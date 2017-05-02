<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;


class InvoiceController extends Controller
{
 const viewFolder = "invoices/";
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



    public function listing(Request $request) {
        $user = Auth::user();

            $data=  \App\FuneralArrangements::where("user_id",$user->id)->where("is_draft",0)->orderBy("id","DESC")->get();
       //     $pending['parlour'] = \App\ParlourOrders::where("funeral_arrangement_id",$data['fa']->id)->first();
        //    $pending['hearse'] = \App\HearseOrders::where("funeral_arrangement_id",$data['fa']->id)->first();
       //     $pending['gemstone'] = \App\GemstoneOrders::where("funeral_arrangement_id",$data["fa"]->id)->first();
       //     $pending['columbarium'] = \App\ColumbariumOrders::where("funeral_arrangement_id",$data['fa']->id)->first();

        return view('invoices/index', array("form"=>$data));
    }


    public function genInvoice(Request $request){

        $id = explode(",", $request->get("id"));
        $date = $request->get("invoice_date");
        $invoice_num = "";
            for($i=1;$i<count($id);$i++){

                $row = \App\FuneralArrangements::where("id",$id[$i])->first();
                $row->is_invoice =1;
                $row->invoice_date=$date;
                $row->invoice_num = "I".$row->generated_code;
                $invoice_num = "I".$row->generated_code;
                $row->save();
            }

           return $invoice_num;
    }

      public function genPdf($id ,$wsc , $invoice_num) {



            $data = array();

            $data['fa'] =  \App\FuneralArrangements::where("id",$id)->where("is_draft",0)->first();
            $data['parlour'] = \App\ParlourOrders::where("funeral_arrangement_id",$data['fa']->id)->get();
            $data['hearse'] = \App\HearseOrders::where("funeral_arrangement_id",$data['fa']->id)->get();
            $data['gemstone'] = \App\GemstoneOrders::where("funeral_arrangement_id",$data["fa"]->id)->get();
            $data['columbarium'] = \App\ColumbariumOrders::where("funeral_arrangement_id",$data['fa']->id)->get();



            $pdf = PDF::loadView('invoices/pdf',array("data"=>$data,"wsc"=>$wsc,"invoice_num"=>$invoice_num));
            $pdf->setPaper('a4', 'Landscape')->setWarnings(false)->save(public_path()."/uploads/".$invoice_num.".pdf");

            return $pdf->stream();
        }

}