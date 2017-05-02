@extends('layouts.app')

@section('content')

<script src="/js/app/jquery-ui.js"></script>
<script src="/js/app/jquery.PrintArea.js"></script>
<script>
$(document).ready(function(){
    $(".print").on('click', function() {
        
        var mode = 'iframe'; // popup
        var close = mode == "popup";
        var options = { mode : mode, popClose : close};
        $("div.printable").printArea( options );
        
    });    
});
</script>
<?php
if($session->get("checklist")!=""){
    $data = $session->get("checklist");
}
?>
<div class="page-header">
    <h3>Operations Checklist</h3>
</div>

@if(!isset($is_view))
<form action="/operations/savechecklist" method="post"  id="info_frm" enctype="multipart/form-data" class="master_form needs_exit_warning">
{!! csrf_field() !!}
<div class="section">
    <div class="messagebox">
        @if($errors->has())
            @foreach ($errors->all() as $error)
                <div class="errormsg">{{ $error }}</div>
            @endforeach
        @endif

        @if(Session::has('flash_message'))
            <div class="successmsg">
                {{ Session::get('flash_message') }}
            </div>
        @endif
    </div>
    <div class="printable">
        <div class="section_content text-right" id="order_section">
            <table width="100%">
                <tr>
                    <td width="50%">&nbsp;</td>
                    <td>Ref No:&nbsp;&nbsp;</td>
                    <td>
                        <input type="text" class="form-control" id="fa_op_code" name="fa_op_code" value="{{ $data['fa_op_code'] }}"  />
                        <input type="hidden"  id="fa_op_id" name="fa_op_id" value="{{ $data['fa_op_code'] }}"  />
                    </td>
                </tr>
            </table>
        </div>
        <div class="section_title customer_details_title" style="width: auto;">Deceased Details</div>
        <div class="section_content customer_details_content">
            <table class="operaton_form_tbl" cellpadding='10' cellspacing='10' border='0' width="100%">
                <tr>
                    <td>Title</td>
							<td>
							<select name="deceased_title" class="form-control">
							<option value=""></option>
								<option value="Mr"   
										@if ($data['deceased_title'] == "Mr")
										selected="true"
										@endif
										>Mr</option> 
								<option value="MDM"
										@if ($data['deceased_title'] == "MDM")
										selected="true"
										@endif
										>Mdm</option>
								<option value="Miss"
										@if ($data['deceased_title'] == "Miss")
										selected="true"
										@endif
										>Miss</option>
								<option value="DR"
										@if ($data['deceased_title'] == "DR")
										selected="true"
										@endif
										>Dr</option>
							</select>
							</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
				<tr>
                    <td>Deceased Name</td>
                    <td><input type="text" class="form-control" id="deceased_name" name="deceased_name" value="{{ $data['deceased_name'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                   <td class="field_container">Religion</td>
					 <td class="input_container">
						<select name="deceased_religion" class="form-control">
						 <option value=""></option>
						   @foreach($religionOptions as $religionOp)
							<option value="{{$religionOp->name}}" 
									@if ($religionOp->name == $data['deceased_religion'])
									selected="true"
									@endif
									>{{$religionOp->name}}</option>
							@endforeach
						</select>
						</td>
                    <td>&nbsp;</td>
                    <td>Church</td>
                    <td><input type="text" class="form-control" id="deceased_church" name="deceased_church" value="{{ $data['deceased_church'] }}" /></td>
                </tr>
                <tr>
                    <td>Sex</td>
                    <td><input type="text" class="form-control" id="deceased_sex" name="deceased_sex" value="{{ $data['deceased_sex'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Race</td>
                    <td><input type="text" class="form-control" id="deceased_race" name="deceased_race" value="{{ $data['deceased_race'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>Dialects</td>
                    <td><input type="text" class="form-control" id="deceased_dialects" name="deceased_dialects" value="{{ $data['deceased_dialects'] }}" /></td>
                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td><input type="text" class="form-control" id="deceased_dob" name="deceased_dob" value="{{ $data['deceased_dob'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>Date of Death</td>
                    <td><input type="text" class="form-control" id="deceased_dod" name="deceased_dod" value="{{ $data['deceased_dod'] }}" /></td>
                </tr>
                <tr>
                    <td style="height:30px;">&nbsp;</td>
                </tr>
            </table>
        </div>
        <div class="section_title customer_details_title" style="width: auto;">Shifting Details</div>
        <div class="section_content customer_details_content">
            <table id="shiftingDetails" class="operaton_form_tbl" cellpadding='10' cellspacing='10' border='0' width="100%">
                <tr>
                    <td>Home/Hospital Address</td>
                    <td colspan="4"><input type="text" class="form-control" id="shifting_hospital" name="shifting_hospital" value="{{ $data['shifting_hospital'] }}" /></td>
                </tr>
                <tr>
                    <td>Embalming</td>
                    <td><input type="text" class="form-control" id="shifting_embalming" name="shifting_embalming" value="{{ $data['shifting_embalming'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Supervisors/Bearers</td>
                    <td><input type="text" class="form-control" id="shifting_supervisor" name="shifting_supervisor" value="{{ $data['shifting_supervisor'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>O/T</td>
                    <td>
                        <select class="form-control" name="shifting_ot" data-toggle="select2">
                            <option></option>
                            <option value="1" <?=($data['shifting_ot']=="1"?"selected":"")?>>Yes</option>
                            <option value="2" <?=($data['shifting_ot']=="2"?"selected":"")?>>No</option>
                        </select> 
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Date Left</td>
                    <td><input type="text" class="form-control" id="shifting_date_left" name="shifting_date_left" value="{{ $data['shifting_date_left'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>Date Return</td>
                    <td><input type="text" class="form-control" id="shifting_date_return" name="shifting_date_return" value="{{ $data['shifting_date_return'] }}" /></td>
                </tr>
                <tr>
                    <td>Time Left</td>
                    <td>
                        <select class="form-control selectpicker"  title="" name="shifting_time_left" id="shifting_time_left">
                            <option></option>
                            <?php for ($i = 0; $i < 24; $i++):?>
                                <option value="<?php echo sprintf("%02d", $i) . ":00";?>" <?=($data['shifting_time_left']==sprintf("%02d", $i) . ":00"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":00";?></option>
                                <option value="<?php echo sprintf("%02d", $i) . ":30";?>" <?=($data['shifting_time_left']==sprintf("%02d", $i) . ":30"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":30";?></option>
                            <?php endfor?>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <td>Time Return</td>
                    <td>
                        <select class="form-control selectpicker"  title="" name="shifting_time_return" id="shifting_time_return">
                            <option></option>
                            <?php for ($i = 0; $i < 24; $i++):?>
                                <option value="<?php echo sprintf("%02d", $i) . ":00";?>" <?=($data['shifting_time_return']==sprintf("%02d", $i) . ":00"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":00";?></option>
                                <option value="<?php echo sprintf("%02d", $i) . ":30";?>" <?=($data['shifting_time_return']==sprintf("%02d", $i) . ":30"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":30";?></option>
                            <?php endfor?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Dressing: Supervisor/Bearer</td>
                    <td colspan="4"><input type="text" class="form-control" id="shifting_dressing_supervisor" name="shifting_dressing_supervisor" value="{{ $data['shifting_dressing_supervisor'] }}" /></td>
                </tr>
                <tr>
                    <td>Remarks</td>
                    <td colspan="4"><input type="text" class="form-control" id="shifting_remarks" name="shifting_remarks" value="{{ $data['shifting_remarks'] }}" /></td>
                </tr>
                <tr>
                    <td style="height:30px;">&nbsp;</td>
                </tr>
            </table>
        </div>
        <div class="section_title customer_details_title" style="width: auto;">Sending Details</div>
        <div class="section_content customer_details_content">
            <table id="sendingDetails" class="operaton_form_tbl" cellpadding='10' cellspacing='10' border='0' width="100%">
                <tr>
                    <td>SC Parlour/ Home/ Others</td>
                    <td><input type="text" class="form-control" id="sending_parlour_others" name="sending_parlour_others" value="{{ $data['sending_parlour_others'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Supervisors/Bearers</td>
                    <td>
                        @if( $usersdata )
                            <select class="form-control" name="sending_detils_users_ids[]" data-toggle="select2" multiple="">
                                <option></option>
                                @foreach( $usersdata as $usersdataVal )
                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $data['sending_detils_users_ids']))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                    </option>
                                @endforeach
                            </select> 
                        @endif
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>O/T</td>
                    <td>
                        <select class="form-control" name="sending_ot" data-toggle="select2">
                            <option></option>
                            <option value="1" <?=($data['sending_ot']=="1"?"selected":"")?>>Yes</option>
                            <option value="2" <?=($data['sending_ot']=="2"?"selected":"")?>>No</option>
                        </select> 
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Date Left</td>
                    <td><input type="text" class="form-control" id="sending_date_left" name="sending_date_left" value="{{ $data['sending_date_left'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>Date Return</td>
                    <td><input type="text" class="form-control" id="sending_date_return" name="sending_date_return" value="{{ $data['sending_date_return'] }}" /></td>
                </tr>
                <tr>
                    <td>Time Left</td>
                    <td>
                        <select class="form-control selectpicker"  title="" name="sending_time_left" id="sending_time_left">
                            <option></option>
                            <?php for ($i = 0; $i < 24; $i++):?>
                                <option value="<?php echo sprintf("%02d", $i) . ":00";?>" <?=($data['sending_time_left']==sprintf("%02d", $i) . ":00"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":00";?></option>
                                <option value="<?php echo sprintf("%02d", $i) . ":30";?>" <?=($data['sending_time_left']==sprintf("%02d", $i) . ":30"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":30";?></option>
                            <?php endfor?>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <td>Time Return</td>
                    <td>
                        <select class="form-control selectpicker"  title="" name="sending_time_return" id="sending_time_return">
                            <option></option>
                            <?php for ($i = 0; $i < 24; $i++):?>
                                <option value="<?php echo sprintf("%02d", $i) . ":00";?>" <?=($data['sending_time_return']==sprintf("%02d", $i) . ":00"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":00";?></option>
                                <option value="<?php echo sprintf("%02d", $i) . ":30";?>" <?=($data['sending_time_return']==sprintf("%02d", $i) . ":30"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":30";?></option>
                            <?php endfor?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Wait For</td>
                    <td>
                        <select class="form-control" name="shifting_waitfor" data-toggle="select2">
                            <option value=""></option>
                            <option value="1" <?=($data['shifting_waitfor']=="1"?"selected":"")?>>Family</option>
                            <option value="2" <?=($data['shifting_waitfor']=="2"?"selected":"")?>>Ready Send In</option>
                            <option value="3" <?=($data['shifting_waitfor']=="3"?"selected":"")?>>SCC Monk</option>
                            <option value="4" <?=($data['shifting_waitfor']=="4"?"selected":"")?>>Own Monk</option>
                        </select> 
                    </td>
                    <td>
                        <select class="form-control" name="shifting_backdrop" data-toggle="select2">
                            <option value=""></option>
                            <option value="1" <?=($data['shifting_backdrop']=="1"?"selected":"")?>>2 Pcs Yellow BackDrop</option>
                            <option value="2" <?=($data['shifting_backdrop']=="2"?"selected":"")?>>3 Pcs Yellow BackDrop</option>
                            <option value="3" <?=($data['shifting_backdrop']=="3"?"selected":"")?>>4 Pcs Yellow BackDrop</option>
                            <option value="4" <?=($data['shifting_backdrop']=="4"?"selected":"")?>>9 Pcs Yellow BackDrop</option>
                        </select> 
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Time</td>
                    <td>
                        <select class="form-control selectpicker"  title="" name="sending_time" id="sending_time">
                            <option></option>
                            <?php for ($i = 0; $i < 24; $i++):?>
                                <option value="<?php echo sprintf("%02d", $i) . ":00";?>" <?=($data['sending_time']==sprintf("%02d", $i) . ":00"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":00";?></option>
                                <option value="<?php echo sprintf("%02d", $i) . ":30";?>" <?=($data['sending_time']==sprintf("%02d", $i) . ":30"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":30";?></option>
                            <?php endfor?>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Informed At</td>
                    <td><input type="text" class="form-control onlytimepicker" id="sending_informed_at" name="sending_informed_at" value="{{ $data['sending_informed_at'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>Be there at</td>
                    <td><input type="text" class="form-control onlytimepicker" id="sending_bethere_at" name="sending_bethere_at" value="{{ $data['sending_bethere_at'] }}" /></td>
                </tr>
                <tr>
                    <td style="height:30px;">&nbsp;</td>
                </tr>
            </table>
        </div>
        <div class="section_title customer_details_title" style="width: auto;">Quantity of Items</div>
        <div class="section_content customer_details_content">
            <table class="table table-striped table-bordered table-hover" cellpadding='10' cellspacing='10' border='0' width="100%">
                <tr>
                    <td>Photo Enlargement</td>
                    <td><input type="text" class="form-control" id="photo_enlargement" name="photo_enlargement" value="{{ $data['photo_enlargement'] }}" /></td>
                    <td>Cross Wreath</td>
                    <td><input type="text" class="form-control" id="cross_wreath" name="cross_wreath" value="{{ $data['cross_wreath'] }}" /></td>
                    <td colspan="2">Others</td>
                    <td><input type="text" class="form-control" id="others_option" name="others_option" value="{{ $data['others_option'] }}" /></td>
                </tr>
                <tr>
                    <td>Photo Wreath</td>
                    <td><input type="text" class="form-control" id="photo_wreath" name="photo_wreath" value="{{ $data['photo_wreath'] }}" /></td>
                    <td>Table Wreath</td>
                    <td><input type="text" class="form-control" id="table_wreath" name="table_wreath" value="{{ $data['table_wreath'] }}" /></td>
                    <td>Special Notice Flower</td>
                    <td style="width:80px">&nbsp;</td>
                    <td><input type="text" class="form-control" id="special_notice_flower" name="special_notice_flower" value="{{ $data['special_notice_flower'] }}" /></td>
                </tr>
                <tr>
                    <td>Passport Photo</td>
                    <td><input type="text" class="form-control" id="passport_photo" name="passport_photo" value="{{ $data['passport_photo'] }}" /></td>
                    <td>No of Boxes</td>
                    <td><input type="text" class="form-control" id="number_of_boxes" name="number_of_boxes" value="{{ $data['number_of_boxes'] }}" /></td>
                    <td>Candle Set Flower</td>
                    <td>&nbsp;</td>
                    <td><input type="text" class="form-control" id="candle_set_flower" name="candle_set_flower" value="{{ $data['candle_set_flower'] }}" /></td>
                </tr>
            </table>
        </div>

        <div class="section_content customer_details_content">
            <table class="table table-striped table-bordered table-hover" cellpadding='10' cellspacing='10' border='0' width="100%">
                <thead>
                    <tr>
                        <th>Roman Catholic</th>
                        <th>Taken</th>
                        <th>Return</th>
                        <th>Protestant</th>
                        <th>Taken</th>
                        <th>Return</th>
                        <th>Buddhist</th>
                        <th>Taoist</th>
                        <th>Soka</th>
                        <th>FT</th>
                        <th>Taken</th>
                        <th>Return</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Crucifix</td>
                        <td><input type="text" class="form-control" id="crucifix_taken" name="crucifix_taken" value="{{ $data['crucifix_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="crucifix_return" name="crucifix_return" value="{{ $data['crucifix_return'] }}" /></td>
                        <td>Cross stand-1Pc</td>
                        <td><input type="text" class="form-control" id="cross_stand_taken" name="cross_stand_taken" value="{{ $data['cross_stand_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="cross_stand_return" name="cross_stand_return" value="{{ $data['cross_stand_return'] }}" /></td>
                        <td colspan="4">Coffin Stand- 2Pcs</td>
                        <td><input type="text" class="form-control" id="coffin_stand_taken" name="coffin_stand_taken" value="{{ $data['coffin_stand_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="coffin_stand_return" name="coffin_stand_return" value="{{ $data['coffin_stand_return'] }}" /></td>
                    </tr>
                    <tr>
                        <td>Coffin Stand- 2Pcs</td>
                        <td><input type="text" class="form-control" id="coffin_stand2_taken" name="coffin_stand2_taken" value="{{ $data['coffin_stand2_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="coffin_stand2_return" name="coffin_stand2_return" value="{{ $data['coffin_stand2_return'] }}" /></td>
                        <td>Coffin Stand- 2Pcs</td>
                        <td><input type="text" class="form-control" id="coffin_stand3_taken" name="coffin_stand3_taken" value="{{ $data['coffin_stand3_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="coffin_stand3_return" name="coffin_stand3_return" value="{{ $data['coffin_stand3_return'] }}" /></td>
                        <td colspan="4">Stand Cover- 2Pcs</td>
                        <td><input type="text" class="form-control" id="stand_cover_taken" name="stand_cover_taken" value="{{ $data['stand_cover_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="stand_cover_return" name="stand_cover_return" value="{{ $data['stand_cover_return'] }}" /></td>
                    </tr>
                    <tr>
                        <td>Stand Cover- 2Pcs</td>
                        <td><input type="text" class="form-control" id="stand_cover2_taken" name="stand_cover2_taken" value="{{ $data['stand_cover2_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="stand_cover2_return" name="stand_cover2_return" value="{{ $data['stand_cover2_return'] }}" /></td>
                        <td>Stand Cover- 2Pcs</td>
                        <td><input type="text" class="form-control" id="stand_cover3_taken" name="stand_cover3_taken" value="{{ $data['stand_cover3_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="stand_cover3_return" name="stand_cover3_return" value="{{ $data['stand_cover3_return'] }}" /></td>
                        <td colspan="4">2Pcs/4 Pcs Back Drop</td>
                        <td><input type="text" class="form-control" id="backdrop_taken" name="backdrop_taken" value="{{ $data['backdrop_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="backdrop_return" name="backdrop_return" value="{{ $data['backdrop_return'] }}" /></td>
                    </tr>
                    <tr>
                        <td>Backdrop- 1 Pcs (Jesus)</td>
                        <td><input type="text" class="form-control" id="backdrop1_taken" name="backdrop1_taken" value="{{ $data['backdrop1_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="backdrop1_return" name="backdrop1_return" value="{{ $data['backdrop1_return'] }}" /></td>
                        <td>Backdrop- 1 Pc</td>
                        <td><input type="text" class="form-control" id="backdrop2_taken" name="backdrop2_taken" value="{{ $data['backdrop2_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="backdrop2_return" name="backdrop2_return" value="{{ $data['backdrop2_return'] }}" /></td>
                        <td colspan="4">Back Drop Stand- 2 Pcs</td>
                        <td><input type="text" class="form-control" id="backdrop_stand_taken" name="backdrop_stand_taken" value="{{ $data['backdrop_stand_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="backdrop_stand_return" name="backdrop_stand_return" value="{{ $data['backdrop_stand_return'] }}" /></td>
                    </tr>
                    <tr>
                        <td>Backdrop stand- 2 Pcs</td>
                        <td><input type="text" class="form-control" id="backdrop_stand1_taken" name="backdrop_stand1_taken" value="{{ $data['backdrop_stand1_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="backdrop_stand1_return" name="backdrop_stand1_return" value="{{ $data['backdrop_stand1_return'] }}" /></td>
                        <td>Backdrop stand- 2 Pcs</td>
                        <td><input type="text" class="form-control" id="backdrop_stand2_taken" name="backdrop_stand2_taken" value="{{ $data['backdrop_stand2_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="backdrop_stand2_return" name="backdrop_stand2_return" value="{{ $data['backdrop_stand2_return'] }}" /></td>
                        <td colspan="4">Photo Stand- 1 Pc</td>
                        <td><input type="text" class="form-control" id="photo_stand_taken" name="photo_stand_taken" value="{{ $data['photo_stand_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="photo_stand_return" name="photo_stand_return" value="{{ $data['photo_stand_return'] }}" /></td>
                    </tr>
                    <tr>
                        <td>Photo Stand- 1 Pc</td>
                        <td><input type="text" class="form-control" id="photo_stand1_taken" name="photo_stand1_taken" value="{{ $data['photo_stand1_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="photo_stand1_return" name="photo_stand1_return" value="{{ $data['photo_stand1_return'] }}" /></td>
                        <td>Photo Stand- 1 Pc</td>
                        <td><input type="text" class="form-control" id="photo_stand2_taken" name="photo_stand2_taken" value="{{ $data['photo_stand2_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="photo_stand2_return" name="photo_stand2_return" value="{{ $data['photo_stand2_return'] }}" /></td>
                        <td colspan="4">Table Cloth- 1 Pc</td>
                        <td><input type="text" class="form-control" id="table_cloth_taken" name="table_cloth_taken" value="{{ $data['table_cloth_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="table_cloth_return" name="table_cloth_return" value="{{ $data['table_cloth_return'] }}" /></td>
                    </tr>
                    <tr>
                        <td>Table Cloth- 1Pc- W</td>
                        <td><input type="text" class="form-control" id="table_cloth1_taken" name="table_cloth1_taken" value="{{ $data['table_cloth1_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="table_cloth1_return" name="table_cloth1_return" value="{{ $data['table_cloth1_return'] }}" /></td>
                        <td>Table Cloth- 1Pc- W</td>
                        <td><input type="text" class="form-control" id="table_cloth2_taken" name="table_cloth2_taken" value="{{ $data['table_cloth2_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="table_cloth2_return" name="table_cloth2_return" value="{{ $data['table_cloth2_return'] }}" /></td>
                        <td colspan="4">Buddhist: Table Cloth</td>
                        <td><input type="text" class="form-control" id="buddhist_table_cloth_taken" name="buddhist_table_cloth_taken" value="{{ $data['buddhist_table_cloth_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="buddhist_table_cloth_return" name="buddhist_table_cloth_return" value="{{ $data['buddhist_table_cloth_return'] }}" /></td>
                    </tr>
                    <tr>
                        <td>Carpet- 1Pc</td>
                        <td><input type="text" class="form-control" id="carpet_taken" name="carpet_taken" value="{{ $data['carpet_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="carpet_return" name="carpet_return" value="{{ $data['carpet_return'] }}" /></td>
                        <td>Carpet- 1Pc</td>
                        <td><input type="text" class="form-control" id="carpet1_taken" name="carpet1_taken" value="{{ $data['carpet1_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="carpet1_return" name="carpet1_return" value="{{ $data['carpet1_return'] }}" /></td>
                        <td colspan="4">Zinc- 1</td>
                        <td><input type="text" class="form-control" id="zinc_taken" name="zinc_taken" value="{{ $data['zinc_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="zinc_return" name="zinc_return" value="{{ $data['zinc_return'] }}" /></td>
                    </tr>
                    <tr>
                        <td>Candles</td>
                        <td><input type="text" class="form-control" id="candles_taken" name="candles_taken" value="{{ $data['candles_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="candles_return" name="candles_return" value="{{ $data['candles_return'] }}" /></td>
                        <td>Candles</td>
                        <td><input type="text" class="form-control" id="candles1_taken" name="candles1_taken" value="{{ $data['candles1_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="candles1_return" name="candles1_return" value="{{ $data['candles1_return'] }}" /></td>
                        <td colspan="4">Candles- White/Red</td>
                        <td><input type="text" class="form-control" id="candles_white_taken" name="candles_white_taken" value="{{ $data['candles_white_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="candles_white_return" name="candles_white_return" value="{{ $data['candles_white_return'] }}" /></td>
                    </tr>
                    <tr>
                        <td>Holy Water- 1 Bottle</td>
                        <td><input type="text" class="form-control" id="holy_water_bottle_taken" name="holy_water_bottle_taken" value="{{ $data['holy_water_bottle_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="holy_water_bottle_return" name="holy_water_bottle_return" value="{{ $data['holy_water_bottle_return'] }}" /></td>
                        <td>Special Notice Stand</td>
                        <td><input type="text" class="form-control" id="special_notice_stand_taken" name="special_notice_stand_taken" value="{{ $data['special_notice_stand_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="special_notice_stand_return" name="special_notice_stand_return" value="{{ $data['special_notice_stand_return'] }}" /></td>
                        <td colspan="4">Special Notice Stand</td>
                        <td><input type="text" class="form-control" id="special_notice_stand1_taken" name="special_notice_stand1_taken" value="{{ $data['special_notice_stand1_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="special_notice_stand1_return" name="special_notice_stand1_return" value="{{ $data['special_notice_stand1_return'] }}" /></td>
                    </tr>
                    <tr>
                        <td>Prayer Books- 10 Bkts</td>
                        <td><input type="text" class="form-control" id="prayer_books_taken" name="prayer_books_taken" value="{{ $data['prayer_books_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="prayer_books_return" name="prayer_books_return" value="{{ $data['prayer_books_return'] }}" /></td>
                        <td>Contribution Book</td>
                        <td><input type="text" class="form-control" id="contribution_book_taken" name="contribution_book_taken" value="{{ $data['contribution_book_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="contribution_book_return" name="contribution_book_return" value="{{ $data['contribution_book_return'] }}" /></td>
                        <td colspan="4">Contribution Book</td>
                        <td><input type="text" class="form-control" id="contribution_book1_taken" name="contribution_book1_taken" value="{{ $data['contribution_book1_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="contribution_book1_return" name="contribution_book1_return" value="{{ $data['contribution_book1_return'] }}" /></td>
                    </tr>
                    <tr>
                        <td>Special Notice Stand</td>
                        <td><input type="text" class="form-control" id="special_notice_taken" name="special_notice_taken" value="{{ $data['special_notice_taken'] }}" /></td>
                        <td><input type="text" class="form-control" id="special_notice_return" name="special_notice_return" value="{{ $data['special_notice_return'] }}" /></td>
                        <td colspan="9">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="2">Check Vehicles & Hearse:</td>
                        <td colspan="9"><input type="text" class="form-control" id="check_vehicles_hearse" name="check_vehicles_hearse" value="{{ $data['check_vehicles_hearse'] }}" /></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section_title customer_details_title" style="width: auto;">Funeral Information</div>
        <div class="section_content customer_details_content">
            <table class="operaton_form_tbl" cellpadding='10' cellspacing='10' border='0' width="100%">
                <tr>
                    <td>Funeral Date</td>
                    <td><input type="text" class="form-control" id="funeral_date" name="funeral_date" value="{{ $data['funeral_date'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Customer</td>
                    <td><input type="text" class="form-control" id="funeral_customer" name="funeral_customer" value="{{ $data['funeral_customer'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Time: Leaving SC</td>
                    <td>
                        <select class="form-control selectpicker"  title="" name="funeral_leaving_sc" id="funeral_leaving_sc">
                            <option></option>
                            <?php for ($i = 0; $i < 24; $i++):?>
                                <option value="<?php echo sprintf("%02d", $i) . ":00";?>" <?=($data['funeral_leaving_sc']==sprintf("%02d", $i) . ":00"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":00";?></option>
                                <option value="<?php echo sprintf("%02d", $i) . ":30";?>" <?=($data['funeral_leaving_sc']==sprintf("%02d", $i) . ":30"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":30";?></option>
                            <?php endfor?>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Time: Leaving Parlour/Home</td>
                    <td>
                        <select class="form-control selectpicker"  title="" name="funeral_leaving_parlour" id="funeral_leaving_parlour">
                            <option></option>
                            <?php for ($i = 0; $i < 24; $i++):?>
                                <option value="<?php echo sprintf("%02d", $i) . ":00";?>" <?=($data['funeral_leaving_parlour']==sprintf("%02d", $i) . ":00"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":00";?></option>
                                <option value="<?php echo sprintf("%02d", $i) . ":30";?>" <?=($data['funeral_leaving_parlour']==sprintf("%02d", $i) . ":30"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":30";?></option>
                            <?php endfor?>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Church Service</td>
                    <td><input type="text" class="form-control onlytimepicker" id="funeral_church" name="funeral_church" value="{{ $data['funeral_church'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Time</td>
                    <td>
                        <select class="form-control selectpicker"  title="" name="funeral_time1" id="funeral_time1">
                            <option></option>
                            <?php for ($i = 0; $i < 24; $i++):?>
                                <option value="<?php echo sprintf("%02d", $i) . ":00";?>" <?=($data['funeral_time1']==sprintf("%02d", $i) . ":00"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":00";?></option>
                                <option value="<?php echo sprintf("%02d", $i) . ":30";?>" <?=($data['funeral_time1']==sprintf("%02d", $i) . ":30"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":30";?></option>
                            <?php endfor?>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>To:</td>
                    <td>
                        <select class="form-control" name="funeral_to" data-toggle="select2">
                            <option value="1" <?=($data['funeral_to']=="1"?"selected":"")?>>MCC</option>
                            <option value="2" <?=($data['funeral_to']=="2"?"selected":"")?>>KMS</option>
                            <option value="3" <?=($data['funeral_to']=="3"?"selected":"")?>>TTA</option>
                            <option value="4" <?=($data['funeral_to']=="4"?"selected":"")?>>CCK</option>
                        </select> 
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Time</td>
                    <td>
                        <select class="form-control selectpicker"  title="" name="funeral_time2" id="funeral_time2">
                            <option></option>
                            <?php for ($i = 0; $i < 24; $i++):?>
                                <option value="<?php echo sprintf("%02d", $i) . ":00";?>" <?=($data['funeral_time2']==sprintf("%02d", $i) . ":00"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":00";?></option>
                                <option value="<?php echo sprintf("%02d", $i) . ":30";?>" <?=($data['funeral_time2']==sprintf("%02d", $i) . ":30"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":30";?></option>
                            <?php endfor?>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Bus:</td>
                    <td><input type="text" class="form-control" id="funeral_bus" name="funeral_bus" value="{{ $data['funeral_bus'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Flowers</td>
                    <td><input type="text" class="form-control" id="funeral_flowers" name="funeral_flowers" value="{{ $data['funeral_flowers'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Supervisor/Bearers</td>
                    <td>
                        @if( $usersdata )
                            <select class="form-control" name="funeral_information_users_ids[]" data-toggle="select2" multiple="">
                                @foreach( $usersdata as $usersdataVal )
                                    <option value="{{ $usersdataVal->id }}"
                                                            @if (in_array($usersdataVal->id, $data['funeral_information_users_ids']))
                                                            selected="selected"
                                                            @endif
                                                    >{{ $usersdataVal->name }}
                                    </option>
                                @endforeach
                            </select> 
                        @endif
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Hearse/Van</td>
                    <td><input type="text" class="form-control" id="funeral_hearsevan" name="funeral_hearsevan" value="{{ $data['funeral_hearsevan'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Ashes Collection:SC/OA/Others</td>
                    <td><input type="text" class="form-control" id="funeral_ashes" name="funeral_ashes" value="{{ $data['funeral_ashes'] }}" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Time</td>
                    <td>
                        <select class="form-control selectpicker"  title="" name="funeral_time3" id="funeral_time3">
                            <option></option>
                            <?php for ($i = 0; $i < 24; $i++):?>
                                <option value="<?php echo sprintf("%02d", $i) . ":00";?>" <?=($data['funeral_time3']==sprintf("%02d", $i) . ":00"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":00";?></option>
                                <option value="<?php echo sprintf("%02d", $i) . ":30";?>" <?=($data['funeral_time3']==sprintf("%02d", $i) . ":30"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":30";?></option>
                            <?php endfor?>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Date/Time Left</td>
                    <td><input type="text" class="form-control onlytimepicker" id="funeral_date_time_left" name="funeral_date_time_left" value="{{ $data['funeral_date_time_left'] }}" /></td>
                    <td>Date/Time Return</td>
                    <td><input type="text" class="form-control onlytimepicker" id="funeral_date_time_return" name="funeral_date_time_return" value="{{ $data['funeral_date_time_return'] }}" /></td>
                    <td>O/T</td>
                    <td>
                        <select class="form-control" name="funeral_ot" data-toggle="select2">
                            <option value="1" <?=($data['funeral_ot']=="1"?"selected":"")?>>Yes</option>
                            <option value="2" <?=($data['funeral_ot']=="2"?"selected":"")?>>No</option>
                        </select> 
                    </td>
                    <td>Time</td>
                    <td>
                        <select class="form-control selectpicker"  title="" name="funeral_time4" id="funeral_time4">
                            <option></option>
                            <?php for ($i = 0; $i < 24; $i++):?>
                                <option value="<?php echo sprintf("%02d", $i) . ":00";?>" <?=($data['funeral_time4']==sprintf("%02d", $i) . ":00"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":00";?></option>
                                <option value="<?php echo sprintf("%02d", $i) . ":30";?>" <?=($data['funeral_time4']==sprintf("%02d", $i) . ":30"?"selected":"")?>><?php echo sprintf("%02d", $i) . ":30";?></option>
                            <?php endfor?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Remarks</td>
                    <td colspan="7"><input type="text" class="form-control" id="funeral_remarks" name="funeral_remarks" value="{{ $data['funeral_remarks'] }}" /></td>
                </tr>
                <tr>
                    <td>Funeral Co-ordinated/Spoken to</td>
                    <td colspan="7"><input type="text" class="form-control" id="funeral_spokento" name="funeral_spokento" value="{{ $data['funeral_spokento'] }}" /></td>
                </tr>
                <tr>
                    <td style="height:30px;">&nbsp;</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="section_content customer_details_content">
        <table class="operaton_form_tbl" cellpadding='10' cellspacing='10' border='0' width="100%">
            <tr>
                <td width="35%"></td>
                <td class="text-center"><input class="btn btn-blue-500" type="submit" name="save_button" value="Save" /></td>
                <td class="text-center"><input class="btn btn-blue-500 print" type="button" name="createpdf_button" value="Create PDF" id="click_to_print" /></td>
                <td width="35%"></td>
                <!-- td class="text-center"><input class="btn btn-blue-500 print" type="button" name="createpdf_button" value="Create PDF" id="click_to_print" /></td -->
            </tr>
        </table>
    </div>
</div>
</form>
@endif;
@endsection


@push('css')
    <link href="/css/app/hearse.css" rel="stylesheet">
    <style>
    .operaton_form_tbl td {
        padding: 3px;
    }
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding: 3px !important;
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
     <script src="/js/app/operations.js"></script>
    <script src="/js/app/general_form.js"></script>   
    
@endpush