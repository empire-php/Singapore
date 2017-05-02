@extends('layouts.app')

@section('content')

<div class="page-header">
    <h3>SMS</h3>
</div>

@if(!isset($is_view))
<form action="/smsnotification/sms/send" id="smsform" method="post" class="master_form needs_exit_warning">
{!! csrf_field() !!}
<div class="section">
    <div id="printable">
        <div class="section_title customer_details_title" style="width: auto;">SMS Sending</div>
        <div class="section_content customer_details_content">            
            @if(session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif
            <table class="operaton_form_tbl" cellpadding='10' cellspacing='10' border='0' width="50%">
                <tr>
                    <td>Display Name</td>
                    <td>
                        <input type="text" class="form-control" id="display_name" name="display_name" value="" />
                        @if ($errors->has('display_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('display_name') }}</strong>
                            </span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Point of Contact Name</td>
                    <td>
                        @if( $pointsContactDat )
                            <select class="form-control" name="contact_name" id="contact_name" data-toggle="select2">
                                <option value=""></option>
                                @foreach( $pointsContactDat as $pointsContactDatKey=>$pointsContactDatVal )
                                    @if( $pointsContactDatVal['first_cp_id'] != "" && $pointsContactDatVal['first_cp_name'] != "" )
                                        <option value="{{ "first_cp_id_".$pointsContactDatVal['first_cp_id'] }}">{{ $pointsContactDatVal['first_cp_name'] }}</option>
                                    @elseif( $pointsContactDatVal['second_cp_id'] != "" && $pointsContactDatVal['second_cp_name'] != "" )
                                        <option value="{{ "second_cp_id_".$pointsContactDatVal['second_cp_id'] }}">{{ $pointsContactDatVal['second_cp_name'] }}</option>
                                    @endif
                                @endforeach
                            </select> 
                        @endif
                        @if ($errors->has('contact_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('contact_name') }}</strong>
                            </span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Recipient No.</td>
                    <td>
                        <input type="text" class="form-control" id="recipient_no" name="recipient_no" value="" />
                        @if ($errors->has('recipient_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('recipient_no') }}</strong>
                            </span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td valign="top">Message</td>
                    <td>
                        <textarea class="form-control" name="message" id="message" onkeyup="countChar(this)"></textarea>
                        <div id="charNum">0/160</div>
                        @if ($errors->has('message'))
                            <span class="help-block">
                                <strong>{{ $errors->first('message') }}</strong>
                            </span>
                        @endif
                    </td>
                </tr>
                
                <tr>
                    <td style="height:30px;">&nbsp;</td>
                </tr>
            </table>
        </div>
        
    </div>
    <div class="section_content customer_details_content">
        <table class="operaton_form_tbl" cellpadding='10' cellspacing='10' border='0' width="100%">
            <tr>
                <td class="text-center"><input class="btn btn-blue-500 print" type="submit" name="save_button" value="SEND" /></td>
            </tr>
        </table>
    </div>
    
    <div style="clear: both; height:50px"></div>
    <div class="section_title">History</div>
    <div id="listing">
        <table id="listing_tbl" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Display Name</th>
                    <th>Recipient No.</th>
                    <th>Recipient Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Message</th>
                    <th>Sent By</th>
                    <th>Status</th>
                </tr>
           </thead>
        </table>
    </div>
    
</div>
</form>
@endif;
@endsection


@push('css')
    <link href="/css/app/hearse.css" rel="stylesheet">
    <style>
    .help-block { color: red; font-size: 12px; }
    .operaton_form_tbl td {
        padding: 3px;
    }
</style>
@endpush



 @push('scripts')
    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
     <script src="/js/app/smsnotification.js"></script>
    <script src="/js/app/general_form.js"></script>   
@endpush