@extends('layouts.app')

@section('content')


<div class="page-header">
    <h3>
        View Shifting Slips
    </h3>
</div>

<div style="width:100%; background-color: #FFFFFF; padding:40px">
   
    <div>
        <table id="table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Deceased name</th>
                    <th>First Contact Name</th>
                    <th>Second Contact Name</th>
                    <th>Status</th>
                    <th>Creator</th>
                    <th>Last Saved</th>
                    <th style="display:none">Last Saved</th>
                    <th class="table_th_view_column">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{$order->deceased_name}}</td>
                    <td>{{$order->first_contact_name}}</td>
                    <td>{{$order->second_contact_name}}</td>
                    <td>{{$order->status}}</td>
                    <td>{{($order->creator)?$order->creator->name:"-"}}</td>
                    <td>{{ ($order->updated_at)?date("d/m/Y H:i:s", strtotime($order->updated_at)):'' }}</td>
                    <td style="display:none">{{ $order->updated_at }}</td>
                    <td ><a href="{{ url("/shifting/" . $order->id) }}"><i class="fa fa-pencil-square-o"></i> View details</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
       
    </div>

<div>
@endsection


@push('css')
    <link href="/css/app/shifting.css" rel="stylesheet">
@endpush

 @push('scripts')
    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/app/shifting.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script>
    $(document).ready(function() {
    $('#table').DataTable( {
        "order": [[ 7, "desc" ]],
        "aoColumnDefs": [
            { "iDataSort": 7, "aTargets": [ 6 ] }
        ]
    } );
     
} );
    </script>
@endpush