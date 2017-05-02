@extends('layouts.app')

@section('content')

    <style>
        #table th {
            text-align: center;
            vertical-align: middle;
        }
    </style>

    <div class="page-header">
        <h3>
            View Inventory Records
        </h3>
    </div>

    <div style="width:100%; background-color: #FFFFFF; padding:40px">
        <div id="search_div" class="row" style="width: 100%;">
            <div style="width: 640px; float: left; border: 2px solid #bbbbbb; border-radius: 7px; padding: 20px;">
                <form class="form-horizontal" id="filter_form" action="" method="post" onsubmit="return false">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="search_word">Category:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="filter_category" name="filter_category[]"
                                    data-toggle="select2" multiple>
                                @foreach($categories as $category)
                                    <option value="{{$category->category}}">{{$category->category}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Company : </label>
                        <div class="col-sm-10">
                            <select class="form-control" id="filter_company" name="filter_company[]"
                                    data-toggle="select2" multiple>
                                @foreach($companies as $company)
                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Type : </label>
                        <div class="col-sm-10">
                            <select class="form-control" id="action_type" name="action_type[]" data-toggle="select2"
                                    multiple class="form-control">
                                <option value="sales">Sales</option>
                                <option value="inventory">Inventory</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2">Date Range : </label>
                        <div class="col-sm-10">
                            <div class="col-sm-5"><input type="text" id="start_date" name="start_date"
                                                         class="form-control"></div>
                            <div class="col-sm-2" style="text-align: center"> To</div>
                            <div class="col-sm-5"><input type="text" id="end_date" name="end_date" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="col-sm-8">
                                <button type="button" class="btn btn-success btn-filter">Search/Filter</button>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="button" class="btn btn-default btn-clear">Clear Search/Filter</button>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="col-sm-4">
                                <button id="saveMe" class="btn btn-primary">Export CSV</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="filter_div">
            <table id="table" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th rowspan="2">Date</th>
                    <th rowspan="2">User Name</th>
                    <th rowspan="2">Type</th>
                    <th rowspan="2">Category</th>
                    <th colspan="3" style="text-align: center; cursor: default;">Companies</th>
                    <th rowspan="2">Item no</th>
                    <th rowspan="2">Description</th>
                    <th rowspan="2">Unit Price</th>
                    <th colspan="3" style="text-align: center; cursor: default;">Added to</th>
                    <th colspan="3" style="text-align: center; cursor: default;">Remove from</th>
                    <th colspan="3" style="text-align: center; cursor: default;">Balance</th>
                    <th rowspan="2">Reference no</th>
                    <th rowspan="2">Sales Order</th>
                </tr>
                <tr>
                    @foreach($companies as $company)
                        <th>{{$company->name}}</th>
                    @endforeach
                    <th>Warehouse</th>
                    <th>Store room</th>
                    <th>Total Balance</th>
                    <th>Warehouse</th>
                    <th>Store room</th>
                    <th>Total Balance</th>
                    <th>Warehouse</th>
                    <th>Store room</th>
                    <th>Total Balance</th>
                </tr>
                </thead>

                <tbody id="filter_body">
                @foreach($histories as $history)
                    <tr>
                        <td>
                            <?php
                            $date = new DateTime($history->editable_date_modif);
                            echo $date->format('d/m/Y H:i');
                            ?>
                        </td>
                        <td>{{ $history->user->name }}</td>
                        <td>{{ $history->type }}</td>
                        <td>{{ $history->product->category }}</td>
                        <?php
                        if (!empty($history->product->companies))
                            $product_companies = explode(',', $history->product->companies);
                        else
                            $product_companies = [];
                        ?>
                        @for($i=0; $i<count($companies); $i++)
                            <td align="center" style="color:#00a957;">
                                @if(in_array($companies[$i]->id, $product_companies))
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                @endif
                            </td>
                        @endfor
                        <td>{{ $history->product->item_number }}</td>
                        <td>{{ $history->remarks }}</td>
                        <td>@if($history->product->unit_price != 0){{ $history->product->unit_price }}@endif</td>
                        <?php
                        if (empty($history->warehouse))
                            $history->warehouse = 0;
                        if (empty($history->store_room))
                            $history->store_room = 0;

                        if ($history->warehouse > 0) {
                            $add_warehouse = $history->warehouse;
                            $remove_warehouse = 0;
                        } else {
                            $add_warehouse = 0;
                            $remove_warehouse = $history->warehouse;
                        }

                        if ($history->store_room > 0) {
                            $add_store_room = $history->store_room;
                            $remove_store_room = 0;
                        } else {
                            $add_store_room = 0;
                            $remove_store_room = $history->store_room;
                        }

                        $add_balance = $add_warehouse + $add_store_room;
                        $remove_balance = $remove_warehouse + $remove_store_room;

                        $total_balance = $history->balance_w +  $history->balance_s;
                        ?>
                        <td>@if($add_warehouse != 0){{ $add_warehouse }}@endif</td>
                        <td>@if($add_store_room != 0){{ $add_store_room }}@endif</td>
                        <td>@if($add_balance != 0){{ $add_balance }}@endif</td>
                        <td>@if($remove_warehouse != 0){{ abs($remove_warehouse) }}@endif</td>
                        <td>@if($remove_store_room != 0){{ abs($remove_store_room) }}@endif</td>
                        <td>@if($remove_balance != 0){{ abs($remove_balance) }}@endif</td>
                        <td>@if($history->balance_w != 0){{ $history->balance_w }}@endif</td>
                        <td>@if($history->balance_s != 0){{ $history->balance_s }}@endif</td>
                        <td>@if($total_balance !=0 ){{ $history->balance_w +  $history->balance_s }}@endif</td>
                        <td>{{ $history->reference_no }}</td>
                        <td>{{ $history->sales_order }}</td>
                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>
    </div>


@endsection

@push('scripts')
<script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
<script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
<script src="/js/app/shifting.js"></script>
<script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>


<script src="/js/app/dataTables.tableTools.js"></script>
<script src="http://datatables.net/release-datatables/extensions/Plugins/integration/bootstrap/3/dataTables.bootstrap.js"></script>

<!--XLSX-->
<script type="text/javascript" src="http://oss.sheetjs.com/js-xlsx/xlsx.core.min.js"></script>
<script type="text/javascript" src="http://sheetjs.com/demos/Blob.js"></script>
<script type="text/javascript" src="http://sheetjs.com/demos/FileSaver.js"></script>


<script>
    $(document).ready(function () {

        $.fn.dataTable.Api.register('column().title()', function () {
            var colheader = this.header();
            return $(colheader).text().trim();
        });

        var table = $('body').find('#table').DataTable();

        function Workbook() {
            if (!(this instanceof Workbook)) return new Workbook();
            this.SheetNames = [];
            this.Sheets = {};
        }

        function datenum1(v, date1904) {
            if (date1904) v += 1462;
            var epoch = Date.parse(v);
            return (epoch - new Date(Date.UTC(1899, 11, 30))) / (24 * 60 * 60 * 1000);
        }

        function s2ab(s) {
            var buf = new ArrayBuffer(s.length);
            var view = new Uint8Array(buf);
            for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
            return buf;
        }

        function sheet_from_array_of_arrays(data, opts) {
            var ws = {};
            var range = {
                s: {
                    c: 10000000,
                    r: 10000000
                },
                e: {
                    c: 0,
                    r: 0
                }
            };
            for (var R = 0; R != data.length; ++R) {
                for (var C = 0; C != data[R].length; ++C) {
                    if (range.s.r > R) range.s.r = R;
                    if (range.s.c > C) range.s.c = C;
                    if (range.e.r < R) range.e.r = R;
                    if (range.e.c < C) range.e.c = C;
                    var cell = {
                        v: data[R][C]
                    };
                    if (cell.v == null) continue;
                    if (cell.v == '<i class="fa fa-check" aria-hidden="true"></i>')
                        cell.v = 'checked';
                    var cell_ref = XLSX.utils.encode_cell({
                        c: C,
                        r: R
                    });

                    if (typeof cell.v === 'number') cell.t = 'n';
                    else if (typeof cell.v === 'boolean') cell.t = 'b';
                    else if (cell.v instanceof Date) {
                        cell.t = 'n';
                        cell.z = XLSX.SSF._table[14];
                        cell.v = datenum(cell.v);
                    } else cell.t = 's';

                    ws[cell_ref] = cell;
                }
            }
            if (range.s.c < 10000000) ws['!ref'] = XLSX.utils.encode_range(range);
            return ws;
        }

        $('body').on('click', '#saveMe', function (btn) {
            var ws_name = "DataTables";

            var data = table.data();


            var names = [];
            table.columns().every(function () {
                names.push(this.title());
            });

            data.unshift(names);

            var wb = new Workbook();
            var ws = sheet_from_array_of_arrays(data);

            wb.SheetNames.push(ws_name);
            wb.Sheets[ws_name] = ws;
            var wbout = XLSX.write(wb, {
                bookType: 'xlsx',
                bookSST: true,
                type: 'binary'
            });

            saveAs(new Blob([s2ab(wbout)], {
                type: "application/octet-stream"
            }), "DataTables.xlsx");

        });


        $('#start_date, #end_date').datepicker({
            singleDatePicker: true,
            timePicker: false,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
            defaultDate: null,
        });

        $(".btn-clear").click(function () {
            $("#filter_company").val('');
            $("#filter_category").val('');
            $("#action_type").val('');
            $("#start_date").val('');
            $("#end_date").val('');
            window.location = '/inventory_record';
        });

        $(".btn-filter").click(function () {
            var form = $("#filter_form");
            $.ajax({
                url: "/inventory/filter_record",
                method: "POST",
                dataType: "html",
                data: form.serialize(),

                statusCode: {
                    401: function () {
                        alert("Login expired. Please sign in again.");
                    }
                },
                success: function (html) {
                    $("#filter_div").html(html);
                    table = $('body').find('#table').DataTable();
                }
            });
        });



    });
</script>
@endpush