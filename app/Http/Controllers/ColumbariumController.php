<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect as Redirect;
use Barryvdh\DomPDF\Facade as PDF;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input as Input;
use Validator;
use App\Settings;
use App\User;
use App\Department;
use App\Notification;

class ColumbariumController extends Controller
{
    const baseUrl = "/columbarium/";
    const viewFolder = "columbarium/";
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $data = array();
        
        $data['order'] = null;

        // General data
        $data["religionOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        $data["raceOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RACE)->orderBy("id")->get();
        $data["sourceOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::SOURCE)->orderBy("id")->get();
        
        $data['item_selection'] = array();
        
        $order = \App\ColumbariumOrders::where("user_id",$user->id)->where("is_draft","1")->first();
     
        if (!$order){
            $order = new \App\ColumbariumOrders();
            $order->is_draft = 1;
            $order->user_id = $user->id;
            $order->save();
        }        
        $data['order'] = $order;
        
        $data['users'] = \App\User::all();
        $data['user'] = $user;
        $data['session'] = new Session();
        return view(self::viewFolder . 'index', $data);
    }
    
    public function listing(Request $request) {
        $user = Auth::user(); 

        $limit = $request->get("limit",5);
        $offset = ($request->get("p",1) - 1) * $limit;
        $data["forms"] = \App\ColumbariumOrders::where("user_id", $user->id)
                                            ->where("is_draft",0)
                                            ->orderby($request->get("sort","created_at"), $request->get("ord","desc"))
                                            ->get();
        
        
        
        return view(self::viewFolder . 'listing', $data);
    }
    
    public function view($id , Request $request)
    {
        // General data
        $data["religionOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        $data["raceOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RACE)->orderBy("id")->get();
        $data["sourceOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::SOURCE)->orderBy("id")->get();
        
        $data['item_selection'] = array();
        $data['order'] = \App\ColumbariumOrders::find($id);
        if ($data['order']){
            $data['item_selection'] = json_decode($data['order']->item_selection, true);
        }
        
        
        if (!$data['order']){
            return "Order not found";
        }
        
        $data['users'] = \App\User::all();
        $data['user'] = Auth::user();
        $data['session'] = new Session();
        return view(self::viewFolder . 'index', $data);
    }
    
    public function getFA(Request $request){
       
       $results = \App\FuneralArrangements::where('generated_code','like','%'.$request->get('term').'%')->orderby('generated_code')->get()->toArray();
       $arrResponse = array();
       foreach ($results as $key => $result){
           foreach($result as $propName => $propValue){
               $arrResponse[$key][$propName] = $propValue;
           }
           $acOrder = \App\AshCollectionForms::where("funeral_arrangement_id", $result["id"])->first();
           if ($acOrder){
               $arrResponse[$key]["type_of_install"] = $acOrder->type_of_install;
               $arrResponse[$key]["niche_location"] = $acOrder->niche_location;
               $arrResponse[$key]["slab_install"] = $acOrder->slab_install;
               $arrResponse[$key]["meet_family"] = $acOrder->meet_family;
               $arrResponse[$key]["photo_install"] = $acOrder->photo_install;
           }
       }
       return response()->json($arrResponse);
    }
    
    public function saveForm(Request $request){
        
        $user = Auth::user();
        $errors = 0;
        $msg = array();        
        
        if( $request->get("id") ){
            $order = \App\ColumbariumOrders::find($request->get("id"));
        }

        if (!$request->ajax()){

            if (!$order->order_nr){            
                $notification_details = "new";
                $notification_action = "new_columbarium";
            }
            else{
                $notification_details = "update";
                $notification_action = "update_columbarium";
            }       
            
            $notificationReceiversSetting = Settings::where(['name' => Settings::KEY_COLUMBARIUM_NOTIFICATION_INDIVIDUALS])->first();
            $notificationDepartmentsSetting = Settings::where(['name' => Settings::KEY_COLUMBARIUM_NOTIFICATION_DEPARTMENTS])->first();
            $notificationReceiversFromIndividuals = User::whereIn('id', $notificationReceiversSetting->getValueArray())->get();
            $notificationReceiversFromDepartments = User::whereIn('department_id', $notificationDepartmentsSetting->getValueArray())->get();

            $notificationReceivers = [];

            foreach ($notificationReceiversFromIndividuals as $user) {
                $notificationReceivers[$user->id] = $user;
            }
            foreach ($notificationReceiversFromDepartments as $user) {
                $notificationReceivers[$user->id] = $user;
            }

            foreach ($notificationReceivers as $user) {
                $notification = new Notification();
                $notification->action = $notification_action;
                $notification->page = "/columbarium";
                $notification->section = "Columbarium";
                $notification->details = $notification_details;
                $notification->link = "/columbarium/view/".$order->id;
                $notification->creator_id = Auth::User()->id;
                $notification->receiver_id = $user->id;
                $notification->receiver_type = 'user';
                $notification->title = $notification->getTitle();
                $notification->save();
            }
            
            
            
            
            if (!$order->order_nr){
                $order->is_draft = 0;
                $order->order_nr = \App\ColumbariumOrders::getNextNumber();
            }
        }
        
        
        
        // SAVE DATA
        $columns = \Schema::getColumnListing("columbarium_orders");
        $info2save = $request->all();
        foreach( $info2save as $key => $value ){
            if (in_array($key, $columns) && !in_array($key, array("files","created_at","order_nr","is_draft","funeral_arrangement_id"))){
                $order->{$key} = $value;
            }
        }
        
        $order->funeral_arrangement_id = $request->get("fa_id");
        
        //SIGNATURES      
        if ($request->get("signature1")){
            $sign1 = ($request->get("signature1"))?$request->get("signature1"):$request->get("signature_image_1");
            $order->signatures = json_encode(array( 1 => $sign1));
            $order->signature_date = date("Y-m-d", strtotime(str_replace("/","-",$request->get("date_signature_1")))) ;
        }
        
        if ($info2save["created_at"]){
            $order->created_at = date("Y-m-d H:i:s", strtotime(str_replace("/","-", $info2save["created_at"])));
        }
        
        $arrItems["item_name"] = $request->get("item_name",array());
        $arrItems["selection"] = $request->get("selection",array());
        $arrItems["comments"] = $request->get("comments",array());
        $arrItems["amount"] = $request->get("amount",array());
        $arrItems["subtotal"] = $request->get("subtotal",0);
        $arrItems["gst"] = $request->get("gst",0);
        $arrItems["total_amount"] = $request->get("total_amount",0);
        $arrItems["deposit"] = $request->get("deposit",0);
        $arrItems["balance_payable"] = $request->get("balance_payable",0);
        
        
        $order->item_selection              = json_encode($arrItems);
        $order->save();
        
        
        // SAVE FILE
        $files = null;
        $order_files = array();
        if ($request->hasFile('files')){
            $files = Input::file('files');
            foreach($files as $file){
                if ($file){
                    $destinationPath = public_path()."/uploads/columbarium";

                    if (!is_dir($destinationPath)){
                        mkdir($destinationPath);
                    } 

                    $destinationPath = public_path()."/uploads/columbarium/".$order->order_nr;

                    if (!is_dir($destinationPath)){
                        mkdir($destinationPath);
                    }
                    
                    $rules = array('file' => 'required');
                    $validator = Validator::make(array('file'=> $file), $rules);
                    if($validator->passes()){
                        $data = implode("", file($file->getPathName()));
                        $gzdata = gzencode($data, 9);
                        $fp = fopen($destinationPath."/".$file->getClientOriginalName().".gz", "w");
                        fwrite($fp, $gzdata);
                        fclose($fp);

                        $order_files[] = "columbarium/".$order->order_nr."/".$file->getClientOriginalName().".gz";
                    }
                    if (!is_file($destinationPath."/".$file->getClientOriginalName().".gz")){
                        $errors++;
                        $msg[] = "Error saving file";
                    }
                }
            }
        }

        $order->files = json_encode($order_files);
        if ($order->save()){
            $msg[] = "Information saved";
        }     
        
//        For point 9 
        
             $groupItems = explode(",", $request->get('group_items'));

             foreach($groupItems as $itemId){

                $packItem = \App\SettingsGroupedItems::find(str_replace(array("w","s"),"",$itemId));
                
                if ($packItem){

                    $product = \App\Products::find($packItem->selection_item_id);
                    if (strpos($itemId, "w")){
                        $product->warehouse -= 1;
                        $product->save();
                       
                    }
                    else if(strpos($itemId, "s")){
                        $product->store_room -= 1;
                        $product->save();
                    }
                    else{
                        $msg[] = "Stock too low for {$product->item} . ";
                        $errors++;
                    }
                }
            }
//        end
        
        // MAIL
        if ($request->get("bttn_clicked") == "submit_email_bttn" || $request->get("bttn_clicked") == "submit_other_email_bttn"){    
            if ($request->get("bttn_clicked") == "submit_email_bttn"){
                $found_email = ($request->get("confirmed_by_email") != "")?$request->get("confirmed_by_email"):$request->get("received_by_email");
            }
            else{
                $found_email = $request->get("new_email");
            }

            $email = filter_var($found_email, FILTER_VALIDATE_EMAIL);
            
            if ($email){
                $tmp_pdf = resource_path().'/columbarium_order_'.$order->id.'.pdf';
                
                
                $data = array();
                // General data
                $data["religionOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RELIGION)->orderBy("id")->get();
                $data["raceOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RACE)->orderBy("id")->get();
                $data["sourceOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::SOURCE)->orderBy("id")->get();

                $data['item_selection'] = json_decode($order->item_selection, true);
                $data['order'] = $order;

                $data['users'] = \App\User::all();
                $data['user'] = Auth::user();              
                $pdf = PDF::loadView( self::viewFolder .'pdf', $data);
                $pdf->setPaper('a4', 'portrait')->setWarnings(false)->save($tmp_pdf);

                Mail::send('emails.new_columbarium_order', [], function($message) use ($email, $tmp_pdf){
                    $message->to( $email )
                            ->subject('Columbarium Order')
                            ->attach($tmp_pdf, array('mime' => 'application/pdf')
                            );
                });
                unlink($tmp_pdf);

                if(count(Mail::failures()) > 0){
                    $msg[] = "Error sending mail.";
                    $errors++;
                }
                else{
                    $msg[] = "Mail to $email sent OK.";
                }
            }
            else{
                $msg[] = "Email not valid ($found_email).";
                $errors++;
            }
        }
        
        /*$session = new Session();
        $session->set("co_msg", $msg);
        $session->set("co_errors", $errors);
        if ($request->get("bttn_clicked") == "submit_print_bttn"){
            $session->set("co_redirect_print", '/columbarium/genpdf/'.$order->id );
        }
        return Redirect::to('/columbarium/?id='.$order->id);*/
        if ($request->ajax())
        {
            return response()->json([
                'msg' => implode("<br />",$msg),
                'errors' => $errors
            ]);
        }
        else{
            $session = new Session();
            $session->set("co_msg", $msg);
            $session->set("co_errors", $errors);
            if ($request->get("bttn_clicked") == "submit_print_bttn"){
                $session->set("co_open_pdf", 1);
            }
            return Redirect::to( self::baseUrl . 'view/'.$order->id);
        }
    }
    
    public function deleteCurrentDraft(){
        $user = Auth::user();
        $drafts = \App\ColumbariumOrders::where("user_id",$user->id)->where("is_draft","1")->get();
        foreach ($drafts as $draft){
            $draft->delete();
        }
        return 1;
    }
    
    public function generatePdf( $id ){

            $user = Auth::user(); 
  
            $data["order"] = \App\ColumbariumOrders::find($id);   
            $data['item_selection'] = array();
            if ($data["order"]){
                $data['item_selection'] = json_decode($data['order']->item_selection, true);
            }
        
            
             // General data
            $data["religionOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RELIGION)->orderBy("id")->get();
            $data["raceOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RACE)->orderBy("id")->get();
            $data["sourceOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::SOURCE)->orderBy("id")->get();
            
            $pdf = PDF::loadView('columbarium/pdf', $data); 
            return $pdf->stream();

    }
    
    public function searchDeceased(Request $request){
       
       $results = \App\Shifting::where('deceased_name','like','%'.$request->get('term').'%')->orderby('id','desc')->get()->toArray();
       $arrResponse = array();
       foreach ($results as $key => $result){
           foreach($result as $propName => $propValue){
               $arrResponse[$key][$propName] = $propValue;
           }
       }
       return response()->json($arrResponse);
    }
    
    public function getStockInfo(Request $request){
        
        $session = new Session();
       
        $group_data=array();

        $selected_item = explode(",", $request->get("selected_item"));
        
        if($selected_item[0] ==''){
            unset($selected_item[0]);
        }
        $data['group_items'] = \App\SettingsGroupedItems::whereIn("id",$selected_item)->get(); ///get data for selected_items.
        
         foreach($data['group_items']  as $get_datas){
            
          
            $product = \App\Products::where( "id",$get_datas->selection_item_id )->where("is_deleted",0)->first();
            $group_data[$get_datas->id] = array("w"=>0,"s"=>0);	
            if ($product->warehouse > 0 && $product->store_room < 0){
			
                $group_data[$get_datas->id]["w"] = $product->warehouse;
//                $group_data[$get_datas->id]["s"] = $product->store_room;
            }else if($product->warehouse < 0 && $product->store_room > 0){
                $group_data[$get_datas->id]["s"] = $product->store_room;
            }else if($product->warehouse > 0 && $product->store_room > 0){
                $group_data[$get_datas->id]["w"] = $product->warehouse;
                $group_data[$get_datas->id]["s"] = $product->store_room;
            }else{
                die("Sorry ! You selected packages or items which doesn't have in inventory.<br>Please select again !");
            }
        }
        
        if (!empty($group_data)){
            $data["list"]['group_items'] = $group_data;
            return view('columbarium/stock_info', $data);
        }
        else{
            return "";
        }
    }
}
