@extends('layouts.app')

@section('content')

<div class="page-header">
    <h3>Manpower Allocation</h3>
</div>

<script>
$(function () {
    
    $('#blockManpowerUsers').find('input, textarea, button, select').prop('disabled',true);
    
    $("#click_to_edit").click(function(e) {
        $("#donemessage").html("");
        $("#click_to_save").show();
        $("#click_to_edit").hide();
        
        $('#blockManpowerUsers').find('input, textarea, button, select').prop('disabled',false);
    });
    $("#click_to_save").click(function(e) {
        $("#click_to_save").hide();
        $("#click_to_edit").show();
        $('#blockManpowerUsers').find('input, textarea, button, select').prop('disabled',true);
    });
 });
</script>
@if(!isset($is_view))
<div class="section">   
    <div><input type="hidden" id="token" value="{{ csrf_token() }}">
        <table cellpadding='10' cellspacing='10' border='0' width="100%">
            <tr>
                <td>
                    <strong>Showing</strong> {{ date("j F, Y, H:i a") }}
                </td>
                <td align="left" id="donemessage" style="color:green">
                    
                </td>
                <td align="center">
                        <input class="btn btn-blue-500" type="button" name="save_button" value="Click to edit" id="click_to_edit" onclick="App.updateManpowerEditingStatus(this)" />
                        <input style="display:none" class="btn btn-blue-500" type="button" name="save_button" value="Click to save" id="click_to_save" onclick="App.updateManpowerAllocation(this)" />
                </td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
        </table>
        <table cellpadding='10' cellspacing='10' border='0' id="blockManpowerUsers" width="100%">
            <tr>
                <td colspan="2" valign="top">
                    <div id="listing">
                        <table  id="listing_tbl" class="table table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <td>OFF</td>
                                    <td>
                                        @if( $usersdata )
                                        <select class="form-control" name="users_ids1" data-toggle="select2" disabled="" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[1]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                    <td>M/C</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids2" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[2]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                    <td>A/L</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids3" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[3]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>LUNCH: 12</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids4" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[4]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                    <td>LUNCH: 1</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids5" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[5]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="listing">
                        <table  id="listing_tbl" class="table table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <td>EMBALMERS</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids10" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[10]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                    <td>SUPERVISORS</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids11" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[11]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>BEARERS</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids12" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[12]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                    <td>DRIVERS</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids13" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[13]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td style="padding-left:10px">
                    <div id="listing">
                        <table  id="listing_tbl" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th colspan="2">OP'S: 456456</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>OP'S</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids6" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[6]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>N/Shift</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids7" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[7]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>1-8PM(B)</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids8" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[8]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>8-10AM(A)</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids9" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[9]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <div id="listing">
                        <table  id="listing_tbl" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th colspan="4" class="text-center">SHIFTING</th>
                                </tr>
                                <tr>
                                    <th>SHIFTING DETAILS</th>
                                    <th>SHIFTING</th>
                                    <th>SENDING OUT</th>
                                    <th>SENDING PARLOUR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($pendingShiftingList)
                                    @foreach ($pendingShiftingList as $shifting)
                                        <tr>
                                            <td><a href='/shifting/{{ $shifting->id }}' target="_blank">{{ $shifting->deceased_name }}</a>, {{ $shifting->start_date ? date('d/m/Y, H:i', strtotime($shifting->start_date)) : '' }},
                                                {{ $shifting->end_date ? date('d/m/Y, H:i', strtotime($shifting->end_date)) : '' }}</td>
                                            <td>
                                                @if( $usersdata )
                                                    <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                        @foreach( $usersdata as $usersdataVal )
                                                            <option value="{{ $usersdataVal->id }}">{{ $usersdataVal->name }}
                                                            </option>
                                                        @endforeach
                                                    </select> 
                                                @endif
                                            </td>
                                            <td>
                                                @if( $usersdata )
                                                    <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                        @foreach( $usersdata as $usersdataVal )
                                                            <option value="{{ $usersdataVal->id }}">{{ $usersdataVal->name }}
                                                            </option>
                                                        @endforeach
                                                    </select> 
                                                @endif
                                            </td>
                                            <td>
                                                @if( $usersdata )
                                                    <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                        @foreach( $usersdata as $usersdataVal )
                                                            <option value="{{ $usersdataVal->id }}">{{ $usersdataVal->name }}
                                                            </option>
                                                        @endforeach
                                                    </select> 
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                </td>
                <td style="padding-left:10px" valign="top">
                    <div id="listing">
                        <table  id="listing_tbl" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-center">Miscellaneous</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>EMBASSY</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids16" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[16]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>PHOTO</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids17" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[17]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>OTHERS</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids18" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[18]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>TRANSFER ASH</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids19" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[19]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>WASH VEHICLES</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids20" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[20]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>ASH COLLECTION</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids21" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[21]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>ST</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids22" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[22]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>COLUMBORIUM</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids23" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[23]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td style="padding-left:10px" valign="top">
                    <div id="listing">
                        <table  id="listing_tbl" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>OUTSIDE WAKE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" style="width:150px" class="form-control" name="manpower_text14" value="{{ ((isset($manpoweralltextarr)&&$manpoweralltextarr[1])!=""?$manpoweralltextarr[1]:"") }}"></td>
                                </tr>
                                <tr>
                                    <td>WORKSHOP</td>
                                </tr>
                                <tr>
                                    <td><input type="text" style="width:150px" class="form-control" name="manpower_text15" value="{{ ((isset($manpoweralltextarr)&&$manpoweralltextarr[1])!=""?$manpoweralltextarr[2]:"") }}"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div id="listing">
                        <table  id="listing_tbl" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th colspan="4" class="text-center">CLEANING</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Toilet 2</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids24" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[24]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                    <td>L1</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids25" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[25]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Toilet 3</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids26" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[26]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                    <td>L2</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids27" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[27]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Toilet 4</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids28" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[28]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                    <td>L6</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids29" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[29]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Toilet 5</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids30" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[30]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                    <td class="text-center" colspan="2">STAIRS</td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td>A</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids31" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[31]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td>B</td>
                                    <td>
                                        @if( $usersdata )
                                            <select class="form-control" name="users_ids32" data-toggle="select2" multiple="">
                                                @foreach( $usersdata as $usersdataVal )
                                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $manpowerallarr[32]))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                                    </option>
                                                @endforeach
                                            </select> 
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </td>
                
            </tr>
            <tr>
                <td>
                    <div id="listing">
                        <table id="parlourBlockDiv" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center">PARLOURS</th>
                                    <th>FUNERAL</th>
                                    <th>Funeral Out</th>
                                    <th>PARLOUR CLEANING</th>
                                    <th>NEXT IN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>T/UP</td>
                                    <td>Name</td>
                                    <td>Manpower</td>
                                    <td>Deceased</td>
                                    <td></td>
                                    <td></td>
                                    <td>Date, Time</td>
                                </tr>
                                        
                                @if ($parlourDataAll)
                                <?php $p = 1; ?>
                                    @foreach ($parlourDataAll as $parlourDataVal)
                                        <tr>
                                            <td><input type="text" style="width:50px" class="form-control" id="fa_code" name="fa_code" value=""></td>
                                            <td>{{ $parlourDataVal->parlour_name }}</td>
                                            <td>
                                                @if( $usersdata )
                                                <select class="form-control" name="users_ids_parlour_manpower{{$p}}" data-toggle="select2" multiple="" style="width:100px">
                                                        @foreach( $usersdata as $usersdataVal )
                                                            <option value="{{ $usersdataVal->id }}"
                                                                                        @if (in_array($usersdataVal->id, $parlourDataVal->parlour_allocation))
                                                                                        selected="selected"
                                                                                        @endif
                                                                                >{{ $usersdataVal->name }}
                                                            </option>
                                                        @endforeach
                                                    </select> 
                                                @endif
                                                <input type="hidden" name="parlourOrderId{{$p}}" value="{{ $parlourDataVal->parlour_order_id }}" />
                                            </td>
                                            <td>{{ $parlourDataVal->deceased_name }}</td>
                                            <td>{{ $parlourDataVal->to_time }}</td>
                                            <td>
                                                @if( $usersdata )
                                                <select class="form-control" name="users_ids_parlour_cleaning{{$p}}" data-toggle="select2" multiple="" style="width:100px">
                                                        @foreach( $usersdata as $usersdataVal )
                                                            <option value="{{ $usersdataVal->id }}""
                                                                                        @if (in_array($usersdataVal->id, $parlourDataVal->parlour_cleaning_allocation))
                                                                                        selected="selected"
                                                                                        @endif
                                                                                >{{ $usersdataVal->name }}
                                                            </option>
                                                        @endforeach
                                                    </select> 
                                                @endif
                                            </td>
                                            <td>{{ $parlourDataVal->from_date }} {{ $parlourDataVal->first_time }}</td>
                                        </tr>
                                        <?php $p++; ?>
                                    @endforeach
                                    <input type="hidden" name="parlour_order_record" id="parlour_order_record" value="{{$p}}" />
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                </td>
                <td colspan="2" style="padding-left:10px" valign="top">
                    <div id="listing">
                        <table>
                            <tr>
                                <td valign="top">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-center">HEARSE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Name</td>
                                                <td>Manpower</td>
                                            </tr>
                                            @if ($hearseDataAll)
                                                @foreach ($hearseDataAll as $hearseDataVal)
                                                    <tr>
                                                        <td>{{ $hearseDataVal->hearse_name }}</td>
                                                        <td>
                                                            @if( $usersdata )
                                                            <select class="form-control" name="users_ids" data-toggle="select2" multiple="" style="width:100px">
                                                                    @foreach( $usersdata as $usersdataVal )
                                                                        <option value="{{ $usersdataVal->id }}"
                                                                                        @if (in_array($usersdataVal->id, $hearseDataVal->hearse_allocation))
                                                                                        selected="selected"
                                                                                        @endif
                                                                                >{{ $usersdataVal->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select> 
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                                <td valign="top">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-center">VAN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Name</td>
                                                <td>Manpower</td>
                                            </tr>
                                            <tr>
                                                <td>Van1</td>
                                                <td>
                                                    @if( $usersdata )
                                                    <select class="form-control" name="users_ids33" data-toggle="select2" multiple="" style="width:100px">
                                                            @foreach( $usersdata as $usersdataVal )
                                                                <option value="{{ $usersdataVal->id }}"
                                                                            @if (in_array($usersdataVal->id, $manpowerallarr[33]))
                                                                            selected="selected"
                                                                            @endif
                                                                    >{{ $usersdataVal->name }}
                                                                </option>
                                                            @endforeach
                                                        </select> 
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Van2</td>
                                                <td>
                                                    @if( $usersdata )
                                                    <select class="form-control" name="users_ids34" data-toggle="select2" multiple="" style="width:100px">
                                                            @foreach( $usersdata as $usersdataVal )
                                                                <option value="{{ $usersdataVal->id }}"
                                                                            @if (in_array($usersdataVal->id, $manpowerallarr[34]))
                                                                            selected="selected"
                                                                            @endif
                                                                    >{{ $usersdataVal->name }}
                                                                </option>
                                                            @endforeach
                                                        </select> 
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Van3</td>
                                                <td>
                                                    @if( $usersdata )
                                                    <select class="form-control" name="users_ids35" data-toggle="select2" multiple="" style="width:100px">
                                                            @foreach( $usersdata as $usersdataVal )
                                                                <option value="{{ $usersdataVal->id }}"
                                                                            @if (in_array($usersdataVal->id, $manpowerallarr[35]))
                                                                            selected="selected"
                                                                            @endif
                                                                    >{{ $usersdataVal->name }}
                                                                </option>
                                                            @endforeach
                                                        </select> 
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Van4</td>
                                                <td>
                                                    @if( $usersdata )
                                                    <select class="form-control" name="users_ids36" data-toggle="select2" multiple="" style="width:100px">
                                                            @foreach( $usersdata as $usersdataVal )
                                                                <option value="{{ $usersdataVal->id }}"
                                                                            @if (in_array($usersdataVal->id, $manpowerallarr[36]))
                                                                            selected="selected"
                                                                            @endif
                                                                    >{{ $usersdataVal->name }}
                                                                </option>
                                                            @endforeach
                                                        </select> 
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Van5</td>
                                                <td>
                                                    @if( $usersdata )
                                                    <select class="form-control" name="users_ids37" data-toggle="select2" multiple="" style="width:100px">
                                                            @foreach( $usersdata as $usersdataVal )
                                                                <option value="{{ $usersdataVal->id }}"
                                                                            @if (in_array($usersdataVal->id, $manpowerallarr[37]))
                                                                            selected="selected"
                                                                            @endif
                                                                    >{{ $usersdataVal->name }}
                                                                </option>
                                                            @endforeach
                                                        </select> 
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Van6</td>
                                                <td>
                                                    @if( $usersdata )
                                                    <select class="form-control" name="users_ids38" data-toggle="select2" multiple="" style="width:100px">
                                                            @foreach( $usersdata as $usersdataVal )
                                                                <option value="{{ $usersdataVal->id }}"
                                                                            @if (in_array($usersdataVal->id, $manpowerallarr[38]))
                                                                            selected="selected"
                                                                            @endif
                                                                    >{{ $usersdataVal->name }}
                                                                </option>
                                                            @endforeach
                                                        </select> 
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Van7</td>
                                                <td>
                                                    @if( $usersdata )
                                                    <select class="form-control" name="users_ids39" data-toggle="select2" multiple="" style="width:100px">
                                                            @foreach( $usersdata as $usersdataVal )
                                                                <option value="{{ $usersdataVal->id }}"
                                                                            @if (in_array($usersdataVal->id, $manpowerallarr[39]))
                                                                            selected="selected"
                                                                            @endif
                                                                    >{{ $usersdataVal->name }}
                                                                </option>
                                                            @endforeach
                                                        </select> 
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Van8</td>
                                                <td>
                                                    @if( $usersdata )
                                                    <select class="form-control" name="users_ids40" data-toggle="select2" multiple="" style="width:100px">
                                                            @foreach( $usersdata as $usersdataVal )
                                                                <option value="{{ $usersdataVal->id }}"
                                                                            @if (in_array($usersdataVal->id, $manpowerallarr[40]))
                                                                            selected="selected"
                                                                            @endif
                                                                    >{{ $usersdataVal->name }}
                                                                </option>
                                                            @endforeach
                                                        </select> 
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

@endif;
@endsection


@push('css')
    <link href="/css/app/hearse.css" rel="stylesheet">
    <style>
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding: 3px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #e0e7e8;
    }
</style>
@endpush

 @push('scripts')
    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/general_form.js"></script>    
@endpush