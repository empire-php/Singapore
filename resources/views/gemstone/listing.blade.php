@extends('layouts.app')

@section('content')


<div class="page-header">
    <h3>
        Gemstone Orders
    </h3>
</div>

<div style="width:100%; background-color: #FFFFFF; padding:40px">
   
    <div>
        <table id="table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Order Nr</th>
                    <th>Point of Contact 1</th>
                    <th>Point of Contact 2</th>
                    <th>Funeral Arrangement</th>
                    <th>Created by</th>
                    <th>Last Saved</th>
                    <th style="display:none">Last Saved</th>
                    <th class="table_th_view_column">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($forms as $form)
                <tr>
                    <td><?php echo sprintf("%05d", $form->order_nr);?></td>
                    <td>{{$form->first_cp_name}}</td>
                    <td>{{$form->second_cp_name}}</td>
                    <td><?php if ($form->funeral_arrangement_id):?><a href="{{ url("/fa/view/" . $form->funeral_arrangement_id) }}">{{$form->funeralArrangement->getCompanyPrefix()}} {{$form->funeralArrangement->generated_code}}<?php endif;?></td>
                    <td>{{($form->creator)?$form->creator->name:"-"}}</td>
                    <td>{{ ($form->updated_at)?date("d/m/Y H:i:s", strtotime($form->updated_at)):'' }}</td>
                    <td style="display:none">{{ $form->updated_at }}</td>
                    <td ><a href="{{ url("/gemstone/view/" . $form->id) }}"><i class="fa fa-pencil-square-o"></i> View details</a></td>
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
    <link href="/css/app/gemstone.css" rel="stylesheet">
@endpush

 @push('scripts')
    <script src="/js/app/gemstone.js"></script>
    
    <script>
    $(document).ready(function() {
    $('#table').DataTable( {
        "order": [[ 1, "desc" ]],
        "aoColumnDefs": [
            { "iDataSort": 6, "aTargets": [ 5 ] }
        ]
    } );
     
} );
    </script>
@endpush