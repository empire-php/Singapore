@extends('layouts.app')

@section('content')


<div class="page-header">
    <h3>
        As need funeral arrangement
    </h3>
</div>

<div style="width:100%; background-color: #FFFFFF; padding:40px">
   
    <div>
        <table id="table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Deceased name</th>
                    <th>POC 1 name</th>
                    <th>POC 1 NRIC</th>
                    <th>POC 2 name</th>
                    <th>POC 2 NRIC</th>
                    <th>{{$company_prefix}} Number</th>
                    <th>Last Saved by</th>
                    <th>Last Saved</th>
                    <th style="display:none">Last Saved</th>
                    <th class="table_th_view_column">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($forms as $form)
                <tr>
                    <td>{{$form->deceased_name}}</td>
                    <td>{{$form->first_cp_name}}</td>
                    <td>{{$form->first_cp_nric}}</td>
                    <td>{{$form->second_cp_name}}</td>
                    <td>{{$form->second_cp_nric}}</td>
                    <td>{{$form->getCompanyPrefix()}}{{$form->generated_code}}</td>
                    <td>{{($form->getLastSavedByUser())?$form->getLastSavedByUser()->name:"-"}}</td>
                    <td>{{ ($form->updated_at)?date("d/m/Y H:i:s", strtotime($form->updated_at)):'' }}</td>
                    <td style="display:none">{{ $form->updated_at }}</td>
                    <td ><a href="{{ url("/fa/view/" . $form->id) }}"><i class="fa fa-pencil-square-o"></i> View details</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
       
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
    <link href="/css/app/fa.css" rel="stylesheet">
@endpush

 @push('scripts')
    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/app/fa.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script>
    $(document).ready(function() {
    $('#table').DataTable( {
        "order": [[ 8, "desc" ]],
        "aoColumnDefs": [
            { "iDataSort": 8, "aTargets": [ 7 ] }
        ]
    } );
     
} );
    </script>
@endpush