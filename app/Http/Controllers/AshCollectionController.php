<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect as Redirect;
use Barryvdh\DomPDF\Facade as PDF;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input as Input;
use Validator;

class AshCollectionController extends Controller
{
    const baseUrl = "/ashcollection/";
    const viewFolder = "ash_collection/";
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
        $form = \App\AshCollectionForms::where("user_id",$user->id)->where("is_draft","1")->first();

        if (!$form){
            $form = new \App\AshCollectionForms();
            $form->is_draft = 1;
            $form->user_id = $user->id;
            $form->save();
        }
        $data['form'] = $form;
        $data['user'] = $user;
        
        $data["religionOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        $data['users'] = \App\User::all();
        $data['session'] = new Session();
        return view( self::viewFolder.'index', $data);
    }
    
    public function listing(Request $request) {
        $user = Auth::user(); 
        
        $limit = $request->get("limit",5);
        $offset = ($request->get("p",1) - 1) * $limit;
        $data["forms"] = \App\AshCollectionForms::where("user_id", $user->id)
                                            ->where("is_draft",0)
                                            ->orderby($request->get("sort","created_at"), $request->get("ord","desc"))
                                            ->get();
        
        
        
        return view('ash_collection/listing', $data);
    }
    
    public function view($id , Request $request)
    {
        $user = Auth::user();
        
        $data = array();
        if ($id){
            $form = \App\AshCollectionForms::find($id);
        }

        $data['form'] = $form;
        $data['user'] = $user;
        
        $data["religionOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        $data['users'] = \App\User::all();
        $data['session'] = new Session();
        return view( self::viewFolder.'index', $data);
    }
    

    
    public function saveForm(Request $request){
        
        $errors = 0;
        $msg = array();        

        if( $request->get("id") ){
            $form = \App\AshCollectionForms::find($request->get("id"));
        }

        if (!$request->ajax()){
            $form->is_draft = 0;
        }
        
        // SAVE DATA
        $columns = \Schema::getColumnListing("ash_collection_forms");
        $info2save = $request->all();
        foreach( $info2save as $key => $value ){
            if (in_array($key, $columns) && !in_array($key, array("files","created_at"))){
                $form->{$key} = $value;
            }
        }
        
        //SIGNATURES
        if ($request->get("signature1") || $request->get("signature2")){
            $sign1 = ($request->get("signature1"))?$request->get("signature1"):$request->get("signature_image_1","");
            $sign2 = ($request->get("signature1"))?$request->get("signature2"):$request->get("signature_image_2","");
      
            
            $form->signatures = json_encode(array( 
                                                    "signatures" => array(
                                                        1 => $sign1,
                                                        2 => $sign2
                                                    ),
                                                    "dates" => array(
                                                        1 => date("Y-m-d", strtotime(str_replace("/","-",$request->get("date_signature_1", date("Y-m-d"))))),
                                                        2 => date("Y-m-d", strtotime(str_replace("/","-",$request->get("date_signature_2", date("Y-m-d")))))
                                                    )
                                                ));
        }

        
        $form->save();

        if ($form->save()){
            $msg[] = "Information saved";
        }
        
        
        
        // MAIL
        if ($request->get("bttn_clicked") == "submit_email_bttn" || $request->get("bttn_clicked") == "submit_other_email_bttn"){    
            if ($request->get("bttn_clicked") == "submit_email_bttn"){
                $found_email = ($request->get("confirmed_by_email") != "")?$request->get("confirmed_by_email"):$request->get("received_by_email");
            }
            else{
                $found_email = $request->get("new_email");
            }

            $email = filter_var($found_email, FILTER_VALIDATE_EMAIL);
            
            if ($email){
                $tmp_pdf = resource_path().'/ash_collection_form_'.$form->id.'.pdf';
                
                
                $user = Auth::user();
                $data = array();
                $data['form'] = $form;
                $data['user'] = $user;
                $data["religionOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RELIGION)->orderBy("id")->get();
                $data['users'] = \App\User::all();                
                $pdf = PDF::loadView( self::viewFolder .'pdf', $data);
                $pdf->setPaper('a4', 'portrait')->setWarnings(false)->save($tmp_pdf);

                Mail::send('emails.new_ash_collection_form', [], function($message) use ($email, $tmp_pdf){
                    $message->to( $email )
                            ->subject('Ash Collection Form')
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
                'errors' => $errors
            ]);
        }
        else{
            $session = new Session();
            $session->set("ac_msg", $msg);
            $session->set("ac_errors", $errors);
            if ($request->get("bttn_clicked") == "submit_print_bttn"){
                $session->set("ac_open_pdf", 1);
            }
            return Redirect::to( self::baseUrl . 'view/'.$form->id);
        }
    }
    
    public function deleteCurrentDraft(){
        $user = Auth::user();
        $drafts = \App\AshCollectionForms::where("user_id",$user->id)->where("is_draft","1")->get();
        foreach ($drafts as $draft){
            $draft->delete();
        }
        return 1;
    }
    
    
    public function generatePdf( $id ){

        $user = Auth::user();
        
        $data = array();
        if ($id){
            $form = \App\AshCollectionForms::find($id);
        }
        if (!$form ){
            return "Form not found";
        }
        
        $data['form'] = $form;
        $data['user'] = $user;
        
        $data["religionOptions"] = \App\SelectOptionsValues::where('select_options_category_id',\App\SelectOptionsCategories::RELIGION)->orderBy("id")->get();
        $data['users'] = \App\User::all();
    
        $pdf = PDF::loadView( self::viewFolder . 'pdf', $data); 
        return $pdf->stream();

    }
    
    public function searchFA(Request $request){
       
        $results = \App\FuneralArrangements::select('funeral_arrangements.*')
                                            ->where('generated_code','like','%'.$request->get('term').'%')
                                            ->orderby('generated_code')->get()->toArray();
        $arrResponse = array();
        foreach ($results as $key => $result){
            $co = \App\ColumbariumOrders::select('niche_location','slab_install','photo_install','type_of_install','meet_family','slab_remarks as remarks')
                    ->where("funeral_arrangement_id",$result["id"])->limit(1)->get()->toArray();

            if ($co){
                foreach($co[0] as $cKey => $cValue){
                    $arrResponse[$key][$cKey] = $cValue;
                }
            }
            foreach($result as $propName => $propValue){
                if (!in_array($propName, array("signatures"))){
                    $arrResponse[$key][$propName] = $propValue;
                }
            }
        }
        return response()->json($arrResponse);
    }
    
    public function searchDeceasedName(Request $request){
       
       $results = \App\Shifting::where('deceased_name','like','%'.$request->get('term').'%')->orderby('id','desc')->get()->toArray();
       return response()->json($results);
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
}
