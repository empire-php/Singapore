@extends('layouts.app')

@section('content')

<?php if ($session->get("go_msg")):?>
<script type="text/javascript">
    var saveMessage = '<?php echo implode("<br />",$session->get("go_msg"))?>';
    var openPdf = <?php echo ($session->get("go_open_pdf") == 1)? "true" : "false"?>;
</script>
<?php $session->set("go_msg", null); $session->set("go_open_pdf", null);?>
<?php endif; ?>
<form action="/gemstone/save"  id="info_frm" method="post" enctype="multipart/form-data" class="master_form needs_exit_warning">
    {!! csrf_field() !!}
    
    <input type="hidden"  id="form_id" name="id" value="{{$order->id}}"  />
    <input type="hidden"  id="is_draft" value="{{$order->is_draft}}"  />
<div class="section">

    <div class="section_content" id="order_section">
        <table>
            <tr>
                <td>Date:</td>
                <td>{{ ($order->created_at)?date("d-m-Y H:i:s",strtotime($order->created_at)):date("d-m-Y H:i:s")}}<input type="hidden" class="form-control" name="created_at" value="{{ ($order->created_at)?date("d-m-Y H:i:s",strtotime($order->created_at)):date("d-m-Y H:i:s")}}" /></td>
            </tr>
            <tr>
                <td>Ref / SC no:</td>
                <td>
                <input type="text" class="form-control" id="fa_code" name="fa_code" value="{{ ($order->funeral_arrangement_id)?$order->funeralArrangement->generated_code:"" }}"  />
                <input type="hidden"  id="fa_id" name="fa_id" value="{{($order->funeral_arrangement_id)?$order->funeral_arrangement_id:""}}"  /></td>
            </tr>
            <tr>
                <td>GEM Order No:</td>
                <td><input type="text" class="form-control" name="order_nr" value="{{($order->order_nr)?$order->order_nr:''}}" /></td>
            </tr>
        </table>
    </div>
    
    <div class="section_title customer_details_title">Customer Details</div>
    <div class="section_content customer_details_content">
        <table>
            <tr>
                <td style="widt: 20% "><em>Point of Contact 1</em></td>
                <td></td>
                
                <td><em>Point of Contact 2</em></td>
                <td></td>
            </tr>
            <tr>
                <td>Title</td>
                <td>
				<select name="first_cp_title" id = "first_cp_title" class="form-control">
				<option value=""></option>
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
							>Dr</option>
				</select>
                </td>
				<td>Title</td>
				<td>
				<select name="second_cp_title" id="second_cp_title" class="form-control">
				<option value=""></option>
					<option value="Mr"   
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
							>Dr</option>
				</select>
			</td>
			</tr>
			<tr>
                <td>NRIC No:</td>
                <td><input type="text" class="form-control" id="first_cp_nric" name="first_cp_nric" value="{{$order->first_cp_nric}}" /></td>
                <td>NRIC No:</td>
                <td><input type="text" class="form-control" id="second_cp_nric" name="second_cp_nric"  value="{{$order->second_cp_nric}}"  /></td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><input type="text" class="form-control" id="first_cp_name" name="first_cp_name"  value="{{$order->first_cp_name}}"  /></td>
                <td>Name:</td>
                <td><input type="text" class="form-control" id="second_cp_name" name="second_cp_name"  value="{{$order->second_cp_name}}"  /></td>
            </tr>
			<tr>
                 <td class="field_container">Religion</td>
				 <td class="input_container">
					<select name="first_cp_religion" id="first_cp_religion" class="form-control">
					 <option value=""></option>
					   @foreach($religionOptions as $religionOp)
						<option value="{{$religionOp->name}}" 
								@if ($religionOp->name == $order->first_cp_religion)
								selected="true"
								@endif
								>{{$religionOp->name}}</option>
						@endforeach
					</select>
				</td>
				<td class="field_container">Religion</td>
				 <td class="input_container">
					<select name="second_cp_religion" id="second_cp_religion" class="form-control">
					 <option value=""></option>
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
                <td><input type="text" class="form-control" id="first_cp_address" name="first_cp_address"  value="{{$order->first_cp_address}}"  /></td>
                <td>Address:</td>
                <td><input type="text" class="form-control" id="second_cp_address" name="second_cp_address"  value="{{$order->second_cp_address}}"  /></td>
            </tr>
            <tr>
                <td>Mobile number:</td>
                <td><input type="text" class="form-control" id="first_cp_mobile" name="first_cp_mobile"  value="{{$order->first_cp_mobile}}"  /></td>
                <td>Mobile number:</td>
                <td><input type="text" class="form-control" id="second_cp_mobile" name="second_cp_mobile"  value="{{$order->second_cp_mobile}}"  /></td>
            </tr>
        </table>
        <table class="bordered_table" id="order_items_tbl">
            <tr>
                <th>Name of Your Loved One</th>
                <th>Product Type</th>
                <th>Weight of Ashes(g)</th>
                <th>Unit Price (SGD)</th>
                <th>Quantity</th>
                <th>Amount (SGD)</th>
            </tr>
            @if (count($order_items) == 0)
            <tr id="default_product" class="active_rows">
                <td><input type="text" class="form-control" id="deceased_name_1" name="deceased_name[]" /></td>
                <td>
                    <select class="form-control" name="product_id[]">
                        <option value=""></option>
                        @foreach($products as $product)
                        <option value="{{$product->id}}||{{$product->unit_price}}">{{$product->item}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" class="product_name"  name="product[]"  />
                </td>
                <td><input type="number" step="0.01" class="form-control" name="weight_ashes[]"  /></td>
                <td><span  class="price_view"></span><input type="hidden"  name="price[]"  /></td>
                <td><input type="number" step="0.01" class="form-control" name="quantity[]"  /></td>
                <td><span class="amount_view"></span><input type="hidden"  name="amount[]"  /></td>
            </tr>
            @else
                @for ($i = 0; $i < count($order_items["deceased_name"]); $i++)
                <tr <?php if ($i == 0):?>id="default_product"<?php endif;?> class="active_rows">
                    <td><input type="text" class="form-control" id="deceased_name_1" name="deceased_name[]" value="{{ $order_items["deceased_name"][$i] }}" /></td>
                    <td>
                        <select class="form-control" name="product_id[]">
                            <option value=""></option>
                            @foreach($products as $product)
                            <option value="{{$product->id}}||{{$product->unit_price}}"  <?php if ($product->item == $order_items["product"][$i]):?>selected="selected"<?php endif;?>>{{$product->item}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" class="product_name"  name="product[]" value="{{ $order_items["product"][$i] }}" />
                    </td>
                    <td><input type="number" step="0.01" class="form-control" name="weight_ashes[]" value="{{ $order_items["weight_ashes"][$i] }}"  /></td>
                    <td><span  class="price_view"></span><input type="hidden"  name="price[]" value="{{ $order_items["price"][$i] }}"  /></td>
                    <td><input type="number" step="1" class="form-control" name="quantity[]" value="{{ $order_items["quantity"][$i] }}" /></td>
                    <td><span class="amount_view"></span><input type="hidden"  name="amount[]" value="{{ $order_items["amount"][$i] }}" /></td>
                </tr>
                @endfor
            @endif
            <tr id="calc_zone">
                <td class="no_border"><a href="#" id="add_products">Click to add more</a></td>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td>Sub-total</td>
                <td><span id="subtotal">{{ isset($order_items["subtotal"])?round($order_items["subtotal"], 2):'' }}</span><input type="hidden" id="subtotal_val" name="subtotal" value="{{ isset($order_items["subtotal"])?$order_items["subtotal"]:'' }}" /></td>
            </tr>
            <tr>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td>GST</td>
                <td><span id="gst">{{ isset($order_items["gst"])?$order_items["gst"]:'' }}</span><input type="hidden" id="gst_val" name="gst" value="{{ isset($order_items["gst"])?$order_items["gst"]:'' }}" /></td>
            </tr>
            <tr>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td>Total Amount</td>
                <td><span id="total_amount">{{ isset($order_items["total_amount"])?$order_items["total_amount"]:'' }}</span><input type="hidden" id="total_amount_val" name="total_amount" value="{{ isset($order_items["total_amount"])?$order_items["total_amount"]:'' }}" /></td>
            </tr>
        </table>
        
        
        
        
        
        <table style="margin-top: 50px">
            <tr>
                <td rowspan="2" style="vertical-align: top">Remarks</td>
                <td><textarea rows="2" class="form-control" name="remarks" style="width: 300px">{{$order->remarks}}</textarea></td>
            </tr>
        </table>
    </div>
    
    
    <div class="section_title">Acknowledgements</div>
    <div class="section_content">
        1. I hereby consent and authorize Singapore Casket Company (Private) Limited ("Singapore Casket") to send the ashes described above to SAGE Funeral Services Limited to transform the ashes into Eternity Gem Stone(s).
        <br />
        2. I understand and accept that the eventual size, shape, color and luster of the Eternity Gem Stone(s) produced may be different from the sample shown to me by Singapore Casket. I understand and am aware that the sample shown to me by Singapore Casket is for my reference only and that the eventual Eternity Gem Stone(s) produced may be different from the sample shown to me.
        <br />
        3. I confirm that I have read Singapore Casket's "Terms and Conditions of Sale" and I accept that Singapore Casket's "Terms and Conditions of Sale" is also an integral part of the agreement between Singapore Casket and me herein.
        
    </div>
    
    <div class="section_title">Terms & Conditions</div>
    <div class="section_content"  style="height: 120px;">
        <p>{{$terms_conditions}}</p>
    </div>
    
    <div class="section_content">
        <table style="width: 100%">
            <tr>
                <td style="width: 50px">
                    &nbsp; 
                </td>
                <td colspan="2">
                    Accepted and Acknowledged by:
                </td>
                <td>
                    &nbsp; 
                </td>
                <td colspan="2">
                    Gem Stone Received by:
                </td>
                <td>
                    &nbsp; 
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp; 
                </td>
                <td style="text-align: center; width: 392px;" colspan="2">
                    <div id="box1" >
                        @if ($order->signatures)
                        <?php $signatures = json_decode($order->signatures, true);?>
                        <img src="<?php echo $signatures[1];?>" style="width:120px"/>
                        @endif
                    </div>
                    <div class="signature_box" id="signature_box_1">
                        <div id="signature1" data-name="signature1" data-max-size="2048" 
                               data-pen-tickness="3" data-pen-color="black" 
                               class="sign-field">     
                        </div>
                        <input type="hidden" id="signature_image_1" name="signature_image_1" value="<?php echo isset($signatures[1])?$signatures[1]:'';?>" />
                        <button class="btn btn-primary" >Ok</button>
                        
                    </div>
                </td>
                <td>
                    &nbsp; 
                </td>
                <td style="text-align: center; width: 392px;" colspan="2">
                    <div id="box2">
                        @if ($order->signatures)
                        <img src="<?php echo $signatures[2];?>" style="width:120px"/>
                        @endif
                    </div>
                    <div class="signature_box" id="signature_box_2">
                          <div id="signature2" data-name="signature2" data-max-size="2048" 
                               data-pen-tickness="3" data-pen-color="black" 
                               class="sign-field"></div>
                               <input type="hidden" name="signature_image_2" id="signature_image_2" value="<?php echo isset($signatures[2])?$signatures[2]:'';?>" />
                               <button class="btn btn-primary" >Ok</button>
                    </div>
                </td>
                <td>
                    &nbsp; 
                </td>
            </tr>
 
            <tr>
                <td>
                    &nbsp; 
                </td>
                <td style="width: 70px">
                    Name: 
                </td>
                <td style="text-align: left">
                    <select id="name_signature_1" name="first_name" style="width: 160px; padding-left: 8px;" class="form-control">
                        <option value=""></option>
                        @for($i = 0 ; $i < count($fa) ; $i ++)
                        <option value="{{$fa[$i]->first_cp_name}}">{{$fa[$i]->first_cp_name}}</option> 
                        @endfor
                    </select>
                </td>
                <td>
                    &nbsp; 
                </td>
                <td style="width: 70px">
                    Name: 
                </td>
                <td style="text-align: left">
                    <select id="name_signature_2" name="name_signature_2" style="width: 160px; padding-left: 8px;" class="form-control">
                        <option value=""></option>
                        @for($i = 0 ; $i < count($fa) ; $i ++)
                        <option value="{{$fa[$i]->second_cp_name}}">{{$fa[$i]->second_cp_name}}</option> 
                        @endfor
                    </select>
                </td>
                <td>
                    &nbsp; 
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp; 
                </td>
                <td>
                    Date: 
                </td>
                <td style="text-align: left">
                    <span id="date_signature_1"><?php 
                            if ($order->signature_date && $order->signature_date != "0000-00-00"):
                                echo date("d/m/Y", strtotime($order->signature_date));
                            endif;
                            ?></span><input type="hidden" name="date_signature_1" id="input_date_signature_1" value="{{$order->signature_date}}" />
                </td>
                <td>
                    &nbsp; 
                </td>
                <td>
                    Date: 
                </td>
                <td style="text-align: left">
                    <span id="date_signature_2"><?php 
                            if ($order->signature_date && $order->signature_date != "0000-00-00"):
                                echo date("d/m/Y", strtotime($order->signature_date));
                            endif;
                            ?></span><input type="hidden" name="date_signature_2" id="input_date_signature_2" value="{{$order->signature_date}}" />
                </td>
                <td>
                    &nbsp; 
                </td>
            </tr>
            <tr>
                <td colspan="7" style="padding-top: 100px">
                    <strong>ASHES TRANSFER LOCATION</strong>
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp; 
                </td>
                <td>
                    Date: 
                </td>
                <td style="text-align: right">
                    <input type="text" class="form-control" style="width: 240px;" name="ashes_transfer_date" value="{{$order->ashes_transfer_date}}" />
                </td>
                <td colspan="4">
                    &nbsp; 
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp; 
                </td>
                <td>
                    Ashes Transfered by: 
                </td>
                <td style="text-align: right">
                    <input type="text" class="form-control" style="width: 240px;" name="ashes_transfered_by" value="{{$order->ashes_transfered_by}}" />
                </td>
                <td colspan="4">
                    &nbsp; 
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp; 
                </td>
                <td>
                    Address: 
                </td>
                <td style="text-align: right">
                    <input type="text" class="form-control" style="width: 240px;" name="ashes_transfer_address" value="{{$order->ashes_transfer_address}}" />
                </td>
                <td colspan="4">
                    &nbsp; 
                </td>
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
    <?php /*

<div class="modal fade" id="save_msg" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Save status</h4>
            </div>

            <div class="modal-body">
                <div class="form-group " id="message_container">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default cancel_bttn">Ok</button>
            </div>

        </div>
    </div>
</div>*/?>
    
    
</form>
@endsection


@push('css')
    <link href="/css/app/gemstone.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/general_form.js"></script>
    <script src="/js/app/gemstone.js"></script>
    
@endpush