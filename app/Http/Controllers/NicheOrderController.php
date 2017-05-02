<?php

namespace App\Http\Controllers;

use App\NicheBlock;
use App\NicheCell;
use App\NicheColumn;
use App\NicheOrder;
use App\NicheRow;
use App\Notification;
use App\SelectOptionsCategories;
use App\SelectOptionsValues;
use App\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input as Input;
use Symfony\Component\HttpFoundation\Session\Session;
use Barryvdh\DomPDF\Facade as PDF;

class NicheOrderController extends Controller
{
    //
    const baseUrl = "/niche/";

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index(Request $request) {

        $user = Auth::user();
        $object = NicheOrder::where("is_draft",1)->where("created_by",$user->id)->first();

        if (!$object){
            $object = new NicheOrder();
            $object->created_by = $user->id;
            $object->is_draft = 1;
            $object->order_nr = $object->setNextNumber();
            $object->save();
        }

        $data["object"] = $object;

        $data["blocks"] = NicheBlock::all();
        $data["raceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RACE)->orderBy("id")->get();
        $data["terms_condition"] = Settings::where('name', 'niche')->get()->first();

        $data['session'] = new Session();

        return view('niche.index', $data);

    }

    public function view($id , Request $request)
    {
        // General data
        /*$data["religionOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        $data["raceOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RACE)->orderBy("id")->get();
        $data["sourceOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::SOURCE)->orderBy("id")->get();

        $data['item_selection'] = array();
        $data['order'] = \App\ColumbariumOrders::find($id);
        if ($data['order']){
            $data['item_selection'] = json_decode($data['order']->item_selection, true);
        }


        if (!$data['order']){
            return "Order not found";
        }

        $data['users'] = \App\User::all();
        $data['user'] = Auth::user();*/
        $object = NicheOrder::find($id);
        $data["object"] = $object;
        $data["raceOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RACE)->orderBy("id")->get();

        $blocks = NicheBlock::all();

        $data["blocks"] = $blocks;
        $data["terms_condition"] = Settings::where('name', 'niche')->get()->first();
        $data['session'] = new Session();
        return view(self::baseUrl . 'index', $data);
    }

    public function saveOrder(Request $request) {
        $bttn_clicked = $request->get("bttn_clicked"); // only in step 4
        $errors = 0;
        $msg = array();
        $changes_made = "";

        $session = new Session();
        $user = Auth::user();
        $order = NicheOrder::find($request->get("order_id"));

        // SAVE DATA
        // SAVE DATA
        $columns = \Schema::getColumnListing("niche_orders");
        $info2save = $request->all();
        foreach( $info2save as $key => $value ){
            if (in_array($key, $columns) && !in_array($key, array("files","created_at","order_nr","is_draft","funeral_arrangement_id"))){
                $order->{$key} = $value;
            }
        }

        $order->funeral_arrangement_id = $request->get("fa_id");

        if ($bttn_clicked) {
            if ($order->is_draft == 1) {
                $order->is_draft = 0;
                $changes_made = "new";
            }
            else {
                $changes_made = "update";
            }
        }

        //SIGNATURES
        if ($request->get("signature1")){
            $sign1 = ($request->get("signature1"))?$request->get("signature1"):$request->get("signature_image_1");
            $order->signatures = json_encode(array( 1 => $sign1));
            $order->signature_date = date("Y-m-d", strtotime(str_replace("/","-",$request->get("date_signature_1")))) ;
        }

        // SAVE FILE
        $files = null;
        $order_files = array();
        if ($request->hasFile('files')){
            $files = Input::file('files');
            foreach($files as $file){
                if ($file){
                    $destinationPath = public_path()."/uploads/niche";

                    if (!is_dir($destinationPath)){
                        mkdir($destinationPath);
                    }

                    $destinationPath = public_path()."/uploads/niche/".$order->order_nr;

                    if (!is_dir($destinationPath)){
                        mkdir($destinationPath);
                    }

                    $rules = array('file' => 'required');
                    $validator = Validator::make(array('file'=> $file), $rules);
                    if($validator->passes()){
                        $data = implode("", file($file->getPathName()));
                        $gzdata = gzencode($data, 9);
                        $fp = fopen($destinationPath."/".$file->getClientOriginalName().".gz", "w");
                        fwrite($fp, $gzdata);
                        fclose($fp);

                        $order_files[] = "niche/".$order->order_nr."/".$file->getClientOriginalName().".gz";
                    }
                    if (!is_file($destinationPath."/".$file->getClientOriginalName().".gz")){
                        $errors++;
                        $msg[] = "Error saving file";
                    }
                }
            }
        }

        $order->files = json_encode($order_files);

        if ($order->save()){
            $msg[] = "Information saved";
            if (!$request->ajax()){
                $operator_notification = new Notification();

                if($changes_made == "new") {
                    $notification_title = "New niche order created by ".$user->name;
                    $notification_action = "add_niche_order";
                    $notification_section = "Add niche order";
                    $notification_details = "";
                }
                else {
                    $notification_title = "The niche order updated by ".$user->name;
                    $notification_action = "update_niche_order";
                    $notification_section = "Update niche order";
                    $notification_details = "";
                }

                $operator_notification->title = $notification_title;
                $operator_notification->action = $notification_action;
                $operator_notification->page = '/niche';
                $operator_notification->section = $notification_section;
                $operator_notification->details = $notification_details;
                $operator_notification->receiver_type = 'user';
                $operator_notification->link = '/viewniche/'.$order->id;
                $operator_notification->creator_id = $user->id;
                $operator_notification->receiver_id = $user->id;
                $operator_notification->show_as_popup = 0;

                $operator_notification->save();

                $department_notification = new Notification();

                $department_notification->title = $notification_title;
                $department_notification->action = $notification_action;
                $department_notification->page = '/niche';
                $department_notification->section = $notification_section;
                $department_notification->details = $notification_details;
                $department_notification->receiver_type = 'department';
                $department_notification->link = '/viewniche/'.$order->id;
                $department_notification->creator_id = $user->id;
                $department_notification->receiver_id = $user->department_id;
                $department_notification->show_as_popup = 0;

                $department_notification->save();

                //set cell status to unavailable
                $cell_id = $order->niche_cell_id;
                if($cell_id != 0) {
                    $cell = NicheCell::find($cell_id);
                    $cell->status = 2;
                    $cell->save();
                }
            }
        }else{
            $msg[] = "Error saving data.";
            $errors++;
        }

        /*//PDF
        if ($bttn_clicked == "submit_print_bttn") {
            $tmp_pdf = storage_path().'/app/pdfs/ssc_buddhist_'.$order->order_nr.'.pdf';

            $data = array();

            $object = $order;

            $data["object"] = $object;

            if($object->niche_cell_id) {
                $data['cell'] = NicheCell::find($object->niche_cell_id);
                $data['row'] = NicheRow::find($data['cell']->niche_row_id);
                $data['column'] = NicheColumn::find($data['cell']->niche_column_id);
            }

            // General data

            $data["raceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RACE)->orderBy("id")->get();
            $data["terms_condition"] = Settings::where('name', 'niche')->get()->first();
            $pdf = PDF::loadView('niche/pdf', $data);
            $pdf->setPaper('a4', 'landscape')->setWarnings(false)->save($tmp_pdf);

        }*/


        //Email
        if ($bttn_clicked == "submit_email_bttn" || $bttn_clicked == "submit_other_email_bttn"){
            $found_email = $order->first_cp_email;
            if ($bttn_clicked == "submit_other_email_bttn"){
                $found_email = $request->get("new_email");
            }

            $email = filter_var($found_email, FILTER_VALIDATE_EMAIL);

            if ($email){
                $tmp_pdf = storage_path().'/app/pdfs/ssc_buddhist_'.$order->order_nr.'.pdf';


                $data = array();

                $object = $order;

                $data["object"] = $object;

                if($object->niche_cell_id) {
                    $data['cell'] = NicheCell::find($object->niche_cell_id);
                    $data['row'] = NicheRow::find($data['cell']->niche_row_id);
                    $data['column'] = NicheColumn::find($data['cell']->niche_column_id);
                }

                // General data

                $data["raceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RACE)->orderBy("id")->get();
                $data["terms_condition"] = Settings::where('name', 'niche')->get()->first();
                $pdf = PDF::loadView('niche/pdf', $data);
                $pdf->setPaper('a4', 'landscape')->setWarnings(false)->save($tmp_pdf);

                Mail::send('emails.new_scc_care', [], function($message) use ($email, $tmp_pdf){
                    $message->to( $email )
                        ->subject('New Niche Order form')
                        ->attach($tmp_pdf, array('mime' => 'application/pdf')
                        );
                });
                unlink($tmp_pdf);

                if(count(Mail::failures()) > 0){
                    $msg[] = "Error sending mail.";
                    $errors++;
                }
                else{
                    $msg[] = "Mail to $email sent OK.";
                }
            }
            else{
                $msg[] = "Email not valid ($found_email).";
                $errors++;
            }
        }


        if ($request->ajax())
        {
            return response()->json([
                'msg' => implode("<br />",$msg),
                'errors' => $errors,
            ]);
        }
        else{

            $session = new Session();
            $session->set("niche_msg", $msg);
            $session->set("niche_errors", $errors);
            if ($request->get("bttn_clicked") == "submit_print_bttn"){
                $session->set("niche_".$order->id."_open_pdf", 1);
            }
            return Redirect::to( self::baseUrl . 'view/'.$order->id);


        }

    }

    public function generatePdf( $id ){

        $order = NicheOrder::find($id);
        $tmp_pdf = storage_path().'/app/pdfs/ssc_buddhist_'.$order->order_nr.'.pdf';

        $data = array();

        $object = $order;

        $data["object"] = $object;

        // General data

        $data["raceOptions"] = SelectOptionsValues::where('select_options_category_id',SelectOptionsCategories::RACE)->orderBy("id")->get();
        $data["terms_condition"] = Settings::where('name', 'niche')->get()->first();
        $pdf = PDF::loadView('niche/pdf', $data);
        $pdf->setPaper('a4', 'landscape')->setWarnings(false)->save($tmp_pdf);

        return $pdf->stream();
    }

    public function viewOrder(Request $request) {
        $user = Auth::user();


        $limit = $request->get("limit",5);
        $offset = ($request->get("p",1) - 1) * $limit;
        $data["forms"] = NicheOrder::where("created_by", $user->id)
            ->where("is_draft",0)
            ->orderby($request->get("sort","created_at"), $request->get("ord","desc"))
            //->limit($limit)
            //->offset($offset)
            ->get();
        return view('niche/listing', $data);
    }


}
