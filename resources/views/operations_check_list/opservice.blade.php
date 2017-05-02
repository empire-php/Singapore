@extends('layouts.app')

@section('content')

<script src="/js/app/jquery-ui.js"></script>
<script src="/js/app/jquery.PrintArea.js"></script>
<script>
var arrRecord=[];

$(document).ready(function(){
    
    $(".print").on('click', function() {
        
        var mode = 'iframe'; // popup
        var close = mode == "popup";
        var options = { mode : mode, popClose : close};
        $("div.printable").printArea( options );
    });    
});
</script>
<div class="page-header">
    <h3>Operation Service team</h3>
</div>

@if(!isset($is_view))
<form action="/operations/saveoperationservice" method="post"  id="info_frm" enctype="multipart/form-data" class="master_form">
{!! csrf_field() !!}
<div class="section">
    <div class="printable">
        <div class="section_title customer_details_title" style="width: auto;">Operation Service team</div>
        <div class="messagebox">
            @if($errors->has())
                @foreach ($errors->all() as $error)
                    <div class="errormsg">{{ $error }}</div>
                @endforeach
            @endif

            @if(Session::has('flash_message'))
                <div class="successmsg">
                    {{ Session::get('flash_message') }}
                </div>
            @endif
        </div>
        <div id="listing">
            <table  id="hearsallclisting_tbl" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th onclick="window.location='/operations/opservice?ord=funeral_date&<?php if(isset($ordrTblBy) && $ordrTblBy=="asc" ){ echo "ordby=desc"; } else{ echo "ordby=asc"; } ?>'" style="cursor: pointer">Date</th>
                        <th>Deceased Name</th>
                        <th>Location of Wake</th>
                        <th>Service Staff</th>
                        <th>Acknowledged By</th>
                        <th>Service Team</th>
                        <th>Acknowledged By</th>
                        <th>Night Care</th>
                        <th>Acknowledged By</th>
                    </tr>
               </thead>
               <?php $i=1; $faids = ""; ?>
               @if($forms)
               <tbody>                    
                    @foreach ($forms as $form)
                        <tr>
                            <td>{{ ($form->funeral_date)?$form->funeral_date:'' }}</td>
                            <td>{{$form->deceased_name}}</td>
                            <td>{{$form->service_date}}</td>
                            <td>
                                @if( $usersdata )
                                    <select class="form-control" name="users_ids1{{ $form->id }}[]" data-toggle="select2" multiple="">
                                        @foreach( $usersdata as $usersdataVal )
                                            <option value="{{ $usersdataVal->id }}"
                                                            @if (isset($operationservicestaff) && in_array($usersdataVal->id, $operationservicestaff[$form->id]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                            </option>
                                        @endforeach
                                    </select> 
                                @endif
                            </td>
                            <td>
                                <div class="signaturebox" id="box1{{ $form->id }}" >
                                    @if (isset($form) && $form->signature_service_staff)
                                    <img src="{{$form->signature_service_staff}}" style="width:100px"/>
                                    @endif
                                </div>
                                <div class="signature_box" id="signature_box_1{{ $form->id }}">
                                    <div id="signature1{{ $form->id }}" data-name="signature1{{ $form->id }}" data-max-size="2048" 
                                           data-pen-tickness="3" data-pen-color="black" 
                                           class="sign-field"></div>
                                           <input type="hidden" id="signature_image_1{{ $form->id }}" name="signature_image_1{{ $form->id }}" value="{{(isset($form))? $form->signature_service_staff:""}}" />
                                           <button class="btn btn-primary" >Ok</button>

                                </div>
                            </td>
                            <td>
                                @if( $usersdata )
                                    <select class="form-control" name="users_ids2{{ $form->id }}[]" data-toggle="select2" multiple="">
                                        @foreach( $usersdata as $usersdataVal )
                                            <option value="{{ $usersdataVal->id }}"
                                                            @if (isset($operationserviceteam) &&  in_array($usersdataVal->id, $operationserviceteam[$form->id]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                            </option>
                                        @endforeach
                                    </select> 
                                @endif
                            </td>
                            <td>
                                <div class="signaturebox" id="box2{{ $form->id }}" >
                                    @if (isset($form) && $form->signature_service_team)
                                    <img src="{{$form->signature_service_team}}" style="width:100px"/>
                                    @endif
                                </div>
                                <div class="signature_box" id="signature_box_2{{ $form->id }}">
                                    <div id="signature2{{ $form->id }}" data-name="signature2{{ $form->id }}" data-max-size="2048" 
                                           data-pen-tickness="3" data-pen-color="black" 
                                           class="sign-field"></div>
                                           <input type="hidden" id="signature_image_2{{ $form->id }}" name="signature_image_2{{ $form->id }}}" value="{{(isset($form))? $form->signature_service_team:""}}" />
                                           <button class="btn btn-primary" >Ok</button>

                                </div>
                            </td>
                            <td>
                                @if( $usersdata )
                                    <select class="form-control" name="users_ids3{{ $form->id }}[]" data-toggle="select2" multiple="">
                                        @foreach( $usersdata as $usersdataVal )
                                            <option value="{{ $usersdataVal->id }}"
                                                            @if (isset($operationservicenightmare) && in_array($usersdataVal->id, $operationservicenightmare[$form->id]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                            </option>
                                        @endforeach
                                    </select> 
                                @endif
                            </td>
                            <td>
                                <div class="signaturebox" id="box3{{ $form->id }}" >
                                    @if (isset($form) && $form->signature_night_care)
                                    <img src="{{$form->signature_night_care}}" style="width:100px"/>
                                    @endif
                                </div>
                                <div class="signature_box" id="signature_box_3{{ $form->id }}">
                                    <div id="signature3{{ $form->id }}" data-name="signature3{{ $form->id }}" data-max-size="2048" 
                                           data-pen-tickness="3" data-pen-color="black" 
                                           class="sign-field"></div>
                                           <input type="hidden" id="signature_image_3{{ $form->id }}" name="signature_image_3{{ $form->id }}" value="{{(isset($form))? $form->signature_night_care:""}}" />
                                           <button class="btn btn-primary" >Ok</button>

                                </div>
                            </td>
                            
                        </tr>
                        <script> arrRecord.push(<?php echo $form->id; ?>); </script>
                        <?php 
                        if( $i == 1 ){
                            if( $form->id != "" ){
                                $faids.= $form->id;
                            }
                        } else {
                            if( $form->id != "" ){
                                $faids.=",".$form->id;
                            }
                        }
                        $i++;                         
                        ?>               
                    @endforeach
                </tbody>
                @endif
            </table>
        </div>
    </div>
    <div class="section_content customer_details_content">
        <table class="operaton_form_tbl" cellpadding='10' cellspacing='10' border='0' width="100%">
            <tr>
                <td class="text-center">
                    <input type="hidden" name="faids" id="faids" value="{{ $faids }}" />
                    <input class="btn btn-blue-500" type="submit" name="save_button" value="Save" />
                </td>
            </tr>
        </table>
    </div>
</div>
</form>
@endif;
@endsection


@push('css')
    <link href="/css/app/hearse.css" rel="stylesheet">
    <style>
    .operaton_form_tbl td {
        padding: 3px;
    }
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding: 3px !important;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #e0e7e8;
    }
</style>
@endpush



 @push('scripts')
    <script>
        $(document).ready(function(){
            // SIGNATURES 
            $.each(arrRecord, function (index, value) {
                if ($('#signature1'+value).length > 0){
                    var s = $('#signature1'+value).signField(). // Setup
                    on('change', function(){ 
                      var signature = $(this); // div
                    });
                    
                    var s = $('#signature2'+value).signField(). // Setup
                    on('change', function(){ 
                      var signature = $(this); // div
                    });
                    
                    var s = $('#signature3'+value).signField(). // Setup
                    on('change', function(){ 
                      var signature = $(this); // div
                    });
                    
                    $("#box1"+value+", #box2"+value+", #box3"+value).click(function(){
                        $(this).next().show();
                        $(this).hide();
                    });                
                
                    $(".signature_box button").click(function(e){
                        $(this).parents(".signature_box").prev().show();
                        $(this).parents(".signature_box").hide();
                        var m = moment().format("DD/MM/YYYY");
                        var boxNr =  $(this).parents(".signature_box").attr("id").replace("signature_box_","");
                        $("#date_signature_" + boxNr).html(m);
                        $("#input_date_signature_" + boxNr).val(m);

                        $("#signature_image_" + boxNr).html($(this).parents(".signature_box").find(".imgdata").val());

                        $("#box" +boxNr).html("<img src='"+  $(this).parents(".signature_box").find(".imgdata").val() +"' style='width: 98px' />");

                        e.preventDefault();
                    });
                }            
            });           
        });
    </script>
    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
     <script src="/js/app/operations.js"></script>
    <script src="/js/app/general_form.js"></script>   
    
@endpush