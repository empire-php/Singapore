@extends('layouts.app')

@section('content')

<div class="page-header">
    <h3>
        @if(isset($order) && !isset($is_pview))
            <a href="/parlour">Parlour</a> / Order P{{$order_nr}}
        @elseif(isset($is_pview))
            <a href="/parlour">Parlour</a>: {{$parlourdetails->name}}
        @else
            Parlour
        @endif
    </h3>
</div>
@if(isset($is_pview))
    @include('parlour.pform')
@else
    @include('parlour.form')
@endif


@if(!isset($is_view))
<div class="section">   
    <div class="section_title">Parlour booking summary</div>
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
                    <td>Parlour</td>
                    <td colspan="3">
                        <select class="form-control" name="filter_parlour" id="filter_parlour" style="width:150px;">
                            <option></option>
                            @foreach($items as $key => $item)
                            <option value="{{$item['id']}}">{{$item['name']}}</option>
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
                        <th>Parlour Name</th>
                        <th>Capacity</th>
                        <th>Date From</th>
                        <th>Date From sec</th>
                        <th>Date To</th>
                        <th>Date To sec</th>
                        <th>Time from</th>
                        <th>Time from sec</th>
                        <th>Time to</th>
                        <th>Time to sec</th>
                        <th>{{$company_prefix}} no.</th>
                        <th>Order taken by</th>
                        <th>Order no.</th>
                    </tr>
               </thead>
            </table>
        </div>
            
    </div>
</div>
<!---   Add popup for to view all images -->
<div class="modal fade" id="view_all_images" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>

            <div class="modal-body">

            </div>
            <div class="modal-footer">
             <!--   <button type="button" class="btn btn-default" id="cancel_general_bttn">Cancel</button>    -->
             <!--   <button type="button" class="btn btn-primary" id="save_general_bttn">Save</button>       -->
            </div>

        </div>
    </div>
</div>
@endif;
@endsection


@push('css')
    <link href="/css/app/parlour.css" rel="stylesheet">
@endpush

 @push('scripts')
    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/parlour.js"></script>
    <script src="/js/app/general_form.js"></script>
@endpush