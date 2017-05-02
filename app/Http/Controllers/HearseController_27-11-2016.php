<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Settings;
use App\Company;
use App\Hearses;
use App\User;
use App\HearseOrders;
use DB;
use App\FuneralArrangements;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Session\Session;

class HearseController extends Controller
{
    const baseUrl = "/hearse/";
    const viewFolder = "hearse/";
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
        $data["user"] = $user;
        $data["company_prefix"] = Company::getCurrentCompanyPrefix();
        $data["items"] = Hearses::where("is_deleted",0)->orderBy("name")->get();
        
        $data["order_nr"] = sprintf("%05d",HearseOrders::getNextNumber());
        
        return view(self::viewFolder.'index', $data);
    }
    
    /**
     * Author: Jinandra
     * Date: 11-24-2016
     * Hearses allocation
     * @param array $request
     *
     * @return Json response for ajax call
     */
    public function hearseAllocation(Request $request)
    {
        $user = Auth::user();
        
        $data = array();
        $data["user"] = $user;
        
        $data["company_prefix"] = Company::getCurrentCompanyPrefix();
        $data["items"] = Hearses::where("is_deleted",0)->orderBy("name")->get();
        
        $q = \App\HearseOrders::select("*");
        if ($request->get("filter_booked_from_day")){
            $timeStr = "00:00";
            $data["filter_booked_from_day"] = $request->get("filter_booked_from_day");
            if ($request->get("filter_booked_from_time")){
                $timeStr = $request->get("filter_booked_from_time");
            }
            $dayStr = str_replace("/","-",$request->get("filter_booked_from_day"));
            $q->whereRaw("TIMESTAMP(booked_from_day, booked_from_time) >='".date("Y-m-d H:i:s", strtotime($dayStr." ".$timeStr.":00"))."'");
        }
        if ($request->get("filter_booked_to_day")){
            $timeStr = "23:59";
            $data["filter_booked_to_day"] = $request->get("filter_booked_to_day");
            if ($request->get("filter_booked_to_time")){
                $timeStr = $request->get("filter_booked_to_time");
            }
            $dayStr = str_replace("/","-",$request->get("filter_booked_to_day"));
            $q->whereRaw("TIMESTAMP(booked_to_day, booked_to_time) <='".date("Y-m-d H:i:s", strtotime($dayStr." ".$timeStr.":00"))."'");
        }
        
        if( !empty($request->get("filter_hearses")) ){
            $filter_hearsesarr = $request->get("filter_hearses");
            $data["filter_hearses"] = $filter_hearsesarr;
            $filter_hearsesstr = implode(",", $filter_hearsesarr);
            
            $q->whereRaw("hearse_id IN (".$filter_hearsesstr.")");
        }
        if ($request->get("filter_hearse_manpower")){
            $data["filter_hearse_manpower"] = $request->get("filter_hearse_manpower");
            $q->where("manpower_assigned",$request->get("filter_hearse_manpower"));
        }
        
        if ($request->get("filter_hearse")){
            $q->where("hearse_id",$request->get("filter_hearse"));
        }

        $orders = $q->get();
        
        $allUsersData = User::all();
        $data["usersdata"] = $allUsersData;        
        $data["hearsesorders"] = $orders;
        
        return view(self::viewFolder.'hearseallocation', $data);
    }
    
    public function view($id, Request $request)
    {
        $session = new Session();
        $user = Auth::user();
        
        $data = array();
        $data["user"] = $user;
        $data["company_prefix"] = Company::getCurrentCompanyPrefix();
        $data["order"] = HearseOrders::find($id);
        $data["items"] = Hearses::whereRaw("is_deleted = 0 OR id = ".$data["order"]->hearse_id)->orderBy("name")->get(); // hearse might now exists anymore so is hidden
        
        
        $data["order_nr"] = sprintf("%05d",$data["order"]->order_nr);
        $data["is_view"] = true;
        
        if ($session->get("save_msg")){
            $data["save_msg"] = $session->get("save_msg");
            $session->remove("save_msg");
        }
        
        return view(self::viewFolder.'index', $data);
    }
    
    public function pview($id, Request $request)
    {
        $session = new Session();
        $user = Auth::user();
        
        $data = array();
        $data["user"] = $user;
        $data["company_prefix"] = Company::getCurrentCompanyPrefix();
        $data["hearsesdetails"] = Hearses::find($id);
        $data["items"] = Hearses::whereRaw("is_deleted = 0 OR id = ".$id)->orderBy("name")->get(); // hearse might now exists anymore so is hidden
        
        
        $data["order_nr"] = sprintf("%05d",HearseOrders::getNextNumber());
        $data["is_view"] = true;
        $data["is_pview"] = true;
        
        if ($session->get("save_msg")){
            $data["save_msg"] = $session->get("save_msg");
            $session->remove("save_msg");
        }
        
        return view(self::viewFolder.'index', $data);
    }
    
    public function listing(Request $request)
    {
        
        $q = \App\HearseOrders::select("*");
        if ($request->get("filter_booked_from_day")){
            $timeStr = "00:00";
            if ($request->get("filter_booked_from_time")){
                $timeStr = $request->get("filter_booked_from_time");
            }
            $dayStr = str_replace("/","-",$request->get("filter_booked_from_day"));
            $q->whereRaw("TIMESTAMP(booked_from_day, booked_from_time) >='".date("Y-m-d H:i:s", strtotime($dayStr." ".$timeStr.":00"))."'");
        }
        if ($request->get("filter_booked_to_day")){
            $timeStr = "23:59";
            if ($request->get("filter_booked_to_time")){
                $timeStr = $request->get("filter_booked_to_time");
            }
            $dayStr = str_replace("/","-",$request->get("filter_booked_to_day"));
            $q->whereRaw("TIMESTAMP(booked_to_day, booked_to_time) <='".date("Y-m-d H:i:s", strtotime($dayStr." ".$timeStr.":00"))."'");
        }
        

        if ($request->get("filter_hearse")){
            $q->where("hearse_id",$request->get("filter_hearse"));
        }

        $orders = $q->get();
        $arr["data"] = array();
        foreach($orders as $order){
            $arr["data"][] = array($order->hearse_name, date("d-m-Y", strtotime($order->booked_from_day)),strtotime($order->booked_from_day), date("d-m-Y", strtotime($order->booked_to_day)),strtotime($order->booked_to_day), date("H:i", strtotime($order->booked_from_day . " ". $order->booked_from_time)),strtotime($order->booked_from_day . " ". $order->booked_from_time), date("H:i", strtotime($order->booked_to_day . " ". $order->booked_to_time)),strtotime($order->booked_to_day . " ". $order->booked_to_time), ($order->funeralArrangement)?$order->funeralArrangement->getFullCode():"", ($order->creator)?$order->creator->name:"", "<a href='".self::viewFolder.'view/'.$order->id."'>H".sprintf("%05d",$order->order_nr)."</a>");
        }

        return response()->json($arr);
    }
    
    public function hearseallclisting(Request $request)
    {
        
        $q = \App\HearseOrders::select("*");
        if ($request->get("filter_booked_from_day")){
            $timeStr = "00:00";
            if ($request->get("filter_booked_from_time")){
                $timeStr = $request->get("filter_booked_from_time");
            }
            $dayStr = str_replace("/","-",$request->get("filter_booked_from_day"));
            $q->whereRaw("TIMESTAMP(booked_from_day, booked_from_time) >='".date("Y-m-d H:i:s", strtotime($dayStr." ".$timeStr.":00"))."'");
        }
        if ($request->get("filter_booked_to_day")){
            $timeStr = "23:59";
            if ($request->get("filter_booked_to_time")){
                $timeStr = $request->get("filter_booked_to_time");
            }
            $dayStr = str_replace("/","-",$request->get("filter_booked_to_day"));
            $q->whereRaw("TIMESTAMP(booked_to_day, booked_to_time) <='".date("Y-m-d H:i:s", strtotime($dayStr." ".$timeStr.":00"))."'");
        }
        
        if ($request->get("filter_hearse_manpower")){
            $q->where("manpower_assigned",$request->get("filter_hearse_manpower"));
        }
        

        if ($request->get("filter_hearse")){
            $q->where("hearse_id",$request->get("filter_hearse"));
        }

        $orders = $q->get();
        
        $allUsersData = User::all();
        $selectQryStr = "";
        if( $allUsersData ){
            $selectQryStr = "<select class=\"form-control\" name=\"users_idsss\" data-toggle=\"select2\" multiple=\"\">";
            foreach( $allUsersData as $allUsersVal ){
                $selectQryStr.="<option value=\"".$allUsersVal->id."\">".$allUsersVal->name."</option>";
            }
            $selectQryStr.="</select>";
        }
        
        $arr["data"] = array();
        foreach($orders as $order){
            $arr["data"][] = array($order->hearse_name, date("d-m-Y", strtotime($order->booked_from_day)),strtotime($order->booked_from_day), date("d-m-Y", strtotime($order->booked_to_day)),strtotime($order->booked_to_day), date("H:i", strtotime($order->booked_from_day . " ". $order->booked_from_time)),strtotime($order->booked_from_day . " ". $order->booked_from_time), date("H:i", strtotime($order->booked_to_day . " ". $order->booked_to_time)),strtotime($order->booked_to_day . " ". $order->booked_to_time), ($order->funeralArrangement)?$order->funeralArrangement->getFullCode():"", ($order->creator)?$order->creator->name:"", "<a href='".self::viewFolder.'view/'.$order->id."'>H".sprintf("%05d",$order->order_nr)."</a>", $selectQryStr);
        }

        return response()->json($arr);
    }
    
    /**
     * Author: Jinandra
     * Date: 11-23-2016
     * Hearses availability booking on dashboard page
     * @param array $request
     *
     * @return Json response for ajax call
     */
    public function dblisting(Request $request)
    {
        
        $q = Hearses::select("*");
        
        $hearsesData = $q->get();
        $arr["data"] = array();
        foreach($hearsesData as $hearsesDataVal){
            
            $timeStr = "00:00";
            $endtimeStr = "23:59";
            $dayStr = date("Y-m-d");
            
            $hearsesOrders = $this->checkParlourAvailability($dayStr, $hearsesDataVal->id);
            if( $hearsesOrders != "" ){
                
                if( strtotime(date("Y-m-d H:m:s")) <= strtotime($hearsesOrders) ) {
                    $datetime = strtotime($hearsesOrders);
                    $dayStr = date('Y-m-d', $datetime);
                    $lastbooktime = date('H:m', $datetime);

                    $first_date = $dayStr;
                    $first_time = $lastbooktime . " to " . $endtimeStr;
                } else{
                    $first_date = $dayStr;
                    $first_time = $timeStr . " to " . $endtimeStr;
                }
            } else {
                $first_date = $dayStr;
                $first_time = $timeStr . " to " . $endtimeStr;
            }
            
            $second_date = date('Y-m-d', strtotime("+1 day", strtotime($dayStr)));
            $second_time = $timeStr . " to " . $endtimeStr;
            
            $third_date = date('Y-m-d', strtotime("+2 day", strtotime($dayStr)));
            $third_time = $timeStr . " to " . $endtimeStr;
            
            $arr["data"][] = array($hearsesDataVal->name, $first_date, $first_date, $first_time, $second_date, $second_date, $second_time, $second_time, $third_date, $third_date, $third_time, "<a target='_blank' href='".(($hearsesDataVal->id!=0 && $hearsesDataVal->id != "")?(self::viewFolder.'pview/'.$hearsesDataVal->id):"#")."'>Book Hearse</a>");
        }

        return response()->json($arr);
    }
    
    /**
    * Author: Jinandra
    * Date: 11-24-2016
    * Get hearses booking availability
    *
    * @param  string  $date_availability
    * @param  integer $hearse_id
    * @return string
    */
    function checkParlourAvailability( $date_availability, $hearse_id) {
        $startTimeStr = "00:00";
        $endTimeStr = "23:59";
        $pq = HearseOrders::select(DB::raw("max(TIMESTAMP(hearse_orders.booked_to_day, hearse_orders.booked_to_time)) as last_date"));
        $pq->where("hearse_id",$hearse_id);

        $hearseOrders = $pq->get();
        
        if( $hearseOrders[0]->last_date != "" ){
            $lastdate = $hearseOrders[0]->last_date;
        } else {
            $lastdate = "";
        }
        return $lastdate;
    }
    
    public function saveForm(Request $request){
        $session = new Session();
        
        $user = Auth::user();
        $errors = 0;
        $msg = array();        
        
        if( $request->get("id") ){
            $order = HearseOrders::find($request->get("id"));
        }
        else{
            $order = new HearseOrders();
        }
        
        // SAVE DATA
        $columns = \Schema::getColumnListing("hearse_orders");
        $info2save = $request->all();
        foreach( $info2save as $key => $value ){
            if (in_array($key, $columns) && !in_array($key, array("created_at","order_nr","funeral_arrangement_id","booked_from_day","booked_to_day"))){
                $order->{$key} = $value;
            }
        }
        
        $order->booked_from_day = date("Y-m-d", strtotime(str_replace("/","-",$request->get("booked_from_day"))));
        $order->booked_to_day = date("Y-m-d", strtotime(str_replace("/","-",$request->get("booked_to_day"))));
        $order->funeral_arrangement_id = $request->get("fa_id");
        
        //SIGNATURES      
        if ($request->get("signature1") || $request->get("signature_image_1")){
            $sign1 = ($request->get("signature1"))?$request->get("signature1"):$request->get("signature_image_1");
            $order->signature = $sign1;
            $order->signature_date = date("Y-m-d", strtotime(str_replace("/", "-", $request->get("date_signature_1", date("Y-m-d"))) ));
        }
        
        if (!$order->order_nr){
            $order->created_at = date("Y-m-d H:i:s");
            $order->order_nr = HearseOrders::getNextNumber();
            $order->created_by = $user->id;
        }

        if ($order->save()){
            $session->set("save_msg", "Information saved");
        }
        else{
            $session->set("save_msg", "Error saving information");
        }

        return Redirect::to( self::baseUrl . 'view/'.$order->id);

    }
    
    public function bookedHours(Request $request)
    {
        $res = HearseOrders::getBookedTime( $request->get("hearse_id"), $request->get("booked_from_day") , $request->get("booked_to_day"), $request->get("order_id"));
        return response()->json($res);
    }
    public function getEndDate(Request $request){
        $result = "";
        $res = HearseOrders::where("booked_from_day", ">=",  date("Y-m-d" , strtotime( str_replace("/","-",$request->get("booked_from_day")))))
                            ->where("hearse_id", $request->get("hearse_id"))
                            ->where("id","!=", $request->get("order_id"))
                            ->orderBy("booked_to_day","ASC")
                            ->first();
        if ($res &&  $res->booked_to_day){
            $result = $res->booked_to_day;
            $result = date("d/m/Y", strtotime($result));
        }
        return response()->json(array("booked_to_day" => $result));
    }
    public function getFA(Request $request){
       
       $results = FuneralArrangements::where('generated_code','like','%'.$request->get('term').'%')->orderby('generated_code')->get()->toArray();
       $arrResponse = array();
       foreach ($results as $key => $result){
           foreach($result as $propName => $propValue){
               $arrResponse[$key][$propName] = $propValue;
           }
       }
       return response()->json($arrResponse);
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
    
    public function popup(Request $request){
        $user = Auth::user();
        
        $data = array();
        $strRaw = "is_deleted = 0";
        if ($request->get("hearse_id")){
            $strRaw .= " OR id = ".$request->get("hearse_id");
        }
        $data["items"] = Hearses::whereRaw( $strRaw )->orderBy("name")->get();
        $data["is_popup"] = 1;

        return view(self::viewFolder.'popup', $data);
    }
    
    /**
     * Author: Jinandra
     * Date: 11-25-2016
     * Update hearse order manpower
     *
     * @param  integer  $id
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateHearseOrderManpower($id, Request $request) {
        $hearseOrder = HearseOrders::find($id);
        
        if (!$hearseOrder) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Wrong Request'
            ]);
        }
        
        $users_ids = $request->get('users_ids');

        $hearseOrder->members()->sync($users_ids ? $users_ids : []);
        
        $result = [
            'status' => 'success',
        ];
        
        if(isset($users_ids) && !empty($users_ids)){
            $hearseOrder->manpower_assigned = 2;
        } else {
            $hearseOrder->manpower_assigned = 1;
        }
        $hearseOrder->save();
        
        return response()->json($result);
    }
}
