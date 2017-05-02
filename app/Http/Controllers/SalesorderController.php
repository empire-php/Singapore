<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect as Redirect;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Database\Schema\Builder as Schema;
use Barryvdh\DomPDF\Facade as PDF;
class SalesorderController extends Controller
{
    
        public function __construct()
        {
            parent::__construct();
            $this->middleware('auth');
        }

        public function index () {

                return view('salesorder/index');
        }
        
        /* Search by WSC or Deceased Name */
        
        public function search (Request $request) {
            
           $wsc = $request->get("wsc");
           $decease = $request->get("decease");
               
           if      ($wsc !="" && $decease ==""){
                $where = "generated_code = ".$wsc." and is_draft = 0 and purchased_items != ''";
           }else if($wsc == "" && $decease !=""){
                $where = "deceased_name like '%$decease%' or deceased_name like '%$decease' or deceased_name like '$decease%'"." and is_draft = 0 and purchased_items != ''";
           }else{
                $where = "generated_code =".$wsc." and (deceased_name like '%$decease' or deceased_name like '$decease%')"." and is_draft = 0 and purchased_items != ''";
           }
           
//           Getting data which are satisfied by conditions.
           $results = \App\FuneralArrangements::select("id","generated_code","deceased_name")->whereRaw($where)->get();
          
         
           if($results->count() >0 ){
               foreach($results as $key => $result){
                $data[$key]['wsc'] = $result->generated_code ;
                $data[$key]['deceased_name']=  $result->deceased_name ;
                $data[$key]['id'] = $result->id ;
               }
               die(json_encode($data));   
           }else{
                die(json_encode($data[0]['error']="error"));
           }
           
                 
        }
        
//        For get data to show to table 
        public function getDetailsData(Request $request) {
            
            $id = $request->get("id");
           
            $data = array();
            
            $data['fa'] =  \App\FuneralArrangements::where("id",$id)->where("is_draft",0)->where("purchased_items","!=","")->first();
            $data['parlour'] = \App\ParlourOrders::where("funeral_arrangement_id",$data['fa']->id)->first();
            $data['hearse'] = \App\HearseOrders::where("funeral_arrangement_id",$data['fa']->id)->first();
            $data['gemstone'] = \App\GemstoneOrders::where("funeral_arrangement_id",$data["fa"]->id)->first();
            $data['columbarium'] = \App\ColumbariumOrders::where("funeral_arrangement_id",$data['fa']->id)->first();
            
            $wsc = $request->get("wsc");
            
 
            return view('salesorder/listing_items',array("data"=>$data,"wsc"=>$wsc));
       
        }
        
        public function savePayment(Request $request){
             
            
            $info = $request->all();
            
         
            $fa = \App\FuneralArrangements::where("generated_code",$request->get("wsc"))->first();
            $fa->is_invoice = 0;
            $fa->save();
          
            
            $sales = new \App\SalesOrder();
            $columns = \Schema::getColumnListing("salesorder");
            
            foreach ($info as $key => $value) {
                
                if(in_array($key, $columns)){
                    $sales->{$key} = $value ;
                }
            }
//            Calulator receiption number 
            $receiption_num =  self::getNextReceiptionNumber($request->get("wsc"));
            $sales->receiption_num =$receiption_num ;
            
            $sales->save();
            
            return $receiption_num;
        }
        
        public function getNextReceiptionNumber ($wsc){
            
            $row = \App\SalesOrder::where('receiption_num','!=',"")->orderBy("id","desc")->first();
            
            if($row){
                $last_digit = substr($row->receiption_num, -3);
                
                if($last_digit == "999"){
                    return $wsc * 1000 +1;
                }else{
                    if(($last_digit+1) % 10 ==0){
                        if(($last_digit+1)<100){
                            return $wsc."0".($last_digit+1);
                        }else{
                            return $wsc.($last_digit+1);
                        }
                    }else if(($last_digit+1) % 10 !=0 && $last_digit < 100){
                        return $wsc.substr(($last_digit+1)/1000, -3);
                    }else{
                        return $wsc.($last_digit+1);
                    }
                }
            }else {
                return $wsc*1000 + 1;
            }
            
        }
        public function genPdf($id ,$wsc , $reception_num) {
            
             
           
            $data = array();
            
            $data['fa'] =  \App\FuneralArrangements::where("id",$id)->where("is_draft",0)->first();
            $data['parlour'] = \App\ParlourOrders::where("funeral_arrangement_id",$data['fa']->id)->get();
            $data['hearse'] = \App\HearseOrders::where("funeral_arrangement_id",$data['fa']->id)->get();
            $data['gemstone'] = \App\GemstoneOrders::where("funeral_arrangement_id",$data["fa"]->id)->get();
            $data['columbarium'] = \App\ColumbariumOrders::where("funeral_arrangement_id",$data['fa']->id)->get();
            
            $amount = \App\SalesOrder::where("receiption_num",$reception_num)->first();
            
            $pdf = PDF::loadView('salesorder/pdf',array("data"=>$data,"wsc"=>$wsc,"reception_num"=>$reception_num,'amount'=>$amount->amount)); 
            $pdf->setPaper('a4', 'Landscape')->setWarnings(false)->save(public_path().'/uploads/'.$reception_num.'.pdf');
            return $pdf->stream();
        }
        
        public function genPdfCustomer($id ,$wsc ,$reception_num){
            
            $data = array();
            
            $data['fa'] =  \App\FuneralArrangements::where("id",$id)->where("is_draft",0)->first();
            $data['parlour'] = \App\ParlourOrders::where("funeral_arrangement_id",$data['fa']->id)->get();
            $data['hearse'] = \App\HearseOrders::where("funeral_arrangement_id",$data['fa']->id)->get();
            $data['gemstone'] = \App\GemstoneOrders::where("funeral_arrangement_id",$data["fa"]->id)->get();
            $data['columbarium'] = \App\ColumbariumOrders::where("funeral_arrangement_id",$data['fa']->id)->get();
            
           $amount = \App\SalesOrder::where("receiption_num",$reception_num)->first();
            
            $pdfs = PDF::loadView('salesorder/pdfcustomer',array("data"=>$data,"wsc"=>$wsc,"reception_num"=>$reception_num,"signature"=>$data['fa']->signatures,'amount'=>$amount->amount)); 
            $pdfs->setPaper('a4', 'Landscape')->setWarnings(false)->save(public_path().'/uploads/customer-'.$reception_num.'.pdf');
            return $pdfs->stream();
        }
        
        public function getDetailsInfo($wsc , Request $request){
            
            $data = array();
            $id = $request->get("id");
           
            $data['fa'] =  \App\FuneralArrangements::where("id",$id)->where("is_draft",0)->where("purchased_items","!=","")->first();
            $data['parlour'] = \App\ParlourOrders::where("funeral_arrangement_id",$data['fa']->id)->get();
            $data['hearse'] = \App\HearseOrders::where("funeral_arrangement_id",$data['fa']->id)->get();
            $data['gemstone'] = \App\GemstoneOrders::where("funeral_arrangement_id",$data["fa"]->id)->get();
            $data['columbarium'] = \App\ColumbariumOrders::where("funeral_arrangement_id",$data['fa']->id)->get();
            
           
            return view('salesorder/tableview',array("data"=>$data,"wsc"=>$wsc,"id"=>$id));
        }
        
        
        public function calIntToStringForMoney($value){
            
            
        }
}