@extends('layouts.app')

@section('content')

<?php if (isset($session) && $object && $session->get("scc_".$object->id."_msg")):?>
<script type="text/javascript">
    var saveMessage = '<?php echo implode("<br />",$session->get("scc_".$object->id."_msg"))?>';
    var openPdf = <?php echo ($session->get("scc_".$object->id."_open_pdf") == 1)? "true" : "false"?>;
</script>
<?php $session->set("scc_".$object->id."_msg", null); $session->set("scc_".$object->id."_open_pdf", null);?>
<?php endif; ?>

<div class="page-header">
    <h3>
        @if(isset($order))
            SCC Care > <a href="/scc/buddhist">{{$page_title}}</a> / Order {{$order_nr}}
        @else
            SCC Care > {{$page_title}}
        @endif
    </h3>
    
    
    <form action="{{ URL::to('/scc/save') }}"  class="master_form needs_exit_warning" id="info_frm" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <input type="hidden" name="order_id" id="order_id" value="{{ $object->id }}" />
        <input type="hidden" name="is_draft" id="is_draft" value="{{ $object->is_draft }}" />
        <input type="hidden" name="order_type" id="order_type" value="{{ $type }}" />
        <input type="hidden" name="changes_made" id="changes_made" value="" />



        <div id="order_form" class="needs_exit_warning">
            <div class="section">
                <div id="order_info">
                    <table style="width: 100%">
                        <tr>
                            <td>Date:</td>
                            <td>{{ ($object->created_at)?date("d-m-Y H:i:s",strtotime($object->created_at)):date("d-m-Y H:i:s")}}</td>
                        </tr>
                        <tr>
                            <td>Ref No:</td>
                            <td><input type="text" class="form-control" id="fa_code" name="fa_code" value="{{ ($object->funeral_arrangement_id)?$object->funeralArrangement->generated_code:"" }}"  /><input type="hidden"  id="fa_id" name="fa_id" value="{{($object->funeral_arrangement_id)?$object->funeral_arrangement_id:""}}"  /></td>
                        </tr>
                        <tr>
                            <td>Order No:</td>
                            <td><input type="text" disabled="disabled" class="form-control" name="order_nr" value="<?php echo $prefix . (($object->order_nr)?sprintf("%05d",$object->order_nr):'')?>" /></td>
                        </tr>
                        <tr>
                            <td>Issued and Arranged by:</td>
                            <td>{{($object->created_by)?$object->creator->name: $user->name }}</td>
                        </tr>
                    </table>
                </div>
                <div style="clear:both"></div>
                
                
                <div class="section_title">Deceased Details</div>
                <table class="form_content">
                    <tbody>
                        <tr>
                           <td>Title</td>
							<td>
							<select name="deceased_title" id="deceased_title" class="form-control">
							<option value=""></option>
								<option value="Mr"   
										@if ($object->deceased_title == "Mr")
										selected="true"
										@endif
										>Mr</option> 
								<option value="Mdm"
										@if ($object->deceased_title == "Mdm")
										selected="true"
										@endif
										>Mdm</option>
								<option value="Miss"
										@if ($object->deceased_title == "Miss")
										selected="true"
										@endif
										>Miss</option>
								<option value="Dr"
										@if ($object->deceased_title == "Dr")
										selected="true"
										@endif
										>Dr</option>
							</select>
							</td>
                        </tr>
						<tr>
                            <td class="field_container">Deceased Name</td>
                            <td colspan="3" class="input_container">
                                <input type="text" name="deceased_name"  id="deceased_name" class="form-control" value="{{$object->deceased_name}}"  />
                                <input type="hidden" name="shifting_id" id="shifting_id" value="{{ $object->id }}" />
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Religion</td>
                            <td class="input_container">
                                <select name="religion" style="width: 170px;" class="form-control">
                                    <option></option>
                                    @foreach($religionOptions as $religionOp)
                                    <option value="{{$religionOp->id}}" 
                                            @if ($religionOp->id == $object->religion)
                                            selected="true"
                                            @endif
                                            >{{$religionOp->name}}

                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="field_container">Church</td>
                            <td class="input_container">
                                <input type="text" name="church"  class="form-control" id="church" value="{{$object->church}}" />
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Sex</td>
                            <td colspan="3" class="input_container">
                                <select name="sex" style="width: 170px;" class="form-control">
                                    {{--<option></option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>--}}
                                    <option value="male" <?php echo ($object->sex == "male")?'selected="true"':'';?>>Male</option>
                                    <option value="female" <?php echo ($object->sex == "female")?'selected="true"':'';?>>Female</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Race</td>
                            <td class="input_container">
                                <select name="race" style="width: 170px;" class="form-control">
                                    <option></option>
                                    @foreach($raceOptions as $raceOp)
                                    <option value="{{$raceOp->id}}"
                                            @if ($raceOp->id == $object->race)
                                            selected="true"
                                            @endif
                                            >{{$raceOp->name}}
                                </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="field_container">Dialects</td>
                            <td class="input_container">
                                <input type="text" id="dialect" name="dialect"  class="form-control" value="{{$object->dialect}}" />
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Date of Birth</td>
                            <td class="input_container"><input type="text" id="birthdate" name="birthdate" class="datepickerty form-control" value="{{$object->birthdate}}" /></td>
                            <!--<td class="input_container"><input type="text" id="birthdate" name="birthdate" class="datepickerty form-control" value="{{$object->birthdate}}"  /></td>-->
                            <td class="field_container">Date of Death</td>
                            <td class="input_container"><input type="text" id="deathdate" name="deathdate" class="datepickerty form-control" value="" /></td>
                            <!--<td class="input_container"><input type="text" id="deathdate" name="deathdate" class="datepickerty form-control" value="{{$object->deathdate}}" /></td>-->
                        </tr>
                        <tr>
                            <td colspan="4" class="space"></td>
                        </tr>
                        <tr>
                            <td class="field_container">Cremation Location</td>
                            <td colspan="3" class="input_container">
                                <input type="text" name="cremation_location"  id="cremation_location" class="form-control" value="{{$object->cremation_location}}"  />
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Cortage Leave Date</td>
                            <td colspan="3" class="input_container">
                                <input type="text" name="cortage_leave_date"  id="cortage_leave_date" class="datepicker form-control" value=""  />
                                <!--<input type="text" name="cortage_leave_date"  id="cortage_leave_date" class="datepicker form-control" value="{{ ($object->cortage_leave_date != "0000-00-00")?date("d/m/Y", strtotime($object->cortage_leave_date)):""}}"  />-->
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Cortage Leaving Time</td>
                            <td colspan="3" class="input_container">
                                <input type="text" name="cortage_leaving_time"  id="cortage_leaving_time" class="form-control" value="{{($object->cortage_leaving_time != "00:00:00")?date("H:i", strtotime($object->cortage_leaving_time)):""}}"  />
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Location of Wake</td>
                            <td colspan="3" class="input_container">
                                <input type="text" name="wake_location"  id="wake_location" class="form-control" value="{{$object->wake_location}}"  />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="space"></div>
                
                
                <div class="section_title">Customer Details</div>
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
						<select name="first_cp_title" id="first_cp_title" class="form-control">
						<option value=""></option>
							<option value="Mr"   
									@if ($object->first_cp_title == "Mr")
									selected="true"
									@endif
									>Mr</option> 
							<option value="Mdm"
									@if ($object->first_cp_title == "Mdm")
									selected="true"
									@endif
									>Mdm</option>
							<option value="Miss"
									@if ($object->first_cp_title == "Miss")
									selected="true"
									@endif
									>Miss</option>
							<option value="Dr"
									@if ($object->first_cp_title == "Dr")
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
									@if ($object->second_cp_title == "Mr")
									selected="true"
									@endif
									>Mr</option> 
							<option value="Mdm"
									@if ($object->second_cp_title == "Mdm")
									selected="true"
									@endif
									>Mdm</option>
							<option value="Miss"
									@if ($object->second_cp_title == "Miss")
									selected="true"
									@endif
									>Miss</option>
							<option value="Dr"
									@if ($object->second_cp_title == "Dr")
									selected="true"
									@endif
									>Dr</option>
						</select>
						</td>
					</tr>
                    <tr>
                        <td>NRIC No:</td>
                        <td><input type="text" class="form-control nric_autocomplete" id="first_cp_nric" name="first_cp_nric" value="{{$object->first_cp_nric}}" /></td>
                        <td>NRIC No:</td>
                        <td><input type="text" class="form-control nric_autocomplete" id="second_cp_nric" name="second_cp_nric"  value="{{$object->second_cp_nric}}"  /></td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td><input type="text" class="form-control" id="first_cp_name" name="first_cp_name"  value="{{$object->first_cp_name}}"  /></td>
                        <td>Name:</td>
                        <td><input type="text" class="form-control" id="second_cp_name" name="second_cp_name"  value="{{$object->second_cp_name}}"  /></td>
                    </tr>
					<tr>
						 <td class="field_container">Religion</td>
						 <td class="input_container">
							<select name="first_cp_religion" id="first_cp_religion" class="form-control">
							 <option value=""></option>
							   @foreach($religionOptions as $religionOp)
								<option value="{{$religionOp->name}}" 
										@if ($religionOp->name == $object->first_cp_religion)
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
										@if ($religionOp->name == $object->second_cp_religion)
										selected="true"
										@endif
										>{{$religionOp->name}}</option>
								@endforeach
							</select>
						</td>
					</tr>
                    <tr>
                        <td>Address:</td>
                        <td><input type="text" class="form-control" id="first_cp_address" name="first_cp_address"  value="{{$object->first_cp_address}}"  /></td>
                        <td>Address:</td>
                        <td><input type="text" class="form-control" id="second_cp_address" name="second_cp_address"  value="{{$object->second_cp_address}}"  /></td>
                    </tr>
                    <tr>
                        <td>Mobile number:</td>
                        <td><input type="text" class="form-control" id="first_cp_mobile" name="first_cp_mobile"  value="{{$object->first_cp_mobile}}"  /></td>
                        <td>Mobile number:</td>
                        <td><input type="text" class="form-control" id="second_cp_mobile" name="second_cp_mobile"  value="{{$object->second_cp_mobile}}"  /></td>
                    </tr>
                </table>
                
                
                <div class="space"></div>
                
                <div class="section_title">Product Details</div>
                <?php if (!empty($pdf_item)):?>
                    <a href="{{url("/uploads/".$pdf_item["pdf"])}}">Click to view pictures of products</a>
                <?php else:?>
                    <!--For point 4 -->
                    <i></i>
                <?php endif; ?>
                <br /><br />
                <table class="table table-striped table-bordered table-hover" id="products_table" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align:center; vertical-align: middle">Description</th>
                            <th style="text-align:center; vertical-align: middle">Selection</th>
                            <th style="text-align:center; vertical-align: middle; width:100px" id="base_th_qty">
                                Qty Order
                                <br />
                                <input type="text" name="qty_order_date[]" class="form-control datepicker_day_format" style="width:80px" value="<?php echo (!empty($qty_dates[0]))?$qty_dates[0]:""?>" />
                            </th>
                            <?php if ($extra_q_td > 0):?>
                                <?php for($i = 1;$i < $extra_q_td; $i++):?>
                                <th style="text-align:center; vertical-align: middle; width:100px">
                                    Qty Order
                                    <br />
                                    <input type="text" name="qty_order_date[]" class="form-control datepicker_day_format" style="width:80px" value="<?php echo (!empty($qty_dates[$i]))?$qty_dates[$i]:""?>" />
                                </th>
                                <?php endfor;?>
                            <?php endif;?>
                            <th style="text-align:center; vertical-align: middle" class="add_column_td">Click here to add</th>
                            <?php if (!in_array($object->care_type, array("chanting","tentage"))):?>
                            <th style="text-align:center; vertical-align: middle; width:100px">Return QTY</th>
                            <?php endif;?>
                            <th style="text-align:center; vertical-align: middle; width:100px">Total Sold</th>
                            <th style="text-align:center; vertical-align: middle; width:100px">Unit Price</th>
                            <th style="text-align:center; vertical-align: middle; width:100px">Amount</th>
                            <th style="text-align:center; vertical-align: middle">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php if ($purchased_items):?>
                            <?php foreach($purchased_items as $key => $product_info):?>
                                <?php if (!empty($product_info["category_name"]) && $key != "new"):?>
                                <tr class="not_editable_line">
                                    <td>
                                        <?php echo (!empty($product_info["category_name"]))?$product_info["category_name"]:""?>
                                    </td>

                                    <td>
                                        <?php echo (!empty($product_info["item"]))?$product_info["item"]:""?>
                                    </td>
                                    <td class="qty" id="base_td_qty_r0" ><?php echo $product_info["quantities"][0]?></td>
                                    <?php if ($extra_q_td > 0):?>
                                        <?php for($i = 1;$i < $extra_q_td; $i++):?>
                                                <td class="qty" ><?php echo (!empty($product_info["quantities"][$i]))?$product_info["quantities"][$i]:""?></td>
                                        <?php endfor;?>
                                    <?php endif;?>
                                    <td class="add_column_td">&nbsp;</td>
                                    <?php if (!in_array($object->care_type, array("chanting","tentage"))):?>
                                    <td><?php echo (!empty($product_info["return_qty"]))?$product_info["return_qty"]:""?> <input type="hidden" id="return_qty[]" value="<?php echo (!empty($product_info["return_qty"]))?$product_info["return_qty"]:""?>" /></td>
                                    <?php endif;?>
                                    <td><?php echo (!empty($product_info["total_sold"]))?$product_info["total_sold"]:""?> <input type="hidden" id="total_sold[]" value="<?php echo (!empty($product_info["total_sold"]))?$product_info["total_sold"]:""?>" /></td>
                                    <td><?php echo (!empty($product_info["unit_price"]))?$product_info["unit_price"]:""?> <input type="hidden" id="unit_price[]" value="<?php echo (!empty($product_info["unit_price"]))?$product_info["unit_price"]:""?>" /></td>
                                    <td><?php echo (!empty($product_info["amount"]))?$product_info["amount"]:""?>         <input type="hidden" id="amount[]" value="<?php echo (!empty($product_info["amount"]))?$product_info["amount"]:""?>" /></td>
                                    <td><?php echo (!empty($product_info["remarks"]))?$product_info["remarks"]:""?>       <input type="hidden" id="remarks[]" value="<?php echo (!empty($product_info["remarks"]))?$product_info["remarks"]:""?>" /></td>
                                    
                                 
                                </tr>
                                <?php endif;?>
                            <?php endforeach;?>
                     
                            <?php if (!empty($purchased_items["new"])):	?>
                                
                                <?php foreach($purchased_items["new"] as $key => $product_info):?>
                                <?php $rId = $key + 2;?>
                                <tr id="r<?php echo $rId?>">
                                    <td>
                                        <select class="form-control" id="categories_r<?php echo $rId?>" name="categories[]">
                                            <option></option>
                                            <?php if (!empty($item_categories)):?>
                                                <?php foreach($item_categories as $key => $category):?>
                                                    <option value="<?php echo $key +1?>" <?php if (!empty($product_info["category_id"]) && $product_info["category_id"] == $key +1):?> selected="selected" <?php endif;?>><?php echo $category["group_name"]?></option>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        </select>

                                        <input type="hidden" id="category_name_r<?php echo $rId?>" name="category_name[]" value="<?php echo $product_info["category_name"];?>">
                                        <input type="hidden" name="row[]" value="r<?php echo $rId?>">
                                    </td>

                                    <td>


                                        <?php if (!empty($item_categories)):?>
                                            <?php foreach($item_categories as $key => $category):?>
                                                <select class="form-control" id="selection_item_<?php echo $key+1?>_r<?php echo $rId?>" name="selection_item_<?php echo $key+1?>_r<?php echo $rId?>" style="<?php if (!empty($product_info["category_id"]) && $product_info["category_id"] != $key +1):?>display:none;<?php endif;?> width:200px">
                                                    <option></option>
                                                    <?php if (!empty($items)):?>
                                                        <?php foreach($items[$category["group_name"]] as $selection_categories => $selection_products):?>
                                                            <optgroup label="{{$selection_categories}}">
                                                                <?php if (!empty($selection_products)):?>
                                                                    <?php foreach($selection_products as $selection_product):?>
                                                                        <?php  if (isset($products[$selection_product["selection_item_id"]])):?>
                                                                            <?php $product = $products[$selection_product["selection_item_id"]];?>
                                                                            <option value="<?php echo $product->id?>_w" data-id="<?php echo $product->id?>" data-name="<?php echo $product->item?>" data-price="<?php echo $product->unit_price?>" data-wq="<?php echo $product->warehouse?>" data-sq="<?php echo $product->store_room?>"  <?php if( $product->id == $product_info["product_id"] && $product_info["store_type"] == "w"):?>selected="selected"<?php endif;?>><?php echo $product->item?> (<?php echo $product->warehouse?> - Warehouse)</option>
                                                                            <option value="<?php echo $product->id?>_s" data-id="<?php echo $product->id?>" data-name="<?php echo $product->item?>" data-price="<?php echo $product->unit_price?>" data-wq="<?php echo $product->warehouse?>" data-sq="<?php echo $product->store_room?>"  <?php if( $product->id == $product_info["product_id"] && $product_info["store_type"] == "s"):?>selected="selected"<?php endif;?>><?php echo $product->item?> (<?php echo $product->store_room?> - Storeroom)</option>
                                                                        <?php endif?>
                                                                    <?php endforeach?>
                                                                <?php endif;?>
                                                            </optgroup>
                                                        <?php endforeach;?>
                                                    <?php endif;?>

                                                </select>


                                            <?php endforeach;?>
                                        <?php endif;?>

                                    </td>

                                    <td class="qty" id="base_td_qty_r<?php echo $rId?>"><input type="text" onkeyup="this.value=this.value.replace(/[^0-9\-]/g,'');"  class="form-control qty_order" id="qty_order_r<?php echo $rId?>" name="qty_order_r<?php echo $rId?>[]" value="<?php echo (!empty($product_info["quantities"][0]))?$product_info["quantities"][0]:"";?>" /></td>
                                    <?php if ($extra_q_td > 0):?>
                                        <?php for($i = 1;$i < $extra_q_td; $i++):?>
                                                <td class="qty"><input type="text" onkeyup="this.value=this.value.replace(/[^0-9]\-/g,'');"  class="form-control qty_order" id="qty_order_r<?php echo $rId?>" name="qty_order_r<?php echo $rId?>[]" value="<?php echo (!empty($product_info["quantities"][$i]))?$product_info["quantities"][$i]:"";?>" /></td>
                                        <?php endfor;?>
                                    <?php endif;?>
                                    <td class="add_column_td">&nbsp;</td>
                                    <?php if (!in_array($object->care_type, array("chanting","tentage"))):?>
                                    <td><input type="text" class="form-control" id="return_qty_r<?php echo $rId?>" name="return_qty[]" value="<?php echo $product_info["return_qty"];?>" /></td>
                                    <?php endif;?>
                                    <td><input type="text" class="form-control" id="total_sold_r<?php echo $rId?>" name="total_sold[]" value="<?php echo $product_info["total_sold"];?>" /></td>
                                    <td><input type="text" class="form-control" id="unit_price_r<?php echo $rId?>" name="unit_price[]" value="<?php echo $product_info["unit_price"];?>" /></td>
                                    <td><input type="text" class="form-control" id="amount_r<?php echo $rId?>" name="amount[]" value="<?php echo $product_info["amount"];?>" /></td>
                                    <td><input type="text" class="form-control" id="remarks_r<?php echo $rId?>" name="remarks[]" value="<?php echo $product_info["remarks"];?>" /></td>
                                </tr>
                                
                                <?php endforeach;?>
                            <?php endif;?>
                        <?php endif;?>
                                
                                <!-- For point 2.2 -->
                     <?php // var_dump(!empty($item_categories));exit;?>   
			<?php if (!empty($item_categories)):?>
			<?php foreach($item_categories as $key => $category):?>
                                <?php  //var_dump($item_categories);exit;?>   
                            <tr id="r1">
                                <td>
                                    <label style="font-weight:normal " for="<?php echo $category["group_name"]?>"><a href="#" id="item_category_id_<?php echo $category['id']; ?>" onclick="getInfomationToDetails(this);" ><?php echo $category["group_name"]?></a></label>
                                                                    <input type="hidden" name="categories[]" value="<?php echo $key +1?>">
                                    <input type="hidden" id="category_name_r1" name="category_name[]">
                                    <input type="hidden" name="row[]" value="r1">
                                </td>
                            
                                <td>
                                
										
                                     <input type="text" name="selection_item_<?php echo $key+1?>_r1" value="" class="form-control">
                                        
										<!--<select class="form-control" id="selection_item_<?php echo $key+1?>_r1" name="selection_item_<?php echo $key+1?>_r1" style="display:none; width:200px">
                                            <option></option>
                                            <?php if (!empty($items)):?>
                                                <?php foreach($items[$category["group_name"]] as $selection_categories => $selection_products):?>
                                                    <optgroup label="{{$selection_categories}}">
                                                        <?php if (!empty($selection_products)):?>
                                                            <?php foreach($selection_products as $selection_product):?>
                                                                <?php  if (isset($products[$selection_product["selection_item_id"]])):?>
                                                                    <?php $product = $products[$selection_product["selection_item_id"]];?>
                                                                    <option value="<?php echo $product->id?>_w" data-id="<?php echo $product->id?>" data-name="<?php echo $product->item?>" data-price="<?php echo $product->unit_price?>" data-wq="<?php echo $product->warehouse?>" data-sq="<?php echo $product->store_room?>"><?php echo $product->item?> (<?php echo $product->warehouse?> - Warehouse)</option>
                                                                    <option value="<?php echo $product->id?>_s" data-id="<?php echo $product->id?>" data-name="<?php echo $product->item?>" data-price="<?php echo $product->unit_price?>" data-wq="<?php echo $product->warehouse?>" data-sq="<?php echo $product->store_room?>"><?php echo $product->item?> (<?php echo $product->store_room?> - Storeroom)</option>
                                                                <?php endif?>
                                                            <?php endforeach?>
                                                        <?php endif;?>
                                                    </optgroup>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                            
                                        </select>-->
                                
                                
                                
                            </td>
                            
                            <td class="qty" id="base_td_qty_r1"><input type="text" onkeyup="this.value=this.value.replace(/[^0-9\-]/g,'');"  class="form-control qty_order" id="qty_order_r1" name="qty_order_r1[]" value=""  onchange="calculate_input_values(this);"/></td>
                            <?php if ($extra_q_td > 0):?>
                                <?php for($i = 1;$i < $extra_q_td; $i++):?>
                                        <td class="qty"><input type="text" onkeyup="this.value=this.value.replace(/[^0-9\-]/g,'');"  class="form-control qty_order" id="qty_order_r1" name="qty_order_r1[]" value="" onchange="calculate_input_values(this);"/></td>
                                <?php endfor;?>
                            <?php endif;?>
                            <td class="add_column_td">&nbsp;</td>
                            <?php if (!in_array($object->care_type, array("chanting","tentage"))):?>
                            <td><input type="text" class="form-control" id="return_qty_r1" name="return_qty[]" value="" /></td>
                            <?php endif;?>
                            <td><input type="text" class="form-control" id="total_sold_r1" name="total_sold[]" value="" /></td>
                            <td><input type="text" class="form-control" id="unit_price_r1" name="unit_price[]" value="<?php echo $category["unit_price"]?$category["unit_price"]:0 ;?>" /></td>
                            <td><input type="text" class="form-control" id="amount_r1" name="amount[]" value="" /></td>
                            <td><input type="text" class="form-control" id="remarks_r1" name="remarks[]" value="" /></td>
                        </tr>
					<?php endforeach;?>
                     <?php endif;?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <?php if (!in_array($object->care_type, array("chanting","tentage"))):?>
                            <td colspan="<?php echo 6 + (($extra_q_td > 0)? ($extra_q_td -1):0) ?>" id="click_add_td"><a href="#">Click to add more</a></td>
                            <?php else:?>
                            <td colspan="<?php echo 5 + (($extra_q_td > 0)? ($extra_q_td -1):0)?>" id="click_add_td"><a href="#">Click to add more</a></td>
                            <?php endif;?>
                            <td style="font-weight: bold; font-style:italic">Total Amount</td>
                            <td><span id="total">{{$object->total}}</span><input type="hidden" name="total" value="{{$object->total}}" /></td>
                            <td> </td>
                        </tr>
                    </tfoot>
                </table>
                
                
                
                <div class="space"></div>
                
                
                <div class="signature_container">
                    <table>
                        <tr>
                            <td>
                                <span style="font-weight: bold">Confirmed & Agreed</span>
                                <div id="box1" >
                                    @if ($object->signature_1)
                                    <img src="{{$object->signature_1}}" style="width:100px"/>
                                    @endif
                                </div>
                                <div class="signature_box" id="signature_box_1">
                                      <div id="signature_1" data-name="signature_1" data-max-size="2048" 
                                           data-pen-tickness="3" data-pen-color="black" 
                                           class="sign-field"></div>
                                           <input type="hidden" id="signature_image_1" name="signature_image_1" value="{{$object->signature_1}}" />
                                           <button class="btn btn-primary" >Ok</button>
                                </div>
                                
                                Date: <span id="date_signature_1"><?php 
                                if ($object->signature_date_1 && $object->signature_date_1 != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($object->signature_date_1));
                                endif;
                                ?></span><input type="hidden" name="signature_date_1" id="input_date_signature_1" value="{{$object->signature_date_1}}" />
                            </td>
                            <td>
                                <span style="font-weight: bold">Goods Return</span>
                                <div id="box2" >
                                    @if ($object->signature_2)
                                    <img src="{{$object->signature_2}}" style="width:100px"/>
                                    @endif
                                </div>
                                <div class="signature_box" id="signature_box_2">
                                      <div id="signature_2" data-name="signature_2" data-max-size="2048" 
                                           data-pen-tickness="3" data-pen-color="black" 
                                           class="sign-field"></div>
                                           <input type="hidden" id="signature_image_2" name="signature_image_2" value="{{$object->signature_2}}" />
                                           <button class="btn btn-primary" >Ok</button>
                                </div>
                                
                                Date: <span id="date_signature_2"><?php 
                                if ($object->signature_date_2 && $object->signature_date_2 != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($object->signature_date_2));
                                endif;
                                ?></span><input type="hidden" name="signature_date_2" id="input_date_signature_2" value="{{$object->signature_date_2}}" />
                            </td>
                        </tr>
                        <tr class="space">
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-weight: bold">Goods Received</span>
                                <div id="box3" >
                                    @if ($object->signature_3)
                                    <img src="{{$object->signature_3}}" style="width:100px"/>
                                    @endif
                                </div>
                                <div class="signature_box" id="signature_box_3">
                                      <div id="signature_3" data-name="signature_3" data-max-size="2048" 
                                           data-pen-tickness="3" data-pen-color="black" 
                                           class="sign-field"></div>
                                           <input type="hidden" id="signature_image_3" name="signature_image_3" value="{{$object->signature_3}}" />
                                           <button class="btn btn-primary" >Ok</button>
                                </div>
                                
                                Date: <span id="date_signature_3"><?php 
                                if ($object->signature_date_3 && $object->signature_date_3 != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($object->signature_date_3));
                                endif;
                                ?></span><input type="hidden" name="signature_date_3" id="input_date_signature_3" value="{{$object->signature_date_3}}" />
                            </td>
                            <td></td>
                        </tr>

                    </table>
                </div>
                
                
                <div class="space"></div>
                
                <p>
                    <span style="text-transform: uppercase; font-weight: bold">Payment by cash, cheque or nets only</span>
                    <br />
                    1. <span style="text-transform: uppercase; font-weight: bold; text-decoration: underline">Payments:</span> We the undersigned quarantee payment in full for the above goods sold. We also accepted that any additional goods sold and services rendered ar the request of the undersigned or family members will be charged accordingly to this order form without further reference. Late payment interest of 2% per month will be imposed for any outstanding balance.
                    <br />
                    2. <span style="text-transform: uppercase; font-weight: bold; text-decoration: underline">Returns:</span> We only accept unopened packages that are purchased from Singapore Casket. Goods return shall be in good condition.
                    <br />
                    3. All cheques payable to <span style="text-transform: uppercase; font-weight: bold">SCC Care Services PTE. LTD.</span>
                    <br />
                    4. Total amount payable including <span style="text-transform: uppercase; font-weight: bold">GST</span>.
                </p>
                
                <div class="space"></div>
                
                <div style="text-align: center; width: 100%">
                    <table style="margin-left: 22%;">
                        <tr>
                            <td><input type="button" value="SUBMIT" id="submit_bttn" /></td>
                                <td><!--<input type="button" value="SUBMIT & E-mail" id="submit_email_bttn" /><br style="line-height:30px" />--><input type="button" value="SUBMIT & E-mail (other e-mail)"   id="submit_other_email_bttn" style="width:200px" /></td>
                            <td><input type="button" value="SUBMIT & Print" id="submit_print_bttn" /></td>
                        </tr>
                    </table>
                </div>
                
                <div class="space"></div>
            </div>
        </div>
    
    
    </form>
</div>

<div class="modal fade" id="box_other_email" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">E-mail address requested</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="inputWarning1">E-mail address</label>
                    <input type="text" id="popup_new_email" value="" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="popup_send_bttn">SEND</button>
            </div>

        </div>
    </div>
</div>
<!-- For point 2.2-->
<!-- Get all images of products -->
<div class="modal fade" id="view_all_images_for_product" tabindex="-1" role="dialog" style="z-index:22222">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail View</h4>
            </div>

            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="all_image_view_close">Close</button>
             <!--   <button type="button" class="btn btn-primary" id="save_general_bttn">Save</button> -->
            </div>

        </div>
    </div>
</div>
@endsection


@push('css')
    <link href="/css/app/scc_care.css" rel="stylesheet">
@endpush

 @push('scripts')
    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/scc_care.js"></script>
    <script src="/js/app/general_form.js"></script>
	
	
@endpush