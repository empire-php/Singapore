<form action="{{ URL::to('/fa/saveForm') }}"  id="info_frm" class="master_form" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="hidden" name="generated_code" value="{{ $object->generated_code }}" />
    <input type="hidden" name="faid" id="faid" value="{{ $object->id }}" />
    <input type="hidden" name="step" id="step" value="{{$step}}" />
    <input type="hidden" name="changes_made" id="changes_made" value="" />
    
    
    
    <div id="fa_form" class="needs_exit_warning">
        <div class="fa_section">
            <div class="form_title">Purchase Summary</div>
            <table class="table table-striped table-bordered" style="margin-top: 30px">
                <thead>
                    <tr>
                        <th>
                            Package
                        </th>
                        <th style="width: 360px">
                            Selection Item
                        </th>
                        <th colspan="5">
                            Comments
                        </th>
                        <th style="min-width: 120px">
                            Amount
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php // ALA CARTE --------------------------------------- ?>
                    <?php $i = 0;?>

                    <?php foreach($items as $category => $selections):?>
                     <?php
                        $saved_ac_selection_item = $saved_ac_price = $saved_ac_remarks = "";
                        if (isset($ac) && isset($ac[$category])):
                            $saved_ac_selection_item = (isset($ac[$category]["selection_item"]))?$ac[$category]["selection_item"]:"";
                            $saved_ac_price = (isset($ac[$category]["price"]))?$ac[$category]["price"]:"";
                            $saved_ac_remarks = (isset($ac[$category]["remarks"]))?$ac[$category]["remarks"]:"";
                    ?>
                    @if($saved_ac_price > 0)
                    <tr class="">
                        <td>
                            <?php echo (isset($category_names[$category]))?$category_names[$category]:""?>
                            <input type="hidden" name="ac_category[]" value="<?php echo $category?>" />
                        </td>
                        <td>

                            <select id="ac_selection_item_<?php echo $i?>" name="ac_selection_item[]" class="form-control" disabled="">
                                <option></option>
                                <?php foreach($selections as $key => $group):?>
                                <optgroup label="{{$key}}">
                                    <?php foreach($group as $item):?>
                                    <!--for point 2 replace 'selection_item_id to 'id'-->
                                        <option value="<?php echo $item["id"]?>" data-price="<?php echo $item["unit_price"]?>"  <?php echo ($item["id"] == $saved_ac_selection_item)?'selected="selected"':''?>>
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

                        <td colspan="5"><textarea disabled="disabled" class="form-control"><?php echo $saved_ac_remarks;?></textarea></td>
                        <td class="price_col">
                            <div></div><input type="number" min="0.01" step="0.01" class="form-control" disabled="disabled" value="{{ number_format((float)$saved_ac_price, 2, '.', '') }}" />
                        </td>
                    </tr>
                    @endif
                    <?php $i++;?>
                    <?php endif;?>
                    <?php endforeach;?>
                    
                    
                    <?php // SALE ITEMS  ------------------------------------------------------------------ ?>
                    <?php $i = 0;?>
                    <?php foreach($sales_items as $package => $selections):?>
                    <?php
                        $saved_si_selection_item = $saved_si_price = $saved_si_remarks = "";
                        if (isset($si) && isset($si[$package])):
                            $saved_si_selection_item = (isset($si[$package]["selection_item"]))?$si[$package]["selection_item"]:'';
                            $saved_si_price = (isset($si[$package]["price"]))?$si[$package]["price"]:'';
                            $saved_si_remarks = (isset($si[$package]["remarks"]))?$si[$package]["remarks"]:'';
                        endif;
                    ?>
                    @if($saved_si_price > 0)
                    <tr>
                        <td>
                            <?php echo (isset($package))?$package:""?>
                            <input type="hidden" name="si_package[]" value="<?php echo $package?>" />
                        </td>
                        <td>

                            <select id="si_selection_item_<?php echo $i?>" name="si_selection_item[]" class="form-control">
                                <option></option>
                                <?php foreach($selections as $key => $group):?>
                                <optgroup label="{{$key}}">
                                    <?php foreach($group as $item):?> <!--for point 2 -->
                                        <option value="<?php echo $item["id"]?>" data-price="<?php echo $item["unit_price"]?>"  <?php echo ($item["id"] == $saved_si_selection_item)?'selected="selected"':''?>>
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
                        <td colspan="5">
                            <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;" id="si_remarks_<?php echo $i?>" name="si_remarks[]"><?php echo $saved_si_remarks;?>"</textarea></td>
                        <td class="price_col">
                            <div></div><input type="number" min="0.01" step="0.01" class="form-control" id="si_price_<?php echo $i?>" disabled="disabled" value="{{ number_format((float)$saved_si_price, 2, '.', '') }}" />
                            <input type="hidden" class="form-control" id="si_price_save_<?php echo $i?>" name="si_price[]" value="{{ number_format((float)$saved_si_price, 2, '.', '') }}" />
                        </td>
                    </tr>
                    @endif
                    <?php $i++;?>
                    <?php endforeach;?>

                    <?php // PARLOURS ?>
                    <?php if (isset($parlours)):?>
                    <?php for( $i = 0; $i < count($parlours); $i++):?>
                    <tr id="parlour_row_<?php echo $i;?>">
                        <td>
                            Parlour
                        </td>
                        <td>
                            <input type="text" disabled="disabled" id="parlour_name_<?php echo $i;?>" name="parlour_name[]" class="form-control" value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_name"]))?$parlours[$i]["parlour_name"]:""?>" />
                        </td>
                        
                        <td colspan="5">
                            <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;">@if(!empty($parlours[$i]["parlour_remarks"])){{ $parlours[$i]["parlour_remarks"] }}@else From <?php echo (isset($parlours) && isset($parlours[$i]["parlour_from_date"]))?$parlours[$i]["parlour_from_date"].' '.$parlours[$i]["parlour_from_time"] :""?> To <?php echo (isset($parlours) && isset($parlours[$i]))?$parlours[$i]["parlour_to_date"]. " " .$parlours[$i]["parlour_to_time"]:""?>@endif</textarea>
                        </td>
                        <td class="price_col">
                            <div></div><input type="number" min="0.01" step="0.01"s class="form-control" disabled="disabled" value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_total_price"]))?$parlours[$i]["parlour_total_price"]:""?>" />
                        </td>
                    </tr>
                    <?php endfor;?>
                    <?php endif;?> 

                    @if(isset($hearse_name) && !empty($hearse_name))
                    <tr>
                        <td>
                            Hearse
                        </td>
                        <td>
                            <input type="text" disabled="disabled" class="form-control"  value="{{(isset($hearse_name))?$hearse_name:''}}" />
                        </td>
                        
                        <td colspan="5">
                            <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($hearse_remarks))?$hearse_remarks:''}}</textarea>
                        </td>
                        <td class="price_col">
                            <div></div><input type="number" min="0.01" step="0.01" class="form-control" disabled="disabled" value="{{number_format(floatval($hearse_price),2, '.', '')}}" />
                        </td>
                    </tr>
                    @endif

                    @if(isset($cck_slab_stand_price) && $cck_slab_stand_price > 0)
                        <tr>
                            <td>
                                CCK - Slab & Stand
                            </td>
                            <td>
                                <input type="text" disabled="disabled" class="form-control"  value="{{(isset($cck_slab_stand))?$cck_slab_stand:''}}" />
                            </td>

                            <td colspan="5">
                                <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($cck_slab_stand_remarks))?$cck_slab_stand_remarks:''}}</textarea>
                            </td>
                            <td class="price_col">
                                <div></div><input type="number" min="0.01" step="0.01" class="form-control" disabled="disabled" value="{{number_format(floatval($cck_slab_stand_price),2, '.', '')}}" />
                            </td>
                        </tr>
                    @endif

                    @if(isset($charcoal_lime_price) && $charcoal_lime_price > 0)
                        <tr>
                            <td>
                                Charcoal & Lime
                            </td>
                            <td>
                                <input type="text" disabled="disabled" class="form-control"  value="{{(isset($charcoal_lime))?$charcoal_lime:''}}" />
                            </td>

                            <td colspan="5">
                                <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($charcoal_lime_remarks))?$charcoal_lime_remarks:''}}</textarea>
                            </td>
                            <td class="price_col">
                                <div></div><input type="number" min="0.01" step="0.01" class="form-control" disabled="disabled" value="{{number_format(floatval($charcoal_lime_price),2, '.', '')}}" />
                            </td>
                        </tr>
                    @endif

                    @if(isset($obituary) && !empty($obituary))
                        <tr>
                            <td>
                                Obituary Posting in newspapers
                            </td>
                            <td>
                                <input type="text" disabled="disabled" class="form-control"  value="{{(isset($obituary))?$obituary:''}}" />
                            </td>

                            <td colspan="5">
                                <?php
                                    $text = "Arranged By - ";
                                    if (!empty($obituary_arranged_by)){
                                        $arrSel = explode(",",$obituary_arranged_by);
                                    }
                                    $arranged_by = App\User::whereIn('id', $arrSel)->get();
                                    foreach($arranged_by as $arr)
                                        $text .= "[".$arr->name."] ";

                                    $text .= "\nFollowed-Up By - ";

                                    if (!empty($obituary_followed_up_by)){
                                        $arrSel = explode(",",$obituary_followed_up_by);
                                    }
                                    $arranged_by = App\User::whereIn('id', $arrSel)->get();
                                    foreach($arranged_by as $arr)
                                    $text .= "[".$arr->name."] ";

                                ?>
                                <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;">{{$text}}</textarea>
                            </td>
                            <td class="price_col">
                                <div></div><input type="number" min="0.01" step="0.01" class="form-control" disabled="disabled" value="{{number_format(floatval($obituary_price),2, '.', '')}}" />
                            </td>
                        </tr>
                    @endif

                    @if(isset($highrise_apartment_price) && $highrise_apartment_price > 0)
                        <tr>
                            <td>
                                Highrise Apartment (3rd Floor Upwards)
                            </td>
                            <td>
                                <input type="text" disabled="disabled" class="form-control"  value="{{(isset($highrise_apartment))?$highrise_apartment:''}}" />
                            </td>

                            <td colspan="5">
                                <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($highrise_apartment_remarks))?$highrise_apartment_remarks:''}}</textarea>
                            </td>
                            <td class="price_col">
                                <div></div><input type="number" min="0.01" step="0.01" class="form-control" disabled="disabled" value="{{number_format(floatval($highrise_apartment_price),2, '.', '')}}" />
                            </td>
                        </tr>
                    @endif

                    @if(isset($collection_from_price) && $collection_from_price > 0)
                        <tr>
                            <td>
                                Collection From
                            </td>
                            <td>
                                <input type="text" disabled="disabled" class="form-control"  value="{{(isset($collection_from))?$collection_from:''}}" />
                            </td>

                            <td colspan="5">
                                <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($collection_from_remarks))?$collection_from_remarks:''}}</textarea>
                            </td>
                            <td class="price_col">
                                <div></div><input type="number" min="0.01" step="0.01" class="form-control" disabled="disabled" value="{{number_format(floatval($collection_from_price),2, '.', '')}}" />
                            </td>
                        </tr>
                    @endif

                    @if(isset($port_health_permit_price) && $port_health_permit_price > 0)
                        <tr>
                            <td>
                                Port Health Permit
                            </td>
                            <td>
                                <input type="text" disabled="disabled" class="form-control"  value="{{(isset($port_health_permit))?$port_health_permit:''}}" />
                            </td>

                            <td colspan="5">
                                <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($port_health_permit_remarks))?$port_health_permit_remarks:''}}</textarea>
                            </td>
                            <td class="price_col">
                                <div></div><input type="number" min="0.01" step="0.01" class="form-control" disabled="disabled" value="{{number_format(floatval($port_health_permit_price),2, '.', '')}}" />
                            </td>
                        </tr>
                    @endif

                    @if(isset($disposal_of_coffin_price) && $disposal_of_coffin_price > 0)
                        <tr>
                            <td>
                                Disposal of coffin
                            </td>
                            <td>
                                <input type="text" id="disposal_coffin" name="disposal_coffin" class="form-control" value="{{(isset($disposal_of_coffin))?$disposal_of_coffin:''}}" />
                            </td>

                            <td colspan="5">
                                <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;" id="disposal_coffin_remarks" name="disposal_coffin_remarks">{{(isset($disposal_of_coffin_remarks))?$disposal_of_coffin_remarks:''}}</textarea>
                            </td>
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" id="disposal_coffin_price" name="disposal_coffin_price" class="form-control" value="{{(isset($disposal_of_coffin_price))?$disposal_of_coffin_price:''}}" />
                            </td>
                        </tr>
                    @endif

                    @if(isset($burial_price) && $burial_price > 0 )
                        <tr>
                            <td>
                                Burial
                            </td>
                            <td>
                                <input type="text" disabled="disabled" class="form-control"  value="{{(isset($burial))?$burial:''}}" />
                            </td>

                            <td colspan="5">
                                <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($burial_remarks))?$burial_remarks:''}}</textarea>
                            </td>
                            <td class="price_col">
                                <div></div><input type="number" min="0.01" step="0.01" class="form-control" disabled="disabled" value="{{number_format(floatval($burial_price),2, '.', '')}}" />
                            </td>
                        </tr>
                    @endif

                    @if($object->package_total > 0)
                    <tr>
                        <td>
                            FA Package
                        </td>
                        <td>
                            <textarea disabled="disabled" class="form-control" style="width: 100%;overflow: auto; min-height: 100px;">[{{ $selected_package->category }}] - [{{$selected_package->name}}] - [${{$selected_package->promo_price}}]</textarea>
                        </td>
                        
                        <td colspan="5">
                            <?php $item_text = ""; ?>
                            @foreach($selected_package_items as $selected_package_item)
                                <?php
                                $package_item = App\PackageItems::find($selected_package_item);
                                $item_text .= $package_item->selection_category.' - '.$package_item->selection_item_name;
                                if($package_item->add_on_price>0)
                                $item_text .= "(Add on: $".$package_item->add_on_price.")";
                                $item_text .= "\n";
                                ?>
                            @endforeach
                            <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 100px;">{{$item_text}}</textarea>
                        </td>
                        <td class="price_col">
                            <div></div><input type="number" min="0.01" step="0.01" class="form-control" disabled="disabled" value="{{number_format($object->package_total, 2, '.', '')}}" />
                        </td>
                    </tr>
                    @endif
                    
                    <tr>
                        <td>
                            Columbarium Order
                        </td>
                        <td>
                            <input type="text" id="columbarium_order_number" name="columbarium_order_number" class="form-control" value="{{(isset($columbarium_order_number))?$columbarium_order_number:''}}" />
                            <input type="hidden" id="columbarium_order_id" name="columbarium_order_id" value="{{(isset($columbarium_order_id))?$columbarium_order_id:''}}" />
                        </td>
                        <td><input type="text" id="columbarium_order_remarks" name="columbarium_order_remarks" class="form-control" value="{{(isset($columbarium_order_remarks))?$columbarium_order_remarks:''}}" /></td>
                        <td>Arranged by:</td>
                        <td>    
                            <select class="form-control" name="columbarium_order_arranged_by[]" data-toggle="select2" multiple class="form-control">
                                <?php 
                                    foreach ($users as $u): 
                                        if (!empty($columbarium_order_arranged_by)){
                                            $arrSel = explode(",",$columbarium_order_arranged_by);
                                        }
                                        else{
                                            $arrSel = array($user->id);
                                        }
                                ?>
                                    <option value="{{ $u->id }}"
                                            @if (in_array($u->id,$arrSel) && !empty($columbarium_order_number))
                                            selected="selected"
                                            @endif
                                            >
                                        {{ $u->name }}
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td>Followed-up by:</td>
                        <td>
                            <select class="form-control" name="columbarium_order_followed_up_by[]" data-toggle="select2" multiple class="form-control">
                                <?php 
                                    foreach ($users as $u): 
                                        if (!empty($columbarium_order_followed_up_by)){
                                            $arrSel = explode(",",$columbarium_order_followed_up_by);
                                        }
                                        else{
                                            $arrSel = array($user->id);
                                        }
                                ?>

                                    <option value="{{ $u->id }}"
                                            @if (in_array($u->id, $arrSel) && !empty($columbarium_order_number))
                                            selected="selected"
                                            @endif
                                            >
                                        {{ $u->name }}
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="columbarium_price" name="columbarium_price" class="form-control" value="{{(isset($columbarium_price))? number_format(floatval($columbarium_price), 2, '.', '') :''}}" />
                        </td>
                    </tr>

                    @if(isset($cremation_fee_price) && $cremation_fee_price > 0)
                    <tr>
                        <td>
                            Cremation Fee
                        </td>
                        <td>
                            <input type="text" id="cremation_fee" name="cremation_fee" class="form-control" value="{{(isset($cremation_fee))?$cremation_fee:''}}" />
                        </td>
                        
                        <td colspan="5">
                            <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;" id="cremation_fee_remarks" name="cremation_fee_remarks">{{(isset($cremation_fee_remarks))?$cremation_fee_remarks:''}}</textarea>
                        </td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="cremation_fee_price" name="cremation_fee_price" class="form-control" value="{{(isset($cremation_fee_price))?$cremation_fee_price:''}}" />
                        </td>
                    </tr>
                    @endif


                    @if(isset($night_care_price) && $night_care_price > 0)
                    <tr>
                        <td>
                            Night Care service team ( services )
                        </td>
                        <td>
                            <input type="text" id="night_care" name="night_care" class="form-control" value="{{(isset($night_care))?$night_care:''}}" /> 
                        </td>
                        
                        <td colspan="5">
                            <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;" id="night_care_remarks" name="night_care_remarks">{{(isset($night_care_price))?$night_care_price:''}}</textarea>
                        </td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="night_care_price" name="night_care_price" class="form-control" value="{{(isset($night_care_price))?$night_care_price:''}}" />
                        </td>
                    </tr>
                    @endif

                    <tr>
                        <td>
                            Gem stone
                        </td>
                        <td>
                            <input type="text" id="gemstone_order_number" name="gemstone_order_number" class="form-control" value="{{(isset($gemstone_order_number))?$gemstone_order_number:''}}" /> <!-- autocomplete -->
                            <input type="hidden" id="gemstone_order_id" name="gemstone_order_id" value="{{(isset($gemstone_order_id))?$gemstone_order_id:''}}" />
                        </td>
                        
                        <td>
                            <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;"  id="gemstone_order_remarks" name="gemstone_order_remarks">{{(isset($gemstone_order_remarks))?$gemstone_order_remarks:''}}</textarea>
                        </td>
                        <td>Arranged by:</td>
                        <td>    
                            <select class="form-control" name="gemstone_order_arranged_by[]" data-toggle="select2" multiple class="form-control">
                                <?php 
                                    foreach ($users as $u): 
                                        if (!empty($gemstone_order_arranged_by)){
                                            $arrSel = explode(",",$gemstone_order_arranged_by);
                                        }
                                        else{
                                            $arrSel = array($user->id);
                                        }
                                ?>
                                    <option value="{{ $u->id }}"
                                            @if (in_array($u->id,$arrSel) && !empty($gemstone_order_number))
                                            selected="selected"
                                            @endif
                                            >
                                        {{ $u->name }}
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td>Followed-up by:</td>
                        <td>
                            <select class="form-control" name="gemstone_order_followed_up_by[]" data-toggle="select2" multiple class="form-control">
                                <?php 
                                    foreach ($users as $u): 
                                        if (!empty($gemstone_order_followed_up_by)){
                                            $arrSel = explode(",",$gemstone_order_followed_up_by);
                                        }
                                        else{
                                            $arrSel = array($user->id);
                                        }
                                ?>

                                    <option value="{{ $u->id }}"
                                            @if (in_array($u->id, $arrSel) && !empty($gemstone_order_number))
                                            selected="selected"
                                            @endif
                                            >
                                        {{ $u->name }}
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="gemstone_order_price" name="gemstone_order_price" class="form-control" value="{{(isset($gemstone_order_price))?$gemstone_order_price:''}}" />
                        </td>
                    </tr>

                    
                    
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
                                        <option value="<?php echo $item["id"]?>" data-price="<?php echo $item["unit_price"]?>" >
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
                        <td colspan="5">
                            <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;" id="more_package_remarks_0" name="more_package_remarks[]"></textarea>
                        </td>
                        <td class="price_col">
                            <div></div><input type="number" min="0.01" step="0.01" class="form-control" id="more_package_price_0" disabled="disabled" value="" />
                            <input type="hidden" class="form-control" id="more_package_price_save_0" name="more_package_price[]" value="" />
                        </td>
                    </tr>


                    @if(isset($others) && count($others) > 0)
                        @for($i=0; $i<count($others); $i++)
                            @if($others[$i]['price'] > 0)
                            <tr id="other_row">
                                <td>
                                    Others
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="others_{{$i+1}}" name="others[]" value="{{$others[$i]['title']}}" />
                                </td>
                                <td colspan="5">
                                    <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 30px;" id="others_remarks_{{$i+1}}" name="others_remarks[]">{{$others[$i]['remarks']}}</textarea>
                                </td>
                                <td class="price_col">
                                    <input type="number" min="0.01" step="0.01" class="form-control" id="others_price_{{$i+1}}" name="others_price[]" value="{{$others[$i]['price']}}" />
                                </td>
                            </tr>
                            @endif
                        @endfor
                    @endif
                    
                    
                    <tr>
                        <td  colspan="8">
                            <a href="#" id="add_package">Click to add</a>
                        </td>
  
                    </tr>
                    
                    <tr>
                        <td>
                            Miscellaneous
                        </td>
                        <td>
                            <select id="miscellaneous_selection" name="miscellaneous" class="form-control">
                                <option></option>
                                @if ($discounts)
                                    @foreach($discounts as $discount)
                                    <option value="{{$discount}}">Discount {{$discount}}%</option>
                                    @endforeach
                                @endif
                                <option value="5">Coffin Discount 5%</option>
                                <option value="special_discount" <?php echo (isset($miscellaneous) && $miscellaneous == "special_discount")?'selected="selected"':''?>>Special Discount</option>
                            </select>
                            
                            
                            <input type="hidden" id="miscellaneous_amount" name="miscellaneous_amount" value="{{$object->miscellaneous_amount}}" />
                            <input type="hidden" id="miscellaneous_approving_supervisor" name="miscellaneous_approving_supervisor" value="{{$object->miscellaneous_approving_supervisor}}" />
                            <input type="hidden" id="miscellaneous_approval_code" name="miscellaneous_approval_code" value="{{$object->miscellaneous_approval_code}}" />
                        </td>
                        
                        <td  colspan="5"></td>
                        <td>
                           
                        </td>
                    </tr>
            <!-- For point 10 -->
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="5"><b>Total</b></td>
                        <td>
                             $<span id="total"></span>
                            <input type="hidden" id="total_input" name="total_step_3" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <br />
            <a href="#" class="btn btn-default">Generate Flower Order Form</a>
            <br /><br />
            <input type="hidden" id="go_to_step" name="go_to_step" value="" />
			<!--  coffin -price -->
			<input type="hidden" name="coffin_price" value="" />
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
