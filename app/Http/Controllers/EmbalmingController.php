<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Shifting;
//use Barryvdh\DomPDF\Facade as PDF;


class EmbalmingController extends Controller
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
    
    public function index(){

        $data = array();
        
        $dep = \App\Department::where('name','like','embalming')->first();
        $data['departmentUsers'] = array();
        if ($dep){
            $data['departmentUsers'] = User::where("department_id", $dep->id)->orderby('name')->get();
        }
        
        $data['users'] = User::all();
        $data["shiftingInfo"] = Shifting::where('status','<>','finished')->orderby("created_at")->get();
        
        return view('embalming/index', $data);
    }
    
    
    public function getTimelog($section, Request $request){
        $data = array();
        $data["today"] = null;
        $data["logs"] = array();
        $error = "";
        $embalmer = $other_staff = "";
        
        if ($section == "today"){
            $action = $request->get("action","");
            if ($request->get("embalmer_users", array())){
                $embalmer = implode(", ",$request->get("embalmer_users", array()));
            }
            if ($request->get("other_staff_users", array())){
                $other_staff = implode(", ",$request->get("other_staff_users", array()));
            }
            if ($action){

                $eTimelog = \App\EmbalmingTimelog::where("shifting_id",$request->get("sid"))->first();
                if ( !$eTimelog ){
                    $eTimelog = new \App\EmbalmingTimelog();
                    $eTimelog->shifting_id = $request->get("sid");            
                }
                
                $shiftingInfo = \App\Shifting::find($request->get("sid"));
                if (strpos(get_class($shiftingInfo), "Collection") > -1){
                    $shiftingInfo = $shiftingInfo[0];
                }
                
                if ($shiftingInfo){
                    $eTimelog->hospital = $shiftingInfo->hospital;
                    $eTimelog->shifted_by = $shiftingInfo->creator_id;
                    $eTimelog->deceased_name = $shiftingInfo->deceased_name;
                }
                $fa = \App\FuneralArrangements::where("shifting_id",$request->get("sid"))->first();
                if ($fa){
                    $checklist = json_decode($fa->checklist_data, true);
                    if (isset($checklist[17]["remarks"])){
                        $eTimelog->items_in_coffin = $checklist[17]["remarks"];
                    }
                }
                
                switch ($action){
                    case "check_br":
                        $eTimelog->body_received_at = date("d/m/Y, H:i") .",<br />". $embalmer. (($embalmer)?", ":"") . $other_staff;
                        $eTimelog->status = "In progress";
                    break;
                    case "check_br_cr":
                        
                    break;
                    case "check_clothing":
                        if (!$eTimelog->clothing ){
                            $eTimelog->clothing = "No";
                        }
                        if ($eTimelog->clothing == "No" && ($embalmer || $other_staff)){
                            $eTimelog->clothing = "Yes". (($embalmer)?",".$embalmer:""). (($other_staff)?",".$other_staff:"");
                        }
                        else{
                            $eTimelog->clothing = "No";
                        }
                    break;
                    case "check_photo":
                        
                        if (!$eTimelog->photo ){
                            $eTimelog->photo = "No";
                        }
                        if ($eTimelog->photo == "No" && ($embalmer || $other_staff)){
                            $eTimelog->photo = "Yes". (($embalmer)?",".$embalmer:""). (($other_staff)?",".$other_staff:"");
                            $fa = \App\FuneralArrangements::where("shifting_id",$request->get("sid"))->first();
                            if ($fa){
                                $checklist = json_decode($fa->checklist_data, true);
                                $checklist[2]["active_item"] = "on";
                                $checklist[2]["remarks"] = $embalmer. (($embalmer)?",":"") . $other_staff;
                                $fa->checklist_data = json_encode($checklist);
                                $fa->save();
                            }
                        }
                        else{
                            $eTimelog->photo = "No";
                            $fa = \App\FuneralArrangements::where("shifting_id",$request->get("sid"))->first();
                            if ($fa){
                                $checklist = json_decode($fa->checklist_data, true);
                                $checklist[2] = array();
                                $fa->checklist_data = json_encode($checklist);
                                $fa->save();
                            }
                        }
                    break;
                    case "check_no_e":
                        $eTimelog->embalming_start_at = "N/A";
                        $eTimelog->embalming_end_at = "N/A";
                    break;
                    case "check_start_e":
                        $eTimelog->embalming_start_at = date("d/m/Y, H:i");
                    break;
                    case "check_end_e":
                        $eTimelog->embalming_end_at = date("d/m/Y, H:i");
                    break;
                    case "check_dressing":
                        $eTimelog->dressing = date("d/m/Y, H:i");
                    break;
                    case "check_makeup":
                        $eTimelog->makeup = date("d/m/Y, H:i");
                    break;
                    case "check_bs":
                        $eTimelog->body_sent_at = date("d/m/Y, H:i") .",<br />". $embalmer. (($embalmer)?", ":"") . $other_staff;
                    break;
                    case "check_complete":
                        $eTimelog->status = "Completed";
                    break;
                }

                $eTimelog->save();
                $data["today"] = $eTimelog;
            }
            else{
                $data["today"] = \App\EmbalmingTimelog::where("body_received_at","like",date("Y-m-d")."%")->orderby("body_received_at","desc")->first();
            }
        }
        else{
                
            $data["logs"] = array();
            $searcTerm = $request->get("search");
            if ($searcTerm || $request->get("start")){
                $q = \App\EmbalmingTimelog::orderby("body_received_at","desc");

                if ($searcTerm){
                    
                    $q->join('users', 'embalming_timelog.shifted_by', '=', 'users.id');
                    $q->where(function($query) use ($searcTerm){
                        $query->where("deceased_name","like","%".$searcTerm."%")
                              ->orWhere("hospital","like","%".$searcTerm."%")
                              ->orWhere("users.name","like","%".$searcTerm."%")
                              ->orWhere("clothing","like","%".$searcTerm."%")
                              ->orWhere("photo","like","%".$searcTerm."%")
                              ->orWhere("coffin_model","like","%".$searcTerm."%")
                              ->orWhere("items_in_coffin","like","%".$searcTerm."%")
                              ->orWhere("embalming_start_at","like","%".$searcTerm."%")
                              ->orWhere("embalming_end_at","like","%".$searcTerm."%")
                              ->orWhere("dressing","like","%".$searcTerm."%")
                              ->orWhere("makeup","like","%".$searcTerm."%")
                              ->orWhere("body_sent_at","like","%".$searcTerm."%")
                              ->orWhere("status","like","%".$searcTerm."%");
                    });
                }
                if ($request->get("start")){
                    $q->where("body_received_at",">=",  date("Y-m-d", strtotime(str_replace("/","-",$request->get("start")))) . " 00:00:00");
                }

                if ($request->get("end")){
                    $q->where("body_received_at","<=",  date("Y-m-d", strtotime(str_replace("/","-",$request->get("end")))) . " 23:59:59");
                }
                $q->where("body_received_at",">=",  date("Y-m-d", strtotime("-6 days")) . " 00:00:00");
                $data["logs"] = $q->get();
            }
        }
        
        return view('embalming/timelog', $data);
    }
    
    public function searchDeceased(Request $request){
       
       $results = Shifting::where('deceased_name','like','%'.$request->get('term').'%')
                            ->where('status','<>','finished')
                            ->orderby('deceased_name')
                            ->get()->toArray();
       $arrResponse = array();
       foreach ($results as $key => $result){
           foreach($result as $propName => $propValue){
               $arrResponse[$key][$propName] = $propValue;
           }
       }
       return response()->json($arrResponse);
    }
}