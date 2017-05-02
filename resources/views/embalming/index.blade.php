@extends('layouts.app')

@section('content')

<div class="section">

    
    <div class="section_title">Shifting Information</div>
    <div>
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th>
                    Date
                </th>
                <th>
                    Deceased Name
                </th>
                <th>
                    Hospital / House
                </th>
                <th>
                    Send Parlour
                </th>
                <th>
                    Send Outside
                </th>
                <th>
                    Shifted By
                </th>
                <th>
                    Reference
                </th>
            </tr>
            @foreach ($shiftingInfo as $line)
            <tr>
                <td>
                    {{ date("d-m-Y", strtotime( $line->created_at )) }}
                </td>
                <td>
                    {{$line->deceased_name}}
                </td>
                <td>
                    {{$line->hospital}}
                </td>
                <td>
                    {{$line->send_parlour}}
                </td>
                <td>
                    {{$line->send_outside}}
                </td>
                <td>
                    {{$line->creator->name}}
                </td>
                <td>
                    <?php 
                    $fa = $line->fa;
                    if ($fa){
                        echo '<a href="'. url("/fa/view/" . $fa->id ) .'">View FA</a>';
                    }
                    ?>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
    
    
<div class="section">
    <div class="section_title">Update Information</div>
    <div>
        <table>
            <tr>
                <td style="width: 200px">Deceased Name</td>
                <td style="width: 200px">
                    <select class="form-control" id="selected_shifting_id" data-toggle="select2" class="form-control">
                        @foreach ($shiftingInfo as $line)
                            <option value="{{ $line->id }}">
                                {{ $line->deceased_name }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>Embalmer Name</td>
                <td>
                    <select class="form-control" id="embalmer_users" data-toggle="select2" multiple class="form-control">
                        @foreach ($departmentUsers as $user)
                            <option value="{{ $user->name }}">
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>Other Staff</td>
                <td>
                    <select class="form-control" id="other_staff_users" data-toggle="select2" multiple class="form-control">
                        @foreach ($users as $user)
                            <option value="{{ $user->name }}">
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
        </table>
        <div class="title_before_buttons">Progress buttons:</div>
        <div>
            <div class="update_button two_lines_div" id="check_br">Body Received</div>
            <div class="update_button one_line_div" id="check_clothing">Clothing</div>
            <div class="update_button one_line_div" id="check_photo">Photo</div>
            <div class="update_button two_lines_div warning_button" id="check_no_e">No Embalming</div>
            <div class="update_button two_lines_div" id="check_start_e">Start Embalming</div>
            <div class="update_button two_lines_div" id="check_end_e">End Embalming</div>
            <div class="update_button one_line_div" id="check_dressing">Dressing</div>
            <div class="update_button one_line_div" id="check_makeup">Makeup</div>
            <div class="update_button two_lines_div" id="check_bs">Body Sent</div>
            <div class="update_button one_line_div" id="check_complete">Complete</div>
        </div>
        <div style="clear: both"></div>
    </div>
</div>

    
    
<div class="section">  
    <div class="section_title">Timelog</div>
    <div id="timelog_container">
        
        <table class="table table-striped table-bordered table-hover">
            <tr id="tbl_header">
                <th>Date, Time</th>
                <th>Deceased Name</th>
                <th>Hospital / House</th>
                <th>Shifted By</th>
                <th>Clothing</th>
                <th>Photo</th>
                <th>Coffin Model</th>
                <th>Items to put inside coffin</th>
                <th>Embalming Start</th>
                <th>Embalming End</th>
                <th>Dressing</th>
                <th>Make up</th>
                <th>Body Sent</th>
                <th>Progress</th>
            </tr>
            <tr id="filter_section">
                <td colspan="14">
                    <table style="width: 70%">
                        <tr>
                            <td style="width:15%">Search for previous records</td>
                            <td><input type="text" class="form-control" id="search_term" /></td>
                            <td style="width: 100px;text-align: right; padding-right: 10px;">Filter:</td>
                            <td style="width: 150px;"><input type="text" class="form-control" id="start_value" style="width:130px" /></td>
                            <td style="width: 50px;text-align: right;padding-right: 10px;">to</td>
                            <td><input type="text" class="form-control" id="end_value" style="width:130px" /></td>
                            <td><input type="button" class="btn" id="get_logs_bttn" value="Go" /></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
    </div>
</div>
      
    
    
    
<div class="modal fade" id="save_msg" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Warning</h4>
            </div>

            <div class="modal-body">
                <div class="form-group" id="message_container">
                    
                </div>
            </div>
            <div class="modal-footer">
                
            </div>

        </div>
    </div>
</div>
@endsection


@push('css')
    <link href="/css/app/embalming.css" rel="stylesheet">
@endpush

 @push('scripts')
    <script src="/js/app/embalming.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
@endpush