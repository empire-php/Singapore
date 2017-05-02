<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\SccCareOrders;
use App\SelectOptionsValues;
use App\SelectOptionsCategories;
use App\SettingsGroupedItems;
use App\Products;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Mail;


class CareOrderController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }
    
    public function indexBuddhist(Request $request){
        
        $data = array();
        $data["type"] = "buddhist";
        $data = array_merge($data, $this->getGeneralIndexData($data["type"], $request));
      //  var_dump($data);exit;
        return view('scc_care_order/index', $data);
    }
    
    public function indexChristian(Request $request){
        
        $data = array();
        $data["type"] = "christian";
        $data = array_merge($data, $this->getGeneralIndexData($data["type"], $request));
        
        return view('scc_care_order/index', $data);
    }
    
    public function indexTidbits(Request $request){
        
        $data = array();
        $data["type"] = "tidbits";
        $data = array_merge($data, $this->getGeneralIndexData($data["type"], $request));
        
        return view('scc_care_order/index', $data);
    }
    
    public function indexChanting(Request $request){
        
        $data = array();
        $data["type"] = "chanting";
        $data = array_merge($data, $this->getGeneralIndexData($data["type"], $request));
        
        return view('scc_care_order/index', $data);
    }
    public function indexTentage(Request $request){
        
        $data = array();
        $data["type"] = "tentage";
        $data = array_merge($data, $this->getGeneralIndexData($data["type"], $request));
        
        return view('scc_care_order/index', $data);
    }
    
    private function getGeneralIndexData($type, $request){
        $user = Auth::user(); 
        $data = array();
        
        $data["prefix"] = "";
        $data["page_title"] = SccCareOrders::getName($type, "page_title");
        $object = SccCareOrders::where("is_draft",1)->where("created_by",$user->id)->where("care_type",$type)->first();
        if (!$object){
            $object = new SccCareOrders();
            $object->created_by = $user->id;
            $object->is_draft = 1;
            $object->care_type = $type;
            $object->save();
        }
        $data["object"] = $object;
        $data["purchased_items"] = json_decode($object->products, true);
        $data["qty_dates"] = json_decode($object->qty_dates, true);
        if ($data["qty_dates"]){
            $data["extra_q_td"] = count($data["qty_dates"]);
        }
        else{
            $data["extra_q_td"] = 0;
        }
        
        // General data
        $data["religionOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        $data["raceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RACE)->orderBy("id")->get();
        $data["sourceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::SOURCE)->orderBy("id")->get();
        
        $elem = "";
        switch ($type){
            case "buddhist":
                $elem = "scc_buddhist";
                $data["prefix"] = "WB";
            break;
            
            case "christian":
                $elem = "scc_christian";
                $data["prefix"] = "WC";
            break;
        
            case "tidbits":
                $elem = "scc_tidbits";
                $data["prefix"] = "WD";
            break;
        
            case "chanting":
                $elem = "scc_chanting";
            break;
        
            case "tentage":
                $elem = "scc_tentage";
            break;
        }
        
        $data["item_categories"] = SettingsGroupedItems::select("id","group_name","unit_price")->where("item_type", $elem )->where("is_deleted",0)->where("group_name","!=","")->distinct()->orderBy("id")->get()->toArray();
        
        $allItems = SettingsGroupedItems::where("item_type", $elem )->whereNotNull("group_name")->where("is_deleted",0)->get()->toArray();
        $items = array();
        foreach($allItems as $line){
            $items[$line["group_name"]][$line["selection_category"]][] = $line;
        }

        $data["items"] = $items;
        $products = Products::where("status",1)->get();
        $arrProducts = array();
        foreach($products as $product){
            $arrProducts[$product->id] = $product;
        }
        $data["products"] = $arrProducts;
        
        $res = SettingsGroupedItems::where("item_type", $elem )->where("is_deleted",0)->where("group_name",null)->orderBy("id")->first();
        $data["pdf_item"] = ($res)?$res->toArray():array();
        
        
        return $data;
    }
    
    public function view($id){
        
        $data = array();
        $data["session"] = $session = new Session();
                
        $object_data = $this->getGeneralViewData($id);
        if ($object_data){
            $data = array_merge($data, $object_data);
        }
        else{
            return Redirect::to('/');
        }
        
        return view('scc_care_order/index', $data);
    }
    
    
    private function getGeneralViewData($id){
        $user = Auth::user(); 
        $data = array();
        $session = new Session();
        
        $object = SccCareOrders::find($id);
        
        if (!$object){
            return false;
        }
        $data["prefix"] = "";
        
        $data["type"] = $object->care_type;
        $data["page_title"] = SccCareOrders::getName($object->care_type, "page_title");

        $data["object"] = $object;
        $data["purchased_items"] = json_decode($object->products, true);
        
        $data["qty_dates"] = json_decode($object->qty_dates, true);
        if ($data["qty_dates"]){
            $data["extra_q_td"] = count($data["qty_dates"]);
        }
        else{
            $data["extra_q_td"] = 0;
        }

        // General data
        $data["religionOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        $data["raceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RACE)->orderBy("id")->get();
        $data["sourceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::SOURCE)->orderBy("id")->get();
        
        $elem = "";
        switch ($object->care_type){
            case "buddhist":
                $elem = "scc_buddhist";
                $data["prefix"] = "WB";
            break;
            
            case "christian":
                $elem = "scc_christian";
                $data["prefix"] = "WC";
            break;
        
            case "tidbits":
                $elem = "tidbits";
                $data["prefix"] = "WD";
            break;
        
            case "chanting":
                $elem = "scc_chanting";
            break;
        
            case "tentage":
                $elem = "scc_tentage";
            break;
        }
        
       // for point 2.2 
        $data["item_categories"] = SettingsGroupedItems::select("group_name","id","unit_price")->where("item_type", $elem )->where("is_deleted",0)->where("group_name","!=","")->distinct()->orderBy("group_name")->get()->toArray();
        
        $allItems = SettingsGroupedItems::where("item_type", $elem )->whereNotNull("group_name")->where("is_deleted",0)->get()->toArray();
        $items = array();
        foreach($allItems as $line){
            $items[$line["group_name"]][$line["selection_category"]][] = $line;
        }

        $data["items"] = $items;
        $products = Products::where("status",1)->get();
        $arrProducts = array();
        foreach($products as $product){
            $arrProducts[$product->id] = $product;
        }
        $data["products"] = $arrProducts;
        
        $res = SettingsGroupedItems::where("item_type", $elem )->where("is_deleted",0)->where("group_name",null)->orderBy("id")->first();
        $data["pdf_item"] = ($res)?$res->toArray():array();
        
        
        return $data;
    }
    

    public function save(Request $request){
        //var_dump($request); exit();
        $bttn_clicked = $request->get("bttn_clicked"); // only in step 4
        $errors = 0;
        $msg = array();
        
        $session = new Session();
        $user = Auth::user(); 
        $order = SccCareOrders::find($request->get("order_id"));

        // SAVE DATA
        $columns = \Schema::getColumnListing("scc_care_orders");
        $info2save = $request->all();

        foreach( $info2save as $key => $value ){
            if (in_array($key, $columns) && !in_array($key, array("id","is_draft","cortage_leave_date","cortage_leaving_time","signature_date_1","signature_date_2","signature_date_3"))){
                if ($value == "users_ids"){
                    $order->{$key} = implode(",",$value);
                }
                else{
                    $order->{$key} = $value;
                    if (!empty($info2save["dialect"])){
                        $result = SelectOptionsValues::where('name','like','%'.$info2save["dialect"].'%')->where('select_options_category_id', SelectOptionsCategories::DIALECTS )->first();
                        if (!$result){
                            $d = new SelectOptionsValues();
                            $d->name = $info2save["dialect"];
                            $d->select_options_category_id = SelectOptionsCategories::DIALECTS;
                            $d->save();
                        }
                    }
                }
            }
        }

        $order->funeral_arrangement_id = $info2save["fa_id"];
        if ($info2save["cortage_leave_date"])
            $order->cortage_leave_date = date("Y-m-d", strtotime( str_replace("/", "-", $info2save["cortage_leave_date"])));
        if ($info2save["cortage_leaving_time"])
            $order->cortage_leaving_time = $info2save["cortage_leaving_time"].":00";
        if ($info2save["signature_date_1"])
            $order->signature_date_1       = date("Y-m-d", strtotime( str_replace("/", "-", $info2save["signature_date_1"])));
        if ($info2save["signature_date_2"])
            $order->signature_date_2       = date("Y-m-d", strtotime( str_replace("/", "-", $info2save["signature_date_2"])));
        if ($info2save["signature_date_3"])
            $order->signature_date_3       = date("Y-m-d", strtotime( str_replace("/", "-", $info2save["signature_date_3"])));
        
        $order->qty_dates              = json_encode($info2save["qty_order_date"]);
        
        
        
        
        // PURCHASED ITEMS
        $purchased_items = json_decode($order->products, true);

        unset($purchased_items["new"]);

        $inc = 0;
        for ($i = 0; $i < count($info2save["categories"]); $i++){
            $sel_category = $info2save["categories"][$i];
            
            $row = $info2save["row"][$i];
            $product_selection = (isset($info2save["selection_item_{$sel_category}_{$row}"]))?$info2save["selection_item_{$sel_category}_{$row}"]:"";

            if (!empty($product_selection)){
                //$arrP = explode("_", $product_selection);

                //$product_id = $arrP[0];
                //$qType = $arrP[1];

                $returnQty = (isset($info2save["return_qty"]))?$info2save["return_qty"][$i]:"";
                $totalSold = $info2save["total_sold"][$i];
                $unitPrice = $info2save["unit_price"][$i];
                $amount    = $info2save["amount"][$i];
                $remarks   = $info2save["remarks"][$i];
                $arrQ      = $info2save["qty_order_".$row];
                $totalQ    = array_sum($arrQ);


                $purchased_items["new"][ $inc ]["product_id"] = $inc;
                //$purchased_items["new"][ $inc ]["product_id"] = $product_id;
                $purchased_items["new"][ $inc ]["store_type"] = $product_selection; //$qType
                $purchased_items["new"][ $inc ]["return_qty"] = $returnQty;
                $purchased_items["new"][ $inc ]["total_sold"] = $totalSold;
                $purchased_items["new"][ $inc ]["unit_price"] = $unitPrice;
                $purchased_items["new"][ $inc ]["amount"]     = $amount;
                $purchased_items["new"][ $inc ]["remarks"]    = $remarks;
                $purchased_items["new"][ $inc ]["quantities"] = $arrQ;
                $purchased_items["new"][ $inc ]["category_name"] = $info2save["category_name"][$i];
                $purchased_items["new"][ $inc ]["category_id"] = $sel_category;
                $inc++;
            }
        }


        // SAVE PURCHASED ITEMS
      //  var_dump(json_encode($purchased_items));exit;
        $order->products = json_encode($purchased_items);
 

        if ($bttn_clicked){

            if ($order->is_draft == 1){
                $order->is_draft = 0;  
                $order->order_nr = $order->setNextNumber();

            }
                
                
                $purchased_items = json_decode($order->products, true);
                if (!empty($purchased_items["new"])){
                    foreach ($purchased_items["new"] as $selected_product){
                        $totalQ = array_sum($selected_product["quantities"]);
                        $product = Products::find($selected_product["product_id"]);
                        if ($product){
                            if ($selected_product["store_type"] == "w"){
                                if ($product->warehouse < $totalQ){
                                    $msg[] = "Quantity in warehouse not available for {$product->item}.";
                                    $errors++;
                                }
                                else{
                                    if ($totalQ > 0){
                                        $product->warehouse -= $totalQ;
                                    }
                                    else{
                                        $product->warehouse += -1 * $totalQ;
                                    }
                                    $inc = count($purchased_items);
                                    $purchased_items[ $inc ] = $selected_product;
                                    $purchased_items[ $inc ]["item"] = $product->item;
                                    $inc++;
                                }
                            }
                            else{
                                if ($product->store_room < $totalQ){
                                    $msg[] = "Quantity in storeroom not available for {$product->item}.";
                                    $errors++;
                                }
                                else{
                                    if ($totalQ > 0){
                                        $product->store_room -= $totalQ;
                                    }
                                    else{
                                        $product->store_room += -1 * $totalQ;
                                    }
                                    $inc = count($purchased_items);
                                    $purchased_items[ $inc ] = $selected_product;
                                    $purchased_items[ $inc ]["item"] = $product->item;
                                    $inc++;
                                }
                            }
  
                            $product->save();
                        }
                    }
                }
                // SAVE PURCHASED ITEMS
                unset($purchased_items["new"]);
                $order->products = json_encode($purchased_items);
                

        
            // MAIL
            if ($bttn_clicked == "submit_email_bttn" || $bttn_clicked == "submit_other_email_bttn"){       
                $found_email = $order->first_cp_email;
                if ($bttn_clicked == "submit_other_email_bttn"){
                    $found_email = $request->get("new_email");
                }
                
                $email = filter_var($found_email, FILTER_VALIDATE_EMAIL);
                
                if ($email){
                    $tmp_pdf = storage_path().'/app/pdfs/scc_care_order_'.$order->care_type.'_'.$order->order_nr.'.pdf';
                    
                    $user = Auth::user(); 
                    $data = array();

                    $object = $order;

                    $data["type"] = $object->care_type;
                    $data["page_title"] = SccCareOrders::getName($object->care_type, "page_title");

                    $data["object"] = $object;
                    $data["purchased_items"] = json_decode($object->products, true);

                    $data["qty_dates"] = json_decode($object->qty_dates, true);
                    if ($data["qty_dates"]){
                        $data["extra_q_td"] = count($data["qty_dates"]);
                    }
                    else{
                        $data["extra_q_td"] = 0;
                    }

                    // General data
                    $data["religionOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RELIGION)->orderBy("id")->get();
                    $data["raceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RACE)->orderBy("id")->get();
                    $data["sourceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::SOURCE)->orderBy("id")->get();

                    $elem = "";
                    $data["prefix"] = "";
                    switch ($object->care_type){
                        case "buddhist":
                            $elem = "scc_buddhist";
                            $data["prefix"] = "WB";
                        break;

                        case "christian":
                            $elem = "scc_christian";
                            $data["prefix"] = "WC";
                        break;

                        case "tidbits":
                            $elem = "tidbits";
                            $data["prefix"] = "WD";
                        break;

                        case "chanting":
                            $elem = "scc_chanting";
                        break;

                        case "tentage":
                            $elem = "scc_tentage";
                        break;
                    }


                    $data["item_categories"] = SettingsGroupedItems::select("group_name")->where("item_type", $elem )->where("is_deleted",0)->where("group_name","!=","")->distinct()->orderBy("group_name")->get()->toArray();

                    $allItems = SettingsGroupedItems::where("item_type", $elem )->whereNotNull("group_name")->where("is_deleted",0)->get()->toArray();
                    $items = array();
                    foreach($allItems as $line){
                        $items[$line["group_name"]][$line["selection_category"]][] = $line;
                    }

                    $data["items"] = $items;
                    $products = Products::where("status",1)->get();
                    $arrProducts = array();
                    foreach($products as $product){
                        $arrProducts[$product->id] = $product;
                    }
                    $data["products"] = $arrProducts;

                    $res = SettingsGroupedItems::where("item_type", $elem )->where("is_deleted",0)->where("group_name",null)->orderBy("id")->first();
                    
                    
                    
                    $pdf = PDF::loadView('scc_care_order/pdf', $data);
                    $pdf->setPaper('a4', 'landscape')->setWarnings(false)->save($tmp_pdf);

                    Mail::send('emails.new_scc_care', [], function($message) use ($email, $tmp_pdf){
                        $message->to( $email )
                                ->subject('New SCC Care Order form')
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

        }
        
        // SAVE DATA
        //$order->last_saved_by = $user->id;
        if ($order->save()){
            $msg[] = "Information saved.";
        }
        else{
            $msg[] = "Error saving data.";
            $errors++;
        }
        
        
        
        if ($request->ajax())
        {
            return response()->json([
                'msg' => implode("<br />",$msg),
                'errors' => $errors,
               
            ]);
        }
        else{
                       
            if ($order->id){

                $session = new Session();
                $session->set("scc_".$order->id."_msg", $msg);
                //$session->set("scc_".$object->id."_errors", $errors);
                if ($request->get("bttn_clicked") == "submit_print_bttn"){
                    $session->set("scc_".$order->id."_open_pdf", 1);
                }
                return Redirect::to('/scc/'.$request->get("order_type").'/view/'.$order->id);
            }
            else{
                return Redirect::to('/scc/'.$request->get("order_type"));
            }
        }
    }
    
    public function listing(Request $request){
        
    }
    
    public function deleteCurrentDraft(){
        $user = Auth::user();
        $drafts = SccCareOrders::where("user_id",$user->id)->where("is_draft","1")->get();
        foreach ($drafts as $draft){
            $draft->delete();
        }
        return 1;
    }
    
    public function generatePdf( $id ){

        $user = Auth::user(); 
        $data = array();
        
        $object = SccCareOrders::find($id);
        
        $data["type"] = $object->care_type;
        $data["page_title"] = SccCareOrders::getName($object->care_type, "page_title");

        $data["object"] = $object;
        $data["purchased_items"] = json_decode($object->products, true);
        
        $data["qty_dates"] = json_decode($object->qty_dates, true);
        if ($data["qty_dates"]){
            $data["extra_q_td"] = count($data["qty_dates"]);
        }
        else{
            $data["extra_q_td"] = 0;
        }
        
        // General data
        $data["religionOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        $data["raceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RACE)->orderBy("id")->get();
        $data["sourceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::SOURCE)->orderBy("id")->get();
        
        $elem = "";
        $data["prefix"] = "";
        switch ($object->care_type){
            case "buddhist":
                $elem = "scc_buddhist";
                $data["prefix"] = "WB";
            break;
            
            case "christian":
                $elem = "scc_christian";
                $data["prefix"] = "WC";
            break;
        
            case "tidbits":
                $elem = "tidbits";
                $data["prefix"] = "WD";
            break;
        
            case "chanting":
                $elem = "scc_chanting";
            break;
        
            case "tentage":
                $elem = "scc_tentage";
            break;
        }
        
        
        $data["item_categories"] = SettingsGroupedItems::select("group_name")->where("item_type", $elem )->where("is_deleted",0)->where("group_name","!=","")->distinct()->orderBy("group_name")->get()->toArray();
        
        $allItems = SettingsGroupedItems::where("item_type", $elem )->whereNotNull("group_name")->where("is_deleted",0)->get()->toArray();
        $items = array();
        foreach($allItems as $line){
            $items[$line["group_name"]][$line["selection_category"]][] = $line;
        }

        $data["items"] = $items;
        $products = Products::where("status",1)->get();
        $arrProducts = array();
        foreach($products as $product){
            $arrProducts[$product->id] = $product;
        }
        $data["products"] = $arrProducts;
        
        $res = SettingsGroupedItems::where("item_type", $elem )->where("is_deleted",0)->where("group_name",null)->orderBy("id")->first();


        $pdf = PDF::loadView('scc_care_order/pdf', $data); 
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream();


    }
    
    public function searchDeceasedName(Request $request){
       
       $results = \App\Shifting::where('deceased_name','like','%'.$request->get('term').'%')->orderby('id','desc')->get()->toArray();
       $arrResponse = array();
       foreach ($results as $key => $result){
           foreach($result as $propName => $propValue){
               $arrResponse[$key][$propName] = $propValue;
           }
       }
       return response()->json($arrResponse);
    }
     
    public function searchFA(Request $request){
       
       $results = \App\FuneralArrangements::where('generated_code','like','%'.$request->get('term').'%')->orderby('generated_code')->get()->toArray();
       $arrResponse = array();
       foreach ($results as $key => $result){
           foreach($result as $propName => $propValue){
               $arrResponse[$key][$propName] = $propValue;
           }
       }
       return response()->json($arrResponse);
    }
    
    public function searchNRIC(Request $request){

        $fa1 = \App\FuneralArrangements::select("first_cp_name as name","first_cp_nric as nric","first_cp_email as email")
                  ->where('first_cp_nric','like','%'.$request->get('term').'%');
        $fa2 = \App\FuneralArrangements::select("second_cp_name as name","second_cp_nric as nric","second_cp_email as email")
                  ->where('second_cp_nric','like','%'.$request->get('term').'%');
        $co1 = \App\ColumbariumOrders::selectRaw("first_cp_name as name,first_cp_nric as nric,'' as email")
                  ->where('first_cp_nric','like','%'.$request->get('term').'%');
        $co2 = \App\ColumbariumOrders::selectRaw("second_cp_name as name,second_cp_nric as nric,'' as email")
                  ->where('second_cp_nric','like','%'.$request->get('term').'%');
        $go1 = \App\GemstoneOrders::selectRaw("first_cp_name as name,first_cp_nric as nric,'' as email")
                  ->where('first_cp_nric','like','%'.$request->get('term').'%');
        $go2 = \App\GemstoneOrders::selectRaw("second_cp_name as name,second_cp_nric as nric, '' as email")
                  ->where('second_cp_nric','like','%'.$request->get('term').'%');
        $ac1 = \App\AshCollectionForms::select("confirmed_by_name as name","confirmed_by_nric as nric","confirmed_by_email as email")
                  ->where('confirmed_by_nric','like','%'.$request->get('term').'%');

        $results = \App\AshCollectionForms::select("received_by_name as name","received_by_nric as nric","received_by_email as email")
                  ->where('received_by_nric','like','%'.$request->get('term').'%')
                    ->union($fa1)
                    ->union($fa2)
                    ->union($co1)
                    ->union($co2)
                    ->union($go1)
                    ->union($go2)
                    ->union($ac1)
                    ->distinct()
                    ->get()->toArray();
       return response()->json($results);
    }
    
    
    // For point 2.2
    public function getAllImagesForPopup(Request $request){
        
        $id= $request->get("id");
        
        $result = SettingsGroupedItems::where("id",$id)->get();
    
       
        $details['images'] = explode("|", $result[0]->image);
        $details['group_name'] =$result[0]->group_name;
        $details['unit_price'] =$result[0]->unit_price;
        die(json_encode($details));
    }
}