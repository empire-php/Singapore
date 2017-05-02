@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Parlour Room Booking Summary</div>
                <div class="panel-body">
                    <!-- -->
                    <div class="section">   
                        <div class="section_title">Availability</div>
                        <div>
                            <div id="listing">
                                <table id="dblisting_tbl" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Parlour Name</th>
                                            <th rowspan="2">Capacity</th>
                                            <th rowspan="2">Price</th>
                                            <th colspan="5">&nbsp;</th>
                                            <th colspan="6" style="text-align: center;">Next In</th>
                                        </tr>
                                        <tr rowspan="2">
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Date </th>
                                            <th>Date To sec</th>
                                            <th>Time</th>
                                            <th>Time from sec</th>
                                            <th>Date</th>
                                            <th>Time to sec</th>
                                            <th>Time</th>
                                            <th>Orden taken by</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                   </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- -->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Hearse Booking Summary</div>
                <div class="panel-body">
                    <div class="section">   
                        <div class="section_title">Availability</div>
                        <div>
                            <div id="listing">
                                <table  id="dbhearslisting_tbl" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Hearse Name</th>
                                            <th colspan="6" style="text-align: center;">Next In</th>
                                            <th colspan="6" style="text-align: center;"></th>
                                        </tr>
                                        <tr rowspan="2">
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Date To</th>
                                            <th>Date</th>
                                            <th>Time from</th>
                                            <th>Time</th>
                                            <th>Time to</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Time</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                   </thead>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="/css/app/parlour.css" rel="stylesheet">
@endpush
@push('scripts')
    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/parlour.js"></script>
    <script src="/js/app/hearse.js"></script>
    <script src="/js/app/general_form.js"></script>
@endpush