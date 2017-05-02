<?php

namespace App\Http\Controllers;

use App\Company;
use App\Products;
use App\Settings;
use App\StockHistory;
use App\User;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect as Redirect;
use Validator;
use Illuminate\Support\Facades\Input as Input;

class InventoryController extends Controller
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
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $data = array();
        $data['users'] = User::all();
        $data['user'] = $user;



        $data['categories'] = Products::where('is_deleted', 0)->groupBy('category')->select('category')->orderby('category')->get();
        //return $data['categories'];
        
        $can_edit = false;
        $can_delete = false;
        
        $settingDeleteDep = Settings::where("name", Settings::KEY_INVENTORY_DELETE_DEPARTMENTS)->first();
        if (in_array($user->department_id,explode(",",$settingDeleteDep->value))){
            $can_delete = true;
        }
        else{
            $settingDeleteInd = Settings::where("name", Settings::KEY_INVENTORY_DELETE_INDIVIDUALS)->first();
            if (in_array($user->id,explode(",",$settingDeleteInd->value))){
                $can_delete = true;
            }
        }
        $settingEditDep = Settings::where("name", Settings::KEY_INVENTORY_EDIT_DEPARTMENTS)->first();
        if (in_array($user->department_id,explode(",",$settingEditDep->value))){
            $can_edit = true;
        }
        else{
            $settingEditInd = Settings::where("name", Settings::KEY_INVENTORY_EDIT_INDIVIDUALS)->first();
            if (in_array($user->id,explode(",",$settingEditInd->value))){
                $can_edit = true;
            }
        }
        
        $data["can_edit"] = $can_edit;
        $data["can_delete"] = $can_delete;
        return view('inventory.index', $data);
    }

    public function filter(Request $request) {
        $user = Auth::user();
        $data = array();
        //$data['users'] = User::all();
        $data['user'] = $user;

        //For Filter
        $data['search_word'] = $request->get('search_word');
        //return $request->get('filter_companies');

        if(count($request->get('filter_companies')) > 0)
            $data['filter_companies'] = $request->get('filter_companies');
        /*else
            $data['filter_companies'] = Company::all()->pluck('id')->toArray();*/

        if(count($request->get('filter_categories')) > 0)
            $data['categories'] = $request->get('filter_categories');
        else
            $data['categories'] = Products::where('is_deleted', 0)->groupBy('category')->orderby('category')->get()->pluck('category')->toArray();

        $can_edit = false;
        $can_delete = false;

        $settingDeleteDep = Settings::where("name", Settings::KEY_INVENTORY_DELETE_DEPARTMENTS)->first();
        if (in_array($user->department_id,explode(",",$settingDeleteDep->value))){
            $can_delete = true;
        }
        else{
            $settingDeleteInd = Settings::where("name", Settings::KEY_INVENTORY_DELETE_INDIVIDUALS)->first();
            if (in_array($user->id,explode(",",$settingDeleteInd->value))){
                $can_delete = true;
            }
        }
        $settingEditDep = Settings::where("name", Settings::KEY_INVENTORY_EDIT_DEPARTMENTS)->first();
        if (in_array($user->department_id,explode(",",$settingEditDep->value))){
            $can_edit = true;
        }
        else{
            $settingEditInd = Settings::where("name", Settings::KEY_INVENTORY_EDIT_INDIVIDUALS)->first();
            if (in_array($user->id,explode(",",$settingEditInd->value))){
                $can_edit = true;
            }
        }

        $data["can_edit"] = $can_edit;
        $data["can_delete"] = $can_delete;


        //return $date['companies'];
        return view('inventory.filter', $data);

    }

    public function getListing(){
        $data["products"] = \App\Products::orderby("category")->get();
        return view('inventory.list', $data);
    }

    public function transferData(Request $request){
        $user = Auth::user();
        $product_id = $request->get("product_id");
        $from = $request->get("from_stock");
        $to = $request->get("to_stock");
        $quantities = $request->get("quantities");
        $transfer_date = $request->get("transfer_date");

        if($request->get("transfer_user"))
            $user_id = $request->get("transfer_user");
        else
            $user_id = $user->id;

        $product = Products::find($product_id);

        if($from == "w") {
            if($product->warehouse < $quantities)
                return Redirect::to('/inventory');
            else {
                $product->warehouse = $product->warehouse - $quantities;
                $product->store_room = $product->store_room + $quantities;
            }
        } else if($from == "s") {
            if($product->store_room < $quantities)
                return Redirect::to('/inventory');
            else {
                $product->store_room = $product->store_room - $quantities;
                $product->warehouse = $product->warehouse + $quantities;
            }
        }

        $behavior = "transfer";

        $product->save();

        // HISTORY
        $history = new StockHistory();
        $history->product_id = $product->id;
        $history->user_id = $user_id;
        $history->behavior = $behavior;
        $history->type = "inventory";
        $history->balance_w = $product->warehouse;
        $history->balance_s = $product->store_room;
        $history->remarks = "Transfer Stock";
        $history->editable_date_modif = date('Y-m-d H:i:s');
        if($from == "w") {
            $history->warehouse = -1 * $quantities;
            $history->store_room = $quantities;

        } else {
            $history->warehouse = $quantities;
            $history->store_room = -1 * $quantities;
        }
        $history->save();

        return Redirect::to('/inventory');
    }

    public function saveData(Request $request){
        $errors = 0;
        $msg = array();
        $record_history = true;
        $user = Auth::user(); 
        if ($request->get("category")){
            $can_edit = false;
            $settingEditDep = \App\Settings::where("name", \App\Settings::KEY_INVENTORY_EDIT_DEPARTMENTS)->first();
            if (in_array($user->department_id,explode(",",$settingEditDep->value))){
                $can_edit = true;
            }
            else{
                $settingEditInd = \App\Settings::where("name", \App\Settings::KEY_INVENTORY_EDIT_INDIVIDUALS)->first();
                if (in_array($user->id,explode(",",$settingEditInd->value))){
                    $can_edit = true;
                }
            }
            if (!$can_edit){
                return Redirect::to('/inventory');
            }
        }
        
        
        $product_id = $request->get("product_id");
        //set behavior



        if ($product_id){
            $product = \App\Products::find($product_id);
            $behavior = "add more";
        }
        else{
            $product = new \App\Products();
            if($request->get("unlimited_stock") == 1)
                $behavior = "new unlimited inventory";
            else
                $behavior = "new inventory";
        }

        $product->save();
        
        $info2save = $request->all();
        
        // SAVE FILE
        $file = null;
        if ($request->hasFile('image')){
            unset($info2save["image"]);
            $file = Input::file('image');
            if ($file){
                $destinationPath = public_path()."/uploads/products/";

                if (!is_dir($destinationPath)){
                    mkdir($destinationPath);
                } 

                $rules = array();
                $validator = Validator::make(array('file'=> $file), $rules);
                if($validator->passes()){
                    $file->move($destinationPath, $file->getClientOriginalName());
                    $product->image = $file->getClientOriginalName();                                                           
                }
                
                /*
                if (!is_file($destinationPath."/".$file->getClientOriginalName())){
                    $errors++;
                    $msg[] = "Error saving file";
                }*/
            }
        }


        // SAVE DATA

        
        if (isset($info2save["location"])){
            if ($info2save["location"] == 1){
                $info2save["warehouse"] = $product->warehouse + ((isset($info2save["add_quantity"]))?$info2save["add_quantity"]: (-1 * $info2save["damage_quantity"]));  
            }
            else{
                $info2save["store_room"] = $product->store_room + ((isset($info2save["add_quantity"]))?$info2save["add_quantity"]:(-1 * $info2save["damage_quantity"]));
            }
        }

        if($product->warehouse == $info2save["warehouse"] && $product->store_room == $info2save["store_room"] && $info2save["unlimited_stock"] != 1) {
            $record_history = false;
        }

        if (isset($info2save["damage_quantity"])){
            $behavior = "damage";
            unset($info2save["remarks"]);
        }

        $columns = \Schema::getColumnListing("products");
        foreach( $info2save as $key => $value ){
            if (in_array($key, $columns) ){
                if($key == "companies")
                    $product->{$key} = implode(",",$value);
                else
                    $product->{$key} = $value;
            }
        }

        $product->save();

        //return $request->get("remarks");
        
        // HISTORY
        if($record_history) {
            $history = new \App\StockHistory();
            $history->product_id = $product->id;
            $history->behavior = $behavior;
            $history->user_id = (isset($info2save["add_quantity"]) || isset($info2save["damage_quantity"]))?$request->get("user_modif"):$user->id;
            $history->warehouse = isset($info2save["warehouse"])?$info2save["warehouse"]:0;
            $history->store_room = isset($info2save["store_room"])?$info2save["store_room"]:0;
            $history->remarks = !empty($request->get("remarks"))?$request->get("remarks"):$behavior;
            $history->editable_date_modif = date('Y-m-d H:i:s');
            $history->type = "inventory";
            $history->balance_w = $product->warehouse;
            $history->balance_s = $product->store_room;
            $history->save();
        }

        
        
        return Redirect::to('/inventory');

    }
    
    public function getCategories(Request $request){
        $results = \App\Products::where('category','like','%'.$request->get('term').'%')->orderby('category')->get();
        $arrResponse = array();
        foreach ($results as $key => $result){
            $arrResponse[$key] = $result->category;
        }
        return response()->json($arrResponse);
    }
    
    public function checkLowStock(){
        $user = Auth::user();
        $all = array();
        if ($user->department_id == 2){
            $all = \App\Products::getLowStockProducts();
        }
        return response()->json($all);
    }
    
    
    public function deleteProduct($id){
        
        $user = Auth::user();
        $can_delete = false;
        $settingDeleteDep = \App\Settings::where("name", \App\Settings::KEY_INVENTORY_DELETE_DEPARTMENTS)->first();
        if (in_array($user->department_id,explode(",",$settingDeleteDep->value))){
            $can_delete = true;
        }
        else{
            $settingDeleteInd = \App\Settings::where("name", \App\Settings::KEY_INVENTORY_DELETE_INDIVIDUALS)->first();
            if (in_array($user->id,explode(",",$settingDeleteInd->value))){
                $can_delete = true;
            }
        }

        if ($can_delete){
            if ($id){
                $prod = \App\Products::find($id);
                $prod->is_deleted = 1;
                $prod->save();
            }
        }
        return Redirect::to('/inventory');
    }
    
    public function getProduct($id){
        $prod = array();
        if ($id){
            $prod = \App\Products::find($id)->toArray();
        }
        return response()->json($prod);
    }

    public function viewRecords(Request $request){
        //$data = $request->all();
        $data["histories"] = StockHistory::all();
        $data['categories'] = Products::where('is_deleted', 0)->groupBy('category')->select('category')->orderby('category')->get();
        $data["companies"] = Company::all();
        return view('inventory/records', $data);
    }

    public function filterRecords(Request $request){
        $start_date = $request->get('start_date');

        if(!empty($start_date)) {
            $date = str_replace('/', '-', $start_date);
            $start_date = date("Y-m-d", strtotime($date));
            $start_date .= " 00:00:00";
        }

        //dd($start_date);
        $end_date = $request->get('end_date');
        if(!empty($end_date)) {
            $date = str_replace('/', '-', $end_date);
            $end_date =  date('Y-m-d', strtotime($date));
            $end_date .= " 23:59:59";
        }


        $type = $request->get('action_type');
        $filter_companies = $request->get('filter_company');
        $filter_categories = $request->get('filter_category');

        $histories = StockHistory::all();

        //filter type
        if (isset($type) && count($type)>0) {
            $histories = $histories->filter(function ($history) use ($type) {
                return in_array($history->type, $type);
            });
        }

        //filter category
        if (isset($filter_categories) && count($filter_categories)>0) {
            $histories = $histories->filter(function ($history) use ($filter_categories) {
                return in_array($history->product->category, $filter_categories);
            });
        }

        //filter company
        if (isset($filter_companies) && count($filter_companies)>0) {
            $histories = $histories->filter(function ($history) use ($filter_companies) {
                $companies = explode(',', $history->product->companies);
                return count(array_intersect($companies, $filter_companies)) == count($filter_companies);
            });
        }

        if(isset($start_date) && !empty($start_date)){
            $histories = $histories->filter(function($history) use ($start_date)
            {
                return $history->editable_date_modif > $start_date;
            });
        }

        if(isset($end_date) && !empty($end_date)){
            $histories = $histories->filter(function($history) use ($end_date)
            {
                return $history->editable_date_modif < $end_date;
            });
        }


        $data["histories"] = $histories;
        $data['categories'] = Products::where('is_deleted', 0)->groupBy('category')->select('category')->orderby('category')->get();
        $data["companies"] = Company::all();
        return view('inventory/record_filter', $data);
    }

}
