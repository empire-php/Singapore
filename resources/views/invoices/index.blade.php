@extends('layouts.app')

@section('content')





<div style="width:100%; background-color: #FFFFFF; padding:40px">
    <form method="post" action="<?php echo url("salesorder"); ?>">
               <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
               <input type="hidden" id="wsc_id" name="id" value="" />
    <div class="page-header">
        <h3>
            Pending Invoice Generation-Open Case
        </h3>
    </div>
    <div>
         
        <table id="table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>All</th>
                    <th>SC Number</th>
                    <th>Deceased Name</th>
                    <th>Funeral End Date</th>
                    <th>Customer Name</th>
                    
                    <th class="table_th_view_column">Sales Order / Payment</th>
                </tr>
            </thead>
            <tbody>     
           
              
                
                <?php foreach ($form as $key => $forms) { ?>
                <?php
                    if($forms->funeral_date && $forms->is_invoice ==0){  
                        $data = explode("/", $forms->funeral_date);
                     
                        if(strtotime($data[2]."/".$data[1]."/".$data[0]) > time()){
                ?>
                <tr style="height:25px">
                    <td style="padding:0 4px;vertical-align: middle"><input class="form-control" type="checkbox" id="check_<?php echo $forms->id; ?>" value="<?php echo $forms->id; ?>"/></td>
                    <td>{{ $forms->generated_code}}<input type="hidden" value="{{$forms->generated_code}}" /></td>
                    <td>{{$forms->deceased_name}}<input type="hidden" value="{{$forms->receiption_num}}" class="receiption_num"></td>
                    <td><?php echo $forms->funeral_date; ?></td>
                    <td>{{ $forms->first_cp_name }}</td>
                    <td>  
                        <a href="fa/view/<?php echo $forms->id; ?>">View full form</a>&nbsp;/&nbsp;<a href="javascript:void(0)" data-id="{{$forms->generated_code}}" class="{{$forms->id}}" onclick="viewPayment(this);">View Payment</a>         
                    </td>
                </tr>
                <?php } ?>
                <?php }} ?>
          
            </tbody>
        </table>
               
        <div style="text-align:right"><label>Invoice Date</label><input type="text" class="" id="invoice_date" /></div></br>
        <div style="text-align: right"><a href="#" class="btn btn-success generate-invoice">Generate Invoice</a></div>
    </div>
    
    <!--Section 2--> 
    <div class="page-header">
        <h3>
            Pending Invoice Generation-Close Case
        </h3>
    </div>
    <div>
        <table id="table1" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>All</th>
                    <th>SC Number</th>
                    <th>Deceased Name</th>
                    <th>Funeral End Date</th>
                    <th>Customer Name</th>
                    
                    <th class="table_th_view_column">Sales Order / Payment</th>
                </tr>
            </thead>
            <tbody>     
                
                <?php foreach ($form as $key => $forms) { ?>
                <?php
                    if($forms->funeral_date && $forms->is_invoice ==0){  
                        $data = explode("/", $forms->funeral_date);
                    
                        if(strtotime($data[2]."/".$data[1]."/".$data[0]) < time()){
                ?>
                <tr style="height:25px">
                    <td style="padding:0 4px;vertical-align: middle"><input class="form-control" type="checkbox" id="check_u_<?php echo $forms->id; ?>" value="<?php echo $forms->id; ?>"/></td>
                    <td>{{ $forms->generated_code}}</td>
                    <td>{{$forms->deceased_name}}</td>
                    <td><?php echo $forms->funeral_date; ?></td>
                    <td>{{ $forms->first_cp_name }}</td>
                    <td>  
                       <a href="fa/view/<?php echo $forms->id; ?>">View full form</a>&nbsp;/&nbsp;<a href="javascript:void(0)" data-id="{{$forms->generated_code}}" class="{{$forms->id}}" onclick="viewPayment(this);">View Payment</a>         
                    </td>
                   
                  
                </tr>
                <?php } ?>
                <?php }} ?>
            </tbody>
        </table>
        <div style="text-align:right"><label>Invoice Date</label><input type="text" class="" id="invoice_date_u" /></div></br>
        <div style="text-align: right"><a href="#" class="btn btn-success ungenerate-invoice">Generate Invoice</a></div>
     
    </div>
     </form>
    <!--Section 3-->
    
    <div class="page-header">
        <h3>
            Generated Invoice
        </h3>
    </div>
    <div>
        <div>Date from : <input type="text" class="" id="from_date" />Date to : <input type="text" class="" id="to_date" /></div>
        <table id="table2" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Invoice Date</th>
                    <th>SC Number</th>
                    <th>Deceased Name</th>
                    <th>Customer Name</th>
                    <th class="table_th_view_column">Funeral End Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>     
                
                <?php foreach ($form as $key => $forms) { ?>
                <?php
                    if($forms->funeral_date && $forms->is_invoice ==1){  
                        $data = explode("/", $forms->funeral_date);
                    
                       // if(strtotime($data[2]."/".$data[1]."/".$data[0]) > time()){
                ?>
                <tr style="height:25px">
                    <td>{{ $forms->invoice_num}}</td>
                    <td>{{ $forms->invoice_date}}</td>
                     <td>{{ $forms->generated_code}}</td>
                    <td>{{$forms->deceased_name}}</td>
                    <td>{{ $forms->first_cp_name }}</td>
                    <td>{{ $forms->funeral_date }}</td>
                    <td>  
                        <a href="<?php echo url("public/uploads/I").$forms->generated_code; ?>.pdf" target="blank">View pdf</a>       
                    </td>
                  
                  
                </tr>
                <?php // } ?>
                <?php }} ?>
            </tbody>
        </table>
<!--        <div style="text-align:right"><label>Invoice Date</label><input type="text" class="datepicker" id="invoice_date_u" /></div></br>
        <div style="text-align: right"><a href="#" class="btn btn-success ungenerate-invoice">Generate Invoice</a></div>-->
  
    </div>
    
    
    
    
      
<div class="modal fade" id="confirm_exit" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">WARNING</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    Your latest edit will not be saved if you exit without submitting. Do you still wish to exit?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="cancel_fa_bttn">Exit without saving</button>
                <button type="button" class="btn btn-primary" id="save_fa_bttn">Submit changes</button>
            </div>

        </div>
    </div>
</div>

<div>
@endsection


@push('css')
    <link href="/css/app/columbarium.css" rel="stylesheet">
@endpush

 @push('scripts')
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/invoice.js"></script>
    <script>
    $(document).ready(function() {
    $('#table').DataTable( {
        "order": [[ 1, "desc" ]],
        "aoColumnDefs": [
            { "iDataSort": 6, "aTargets": [ 5 ] }
        ]
    } );
    
    $('#table1').DataTable( {
        "order": [[ 1, "desc" ]],
        "aoColumnDefs": [
            { "iDataSort": 6, "aTargets": [ 5 ] }
        ]
    } );
     
     
    
   
     var tables = $('#table2').DataTable();
     tables.draw();
     $('#from_date, #to_date').change( function() {
        tables.draw();
    } );
} );
    </script>
@endpush