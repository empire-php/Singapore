@extends('layouts.app')

@section('content')

<div style="width:100%">

    
@if (isset($view_mode))
    @include('funeral_arrangement.checklist')
    @include('funeral_arrangement.view')
@else

    <div class="page-header">
        <h3>
            @if(isset($step))
                <a href="/fa">Funeral Arrangement</a> / Step {{$step}}
            @else
                Funeral Arrangement
            @endif
        </h3>
        
    </div>

    @include('funeral_arrangement.checklist')
    @if ($step == 1)
        @include('funeral_arrangement.form1')
    @elseif ($step == 2)
        @include('funeral_arrangement.form2')
    @elseif ($step == 3)
        @include('funeral_arrangement.form3')
    @elseif ($step == 4)
        @include('funeral_arrangement.form4')
    @endif
@endif



      
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
    
    
<div class="modal fade" id="save_msg" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Status</h4>
            </div>

            <div class="modal-body">
                <div class="form-group" id="message_container">
                    
                </div>
            </div>
            <div class="modal-footer">
                
            </div>

        </div>
    </div>
</div>


 
@endsection


@push('css')
    <link href="/css/app/fa.css" rel="stylesheet">
     <link href="/css/app/parlour.css" rel="stylesheet">
@endpush

 @push('scripts')

    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
     <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    {{--<script src="/js/app/general_form.js"></script>--}}
    <script src="/js/app/fa.js"></script>
     <script src="/js/app/parlour.js"></script>
   
   
   
@endpush