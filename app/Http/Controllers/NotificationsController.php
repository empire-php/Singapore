<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Notification;
use App\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;

class NotificationsController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::User();
 
        $args = [
            'notifications' => Notification::where('receiver_id', Auth::User()->id)->where("show_as_popup",0)->orderBy('created_at', 'DESC')->get()
            //'notifications' => Notification::whereIn('action', $arrActions)->orderBy('created_at', 'DESC')->get()
        ];

        return view('notifications.index', $args);
    }
    
    public function popup(){
        
        $user = Auth::User();
        
        $notification = Notification::where("show_as_popup",1)->where("receiver_id", $user->id)->first();
        $arr = array();
        if ($notification){
            if ($notification->action == "coffin_slip"){
                $arr["show_pdf"] = 1;
            }
            $arr["id"] = $notification->id;
            $arr["content"] = $notification->title;
        }
        return response()->json($arr);
    }
    
    public function showPdf( $id ){
        $notification = Notification::find( $id );
        if ($notification && !empty($notification->link)){
            
            /*$pdf = PDF::loadView($notification->link); 
            return $pdf->stream();*/
            return response()->file($notification->link);
        }
        else{
            return "PDF not found";
        }
    }
    
    public function delete($id){
        if ($id){
            $notification = Notification::find($id);
            if ($notification){
                $notification->delete();
            }
        }
    }
}
