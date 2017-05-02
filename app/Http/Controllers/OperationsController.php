<?php

/*
 * Author: Jinandra
 * Date: 07-12-2016
 * Operation Controller
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Settings;
use App\Shifting;
use App\User;
use App\Company;
use App\Operationservice;
use App\FuneralArrangements;
use DB;
use Input;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Session\Session;

class OperationsController extends Controller
{
    const baseUrl = "/operations_check_list/";
    const viewFolder = "operations_check_list/";
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
        $sessionObj = new Session();
        
        $allUsersData = User::all();
        $data["usersdata"] = $allUsersData;
        $data['session'] = new Session();
        $data['religionOptions'] =  \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        if($sessionObj->get("checklist")==""){
            $data['data']['fa_op_code'] = "";
            $data['data']['deceased_title'] = "";
            $data['data']['deceased_name'] = "";
            $data['data']['deceased_religion'] = "";
            $data['data']['deceased_church'] = "";
            $data['data']['deceased_sex'] = "";
            $data['data']['deceased_race'] = "";
            $data['data']['deceased_dialects'] = "";
            $data['data']['deceased_dob'] = "";
            $data['data']['deceased_dod'] = "";
            $data['data']['shifting_hospital'] = "";
            $data['data']['shifting_embalming'] = "";
            $data['data']['shifting_supervisor'] = "";
            $data['data']['shifting_ot'] = "";
            $data['data']['shifting_date_left'] = "";
            $data['data']['shifting_date_return'] = "";
            $data['data']['shifting_time_left'] = "";
            $data['data']['shifting_time_return'] = "";
            $data['data']['shifting_dressing_supervisor'] = "";
            $data['data']['shifting_remarks'] = "";
            $data['data']['sending_parlour_others'] = "";
            $data['data']['sending_detils_users_ids'] = array();
            $data['data']['sending_ot'] = "";
            $data['data']['sending_date_left'] = "";
            $data['data']['sending_date_return'] = "";
            $data['data']['sending_time_left'] = "";
            $data['data']['sending_time_return'] = "";
            $data['data']['shifting_waitfor'] = "";
            $data['data']['shifting_backdrop'] = "";
            $data['data']['sending_time'] = "";
            $data['data']['sending_informed_at'] = "";
            $data['data']['sending_bethere_at'] = "";
            $data['data']['photo_enlargement'] = "";
            $data['data']['cross_wreath'] = "";
            $data['data']['others_option'] = "";
            $data['data']['photo_wreath'] = "";
            $data['data']['table_wreath'] = "";
            $data['data']['special_notice_flower'] = "";
            $data['data']['passport_photo'] = "";
            $data['data']['number_of_boxes'] = "";
            $data['data']['candle_set_flower'] = "";
            $data['data']['crucifix_taken'] = "";
            $data['data']['crucifix_return'] = "";
            $data['data']['cross_stand_taken'] = "";
            $data['data']['cross_stand_return'] = "";
            $data['data']['coffin_stand_taken'] = "";
            $data['data']['coffin_stand_return'] = "";
            $data['data']['coffin_stand2_taken'] = "";
            $data['data']['coffin_stand2_return'] = "";
            $data['data']['coffin_stand3_taken'] = "";
            $data['data']['coffin_stand3_return'] = "";
            $data['data']['stand_cover_taken'] = "";
            $data['data']['stand_cover_return'] = "";
            $data['data']['stand_cover2_taken'] = "";
            $data['data']['stand_cover2_return'] = "";
            $data['data']['stand_cover3_taken'] = "";
            $data['data']['stand_cover3_return'] = "";
            $data['data']['backdrop_taken'] = "";
            $data['data']['backdrop_return'] = "";
            $data['data']['backdrop1_taken'] = "";
            $data['data']['backdrop1_return'] = "";
            $data['data']['backdrop2_taken'] = "";
            $data['data']['backdrop2_return'] = "";
            $data['data']['backdrop_stand_taken'] = "";
            $data['data']['backdrop_stand_return'] = "";
            $data['data']['backdrop_stand1_taken'] = "";
            $data['data']['backdrop_stand1_return'] = "";
            $data['data']['backdrop_stand2_taken'] = "";
            $data['data']['backdrop_stand2_return'] = "";
            $data['data']['photo_stand_taken'] = "";
            $data['data']['photo_stand_return'] = "";
            $data['data']['photo_stand1_taken'] = "";
            $data['data']['photo_stand1_return'] = "";
            $data['data']['photo_stand2_taken'] = "";
            $data['data']['photo_stand2_return'] = "";
            $data['data']['table_cloth_taken'] = "";
            $data['data']['table_cloth_return'] = "";
            $data['data']['table_cloth1_taken'] = "";
            $data['data']['table_cloth1_return'] = "";
            $data['data']['table_cloth2_taken'] = "";
            $data['data']['table_cloth2_return'] = "";
            $data['data']['buddhist_table_cloth_taken'] = "";
            $data['data']['buddhist_table_cloth_return'] = "";
            $data['data']['carpet_taken'] = "";
            $data['data']['carpet_return'] = "";
            $data['data']['carpet1_taken'] = "";
            $data['data']['carpet1_return'] = "";
            $data['data']['zinc_taken'] = "";
            $data['data']['zinc_return'] = "";
            $data['data']['candles_taken'] = "";
            $data['data']['candles_return'] = "";
            $data['data']['candles1_taken'] = "";
            $data['data']['candles1_return'] = "";
            $data['data']['candles_white_taken'] = "";
            $data['data']['candles_white_return'] = "";
            $data['data']['holy_water_bottle_taken'] = "";
            $data['data']['holy_water_bottle_return'] = "";
            $data['data']['special_notice_stand_taken'] = "";
            $data['data']['special_notice_stand_return'] = "";
            $data['data']['special_notice_stand1_taken'] = "";
            $data['data']['special_notice_stand1_return'] = "";
            $data['data']['prayer_books_taken'] = "";
            $data['data']['prayer_books_return'] = "";
            $data['data']['contribution_book_taken'] = "";
            $data['data']['contribution_book_return'] = "";
            $data['data']['contribution_book1_taken'] = "";
            $data['data']['contribution_book1_return'] = "";
            $data['data']['special_notice_taken'] = "";
            $data['data']['special_notice_return'] = "";
            $data['data']['check_vehicles_hearse'] = "";
            $data['data']['funeral_date'] = "";
            $data['data']['funeral_customer'] = "";
            $data['data']['funeral_leaving_sc'] = "";
            $data['data']['funeral_leaving_parlour'] = "";
            $data['data']['funeral_church'] = "";
            $data['data']['funeral_time1'] = "";
            $data['data']['funeral_to'] = "";
            $data['data']['funeral_time2'] = "";
            $data['data']['funeral_bus'] = "";
            $data['data']['funeral_flowers'] = "";
            $data['data']['funeral_information_users_ids'] = array();
            $data['data']['funeral_hearsevan'] = "";
            $data['data']['funeral_ashes'] = "";
            $data['data']['funeral_time3'] = "";
            $data['data']['funeral_date_time_left'] = "";
            $data['data']['funeral_date_time_return'] = "";
            $data['data']['funeral_ot'] = "";
            $data['data']['funeral_time4'] = "";
            $data['data']['funeral_remarks'] = "";
            $data['data']['funeral_spokento'] = "";
        }

        return view(self::viewFolder.'index', $data);
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
    
    
    public function searchDeceased(Request $request){
       
       $results = \App\Shifting::where('deceased_name','=',$request->get('deceased_name'))->get()->toArray();
       $arrResponse = array();
       foreach ($results as $key => $result){
           foreach($result as $propName => $propValue){
               $arrResponse[$key][$propName] = $propValue;
           }
       }
       //echo "<pre>";
       //print_r($arrResponse);
       return response()->json($arrResponse);
    }
    
    public function operationChecklistSave(Request $request){
        
        $data = array();
        $session = new Session();
        
        $data['fa_op_code'] = $request->get('fa_op_code');
        $data['deceased_title'] = $request->get('deceased_title');
        $data['deceased_name'] = $request->get('deceased_name');
        $data['deceased_religion'] = $request->get('deceased_religion');
        $data['deceased_church'] = $request->get('deceased_church');
        $data['deceased_sex'] = $request->get('deceased_sex');
        $data['deceased_race'] = $request->get('deceased_race');
        $data['deceased_dialects'] = $request->get('deceased_dialects');
        $data['deceased_dob'] = $request->get('deceased_dob');
        $data['deceased_dod'] = $request->get('deceased_dod');
        $data['shifting_hospital'] = $request->get('shifting_hospital');
        $data['shifting_embalming'] = $request->get('shifting_embalming');
        $data['shifting_supervisor'] = $request->get('shifting_supervisor');
        $data['shifting_ot'] = $request->get('shifting_ot');
        $data['shifting_date_left'] = $request->get('shifting_date_left');
        $data['shifting_date_return'] = $request->get('shifting_date_return');
        $data['shifting_time_left'] = $request->get('shifting_time_left');
        $data['shifting_time_return'] = $request->get('shifting_time_return');
        $data['shifting_dressing_supervisor'] = $request->get('shifting_dressing_supervisor');
        $data['shifting_remarks'] = $request->get('shifting_remarks');
        $data['sending_parlour_others'] = $request->get('sending_parlour_others');
        if( !empty($request->get('sending_detils_users_ids')) ) {
            $data['sending_detils_users_ids'] = $request->get('sending_detils_users_ids');
        } else {
            $data['sending_detils_users_ids'] = array();
        }
        $data['sending_ot'] = $request->get('sending_ot');
        $data['sending_date_left'] = $request->get('sending_date_left');
        $data['sending_date_return'] = $request->get('sending_date_return');
        $data['sending_time_left'] = $request->get('sending_time_left');
        $data['sending_time_return'] = $request->get('sending_time_return');
        $data['shifting_waitfor'] = $request->get('shifting_waitfor');
        $data['shifting_backdrop'] = $request->get('shifting_backdrop');
        $data['sending_time'] = $request->get('sending_time');
        $data['sending_informed_at'] = $request->get('sending_informed_at');
        $data['sending_bethere_at'] = $request->get('sending_bethere_at');
        $data['photo_enlargement'] = $request->get('photo_enlargement');
        $data['cross_wreath'] = $request->get('cross_wreath');
        $data['others_option'] = $request->get('others_option');
        $data['photo_wreath'] = $request->get('photo_wreath');
        $data['table_wreath'] = $request->get('table_wreath');
        $data['special_notice_flower'] = $request->get('special_notice_flower');
        $data['passport_photo'] = $request->get('passport_photo');
        $data['number_of_boxes'] = $request->get('number_of_boxes');
        $data['candle_set_flower'] = $request->get('candle_set_flower');
        $data['crucifix_taken'] = $request->get('crucifix_taken');
        $data['crucifix_return'] = $request->get('crucifix_return');
        $data['cross_stand_taken'] = $request->get('cross_stand_taken');
        $data['cross_stand_return'] = $request->get('cross_stand_return');
        $data['coffin_stand_taken'] = $request->get('coffin_stand_taken');
        $data['coffin_stand_return'] = $request->get('coffin_stand_return');
        $data['coffin_stand2_taken'] = $request->get('coffin_stand2_taken');
        $data['coffin_stand2_return'] = $request->get('coffin_stand2_return');
        $data['coffin_stand3_taken'] = $request->get('coffin_stand3_taken');
        $data['coffin_stand3_return'] = $request->get('coffin_stand3_return');
        $data['stand_cover_taken'] = $request->get('stand_cover_taken');
        $data['stand_cover_return'] = $request->get('stand_cover_return');
        $data['stand_cover2_taken'] = $request->get('stand_cover2_taken');
        $data['stand_cover2_return'] = $request->get('stand_cover2_return');
        $data['stand_cover3_taken'] = $request->get('stand_cover3_taken');
        $data['stand_cover3_return'] = $request->get('stand_cover3_return');
        $data['backdrop_taken'] = $request->get('backdrop_taken');
        $data['backdrop_return'] = $request->get('backdrop_return');
        $data['backdrop1_taken'] = $request->get('backdrop1_taken');
        $data['backdrop1_return'] = $request->get('backdrop1_return');
        $data['backdrop2_taken'] = $request->get('backdrop2_taken');
        $data['backdrop2_return'] = $request->get('backdrop2_return');
        $data['backdrop_stand_taken'] = $request->get('backdrop_stand_taken');
        $data['backdrop_stand_return'] = $request->get('backdrop_stand_return');
        $data['backdrop_stand1_taken'] = $request->get('backdrop_stand1_taken');
        $data['backdrop_stand1_return'] = $request->get('backdrop_stand1_return');
        $data['backdrop_stand2_taken'] = $request->get('backdrop_stand2_taken');
        $data['backdrop_stand2_return'] = $request->get('backdrop_stand2_return');
        $data['photo_stand_taken'] = $request->get('photo_stand_taken');
        $data['photo_stand_return'] = $request->get('photo_stand_return');
        $data['photo_stand1_taken'] = $request->get('photo_stand1_taken');
        $data['photo_stand1_return'] = $request->get('photo_stand1_return');
        $data['photo_stand2_taken'] = $request->get('photo_stand2_taken');
        $data['photo_stand2_return'] = $request->get('photo_stand2_return');
        $data['table_cloth_taken'] = $request->get('table_cloth_taken');
        $data['table_cloth_return'] = $request->get('table_cloth_return');
        $data['table_cloth1_taken'] = $request->get('table_cloth1_taken');
        $data['table_cloth1_return'] = $request->get('table_cloth1_return');
        $data['table_cloth2_taken'] = $request->get('table_cloth2_taken');
        $data['table_cloth2_return'] = $request->get('table_cloth2_return');
        $data['buddhist_table_cloth_taken'] = $request->get('buddhist_table_cloth_taken');
        $data['buddhist_table_cloth_return'] = $request->get('buddhist_table_cloth_return');
        $data['carpet_taken'] = $request->get('carpet_taken');
        $data['carpet_return'] = $request->get('carpet_return');
        $data['carpet1_taken'] = $request->get('carpet1_taken');
        $data['carpet1_return'] = $request->get('carpet1_return');
        $data['zinc_taken'] = $request->get('zinc_taken');
        $data['zinc_return'] = $request->get('zinc_return');
        $data['candles_taken'] = $request->get('candles_taken');
        $data['candles_return'] = $request->get('candles_return');
        $data['candles1_taken'] = $request->get('candles1_taken');
        $data['candles1_return'] = $request->get('candles1_return');
        $data['candles_white_taken'] = $request->get('candles_white_taken');
        $data['candles_white_return'] = $request->get('candles_white_return');
        $data['holy_water_bottle_taken'] = $request->get('holy_water_bottle_taken');
        $data['holy_water_bottle_return'] = $request->get('holy_water_bottle_return');
        $data['special_notice_stand_taken'] = $request->get('special_notice_stand_taken');
        $data['special_notice_stand_return'] = $request->get('special_notice_stand_return');
        $data['special_notice_stand1_taken'] = $request->get('special_notice_stand1_taken');
        $data['special_notice_stand1_return'] = $request->get('special_notice_stand1_return');
        $data['prayer_books_taken'] = $request->get('prayer_books_taken');
        $data['prayer_books_return'] = $request->get('prayer_books_return');
        $data['contribution_book_taken'] = $request->get('contribution_book_taken');
        $data['contribution_book_return'] = $request->get('contribution_book_return');
        $data['contribution_book1_taken'] = $request->get('contribution_book1_taken');
        $data['contribution_book1_return'] = $request->get('contribution_book1_return');
        $data['special_notice_taken'] = $request->get('special_notice_taken');
        $data['special_notice_return'] = $request->get('special_notice_return');
        $data['check_vehicles_hearse'] = $request->get('check_vehicles_hearse');
        $data['funeral_date'] = $request->get('funeral_date');
        $data['funeral_customer'] = $request->get('funeral_customer');
        $data['funeral_leaving_sc'] = $request->get('funeral_leaving_sc');
        $data['funeral_leaving_parlour'] = $request->get('funeral_leaving_parlour');
        $data['funeral_church'] = $request->get('funeral_church');
        $data['funeral_time1'] = $request->get('funeral_time1');
        $data['funeral_to'] = $request->get('funeral_to');
        $data['funeral_time2'] = $request->get('funeral_time2');
        $data['funeral_bus'] = $request->get('funeral_bus');
        $data['funeral_flowers'] = $request->get('funeral_flowers');
        if( !empty($request->get('funeral_information_users_ids')) ) {
            $data['funeral_information_users_ids'] = $request->get('funeral_information_users_ids');
        } else {
            $data['funeral_information_users_ids'] = array();
        }
        $data['funeral_hearsevan'] = $request->get('funeral_hearsevan');
        $data['funeral_ashes'] = $request->get('funeral_ashes');
        $data['funeral_time3'] = $request->get('funeral_time3');
        $data['funeral_date_time_left'] = $request->get('funeral_date_time_left');
        $data['funeral_date_time_return'] = $request->get('funeral_date_time_return');
        $data['funeral_ot'] = $request->get('funeral_ot');
        $data['funeral_time4'] = $request->get('funeral_time4');
        $data['funeral_remarks'] = $request->get('funeral_remarks');
        $data['funeral_spokento'] = $request->get('funeral_spokento');
        
        
        $session->set("checklist", $data);
        //$session->set("go_errors", $errors);
            
        return redirect()->back()->with('flash_message', "Information Saved Successfully");
        
    }
    
    
    public function operationService(Request $request)
    {
        $user = Auth::user();
        $data = array();
        $data["user"] = $user;
        
        $allUsersData = User::all();
        $data["usersdata"] = $allUsersData;
        
        $data["company_prefix"] = Company::getCurrentCompanyPrefix();
        
        if( $request->get("ord") != "" && $request->get("ordby") != ""){
            $orderbyTbl = $request->get('ord');
            $orderby = $request->get("ordby");
            
            $orderbyTblVal = $orderbyTbl;
            $data["ordrTableName"] = $orderbyTbl;
            $data["ordrTblBy"] = $orderby;
        } else{
            $orderbyTblVal = "funeral_date";
            $orderby = "desc";
        }
        
        $data["forms"] = FuneralArrangements::getFAWithOperationService($orderbyTblVal, $orderby);
        
        $opServiceQry = Operationservice::select("*");        
        $operationServiceData = $opServiceQry->get();
        $f = 1;
        
        foreach($operationServiceData as $opDataVal){
            $data['operationservicestaff'][$opDataVal->fa_id] = $opDataVal->membersServiceStaff()->getRelatedIds()->toArray();
            $data['operationserviceteam'][$opDataVal->fa_id] = $opDataVal->membersServiceTeam()->getRelatedIds()->toArray();
            $data['operationservicenightmare'][$opDataVal->fa_id] = $opDataVal->membersNightCare()->getRelatedIds()->toArray();
            $f++;            
        }
        //echo "<pre>";
        //print_r($data);
        //die();
        
        return view(self::viewFolder.'opservice', $data);
    }
    
    
    public function operationServieSave(Request $request){
        
        $faOperationObj = new Operationservice();
        
        $user = Auth::user();
        $errors = 0;
        $insertRes = "";
        $updateRes = "";
        $funeraIds = "";
        
        $msg = array();   
        $funeraIdsArr = array();
        
        $funeraIds = $request->get("faids");
        
        if( $funeraIds )
        {
            $funeraIdsArr = explode(",", $funeraIds);
            
            foreach( $funeraIdsArr as $funeraIdsVal ){
                $sign1 = "";
                $sign2 = "";
                $sign3 = "";
                $users_ids1 = array();
                $signature_service_staff = "";
                $signature_service_team = "";
                $signature_night_care = "";
                
                $users_ids1 = $request->get('users_ids1'.$funeraIdsVal);
                $users_ids2 = $request->get('users_ids2'.$funeraIdsVal);
                $users_ids3 = $request->get('users_ids3'.$funeraIdsVal);
                
                if ($request->get("signature1".$funeraIdsVal) || $request->get("signature_image_1".$funeraIdsVal)){
                    $sign1 = ($request->get("signature1".$funeraIdsVal))?$request->get("signature1".$funeraIdsVal):$request->get("signature_image_1".$funeraIdsVal);
                    $signature_service_staff = $sign1;
                }
                
                if ($request->get("signature2".$funeraIdsVal) || $request->get("signature_image_2".$funeraIdsVal)){
                    $sign2 = ($request->get("signature2".$funeraIdsVal))?$request->get("signature2".$funeraIdsVal):$request->get("signature_image_2".$funeraIdsVal);
                    $signature_service_team = $sign2;
                }
                
                if ($request->get("signature3".$funeraIdsVal) || $request->get("signature_image_3".$funeraIdsVal)){
                    $sign3 = ($request->get("signature3".$funeraIdsVal))?$request->get("signature3".$funeraIdsVal):$request->get("signature_image_3".$funeraIdsVal);
                    $signature_night_care = $sign3;
                }
        
                $dataCheck = $faOperationObj->checkOperationAlreadyExists($funeraIdsVal);
                
                if( $dataCheck ){
                    $postdataarr = array(
                                        'fa_id' => $funeraIdsVal,
                                        'signature_service_staff' => $signature_service_staff,
                                        'signature_service_team' => $signature_service_team,
                                        'signature_night_care' => $signature_night_care
                                    );
                    $updateRes = $faOperationObj->updateOperationService($postdataarr);
                    
                    $opObj = Operationservice::find($dataCheck->id);
                    
                    $opObj->membersServiceStaff()->sync($users_ids1 ? $users_ids1 : []);
                    $opObj->membersServiceTeam()->sync($users_ids2 ? $users_ids2 : []);
                    $opObj->membersNightCare()->sync($users_ids3 ? $users_ids3 : []);
                    
                    
                } else {
                    $postdataarr = array(
                                        'fa_id' => $funeraIdsVal,
                                        'signature_service_staff' => $signature_service_staff,
                                        'signature_service_team' => $signature_service_team,
                                        'signature_night_care' => $signature_night_care
                                    );
                    $insertRes = $faOperationObj->insertOperationService($postdataarr);
                    
                    $lastinsert_id = $insertRes;
                    
                    $opObj = Operationservice::find($lastinsert_id);
                    
                    $opObj->membersServiceStaff()->sync($users_ids1 ? $users_ids1 : []);
                    $opObj->membersServiceTeam()->sync($users_ids2 ? $users_ids2 : []);
                    $opObj->membersNightCare()->sync($users_ids3 ? $users_ids3 : []);
                    
                }
            }
        }
        
        return redirect()->back()->with('flash_message', "Information Saved Successfully");

    }
}
