<?php
/**
 * SMS controller.
 * User: Jinandra
 * Date: 08-12-2016
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ContactForm;
use App\Http\Requests\SendSMSRequest;
use App\SMSMessage;
use App\User;
use App\FuneralArrangements;
use Carbon\Carbon;
use DB;
use App\ParlourOrders;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class SMSController
 * @package App\Http\Controllers
 */
class SMSController extends Controller
{
    const baseUrl = "/smsnotification/";
    const viewFolder = "smsnotification/";
    
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
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user();
        $data = array();
        $pointsContactData = array();
        $data["user"] = $user;
        
        $allUsersData = User::all();
        $data["usersdata"] = $allUsersData;
        
        $allPointsContactData = \App\FuneralArrangements::where('first_cp_name','<>','')->orWhere('second_cp_name','<>','')->get();
        
        if( $allPointsContactData ){
            foreach($allPointsContactData as $pointConactKey=>$allPointsContactDataVal){
                if( $allPointsContactDataVal->first_cp_name != "" ){
                    $pointsContactData[] = array("first_cp_id"=>$allPointsContactDataVal->id, "first_cp_name"=>$allPointsContactDataVal->first_cp_name, "second_cp_id"=>"", "second_cp_name"=>"");
                }
                if( $allPointsContactDataVal->second_cp_name != "" ){
                    $pointsContactData[] = array("first_cp_id"=>"", "first_cp_name"=>"", "second_cp_id"=>$allPointsContactDataVal->id, "second_cp_name"=>$allPointsContactDataVal->second_cp_name);
                }
            }
        }
        
        $data["pointsContactDat"] = $pointsContactData;
        
        return view(self::viewFolder.'index', $data);
    }
    
    public function listing(Request $request)
    {
        
        $smsData = SMSMessage::getSMSNotification();
        $arr["data"] = array();
        
        if( $smsData ){
            foreach($smsData as $smsdataval){
                $arr["data"][] = array($smsdataval->display_name, $smsdataval->recipient_no, $smsdataval->recipient_name, date("d-m-Y", strtotime($smsdataval->date)), $smsdataval->time, $smsdataval->message, $smsdataval->name, $smsdataval->status);
            }
        }
        return response()->json($arr);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $contactForm = ContactForm::find($id);
        $messages = SMSMessage::paginate(20);

        return view('pages.sms', compact('messages', 'contactForm'));
    }

    /**
     * @param SendSMSRequest $request
     * @return mixed
     */
    public function send(SendSMSRequest $request)
    {
        $date = Carbon::create();

        $sentById = Auth::user()->id;
        
        $sms = SMSMessage::create([
            'display_name' => $request->display_name,
            'recipient_no' => $request->recipient_no,
            'recipient_name' => $request->display_name,
            'date' => $date->toDateString(),
            'time' => $date->toTimeString(),
            'message' => $request->message,
            'sent_by' => $sentById,
            'status' => 'none'
        ]);

        $smsmessage = $sms->message." : ".$request->display_name;
        $sms->status = $this->sendViaApi($sms->display_name, $sms->recipient_no, $smsmessage);
        
        $sms->save();

        if($sms->status == 'Fail') {
            $error = 'SMS sending error';
            return redirect('smsnotification/sms')->with('error', $error);
        } else {
            $success = 'SMS successfully sent!';
            return redirect('smsnotification/sms')->with('success', $success);
        }
    }

    /**
     * @param $sms_from
     * @param $sms_to
     * @param $sms_msg
     * @return string
     */
    public function sendViaApi($sms_from, $sms_to,$sms_msg)
    {
        $result = 'Fail';
        
        $query_string = "api.aspx?apiusername=APIC405RN4YFL&apipassword=APIC405RN4YFLC405R";
        $query_string .= "&senderid=".rawurlencode($sms_from)."&mobileno=".rawurlencode($this->checkNumber($sms_to));
        $query_string .= "&message=".rawurlencode(stripslashes($sms_msg)) . "&languagetype=1";
        $url = "http://gateway.onewaysms.sg:10002/".$query_string;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $fd = curl_exec($ch);
        //$fd = @implode ('', file ($url));        
        if ($fd)
        {
            $secondurl = "http://gateway.onewaysms.sg:10002/bulktrx.aspx/?mtid=" . $fd;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_URL, $secondurl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $status = curl_exec($ch);
            //$status = @implode ('', file ("http://gateway.onewaysms.sg:10002/bulktrx.aspx/?mtid=" . $fd));
            $result = $status == 100 ? 'Success' : 'Fail';
        }
        else
        {
            $result = 'Fail';
        }

        return $result;
    }

    /**
     * @param $number
     * @return string
     */
    public function checkNumber($number)
    {
        if(strlen($number) == 8 && (substr($number, 0, 1) == 8 || substr($number, 0, 1) == 9)) {
            return ('65' . $number);
        }
        
        return $number;
    }
    
    /*
     * Author: Jinandra
     * Search user by user id
     * @param int $request
     */
    public function searchFuneral(Request $request){
       
       $results = \App\FuneralArrangements::where('id','=',$request->get('funeral_id'))->get()->toArray();
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
}