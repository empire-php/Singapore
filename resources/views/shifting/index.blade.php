@extends('layouts.app')

@section('content')
    <input type="hidden" id="token" value="{{ csrf_token() }}">
    <div class="page-header">
        <h3>
            New Shifting
        </h3>
    </div>
    <div class="row">
        <form method="POST" action="{{ url('/shifting/create') }}">
            {!! csrf_field() !!}
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Point of Contact
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>1st Contact Person</h5>
                                <hr/>
                                <div class="form-group{{ $errors->has('first_contact_title') ? ' has-error' : ''}}">
                                    <label class="control-label">Title</label>
                                    <select name="first_contact_title" class="form-control">
                                        <option disabled selected value></option>
                                        <option value="Mr"
                                                @if ("Mr" == old('first_contact_title'))
                                                selected="true"
                                                @endif
                                        >Mr</option>
                                        <option value="Mdm"
                                                @if ("Mdm" == old('first_contact_title'))
                                                selected="true"
                                                @endif
                                        >Mdm</option>
                                        <option value="Miss"
                                                @if ("Miss" == old('first_contact_title'))
                                                selected="true"
                                                @endif
                                        >Miss</option>
                                        <option value="Dr"
                                                @if ("Dr" == old('first_contact_title'))
                                                selected="true"
                                                @endif
                                        >Dr</option>
                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('first_contact_name') ? ' has-error' : ''}}">
                                    <label class="control-label">Name</label>
                                    <input type="text" name="first_contact_name" class="form-control" value="{{ old('first_contact_name') }}"/>

                                    @if ($errors->has('first_contact_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('first_contact_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('first_contact_religion') ? ' has-error' : ''}}">
                                    <label class="control-label">Religion</label>
                                    <select name="first_contact_religion" class="form-control">
                                        <option disabled selected value></option>
                                        @foreach($religionOptions as $religionOp)
                                            <option value="{{ $religionOp->id}}"
                                                    @if ($religionOp->name == old('first_contact_religion'))
                                                    selected="true"
                                                    @endif
                                            >{{$religionOp->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group margin-bottom-none{{ $errors->has('first_contact_number') ? ' has-error' : ''}}">
                                    <label class="control-label">Mobile Number</label>
                                    <input type="text" class="form-control" name="first_contact_number" value="{{ old('first_contact_number') }}"/>

                                    @if ($errors->has('first_contact_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('first_contact_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>2nd Contact Person</h5>
                                <hr/>
                                <div class="form-group{{ $errors->has('second_contact_title') ? ' has-error' : ''}}">
                                    <label class="control-label">Title</label>
                                    <select name="second_contact_title" class="form-control">
                                        <option disabled selected value></option>
                                        <option value="Mr"
                                                @if ("Mr" == old('second_contact_title'))
                                                selected="true"
                                                @endif
                                        >Mr</option>
                                        <option value="Mdm"
                                                @if ("Mdm" == old('second_contact_title'))
                                                selected="true"
                                                @endif
                                        >Mdm</option>
                                        <option value="Miss"
                                                @if ("Miss" == old('second_contact_title'))
                                                selected="true"
                                                @endif
                                        >Miss</option>
                                        <option value="Dr"
                                                @if ("Dr" == old('second_contact_title'))
                                                selected="true"
                                                @endif
                                        >Dr</option>
                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('second_contact_name') ? ' has-error' : ''}}">
                                    <label class="control-label">Name</label>
                                    <input type="text" class="form-control" name="second_contact_name" value="{{ old('second_contact_name') }}"/>

                                    @if ($errors->has('second_contact_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('second_contact_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('second_contact_religion') ? ' has-error' : ''}}">
                                    <label class="control-label">Religion</label>
                                    <select name="second_contact_religion" class="form-control">
                                        <option disabled selected value></option>
                                        @foreach($religionOptions as $religionOp)
                                            <option value="{{ $religionOp->id}}"
                                                    @if ($religionOp->name == old('second_contact_religion'))
                                                    selected="true"
                                                    @endif
                                            >{{$religionOp->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group margin-bottom-none{{ $errors->has('second_contact_number') ? ' has-error' : ''}}">
                                    <label class="control-label">Mobile Number</label>
                                    <input type="text" class="form-control" name="second_contact_number" value="{{ old('second_contact_number') }}"/>

                                    @if ($errors->has('second_contact_number'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('second_contact_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Deceased Information
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('deceased_title') ? ' has-error' : ''}}">
                                    <label class="control-label">Title</label>
                                    <select name="deceased_title" class="form-control">
                                        <option disabled selected value></option>
                                        <option value="Mr"
                                                @if ("Mr" == old('deceased_title'))
                                                selected="true"
                                                @endif
                                        >Mr</option>
                                        <option value="Mdm"
                                                @if ("Mdm" == old('deceased_title'))
                                                selected="true"
                                                @endif
                                        >Mdm</option>
                                        <option value="Miss"
                                                @if ("Miss" == old('deceased_title'))
                                                selected="true"
                                                @endif
                                        >Miss</option>
                                        <option value="Dr"
                                                @if ("Dr" == old('deceased_title'))
                                                selected="true"
                                                @endif
                                        >Dr</option>
                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('deceased_name') ? ' has-error' : ''}}">
                                    <label class="control-label">Deceased Name</label>
                                    <input type="text" class="form-control" name="deceased_name" value="{{ old('deceased_name') }}">

                                    @if ($errors->has('deceased_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('deceased_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('deceased_religion') ? ' has-error' : ''}}">
                                    <label class="control-label">Religion</label>
                                    <select name="deceased_religion" class="form-control">
                                        <option disabled selected value></option>
                                        @foreach($religionOptions as $religionOp)
                                            <option value="{{ $religionOp->id}}"
                                                    @if ($religionOp->name == old('deceased_religion'))
                                                    selected="true"
                                                    @endif
                                            >{{$religionOp->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('hospital') ? ' has-error' : ''}}">
                                    <label class="control-label">Hospital/House</label>
                                    <input type="text" class="form-control" name="hospital" value="{{ old('hospital') }}"/>

                                    @if ($errors->has('hospital'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('hospital') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                            <!--                  <div class="form-group{{ $errors->has('send_parlour') ? ' has-error' : ''}}">
                                    <label class="control-label">Send Parlour</label>
                                    <input type="text" class="form-control" id="send_parlour" name="send_parlour" value="{{ old('send_parlour') }}"/>

                                    @if ($errors->has('send_parlour'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('send_parlour') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                 -->
                                <!-- Add a button	-->

                                <div class="form-group">
                                    <label class="control-label">Send Parlour</label></br>

                                    <input type="text" class="form-control" id="send_parlour" name="send_parlour" value="{{ old('send_parlour') }}" style="margin-right:20px;width:200px;float:left" />
                                    <input type="hidden" id="parlour_order_id" name="parlour_order_id" value="{{ old('parlour_order_id') }}">
                                    <a class= "btn btn-info" id = "pop-up-parlour" name = "pop-up-parlour">Select parlour </a>
                                </div>



                                <!--      end      -->
                                <div class="form-group{{ $errors->has('send_outside') ? ' has-error' : ''}}">
                                    <label class="control-label">Send Outside</label>
                                    <input type="text" class="form-control" name="send_outside" value="{{ old('send_outside') }}"/>

                                    @if ($errors->has('send_outside'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('send_outside') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group margin-bottom-none{{ $errors->has('remarks') ? ' has-error' : ''}}">
                                    <label class="control-label">Remarks</label>
                                    <textarea class="form-control" name="remarks">{{ old('remarks') }}</textarea>

                                    @if ($errors->has('remarks'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('remarks') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Others
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Taken by</label>
                                    <input type="text" class="form-control" disabled value="{{ Auth::User()->name }}">
                                    <input type="hidden" name="creator_id" class="form-control" value="{{ Auth::User()->id }}">
                                </div>
                                <div class="form-group margin-bottom-none">
                                    <label class="control-label">Date/Time</label>
                                    <input type="text" class="form-control" disabled value="{{ date('d/m/Y, H:i') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group margin-bottom-none text-right">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fa fa-save"></i>
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @if ($pendingShiftingList)
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Update Shiftings
                        </h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
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
                                    1st Contact Person
                                </th>
                                <th>
                                    2nd Contact Person
                                </th>
                                <th>
                                    Remarks
                                </th>
                                <th>
                                    Shifted by
                                </th>
                                <th>
                                    Time start
                                </th>
                                <th>
                                    Time end
                                </th>
                                @if ($canUpdate)
                                    <th class="text-right">
                                        Action
                                    </th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pendingShiftingList as $shifting)
                                <tr>
                                    <td>
                                        {{ $shifting->deceased_title }} {{ $shifting->deceased_name }}
                                    </td>
                                    <td>
                                        {{ $shifting->hospital }}
                                    </td>
                                    <td>
                                        {{ $shifting->send_parlour }}
                                    </td>
                                    <td>
                                        {{ $shifting->send_outside }}
                                    </td>
                                    <td>
                                        {{ $shifting->first_contact_title }} {{ $shifting->first_contact_name }}, {{ $shifting->first_contact_number }}
                                    </td>
                                    <td>
                                        {{ $shifting->second_contact_title }} {{ $shifting->second_contact_name }}, {{ $shifting->second_contact_number }}
                                    </td>
                                    <td>
                                        @if ($canUpdate)
                                            <textarea class="form-control" name="remarks">{{ $shifting->remarks }}</textarea>
                                        @else
                                            {{ $shifting->remarks }}
                                        @endif
                                    </td>
                                    <td style="width:100px" {{ $canUpdate ? ' class="padding-v-5"' : '' }}>
                                        @if ($canUpdate)
                                            <select class="form-control" name="users_ids" data-toggle="select2" multiple="">
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                            @if (in_array($user->id, $shifting->members()->getRelatedIds()->toArray()))
                                                            selected="selected"
                                                            @endif
                                                    >
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            @if ($shifting->members())
                                                @foreach ($shifting->members()->get() as $user)
                                                    <span class="label label-info margin-v-1">{{ $user->name }}</span>
                                                @endforeach
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($canUpdate)
                                            <input type="text" class="form-control datetimepicker" name="start_date"
                                                   value="{{ $shifting->start_date ? date('d/m/Y, H:i', strtotime($shifting->start_date)) : '' }}">
                                        @else
                                            {{ $shifting->start_date ? date('d/m/Y, H:i', strtotime($shifting->start_date)) : '' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($canUpdate)
                                            <input type="text" class="form-control datetimepicker" name="end_date"
                                                   value="{{ $shifting->end_date ? date('d/m/Y, H:i', strtotime($shifting->end_date)) : '' }}">
                                        @else
                                            {{ $shifting->end_date ? date('d/m/Y, H:i', strtotime($shifting->end_date)) : '' }}
                                        @endif
                                    </td>
                                    @if ($canUpdate)
                                        <td class="text-right">
                                            <button class="btn btn-info btn-xs" onclick="App.updateShifting(this)"
                                                    data-shifting-id="{{ $shifting->id }}">
                                                <i class="fa fa-fw fa-save"></i>Save
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Completed Shiftings
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <form method="GET" class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-md-6"></div>
                                    <label class="col-md-1 control-label">Filter</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control datetimepicker" name="from" id="filterFrom" placeholder="From" value="{{ $fromFilter }}">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control datetimepicker" name="to" id="filterTo" placeholder="To" value="{{ $toFilter }}">
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="submit" class="btn btn-info btn-block">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xs-12">
                            @if ($finishedShiftingList)
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
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
                                            1st Contact Person
                                        </th>
                                        <th>
                                            2nd Contact Person
                                        </th>
                                        <th>
                                            Remarks
                                        </th>
                                        <th>
                                            Shifted by
                                        </th>
                                        <th>
                                            Time start
                                        </th>
                                        <th>
                                            Time end
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($finishedShiftingList as $shifting)
                                        <tr>
                                            <td>
                                                {{ $shifting->deceased_title }} {{ $shifting->deceased_name }}
                                            </td>
                                            <td>
                                                {{ $shifting->hospital }}
                                            </td>
                                            <td>
                                                {{ $shifting->send_parlour }}
                                            </td>
                                            <td>
                                                {{ $shifting->send_outside }}
                                            </td>
                                            <td>
                                                {{ $shifting->first_contact_title }} {{ $shifting->first_contact_name }}, {{ $shifting->first_contact_number }}
                                            </td>
                                            <td>
                                                {{ $shifting->second_contact_title }} {{ $shifting->second_contact_name }}, {{ $shifting->second_contact_number }}
                                            </td>
                                            <td>
                                                {{ $shifting->remarks }}
                                            </td>
                                            <td>
                                                @if ($shifting->members())
                                                    @foreach ($shifting->members()->get() as $user)
                                                        <span class="label label-info margin-v-1">{{ $user->name }}</span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                {{ date('d/m/Y, H:i', strtotime($shifting->start_date)) }}
                                            </td>
                                            <td>
                                                {{ date('d/m/Y, H:i', strtotime($shifting->end_date)) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--    Add parlours modal popup window -->

    <div class="modal fade" id="parlour_popup" tabindex="-1" role="dialog" style="overflow:scroll">
        <div class="modal-dialog" role="document" style="width:57%">
            <div class="modal-content" style="overflow-x:scroll">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="text-align:center">Parlour</h4>
                </div>

                <div class="modal-body" style="width:100%;">
                    <div class="parlour_form">
                        <div class="section">
                            <div class="section_title">Parlour selection</div>
                            <div>
                                <div class="capacity_filter_text">Capacity:</div> <input class="form-control capacity_filter_input" type="text" id="capacity_filter" />
                                <div style="clear:both; height:30px"></div>
                                <?php $i = 0;?>

                                @foreach($items as $key => $item)
                                    <div id="item_{{$item['id']}}" class="item2select
								@if (isset($order))
                                    @if ($order->parlour_name == $item['name'])
                                            selected_item
                                            @endif
                                    @endif
                                    <?php echo (!isset($is_popup))?'':'popup_view'?>" >
                                        <table style="width:100%">
                                            <tr><td class="img_container">
                                                    @if (!empty($item["image"][0]))
                                                        <img src="/uploads/{{$item['image'][0]}}" />
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="item_text">
                                                    <span class="parlour_name_container">{{(isset($item['name']))?$item['name']:''}}</span>
                                                    <br <?php echo (!isset($is_popup))?'':'style="line-height:5px"'?> />
                                                    Capacity: <span class="parlour_capacity_container">{{(isset($item['capacity']))?$item['capacity']:''}}</span>
                                                    <br <?php echo (!isset($is_popup))?'':'style="line-height:5px"'?> />
                                                    Unit price: $<span class="unit_price">{{(isset($item['unit_price']))?$item['unit_price']:''}}</span>
                                                </td>
                                            </tr>
                                            <tr><td class="item_btn">SELECT</td></tr>
                                        </table>
                                    </div>
                                    <?php if (isset($is_popup) && $i++ % 4 == 3):?>
                                    <div style="clear:both"></div>
                                    <?php endif;?>
                                @endforeach
                                <div style="clear:both"></div>
                            </div>
                        </div>

                        <div class="section" <?php echo (!isset($is_popup))?'':'style="margin-bottom:0px"'?>>
                            <div class="section_title">Parlour booking details</div>
                            <div>
                                <form id="booking_parlour" action="/parlour/save" method="post" class="master_form" onsubmit="return false">
                                    {!! csrf_field() !!}
                                    <input type="hidden" id="order_id" name="id" value="{{(isset($order))?$order->id:""}}" />
                                    <input type="hidden" id="parlour_id" name="parlour_id" value="{{(isset($order))?$order->parlour_id:""}}" />
                                    <input type="hidden" id="is_order" name="is_order" value="1" />
                                    <table id="order_form_tbl">
                                        @if (!isset($is_popup))
                                            <tr>
                                                <td style="width: 20%">Capacity </td>
                                                <td style="<?php echo (!isset($is_popup))?'width: 236px':''?>"><input type="text" class="form-control" name="capacity" id="capacity" value="{{(isset($order))?$order->capacity:""}}" /></td>
                                                <td style="width: 10%"></td>
                                                <td></td>
                                                @if (!isset($is_popup))
                                                    <td style="width: 8%">Date </td>
                                                    <td>{{(isset($order))? date("d/m/Y H:i", strtotime($order->created_at)):date("d/m/Y H:i")}}</td>
                                                @endif
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>Parlour selection </td>
                                            <td><span id="parlour_selection_container">{{(isset($order))?$order->parlour_name:""}}</span><input type="hidden" name="parlour_name" id="parlour_name" value="{{(isset($order))?$order->parlour_name:""}}" /></td>
                                            <td></td>
                                            <td></td>
                                            @if (!isset($is_popup))
                                                <td>Ref No: </td>
                                                <td><input type="text" style="width:150px" class="form-control" id="fa_code" name="fa_code" value="{{(isset($order) && $order->funeral_arrangement_id)?$order->funeralArrangement->generated_code:""}}"  /><input type="hidden"  id="fa_id" name="fa_id" value="{{(isset($order))?$order->funeral_arrangement_id:""}}"  /></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Unit price </td>
                                            <td><span id="unit_price_container">{{(isset($order))?"$" . $order->unit_price:""}}</span><input type="hidden" name="unit_price" id="unit_price" value="{{(isset($order))?$order->unit_price:""}}" /></td>
                                            <td></td>
                                            <td></td>
                                            @if (!isset($is_popup))
                                                <td>Order No. </td>
                                                <td>P{{$order_nr}} <?php echo (!isset($order))?"<span style='color: #CCC; font-size:11px'>(might change after saving)</span>":"";?></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Date from: </td>
                                            <td><input type="text"  class="form-control" id="booked_from_day" name="booked_from_day" value="{{(isset($order) && $order->booked_from_day !="0000-00-00")? date("d/m/Y", strtotime($order->booked_from_day)):""}}" /></td>
                                            <td style="padding-left: 10px;">Date to: </td><td></td><td></td>
                                            <td><input type="text" class="form-control" id="booked_to_day" name="booked_to_day" value="{{(isset($order) && $order->booked_to_day !="0000-00-00")? date("d/m/Y", strtotime($order->booked_to_day)):""}}" /></td>
                                            @if (!isset($is_popup))

                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Time from: </td>
                                            <td>
                                                <select class="form-control selectpicker" title="" name="booked_from_time" id="booked_from_time">
                                                    <option></option>
                                                    <?php $booked_from_time = (isset($order))?substr($order->booked_from_time, 0, -3):""; ?>
                                                    <?php for ($i = 0; $i < 24; $i++):?>
                                                    <option value="<?php echo sprintf("%02d", $i) . ":00";?>"
                                                            @if ($booked_from_time == sprintf("%02d", $i) . ":00")
                                                            selected="selected"
                                                            @endif
                                                    ><?php echo sprintf("%02d", $i) . ":00";?></option>
                                                    <option value="<?php echo sprintf("%02d", $i) . ":30";?>"
                                                            @if ($booked_from_time == sprintf("%02d", $i) . ":30")
                                                            selected="selected"
                                                            @endif
                                                    ><?php echo sprintf("%02d", $i) . ":30";?></option>
                                                    <?php endfor?>
                                                </select>
                                            </td>
                                            <td style="padding-left: 10px;">Time to: </td><td></td><td></td>
                                            <td>
                                                <select class="form-control selectpicker" title="" name="booked_to_time" id="booked_to_time">

                                                    <?php $booked_to_time = (isset($order))?substr($order->booked_to_time, 0, -3):""; ?>
                                                    <option></option>
                                                    <?php for ($i = 1; $i <= 24; $i++):?>
                                                    <option value="<?php echo sprintf("%02d", $i-1) . ":30";?>"
                                                            @if ($booked_to_time == sprintf("%02d", $i) . ":30")
                                                            selected="selected"
                                                            @endif
                                                    ><?php echo sprintf("%02d", $i-1) . ":30";?></option>
                                                    <?php if ($i == 24):?>
                                                    <option value="23:59"
                                                            @if ( $booked_to_time == "23:59:00")
                                                            selected="selected"
                                                            @endif
                                                    >23:59</option>
                                                    <?php else:?>
                                                    <option value="<?php echo sprintf("%02d", $i) . ":00";?>"
                                                            @if ($booked_to_time == sprintf("%02d", $i) . ":00")
                                                            selected="selected"
                                                            @endif
                                                    ><?php echo sprintf("%02d", $i) . ":00";?></option>
                                                    <?php endif;?>
                                                    <?php endfor?>
                                                </select>
                                            </td>
                                            @if (!isset($is_popup))
                                                <td></td>
                                                <td></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Total price </td>
                                            <td>
                                                <span id="total_price_span">{{(isset($order))? "$".$order->total_price:""}}</span>
                                                <input type="hidden" class="form-control" name="total_price" id="total_price" value="{{(isset($order))? $order->total_price:""}}" />
                                                <input type="hidden" class="form-control" name="hours" id="hours" value="" />
                                            </td>
                                            <td></td>
                                            <td></td>
                                            @if (!isset($is_popup))
                                                <td></td>
                                                <td></td>
                                            @endif
                                        </tr>

                                        @if (!isset($is_popup))
                                            <tr>
                                                <td colspan="6" style="height: 50px"></td>
                                            </tr>
                                            <tr>
                                                <td>Deceased Name</td>
                                                <td><input type="text" name="deceased_name"  id="deceased_name" class="form-control" value="{{(isset($order))? $order->deceased_name:""}}"  /></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" style="height: 50px"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Confirmed By</strong></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>NRIC</td>
                                                <td><input type="text" class="form-control nric_autocomplete" id="first_cp_nric" name="cp_nric"  value="{{(isset($order))? $order->cp_nric:""}}"  /></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td><input type="text" class="form-control" id="first_cp_name" name="cp_name" value="{{(isset($order))? $order->cp_name:""}}" /></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Signature</td>
                                                <td colspan="5">
                                                    <div id="box1" >
                                                        @if (isset($order) && $order->signature)
                                                            <img src="{{$order->signature}}" style="width:100px"/>
                                                        @endif
                                                    </div>
                                                    <div class="signature_box" id="signature_box_1">
                                                        <div id="signature1" data-name="signature1" data-max-size="2048"
                                                             data-pen-tickness="3" data-pen-color="black"
                                                             class="sign-field"></div>
                                                        <input type="hidden" id="signature_image_1" name="signature_image_1" value="{{(isset($order))? $order->signature:""}}" />
                                                        <button class="btn btn-primary" >Ok</button>

                                                    </div>
                                                    Date: <span id="date_signature_1">{{(isset($order))?$order->signature_date:""}}</span><input type="hidden" name="date_signature_1" id="input_date_signature_1" value="{{(isset($order))?$order->signature_date:""}}" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" style="height: 50px"></td>
                                            </tr>
                                            <tr>
                                                <td>Taken by</td>
                                                <td>{{ Auth::User()->name }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Date, Time</td>
                                                <td>{{(isset($order))? date("d/m/Y, H:i", strtotime($order->created_at)):date("d/m/Y H:i")}}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" style="height: 50px"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" style="text-align:center"><input type="button" value="SUBMIT" id="submit_bttn_form" class="btn btn-grey-500" /></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" style="height: 20px"></td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="6" style="height: 20px"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" style="text-align:center"><input type="button" value="SAVE" id="add_info_bttn" class="btn btn-grey-600" style="padding-left: 30px;padding-right: 30px;" /></td>
                                            </tr>
                                        @endif
                                    </table>
                                </form>
                            </div>
                        </div>
                        <input type='hidden' id='dp_start_date' />
                        <input type='hidden' id='dp_end_date' />
                    </div>

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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="save_msg" tabindex="-1" role="dialog" style="z-index:11111;overflow:scroll">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Status</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group" id="message_container">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="close_all_popup();">OK</button>
                </div>

            </div>
        </div>
    </div>
    <!--  -->
    <!---   Add popup for to view all images -->
    <div class="modal fade" id="view_all_images" tabindex="-2" role="dialog" style="z-index:22222">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 700px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id=""></h4>
                </div>

                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <!--  <button type="button" class="btn btn-default" id="cancel_general_bttn">Cancel</button>  -->
                    <!--  <button type="button" class="btn btn-primary" id="save_general_bttn">Save</button>  -->
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $("#capacity_filter").keyup(function(){
        var capacity_val = $(this).val();
        $('#capacity').val(capacity_val);
    });
    $("#submit_bttn_form").click(function(){
        if( $("#parlour_selection_container").text() == ""){
            $("#message_container").html("Please select a Parlour ");
            $("#save_msg").modal("show");
            return false;
        }

        $.ajax({
            url: "parlour/parlour_modal_save",
            method: "POST",
            data: $(this).parents("form").serialize(),
            statusCode: {
                401: function() {
                    alert( "Login expired. Please sign in again." );
                }
            },
            success: function (result) {
                var message;
                //console.log(result);
                if(result) {
                    message = "Successful Parlour Booking!";
                    var parlour_send = $('#parlour_selection_container').text();

                    $('#send_parlour').val(parlour_send);
                    $('#parlour_order_id').val(result.id);

                }
                else {
                    message = "Fail Parlour Booking!";
                }

                $("#message_container").html(message);

                $("#save_msg").modal("show");

                $("#parlour_popup").modal("hide");
            }
        });

    });

</script>
<script>

    function close_all_popup(){

        $("#save_msg").modal("hide");
        $("#parlour_popup").modal("hide");
    }
</script>
<script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
<script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
<script src="{{ url('')}}/js/vendor/core/jquery-ui/autocomplete.js"></script>
<script src="{{ url('')}}/js/app/shifting.js"></script>
<script src="/js/app/parlour.js"></script>
<script src="/js/app/general_form.js"></script>
<link href="/css/app/parlour.css" rel="stylesheet">
@endpush