<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Settings;
use App\Manpower;
use App\Dutyroster;
use App\RosterSettings;
use App\User;
use App\FuneralArrangements;
use DB;
use App\ParlourOrders;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Session\Session;

class DutyrosterController extends Controller
{
    const baseUrl = "/dutyroster/";
    const viewFolder = "dutyroster/";
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
        
        $allUsersData = User::all();
        $data["usersdata"] = $allUsersData;
		$allRosterData = RosterSettings::where('is_deleted',0)
		                 ->where('add_to_roster',1)
						 ->get();
        $data["rosterdata"] = $allRosterData;
        
        $dateYear = ($request->get("year") != '')?$request->get("year"):date("Y");
	$dateMonth = ($request->get("month") != '')?$request->get("month"):date("m");
	$date = $dateYear.'-'.$dateMonth.'-01';
	$currentMonthFirstDay = date("N",strtotime($date));
	$totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$dateMonth,$dateYear);
	$totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay);
	$boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42;
        
        $data['dateYear'] = $dateYear;
        $data['dateMonth'] = $dateMonth;
        $data['date'] = $date;
        $data['currentMonthFirstDay'] = $currentMonthFirstDay;
        $data['totalDaysOfMonth'] = $totalDaysOfMonth;
        $data['totalDaysOfMonthDisplay'] = $totalDaysOfMonthDisplay;
        $data['boxDisplay'] = $boxDisplay;
        
        $data['monthDataVal'] = Dutyroster::getMonthData($dateMonth);
        
        return view(self::viewFolder.'index', $data);
    }
    
    
    /**
    * Author: Jinandra
    * Date: 13-12-2016
    * Get month name
    *
    * @param  string  $date_availability
    * @param  integer $parlour_id
    * @return string
    */
    function getAllMonths($selected = ''){
        $options = '';
        for($i=1;$i<=12;$i++)
        {
            $value = ($i < 10)?'0'.$i:$i;
            $selectedOpt = ($value == $selected)?'selected':'';
            //$options .= '<option value="'.$value.'" '.$selectedOpt.' >'.date("F", mktime(0, 0, 0, $i+1, 0, 0)).'</option>';
            if( $selectedOpt == 'selected' )
                    $options = date("F", mktime(0, 0, 0, $i+1, 0, 0));
        }
        return $options;
    }

    /**
    * Author: Jinandra
    * Date: 13-12-2016
    * Get year
    *
    * @param  string  $date_availability
    * @param  integer $parlour_id
    * @return string
    */
    function getYearList($selected = ''){
        $options = '';
        for($i=2015;$i<=2025;$i++)
        {
            $selectedOpt = ($i == $selected)?'selected':'';
            //$options .= '<option value="'.$i.'" '.$selectedOpt.' >'.$selectedOpt.$i.'</option>';
            if( $selectedOpt == 'selected' )
                    $options = $i;
        }
        return $options;
    }
   
   
    public function ajaxCalendar(Request $request)
    {
        $user = Auth::user();
        
        $allUsersData = User::all();
        $data["usersdata"] = $allUsersData;
        
        $dateYear = ($request->get("year") != '')?$request->get("year"):date("Y");
	$dateMonth = ($request->get("month") != '')?$request->get("month"):date("m");
	$date = $dateYear.'-'.$dateMonth.'-01';
	$currentMonthFirstDay = date("N",strtotime($date));
	$totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$dateMonth,$dateYear);
	$totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay);
	$boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42;
        
        $data['dateYear'] = $dateYear;
        $data['dateMonth'] = $dateMonth;
        $data['date'] = $date;
        $data['currentMonthFirstDay'] = $currentMonthFirstDay;
        $data['totalDaysOfMonth'] = $totalDaysOfMonth;
        $data['totalDaysOfMonthDisplay'] = $totalDaysOfMonthDisplay;
        $data['boxDisplay'] = $boxDisplay;
        
        $data['monthDataVal'] = Dutyroster::getMonthData($dateMonth);
        
        return view(self::viewFolder.'ajaxcalendar', $data);
    }
    
    
    public function dutyRosterSave(Request $request){
        
        $dutyRosterObj = new Dutyroster();
        
        $user = Auth::user();
        $errors = 0;
        $insertRes = "";
        $updateRes = "";
        $funeraIds = "";
        
        $msg = array();   
        $postdataarr = array();
        
        $dateYear = ($request->get("year_number") != '')?$request->get("year_number"):date("Y");
	$dateMonth = ($request->get("month_number") != '')?$request->get("month_number"):date("m");
	$date = $dateYear.'-'.$dateMonth.'-01';
	$currentMonthFirstDay = date("N",strtotime($date));
	$totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$dateMonth,$dateYear);
	$totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay);
	$boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42;
        
        /* ------------------------------ */
        $dayCount = 1; 
        $drrow = 1;
        for($rw=1;$rw<=6;$rw++){
            
            $postdataarr = array();
            
            $postdataarr['duty_month'] = $dateMonth;
            $postdataarr['duty_year'] = $dateYear;
            
            $calendarunique_id = "dr_".$dateMonth."_".$drrow;
            $dataCheck = $dutyRosterObj->checkDutyRosterAlreadyExists($calendarunique_id);
            
            if( $dataCheck ){
                $postdataarr['calendarunique_id'] = $calendarunique_id;
                $postdataarr['column_1'] = ($request->get("first_a_".$rw) != '')?$request->get("first_a_".$rw):"";
                $postdataarr['column_2'] = ($request->get("users_idsb_".$rw) != '')?implode(",", $request->get("users_idsb_".$rw)):"";

                $dayCount = 1; 
                for($cb=1;$cb<=$boxDisplay;$cb++){
                    if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                        $postdataarr['date_column_'.$dayCount] = ($request->get("month_dates_".$rw."_".$dayCount) != '')?$request->get("month_dates_".$rw."_".$dayCount):"";
                        $dayCount++;
                    }
                }
                
                if( !isset($postdataarr['date_column_29']) ){
                    $postdataarr['date_column_29'] = "";
                }
                
                if( !isset($postdataarr['date_column_30']) ){
                    $postdataarr['date_column_30'] = "";
                }
                
                if( !isset($postdataarr['date_column_31']) ){
                    $postdataarr['date_column_31'] = "";
                }
                
                $updateRes = $dutyRosterObj->updateDutyRoster($postdataarr);
                $drrow++;
                
            } else {
                $postdataarr['calendarunique_id'] = $calendarunique_id;
                $postdataarr['column_1'] = ($request->get("first_a_".$rw) != '')?$request->get("first_a_".$rw):"";
                $postdataarr['column_2'] = ($request->get("users_idsb_".$rw) != '')?implode(",", $request->get("users_idsb_".$rw)):"";

                $dayCount = 1; 
                for($cb=1;$cb<=$boxDisplay;$cb++){
                    if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                        $postdataarr['date_column_'.$dayCount] = ($request->get("month_dates_".$rw."_".$dayCount) != '')?$request->get("month_dates_".$rw."_".$dayCount):"";
                        $dayCount++;
                    }
                }
                
                if( !isset($postdataarr['date_column_29']) ){
                    $postdataarr['date_column_29'] = "";
                }
                
                if( !isset($postdataarr['date_column_30']) ){
                    $postdataarr['date_column_30'] = "";
                }
                
                if( !isset($postdataarr['date_column_31']) ){
                    $postdataarr['date_column_31'] = "";
                }
                
                $insertRes = $dutyRosterObj->insertDutyRoster($postdataarr);

                $lastinsert_id = $insertRes;
                $drrow++;
            }
        }
        
        /* --------------------------------- */
        $postdataarr = array();
        
        $calendarunique_id = "dr_".$dateMonth."_".$drrow;
        $dataCheck = $dutyRosterObj->checkDutyRosterAlreadyExists($calendarunique_id);
        
        $postdataarr['duty_month'] = $dateMonth;
        $postdataarr['duty_year'] = $dateYear;
            
        if( $dataCheck ){
            $postdataarr['calendarunique_id'] = $calendarunique_id;
            $postdataarr['column_1'] = ($request->get("seventh_input") != '')?$request->get("seventh_input"):"";
            $postdataarr['column_2'] = "";

            $dayCount = 1; 
            for($cb=1;$cb<=$boxDisplay;$cb++){
                if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                    $postdataarr['date_column_'.$dayCount] = ($request->get("users_ids_sev_".$dayCount) != '')?implode(",", $request->get("users_ids_sev_".$dayCount)):"";
                    $dayCount++;
                }
            }
            
            if( !isset($postdataarr['date_column_29']) ){
                $postdataarr['date_column_29'] = "";
            }

            if( !isset($postdataarr['date_column_30']) ){
                $postdataarr['date_column_30'] = "";
            }

            if( !isset($postdataarr['date_column_31']) ){
                $postdataarr['date_column_31'] = "";
            }
                
            $updateRes = $dutyRosterObj->updateDutyRoster($postdataarr);
            
            $drrow++;
        } else {
            $postdataarr['calendarunique_id'] = $calendarunique_id;
            $postdataarr['column_1'] = ($request->get("seventh_input") != '')?$request->get("seventh_input"):"";
            $postdataarr['column_2'] = "";

            $dayCount = 1; 
            for($cb=1;$cb<=$boxDisplay;$cb++){
                if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                    $postdataarr['date_column_'.$dayCount] = ($request->get("users_ids_sev_".$dayCount) != '')?implode(",", $request->get("users_ids_sev_".$dayCount)):"";
                    $dayCount++;
                }
            }
            
            if( !isset($postdataarr['date_column_29']) ){
                $postdataarr['date_column_29'] = "";
            }

            if( !isset($postdataarr['date_column_30']) ){
                $postdataarr['date_column_30'] = "";
            }

            if( !isset($postdataarr['date_column_31']) ){
                $postdataarr['date_column_31'] = "";
            }
                

            $insertRes = $dutyRosterObj->insertDutyRoster($postdataarr);
            $drrow++;
        }
        
        /* --------------------------------- */
        $postdataarr = array();
        
        for($rw=1;$rw<=2;$rw++){
            $postdataarr = array();
            
            $postdataarr['duty_month'] = $dateMonth;
            $postdataarr['duty_year'] = $dateYear;
        
            $calendarunique_id = "dr_".$dateMonth."_".$drrow;
            $dataCheck = $dutyRosterObj->checkDutyRosterAlreadyExists($calendarunique_id);
            
            if( $dataCheck ){
                $postdataarr['calendarunique_id'] = $calendarunique_id;
                $postdataarr['column_1'] = ($request->get("users_ids_egt_".$rw) != '')?implode(",", $request->get("users_ids_egt_".$rw)):"";
                $postdataarr['column_2'] = ($request->get("text_input_".$rw) != '')?$request->get("text_input_".$rw):"";

                $dayCount = 1; 
                for($cb=1;$cb<=$boxDisplay;$cb++){
                    if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                        $postdataarr['date_column_'.$dayCount] = ($request->get("month_dates_egt_".$rw."_".$dayCount) != '')?$request->get("month_dates_egt_".$rw."_".$dayCount):"";
                        $dayCount++;
                    }
                }
                
                if( !isset($postdataarr['date_column_29']) ){
                    $postdataarr['date_column_29'] = "";
                }
                
                if( !isset($postdataarr['date_column_30']) ){
                    $postdataarr['date_column_30'] = "";
                }
                
                if( !isset($postdataarr['date_column_31']) ){
                    $postdataarr['date_column_31'] = "";
                }
                
                $updateRes = $dutyRosterObj->updateDutyRoster($postdataarr);
                $drrow++;
                
            } else {
                $postdataarr['calendarunique_id'] = $calendarunique_id;
                $postdataarr['column_1'] = ($request->get("users_ids_egt_".$rw) != '')?implode(",", $request->get("users_ids_egt_".$rw)):"";
                $postdataarr['column_2'] = ($request->get("text_input_".$rw) != '')?$request->get("text_input_".$rw):"";

                $dayCount = 1; 
                for($cb=1;$cb<=$boxDisplay;$cb++){
                    if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                        $postdataarr['date_column_'.$dayCount] = ($request->get("month_dates_egt_".$rw."_".$dayCount) != '')?$request->get("month_dates_egt_".$rw."_".$dayCount):"";
                        $dayCount++;
                    }
                }
                
                if( !isset($postdataarr['date_column_29']) ){
                    $postdataarr['date_column_29'] = "";
                }
                
                if( !isset($postdataarr['date_column_30']) ){
                    $postdataarr['date_column_30'] = "";
                }
                
                if( !isset($postdataarr['date_column_31']) ){
                    $postdataarr['date_column_31'] = "";
                }
                
                $insertRes = $dutyRosterObj->insertDutyRoster($postdataarr);                    
                $lastinsert_id = $insertRes; 
                $drrow++;
            }
        }
        
        /* --------------------------------- */
        $postdataarr = array();
        
        $dayCount = 1; 
        for($rw=1;$rw<=3;$rw++){
            
            $postdataarr = array();
            
            $postdataarr['duty_month'] = $dateMonth;
            $postdataarr['duty_year'] = $dateYear;
            
            $calendarunique_id = "dr_".$dateMonth."_".$drrow;
            $postdataarr['calendarunique_id'] = $calendarunique_id;
            $dataCheck = $dutyRosterObj->checkDutyRosterAlreadyExists($calendarunique_id);
            
            $firstColumnTitle = "";
            switch($rw){
                case 1:
                    $postdataarr['column_1'] = ($request->get("nine_text_".$rw) != '')?$request->get("nine_text_".$rw):"";
                    break;
                case 2:
                    $postdataarr['column_1'] = ($request->get("users_ids_nine_".$rw) != '')?implode(",", $request->get("users_ids_nine_".$rw)):"";
                    break;
                case 3:
                    $postdataarr['column_1'] = ($request->get("users_ids_nine_".$rw) != '')?implode(",", $request->get("users_ids_nine_".$rw)):"";
                    break;
                default:
                    break;
            }
            
            $postdataarr['column_2'] = "";
            $dayCount = 1; 
            for($cb=1;$cb<=$boxDisplay;$cb++){
                if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                    $postdataarr['date_column_'.$dayCount] = ($request->get("month_dates_nine_".$rw."_".$dayCount) != '')?$request->get("month_dates_nine_".$rw."_".$dayCount):"";
                    $dayCount++;
                }
            }
            
            if( !isset($postdataarr['date_column_29']) ){
                $postdataarr['date_column_29'] = "";
            }

            if( !isset($postdataarr['date_column_30']) ){
                $postdataarr['date_column_30'] = "";
            }

            if( !isset($postdataarr['date_column_31']) ){
                $postdataarr['date_column_31'] = "";
            }
                
            if( $dataCheck ){
                $updateRes = $dutyRosterObj->updateDutyRoster($postdataarr);
                $drrow++;
            } else {
                $insertRes = $dutyRosterObj->insertDutyRoster($postdataarr);                    
                $lastinsert_id = $insertRes;   
                $drrow++;
            }
            
        }
        
        /* ---------------------------------- */
        $postdataarr = array();
        
        $calendarunique_id = "dr_".$dateMonth."_".$drrow;
        $postdataarr['calendarunique_id'] = $calendarunique_id;
        $dataCheck = $dutyRosterObj->checkDutyRosterAlreadyExists($calendarunique_id);
        $dayCount = 1; 
        
        $postdataarr['duty_month'] = $dateMonth;
        $postdataarr['duty_year'] = $dateYear;
        if( $dataCheck ){
            $postdataarr['column_1'] = "";
            $postdataarr['column_2'] = "";
            for($cb=1;$cb<=$boxDisplay;$cb++){
                if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                    $postdataarr['date_column_'.$dayCount] = ($request->get("users_ids_ten_".$dayCount) != '')?implode(",", $request->get("users_ids_ten_".$dayCount)):"";
                    $dayCount++;
                }
            }
            if( !isset($postdataarr['date_column_29']) ){
                $postdataarr['date_column_29'] = "";
            }

            if( !isset($postdataarr['date_column_30']) ){
                $postdataarr['date_column_30'] = "";
            }

            if( !isset($postdataarr['date_column_31']) ){
                $postdataarr['date_column_31'] = "";
            }
                
            $updateRes = $dutyRosterObj->updateDutyRoster($postdataarr);
            
        } else {
            $postdataarr['column_1'] = "";
            $postdataarr['column_2'] = "";
            for($cb=1;$cb<=$boxDisplay;$cb++){
                if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
                    $postdataarr['date_column_'.$dayCount] = ($request->get("users_ids_ten_".$dayCount) != '')?implode(",", $request->get("users_ids_ten_".$dayCount)):"";
                    $dayCount++;
                }
            }
            
            if( !isset($postdataarr['date_column_29']) ){
                $postdataarr['date_column_29'] = "";
            }

            if( !isset($postdataarr['date_column_30']) ){
                $postdataarr['date_column_30'] = "";
            }

            if( !isset($postdataarr['date_column_31']) ){
                $postdataarr['date_column_31'] = "";
            }
            $insertRes = $dutyRosterObj->insertDutyRoster($postdataarr);
        }
        
        return redirect()->back()->with('flash_message', "Information Saved Successfully");

    }
    
}