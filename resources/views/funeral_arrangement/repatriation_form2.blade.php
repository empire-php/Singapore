<form action="{{ URL::to('/FArepatriation/save') }}"  id="info_frm" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}

    <input type="hidden" name="id" id="id" value="{{ $object->id }}" />
    <input type="hidden" name="step" id="step" value="{{$step}}" />
    <input type="hidden" name="changes_made" id="changes_made" value="" />
    <!--For point 9-->
    <input type="hidden" name="package_items" id="package_items" value="" />
    <input type="hidden" name="packages_stock_checked" id="packages_stock_checked" value="1" />
    <input type="hidden" name="group_items" id="group_items" value="0" />
    
    
    <div id="fa_form" class="needs_exit_warning">
        <div class="fa_section">
            <div class="form_title">Purchase</div>
            <table class="table table-striped table-bordered" style="margin-top: 30px">
                <thead>
                    <tr>
                        <th>
                            
                        </th>
                        <th>
                            Selection
                        </th>
                        <th>Comments</th>
                        <th colspan="2">
                            
                        </th>
                        <th>
                            Amount
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!--<tr>
                        <td>
                            Coffin
                        </td>
                        <td>
                            <input type="text" id="coffin_selection" name="coffin_selection" class="form-control" value="{{(isset($object))?$object->coffin_selection:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="coffin_comments" name="coffin_comments" class="form-control" value="{{(isset($object))?$object->coffin_comments:''}}" />
                        </td>
                        <td>Sold by </td>
                        <td><input type="text" id="coffin_sold_by" name="coffin_sold_by" class="form-control" value="{{(isset($object))?$object->coffin_sold_by:''}}" /></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="coffin_price" name="coffin_price" class="form-control" value="{{(isset($object) && $object->coffin_price)?$object->coffin_price:''}}" />
                        </td>
                    </tr>-->
                    <tr>
                        <td>
                            Embalming for Repatriation
                        </td>
                        <td>
                            <input type="text" id="embalming_selection" name="embalming_selection" class="form-control" value="{{(isset($object))?$object->embalming_selection:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="embalming_comments" name="embalming_comments" class="form-control" value="{{(isset($object))?$object->embalming_comments:''}}" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="embalming_price" name="embalming_price" class="form-control" value="{{(isset($object) && $object->embalming_price)?$object->embalming_price:''}}" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Parlour
                        </td>
                        <td>
                            <input type="text" id="parlour_selection" name="parlour_selection" class="form-control" value="{{(isset($object))?$object->parlour_selection:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="parlour_comments" name="parlour_comments" class="form-control" value="{{(isset($object))?$object->parlour_comments:''}}" />
                        </td>
                        <td>Days </td>
                        <td><input type="text" id="parlour_days" name="parlour_days" class="form-control" value="{{(isset($object))?$object->parlour_days:''}}" /></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="parlour_price" name="parlour_price" class="form-control" value="{{(isset($object) && $object->parlour_price)?$object->parlour_price:''}}" />
                        </td>
                    </tr>
                    
                    
                    
                    <tr>
                        <td>
                            Overtime
                        </td>
                        <td>
                            <input type="text" id="overtime_selection" name="overtime_selection" class="form-control" value="{{(isset($object))?$object->overtime_selection:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="overtime_comments" name="overtime_comments" class="form-control" value="{{(isset($object))?$object->overtime_comments:''}}" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="overtime_price" name="overtime_price" class="form-control" value="{{(isset($object) && $object->overtime_price)?$object->overtime_price:''}}" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Clothes
                        </td>
                        <td>
                            <input type="text" id="clothes_selection" name="clothes_selection" class="form-control" value="{{(isset($object))?$object->clothes_selection:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="clothes_comments" name="clothes_comments" class="form-control" value="{{(isset($object))?$object->clothes_comments:''}}" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="clothes_price" name="clothes_price" class="form-control" value="{{(isset($object) && $object->clothes_price)?$object->clothes_price:''}}" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Fumigation
                        </td>
                        <td>
                            <input type="text" id="fumigation_selection" name="fumigation_selection" class="form-control" value="{{(isset($object))?$object->fumigation_selection:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="fumigation_comments" name="fumigation_comments" class="form-control" value="{{(isset($object))?$object->fumigation_comments:''}}" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="fumigation_price" name="fumigation_price" class="form-control" value="{{(isset($object) && $object->fumigation_price)?$object->fumigation_price:''}}" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Removal from Airport / Wharf / On board vessel
                        </td>
                        <td>
                            <input type="text" id="wharf_selection" name="wharf_selection" class="form-control" value="{{(isset($object))?$object->wharf_selection:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="wharf_comments" name="wharf_comments" class="form-control" value="{{(isset($object))?$object->wharf_comments:''}}" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="wharf_price" name="wharf_price" class="form-control" value="{{(isset($object) && $object->wharf_price)?$object->wharf_price:''}}" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Metal Lining / Plastic Sealing
                        </td>
                        <td>
                            <input type="text" id="materials_selection" name="materials_selection" class="form-control" value="{{(isset($object))?$object->materials_selection:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="materials_comments" name="materials_comments" class="form-control" value="{{(isset($object))?$object->materials_comments:''}}" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="materials_price" name="materials_price" class="form-control" value="{{(isset($object) && $object->materials_price)?$object->materials_price:''}}" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Outer Wooden Packing Case / Hessian Covering
                        </td>
                        <td>
                            <input type="text" id="covering_selection" name="covering_selection" class="form-control" value="{{(isset($object))?$object->covering_selection:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="covering_comments" name="covering_comments" class="form-control" value="{{(isset($object))?$object->covering_comments:''}}" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="covering_price" name="covering_price" class="form-control" value="{{(isset($object) && $object->covering_price)?$object->covering_price:''}}" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Singapore Port Health ( Export / Transit )
                        </td>
                        <td>
                            <input type="text" id="export_selection" name="export_selection" class="form-control" value="{{(isset($object))?$object->export_selection:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="export_comments" name="export_comments" class="form-control" value="{{(isset($object))?$object->export_comments:''}}" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="export_price" name="export_price" class="form-control" value="{{(isset($object) && $object->export_price)?$object->export_price:''}}" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Airfreight Charges ( Ashes / Remains ) / Delivery Airport
                        </td>
                        <td>
                            <input type="text" id="airport_charges_selection" name="airport_charges_selection" class="form-control" value="{{(isset($object))?$object->airport_charges_selection:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="airport_charges_comments" name="airport_charges_comments" class="form-control" value="{{(isset($object))?$object->airport_charges_comments:''}}" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="airport_charges_price" name="airport_charges_price" class="form-control" value="{{(isset($object) && $object->airport_charges_price)?$object->airport_charges_price:''}}" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Professional services
                        </td>
                        <td>
                            <input type="text" id="pro_services_selection" name="pro_services_selection" class="form-control" value="{{(isset($object))?$object->pro_services_selection:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="pro_services_comments" name="pro_services_comments" class="form-control" value="{{(isset($object))?$object->pro_services_comments:''}}" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="pro_services_price" name="pro_services_price" class="form-control" value="{{(isset($object) && $object->pro_services_price)?$object->pro_services_price:''}}" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Disposal of Coffin
                        </td>
                        <td>
                            <input type="text" id="coffin_disposal_selection" name="coffin_disposal_selection" class="form-control" value="{{(isset($object))?$object->coffin_disposal_selection:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="coffin_disposal_comments" name="coffin_disposal_comments" class="form-control" value="{{(isset($object))?$object->coffin_disposal_comments:''}}" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="coffin_disposal_price" name="coffin_disposal_price" class="form-control" value="{{(isset($object) && $object->coffin_disposal_price)?$object->coffin_disposal_price:''}}" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Rituals & rites
                        </td>
                        <td>
                            <input type="text" id="rituals_selection" name="rituals_selection" class="form-control" value="{{(isset($object))?$object->rituals_selection:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="rituals_comments" name="rituals_comments" class="form-control" value="{{(isset($object))?$object->rituals_comments:''}}" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="rituals_price" name="rituals_price" class="form-control" value="{{(isset($object) && $object->rituals_price)?$object->rituals_price:''}}" />
                        </td>
                    </tr>
                    
                    
                    
                    <?php // SALE ITEMS  ------------------------------------------------------------------ ?>
                    <?php $i = 0;?>
                    <?php foreach($sales_items as $package => $selections):?>
                    <tr>
                        <td>
                           
                            <?php if(isset($package)){
                                if($package == "Coffin"){ 
                                    echo ("<a href='#' id='view_coffin_with_popup'>".$package."</a>");
                                }else {
                                    echo $package;
                                }
                            }else{ 
                                echo "";
                                
                            }
                            ?>
                            <input type="hidden" name="si_package[]" value="<?php echo $package?>" />
                        </td>
                        <td>
                            <?php 
                                $saved_si_selection_item = $saved_si_price = $saved_si_remarks = "";
                                if (isset($si) && isset($si[$package])):
                                    $saved_si_selection_item = (isset($si[$package]["selection_item"]))?$si[$package]["selection_item"]:'';
                                    $saved_si_price = (isset($si[$package]["price"]))?$si[$package]["price"]:'';
                                    $saved_si_remarks = (isset($si[$package]["remarks"]))?$si[$package]["remarks"]:'';
                                endif;
                            ?>
                            <select id="si_selection_item_<?php echo $i?>" name="si_selection_item[]" class="form-control">
                                <option></option>
                                <?php foreach($selections as $key => $group):?>
                                <optgroup label="{{$key}}">
                                    <?php foreach($group as $item):?>
                                        <option value="<?php echo $item["id"]?>" data-price="<?php echo $item["unit_price"]?>"  <?php echo ($item["selection_item_id"] == $saved_si_selection_item)?"selected='selected'":''?>>
                                            <?php 
                                                $product = App\Products::find($item["selection_item_id"]);
                                                if ($product){
                                                    echo $product->item;
                                                }
                                                else{
                                                    echo $item["selection_item_name"];
                                                }

                                            ?>
                                        </option>
                                    <?php endforeach;?>
                                </optgroup>
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td colspan="3"><input type="text" class="form-control" id="si_remarks_<?php echo $i?>" name="si_remarks[]" value="<?php echo $saved_si_remarks;?>" /></td>
                        <td class="price_col">
                            <div></div><input type="number" min="0.01" step="0.01" class="form-control" id="si_price_<?php echo $i?>" disabled="disabled" value="<?php echo $saved_si_price;?>" />
                            <input type="hidden" class="form-control" id="si_price_save_<?php echo $i?>" name="si_price[]" value="<?php echo $saved_si_price;?>" />
                        </td>
                    </tr>
                    <?php $i++;?>
                    <?php endforeach;?>
                    
                    
                    
                    
                    
                    <tr>
                        <td>
                            Miscellaneous
                        </td>
                        <td>
                            <input type="text" id="miscellaneous_selection_1" name="miscellaneous_selection_1" class="form-control" value="{{(isset($object))?$object->miscellaneous_selection_1:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="miscellaneous_comments_1" name="miscellaneous_comments_1" class="form-control" value="{{(isset($object))?$object->miscellaneous_comments_1:''}}" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="miscellaneous_price_1" name="miscellaneous_price_1" class="form-control" value="{{(isset($object) && $object->miscellaneous_price_1)?$object->miscellaneous_price_1:''}}" />
                        </td>
                    </tr>
                    <?php /*
                    <?php if (is_array($other_purchased_items)):?>
                    <?php foreach($other_purchased_items as $items):?>
                    <tr>
                        <td>
                            <input type="text" id="more_name" name="more_name[]" class="form-control" value="<?php echo (isset($items["name"]))?$items["name"]:""?>" />
                        </td>
                        <td>
                            <input type="text" id="more_selection" name="more_selection[]" class="form-control" value="<?php echo (isset($items["selection"]))?$items["selection"]:""?>" />
                        </td>
                        
                        <td>
                            <input type="text" id="more_comments" name="more_comments[]" class="form-control" value="<?php echo (isset($items["comments"]))?$items["comments"]:""?>" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="more_price" name="more_price[]" class="form-control" value="<?php echo (isset($items["price"]))?$items["price"]:""?>" />
                        </td>
                    </tr>
                    <?php endforeach;?>
                    <?php endif;?>
                    
                    <tr id="repatriation_add_more_default" style="display:none">
                        <td>
                            <input type="text" id="more_name" name="more_name[]" class="form-control" value="" />
                        </td>
                        <td>
                            <input type="text" id="more_selection" name="more_selection[]" class="form-control" value="" />
                        </td>
                        
                        <td>
                            <input type="text" id="more_comments" name="more_comments[]" class="form-control" value="" />
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="more_price" name="more_price[]" class="form-control" value="" />
                        </td>
                    </tr>
                    
                    */?>
                    
                    <?php // MORE PACKS ----------------------------------------------------- ?>
                    <?php if (isset($mp)):?>
                    <?php $inc = 0;?>
                    <?php foreach($mp as $package => $other_item):?>
                    <tr>
                        <td>
                            <select id="more_package_name_{{$inc}}" name="more_package_name[]" class="form-control">
                                <?php $sel = 1;?>
                                <?php foreach($sales_items as $list_package => $selections):?>
                                    <option value="{{$list_package}}|<?php echo $sel++;?>" <?php echo ($list_package == $package)?'selected="selected"':''?>><?php echo $list_package?></option>    
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td>
                            <?php $sel = 1;?>
                            <?php foreach($sales_items as $list_package => $selections):?>
                            
                            <?php 
                                $saved_mp_selection_item = $saved_mp_price = $saved_mp_remarks = "";
                                
                                if (isset($si) && isset($si[$list_package])):
                                    $saved_mp_selection_item = (isset($mp[$package]["selection_item"]))?$mp[$package]["selection_item"]:'';
                                    $saved_mp_price = (isset($mp[$package]["price"]))?$mp[$package]["price"]:'';
                                    $saved_mp_remarks = (isset($mp[$package]["remarks"]))?$mp[$package]["remarks"]:'';
                                endif;
                            ?>
                            
                            <select id="more_package_selection_item_<?php echo $sel;?>_{{$inc}}" name="more_package_selection_<?php echo $sel;?>_item[]" class="form-control" <?php echo ($list_package == $package)?'':'style="display:none"'?>>
                                <option></option>
                                <?php foreach($selections as $key => $group):?>
                                <optgroup label="{{$key}}">
                                    <?php foreach($group as $item):?>
                                        <option value="<?php echo $item["selection_item_id"]?>" data-price="<?php echo $item["unit_price"]?>"  <?php echo ($list_package == $package && $item["selection_item_id"] == $saved_mp_selection_item)?'selected="selected"':''?>>
                                            <?php 
                                                $product = App\Products::find($item["selection_item_id"]);
                                                if ($product){
                                                    echo $product->item;
                                                }
                                                else{
                                                    echo $item["selection_item_name"];
                                                }

                                            ?>
                                        </option>
                                    <?php endforeach;?>
                                </optgroup>
                                <?php endforeach;?>
                            </select>
                            <?php $sel++; ?>
                            <?php endforeach;?>
                        </td>
                        <td colspan="3"><input type="text" class="form-control" id="more_package_remarks_{{$inc}}" name="more_package_remarks[]" value="<?php echo $saved_mp_remarks;?>" /></td>
                        <td class="price_col">
                            <div></div><input type="number" min="0.01" step="0.01" class="form-control" id="more_package_price_{{$inc}}" disabled="disabled" value="<?php echo $saved_mp_price;?>" />
                            <input type="hidden" class="form-control" id="more_package_price_save_{{$inc}}" name="more_package_price[]" value="<?php echo $saved_mp_price;?>" />
                        </td>
                    </tr>
                    <?php $inc++;?>
                    <?php endforeach;?>
                    <?php endif;?>
                    
                    
                    
                    
                    
                    
                    <tr id="draft_add_package" style="display:none">
                        <td>
                            <select id="more_package_name_0" name="more_package_name[]" class="form-control">
                                <?php $sel = 1;?>
                                <?php foreach($sales_items as $package => $selections):?>
                                    <option value="{{$package}}|<?php echo $sel++;?>">{{$package}}</option>    
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td>
                            <?php $sel = 1;?>
                            <?php foreach($sales_items as $package => $selections):?>
                                   
                            <select id="more_package_selection_item_{{$sel}}_0" name="more_package_selection_{{$sel}}_item[]" class="form-control" <?php echo ( $sel > 1 )?'style="display:none"':''?>>
                                <option></option>
                                <?php foreach($selections as $key => $group):?>
                                <optgroup label="{{$key}}">
                                    <?php foreach($group as $item):?>
                                        <option value="<?php echo $item["selection_item_id"]?>" data-price="<?php echo $item["unit_price"]?>" >
                                            <?php 
                                                $product = App\Products::find($item["selection_item_id"]);
                                                if ($product){
                                                    echo $product->item;
                                                }
                                                else{
                                                    echo $item["selection_item_name"];
                                                }

                                            ?>
                                        </option>
                                    <?php endforeach;?>
                                </optgroup>
                                <?php endforeach;?>
                            </select>
                            <?php $sel++?>
                            <?php endforeach;?>
                        </td>
                        <td colspan="3"><input type="text" class="form-control" id="more_package_remarks_0" name="more_package_remarks[]" value="" /></td>
                        <td class="price_col">
                            <div></div><input type="number" min="0.01" step="0.01" class="form-control" id="more_package_price_0" disabled="disabled" value="" />
                            <input type="hidden" class="form-control" id="more_package_price_save_0" name="more_package_price[]" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td  colspan="6">
                            <a href="#" id="add_package">Click to add</a>
                        </td>
  
                    </tr>
                    
                    <tr>
                        <td>
                            Miscellaneous
                        </td>
                        <td>
                            <select id="miscellaneous_selection" name="miscellaneous_selection_2" class="form-control">
                                <option></option>
                                @if ($discounts)
                                    @foreach($discounts as $discount)
                                    <option value="{{$discount}}">Discount {{$discount}}%</option>
                                    @endforeach
                                @endif
                                <option value="special_discount" <?php echo (isset($object) && $object->miscellaneous_selection_2 == "special_discount")?'selected="selected"':''?>>Special Discount</option>
                            </select>
                            
                            
                            <input type="hidden" id="miscellaneous_amount" name="miscellaneous_amount" value="{{$object->miscellaneous_amount}}" />
                            <input type="hidden" id="miscellaneous_approving_supervisor" name="miscellaneous_approving_supervisor" value="{{$object->miscellaneous_approving_supervisor}}" />
                            <input type="hidden" id="miscellaneous_approval_code" name="miscellaneous_approval_code" value="{{$object->miscellaneous_approval_code}}" />
                        </td>
                        
                        <td  colspan="3"></td>
                        <td>
                            <span id="total"></span>
                            <input type="hidden" id="total_input" name="total_step_3" />
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            
            <br /><br />
            <input type="hidden" id="go_to_step" name="go_to_step" value="" />
            <table style="width: 100%">
                <tr>
                    <td>
                        <a class="btn btn-primary" id="back_button" /><i class="fa fa-backward"></i> &nbsp;Previous</a>
                    </td>
                    <td colspan="3" style="text-align: right;">
                        <a class="btn btn-primary" id="next_bttn" /> Next &nbsp;<i class="fa fa-forward"></i></a>
                    </td>
                </tr>
            </table>
            <br />
            <br />
        </div>
    </div>
</form>


<div class="modal fade" id="special_discount_popup" tabindex="-1" role="dialog" style="display:none">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Special Discount</h4>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <table class="discount_popup_table">
                        <tr>
                            <td><label class="control-label" for="inputWarning1">Amount</label></td>
                            <td>$</td>
                            <td><input type="text" id="discount_amount" name="discount_amount" value="" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td><label class="control-label" for="inputWarning1">Approving supervisor</label></td>
                            <td></td>
                            <td><input type="text" id="approving_supervisor" name="approving_supervisor" value="{{$user->getSupervisor()}}" disabled="disabled" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td><label class="control-label" for="inputWarning1">Approval code</label></td>
                            <td></td>
                            <td><input type="text" id="approval_code" name="approval_code" value="{{$object->approval_code}}" class="form-control" /></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submit_bttn">SUBMIT</button>
            </div>

        </div>
    </div>
</div>
<!-- For point 2-->
<div class="modal fade" id="add_far_popup" tabindex="-1" role="dialog" style="overflow:scroll">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gem_stones_title">Add Gemstone</h4>
            </div>

            <div class="modal-body">

            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-default selected-item-ok" >OK</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="view_all_images_for_ala_carte" tabindex="-1" role="dialog" style="z-index:22222">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
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
<div class="modal fade" id="general_popup" tabindex="-1" role="dialog" style="overflow:scroll">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>

            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="cancel_general_bttn">Cancel</button>
                <button type="button" class="btn btn-primary" id="save_general_bttn">Save</button>
            </div>

        </div>
    </div>
</div>