<?php

namespace App\Http\Controllers;

use App\StockHistory;
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

class GemstoneController extends Controller
{
    const baseUrl = "/gemstone/";
    const viewFolder = "gemstone/";
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
        
        $order = \App\GemstoneOrders::where("user_id",$user->id)->where("is_draft","1")->first();
        $data['fa'] = \App\GemstoneOrders::where("user_id",$user->id)->where("is_draft","1")->orderBy("id")->get();
        if (!$order){
            $order = new \App\GemstoneOrders();
            $order->is_draft = 1;
            $order->user_id = $user->id;
            $order->save();
        }        
        $data['order'] = $order;
        $data['order_items'] = array();
        $data["religionOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        $data['users'] = \App\User::all();
        $data['user'] = $user;
        $data["products"] = \App\Products::where("category","Gemstone")->orderby("item")->get();
        $data['terms_conditions'] = Settings::where('name', Settings::KEY_GEMSTONE_TERMS_CONDITIONS)->first()->value;
        $data['session'] = new Session();
        return view( self::viewFolder . 'index', $data);
    }
    
    public function listing(Request $request) {
        $user = Auth::user(); 
        
        $limit = $request->get("limit",5);
        $offset = ($request->get("p",1) - 1) * $limit;
        $data["forms"] = \App\GemstoneOrders::where("user_id", $user->id)
                                            ->where("is_draft",0)
                                            ->orderby($request->get("sort","created_at"), $request->get("ord","desc"))
                                            ->get();
        
                              
        
        return view( self::viewFolder . 'listing', $data);
    }
    
    public function view($id , Request $request)
    {
        $data = array();
        $user = Auth::user();
        $data['order'] = \App\GemstoneOrders::find($id);
        $data['fa'] = \App\GemstoneOrders::where("user_id",$user->id)->where("is_draft","1")->orderBy("id")->get();
        if (!$data['order']){
            return "Order not found";
        }
        $data["order_items"] = json_decode($data["order"]->order_items, true);
        
        $data['users'] = \App\User::all();
        $data['user'] = Auth::user();
		$data["religionOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        $data["products"] = \App\Products::orderby("item")->get();
        $data['terms_conditions'] = Settings::where('name', Settings::KEY_GEMSTONE_TERMS_CONDITIONS)->first()->value;
        $data['session'] = new Session();
        return view( self::viewFolder . 'index', $data);
    }
    

    
    public function saveForm(Request $request){
        
        $user = Auth::user();
        $errors = 0;
        $msg = array();
        
        if( $request->get("id") ){
            $order = \App\GemstoneOrders::find($request->get("id"));
        }
        
        if (!$request->ajax()){
            /*$notification = new \App\Notification();
            $notification->title = "New Gemstone form created by ".$user->name;

            $notification->page = "/gemstone";
            $notification->section = "Gemstone";*/

            if (!$order->order_nr){            
                $notification_details = "new";
                $notification_action = "new_gemstone";
            }
            else{
                $notification_details = "update";
                $notification_action = "update_gemstone";
            }       
            /*$notification->link = "/gemstone/view/".$order->id;
            $notification->creator_id = $user->id;
            $notification->created_at = date("Y-m-d H:i:s");
            $notification->updated_at = date("Y-m-d H:i:s");

            $notification->save();*/
            
            
            $notificationReceiversSetting = Settings::where(['name' => Settings::KEY_GEMSTONE_NOTIFICATION_INDIVIDUALS])->first();
            $notificationDepartmentsSetting = Settings::where(['name' => Settings::KEY_GEMSTONE_NOTIFICATION_DEPARTMENTS])->first();
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
                $notification->page = "/gemstone";
                $notification->section = "Gemstone";
                $notification->details = $notification_details;
                $notification->link = "/gemstone/view/".$order->id;
                $notification->creator_id = Auth::User()->id;
                $notification->receiver_id = $user->id;
                $notification->receiver_type = 'user';
                $notification->title = $notification->getTitle();
                $notification->save();
            }
            
            
            
            if (!$order->order_nr){
                $order->is_draft = 0;
                $order->order_nr = \App\GemstoneOrders::getNextNumber();
            }
        }

        
        // SAVE DATA
        $columns = \Schema::getColumnListing("gemstone_orders");
        $info2save = $request->all();
        foreach( $info2save as $key => $value ){
            if (in_array($key, $columns) && !in_array($key, array("created_at","order_nr","is_draft","funeral_arrangement_id"))){
                $order->{$key} = $value;
            }
        }

        //SIGNATURES
        if ($request->get("signature1") || $request->get("signature2")){
            $sign1 = ($request->get("signature1"))?$request->get("signature1"):$request->get("signature_image_1");
            $sign2 = ($request->get("signature1"))?$request->get("signature2"):$request->get("signature_image_2");
            $order->signatures = json_encode(array( 1 => $sign1, 2 => $sign2));
            $order->signature_date = date("Y-m-d", strtotime(str_replace("/","-",$request->get("date_signature_1")))) ;
        }
        
        $order->funeral_arrangement_id	 = $request->get("fa_id");
        
        $arrItems["deceased_name"] = $request->get("deceased_name",array());
        $arrItems["product"] = $request->get("product",array());
        $arrItems["weight_ashes"] = $request->get("weight_ashes",array());
        $arrItems["price"] = $request->get("price",array());
        $arrItems["quantity"] = $request->get("quantity",array());
        $arrItems["amount"] = $request->get("amount",array());
        $arrItems["subtotal"] = $request->get("subtotal",0);
        $arrItems["gst"] = $request->get("gst",0);
        $arrItems["total_amount"] = $request->get("total_amount",0);
        
        
        $order->order_items              = json_encode($arrItems);
        
        if ($order->save()){
            $msg[] = "Information saved";

            //remove Inventory
            for($i=0;$i<count($arrItems["product"]); $i++){
                $product = \App\Products::where('item', $arrItems["product"][$i])->first();
                $history = StockHistory::where('sales_order', $order->order_nr)->where('product_id', $product->id)->first();
                if(!$history || $history->product_id != $product->id) {
                    $product->store_room -= $arrItems["quantity"][$i];
                    $product->save();

                    // Inventory HISTORY
                    $new_history = new \App\StockHistory();
                    $new_history->product_id = $product->id;
                    $new_history->behavior = "purchase";
                    $new_history->user_id = $user->id;
                    $new_history->store_room = -$arrItems["quantity"][$i];
                    $new_history->remarks = "purchased";
                    $new_history->editable_date_modif = date('Y-m-d H:i:s');
                    $new_history->type = "sales";
                    $new_history->balance_w = $product->warehouse;
                    $new_history->balance_s = $product->store_room;
                    $new_history->sales_order = $order->order_nr;
                    $new_history->save();
                }
            }

        }  
        
 
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
                $tmp_pdf = resource_path().'/gemstone_order'.$order->id.'.pdf';
                
                
                $data['order'] = $order;
                $data["order_items"] = json_decode($data["order"]->order_items, true);

                $data['users'] = \App\User::all();
                $data['user'] = Auth::user();
                $data["products"] = \App\Products::orderby("item")->get();
    
                $pdf = PDF::loadView( self::viewFolder .'pdf', $data);
                $pdf->setPaper('a4', 'portrait')->setWarnings(false)->save($tmp_pdf);

                Mail::send('emails.new_gemstone_order', [], function($message) use ($email, $tmp_pdf){
                    $message->to( $email )
                            ->subject('Gemstone Order')
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

        if ($request->ajax())
        {
            return response()->json([
                'msg' => implode("<br />",$msg),
                'errors' => $errors
            ]);
        }
        else{
            $session = new Session();
            $session->set("go_msg", $msg);
            $session->set("go_errors", $errors);
            if ($request->get("bttn_clicked") == "submit_print_bttn"){
                $session->set("go_open_pdf", 1);
            }
            return Redirect::to( self::baseUrl . 'view/'.$order->id);
        }
        
        
        
        
        //return response()->json(array("id" => $order->id));
    }
    
    public function deleteCurrentDraft(){
        $user = Auth::user();
        $drafts = \App\GemstoneOrders::where("user_id",$user->id)->where("is_draft","1")->get();
        foreach ($drafts as $draft){
            $draft->delete();
        }
        return 1;
    }
    
    public function generatePdf( $id ){

            $user = Auth::user(); 
  
            $data["order"] = \App\GemstoneOrders::find($id);   
            $data["order_items"] = json_decode($data["order"]->order_items, true);
            
            $pdf = PDF::loadView('gemstone/pdf', $data); 
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
     
    public function getFA(Request $request){
       
       $results = \App\FuneralArrangements::where('generated_code','like','%'.$request->get('term').'%')->orderby('generated_code')->get()->toArray();
       $arrResponse = array();
       foreach ($results as $key => $result){
           foreach($result as $propName => $propValue){
               $arrResponse[$key][$propName] = $propValue;
           }
       }
       return response()->json($arrResponse);
    }
}
