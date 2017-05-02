<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\PackageItems;
use App\Products;
use App\SettingsGroupedItems;
use App\StockHistory;
use Illuminate\Http\Request;
use App\ChecklistItems;
use App\FuneralArrangements;
use App\SelectOptionsValues;
use App\Shifting;
use App\FARepatriationForms;
use App\User;
use Illuminate\Database\Schema\Builder as Schema;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Redirect as Redirect;
use Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Mail;
use App\Company;
use App\SelectOptionsCategories;
use App\Settings;
use App\Department;
use App\Notification;
use App\Packages;
use App\Parlours;
use App\ParlourOrders;
use App\GemstoneOrders;
class FuneralArrangementController extends Controller
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

    /**
     * Listing for the forms created by the user
     */
    public function index(Request $request) {
        $user = Auth::user(); 
        $data["company_prefix"] = Company::getCurrentCompanyPrefix();
        
        $limit = $request->get("limit",5);
        $offset = ($request->get("p",1) - 1) * $limit;
        $data["forms"] = FuneralArrangements::where("user_id", $user->id)
                                            ->where("is_draft",0)
                                            ->orderby($request->get("sort","created_at"), $request->get("ord","desc"))
                                            //->limit($limit)
                                            //->offset($offset)
                                            ->get();
        return view('funeral_arrangement/listing', $data);
    }
    
    
    
    
    /**
     * Create new Funeral Arrangement
     *
     */
    public function getgemstone(request $request){
        
        $object = FuneralArrangements::where('deceased_name', $request->name)->first();
        return $object;
    }
    public function createFA(Request $request)
    {
        $user = Auth::user(); 
        
        // General data
        $data["religionOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        $data["raceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RACE)->orderBy("id")->get();
        $data["sourceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::SOURCE)->orderBy("id")->get();
        
        $session = new Session();
        
        $companyId = $session->get('company_id');
        if (!$companyId){
            return Redirect::to('/logout');
        }
        
        
     // Draft
     //  if ($session->get("fa_id")){
     //       $draft = FuneralArrangements::find($session->get("fa_id"));
     //  }
        
        if (!isset($draft)){
            $draft = FuneralArrangements::getDraft();
        }
        $data["object"] = $draft;
        
        
        // Generate Number
        $session->set("fa_id", $draft->id);
       
        // Checklist
        $data["checlist_items"] = ChecklistItems::orderBy('position', 'asc')->get();
        $data["last_item_position"] = count($data["checlist_items"]);
              
        // Purchased items
        $arrItems = json_decode($draft->purchased_items, true);
        if (is_array($arrItems)){
            $data = array_merge($data, $arrItems);
        }
        
        $data["users"] = User::all();
        
        $data["saved_checklist"] = json_decode($draft->checklist_data, true);
        $data["step"] = 1;
        
        //  Add function for parlour popup	
		// $data = array();
		 $user = Auth::user();
		 $data["user"] = $user;
         $data["company_prefix"] = Company::getCurrentCompanyPrefix();
		////////////////	
		$completedData=array();
			$preDate = Parlours::where("is_deleted",0)->orderBy("name")->get()->toArray();
			foreach($preDate as $key => $eachData){
				//var_dump($eachData['image']);exit;
				if($eachData['image'] !=""){
					$eachImageName = explode("|",$eachData['image']);
					//for($i=0;$i<count($eachImageName)-1;$i++){
						$completedData[$key]['image'][]=$eachImageName[0];
					//}
				}else{
					$completedData[$key]['image'][]="";
				}
				$completedData[$key]['id'] = $eachData['id'];
				$completedData[$key]['name'] = $eachData['name'];
				$completedData[$key]['capacity'] = $eachData['capacity'];
				$completedData[$key]['unit_price'] = $eachData['unit_price'];
				$completedData[$key]['created_at'] = $eachData['created_at'];
				$completedData[$key]['is_deleted'] = $eachData['is_deleted'];
				$completedData[$key]['updated_at'] = $eachData['updated_at'];
			}
            $data["items"] = $completedData;
            $data["order_nr"] = sprintf("%05d",ParlourOrders::getNextNumber());
        return view('funeral_arrangement/index', $data);
    }
    
    
    public function getObituary(){
        $session = new Session();
        $data = array();
        $fa = FuneralArrangements::find($session->get("fa_id"));
        $arrItems = json_decode($fa->purchased_items, true);
        if (is_array($arrItems)){
            if(isset($arrItems['obituary_arranged_by']))
                $data['obituary_arranged_by'] = $arrItems['obituary_arranged_by'];

            if(isset($arrItems['obituary_followed_up_by']))
                $data['obituary_followed_up_by'] = $arrItems['obituary_followed_up_by'];
        }
        return $data;

    }

    
    public function stepTwo(){
        $session = new Session();
        $fa = FuneralArrangements::find($session->get("fa_id"));
        $data["object"] = $fa;
 
        // Checklist
        $data["checlist_items"] = ChecklistItems::orderBy('position', 'asc')->get();
        $data["last_item_position"] = count($data["checlist_items"]);
        $data["saved_checklist"] = json_decode($fa->checklist_data, true);
        
        // Ala-carte			//	Feb 21
        $ala_carte_items = \App\SettingsGroupedItems::where("is_deleted",0)->where("item_type","ala_carte")->get()->toArray();
        $items = array();
        if (is_array($ala_carte_items)){
            foreach($ala_carte_items as $item){
                if (!isset($items[$item["group_name"]][$item["selection_category"]])){
                    $items[$item["group_name"]][$item["selection_category"]]= array();
                }
                $items[$item["group_name"]][$item["selection_category"]][] = $item;
            }
        }

        $data["items"] = $items;
        $data["category_names"] = Settings::FA_ALA_CARTE_CATEGORY_NAMES;
      
        $arrItems = json_decode($fa->purchased_items, true);
        if (is_array($arrItems)){
            $data = array_merge($data, $arrItems);
        }
        
        $data["package_categories"] = Packages::select("category")->where("is_deleted", 0)->distinct()->orderby("name")->get();
      
        $data["selected_package_items"] = explode(",",str_replace(array("w","s"), "",$fa->package_items));
		
        $data["selected_package"] = "";
        if (!empty($data["selected_package_items"])){
            $pack = \App\PackageItems::find($data["selected_package_items"][0]);
            if ($pack){
                $data["selected_package"] = $pack->fa_package_id;
            }
        }
    //  var_dump( $data  );exit;
        // USERS
        $data['users'] = User::all();
        $user = Auth::user(); 
        $data['user'] = $user;
        
        $data["step"] = 2;
        return view('funeral_arrangement/index', $data);
    }
    
    
    public function stepThree(){
        $session = new Session();
        $fa = FuneralArrangements::find($session->get("fa_id"));
        $data["object"] = $fa;
 
        // Checklist -----------------------
        $data["checlist_items"] = ChecklistItems::orderBy('position', 'asc')->get();
        $data["last_item_position"] = count($data["checlist_items"]);
        $data["saved_checklist"] = json_decode($fa->checklist_data, true);
        
        // Ala-carte ---------------------------
        $ala_carte_items = \App\SettingsGroupedItems::where("is_deleted",0)->where("item_type","ala_carte")->get()->toArray();
        $items = array();
        if (is_array($ala_carte_items)){
            foreach($ala_carte_items as $item){
                if (!isset($items[$item["group_name"]][$item["selection_category"]])){
                    $items[$item["group_name"]][$item["selection_category"]]= array();
                }
                $items[$item["group_name"]][$item["selection_category"]][] = $item;
            }
        }
        $data["items"] = $items;
        $data["category_names"] = Settings::FA_ALA_CARTE_CATEGORY_NAMES;
    
        // FA individual sale -----------------------------
        $fa_sales_items = \App\SettingsGroupedItems::where("is_deleted",0)->where("item_type","individual_sales")->get()->toArray();
        $items = array();
        if (is_array($fa_sales_items)){
            foreach($fa_sales_items as $item){
                if (!isset($items[$item["group_name"]][$item["selection_category"]])){
                    $items[$item["group_name"]][$item["selection_category"]]= array();
                }
                $items[$item["group_name"]][$item["selection_category"]][] = $item;
            }
        }
  
        $data["sales_items"] = $items;
        $namesObj = Settings::where("name", Settings::KEY_FA_SALES_PACKAGES)->first();
        if ($namesObj){
            $data["sales_category_names"] = ($namesObj->value)?json_decode($namesObj->value, true):array();
        }
        
        
        $arrItems = json_decode($fa->purchased_items, true);
        if (is_array($arrItems)){
            $data = array_merge($data, $arrItems);
        }
        
        $settings_discount = Settings::where("name", Settings::KEY_FA_DISCOUNT)->first();
        $data["discounts"] = json_decode($settings_discount->value);

        $data["selected_package_items"] = explode(",",str_replace(array("w","s"), "",$fa->package_items));
        $data["selected_package"] = new \App\Packages();
        if (!empty($data["selected_package_items"])){
            $pack = \App\PackageItems::find($data["selected_package_items"][0]);
            if ($pack){
                $data["selected_package"] = \App\Packages::find($pack->fa_package_id);
            }
        }

        
        // USERS
        $data['users'] = User::all();
        $user = Auth::user(); 
        $data['user'] = $user;
        
        $data["step"] = 3;
        return view('funeral_arrangement/index', $data);
    }
    
    
    public function stepFour(Request $request){
        $session = new Session();
        $fa = FuneralArrangements::find($session->get("fa_id"));
        $data["object"] = $fa;
		
        // Checklist
        $data["checlist_items"] = ChecklistItems::orderBy('position', 'asc')->get();
        $data["last_item_position"] = count($data["checlist_items"]);
        $data["saved_checklist"] = json_decode($fa->checklist_data, true);
		$data['coffin_price'] = $session->get('coffin_price');
        	//var_dump($session->get('coffin_price'));exit;	
        
        $data["step"] = 4;
        return view('funeral_arrangement/index', $data);
    }
    

    
    /**
     * 
     * View funeral arrangement form
     */
    
    public function view($id, Request $request)
    {
        $user = Auth::user(); 
        
        // General data
        $data["religionOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        $data["raceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RACE)->orderBy("id")->get();
        $data["sourceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::SOURCE)->orderBy("id")->get();

        $object = FuneralArrangements::find($id);   
        if ($object){
            $data["object"] = $object;
            $data['users'] = User::all();

 
            // Checklist -----------------------
            $data["checlist_items"] = ChecklistItems::orderBy('position', 'asc')->get();
            $data["last_item_position"] = count($data["checlist_items"]);
            $data["saved_checklist"] = json_decode($object->checklist_data, true);

            // Ala-carte ---------------------------
            $ala_carte_items = \App\SettingsGroupedItems::where("is_deleted",0)->where("item_type","ala_carte")->get()->toArray();
            $items = array();
            if (is_array($ala_carte_items)){
                foreach($ala_carte_items as $item){
                    if (!isset($items[$item["group_name"]][$item["selection_category"]])){
                        $items[$item["group_name"]][$item["selection_category"]]= array();
                    }
                    $items[$item["group_name"]][$item["selection_category"]][] = $item;
                }
            }
            $data["items"] = $items;
            $data["category_names"] = Settings::FA_ALA_CARTE_CATEGORY_NAMES;

            // FA individual sale -----------------------------
            $fa_sales_items = \App\SettingsGroupedItems::where("is_deleted",0)->where("item_type","individual_sales")->get()->toArray();
            $items = array();
            if (is_array($fa_sales_items)){
                foreach($fa_sales_items as $item){
                    if (!isset($items[$item["group_name"]][$item["selection_category"]])){
                        $items[$item["group_name"]][$item["selection_category"]]= array();
                    }
                    $items[$item["group_name"]][$item["selection_category"]][] = $item;
                }
            }

            $data["sales_items"] = $items;
            $namesObj = Settings::where("name", Settings::KEY_FA_SALES_PACKAGES)->first();
            if ($namesObj){
                $data["sales_category_names"] = ($namesObj->value)?json_decode($namesObj->value, true):array();
            }


            $arrItems = json_decode($object->purchased_items, true);
            if (is_array($arrItems)){
                $data = array_merge($data, $arrItems);
            }
            
            $settings_discount = Settings::where("name", Settings::KEY_FA_DISCOUNT)->first();
            $data["discounts"] = json_decode($settings_discount->value);

            $data["selected_package_items"] = explode(",",str_replace(array("w","s"), "",$object->package_items));
            $data["selected_package"] = new \App\Packages();
            if (!empty($data["selected_package_items"])){
                $pack = \App\PackageItems::find($data["selected_package_items"][0]);
                if ($pack){
                    $data["selected_package"] = \App\Packages::find($pack->fa_package_id);
                }
            }
            
            $data["view_mode"] = 1;
            return view('funeral_arrangement/index', $data);
        }
        else{
            return "Form not found";
        }
    }
    
    
//  Remove auto_check_list function by LinPing

    public function getDeceasedDetails(Request $request ){
        $deceased_name=$request->input('deceased_name');
//        return $deceased_name;
        $result = \App\Shifting::where('deceased_name', $deceased_name)->orderBy('id')->get()->first();
        return $result;
    }

	public function autoSaveChecklist( Request $request ){

        $data = $request->all();
        $arrChecklist = array();

        foreach ($data as $name => $val){
            if ( strpos($name, "remarks") > -1 || strpos($name, "active_item") > -1 ){
                $id = str_replace(array("remarks_","active_item_"), "", $name);
                $arrChecklist[$id][str_replace("_".$id,"",$name)] = $val;
            }
        }
        $checklist = json_encode($arrChecklist);
        $fa = FuneralArrangements::find($request->get("faid"));
        $fa->checklist_data = $checklist;
        $fa->save();

        if ($fa->shifting_id){
            $timelog = \App\EmbalmingTimelog::where("shifting_id", $fa->shifting_id)->first();
            if ( isset($arrChecklist[17]["remarks"]) && !empty($arrChecklist[17]["remarks"])){
                $timelog->items_in_coffin = "Yes";
                $timelog->save();
            }
            else{
                $timelog->items_in_coffin = "";
                $timelog->save();
            }
        }
    }
    
    
    
    
    public function generatePdf( $name, $fa_id ){

        if (in_array($name, array("embalming","declination","loa","fa","fa_repatriation","parlour"))){

            $user = Auth::user();
        
            // General data
            $data["religionOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RELIGION)->orderBy("id")->get();
            $data["raceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RACE)->orderBy("id")->get();
            $data["sourceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::SOURCE)->orderBy("id")->get();

            // Draft
            if ( $name == "fa_repatriation"){
                $data["object"] = $object = FARepatriationForms::find($fa_id);   
                $data["other_purchased_items"] = json_decode($data["object"]->other_purchased_items, true);
            }
            else{
                $data["object"] = $object = FuneralArrangements::find($fa_id);       
            }
            
            // Checklist -----------------------
            $data["checlist_items"] = ChecklistItems::orderBy('position', 'asc')->get();
            $data["last_item_position"] = count($data["checlist_items"]);
            $data["saved_checklist"] = json_decode($object->checklist_data, true);

            if ($name == "fa_repatriation"){
                $far_sales_items = SettingsGroupedItems::where("is_deleted",0)->where("item_type","far")->get()->toArray();
                $items = array();
                if (is_array($far_sales_items)){
                    foreach($far_sales_items as $item){
                        if (!isset($items[$item["group_name"]][$item["selection_category"]])){
                            $items[$item["group_name"]][$item["selection_category"]]= array();
                        }
                        $items[$item["group_name"]][$item["selection_category"]][] = $item;
                    }
                }

                $data["sales_items"] = $items;
            }
            else{
                // Ala-carte ---------------------------
                $ala_carte_items = SettingsGroupedItems::where("is_deleted",0)->where("item_type","ala_carte")->get()->toArray();
                $items = array();
                if (is_array($ala_carte_items)){
                    foreach($ala_carte_items as $item){
                        if (!isset($items[$item["group_name"]][$item["selection_category"]])){
                            $items[$item["group_name"]][$item["selection_category"]]= array();
                        }
                        $items[$item["group_name"]][$item["selection_category"]][] = $item;
                    }
                }
				
                $data["items"] = $items;
                $data["category_names"] = Settings::FA_ALA_CARTE_CATEGORY_NAMES;

                // FA individual sale -----------------------------
                $fa_sales_items = SettingsGroupedItems::where("is_deleted",0)->where("item_type","individual_sales")->get()->toArray();
                $items = array();
                if (is_array($fa_sales_items)){
                    foreach($fa_sales_items as $item){
                        if (!isset($items[$item["group_name"]][$item["selection_category"]])){
                            $items[$item["group_name"]][$item["selection_category"]]= array();
                        }
                        $items[$item["group_name"]][$item["selection_category"]][] = $item;
                    }
                }

                $data["sales_items"] = $items;
                
            }
            $namesObj = Settings::where("name", Settings::KEY_FA_SALES_PACKAGES)->first();
            if ($namesObj){
                $data["sales_category_names"] = ($namesObj->value)?json_decode($namesObj->value, true):array();
            }

            $arrItems = json_decode($object->purchased_items, true);
            if (is_array($arrItems)){
                $data = array_merge($data, $arrItems);
            }
            
            $settings_discount = Settings::where("name", Settings::KEY_FA_DISCOUNT)->first();
            $data["discounts"] = json_decode($settings_discount->value);

            $data["selected_package_items"] = explode(",",str_replace(array("w","s"), "",$object->package_items));
            $data["selected_package"] = new Packages();
            if (!empty($data["selected_package_items"])){
                $pack = PackageItems::find($data["selected_package_items"][0]);
                if ($pack){
                    $data["selected_package"] = Packages::find($pack->fa_package_id);
                }
            }

            $data['users'] = User::all();
            
            $pdf = PDF::loadView('funeral_arrangement/pdfs/'.$name, $data); 
            return $pdf->stream();
        }
        else{
            return "PDF not found";
        }
    }

    public function saveData( Request $request, $doRedirect = true){

        $bttn_clicked = $request->get("bttn_clicked"); // only in step 4
        $errors = 0;
        $msg = array();
          
        $session = new Session();
        $user = Auth::user(); 
        $fa = FuneralArrangements::find($request->get("faid"));
        $session->set('coffin_price',$request->get('coffin_price'));
	
        // SAVE DATA
        $columns = \Schema::getColumnListing("funeral_arrangements");
        $info2save = $request->all();
     
        foreach( $info2save as $key => $value ){
            if (in_array($key, $columns) ){
                if ($value == "other"){
                    $fa->{$key} = $info2save["other_".$key];
                }
                elseif ($value == "users_ids"){
                    $fa->{$key} = implode(",",$value);
                }
                else{
                    $fa->{$key} = $value;
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

 
        //SIGNATURES
        if ($request->get("signature1") ){
            $fa->signatures = json_encode(array( 1 => $request->get("signature1"), 2 => $request->get("signature2")));
            $fa->signature_date = date("Y-m-d", strtotime(str_replace("/","-",$request->get("date_signature_1")))) ;
        }
        
        
        // PURCHASED ITEMS
        $purchased_items = json_decode($fa->purchased_items, true);
        $info2save["step"] = $request->get("step","");
        //return $info2save["parlour_from_date"];
        if ($info2save["step"] == 1 || $request->get("is_view")){
            $parlours = array();
            if (isset($info2save["parlour_name"])){
                $pInc = 0;
                for ($i = 0; $i < count($info2save["parlour_name"]); $i++){
                    if (!empty($info2save["parlour_name"][$i])){
                        $parlours[$pInc]["parlour_id"]   = $info2save["parlour_id"][$i];
                        $parlours[$pInc]["parlour_order_id"]  = $info2save["parlour_order_id"][$i];
                        $parlours[$pInc]["parlour_name"] = $info2save["parlour_name"][$i];
                        $parlours[$pInc]["parlour_unit_price"]  = $info2save["parlour_unit_price"][$i];
                        $parlours[$pInc]["parlour_total_price"]  = $info2save["parlour_total_price"][$i];
                        $parlours[$pInc]["parlour_from_date"] = $info2save["parlour_from_date"][$i];
                        $parlours[$pInc]["parlour_from_time"]   = $info2save["parlour_from_time"][$i];
                        $parlours[$pInc]["parlour_to_date"] = $info2save["parlour_to_date"][$i];
                        $parlours[$pInc]["parlour_to_time"]   = $info2save["parlour_to_time"][$i];

                        //update parlour_order with WSC_no
                        $parlour_order = ParlourOrders::find($parlours[$pInc]["parlour_order_id"]);
                        $parlour_order->funeral_arrangement_id = $fa->id;
                        $parlour_order->save();


                        $pInc++;
                    }
                }
            }
            
            $purchased_items["parlours"] = $parlours;
        }

        //==========Step 2=============
        if ($info2save["step"] == 2 || $request->get("is_view")){
       
            // Ala carte
            $ac = array();
            if (isset($info2save["ac_category"])){
                $pInc = 0;
                for ($i = 0; $i < count($info2save["ac_category"]); $i++){
                    $ac[$info2save["ac_category"][$i]] = array();
                    if (!empty($info2save["ac_selection_item"][$i])){
                        $ac[$info2save["ac_category"][$i]]["selection_item"] = $info2save["ac_selection_item"][$i];
                        $ac[$info2save["ac_category"][$i]]["price"] = $info2save["ac_price"][$i];
                        $ac[$info2save["ac_category"][$i]]["remarks"] = $info2save["ac_remarks"][$i];
                    }
                }
            }
            unset($info2save["ac_category"],$info2save["ac_selection_item"],$info2save["ac_price"],$info2save["ac_remarks"]);
            $purchased_items["ac"] = $ac;


            // Others price
            $others = array();
            if (isset($info2save["others_price"])){

                for ($i = 0; $i < count($info2save["others_price"]); $i++){
                    $others[$i] = array();
                    $others[$i]['title'] = $info2save["others"][$i];
                    $others[$i]['price'] = number_format(floatval($info2save["others_price"][$i]), 2, '.', '');
                    $others[$i]['remarks'] = $info2save["others_remarks"][$i];
                }
            }
            unset($info2save["others"],$info2save["others_price"],$info2save["others_remarks"]);
            $purchased_items["others"] = $others;

            
            foreach( $info2save as $key => $value ){
                if (!in_array($key, array("step","go_to_step","id","faid","changes_made","generated_code","_token")) ){
                    if (is_array($value)){
                        $purchased_items[$key] = implode(",",$value);
                    }
                    else{
                        $purchased_items[$key] = $value;
                    }
                }
            }
        }

        //==========Step3==========
        if ($info2save["step"] == 3 || $request->get("is_view")){
		
            // FA SALES ITEMS
            $si = array();
            if (isset($info2save["si_package"])){
                $pInc = 0;
                for ($i = 0; $i < count($info2save["si_package"]); $i++){
                    $si[$info2save["si_package"][$i]] = array();
                    if (!empty($info2save["si_selection_item"][$i])){
                        $si[$info2save["si_package"][$i]]["selection_item"] = $info2save["si_selection_item"][$i];
                        $si[$info2save["si_package"][$i]]["price"] = $info2save["si_price"][$i];
                        $si[$info2save["si_package"][$i]]["remarks"] = $info2save["si_remarks"][$i];
                    }
                }
            }
            unset($info2save["si_package"],$info2save["si_selection_item"],$info2save["si_price"],$info2save["si_remarks"]);
            $purchased_items["si"] = $si;
            
            // MORE PACKS
           
            $mp = array();
            if (isset($info2save["more_package_name"])){
       //         var_dump($info2save);exit;
                $pInc = 0;
                for ($i = 0; $i < count($info2save["more_package_name"]); $i++){
                    $arrMP = explode("|", $info2save["more_package_name"][$i]);
                    $mp[$arrMP[0]] = array();
                    if (!empty($info2save["more_package_selection_".$arrMP[1]."_item"][$i])){
                        $mp[$arrMP[0]]["selection_item"] = $info2save["more_package_selection_".$arrMP[1]."_item"][$i];
                        $mp[$arrMP[0]]["price"] = $info2save["more_package_price"][$i];
                        $mp[$arrMP[0]]["remarks"] = $info2save["more_package_remarks"][$i];
                    }
                }
            }
            unset($info2save["more_package"],$info2save["more_package_selection_item"],$info2save["more_package_price"],$info2save["more_package_remarks"]);
            $purchased_items["mp"] = $mp;
            
            
            foreach( $info2save as $key => $value ){
                if (!in_array($key, array("step","go_to_step","id","faid","changes_made","generated_code","_token")) ){
                    if (is_array($value)){
                        $purchased_items[$key] = implode(",",$value);
                    }
                    else{
                        $purchased_items[$key] = $value;
                    }
                }
            }

            // Others price
            $others = array();
            if (isset($info2save["others_price"]) && empty($info2save["others_price"])){

                for ($i = 0; $i < count($info2save["others_price"]); $i++){
                    $others[$i] = array();
                    $others[$i]['title'] = $info2save["others"][$i];
                    $others[$i]['price'] = number_format(floatval($info2save["others_price"][$i]), 2, '.', '');
                    $others[$i]['remarks'] = $info2save["others_remarks"][$i];
                }
            }
            unset($info2save["others"],$info2save["others_price"],$info2save["others_remarks"]);
            $purchased_items["others"] = $others;
        }
        // SAVE PURCHASED ITEMS
        $fa->purchased_items = json_encode($purchased_items);
 
       
        // SAVE FILE - just when is not ajax
        $file = null;
        if ($request->hasFile('files')){
            $file = Input::file('files');
            if ($file){
                $destinationPath = public_path()."/uploads/fa";

                if (!is_dir($destinationPath)){
                    mkdir($destinationPath);
                } 
                
                $destinationPath .= "/".$fa->generated_code;
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
                    
                    if (!empty($fa->filename) && is_file(public_path()."/uploads/".$fa->filename)){
                        unlink( public_path()."/uploads/".$fa->filename );
                    }
                    $fa->filename = $fa->generated_code."/".$file->getClientOriginalName().".gz";
                }
                if (!is_file(public_path()."/uploads/".$fa->generated_code."/".$file->getClientOriginalName().".gz")){
                    $errors++;
                    $msg[] = "Error saving file";
                }
            }
        }

     
        // NOTIFICATIONS
        if ($bttn_clicked){
            if ($fa->is_draft == 1){
                $fa->is_draft = 0;  
                $fa->generated_code = FuneralArrangements::getNextCode();
                $notification_details = "new";
                $notification_action = "new_fa";
                
                // coffin notification
                $coffingSelection = false;
                foreach($purchased_items["si"] as $key => $value){
                    if (strtolower($key) == "coffin"){
                        $coffingSelection = (isset($value["selection_item"]))?$value["selection_item"]:"";
                        break;
                    }
                }
              
                foreach($purchased_items["mp"] as $key => $value){
                    if (strtolower($key) == "coffin"){
                        $coffingSelection = (isset($value["selection_item"]))?$value["selection_item"]:"";
                        break;
                    }
                }
                
                if ($coffingSelection){
                    $pdf_name = storage_path().'/app/pdfs/'.$fa->getFullCode().'_coffin_selection.pdf';
                    $data['deceased_name'] = $fa->deceased_name;
                    $data['fa_number'] = $fa->getFullCode();
                    $prod = \App\Products::find($coffingSelection);
                    $data['coffin_selected'] = ($prod)?$prod->item:'';

                    $pdf = PDF::loadView('funeral_arrangement/pdfs/coffin_slip', $data);
                    $pdf->setPaper('a4', 'portrait')->setWarnings(false)->save($pdf_name);
                    $user2receive = User::where("department_id",Department::OPERATIONS)->get();
                    foreach ($user2receive as $u){
                        $email = $u->email;
                        Mail::send('emails.coffin_slip', [], function($message) use ($email, $pdf_name){
                            $message->to( $email )
                                    ->subject('New Coffin Slip')
                                    ->attach($pdf_name, array('mime' => 'application/pdf')
                                    );
                        });
                    }

                    if(count(Mail::failures()) > 0){
                        $msg[] = "Error sending mail.";
                        $errors++;
                    }
                    else{
                        $msg[] = "Mail to $email sent OK.";
                    }
                    
                    
                    foreach ($user2receive as $user) {
                        $notification = new Notification();
                        $notification->action = "coffin_slip";
                        $notification->page = "/fa";
                        $notification->section = "Coffin Slip";
                        $notification->details = "coffin_slip";
                        $notification->link = $pdf_name;
                        $notification->creator_id = Auth::User()->id;
                        $notification->receiver_id = $user->id;
                        $notification->receiver_type = 'user';
                        $notification->title = $notification->getTitle();
                        $notification->show_as_popup = 1;
                        $notification->save();
                    }
                }
                
            }
            else{
                $notification_details = "update";
                $notification_action = "update_fa";
            }       
            
            $notificationReceiversSetting = Settings::where(['name' => Settings::KEY_FA_NOTIFICATION_INDIVIDUALS])->first();
            $notificationDepartmentsSetting = Settings::where(['name' => Settings::KEY_FA_NOTIFICATION_DEPARTMENTS])->first();
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
                $notification->page = "/fa";
                $notification->section = "New FA";
                $notification->details = $notification_details;
                $notification->link = "/fa/view/".$fa->id;
                $notification->creator_id = Auth::User()->id;
                $notification->receiver_id = $user->id;
                $notification->receiver_type = 'user';
                $notification->title = $notification->getTitle();
                $notification->save();
            }
        
        
           
            // remove from inventory
            $arrItems = explode(",",$fa->package_items);
            $groupItems = explode(",", $fa->group_items);
            foreach($arrItems as $itemId){

                $packItem = \App\PackageItems::find(str_replace(array("w","s"),"",$itemId));
                if ($packItem){

                    $product = \App\Products::find($packItem->selection_item_id);
                    $history = StockHistory::where('reference_no', $fa->generated_code)->where('product_id', $product->id)->first();

                    if(!$history || $history->product_id != $product->id) {
                        if (strpos($itemId, "w")){
                            $product->warehouse -= 1;
                            $product->save();

                            // Inventory HISTORY
                            $new_history = new \App\StockHistory();
                            $new_history->product_id = $product->id;
                            $new_history->behavior = "purchase";
                            $new_history->user_id = Auth::User()->id;
                            $new_history->warehouse = -1;
                            $new_history->remarks = "purchased";
                            $new_history->editable_date_modif = date('Y-m-d H:i:s');
                            $new_history->type = "sales";
                            $new_history->balance_w = $product->warehouse;
                            $new_history->balance_s = $product->store_room;
                            $new_history->reference_no = $fa->generated_code;
                            $new_history->save();
                        }
                        else if (strpos($itemId, "s")){
                            $product->store_room -= 1;
                            $product->save();

                            // Inventory HISTORY
                            $new_history = new \App\StockHistory();
                            $new_history->product_id = $product->id;
                            $new_history->behavior = "purchase";
                            $new_history->user_id = Auth::User()->id;
                            $new_history->store_room = -1;
                            $new_history->remarks = "purchased";
                            $new_history->editable_date_modif = date('Y-m-d H:i:s');
                            $new_history->type = "sales";
                            $new_history->balance_w = $product->warehouse;
                            $new_history->balance_s = $product->store_room;
                            $new_history->reference_no = $fa->generated_code;
                            $new_history->save();

                        }
                        else{
                            $msg[] = "Stock too low for {$product->item} . ";
                            $errors++;
                        }
                    }
                }
            }


            foreach($groupItems as $itemId){
                $packItem = \App\SettingsGroupedItems::find(str_replace(array("w","s"),"",$itemId));
                if ($packItem){
                    $product = \App\Products::find($packItem->selection_item_id);
                    $history = StockHistory::where('reference_no', $fa->generated_code)->where('product_id', $product->id)->first();
                    if(!$history || $history->product_id != $product->id) {
                        if (strpos($itemId, "w")) {
                            $product->warehouse -= 1;
                            $product->save();
                            // Inventory HISTORY
                            $new_history = new \App\StockHistory();
                            $new_history->product_id = $product->id;
                            $new_history->behavior = "purchase";
                            $new_history->user_id = $user->id;
                            $new_history->warehouse = -1;
                            $new_history->remarks = "purchased";
                            $new_history->editable_date_modif = date('Y-m-d H:i:s');
                            $new_history->type = "sales";
                            $new_history->balance_w = $product->warehouse;
                            $new_history->balance_s = $product->store_room;
                            $new_history->reference_no = $fa->generated_code;
                            $new_history->save();

                        } else if (strpos($itemId, "s")) {
                            $product->store_room -= 1;
                            $product->save();

                            // Inventory HISTORY
                            $new_history = new \App\StockHistory();
                            $new_history->product_id = $product->id;
                            $new_history->behavior = "purchase";
                            $new_history->user_id = $user->id;
                            $new_history->store_room = -1;
                            $new_history->remarks = "purchased";
                            $new_history->editable_date_modif = date('Y-m-d H:i:s');
                            $new_history->type = "sales";
                            $new_history->balance_w = $product->warehouse;
                            $new_history->balance_s = $product->store_room;
                            $new_history->reference_no = $fa->generated_code;
                            $new_history->save();
                        } else {
                            $msg[] = "Stock too low for {$product->item} . ";
                            $errors++;
                        }
                    }
                }
            }

            // MAIL
            if ($bttn_clicked == "submit_email_bttn" || $bttn_clicked == "submit_other_email_bttn"){       
                $found_email = $fa->first_cp_email;
                if ($bttn_clicked == "submit_other_email_bttn"){
                    $found_email = $request->get("new_email");
                }
                
                $email = filter_var($found_email, FILTER_VALIDATE_EMAIL);
                
                if ($email){
                    $tmp_pdf = resource_path().'/'.(($fa->company_id == Company::WSC )?"WSC":"WFA").$fa->generated_code.'.pdf';
                    // General data
                    $data["religionOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RELIGION)->orderBy("id")->get();
                    $data["raceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RACE)->orderBy("id")->get();
                    $data["sourceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::SOURCE)->orderBy("id")->get();

                    // Draft
                    $data["object"] = $fa;     
                    
                    // Ala-carte ---------------------------
                    $ala_carte_items = \App\SettingsGroupedItems::where("is_deleted",0)->where("item_type","ala_carte")->get()->toArray();
                    $items = array();
                    if (is_array($ala_carte_items)){
                        foreach($ala_carte_items as $item){
                            if (!isset($items[$item["group_name"]][$item["selection_category"]])){
                                $items[$item["group_name"]][$item["selection_category"]]= array();
                            }
                            $items[$item["group_name"]][$item["selection_category"]][] = $item;
                        }
                    }
                    $data["items"] = $items;
                    $data["category_names"] = Settings::FA_ALA_CARTE_CATEGORY_NAMES;

                    // FA individual sale -----------------------------
                    $fa_sales_items = \App\SettingsGroupedItems::where("is_deleted",0)->where("item_type","individual_sales")->get()->toArray();
                    $items = array();
                    if (is_array($fa_sales_items)){
                        foreach($fa_sales_items as $item){
                            if (!isset($items[$item["group_name"]][$item["selection_category"]])){
                                $items[$item["group_name"]][$item["selection_category"]]= array();
                            }
                            $items[$item["group_name"]][$item["selection_category"]][] = $item;
                        }
                    }

                    $data["sales_items"] = $items;
                    $namesObj = Settings::where("name", Settings::KEY_FA_SALES_PACKAGES)->first();
                    if ($namesObj){
                        $data["sales_category_names"] = ($namesObj->value)?json_decode($namesObj->value, true):array();
                    }


                    $arrItems = json_decode($object->purchased_items, true);
                    if (is_array($arrItems)){
                        $data = array_merge($data, $arrItems);
                    }

                    $settings_discount = Settings::where("name", Settings::KEY_FA_DISCOUNT)->first();
                    $data["discounts"] = json_decode($settings_discount->value);

                    $data["selected_package_items"] = explode(",",str_replace(array("w","s"), "",$object->package_items));
                    $data["selected_package"] = new \App\Packages();
                    if (!empty($data["selected_package_items"])){
                        $pack = \App\PackageItems::find($data["selected_package_items"][0]);
                        if ($pack){
                            $data["selected_package"] = \App\Packages::find($pack->fa_package_id);
                        }
                    }

                    $data['users'] = User::all();
                    $pdf = PDF::loadView('funeral_arrangement/pdfs/fa', $data);
                    $pdf->setPaper('a4', 'portrait')->setWarnings(false)->save($tmp_pdf);

                    Mail::send('emails.new_fa', [], function($message) use ($email, $tmp_pdf){
                        $message->to( $email )
                                ->subject('New FA form')
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
        $fa->last_saved_by = Auth::user()->id;

        if ($fa->save()){
            $msg[] = "Information saved.";
            
            
            if ($bttn_clicked){
                $arr_purchased_items = json_decode($fa->purchased_items , true);
                
                // Parlours
                /*if (!empty($arr_purchased_items["parlours"])){
                    foreach($arr_purchased_items["parlours"] as $key=>$parlour){
                        $from_date_time = $parlour["parlour_from_date"].' '.$parlour["parlour_from_time"].':00';
                        $to_date_time = $parlour["parlour_to_date"].' '.$parlour["parlour_to_time"].':00';
                        $start = date("Y-m-d H:i:s", strtotime(str_replace("/","-",$from_date_time)));
                        $end = date("Y-m-d H:i:s", strtotime(str_replace("/","-",$to_date_time)));
                        $q = ParlourOrders::whereRaw(" (( CONCAT(`booked_from_day`,' ',`booked_from_time`) <= '".$start."' AND '".$start."' <= CONCAT(`booked_to_day`,' ',`booked_to_time`) )"
                                                        . " OR "
                                                        . " ( CONCAT(`booked_from_day`,' ',`booked_from_time`) <= '".$end."' AND '".$end."' <= CONCAT(`booked_to_day`,' ',`booked_to_time`) )   "
                                                        . " OR "
                                                        . " ('".$end."' >= CONCAT(`booked_to_day`,' ',`booked_to_time`) AND '".$start."' <= CONCAT(`booked_from_day`,' ',`booked_from_time`)  )"
                                                        . " ) AND parlour_id = '{$parlour["parlour_id"]}'")
                                ->orderBy("booked_to_day");

                        if (!empty($parlour["parlour_order_id"])){
                            $q->where("id","!=",$parlour["parlour_order_id"]);
                        }
            
                        $res = $q->first();
                        if ($res){
                            // Reject
                            $msg[] = "A parlour order for '{$parlour["parlour_from"]}' - '{$parlour["parlour_to"]}' already exists";
                            $errors++;
                        }
                        else{
                            $order = null;
                            if (isset($parlour["parlour_order_id"])){
                                $order = ParlourOrders::find($parlour["parlour_order_id"]);
                            }
                            if (!$order){
                                $order = new ParlourOrders();
                                $order->order_nr = ParlourOrders::getNextNumber();
                                $order->created_by = $user->id;
                                $order->funeral_arrangement_id = $fa->id;
                            }


                            $order->parlour_name = $parlour["parlour_name"];
                            $order->parlour_id = $parlour["parlour_id"];
                            $order->booked_from_day = date("Y-m-d", strtotime(str_replace("/","-", $parlour["parlour_from"]) ));
                            $order->booked_from_time = date("H:i:s", strtotime(str_replace("/","-", $parlour["parlour_from"]) ));
                            $order->booked_to_day = date("Y-m-d", strtotime(str_replace("/","-", $parlour["parlour_to"]) ));
                            $order->booked_to_time = date("H:i:s", strtotime(str_replace("/","-", $parlour["parlour_to"]) ));
                            $order->unit_price = $parlour["parlour_unit_price"];
                            $order->total_price = $parlour["parlour_total_price"];
                            $order->deceased_name = $fa->deceased_name;
                            $order->cp_nric = $fa->deceased_name;
                            $order->cp_name = $fa->deceased_name;
                            $signatures = json_decode($fa->signatures, true);
                            $order->signature = $signatures[1];
                            $order->signature_date = $fa->signature_date;
                            $order->save();

                            if (empty($parlour["parlour_order_id"]) || $parlour["parlour_order_id"] != $order->id ){
                                $arr_purchased_items["parlours"][$key]["parlour_order_id"] = $order->id;
                            }
                        }
                    }
                }*/

                // Hearse
                if (!empty($arr_purchased_items["hearse_name"])){
                    $start = date("Y-m-d H:i:s", strtotime(str_replace("/","-",$arr_purchased_items["hearse_from"])));
                    $end = date("Y-m-d H:i:s", strtotime(str_replace("/","-",$arr_purchased_items["hearse_to"])));
                    $q = \App\HearseOrders::whereRaw(" (( CONCAT(`booked_from_day`,' ',`booked_from_time`) <= '".$start."' AND '".$start."' <= CONCAT(`booked_to_day`,' ',`booked_to_time`) )"
                                                    . " OR "
                                                    . " ( CONCAT(`booked_from_day`,' ',`booked_from_time`) <= '".$end."' AND '".$end."' <= CONCAT(`booked_to_day`,' ',`booked_to_time`) )   "
                                                    . " OR "
                                                    . " ('".$end."' >= CONCAT(`booked_to_day`,' ',`booked_to_time`) AND '".$start."' <= CONCAT(`booked_from_day`,' ',`booked_from_time`)  )"
                                                    . ") AND hearse_id = '{$arr_purchased_items["hearse_id"]}'")
                            ->orderBy("booked_to_day");
                    if (!empty($arr_purchased_items["hearse_order_id"])){
                        $q->where("id","!=",$arr_purchased_items["hearse_order_id"]);
                    }
                    
                    $res = $q->first();
                    if ($res){
                        // Reject
                        $msg[] = "A hearse order for '{$arr_purchased_items["hearse_from"]}' - '{$arr_purchased_items["hearse_to"]}' already exists";
                        $errors++;
                    }
                    else{
                        $order = null;
                        if (!empty($arr_purchased_items["hearse_order_id"])){
                            $order = \App\HearseOrders::find($arr_purchased_items["hearse_order_id"]);
                        }
                        if (!$order){
                            $order = new \App\HearseOrders();
                            $order->order_nr = \App\HearseOrders::getNextNumber();
                            $order->created_by = $user->id;
                            $order->funeral_arrangement_id = $fa->id;
                        }
                        
                        $order->hearse_name = (isset($arr_purchased_items["hearse_name"]))?$arr_purchased_items["hearse_name"]:"";
                        $order->hearse_id = $arr_purchased_items["hearse_id"];
                        $order->booked_from_day = date("Y-m-d", strtotime(str_replace("/","-", $arr_purchased_items["hearse_from"]) ));
                        $order->booked_from_time= date("H:i:s", strtotime(str_replace("/","-", $arr_purchased_items["hearse_from"]) ));
                        $order->booked_to_day = date("Y-m-d", strtotime(str_replace("/","-", $arr_purchased_items["hearse_to"]) ));
                        $order->booked_to_time = date("H:i:s", strtotime(str_replace("/","-", $arr_purchased_items["hearse_to"]) ));
                        $order->unit_price = $arr_purchased_items["hearse_unit_price"];
                        $order->total_price = $arr_purchased_items["hearse_price"];
                        $order->deceased_name = $fa->deceased_name;
                        $order->cp_nric = $fa->deceased_name;
                        $order->cp_name = $fa->deceased_name;
                        $signatures = json_decode($fa->signatures, true);
                        $order->signature = $signatures[1];
                        $order->signature_date = $fa->signature_date;
                        $order->save();

                        if (empty($arr_purchased_items["hearse_order_id"]) || $arr_purchased_items["hearse_order_id"] != $order->id){
                            $arr_purchased_items["hearse_order_id"] = $order->id;
                        }
                    }
                }
                $fa->purchased_items = json_encode($arr_purchased_items);
                $fa->save();
            }
            
            
        }
        else{
            $msg[] = "Error saving data.";
            $errors++;
        }
        
        
        if ($request->ajax())
        {
            return response()->json([
                'msg' => implode("<br />",$msg),
                'errors' => $errors
            ]);
        }
        else{

            if ($request->get("is_view") == 1){
                return Redirect::to('/fa/view/'.$fa->id);
            }
            else{
                $go_to_step = $request->get("go_to_step",1);
                if ($go_to_step > 1 && $go_to_step <= 4 ){
                    return Redirect::to('/fa/step' . $go_to_step);
                }
                else{
                    return Redirect::to('/fa');
                }
            }
        }
    }
    
    
    
    public function deleteDraft(){
        $draft = FuneralArrangements::getDraft();
        $draft->delete();
        $session = new Session();
        $session->remove("fa_id");
        return 1;
    }
    
    public function searchDeceased(Request $request){
       
       $results = Shifting::where('deceased_name','like','%'.$request->get('term').'%')->orderby('deceased_name')->with('parlour_order')->get()->toArray();
       $arrResponse = array();
       foreach ($results as $key => $result){
           foreach($result as $propName => $propValue){
               $arrResponse[$key][$propName] = $propValue;
           }
       }
       return response()->json($arrResponse);
    }
   
    public function searchDialect(Request $request){
       
       $results = SelectOptionsValues::where('name','like','%'.$request->get('term').'%')->where('select_options_category_id', SelectOptionsCategories::DIALECTS )->orderby('id')->get();
       $arrResponse = array();
       foreach ($results as $key => $result){
           $arrResponse[$key]["name"] = $result->name;
       }
       return response()->json($arrResponse);
    }
    
    public function dowloadFaFile($fa_id)
    {
        $fa = FuneralArrangements::find($fa_id);
        $destinationPath = public_path()."/uploads/";
        if ($fa && $fa->filename && is_file($destinationPath . "/".$fa->filename)){
            return response()->download($destinationPath . "/".$fa->filename);
        }
        else{
            return "File not found";
        }
    }
    
    
    
    
    
    // FA Repatriation ----------------------------------------------------------------------------------------------------------------------
    public function FArepatriation(Request $request){
        $user = Auth::user(); 
        
        // General data
        $data["religionOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        $data["raceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RACE)->orderBy("id")->get();
        $data["sourceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::SOURCE)->orderBy("id")->get();      
        
        // Draft
        $draft = FARepatriationForms::where("is_draft",1)->where("user_id", $user->id)->first();
        if (!$draft){
            $draft = new FARepatriationForms();
            $draft->is_draft = 1;
            $draft->user_id = $user->id;
            $draft->save();
        }
        $data["object"] = $draft;       
        $session = new Session();
        $session->set("fa_repatriation_id", $draft->id);
        
        
        // Checklist
        $data["checlist_items"] = ChecklistItems::orderBy('position', 'asc')->get();
        $data["last_item_position"] = count($data["checlist_items"]);
              
        // Purchased items
        $arrItems = json_decode($draft->purchased_items, true);
        if (is_array($arrItems)){
            $data = array_merge($data, $arrItems);
        }
        
        $data['users'] = User::all();
        
        $data["saved_checklist"] = json_decode($draft->checklist_data, true);
        $data["step"] = 1;
        return view('funeral_arrangement/repatriation', $data);
    }
    
    public function FArepatriationStepTwo(){
        $session = new Session();
        $fa = FARepatriationForms::find($session->get("fa_repatriation_id"));
        $data["object"] = $fa;
 
        // Checklist
        $data["checlist_items"] = ChecklistItems::orderBy('position', 'asc')->get();
        $data["last_item_position"] = count($data["checlist_items"]);
        $data["saved_checklist"] = json_decode($fa->checklist_data, true);
        
        $data["other_purchased_items"] = json_decode($fa->other_purchased_items, true);
        
        $settings_discount = Settings::where("name", Settings::KEY_FA_REPATRIATION_DISCOUNT)->first();
        $data["discounts"] = json_decode($settings_discount->value);
        
        // USERS
        $data['users'] = User::all();
        $user = Auth::user(); 
        $data['user'] = $user;
        
        
        $far_sales_items = \App\SettingsGroupedItems::where("is_deleted",0)->where("item_type","far")->get()->toArray();
        $items = array();
     
        if (is_array($far_sales_items)){
            foreach($far_sales_items as $item){
//                For point 9
                $is_check = \App\Products::where("id",$item['selection_item_id'])->where("is_deleted",0)->get()->toArray();
                if(count($is_check) >0){
                    if (!isset($items[$item["group_name"]][$item["selection_category"]])){
                        $items[$item["group_name"]][$item["selection_category"]]= array();
                    }
                    $items[$item["group_name"]][$item["selection_category"]][] = $item;
                }
            }
        }

        $data["sales_items"] = $items;
        $arrItems = json_decode($fa->purchased_items, true);
        if (is_array($arrItems)){
            $data = array_merge($data, $arrItems);
        }
        
        $data["step"] = 2;
        return view('funeral_arrangement/repatriation', $data);
    }
    
    
    public function FArepatriationStepThree(){
        $session = new Session();
        $fa = FARepatriationForms::find($session->get("fa_repatriation_id"));
        $data["object"] = $fa;
 
        // Checklist
        $data["checlist_items"] = ChecklistItems::orderBy('position', 'asc')->get();
        $data["last_item_position"] = count($data["checlist_items"]);
        $data["saved_checklist"] = json_decode($fa->checklist_data, true);
        
        
        $data["step"] = 3;
        return view('funeral_arrangement/repatriation', $data);
    }
    
    
    public function autoSaveFARepatriationChecklist( Request $request ){
        $data = $request->all();
        $arrChecklist = array();
        foreach ($data as $name => $val){
            if ( strpos($name, "remarks") > -1 || strpos($name, "active_item") > -1 ){
                $id = str_replace(array("remarks_","active_item_"), "", $name);
                $arrChecklist[$id][str_replace("_".$id,"",$name)] = $val;
            }
        }
        $checklist = json_encode($arrChecklist);
        
        $session = new Session();
        $fa = FARepatriationForms::find($session->get("fa_repatriation_id"));
        $fa->checklist_data = $checklist;
        $fa->save();

        if ($fa->shifting_id){
            $timelog = \App\EmbalmingTimelog::where("shifting_id", $fa->shifting_id)->first();
            if ( isset($arrChecklist[17]["remarks"]) && !empty($arrChecklist[17]["remarks"])){
                $timelog->items_in_coffin = "Yes";
                $timelog->save();
            }
            else{
                $timelog->items_in_coffin = "";
                $timelog->save();
            }
        }
    }
    
    public function saveFARepatriation(Request $request){
        $bttn_clicked = $request->get("bttn_clicked"); // only in step 4
        $errors = 0;
        $msg = array();
        
        $session = new Session();
        $user = Auth::user(); 
        $fa = FARepatriationForms::find($request->get("id"));

        // SAVE DATA
        $columns = \Schema::getColumnListing("fa_repatriation_forms");
        $info2save = $request->all();
        unset($info2save["id"],$info2save["_token"]);
        foreach( $info2save as $key => $value ){
            if (in_array($key, $columns) ){
                if ($value == "other"){
                    $fa->{$key} = $info2save["other_".$key];
                }
                elseif ($value == "users_ids"){
                    $fa->{$key} = implode(",",$value);
                }
                else{
                    $fa->{$key} = $value;
                    if ($key == "dialect" && !empty($info2save["dialect"])){
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
        
        // FA SALES ITEMS
        $si = array();
        $purchased_items = array();
        if (isset($info2save["si_package"])){
            $pInc = 0;
            for ($i = 0; $i < count($info2save["si_package"]); $i++){
                $si[$info2save["si_package"][$i]] = array();
                if (!empty($info2save["si_selection_item"][$i])){
                    $si[$info2save["si_package"][$i]]["selection_item"] = $info2save["si_selection_item"][$i];
                    $si[$info2save["si_package"][$i]]["price"] = $info2save["si_price"][$i];
                    $si[$info2save["si_package"][$i]]["remarks"] = $info2save["si_remarks"][$i];
                }
            }
            unset($info2save["si_package"],$info2save["si_selection_item"],$info2save["si_price"],$info2save["si_remarks"]);
            $purchased_items["si"] = $si;
        }
        

        // MORE PACKS

        $mp = array();
        if (isset($info2save["more_package_name"])){

            $pInc = 0;
            for ($i = 0; $i < count($info2save["more_package_name"]); $i++){
                $arrMP = explode("|", $info2save["more_package_name"][$i]);
                $mp[$arrMP[0]] = array();
                if (!empty($info2save["more_package_selection_".$arrMP[1]."_item"][$i])){
                    $mp[$arrMP[0]]["selection_item"] = $info2save["more_package_selection_".$arrMP[1]."_item"][$i];
                    $mp[$arrMP[0]]["price"] = $info2save["more_package_price"][$i];
                    $mp[$arrMP[0]]["remarks"] = $info2save["more_package_remarks"][$i];
                }
            }
            unset($info2save["more_package"],$info2save["more_package_selection_item"],$info2save["more_package_price"],$info2save["more_package_remarks"]);
            $purchased_items["mp"] = $mp;
        }
        
        if (!empty($purchased_items)){
            $fa->purchased_items = json_encode($purchased_items);
        }
               
        
        //SIGNATURES
        if ($request->get("signature1") ){
            $fa->signatures = json_encode(array( 1 => $request->get("signature1"), 2 => $request->get("signature2")));
            $fa->signature_date = date("Y-m-d", strtotime(str_replace("/","-",$request->get("date_signature_1")))) ;
        }
           
        
        
        // SAVE FILE - just when is not ajax
        $file = null;
        if ($request->hasFile('files')){
            $file = Input::file('files');
            if ($file){
                $destinationPath = public_path()."/uploads/fa_repatriation";

                if (!is_dir($destinationPath)){
                    mkdir($destinationPath);
                } 
                
                $destinationPath .= "/".$fa->generated_code;
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
                    
                    if (!empty($fa->filename) && is_file(public_path()."/uploads/".$fa->filename)){
                        unlink( public_path()."/uploads/".$draft->filename );
                    }
                    $fa->filename = $fa->generated_code."/".$file->getClientOriginalName().".gz";
                }
                if (!is_file(public_path()."/uploads/".$fa->generated_code."/".$file->getClientOriginalName().".gz")){
                    $errors++;
                    $msg[] = "Error saving file";
                }
            }
        }

        
        
        if ($bttn_clicked){

            if ($fa->is_draft == 1){
                $fa->is_draft = 0;  
                $fa->generated_code = FARepatriationForms::getNextCode();
                $companyId = $session->get('company_id');
                $fa->company_id = ($companyId)?$companyId:0;
                
                
                // coffin notification
                $coffingSelection = false;
                if (isset($purchased_items["si"])){
                    foreach($purchased_items["si"] as $key => $value){
                        if (strtolower($key) == "coffin"){
                            $coffingSelection = $value["selection_item"];
                            break;
                        }
                    }
                }
                
                if (isset($purchased_items["mp"])){
                    foreach($purchased_items["mp"] as $key => $value){
                        if (strtolower($key) == "coffin"){
                            $coffingSelection = $value["selection_item"];
                            break;
                        }
                    }
                }
                
                if ($coffingSelection){
                    $pdf_name = storage_path().'/app/pdfs/'.$fa->getFullCode().'_fa_repatriation_coffin_selection.pdf';
                    $data['deceased_name'] = $fa->deceased_name;
                    $data['fa_number'] = $fa->getFullCode();
                    $prod = \App\Products::find($coffingSelection);
                    $data['coffin_selected'] = ($prod)?$prod->item:'';

                    $pdf = PDF::loadView('funeral_arrangement/pdfs/coffin_slip', $data);
                    $pdf->setPaper('a4', 'portrait')->setWarnings(false)->save($pdf_name);
                    $user2receive = User::where("department_id",Department::OPERATIONS)->get();
                    foreach ($user2receive as $u){
                        $email = $u->email;
                        Mail::send('emails.coffin_slip', [], function($message) use ($email, $pdf_name){
                            $message->to( $email )
                                    ->subject('New Coffin Slip')
                                    ->attach($pdf_name, array('mime' => 'application/pdf')
                                    );
                        });
                    }

                    if(count(Mail::failures()) > 0){
                        $msg[] = "Error sending mail.";
                        $errors++;
                    }
                    else{
                        $msg[] = "Mail to $email sent OK.";
                    }
                    
                    
                    foreach ($user2receive as $user) {
                        $notification = new Notification();
                        $notification->action = "coffin_slip";
                        $notification->page = "/fa";
                        $notification->section = "Coffin Slip";
                        $notification->details = "coffin_slip";
                        $notification->link = $pdf_name;
                        $notification->creator_id = Auth::User()->id;
                        $notification->receiver_id = $user->id;
                        $notification->receiver_type = 'user';
                        $notification->title = $notification->getTitle();
                        $notification->show_as_popup = 1;
                        $notification->save();
                    }
                }
               
            }
            
//                       For point 9 
            
            // remove from inventory       
            $groupItems = explode(",", $fa->group_items);
           

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
//                    elseif($product->warehouse > 0 || $product->store_room > 0 ){
//                        if ($product->warehouse > $product->store_room){
//                            $product->warehouse -= 1;
//                            $product->save();
//                        }
//                        else{
//                            $product->store_room -= 1;
//                            $product->save();
//                        }
//                    }
                    else{
                        $msg[] = "Stock too low for {$product->item} . ";
                        $errors++;
                    }
                }
            }
            
            
//                       end 
        
        
            // MAIL
            if ($bttn_clicked == "submit_email_bttn" || $bttn_clicked == "submit_other_email_bttn"){       
                $found_email = $fa->first_cp_email;
                if ($bttn_clicked == "submit_other_email_bttn"){
                    $found_email = $request->get("new_email");
                }
                
                $email = filter_var($found_email, FILTER_VALIDATE_EMAIL);
                
                if ($email){
                    $tmp_pdf = resource_path().'/'.(($fa->company_id == Company::WSC )?"WSC":"WFA").$fa->generated_code.'.pdf';
                    // General data
                    $data["religionOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RELIGION)->orderBy("id")->get();
                    $data["raceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RACE)->orderBy("id")->get();
                    $data["sourceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::SOURCE)->orderBy("id")->get();

                    // Draft
                    $data["object"] = $fa;       

                    $far_sales_items = \App\SettingsGroupedItems::where("is_deleted",0)->where("item_type","far")->get()->toArray();
                    $items = array();
                    if (is_array($far_sales_items)){
                        foreach($far_sales_items as $item){
                            if (!isset($items[$item["group_name"]][$item["selection_category"]])){
                                $items[$item["group_name"]][$item["selection_category"]]= array();
                            }
                            $items[$item["group_name"]][$item["selection_category"]][] = $item;
                        }
                    }

                    $data["sales_items"] = $items;
                    $namesObj = Settings::where("name", Settings::KEY_FA_SALES_PACKAGES)->first();
                    if ($namesObj){
                      $data["sales_category_names"] = ($namesObj->value)?json_decode($namesObj->value, true):array();
                    }

                    $arrItems = json_decode($fa->purchased_items, true);
                    if (is_array($arrItems)){
                      $data = array_merge($data, $arrItems);
                    }
                    
                    $data["other_purchased_items"] = json_decode($data["object"]->other_purchased_items, true);

                    $settings_discount = Settings::where("name", Settings::KEY_FA_DISCOUNT)->first();
                    $data["discounts"] = json_decode($settings_discount->value);
                    

                    
                    $data['users'] = User::all();
                    $pdf = PDF::loadView('funeral_arrangement/pdfs/fa_repatriation', $data);
                    $pdf->setPaper('a4', 'portrait')->setWarnings(false)->save($tmp_pdf);

                    Mail::send('emails.new_fa', [], function($message) use ($email, $tmp_pdf){
                        $message->to( $email )
                                ->subject('New FA form')
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
        $fa->last_saved_by = $user->id;
        if ($fa->save()){
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
                'errors' => $errors
            ]);
        }
        else{
            $go_to_step = $request->get("go_to_step",1);
            if ($go_to_step > 1 && $go_to_step <= 4 ){
                return Redirect::to('/FArepatriation/step' . $go_to_step);
            }
            else{
                return Redirect::to('/FArepatriation');
            }
        }
    }
    
    
    public function deleteCurrentFARepatriation(){
        $session = new Session();
        $fa = FARepatriationForms::find($session->get("fa_repatriation_id"));
        $fa->delete();
   
        $session->remove("fa_repatriation_id");
        return 1;
    }
    
    public function getStockInfo(Request $request){
        $session = new Session();
        //  var_dump($request->all());exit;
        $arrList = array();
        $group_data=array();
        $arr = explode(",",str_replace(array("w","s"),"",$request->get("package_items")));
        $selected_item = explode(",", $request->get("selected_item"));
        
        if($selected_item[0] ==''){
            unset($selected_item[0]);
        }
       
        /*      For point 9     */
        
       
        
        $data["fa_items"] = \App\PackageItems::whereIn("id",$arr)->get();
     
	$data['group_items'] = \App\SettingsGroupedItems::whereIn("id",$selected_item)->get(); ///get data for selected_items.
        
       
            foreach($data["fa_items"] as $item){


                $product = \App\Products::where( "id",$item->selection_item_id )->where("is_deleted",0)->first();
                 $arrList[$product->id] = array("w"=>0,"s"=>0);
                if ($product->warehouse > 0 && $product->store_room > 0){

                    $arrList[$item->id]["w"] = $product->warehouse;
                    $arrList[$item->id]["s"] = $product->store_room;
                }
            }
       
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
        
        if (!empty($arrList) || !empty($group_data)){
            $data["list"]['fa_package'] = $arrList;
            $data["list"]['group_items'] = $group_data;
            return view('funeral_arrangement/stock_info', $data);
        }
        else{
            return "";
        }
    }

    public function getFullImage(Request $request){

        $id= $request->get("id");

        $result = PackageItems::find($id);

        return $result->image;
    }

    public function getParlourOrder(Request $request){

        //$user = Auth::user();

        $data = array();

        if ($request->get("parlour_id")) {
            $order = ParlourOrders::find($request->get("parlour_id"));
            $data['order'] = $order;
        }

        if($order->funeral_arrangement_id)
            $data['fa_code'] = FuneralArrangements::find($order->funeral_arrangement_id)->generated_code;
        else
            $data['fa_code'] = '';
        $data['taken_by'] = User::find($order->created_by)->name;

        return $data;
    }
}
