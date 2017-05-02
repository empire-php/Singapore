<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Settings;
use App\Shifting;
use App\Company;
use App\Parlours;
use App\Hearses;
use App\HearseOrders;
use App\Manpower;
use App\Manpowertext;
use App\User;
use App\FuneralArrangements;
use DB;
use App\ParlourOrders;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Session\Session;

class ManpowerController extends Controller
{
    const baseUrl = "/manpower/";
    const viewFolder = "manpower/";
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
        $manpowerObj1 = Manpower::find(41);
        $editStatus = $manpowerObj1->manpower_type;
        $manpowerEditUserId = $manpowerObj1->manpower_edit_user_id;
        
        $funeralObj = new FuneralArrangements();
        
        $data = array();
        $parlourDataArr = array();
        $hearseDataArr = array();
        
        $data["user"] = $user;
        
        $allUsersData = User::all();
        $data["usersdata"] = $allUsersData;
        
        $parlourData = Parlours::where("is_deleted",0)->orderBy("name")->get();
        
        foreach($parlourData as $parlourDataVal){
            $timeStr = "00:00";
            $endtimeStr = "23:59";
            $dayStr = date("Y-m-d");
            
            $first_date = "";
            $first_time = "";
            $second_date = "";
            $second_time = "";                 
            $third_date = "";
            $third_time = "";
            $deceased_name = ""; 
            $first_to_time = "";
            $from_date = "";
            $parlourOrderId = "";
            $parlourAllocation = array();
            $parlourCleaningAllocation = array();
            $parlourOrders = $this->checkParlourAvailability($dayStr, $parlourDataVal->id);
            if( $parlourOrders != "" ){
                
                $caseId = 1;
                foreach( $parlourOrders as $parlourOrdersVal ){
                    
                    switch ($caseId) {
                        case 1:
                            if( !empty($parlourOrdersVal->booked_to_day) ) {
                                $parlourAllocation = $parlourOrdersVal->members()->getRelatedIds()->toArray();
                                $parlourCleaningAllocation = $parlourOrdersVal->membersCleaning()->getRelatedIds()->toArray();
                                $parlourOrderId = $parlourOrdersVal->id;
                                $from_date = date("d-m-Y", strtotime($parlourOrdersVal->booked_from_day));
                                $first_date = date("d-m-Y", strtotime($parlourOrdersVal->booked_to_day));
                                $first_time = date("H:i", strtotime($parlourOrdersVal->booked_from_time));
                                $first_to_time = date("H:i", strtotime($parlourOrdersVal->booked_to_time));
                                $funeralData = $funeralObj->getFuneralData($parlourOrdersVal->funeral_arrangement_id);
                                if($funeralData){
                                    $deceased_name = $funeralData->deceased_name;
                                }                                
                            } else {
                                $first_date = "";
                                $first_time = "";
                                $deceased_name = "";
                            }
                            break;
                        case 2:
                            if( !empty($parlourOrdersVal->booked_to_day) ) {
                                $second_date = date("d-m-Y", strtotime($parlourOrdersVal->booked_to_day));
                                $second_time = date("H:i", strtotime($parlourOrdersVal->booked_from_time)) . " to " . date("H:i", strtotime($parlourOrdersVal->booked_to_time));
                            } else {
                                $second_date = "";
                                $second_time = "";
                            }
                            break;
                        case 3:
                            if( !empty($parlourOrdersVal->booked_to_day) ) {
                                $third_date = date("d-m-Y", strtotime($parlourOrdersVal->booked_to_day));
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
            
            $parlourDataArr[] = (object) array('parlour_name'=>$parlourDataVal->name,'parlour_capacity'=>$parlourDataVal->capacity, 'parlour_unit_price'=>$parlourDataVal->unit_price, 'first_date'=>$first_date, 'first_time'=>$first_time, 'second_date'=>$second_date, 'second_time'=>$second_time, 'third_date'=>$third_date, 'third_time'=>$third_time, 'parlour_view'=>"<a target='_blank' href='".(($parlourDataVal->id!=0 && $parlourDataVal->id != "")?(self::viewFolder.'pview/'.$parlourDataVal->id):"#")."'>Book Room</a>", 'deceased_name'=>$deceased_name, 'to_time'=>$first_to_time, 'from_date'=>$from_date, 'parlour_order_id'=>$parlourOrderId, 'parlour_allocation'=>$parlourAllocation, 'parlour_cleaning_allocation'=>$parlourCleaningAllocation);
            
        }
        $data['parlourDataAll'] = $parlourDataArr;
        
        $q = Hearses::select("*");        
        $hearsesData = $q->get();
        foreach($hearsesData as $hearsesDataVal){
            
            $timeStr = "00:00";
            $endtimeStr = "23:59";
            $dayStr = date("Y-m-d");
            
            $first_date = "";
            $first_time = "";

            $second_date = "";
            $second_time = "";

            $third_date = "";
            $third_time = "";
            $hearseAllocation = array();
            
            $hearsesOrders = $this->checkHearseAvailability($dayStr, $hearsesDataVal->id);
            if( $hearsesOrders != "" ){
                
                $caseId = 1;
                foreach( $hearsesOrders as $hearsesOrdersVal ){
                    
                    switch ($caseId) {
                        case 1:
                            if( !empty($hearsesOrdersVal->booked_to_day) ) {
                                $hearseAllocation = $hearsesOrdersVal->members()->getRelatedIds()->toArray();
                                $first_date = date("d-m-Y", strtotime($hearsesOrdersVal->booked_to_day));
                                $first_time = date("H:i", strtotime($hearsesOrdersVal->booked_from_time)) . " to " . date("H:i", strtotime($hearsesOrdersVal->booked_to_time));
                            } else {
                                $first_date = "";
                                $first_time = "";
                            }
                            break;
                        case 2:
                            if( !empty($hearsesOrdersVal->booked_to_day) ) {
                                $hearseAllocation = $hearsesOrdersVal->members()->getRelatedIds()->toArray();
                                $second_date = date("d-m-Y", strtotime($hearsesOrdersVal->booked_to_day));
                                $second_time = date("H:i", strtotime($hearsesOrdersVal->booked_from_time)) . " to " . date("H:i", strtotime($hearsesOrdersVal->booked_to_time));
                            } else {
                                $second_date = "";
                                $second_time = "";
                            }
                            break;
                        case 3:
                            if( !empty($hearsesOrdersVal->booked_to_day) ) {
                                $hearseAllocation = $hearsesOrdersVal->members()->getRelatedIds()->toArray();
                                $third_date = date("d-m-Y", strtotime($hearsesOrdersVal->booked_to_day));
                                $third_time = date("H:i", strtotime($hearsesOrdersVal->booked_from_time)) . " to " . date("H:i", strtotime($hearsesOrdersVal->booked_to_time));
                            } else {
                                $third_date = "";
                                $third_time = "";
                            }
                            break;
                    }
                    
                    $caseId++;
                    
                }
            }
           
            $hearseDataArr[] = (object) array('hearse_name'=>$hearsesDataVal->name, 'first_date'=>$first_date, 'first_time'=>$first_time, 'second_date'=>$second_date, 'second_time'=>$second_time, 'third_date'=>$third_date, 'third_time'=>$third_time, 'hearse_view'=>"<a target='_blank' href='".(($hearsesDataVal->id!=0 && $hearsesDataVal->id != "")?(self::viewFolder.'pview/'.$hearsesDataVal->id):"#")."'>Book Hearse</a>", 'hearse_allocation'=>$hearseAllocation);
        }

        $data['hearseDataAll'] = $hearseDataArr;
        $data['pendingShiftingList'] = Shifting::where(['status' => 'pending'])->get();
        
        $mq = Manpower::select("*");        
        $manpowerData = $mq->get();
        $f = 1;
        foreach($manpowerData as $manpowerDataVal){
            $data['manpowerallarr'][$f] = $manpowerDataVal->members()->getRelatedIds()->toArray();
            $f++;            
        }
        
        $mtq = Manpowertext::select("*");        
        $manpowerTextData = $mtq->get();
        $f = 1;
        $manpoweralltextarr = array();
        foreach($manpowerTextData as $manpowerTextDataVal){
            $data['manpoweralltextarr'][$f] = $manpowerTextDataVal->manpower_text;
            $f++;            
        }
        $data['manpowerEditStatus'] = $editStatus;
        return view(self::viewFolder.'index', $data);
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
        $pq->whereRaw("TIMESTAMP(booked_from_day, booked_from_time) <='".date("Y-m-d H:i:s", strtotime($date_availability." ".$endTimeStr.":00"))."'");
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
    
    /**
    * Author: Jinandra
    * Date: 11-24-2016
    * Get hearses booking availability
    *
    * @param  string  $date_availability
    * @param  integer $hearse_id
    * @return string
    */
    function checkHearseAvailability( $date_availability, $hearse_id) {
        $startTimeStr = "00:00";
        $endTimeStr = "23:59";
        //$pq = HearseOrders::select(DB::raw("max(TIMESTAMP(hearse_orders.booked_to_day, hearse_orders.booked_to_time)) as last_date"));
        $pq = HearseOrders::select("*");
        $pq->whereRaw("TIMESTAMP(booked_from_day, booked_from_time) >='".date("Y-m-d H:i:s", strtotime($date_availability." ".$startTimeStr.":00"))."'");
        $pq->whereRaw("TIMESTAMP(booked_from_day, booked_from_time) <='".date("Y-m-d H:i:s", strtotime($date_availability." ".$endTimeStr.":59"))."'");
        $pq->where("hearse_id",$hearse_id);
        $pq->orderBy("booked_from_day", "asc");
        
        $hearseOrders = $pq->get();
        
        if( $hearseOrders ){
            $responseData = $hearseOrders;
        } else {
            $responseData = "";
        }
        return $responseData;
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
    public function updateAllManpower($id, Request $request) {
        
        $manpowerObj1 = Manpower::find(41);
        $editStatus = $manpowerObj1->manpower_type;
        $manpowerEditUserId = $manpowerObj1->manpower_edit_user_id;
        
        $manpowerObj = Manpower::find($id);
        
        if (!$manpowerObj || ( $editStatus == 10 && $manpowerEditUserId != Auth::user()->id )) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Wrong Request'
            ]);
        }
        
        $users_ids = $request->get('users_ids');
        $manpowerObj->members()->sync($users_ids ? $users_ids : []);
        $result = [
            'status' => 'success',
        ];
        
        $manpowerObj->save();        
        return response()->json($result);
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
    public function updateAllManpowerText($id, Request $request) {
        
        $manpowerObj = Manpower::find(41);
        $editStatus = $manpowerObj->manpower_type;
        $manpowerEditUserId = $manpowerObj->manpower_edit_user_id;
        
        $manpowertextObj = new Manpowertext();
        
        if (!$manpowertextObj || ( $editStatus == 10 && $manpowerEditUserId != Auth::user()->id )) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Wrong Request'
            ]);
        }
        
        $manpowerText = $manpowertextObj->getManpowerTextRecord($id);
        
        if( $manpowerText ){
            $manpowertextObj->deleteTextRecord($id);
        }
        $manpowertextObj->manpower_id = $id;
        $manpowertextObj->manpower_text = $request->get('manpower_text');
        $manpowertextObj->created_at = date('Y-m-d H:i:s');
        $result = [
            'status' => 'success',
        ];
        
        $manpowertextObj->save();        
        return response()->json($result);
    }
    
    
    /**
     * Author: Jinandra
     * Date: 30-11-2016
     * Update parlour order manpower
     *
     * @param  integer  $id
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateParlourOrderManpower($id, Request $request) {
        
        $manpowerObj = Manpower::find(41);
        $editStatus = $manpowerObj->manpower_type;
        $manpowerEditUserId = $manpowerObj->manpower_edit_user_id;
        
        $parlourOrder = ParlourOrders::find($id);
        
        if (!$parlourOrder || ( $editStatus == 10 && $manpowerEditUserId != Auth::user()->id )) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Wrong Request'
            ]);
        }
        
        $users_ids = $request->get('users_ids');

        $parlourOrder->members()->sync($users_ids ? $users_ids : []);
        
        $result = [
            'status' => 'success',
        ];
        
        
        $parlourOrder->save();
        
        return response()->json($result);
    }
    
    /**
     * Author: Jinandra
     * Date: 30-11-2016
     * Update parlour order manpower
     *
     * @param  integer  $id
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateParlourOrderManpowerCleaning($id, Request $request) {
        
        $manpowerObj = Manpower::find(41);
        $editStatus = $manpowerObj->manpower_type;
        $manpowerEditUserId = $manpowerObj->manpower_edit_user_id;
        
        $parlourOrder = ParlourOrders::find($id);
        
        if (!$parlourOrder || ( $editStatus == 10 && $manpowerEditUserId != Auth::user()->id )) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Wrong Request'
            ]);
        }
        
        $users_ids = $request->get('users_ids');

        $parlourOrder->membersCleaning()->sync($users_ids ? $users_ids : []);
        
        $result = [
            'status' => 'success',
        ];
        
        
        $parlourOrder->save();
        
        return response()->json($result);
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
    public function updateEditingStatus($id, Request $request) {
        
        $manpowerObj = Manpower::find($id);
        
        if (!$manpowerObj) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Wrong Request'
            ]);
        }
        
        $manpowerObj->manpower_type = $request->get('manpower_type');
        if( $request->get('manpower_type') == 9 ){
            $manpowerObj->manpower_edit_user_id = 0;
        } else {
            $manpowerObj->manpower_edit_user_id = Auth::user()->id;
        }
        $result = [
            'status' => 'success',
        ];
        
        $manpowerObj->save();        
        return response()->json($result);
    }
}
