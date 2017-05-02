<div class="parlour_form">
    <div class="section">   
        <div class="section_title">Parlour selection</div>
        <div>
            <div class="capacity_filter_text">Capacity:</div> <input class="form-control capacity_filter_input" type="text" id="capacity_filter" />
            <div style="clear:both; height:30px"></div>
            <?php $i = 0;?>
            @foreach($items as $key => $item)
            <div id="item_{{$item->id}}" class="item2select 
                @if (isset($parlourdetails))
                    @if ($parlourdetails->name == $item->name)
                    selected_item
                    @endif
                @endif
                <?php echo (!isset($is_popup))?'':'popup_view'?>" >
                <table style="width:100%">
                    <tr><td class="img_container">
                            @if (!empty($item->image))
                            <img src="/uploads/{{$item->image}}" />
                            @endif
                        </td>
                    </tr>
                    <tr><td class="item_text">
                            <span class="parlour_name_container">{{(isset($item->name))?$item->name:''}}</span>
                            <br <?php echo (!isset($is_popup))?'':'style="line-height:5px"'?> />
                            Capacity: <span class="parlour_capacity_container">{{(isset($item->capacity))?$item->capacity:''}}</span>
                            <br <?php echo (!isset($is_popup))?'':'style="line-height:5px"'?> />
                            Unit price: $<span class="unit_price">{{(isset($item->unit_price))?$item->unit_price:''}}</span></td></tr>
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
            <form action="/parlour/save" method="post" class="master_form">
            {!! csrf_field() !!}
            <input type="hidden" id="order_id" name="id" value="{{(isset($order))?$order->id:""}}" />
            <input type="hidden" id="parlour_id" name="parlour_id" value="{{(isset($parlourdetails))?$parlourdetails->id:""}}" />
            <input type="hidden" id="is_order" name="is_order" value="1" />
            <table id="order_form_tbl">
                @if (!isset($is_popup))
                <tr>
                    <td style="width: 20%">Capacity </td>
                    <td style="<?php echo (!isset($is_popup))?'width: 236px':''?>"><input type="text" class="form-control" name="capacity" id="capacity" value="{{(isset($parlourdetails))?$parlourdetails->capacity:""}}" /></td>
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
                    <td><span id="parlour_selection_container">{{(isset($parlourdetails))?$parlourdetails->name:""}}</span><input type="hidden" name="parlour_name" id="parlour_name" value="{{(isset($parlourdetails))?$parlourdetails->name:""}}" /></td>
                    <td></td>
                    <td></td>
                    @if (!isset($is_popup))
                    <td>Ref No: </td>
                    <td><input type="text" style="width:150px" class="form-control" id="fa_code" name="fa_code" value="{{(isset($order) && $order->funeral_arrangement_id)?$order->funeralArrangement->generated_code:""}}"  /><input type="hidden"  id="fa_id" name="fa_id" value="{{(isset($order))?$order->funeral_arrangement_id:""}}"  /></td>
                    @endif
                </tr>
                <tr>
                    <td>Unit price </td>
                    <td><span id="unit_price_container">{{(isset($parlourdetails))?"$" . $parlourdetails->unit_price:""}}</span><input type="hidden" name="unit_price" id="unit_price" value="{{(isset($parlourdetails))?$parlourdetails->unit_price:""}}" /></td>
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
                    <td style="padding-left: 10px;">Date to: </td>
                    <td><input type="text" class="form-control" id="booked_to_day" name="booked_to_day" value="{{(isset($order) && $order->booked_to_day !="0000-00-00")? date("d/m/Y", strtotime($order->booked_to_day)):""}}" /></td>
                    @if (!isset($is_popup))
                    <td></td>
                    <td></td>
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
                    <td style="padding-left: 10px;">Time to: </td>
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
                    <td>{{(isset($order) && isset($order->creator))? $order->creator->name:$user->name}}</td>
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

<div class="modal fade" id="general_popup" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Status</h4>
            </div>

            <div class="modal-body">
                @if (!empty($save_msg))
                    {{$save_msg}}
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
@if (!empty($save_msg))
<script type="text/javascript">
$(document).ready(function(){
    $("#general_popup").modal("show");
});
</script>
@endif