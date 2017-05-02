<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Settings;
use App\Company;
use App\Parlours;
use DB;
use App\ParlourOrders;
use App\FuneralArrangements;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Session\Session;

class ParlourController extends Controller
{
    const baseUrl = "/parlour/";
    const viewFolder = "parlour/";
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

        //   $data["items"] = Parlours::where("is_deleted",0)->orderBy("name")->get();

        $data["order_nr"] = sprintf("%05d",ParlourOrders::getNextNumber());
        if ($request->get("is_popup")){
            $data["is_popup"] = 1;
        }

        return view(self::viewFolder.'index', $data);
    }

    public function view($id, Request $request)
    {
        $session = new Session();
        $user = Auth::user();

        $data = array();
        $data["user"] = $user;
        $data["company_prefix"] = Company::getCurrentCompanyPrefix();

        $data["order"] = ParlourOrders::find($id);
        $completedData=array();
        $preDate = Parlours::find($data["order"]->parlour_id)->get()->toArray();

        foreach($preDate as $key => $eachData){

            if($eachData['image'] !=""){
                $eachImageName = explode("|",$eachData['image']);
                $completedData[$key]['image'][]=$eachImageName[0];
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

        $data["parlourdetails"] = Parlours::find($id);

        $data["items"] = Parlours::whereRaw("is_deleted = 0 OR id = ".$id)->orderBy("name")->get();

        $data["order_nr"] = sprintf("%05d",ParlourOrders::getNextNumber());
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

        $q = ParlourOrders::select("*");
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


        if ($request->get("filter_parlour")){
            $q->where("parlour_id",$request->get("filter_parlour"));
        }

        $orders = $q->get();
        $arr["data"] = array();

        foreach($orders as $order){
            if(isset($order->booked_from_day) && $order->booked_from_day!= "0000-00-00"){
                $from_day = date("d/m/Y", strtotime($order->booked_from_day));
                $from_time = date("H:i", strtotime($order->booked_from_day . " ". $order->booked_from_time));
            }
            else{
                $from_day = "";
                $from_time = "";
            }


            if(isset($order->booked_to_day) && $order->booked_to_day!= "0000-00-00") {
                $to_day = date("d/m/Y", strtotime($order->booked_to_day));
                $to_time = date("H:i", strtotime($order->booked_to_day . " ". $order->booked_to_time));
            }
            else {
                $to_day = "";
                $to_time = "";
            }

            $arr["data"][] = array($order->parlour_name,$order->capacity, $from_day, strtotime($order->booked_from_day), $to_day, strtotime($order->booked_to_day), $from_time, strtotime($order->booked_from_day . " ". $order->booked_from_time), $to_time, strtotime($order->booked_to_day . " ". $order->booked_to_time), ($order->funeralArrangement)?$order->funeralArrangement->getFullCode():"", ($order->creator)?$order->creator->name:"", "<a href='".self::viewFolder.'view/'.$order->id."'>P".sprintf("%05d",$order->order_nr)."</a>");

        }

        return response()->json($arr);
    }

    /**
     * Author: Jinandra
     * Date: 11-23-2016
     * Parlour availability booking on dashboard page
     * @param array $request
     *
     * @return Json response for ajax call
     */
    public function dblisting(Request $request)
    {

        $q = Parlours::select("*");

        $parlourData = $q->get();
        $arr["data"] = array();
        foreach($parlourData as $parlourDataVal){
            $timeStr = "00:00";
            $endtimeStr = "23:59";
            $dayStr = date("Y-m-d");

            $first_from_date = "";
            $first_date = "";
            $first_from_time = "";
            $first_time = "";

            $second_from_date = "";
            $second_date = "";
            $second_from_time = "";
            $second_time = "";

            $third_from_date = "";
            $third_date = "";
            $third_from_time = "";
            $third_time = "";

            $parlourOrders = $this->checkParlourAvailability($dayStr, $parlourDataVal->id);
            if( $parlourOrders != "" ){

                $caseId = 1;
                foreach( $parlourOrders as $parlourOrdersVal ){

                    switch ($caseId) {
                        case 1:
                            if( !empty($parlourOrdersVal->booked_to_day) ) {
                                $first_from_date = date("d-m-Y", strtotime($parlourOrdersVal->booked_from_day));
                                $first_date = date("d-m-Y", strtotime($parlourOrdersVal->booked_from_day))." to ".date("d-m-Y", strtotime($parlourOrdersVal->booked_to_day));
                                $first_time = date("H:i", strtotime($parlourOrdersVal->booked_from_time)) . " to " . date("H:i", strtotime($parlourOrdersVal->booked_to_time));
                            } else {
                                $first_date = "";
                                $first_time = "";
                            }
                            break;
                        case 2:
                            if( !empty($parlourOrdersVal->booked_to_day) ) {
                                $second_from_date = date("d-m-Y", strtotime($parlourOrdersVal->booked_from_day));
                                $second_date = date("d-m-Y", strtotime($parlourOrdersVal->booked_from_day))." to ".date("d-m-Y", strtotime($parlourOrdersVal->booked_to_day));
                                $second_time = date("H:i", strtotime($parlourOrdersVal->booked_from_time)) . " to " . date("H:i", strtotime($parlourOrdersVal->booked_to_time));
                            } else {
                                $second_date = "";
                                $second_time = "";
                            }
                            break;
                        case 3:
                            if( !empty($parlourOrdersVal->booked_to_day) ) {
                                $third_from_date = date("d-m-Y", strtotime($parlourOrdersVal->booked_from_day));
                                $third_date = date("d-m-Y", strtotime($parlourOrdersVal->booked_from_day))." to ".date("d-m-Y", strtotime($parlourOrdersVal->booked_to_day));
                                $third_time = date("H:i", strtotime($parlourOrdersVal->booked_from_time)) . " to " . date("H:i", strtotime($parlourOrdersVal->booked_to_time));
                            } else {
                                $third_date = "";
                                $third_time = "";
                            }
                            break;
                    }

                    $caseId++;

                }

            }

            $arr["data"][] = array($parlourDataVal->name,$parlourDataVal->capacity, $parlourDataVal->unit_price, $first_date, $first_date, $first_time, $first_time, $second_date, $second_date, $second_time, $second_time, $third_date, $third_time, "<a target='_blank' href='".(($parlourDataVal->id!=0 && $parlourDataVal->id != "")?(self::viewFolder.'pview/'.$parlourDataVal->id):"#")."'>Book Room</a>");

        }

        return response()->json($arr);
    }

    /**
     * Author: Jinandra
     * Date: 11-24-2016
     * Get parlour booking availability
     *
     * @param  string  $date_availability
     * @param  integer $parlour_id
     * @return string
     */
    function checkParlourAvailability( $date_availability, $parlour_id) {
        $startTimeStr = "00:00";
        $endTimeStr = "23:59";

        //$pq = ParlourOrders::select(DB::raw("max(TIMESTAMP(parlour_orders.booked_to_day, parlour_orders.booked_to_time)) as last_date"));
        $pq = ParlourOrders::select("*");
        $pq->whereRaw("TIMESTAMP(booked_from_day, booked_from_time) >='".date("Y-m-d H:i:s", strtotime($date_availability." ".$startTimeStr.":00"))."'");
        $pq->where("parlour_id",$parlour_id);
        $pq->orderBy("booked_from_day", "asc");

        $parlourOrders = $pq->get();

        if( $parlourOrders ){
            $responseData = $parlourOrders;
        } else {
            $responseData = "";
        }
        return $responseData;
    }

    public function saveForm(Request $request){
        $session = new Session();
        $user = Auth::user();
        $errors = 0;
        $msg = array();

        if( $request->get("id") ){
            $order = ParlourOrders::find($request->get("id"));
        }
        else{
            $order = new ParlourOrders();
        }

        // SAVE DATA
        $columns = \Schema::getColumnListing("parlour_orders");
        $info2save = $request->all();

        foreach( $info2save as $key => $value ){
            if (in_array($key, $columns) && !in_array($key, array("created_at","order_nr","funeral_arrangement_id","booked_from_day","booked_to_day"))){
                $order->{$key} = $value;
            }
        }

        if(!empty($request->get("booked_from_day")))
            $order->booked_from_day = date("Y-m-d", strtotime(str_replace("/","-",$request->get("booked_from_day"))));
        else
            $order->booked_from_day = "";
        if(!empty($request->get("booked_to_day")))
            $order->booked_to_day = date("Y-m-d", strtotime(str_replace("/","-",$request->get("booked_to_day"))));
        else
            $order->booked_to_day = "";


        $order->funeral_arrangement_id = $request->get("fa_id");

        //SIGNATURES
        if ($request->get("signature1") || $request->get("signature_image_1")){
            $sign1 = ($request->get("signature1"))?$request->get("signature1"):$request->get("signature_image_1");
            $order->signature = $sign1;
            $order->signature_date = date("Y-m-d", strtotime(str_replace("/", "-", $request->get("date_signature_1", date("Y-m-d"))) ));
        }

        if (!$order->order_nr){
            $order->created_at = date("Y-m-d H:i:s");
            $order->order_nr = ParlourOrders::getNextNumber();
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
        $res = ParlourOrders::getBookedTime( $request->get("parlour_id"), $request->get("booked_from_day") , $request->get("booked_to_day"), $request->get("order_id"));
        return response()->json($res);
    }
    public function getEndDate(Request $request){
        $result = "";
        $res = ParlourOrders::where("booked_from_day", ">=",$request->get("booked_from_day"))
            ->where("parlour_id", $request->get("parlour_id"))
            ->where("id","!=", $request->get("order_id"))
            ->orderBy("booked_to_day","ASC")
            ->first();
        if ($res && $res->booked_to_day){
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

        if ($request->get("parlour_id")) {
            $order = ParlourOrders::find($request->get("parlour_id"));
            $parlour_id = $order->parlour_id;
            $strRaw .= " OR id = ".$parlour_id;
            $data['order'] = $order;
        }


        $preDate = Parlours::whereRaw( $strRaw )->orderBy("name")->get();

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


        $data['user'] = $user;

        $data["is_popup"] = 1;



        return view(self::viewFolder.'popup', $data);
    }

///  Add data via parlour_modal;
    public function parlour_modal_save(Request $request){
        $session = new Session();
        $user = Auth::user();
        $errors = 0;
        $msg = array();

        if( $request->get("id") ){
            $order = ParlourOrders::find($request->get("id"));
        }
        else{
            $order = new ParlourOrders();
        }

        // SAVE DATA
        $columns = \Schema::getColumnListing("parlour_orders");

        $info2save = $request->all();

        foreach( $info2save as $key => $value ){
            if (in_array($key, $columns) && !in_array($key, array("created_at","order_nr","funeral_arrangement_id","booked_from_day","booked_to_day"))){
                $order->{$key} = $value;
            }
        }

        if(!empty($request->get("booked_from_day")))
            $order->booked_from_day = date("Y-m-d", strtotime(str_replace("/","-",$request->get("booked_from_day"))));
        else
            $order->booked_from_day = "";
        if(!empty($request->get("booked_to_day")))
            $order->booked_to_day = date("Y-m-d", strtotime(str_replace("/","-",$request->get("booked_to_day"))));
        else
            $order->booked_to_day = "";

        $order->funeral_arrangement_id = $request->get("funeral_arrangement_id");
        $order->funeral_arrangement_id = $request->get("fa_id");

        //SIGNATURES
        if ($request->get("signature1") || $request->get("signature_image_1")){
            $sign1 = ($request->get("signature1"))?$request->get("signature1"):$request->get("signature_image_1");
            $order->signature = $sign1;
            $order->signature_date = date("Y-m-d", strtotime(str_replace("/", "-", $request->get("date_signature_1", date("Y-m-d"))) ));
        }

        if (!$order->order_nr){
            $order->created_at = date("Y-m-d H:i:s");
            $order->order_nr = ParlourOrders::getNextNumber();
            $order->created_by = $user->id;
        }



        if ($order->save()){
            $session->set("save_msg", "Information saved");
            return $order;
        }
        else{
            $session->set("save_msg", "Error saving information");
        }
    }
    public function getAllImages(Request $request){

        $id = $request->get("id");

        $preDate = Parlours::where("is_deleted",0)->where("id",$id)->get()->toArray();
        foreach($preDate as $key => $eachData){
            //var_dump($eachData['image']);exit;
            if($eachData['image'] !=""){
                $eachImageName = explode("|",$eachData['image']);
                for($i=0;$i<count($eachImageName)-1;$i++){
                    $completedData[]=$eachImageName[$i];
                }
            }else{
                $completedData[]="";
            }

        }
        die(json_encode($completedData));
    }
}
