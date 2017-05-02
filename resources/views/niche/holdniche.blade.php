@extends('layouts.app')

@section('content')

<style>
    .suite-table td {
        border : 1px solid #aeaeae !important;
        word-wrap:break-word;
        text-align:center;
        cursor: pointer;
    }

    .suite-table tr:first-child, .suite-table td:nth-child(1), .suite-table td:last-child {
        background-color: #494949;
        color: #fff;
        border-color: #3a3a3a;
        cursor: default;
    }
    .suite-table tr:first-child > td:nth-child(1), .suite-table tr:first-child > td:last-child, .suite-table tr:first-child > td:nth-child(1)
    {
        background-color: #fff;
        border: 0px solid #fff !important;
    }
    .suite-table tr:first-child > td {
        cursor: default;
    }
</style>

    <div class="page-header">
        <h3>Niche On Hold</h3>
    </div>
    <div class="section">
        <div class="printable">
            <div class="row"><!--- Select box ---->
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="block">Block  </label>
                        <div class="col-sm-10">
                            <select id="block" class="form-control" style="min-width: 200px; width:auto;">
                                <option>[Select Block]</option>
                                @if($blocks)
                                    @foreach($blocks as $block)
                                        <option value="{{$block->id}}">{{ $block->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="suite">Suite  </label>
                        <div class="col-sm-10">
                            <select id="suite" class="form-control" style="min-width: 200px; width:auto;">
                                <option>[Select Suite]</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="section">Section  </label>
                        <div class="col-sm-10">
                            <select id="section" class="form-control" style="min-width: 200px; width:auto;">
                                <option>[Select Section]</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12" style="padding-top: 20px;text-align: center" id="niche_table">
                    <div style="text-align: center" id="help"><h5>Select a section, please.</h5></div>

                    <table class="table table-bordered suite-table" id="suiteTable" leftcolumns="3" rightcolumns="3">
                        <tr>
                            <td></td>
                            <td align="center" style="width: 200px;">Entrance</td>
                            <td></td>
                        </tr>
                    </table>

                </div>
            </div>

            <div class="row" style="padding-top: 20px;">
                <table class="table table-bordered" id="legend_table" style="width:300px;">
                    <tbody>
                    <tr><td style="min-height: 30px; font-size:14px;" colspan="2">Legend</td></tr>
                    <tr><td style="width:100px; background: yellow; height:30px;">&nbsp;</td><td>Not Avail</td></tr>
                    <tr><td style="width:100px;background: #fff; height:30px;">&nbsp;</td><td>Avail</td></tr>
                    <tr><td style="width:100px;background: #92cf51; height:30px;">&nbsp;</td><td>On Hold</td></tr>
                    <tr><td style="width:100px;background: #abb8ca; height:30px;">&nbsp;</td><td>Future Development</td></tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>


    <div class="modal fade" id="cell_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cell Information</h4>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label" for="staff">Staff Name</label>
                        <input type="text" name="staff" id="staff" value="" class="form-control" maxlength="30" readonly/>

                    </div>
                    <div class="form-group">
                        <label class="control-label" for="customer">Customer Name</label>
                        <input type="text" name="customer" id="customer" value="" class="form-control" maxlength="30"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" maxlength="100"/></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="cell_status">On Hold</label>&nbsp;&nbsp;&nbsp;
                        <label class="radio-inline"><input type="radio" name="cell_status" id="cell_status" value="0" checked/> Yes</label>
                        <label class="radio-inline"><input type="radio" name="cell_status" id="cell_status" value="1"/> No</label>
                        <input type="hidden" name="cell_id" id="cell_id" />
                        <input type="hidden" name="tdIndex" id="tdIndex" />
                        <input type="hidden" name="cell_act" id="cell_act" />
                        <input type="hidden" name="column_id" id="column_id" />
                        <input type="hidden" name="row_id" id="row_id" />
                        <input type="hidden" name="staff_name" id="staff_name" value="{{ Auth::User()->id }}" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_btn" id="cell_info_button">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {


        $('#block').change(function(e){
            e.preventDefault();
            if(this.value) {
                $.get('/holdniche/suites/' + this.value + '/suites.json', function(suites)
                {
                    var $suite = $('#suite');

                    $suite.find('option').remove().end();
                    $suite.append('<option value="">[Select Suite]</option>');
                    $.each(suites, function(index, suite) {
                        $suite.append('<option value="' + suite.id + '">' + suite.name + '</option>');
                    });
                });
            }

        });

        $('#suite').change(function(e){
            e.preventDefault();
            if(this.value) {
                $.get('/holdniche/sections/' + this.value + '/sections.json', function (sections) {
                    var $section = $('#section');

                    $section.find('option').remove().end();
                    $section.append('<option value="">[Select Section]</option>');
                    $.each(sections, function (index, section) {
                        $section.append('<option value="' + section.id + '">' + section.name + '</option>');
                    });
                });
            }
        });

        $('#section').change(function(e){
            e.preventDefault();
            if(this.value) {
                //
                $.ajax({
                    url: "{{ url('')}}/holdniche/index",
                    method: "POST",
                    data: {
                        section_id: this.value,
                        "_token": "{{ csrf_token() }}",
                    },
                    statusCode: {
                        401: function () {
                            alert("Login expired. Please sign in again.");
                        }
                    }
                }).done(function (html) {
                    $('#niche_table').html(html);
                });
            }
        });

        $('body').on("click", ".editable", function (e) {
            e.preventDefault();

            var row_id = $(this).closest("tr").attr('rowid');
            var side = $(this).attr('side');
            var column_id = $(this).attr('columnid');
            var tdIndex = $(this).index()+1;

            $('#cell_id').val('');
            $('#description').val('');
            $('#customer').val('');
            $('#row_id').val(row_id);
            $('#column_id').val(column_id);
            $('#cell_act').val('add');
            $('#td_index').val(tdIndex);
            $('#cell_popup').modal();
        });

        $('body').on("click", ".re-editable", function (e) {
            e.preventDefault();
            var cell_id = $(this).attr('cellid');
            var tdIndex = $(this).index() + 1;
           /* var row_id = $(this).closest("tr").attr('rowid');
            var column_id = $(this).attr('columnid');*/

            $.ajax({
                url: "{{ url('')}}/settings/read_niche_cell",
                method: "POST",
                data: {
                    cell_id: cell_id,
                    "_token": "{{ csrf_token() }}",
                },
                statusCode: {
                    401: function () {
                        alert("Login expired. Please sign in again.");
                    }
                }
            }).done(function (cell) {
                //console.log(cell);
                $('#cell_id').val(cell.id);
                $('#description').val(cell.description);
                $('#customer').val(cell.customer_name);
                $('#row_id').val(cell.niche_row_id);
                $('#column_id').val(cell.niche_column_id);
                $('#cell_act').val('update');
                $('#td_index').val(tdIndex);
                $('#staff').val(cell.staff);
                $("input[name=cell_status][value=" + cell.status + "]").prop('checked', true);
                $('#cell_popup').modal();
            });
        });

        $('#cell_info_button').on("click", function (e) {
            e.preventDefault();

            //Save Cell information
            var cell_id = $('#cell_id').val();
            var cell_status = $('input[name="cell_status"]:checked').val();
            var cell_row_id = $('#row_id').val();
            var cell_column_id = $('#column_id').val();
            var customer_name = $('#customer').val();
            var cell_description = $('#description').val();
            var cell_act = $('#cell_act').val();
            var cell_td_index = $('#td_index').val();
            var staff_name = $('#staff_name').val();


            if (customer_name == '' && cell_status == 0 ) {
                $('#customer').focus();
                return false;
            }

            if(cell_status == 1)
                customer_name = '';

            $.ajax({
                url: "{{ url('')}}/holdniche/hold_cell",
                method: "POST",
                data: {
                    cell_id: cell_id,
                    onhold: cell_status,
                    row_id: cell_row_id,
                    column_id: cell_column_id,
                    description: cell_description,
                    staff_name : staff_name,
                    customer_name: customer_name,
                    td_index: cell_td_index,
                    act: cell_act,
                    "_token": "{{ csrf_token() }}",
                },
                statusCode: {
                    401: function () {
                        alert("Login expired. Please sign in again.");
                    }
                }
            }).done(function (holdcell) {
                var cell_id = 'td_' + holdcell.niche_row_id + '_' + holdcell.niche_column_id;
                var cell = $('#' + cell_id);
                cell.attr('cellid', holdcell.id);
                cell.removeClass('editable');
                cell.addClass('re-editable');
                cell.attr('cellid', holdcell.id);
                cell_status = holdcell.status;

                if(cell_status == 0) { //on hold
                    cell.css("background-color", "#92cf51");
                    cell.attr('status', '0');
                    var cell_name = holdcell.name;
                    if(cell_name)
                        cell.html(holdcell.name + ' ['+customer_name+']');
                    else
                        cell.html('['+customer_name+']');

                }
                if(cell_status == 1) { //Available
                    cell.css("background-color", "#fff");
                    cell.attr('status', '1');
                    cell.html('');
                }

                if(cell_status == 2) { //Not Available
                    cell.css("background-color", "yellow");
                    //cell.off('click');
                    cell.attr('status', '2');
                }

                if(cell_status == 3) { //Future Development
                    cell.attr('status', '3');
                    cell.css("background-color", "#abb8ca");
                }

                $('#cell_popup').modal('hide');
            });
        });
    });
</script>
@endpush