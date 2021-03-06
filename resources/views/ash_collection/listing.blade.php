@extends('layouts.app')

@section('content')


<div class="page-header">
    <h3>
        Ash Collection Slips
    </h3>
</div>

<div style="width:100%; background-color: #FFFFFF; padding:40px">
   
    <div>
        <table id="table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Deceased name</th>
                    <th>Funeral Date</th>
                    <th style="display:none">Funeral Date</th>
                    <th>Final Resting Place</th>
                    <th>Created by</th>
                    <th>Last Saved</th>
                    <th style="display:none">Last Saved</th>
                    <th class="table_th_view_column">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($forms as $form)
                <tr>
                    <td>{{$form->deceased_name}}</td>
                    <td>{{$form->funeral_date}}</td>
                    <td style="display:none"><?php echo ($form->funeral_date)? date("Y-m-d",strtotime(str_replace("/","-",$form->funeral_date))):""?></td>
                    <td>{{$form->final_resting_place}}</td>
                    <td>{{($form->creator)?$form->creator->name:"-"}}</td>
                    <td>{{ ($form->updated_at)?date("d/m/Y H:i:s", strtotime($form->updated_at)):'' }}</td>
                    <td style="display:none">{{ $form->updated_at }}</td>
                    <td ><a href="{{ url("/ashcollection/view/" . $form->id) }}"><i class="fa fa-pencil-square-o"></i> View details</a></td>
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
    <link href="/css/app/ashcollection.css" rel="stylesheet">
@endpush

 @push('scripts')
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/ashcollection.js"></script>
    <script>
    $(document).ready(function() {
    $('#table').DataTable( {
        "order": [[ 2, "desc" ]],
        "aoColumnDefs": [
            { "iDataSort": 3, "aTargets": [ 2 ] ,
              "iDataSort": 7, "aTargets": [ 6 ] }
        ]
    } );
     
} );
    </script>
@endpush