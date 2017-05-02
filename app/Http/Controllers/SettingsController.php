<?php

namespace App\Http\Controllers;

use App\Company;
use App\Department;
use App\GemstoneOrders;
use App\NicheBlock;
use App\Settings;
use App\Products;
use App\User;
use App\Hearses;
use App\Parlours;
use App\Packages;
use App\RosterSettings;
use App\PackageItems;
use App\SettingsGroupedItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input as Input;
use Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Session\Session;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$user = Auth::user(); 
        $args = [
            'secret_key'                            => Settings::where(['name' => Settings::KEY_LANDING_PAGE_PASSWORD])->first(),
            'shifting_email_departments_ids'        => Settings::where(['name' => Settings::KEY_SHIFTING_EMAIL_DEPARTMENTS])->first(),
            'shifting_email_individuals_ids'        => Settings::where(['name' => Settings::KEY_SHIFTING_EMAIL_INDIVIDUALS])->first(),
            'shifting_notification_departments_ids' => Settings::where(['name' => Settings::KEY_SHIFTING_NOTIFICATION_DEPARTMENTS])->first(),
            'shifting_notification_individuals_ids' => Settings::where(['name' => Settings::KEY_SHIFTING_NOTIFICATION_INDIVIDUALS])->first(),
            'shifting_update_departments_ids'       => Settings::where(['name' => Settings::KEY_SHIFTING_UPDATE_DEPARTMENTS])->first(),
            'shifting_update_individuals_ids'       => Settings::where(['name' => Settings::KEY_SHIFTING_UPDATE_INDIVIDUALS])->first(),
            
            
            'fa_email_departments_ids'              => Settings::where(['name' => Settings::KEY_FA_EMAIL_DEPARTMENTS])->first(),
            'fa_email_individuals_ids'              => Settings::where(['name' => Settings::KEY_FA_EMAIL_INDIVIDUALS])->first(),
            'fa_notification_departments_ids'       => Settings::where(['name' => Settings::KEY_FA_NOTIFICATION_DEPARTMENTS])->first(),
            'fa_notification_individuals_ids'       => Settings::where(['name' => Settings::KEY_FA_NOTIFICATION_INDIVIDUALS])->first(),
            'fa_update_departments_ids'             => Settings::where(['name' => Settings::KEY_FA_UPDATE_DEPARTMENTS])->first(),
            'fa_update_individuals_ids'             => Settings::where(['name' => Settings::KEY_FA_UPDATE_INDIVIDUALS])->first(),
            
            
            'gemstone_email_departments_ids'              => Settings::where(['name' => Settings::KEY_GEMSTONE_EMAIL_DEPARTMENTS])->first(),
            'gemstone_email_individuals_ids'              => Settings::where(['name' => Settings::KEY_GEMSTONE_EMAIL_INDIVIDUALS])->first(),
            'gemstone_notification_departments_ids'       => Settings::where(['name' => Settings::KEY_GEMSTONE_NOTIFICATION_DEPARTMENTS])->first(),
            'gemstone_notification_individuals_ids'       => Settings::where(['name' => Settings::KEY_GEMSTONE_NOTIFICATION_INDIVIDUALS])->first(),
            'gemstone_update_departments_ids'             => Settings::where(['name' => Settings::KEY_GEMSTONE_UPDATE_DEPARTMENTS])->first(),
            'gemstone_update_individuals_ids'             => Settings::where(['name' => Settings::KEY_GEMSTONE_UPDATE_INDIVIDUALS])->first(),
                        
            'columbarium_email_departments_ids'              => Settings::where(['name' => Settings::KEY_COLUMBARIUM_EMAIL_DEPARTMENTS])->first(),
            'columbarium_email_individuals_ids'              => Settings::where(['name' => Settings::KEY_COLUMBARIUM_EMAIL_INDIVIDUALS])->first(),
            'columbarium_notification_departments_ids'       => Settings::where(['name' => Settings::KEY_COLUMBARIUM_NOTIFICATION_DEPARTMENTS])->first(),
            'columbarium_notification_individuals_ids'       => Settings::where(['name' => Settings::KEY_COLUMBARIUM_NOTIFICATION_INDIVIDUALS])->first(),
            'columbarium_update_departments_ids'             => Settings::where(['name' => Settings::KEY_COLUMBARIUM_UPDATE_DEPARTMENTS])->first(),
            'columbarium_update_individuals_ids'             => Settings::where(['name' => Settings::KEY_COLUMBARIUM_UPDATE_INDIVIDUALS])->first(),
            
            
            'inventory_edit_individuals_ids'                => Settings::where(['name' => Settings::KEY_INVENTORY_EDIT_INDIVIDUALS])->first(),
            'inventory_delete_individuals_ids'              => Settings::where(['name' => Settings::KEY_INVENTORY_DELETE_INDIVIDUALS])->first(),
            'inventory_edit_departments_ids'                => Settings::where(['name' => Settings::KEY_INVENTORY_EDIT_DEPARTMENTS])->first(),
            'inventory_delete_departments_ids'              => Settings::where(['name' => Settings::KEY_INVENTORY_DELETE_DEPARTMENTS])->first(),
              
            'users'                                 => User::all(),
            'departments'                           => Department::all(),
            'companies'                             => Company::all(),
            'gemstones'                             => GemstoneOrders::select("term_condition")->where("user_id", $user->id)->first(),
            
            'product_categories'                   => Products::select("category")->distinct()->get(),
            'product_items'                        => Products::select("id","item","unit_price")->get(),

            'niche'                                => Settings::where(['name' => Settings::KEY_NICHE])->first(),
            'gemstone_terms_conditions'            => Settings::where(['name' => Settings::KEY_GEMSTONE_TERMS_CONDITIONS])->first(),
        ];
        
        $arrElems = array("hearse","ala_carte","columbarium","individual_sales","parlour","scc_buddhist", "scc_christian","scc_tidbits","scc_tentage","scc_chanting","far");
        foreach($arrElems as $elem){
            if ($elem == "hearse"){
                $args[$elem]["items"] = Hearses::where("is_deleted",0)->orderBy("name")->get()->toArray();
            }
            /*elseif($elem == "ala_carte"){
                $name = Settings::KEY_FA_ALA_CARTE_ITEMS;

                $setting = Settings::where("name", $name)->first();
                if ($setting){
                    $args[$elem]["items"] = json_decode($setting->value, true);
                }
            }
            elseif($elem == "individual_sales"){
                $name = Settings::KEY_FA_INDIVIDUAL_SALES_ITEMS;

                $setting = Settings::where("name", $name)->first();
                if ($setting){
                    $args[$elem]["items"] = json_decode($setting->value, true);
                }
            }*/
            elseif($elem == "parlour"){
                $args[$elem]["items"] = Parlours::where("is_deleted",0)->orderBy("name")->get()->toArray();
            }
            
            elseif(in_array($elem, array( "ala_carte","columbarium","individual_sales","scc_buddhist", "scc_christian","scc_tidbits","scc_tentage","scc_chanting","far"))) {  
          
                $args[$elem]["items"] = SettingsGroupedItems::where("item_type", $elem )->where("is_deleted",0)->where("group_name","!=","")->orderBy("group_name")->get()->toArray();
                $res = SettingsGroupedItems::where("item_type", $elem )->where("is_deleted",0)->where("group_name",null)->orderBy("id")->first();
                $args[$elem]["pdf"] = ($res)?$res->toArray():array();
            }
        }
       
        
        $fa_discount_settings = Settings::where('name',Settings::KEY_FA_DISCOUNT)->first();
        $args['fa_discount'] = json_decode($fa_discount_settings->value, true);
        $far_discount_settings = Settings::where('name', Settings::KEY_FA_REPATRIATION_DISCOUNT)->first();
        $args['far_discount'] = json_decode($far_discount_settings->value, true);
		$args["rosters"] = RosterSettings::where("is_deleted",0)->orderBy("id")->get();
        $args['niche_blocks'] = NicheBlock::all();

        return view('settings.index', $args);
    }

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateGemstoneTermsConditions(Request $request)
    {
        $terms = $request->get('terms');
        $gemstone_setting = Settings::where('name', Settings::KEY_GEMSTONE_TERMS_CONDITIONS)->get()->first();
        $gemstone_setting->value = $terms;
        $gemstone_setting->save();
        $msg = "Save Successfully!";
        return $msg;
    }
    public function updateSecretKey(Request $request)
    {
        $secret_key = Settings::where(['name' => 'secret_key'])->first();
        $new_value = $request->get('secret_key');

        if (!$secret_key || $new_value === null) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Wrong Request',
            ]);
        }

        $secret_key->value = $new_value;
        $secret_key->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Saved',
        ]);
    }

    /**
     * Edit company
     * @param integer $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateCompany($id, Request $request)
    {
        $company = Company::find($id);
        $name = $request->get('company_name');

        if (!$company || $name === null) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Wrong Request',
            ]);
        }

        $company->name = $name;
        $company->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Saved',
        ]);
    }

    /**
     * Edit department
     * @param integer $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateDepartment($id, Request $request)
    {
        $department = Department::find($id);
        $name = $request->get('department_name');

        if (!$department || $name === null) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Wrong Request',
            ]);
        }

        $department->name = $name;
        $department->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Saved',
        ]);
    }

    /**
     * Create new department
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function createDepartment(Request $request)
    {
        $department = new Department;
        $name = $request->get('department_name');

        if ($name === null) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Wrong Request',
            ]);
        }

        $department->name = $name;
        $department->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Saved',
        ]);
    }

    /**
     * update settings
     * @param integer $did
     * @param integer $uid
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateShifting($did, $uid, Request $request)
    {
        $dSetting = Settings::find($did);
        $uSetting = Settings::find($uid);
        $departments_ids = $request->get('departments_ids');
        $users_ids = $request->get('users_ids');

        if (!$dSetting || !$uSetting) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Wrong Request',
            ]);
        }

        $uSetting->value = implode(',', $users_ids);
        $uSetting->save();
        $dSetting->value = implode(',', $departments_ids);
        $dSetting->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Saved',
        ]);
    }

    public function updateFASetting($did, $uid, Request $request)
    {
        $dSetting = Settings::find($did);
        $uSetting = Settings::find($uid);
        $departments_ids = $request->get('departments_ids');
        $users_ids = $request->get('users_ids');

        if (!$dSetting || !$uSetting) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Wrong Request',
            ]);
        }

        if ($users_ids){
            $uSetting->value = implode(',', $users_ids);
            $uSetting->save();
        }
        if ($departments_ids){
            $dSetting->value = implode(',', $departments_ids);
        }
        $dSetting->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Saved',
        ]);
    }
    
    public function updateGemstoneSetting($did, $uid, Request $request)
    {
        $dSetting = Settings::find($did);
        $uSetting = Settings::find($uid);
        $departments_ids = $request->get('departments_ids');
        $users_ids = $request->get('users_ids');

        if (!$dSetting || !$uSetting) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Wrong Request',
            ]);
        }

        if ($users_ids){
            $uSetting->value = implode(',', $users_ids);
            $uSetting->save();
        }
        if ($departments_ids){
            $dSetting->value = implode(',', $departments_ids);
        }
        $dSetting->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Saved',
        ]);
    }

    public function updateColumbariumSetting($did, $uid, Request $request)
    {
        $dSetting = Settings::find($did);
        $uSetting = Settings::find($uid);
        $departments_ids = $request->get('departments_ids');
        $users_ids = $request->get('users_ids');

        if (!$dSetting || !$uSetting) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Wrong Request',
            ]);
        }

        if ($users_ids){
            $uSetting->value = implode(',', $users_ids);
            $uSetting->save();
        }
        if ($departments_ids){
            $dSetting->value = implode(',', $departments_ids);
        }
        $dSetting->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Saved',
        ]);
    }
    
    public function updateInventorySetting($did, $uid, Request $request)
    {
        $dSetting = Settings::find($did);
        $uSetting = Settings::find($uid);
        $departments_ids = $request->get('departments_ids');
        $users_ids = $request->get('users_ids');

        if (!$dSetting || !$uSetting) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Wrong Request',
            ]);
        }

        if ($users_ids){
            $uSetting->value = implode(',', $users_ids);
            $uSetting->save();
        }
        if ($departments_ids){
            $dSetting->value = implode(',', $departments_ids);
        }
        $dSetting->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Saved',
        ]);
    }
    
    public function getItemsSetttings( Request $request ){
        
        $session = new Session();
        $session->set("rfs",1);
        
        $data = array();
        $data["elem"] = $request->get("elem");
        
        $data["items"] = array();
        if ($request->get("elem") == "hearse"){
            $data["items"] = Hearses::where("is_deleted",0)->orderBy("name")->get()->toArray();
        }

        elseif($request->get("elem") == "parlour"){
			$completedData=array();
			$preDate = Parlours::where("is_deleted",0)->orderBy("name")->get()->toArray();
			foreach($preDate as $key => $eachData){
				//var_dump($eachData['image']);exit;
				if($eachData['image'] !=""){
					$eachImageName = explode("|",$eachData['image']);
					for($i=0;$i<count($eachImageName)-1;$i++){
						$completedData[$key]['image'][]=$eachImageName[$i];
					}
				}else{
					$completedData[$key]['image'][]="";
				}
				$completedData[$key]['id'] = $eachData['id'];
				$completedData[$key]['name'] = $eachData['name'];
				$completedData[$key]['unit_price'] = $eachData['unit_price'];
				$completedData[$key]['created_at'] = $eachData['created_at'];
				$completedData[$key]['is_deleted'] = $eachData['is_deleted'];
				$completedData[$key]['updated_at'] = $eachData['updated_at'];
			}
            $data["items"] = $completedData;
			
			//var_dump($data);exit;
        }
                            //for point 5                                                                                                                             //for point 5
        elseif(in_array($request->get("elem"), array("ala_carte","columbarium","individual_sales","scc_buddhist","scc_christian","scc_tidbits","scc_tentage","scc_chanting","far","culumbarium"))){
            $data["items"] = SettingsGroupedItems::where("item_type", $request->get("elem") )->where("is_deleted",0)->where("group_name","!=","")->orderBy("id")->get()->toArray();
            $res = SettingsGroupedItems::where("item_type", $request->get("elem") )->where("is_deleted",0)->where("pdf","!=","")->orderBy("id")->first();
            $data["pdf"] = ($res)?$res->toArray():array();
        }

        return view('settings.items_settings', $data); 
    }
    
    public function saveItemsSetttings( Request $request ){
        
        
        	//var_dump($request->all());exit;
        $data = array();
        
        
        $createNew = true;  
        $oldImage = "";
		
        if ($request->get("elem") == "hearse"){
            if ($request->get("order_nr") != ""){
                $hearse = Hearses::find($request->get("order_nr"));
                if ($hearse->name == $request->get("hearse_name") && $hearse->unit_price == $request->get("unit_price") && !$request->hasFile('image') ){
                    $createNew = false;
                }
                else{
                    $hearse->is_deleted = 1;
                    $hearse->save();
                    $oldImage = $hearse->image;
                }
            }
            if ($createNew || !$hearse){
                $hearse = new Hearses();
            }
            
            $imageName = "";
            if ($request->hasFile('image')){
                $createNew = true;
                $file = Input::file('image');
                if ($file){
                    $destinationPath = public_path()."/uploads/hearse";

                    if (!is_dir($destinationPath)){
                        mkdir($destinationPath);
                    } 

                    $rules = array();
                    $validator = Validator::make(array('file'=> $file), $rules);
                    if($validator->passes()){
                        $file->move($destinationPath, $file->getClientOriginalName());
                        $hearse->image = "hearse/".$file->getClientOriginalName();                                                           
                    }
                }
            }
            elseif($oldImage){
                $hearse->image = $oldImage;                                                           
            }
            $hearse->name = $request->get("hearse_name");
            $hearse->unit_price = $request->get("unit_price");
            $hearse->save();
        } 
        elseif ($request->get("elem") == "parlour"){
            if ($request->get("order_nr") != ""){
                $parlour = Parlours::find($request->get("order_nr"));
			
                if ($parlour->name == $request->get("hearse_name") && $parlour->unit_price == $request->get("unit_price") && !$request->hasFile('image') ){
                    $createNew = false;
                }
                else{
                    $parlour->is_deleted = 1;
                    $parlour->save();
                    $oldImage = $parlour->image;
                }
            }
            if ($createNew || !$parlour){
                $parlour = new Parlours();
            }
   //////////////////////////         
            $imageName = "";
		//	var_dump($request->hasFile('image'));exit;
            if ($request->hasFile('image')){
                $file = Input::file('image');
				
                if ($file){
                    $destinationPath = public_path()."/uploads/parlour";

                    if (!is_dir($destinationPath)){
                        mkdir($destinationPath);
                    } 
					$savedImageName = "";
                    $rules = array();
                    $validator = Validator::make(array('file'=> $file), $rules);
                    if($validator->passes()){
						foreach($file as $files){ 
                        $files->move($destinationPath, $files->getClientOriginalName());
						$savedImageName .="parlour/".$files->getClientOriginalName()."|";
                       // $parlour->image = "parlour/".$files->getClientOriginalName();  
						}
						$parlour->image = $savedImageName;  
                    }
                }
            }
            elseif($oldImage){
                $parlour->image = $oldImage;                                                           
            }
            $parlour->name = $request->get("parlour_name");
            $parlour->capacity = $request->get("capacity");
            $parlour->unit_price = $request->get("unit_price");
            $parlour->save();
        } 
        elseif(in_array($request->get("elem"), array("ala_carte","columbarium","individual_sales","scc_buddhist","scc_christian","scc_tidbits","scc_tentage","scc_chanting","far"))){
           
           // var_dump($request->all());exit;
            if ($request->get("id") != ""){
                $item = SettingsGroupedItems::find($request->get("id"));
                /*  get Previous images*/
                $oldImage = $item->image ;
            }
            if (!isset($item)){
                $item = new SettingsGroupedItems();
                $item->item_type = $request->get("elem");
            }
            $fileName = "";
            if ($request->hasFile('file')){
                $file = Input::file('file');
                
                if ($file){
                    $destinationPath = public_path()."/uploads/settings";

                    if (!is_dir($destinationPath)){
                        mkdir($destinationPath);
                    } 

                    $rules = array();
                    $validator = Validator::make(array('file'=> $file), $rules);
                
                    if($validator->passes()){
                        $file->move($destinationPath, $file->getClientOriginalName());
                        
                        if ($item->pdf && $item->pdf != "error"){
                            unlink(public_path() . "/uploads/".$item->pdf);
                        }
                        
                        $item->pdf = "settings/".$file->getClientOriginalName();                                                           
                    }
                }
            }
            else{
                if ($request->get("file")){
                    $item->pdf = "error";
                }
                else{
                    
             /* For point 1 :  Add multiple images for Ala_carte. Same function parlour */   
                    
                     if ($request->hasFile('image')){
                        $file = Input::file('image');
                       
                        if ($file){
                            $destinationPath = public_path()."/uploads/ala_carte";

                            if (!is_dir($destinationPath)){
                                mkdir($destinationPath);
                            } 
                                                $savedImageName = "";
                            $rules = array();
                            $validator = Validator::make(array('file'=> $file), $rules);
                            if($validator->passes()){
                                                        foreach($file as $files){ 
                                $files->move($destinationPath, $files->getClientOriginalName());
                                                        $savedImageName .="ala_carte/".$files->getClientOriginalName()."|";
                               
                                                        }
                                                        $item->image = $savedImageName;  
                            }
                        }
                     } elseif($oldImage){
                          $item->image = $oldImage;                                                           
                     }
             /*  End */
                     
                    if ($request->get("elem") == "far" || $request->get("elem") == "individual_sales"){
                        $item->group_name = $request->get("package_name");
                    }
                    else{
                        $item->group_name = $request->get("category_name");
                    }
                    $item->selection_category = $request->get("selection_category");
                    $item->selection_item_id = $request->get("selection_item_id");
                    $item->selection_item_name = $request->get("selection_item_name");
                    $item->unit_price = $request->get("unit_price");
                }
            }
            $item->save();
        }
        
    }
    
    public function deleteItemsSetttings( Request $request ){
        
        $session = new Session();
        $session->set("rfs",1);
        
        if ($request->get("elem") == "hearse"){
            $hearse = Hearses::find($request->get("id"));
            if ($hearse){
                $hearse->is_deleted = 1;
                $hearse->save();
            }
        }
        elseif($request->get("elem") == "parlour"){
            $parlour = Parlours::find($request->get("id"));
            if ($parlour){
                $parlour->is_deleted = 1;
                $parlour->save();
            }
        }
        elseif(in_array($request->get("elem"), array("scc_buddhist","scc_christian","scc_tidbits","scc_tentage","scc_chanting","far","individual_sales","ala_carte","columbarium"))){
            $item = SettingsGroupedItems::find($request->get("id"));
            if ($item){
                $item->is_deleted = 1;
                $item->save();
            }
        }
    }
    
    public function searchInventoryCategory( Request $request ){
        $session = new Session();
        $session->set("rfs",1);
        
        $results = \App\Products::select("category")->where('category','like','%'.$request->get('term').'%')->distinct()->orderby('category')->get()->toArray();
        $arrResponse = array();
        foreach ($results as $key => $result){
            foreach($result as $propName => $propValue){
               $arrResponse[$key][$propName] = $propValue;
            }
        }
        return response()->json($arrResponse);
    }
    
    public function searchInventoryItem( Request $request ){
        $session = new Session();
        $session->set("rfs",1);
        
        $results = \App\Products::where('item','like','%'.$request->get('term').'%')->where("category",$request->get('category'))->orderby('item')->get()->toArray();
        $arrResponse = array();
        foreach ($results as $key => $result){
           foreach($result as $propName => $propValue){
               $arrResponse[$key][$propName] = $propValue;
           }
        }
        return response()->json($arrResponse);
    }
    
    
    public function searchFASalesPackage( Request $request ){
        $session = new Session();
        $session->set("rfs",1);
        
        $packagesObj = Settings::where('name',Settings::KEY_FA_SALES_PACKAGES)->first();
        $arrPackages = json_decode($packagesObj->value, true);
        $results = array();
        if (is_array($arrPackages)){
            foreach($arrPackages as $name){
                if ($request->get('term') == "" || strpos($name, $request->get('term')) > -1){
                    $results[] = $name;
                }
            }
        }
        sort($results);
        return response()->json($results);
    }
    
    public function searchGroupName( Request $request ){
        $session = new Session();
        $session->set("rfs",1);
        
        $categories = SettingsGroupedItems::selectRaw('group_name as category')->where("item_type", $request->get("elem"))->where('group_name','like','%'.$request->get('term').'%')->distinct()->orderBy("group_name")->get()->toArray();
        if (is_array($categories)){
            return response()->json($categories);
        }
        else{
            return response()->json(array());
        }
    }
    
    public function saveDiscount( Request $request ){
        if ($request->get("elem") == "fa"){
            $discounts = Settings::where('name',Settings::KEY_FA_DISCOUNT)->first();
        }
        else{
            $discounts = Settings::where('name',Settings::KEY_FA_REPATRIATION_DISCOUNT)->first();
        }
        $arrDiscounts = json_decode( $discounts->value, true);
        $arrDiscounts[$request->get("inc")] = $request->get("value");
     
        $discounts->value = json_encode($arrDiscounts);
        if ($discounts->save()){
            return response()->json(array("msg"=>"ok"));
        }
        return response()->json(array());
    }
    
    public function deleteDiscount( Request $request ){
        if ($request->get("elem") == "fa"){
            $discounts = Settings::where('name',Settings::KEY_FA_DISCOUNT)->first();
        }
        else{
            $discounts = Settings::where('name',Settings::KEY_FA_REPATRIATION_DISCOUNT)->first();
        }
        $arrDiscounts = json_decode( $discounts->value, true);
        unset($arrDiscounts[$request->get("inc")]);
        $discounts->value = json_encode($arrDiscounts);
        if ($discounts->save()){
            return response()->json(array("msg"=>"ok"));
        }
        return response()->json(array());
    }
    
    
    public function editPackage( Request $request ){
        $session = new Session();
        $session->set("rfs",1);
        
        $data = array();
        $data["id"] = $request->get("id","");
        if ($request->get("id")){
            $data["package"] = Packages::find($request->get("id"));
        }
        else{
            $data["package"] = new Packages();
        }
        return view('settings.edit_package', $data);
    } 
	
	public function editRosterSettings( Request $request ){
        $session = new Session();
        $session->set("rfs",1);
        $roster = new RosterSettings();
        $data = array();
        $data["id"] = $request->get("id","");
        if ($request->get("id")){
            $data["roster"] = RosterSettings::find($request->get("id"));
        }
        else{
            $data["roster"] = new RosterSettings();
        }
		return view('settings.edit_roster_settings', $data);
    }
    
    public function savePackage( Request $request ){
        $data["id"] = $request->get("id","");
        if ($request->get("act") == "edit_item"){
            $package = Packages::find($request->get("id"));
            
            $createNew = true;
            $oldImage = ""; 
            $image2save = "";
            $newImage = "";
            
            if ($request->hasFile('image')){
                $file = Input::file('image');
                if ($file){
                    $destinationPath = public_path()."/uploads/fa_packages";

                    if (!is_dir($destinationPath)){
                        mkdir($destinationPath);
                    } 

                    $rules = array();
                    $validator = Validator::make(array('file'=> $file), $rules);
                    if($validator->passes()){
                        $file->move($destinationPath, $file->getClientOriginalName());
                        $newImage = "fa_packages/".$file->getClientOriginalName();                                                           
                    }
                }
            }
            
            
            if ($request->get("item_id")){
                $oldItem = PackageItems::find($request->get("item_id"));
                
                
                
                
                if ($request->get("section_name") == $oldItem->section_name && $request->get("category_name") == $oldItem->category_name && 
                    $request->get("selection_category_name") == $oldItem->selection_category && $request->get("selection_item") == $oldItem->selection_item &&
                    $request->get("usual_price") == $oldItem->usual_price && $request->get("package_price") == $oldItem->package_price &&
                    $request->get("add_on_price") == $oldItem->add_on_price && !$request->hasFile('image')){
                    $createNew = false;
               
                }    
                if ($createNew){
                    $oldItem->is_deleted = 1;
                    $oldItem->save();
                
                    if(!$request->hasFile('image') && empty($newImage)){
                        $newImage = $oldItem->image;
                    }
                }
               
            }
            
            if ($createNew){
               
                $item = new PackageItems();
                $item->fa_package_id = $request->get("id");
                $item->section_name = $request->get("section_name");
                $item->category_name = $request->get("category_name");
                $item->selection_category = $request->get("selection_category");
                $item->selection_item_name = $request->get("selection_item_name");
                $item->selection_item_id = $request->get("selection_item_id");
                $item->usual_price = $request->get("usual_price");
                $item->package_price = $request->get("package_price");
                $item->add_on_price = $request->get("add_on_price");
                $item->image = $newImage;
                $item->save();
            }
        }
        else{
            if ($request->get("name")){
                $package = new Packages();
                $createNew = true;
                if ($request->get("id")){
                    $oldPackage = Packages::find($request->get("id"));


                    if ($request->get("category") == $oldPackage->category && $request->get("name") == $oldPackage->name && 
                        $request->get("original_price") == $oldPackage->original_price && $request->get("promo_price") == $oldPackage->promo_price){
                        $createNew = false;
                    }

                    if ($createNew){                               
                        $package->category = $oldPackage->category;
                        $package->name = $oldPackage->name;
                        $package->original_price = $oldPackage->original_price;
                        $package->promo_price = $oldPackage->promo_price;
                        $oldPackage->is_deleted = 1;
                        $oldPackage->save();
                    }
                }

                if ($createNew){
                    $package->category = $request->get("category");
                    $package->name = $request->get("name");
                    $package->original_price = $request->get("original_price");
                    $package->promo_price = $request->get("promo_price");
                    $package->save();
                    $data["id"] = $package->id;
                    
                    
                    if (!empty($oldPackage)){
                        $pItems = $oldPackage->items();
                        foreach($pItems as $item){                           
                            $newItem = new PackageItems();
                            $newItem->fa_package_id = $package->id;
                            $newItem->section_name = $item->section_name;
                            $newItem->category_name = $item->category_name;
                            $newItem->selection_category = $item->selection_category;
                            $newItem->selection_item_name = $item->selection_item_name;
                            $newItem->selection_item_id = $item->selection_item_id;
                            $newItem->usual_price = $item->usual_price;
                            $newItem->package_price = $item->package_price;
                            $newItem->add_on_price = $item->add_on_price;
                            $newItem->image = $item->image;
                            $newItem->save();
                        }
                    }
                }

                if (!$createNew){
                    $package = $oldPackage;
                }
            }
            else{
                $package = new Packages();
            }
        }
        $data["package"] = $package;
        return view('settings.edit_package', $data);
    }
    
	 public function saveRosterSettings( Request $request ){
               $add_to_roster = $request->get("add_to_roster");
               if ($request->get("team_name") && $request->get("team_leader") && $request->get("embalmers") && $request->get("others") && $add_to_roster!=''){
                $rostersetting = new RosterSettings();
                $createNew = true;
				$team_name = $request->get("team_name");
				$already_team = RosterSettings::where("team_name",$team_name)
				                ->where('is_deleted',0)
				                ->get()->count();
               
				if ($already_team>0){
					    $createNew = false;
                        $var = array("result"=>"failure","message"=>"Team Name already exist. Please choose another name.");
                }
					
                if ($createNew){
					if($add_to_roster==1){
					$countrosterSetting = RosterSettings::where("add_to_roster",1)
					                      ->where('is_deleted',0)
					                      ->orderBy("add_to_roster")->get()->count();
					}else{
					$countrosterSetting = 5;
					}
					if($countrosterSetting<=5){
                    $rostersetting->team_name = $request->get("team_name");
                    $rostersetting->team_leader = implode(",",$request->get("team_leader"));
                    $rostersetting->embalmers = implode(",",$request->get("embalmers"));
                    $rostersetting->others = implode(",",$request->get("others"));
                    $rostersetting->add_to_roster = $request->get("add_to_roster");
                    $rostersetting->save();
                    $data["id"] = $rostersetting->id;
						if($data["id"]>0){
							$var = array("result"=>"success","message"=>"Team added successfully.");
						}else{
							$var = array("result"=>"failure","message"=>"Action failure! Please Try again.");
						}
					}else{
						$var = array("result"=>"failure","message"=>"Sorry! Only 6 Teams are added into roster.");
					}
                }

                if (!$createNew){
                    $var = array("result"=>"failure","message"=>"Team Name already exist. Please choose another name.");
                }
            }
            else{
               $var = array("result"=>"failure","message"=>"Please fill all fields.");
            }
        
        echo json_encode($var);
		die;
    }
	
	 public function updateRosterSettings( Request $request)
    {
		$id = $request->input("id");
        $rostersettings = RosterSettings::find($id);
	

        $rostersettings->team_name = $request->input('team_name');
        $rostersettings->team_leader = implode(",",$request->input('team_leader'));
        $rostersettings->embalmers = implode(",",$request->input('embalmers'));
        $rostersettings->others = implode(",",$request->input('others'));
        $rostersettings->add_to_roster = $request->input('add_to_roster');
        $rostersettings->save();

        return redirect()->back();
    }
	
	
    public function deletePackage( Request $request ){
        $session = new Session();
        $session->set("rfs",1);
        
        $package = Packages::find($request->get("id"));
        $package->is_deleted = 1;
        return ($package->save())?"ok":"";
    }
	
	public function deleteRosterSettings( Request $request ){
        $session = new Session();
        $session->set("rfs",1);
        
        $rosterpckg = RosterSettings::find($request->get("id"));
        $rosterpckg->is_deleted = 1;
        return ($rosterpckg->save())?"ok":"";
    }
    
    public function deletePackageItem( Request $request ){
        $session = new Session();
        $session->set("rfs",1);
        
        
        $item = PackageItems::find($request->get("id"));
        $package = Packages::find($item->fa_package_id);
        $item->is_deleted = 1;
        $item->save();
        
        $data["package"] = $package;
        $data["id"] = $package->id;
        return view('settings.edit_package', $data);
    }
    
    public function getPackagesList(){
        $session = new Session();
        $session->set("rfs",1);
        
        $data = array();
		$data['users'] = User::all();
        $data['canUpdate'] = false;
        $data["packages"] = Packages::where("is_deleted",0)->orderBy("id")->get();
        return view('settings.list_packages', $data);
    } 

	public function getRosterSettings(){
        $session = new Session();
        $session->set("rfs",1);
        
        $data = array();
        $data["rosters"] = RosterSettings::where("is_deleted",0)->orderBy("id")->get();
		return view('settings.list_roster_settings', $data);
    } 
	
	public function getUsersList(){
		$args = [];

        $args['users'] = User::all();
        $args['departments'] = Department::all();

        $args['supervisors'] = [];
        foreach ($args['users'] as $user) {
            if ($user->is_supervisor) {
                $args['supervisors'][$user->id] = $user;
            }
        }
        $args['managers'] = User::all();
        
        return view('settings.list_users', $args);
    }
    
    //For point 2 
    public function getAllImageForPopup(Request $request) {
        
        
        
        $data = array();
        $strRaw = "is_deleted = 0 and item_type = 'ala_carte' ";
        $elementType = $request->get("elementType");
        
        if($elementType == "add_coffin_catalog"){
            $strRaw .=" and selection_category like 'Coffin (%'";
        }else if($elementType == "add_backdrop"){
            $strRaw .=" and selection_category like 'Backdrop'";
        }else if($elementType == "add_urns"){
            $strRaw .=" and selection_category like 'urns'";
        }else if($elementType == "add_burial_plot"){
            $strRaw .=" and selection_category like 'Burial Plot'";
        }else if ($elementType == "add_gem_stones"){
            $strRaw .=" and selection_category like 'Gemstone'";
        }else if ($elementType == "add_columbarium"){
            $strRaw ="is_deleted =0 and item_type ='columbarium' and selection_category like 'Columbarium'";
        }else{
            $strRaw ="is_deleted =0 and item_type ='far' and selection_category like 'Coffin' and group_name like 'Coffin'";
        }
          
        $data["items"] = SettingsGroupedItems::whereRaw($strRaw)->orderBy("unit_price","ASC")->get()->toArray();
        $data["is_popup"] = 1;
        
        if($elementType =="add_columbarium"){
                return view('columbarium/popup', $data);
        }else{
                return view('funeral_arrangement/popup', $data);
        }
    }
    
    public function getAllImages(Request $request) {
            
        $id = $request->get("id");
        $result = SettingsGroupedItems::where("id",$id)->get();
    
       
        $images = explode("|", $result[0]->image);
       
        die(json_encode($images));
    }
    
    public function deletePdf(Request $request){
        
        $id = $request->get("id");
       
       
        $pdf= SettingsGroupedItems::where("pdf","like" ,$id)->update(["pdf"=>""]);
        
        
        if($pdf){
            die("ok");
        }
    }

}
