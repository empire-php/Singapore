@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h3>
            Niche Order List
        </h3>
    </div>

    <div style="width:100%; background-color: #FFFFFF; padding:40px">

        <div>
            <table id="table" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Date/Time</th>
                    <th>WSC Number</th>
                    <th>Order Number</th>
                    <th>Block</th>
                    <th>Suite</th>
                    <th>Unit</th>
                    <th>Order by</th>
                    <th class="table_th_view_column">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($forms as $form)
                    <tr>
                        <td>
                            <?php
                            $date = new DateTime($form->created_at);
                            echo $date->format('d/m/Y H:i');
                            ?>

                        </td>
                        <td>{{$form->funeralArrangement['generated_code']}}</td>
                        <td>{{$form->order_nr}}</td>
                        <td>{{$form->columbarium}}</td>
                        <td>{{$form->suite_nr}}</td>
                        <td>{{$form->unit}}</td>
                        <td>{{$form->creator->name }}</td>
                        <td ><a href="{{ url("/niche/view/" . $form->id) }}"><i class="fa fa-pencil-square-o"></i> View details</a></td>
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
                        "order": [[ 2, "desc" ]],
                        "aoColumnDefs": [
                            { "iDataSort": 2, "aTargets": [ 6 ] }
                        ]
                    } );

                } );
            </script>
    @endpush