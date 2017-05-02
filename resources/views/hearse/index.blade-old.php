@extends('layouts.app')

@section('content')

<div class="page-header">
    <h3>
        @if(isset($order) && !isset($is_pview))
            <a href="/hearse">Hearse</a> / Order H{{$order_nr}}
        @elseif(isset($is_pview))
            <a href="/hearse">Hearse</a>: {{$hearsesdetails->name}}
        @else
            Hearse
        @endif
    </h3>
</div>
@if(isset($is_pview))
    @include('hearse.pform')
@else
    @include('hearse.form')
@endif

@if(!isset($is_view))
<div class="section">   
    <div class="section_title">Hearse booking summary</div>
    <div>
        <div class="filter_zone">
            <form>
            <table>
                <tr>
                    <td>Date from</td>
                    <td><input type="text" class="form-control" id="filter_booked_from_day" name="filter_booked_from_day" /></td>
                    <td>to</td>
                    <td><input type="text" class="form-control" id="filter_booked_to_day" name="filter_booked_to_day" /></td>
                </tr>
                <tr>
                    <td>Hearse</td>
                    <td colspan="3">
                        <select class="form-control" name="filter_hearse" id="filter_hearse">
                            <option></option>
                            @foreach($items as $key => $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input type="button" value="Filter" class="btn btn-blue-500" id="filter_bttn" /></td>
                    <td colspan="3"></td>
                </tr>
            </table>
            </form>
        </div>
        
        <div style="clear: both; height:50px"></div>
        <div id="listing">
            <table  id="listing_tbl" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Hearse Name</th>
                        <th>Date From</th>
                        <th>Date From sec</th>
                        <th>Date To</th>
                        <th>Date To sec</th>
                        <th>Time from</th>
                        <th>Time from sec</th>
                        <th>Time to</th>
                        <th>Time to sec</th>
                        <th>{{$company_prefix}} no.</th>
                        <th>Orden taken by</th>
                        <th>Orden no.</th>
                    </tr>
               </thead>
            </table>
        </div>
            
    </div>
</div>
@endif;
@endsection


@push('css')
    <link href="/css/app/hearse.css" rel="stylesheet">
@endpush

 @push('scripts')
    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/hearse.js"></script>
    <script src="/js/app/general_form.js"></script>    
@endpush