@extends('layouts.app')

@section('content')

<?php if ($session->get("co_msg")):?>
<script type="text/javascript">
    var saveMessage = '<?php echo implode("<br />",$session->get("co_msg"))?>';
    var openPdf = <?php echo ($session->get("co_open_pdf") == 1)? "true" : "false"?>;
</script>
<?php $session->set("co_msg", null); $session->set("co_open_pdf", null);?>
<?php endif; ?>

<form action="/columbarium/save"  id="info_frm" method="post" enctype="multipart/form-data" class="master_form needs_exit_warning">
    {!! csrf_field() !!}
    
    <input type="hidden"  id="form_id" name="id" value="{{$order->id}}"  />
    <input type="hidden"  id="is_draft" value="{{$order->is_draft}}"  />
<div class="section">

    <div class="section_content" id="order_section">
        <table style="width:80%">
            <tr>
                <td>Date:</td>
                <td>{{ ($order->created_at)?date("d-m-Y H:i:s",strtotime($order->created_at)):date("d-m-Y H:i:s")}}<input type="hidden" class="form-control" name="created_at" value="{{ ($order->created_at)?date("d-m-Y H:i:s",strtotime($order->created_at)):date("d-m-Y H:i:s")}}" /></td>
            </tr>
            <tr>
                <td>Ref / SC no:</td>
                <td><input type="text" class="form-control" id="fa_code" name="fa_code" value="{{ ($order->funeral_arrangement_id)?$order->funeralArrangement->generated_code:"" }}"  /><input type="hidden"  id="fa_id" name="fa_id" value="{{($order->funeral_arrangement_id)?$order->funeral_arrangement_id:""}}"  /></td>
            </tr>
            <tr>
                <td>Columbarium Order No:</td>
                <td><input type="text" class="form-control" name="order_nr" value="{{($order->order_nr)?$order->order_nr:''}}" /></td>
            </tr>
        </table>
    </div>
    
    <div class="section_title">Deceased details</div>
    <div class="section_content">
        <table class="form_content" style="width:80%">
            <tbody>
                <tr>
                        <td class="field_container">Title</td>
                            <td class="input_container">
                                <select name="deceased_title" style="width:200px;" class="form-control">
									<option value="">Select</option>
                                    <option value="Mr"   
                                            @if ($order->deceased_title == "Mr")
                                            selected="true"
                                            @endif
                                            >Mr</option> 
									<option value="MDM"
                                            @if ($order->deceased_title == "MDM")
                                            selected="true"
                                            @endif
                                            >MDM</option>
									<option value="Miss"
                                            @if ($order->deceased_title == "Miss")
                                            selected="true"
                                            @endif
                                            >Miss</option>
									<option value="DR"
                                            @if ($order->deceased_title == "DR")
                                            selected="true"
                                            @endif
                                            >DR</option>
                                </select>
                            </td>
						</tr>
				<tr><td class="field_container">Deceased Name</td><td colspan="5" class="input_container"><input type="text" name="deceased_name"  id="deceased_name" class="form-control" value="{{$order->deceased_name}}" style="width:200px;"  /></tr>
                <tr><td class="field_container">Religion</td>
                    <td class="input_container">
                        <select name="religion"  style="width:200px;" class="form-control">
                            @foreach($religionOptions as $religionOp)
                            <option value="{{$religionOp->id}}"
                                            @if (($order->religion) && $religionOp->id == $order->religion)
                                            selected="true"
                                            @endif
                                    >{{$religionOp->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td style="width:5%"></td>
                    <td class="field_container" style="width:20%;">Church</td>
                    <td colspan="2" class="input_container"><input type="text" name="church"  class="form-control" id="church" value="{{$order->church}}" style="width:200px;" /></td>
                </tr>
                <tr>
                    <td class="field_container">Sex</td>
                    <td class="input_container">
                        <select name="sex"  style="width:200px;" class="form-control">
                            <option value="male" <?php echo (!empty($order->sex) && $order->sex == "male")?'selected="true"':'';?>>Male</option>
                            <option value="female" <?php echo (!empty($order->sex) && $order->sex == "female")?'selected="true"':'';?>>Female</option>
                        </select>
                    </td>
                    <td colspan="4" class="input_container"></td>
                </tr>
                <tr>
                    <td class="field_container">Race</td>
                    <td class="input_container">
                        <select name="race"  style="width:200px;" class="form-control">
                            @foreach($raceOptions as $raceOp)
                            <option value="{{$raceOp->id}}" 
                                            @if (($order->race) && $raceOp->id == $order->race)
                                            selected="true"
                                            @endif
                                    >{{$raceOp->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td></td>
                    <td class="field_container">Dialects</td>
                    <td class="input_container">
                        <input type="text" id="dialect" name="dialect"  class="form-control" value="{{$order->dialect}}" style="width:200px;" />
                    </td>
                </tr>
                <tr>
                    <td class="field_container">Date of Birth</td>
                    <td class="input_container">
                        <input type="text" id="birthdate" name="birthdate" class="datepicker_fa form-control" value="{{$order->birthdate}}" style="width:200px;"  />
                    </td>
                    <td></td>
                    <td class="field_container">Date of Death</td>
                    <td class="input_container">
                        <input type="text" id="deathdate" name="deathdate" class="datepicker_fa form-control" value="{{$order->deathdate}}" style="width:200px;" />
                    </td>
                </tr>
                <tr><td colspan="6" style="height: 30px"></td></tr>
                <tr>
                    <td class="field_container">Funeral Date</td>
                    <td class="input_container">
                        <input type="text" id="funeral_date" name="funeral_date" class="datepicker_fa form-control" value="{{$order->funeral_date}}" style="width:200px;"  />
                    </td>
                    <td></td>
                    <td class="field_container">Type of install</td>
                    <td class="input_container">
                        <input type="text" id="type_of_install" name="type_of_install" class="form-control" value="{{$order->type_of_install}}" style="width:200px;" />
                    </td>
                </tr>
                <tr>
                    <td class="field_container">Final Resting Place</td>
                    <td class="input_container">
                        <input type="text" id="final_resting_place" name="final_resting_place" class="form-control" value="{{$order->final_resting_place}}" style="width:200px;"  />
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="field_container">Niche Type</td>
                    <td class="input_container">
                        <select  id="niche_type" name="niche_type"  style="width:200px;" class="form-control">
                            <option value="single" <?php echo (!empty($order->niche_type) && $order->niche_type == "single")?'selected="true"':'';?>>Single</option>
                            <option value="double" <?php echo (!empty($order->niche_type) && $order->niche_type == "double")?'selected="true"':'';?>>Double</option>
                        </select>
                    </td>
                    <td></td>
                    <td class="field_container">Niche Location</td>
                    <td class="input_container">
                        <input type="text" id="niche_location" name="niche_location" class="form-control" value="{{$order->niche_location}}" style="width:200px;" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    
    <div class="section_title">Customer Details</div>
    <div class="section_content">
        <table style="width:80%">
            <tr>
                <td style="width: 20% "><em>Point of Contact 1</em></td>
                <td></td>
                <td style="width:5%"></td>
                <td><em>Point of Contact 2</em></td>
                <td></td>
            </tr>
            <tr>
                <td>NRIC No:</td>
                <td><input type="text" class="form-control" id="first_cp_nric" name="first_cp_nric"  value="{{$order->first_cp_nric}}" /></td>
                <td></td>
                <td>NRIC No:</td>
                <td><input type="text" class="form-control" id="second_cp_nric" name="second_cp_nric" value="{{$order->second_cp_nric}}" /></td>
            </tr>
            <tr>
                <td>Title</td>
                <td>
				<select name="first_cp_title" class="form-control">
				<option value="">Select</option>
					<option value="Mr"   
							@if ($order->first_cp_title == "Mr")
							selected="true"
							@endif
							>Mr</option> 
					<option value="MDM"
							@if ($order->first_cp_title == "MDM")
							selected="true"
							@endif
							>MDM</option>
					<option value="Miss"
							@if ($order->first_cp_title == "Miss")
							selected="true"
							@endif
							>Miss</option>
					<option value="DR"
							@if ($order->first_cp_title == "DR")
							selected="true"
							@endif
							>DR</option>
				</select>
                </td>
				<td></td>
				<td>Title</td>
				<td>
				<select name="second_cp_title" class="form-control">
				<option value="">Select</option>
					<option value="Mr"   
							@if ($order->second_cp_title == "Mr")
							selected="true"
							@endif
							>Mr</option> 
					<option value="MDM"
							@if ($order->second_cp_title == "MDM")
							selected="true"
							@endif
							>MDM</option>
					<option value="Miss"
							@if ($order->second_cp_title == "Miss")
							selected="true"
							@endif
							>Miss</option>
					<option value="DR"
							@if ($order->second_cp_title == "DR")
							selected="true"
							@endif
							>DR</option>
				</select>
			</td>
			</tr>
			<tr>
				<td>Name:</td>
                <td><input type="text" class="form-control" id="first_cp_name" name="first_cp_name" value="{{$order->first_cp_name}}" /></td>
				<td></td>
				<td>Name:</td>
                <td><input type="text" class="form-control" id="second_cp_name" name="second_cp_name" value="{{$order->second_cp_name}}" /></td>
            </tr>
			<tr>
                 <td class="field_container">Religion</td>
				 <td class="input_container">
					<select name="first_cp_religion" class="form-control">
					 <option value="">Select</option>
					   @foreach($religionOptions as $religionOp)
						<option value="{{$religionOp->name}}" 
								@if ($religionOp->name == $order->first_cp_religion)
								selected="true"
								@endif
								>{{$religionOp->name}}</option>
						@endforeach
					</select>
				</td>
				<td></td>
				<td class="field_container">Religion</td>
				 <td class="input_container">
					<select name="second_cp_religion" class="form-control">
					 <option value="">Select</option>
					   @foreach($religionOptions as $religionOp)
						<option value="{{$religionOp->name}}" 
								@if ($religionOp->name == $order->second_cp_religion)
								selected="true"
								@endif
								>{{$religionOp->name}}</option>
						@endforeach
					</select>
				</td>
			</tr>
            <tr>
                <td>Address:</td>
                <td><input type="text" class="form-control" id="first_cp_address" name="first_cp_address" value="{{$order->first_cp_address}}" /></td>
                <td></td>
                <td>Address:</td>
                <td><input type="text" class="form-control" id="second_cp_address" name="second_cp_address" value="{{$order->second_cp_address}}" /></td>
            </tr>
            <tr>
                <td>Mobile number:</td>
                <td><input type="text" class="form-control" id="first_cp_mobile" name="first_cp_mobile" value="{{$order->first_cp_mobile}}" /></td>
                <td></td>
                <td>Mobile number:</td>
                <td><input type="text" class="form-control" id="second_cp_mobile" name="second_cp_mobile" value="{{$order->second_cp_mobile}}" /></td>
            </tr>
            <tr>
                <td>Attach file(s)</td>
                <td style="padding-top: 20px;"><input type="file" name='files[]' multiple="multiple" /></td>
                <td colspan="3"></td>
            </tr>
        </table>
    </div> 
        
    <div class="section_title">Inscription Details</div>
    <div class="section_content ">
        <table class="bordered_table" id="order_items_tbl" style="width:96%">
            <tr>
                <th style="width: 25%">&nbsp;</th>
                <th style="width: 20%">SELECTION</th>
                <th style="width: 40%">COMMENTS</th>
                <th>Amount</th>
            </tr>
            <tr class="active_rows">
                <td>Columbarium Charges: (Click to view slab selection)</td>
                <td>
                    <input type="text"  class="form-control"  name="selection[]"  value="{{ (isset($item_selection["selection"][0]))?$item_selection["selection"][0]:"" }}" />
                </td>
                <td><input type="text" class="form-control" name="comments[]" value="{{ (isset($item_selection["comments"][0]))?$item_selection["comments"][0]:"" }}"  /></td>
                <td><span class="amount_view"></span><input type="text" class="form-control"  name="amount[]" value="{{ (isset($item_selection["amount"][0]))?$item_selection["amount"][0]:"" }}"  /></td>
            </tr>
            <tr class="active_rows">
                <td>Wording Colour:</td>
                <td>
                    <select class="form-control"  name="selection[]">
                        <option valu=""></option>
                        <option valu="Black" <?php echo (isset($item_selection["selection"][1]) && $item_selection["selection"][1] == "Black")?'selected="true"':'';?>>Black</option>
                        <option valu="Gold" <?php echo (isset($item_selection["selection"][1]) && $item_selection["selection"][1] == "Gold")?'selected="true"':'';?>>Gold</option>
                        <option valu="Blue" <?php echo (isset($item_selection["selection"][1]) && $item_selection["selection"][1] == "Blue")?'selected="true"':'';?>>Blue</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="comments[]"  value="{{ (isset($item_selection["comments"][1]))?$item_selection["comments"][1]:"" }}" /></td>
                <td><span class="amount_view"></span><input type="text" class="form-control"  name="amount[]" value="{{ (isset($item_selection["amount"][1]))?$item_selection["amount"][1]:"" }}"/></td>
            </tr>
            <tr class="active_rows">
                <td>Porcelain Photo Size</td>
                <td>
                    <select class="form-control"  name="selection[]">
                        <option valu=""></option>
                        <option valu="6cm x 8cm" <?php echo (isset($item_selection["selection"][2]) && $item_selection["selection"][2] == "6cm x 8cm")?'selected="true"':'';?>>6cm x 8cm</option>
                        <option valu="other" <?php echo (isset($item_selection["selection"][2]) && $item_selection["selection"][2] == "other")?'selected="true"':'';?>>other</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="comments[]"  value="{{ (isset($item_selection["comments"][2]))?$item_selection["comments"][2]:"" }}" /></td>
                <td><span class="amount_view"></span><input type="text" class="form-control"  name="amount[]" value="{{ (isset($item_selection["amount"][2]))?$item_selection["amount"][2]:"" }}"/></td>
            </tr>
            <tr class="active_rows">
                <td>Porcelain Photo Design</td>
                <td>
                    <select class="form-control"  name="selection[]">
                        <option valu=""></option>
                        <option valu="Thin Border" <?php echo (isset($item_selection["selection"][3]) && $item_selection["selection"][3] == "Thin Border")?'selected="true"':'';?>>Thin Border</option>
                        <option valu="No Border" <?php echo (isset($item_selection["selection"][3]) && $item_selection["selection"][3] == "No Border")?'selected="true"':'';?>>No Border</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="comments[]"  value="{{ (isset($item_selection["comments"][3]))?$item_selection["comments"][3]:"" }}" /></td>
                <td><span class="amount_view"></span><input type="text" class="form-control"  name="amount[]" value="{{ (isset($item_selection["amount"][3]))?$item_selection["amount"][3]:"" }}" /></td>
            </tr>
            <tr class="active_rows">
                <td>Porcelain Photo Type</td>
                <td>
                    <select class="form-control"  name="selection[]">
                        <option valu=""></option>
                        <option valu="Thin Border" <?php echo (isset($item_selection["selection"][4]) && $item_selection["selection"][4] == "Thin Border")?'selected="true"':'';?>>Thin Border</option>
                        <option valu="No Border" <?php echo (isset($item_selection["selection"][4]) && $item_selection["selection"][4] == "No Border")?'selected="true"':'';?>>No Border</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="comments[]"  value="{{ (isset($item_selection["comments"][4]))?$item_selection["comments"][4]:"" }}" /></td>
                <td><span class="amount_view"></span><input type="text" class="form-control"  name="amount[]" value="{{ (isset($item_selection["amount"][4]))?$item_selection["amount"][4]:"" }}"/></td>
            </tr>
            <tr class="active_rows">
                <td>Urn Model: (click to view urns selection )</td>
                <td>
                    <input type="text"  class="form-control" name="selection[]"   value="{{ (isset($item_selection["selection"][5]))?$item_selection["selection"][5]:"" }}" />
                </td>
                <td><input type="text" class="form-control" name="comments[]"  value="{{ (isset($item_selection["comments"][5]))?$item_selection["comments"][5]:"" }}" /></td>
                <td><span class="amount_view"></span><input type="text" class="form-control"  name="amount[]" value="{{ (isset($item_selection["amount"][5]))?$item_selection["amount"][5]:"" }}"/></td>
            </tr>
            <tr class="active_rows">
                <td>Ashes with:</td>
                <td>
                    <input type="text"  class="form-control" name="selection[]"   value="{{ (isset($item_selection["selection"][6]))?$item_selection["selection"][6]:"" }}" />
                </td>
                <td><input type="text" class="form-control" name="comments[]"  value="{{ (isset($item_selection["comments"][6]))?$item_selection["comments"][6]:"" }}" /></td>
                <td><span class="amount_view"></span><input type="text" class="form-control"  name="amount[]" value="{{ (isset($item_selection["amount"][6]))?$item_selection["amount"][6]:"" }}"/></td>
            </tr>
            <tr class="active_rows">
                <td>Miscellaneous</td>
                <td>
                    <input type="text"  class="form-control" name="selection[]"   value="{{ (isset($item_selection["selection"][7]))?$item_selection["selection"][7]:"" }}" />
                </td>
                <td><input type="text" class="form-control" name="comments[]"  value="{{ (isset($item_selection["comments"][7]))?$item_selection["comments"][7]:"" }}" /></td>
                <td><span class="amount_view"></span><input type="text" class="form-control"  name="amount[]" value="{{ (isset($item_selection["amount"][7]))?$item_selection["amount"][7]:"" }}"/></td>
            </tr>
            <?php
            if (isset($item_selection["item_name"])):
                foreach ($item_selection["item_name"] as $key=>$item_name):
                    ?>
                    <tr class="active_rows">
                        <td><input type="text" class="form-control" name="item_name[]" value="{{$item_name}}" /></td>
                        <td>
                            <input type="text"  class="form-control" name="selection[]"   value="{{ (isset($item_selection["selection"][$key + 8]))?$item_selection["selection"][$key + 8]:"" }}" />
                        </td>
                        <td><input type="text" class="form-control" name="comments[]"  value="{{ (isset($item_selection["comments"][$key + 8]))?$item_selection["comments"][$key + 8]:"" }}" /></td>
                        <td><span class="amount_view"></span><input type="text" class="form-control"  name="amount[]" value="{{ (isset($item_selection["amount"][$key + 8]))?$item_selection["amount"][$key + 8]:"" }}"/></td>
                    </tr>
                    <?php
                endforeach;
            endif;
            ?>
            <tr id="click_add_zone">
                <td class="no_border"><a href="#" id="add_items">Click to add more</a></td>
                <td class="no_border"></td>
                <td class="no_border" style="text-align:right">Total</td>
                <td><span id="subtotal">{{ (isset($item_selection["subtotal"]))?$item_selection["subtotal"]:"" }}</span><input type="hidden" id="subtotal_val" name="subtotal" value="{{ (isset($item_selection["subtotal"]))?$item_selection["subtotal"]:"" }}"  /></td>
            </tr>
            <tr>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border" style="text-align:right">GST</td>
                <td><span id="gst">{{ (isset($item_selection["gst"]))?$item_selection["gst"]:"" }}</span><input type="hidden" id="gst_val" name="gst" value="{{ (isset($item_selection["gst"]))?$item_selection["gst"]:"" }}" /></td>
            </tr>
            <tr>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border" style="text-align:right">Total with GST</td>
                <td><span id="total_amount">{{ (isset($item_selection["total_amount"]))?$item_selection["total_amount"]:"" }}</span><input type="hidden" id="total_amount_val" name="total_amount" value="{{ (isset($item_selection["total_amount"]))?$item_selection["total_amount"]:"" }}" /></td>
            </tr>
            <tr>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border" style="text-align:right">Deposit</td>
                <td><span id="deposit">{{ (isset($item_selection["deposit"]))?$item_selection["deposit"]:"" }}</span><input type="text" id="deposit_val" name="deposit" class="form-control" value="{{ (isset($item_selection["deposit"]))?$item_selection["deposit"]:"" }}"  /></td>
            </tr>
            <tr>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border" style="text-align:right">Balance Payable</td>
                <td><span id="balance_payable">{{ (isset($item_selection["balance_payable"]))?$item_selection["balance_payable"]:"" }}</span><input type="hidden" id="balance_payable_val" name="balance_payable" value="{{ (isset($item_selection["balance_payable"]))?$item_selection["balance_payable"]:"" }}" /></td>
            </tr>
            
        </table>
    </div>
    
    
    
    <div class="section_title">Confirmation of Order</div>
    <div class="section_content">
        I confirmed that the inscriptions are correct:
        <br /><br />
        
        <div id="box1" >
            @if ($order->signatures)
            <?php $signatures = json_decode($order->signatures, true);?>
            <img src="<?php echo $signatures[1];?>" style="width:100px"/>
            @endif
        </div>
        <div class="signature_box" id="signature_box_1">
            <div id="signature1" data-name="signature1" data-max-size="2048" 
                   data-pen-tickness="3" data-pen-color="black" 
                   class="sign-field"></div>
                   <input type="hidden" id="signature_image_1" name="signature_image_1" value="<?php echo (isset($signatures))?$signatures[1]:'';?>" />
                   <button class="btn btn-primary" >Ok</button>

        </div>
        Date: <span id="date_signature_1"><?php 
                                if ($order->signature_date && $order->signature_date != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($order->signature_date));
                                endif;
                                ?></span><input type="hidden" name="date_signature_1" id="input_date_signature_1" value="{{$order->signature_date}}" />
    </div>
    
    
    <div class="section_title">Checking of Slab (for office use only)</div>
    <div class="section_content">
        <table>
            <tr>
                <td>Slab Returned / Completed Date:</td>
                <td><input type="text" class="form-control" id="slab_returned" name="slab_returned" value="{{$order->slab_returned}}"  /></td>
                <td colspan="3"></td>
                <td>Checked by:</td>
                <td><input type="text" class="form-control" id="slab_returned_checked_by" name="slab_returned_checked_by" value="{{$order->slab_returned_checked_by}}"  /></td>
            </tr>
            <tr>
                <td>Porcelain Photo Returned Date:</td>
                <td><input type="text" class="form-control" id="porcelain_photo_returned_date" name="porcelain_photo_returned_date" value="{{$order->porcelain_photo_returned_date}}" /></td>
                <td colspan="3"></td>
                <td>Checked by:</td>
                <td><input type="text" class="form-control" id="porcelain_photo_returned_date_checked_by" name="porcelain_photo_returned_date_checked_by" value="{{$order->porcelain_photo_returned_date_checked_by}}" /></td>
            </tr>
            <tr>
                <td>Called Family by:</td>
                <td><input type="text" class="form-control" id="called_family" name="called_family" value="{{$order->called_family}}" /></td>
                <td colspan="3"></td>
                <td>Date:</td>
                <td><input type="text" class="form-control" id="called_family_date" name="called_family_date" value="{{$order->called_family_date}}" /></td>
            </tr>
            <tr>
                <td>Slab Installation Date & Time:</td>
                <td><input type="text" class="form-control" id="slab_install" name="slab_install" value="{{$order->slab_install}}" /></td>
                <td colspan="2"></td>
                <td>Photo installation</td>
                <td>Date & Time:</td>
                <td><input type="text" class="form-control" id="photo_install" name="photo_install" value="{{$order->photo_install}}" /></td>
            </tr>
            <tr>
                <td>Meet Family:</td>
                <td><input type="text" class="form-control" id="meet_family" name="meet_family" value="{{$order->meet_family}}" /></td>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td>Remarks:</td>
                <td><input type="text" class="form-control" id="slab_remarks" name="slab_remarks" value="{{$order->slab_remarks}}" /></td>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td colspan="7"> &nbsp;</td>
            </tr>
            <tr>
                <td>Order taken by:</td>
                <td><input type="text" class="form-control" id="slab_order_taken_by" name="slab_order_taken_by" value="{{($order->slab_order_taken_by)?$order->slab_order_taken_by:$user->name}}" /></td>
                <td>Date:</td>
                <td><input type="text" class="form-control" id="slab_order_date" name="slab_order_date" value="{{$order->slab_order_date}}" /></td>
                <td>Remarks:</td>
                <td><input type="text" class="form-control" id="slab_order_remarks" name="slab_order_remarks" value="{{$order->slab_order_remarks}}" /></td>
            </tr>
            <tr>
                <td>Inscription taken by:</td>
                <td><input type="text" class="form-control" id="inscription_taken_by" name="inscription_taken_by" value="{{$order->inscription_taken_by}}" /></td>
                <td>Date:</td>
                <td><input type="text" class="form-control" id="inscription_taken_date" name="inscription_taken_date" value="{{$order->inscription_taken_date}}" /></td>
                <td>Remarks:</td>
                <td><input type="text" class="form-control" id="inscription_taken_remarks" name="inscription_taken_remarks" value="{{$order->inscription_taken_remarks}}" /></td>
            </tr>
            <tr>
                <td>Photo taken by:</td>
                <td>
                    <input type="text" class="form-control" id="photo_taken" name="photo_taken" value="{{$order->photo_taken}}" />
                </td>
                <td>Date:</td>
                <td><input type="text" class="form-control" id="photo_taken_date" name="photo_taken_date" value="{{$order->photo_taken_date}}" /></td>
                <td>Remarks:</td>
                <td>
                    <select class="form-control" id="photo_taken_remarks" name="photo_taken_remarks">
                        <option value="use photo enlargement" <?php echo (!empty($order->photo_taken_remarks) && $order->photo_taken_remarks == "use photo enlargement")?'selected="true"':'';?>>use photo enlargement</option>
                        <option value="provided new photo" <?php echo (!empty($order->photo_taken_remarks) && $order->photo_taken_remarks == "provided new photo")?'selected="true"':'';?>>provided new photo</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Photo returned by:</td>
                <td><input type="text" class="form-control" id="photo_returned_by" name="photo_returned_by" value="{{$order->photo_returned_by}}" /></td>
                <td>Date:</td>
                <td><input type="text" class="form-control" id="photo_returned_date" name="photo_returned_date" value="{{$order->photo_returned_date}}" /></td>
                <td>Remarks:</td>
                <td><input type="text" class="form-control" id="photo_returned_remarks" name="photo_returned_remarks" value="{{$order->photo_returned_remarks}}" /></td>
            </tr>
        </table>
    </div>
    
    
    
    <div class="section_content" style="margin-top: 100px; height: 100px;">
        <table style="width: 100%">
            <tr>
                <td style="width: 33%; text-align: right"><input type="button" value="SUBMIT" id="submit_bttn" /></td>
                <td style="width: 33%; text-align: center"><input type="button" value="SUBMIT & E-mail" id="submit_email_bttn" /><br style="line-height:30px" /><input type="button" value="SUBMIT & E-mail (other e-mail)"   id="submit_other_email_bttn" /></td>
                <td style=" text-align: left"><input type="button" value="SUBMIT & Print" id="submit_print_bttn" /></td>

            </tr>
        </table>
    </div>
</div>

</form>

@endsection


@push('css')
    <link href="/css/app/columbarium.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/general_form.js"></script>
    <script src="/js/app/columbarium.js"></script>
	<script>
 $('.datepicker_fa').datepicker({
			startView:2,
            singleDatePicker: true,
            timePicker: false,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy'
     });
</script>
@endpush