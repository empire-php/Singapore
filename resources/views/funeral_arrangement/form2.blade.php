<form action="{{ URL::to('/fa/saveForm') }}" class="master_form" id="info_frm" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="hidden" name="generated_code" value="{{ $object->generated_code }}" />
    <input type="hidden" name="faid" id="faid" value="{{ $object->id }}" />
    <input type="hidden" name="step" id="step" value="{{$step}}" />
    <input type="hidden" name="changes_made" id="changes_made" value="" />
    
    <input type="hidden" name="package_items" id="package_items" value="{{ $object->package_items }}" />
    <input type="hidden" name="package_total" id="package_total" value="{{ $object->package_total }}" />
    <input type="hidden" name="packages_stock_checked" id="packages_stock_checked" value="1" />
    
    <!--For point 9-->
    <input type="hidden" name="group_items" id="group_items" value="0" />
    <input type="hidden" name="group_items_checked" id="group_items_checked" value="" />
    
    
    <div id="fa_form" class="needs_exit_warning">
        <div style="text-align:center">
            <div class="fa_section">
                @if(Session::has('msg'))
                    <div class="alert alert-info">
                        <a class="close" data-dismiss="alert">×</a>
                        {!!Session::get('msg')!!} 
                    </div>
                @endif
                <?php Session::remove('msg'); ?>
                <div class="form_title">Packages &nbsp;&nbsp;&nbsp;<a href="#" id="open_packages">Click to open</a></div>
                <div id="package_listing">
             
                    @foreach($package_categories as $categ)
                    <div class="pack_title">{{$categ->category}}</div>
                    
                        <?php foreach(App\Packages::where("category",$categ->category)->where("is_deleted",0)->orderby("name")->get() as $package):?>
                            <div class="item <?php echo ($package->id == $selected_package)?'selected':''?>" id="box_pack_{{$package->id}}">
                                <span class="name">{{$package->name}}</span>
                                <br />
                                Original Price: ${{$package->original_price}}<br />
                                Promotional Price: <br />
                                <span class="promo_price">${{$package->promo_price}}</span>
                            </div>
                        <?php endforeach;?>
                    
                        <div style="clear:both"></div>
                    
                    @endforeach
                </div>
                
                <?php foreach(App\Packages::where("is_deleted",0)->get() as $package):?>
				
				<div class="modal fade" id="package_items_modal_{{$package->id}}" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content" style="width: 700px;">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Items</h4>
							</div>

							<div class="modal-body">
								<div class="package_items_listing" id="pack_{{$package->id}}" data-promo_price="{{$package->promo_price}}" <?php echo ($package->id != $selected_package)?'style="display:none"':''?>>
                    <div class="pack_group_title">{{$package->category}} - {{$package->name}}
                        <div style="float: right; width: 200px; font-weight: bold; font-style: normal; color:#0a0a0a">Total: $<span class="package_total_s" id="package_total_s">{{ $object->package_total }}</span></div>
                    </div>

                    <?php $packageitems =App\PackageItems::select("section_name")->where("fa_package_id",$package->id)->where("is_deleted",0)->where('selection_item_id','!=',0)->distinct()->orderby("section_name")->get(); ?>
                     <?php  $compareProduct =App\PackageItems::select("selection_item_id")->where("fa_package_id",$package->id)->where("is_deleted",0)->where('selection_item_id','!=',0)->distinct()->orderby("section_name")->get(); ?>
                     
                        <?php //var_dump($product );exit;?>
                    <?php foreach( $packageitems as $section):?>
                    <?php  //var_dump($section);exit; ?>
                    <?php //$check_data = App\Products::select("id")->where("id",$section->selection_item_id)->where("is_deleted",0)->where("warehouse","!=",0)->get();?>
                   <?php // var_dump($check_data);?>		
                    <?php // if(isset($check_data->id)) { ?>
                        <div class="item_title">{{$section->section_name}}</div>
                            <?php foreach(App\PackageItems::select("fa_package_id", "category_name")->whereRaw("section_name = '{$section->section_name}' AND fa_package_id = {$package->id} AND is_deleted = 0 ")->distinct()->orderby("category_name")->get() as $categ):?>
                               
                                
                           <div style='float:left;' class="blank_mark">
                                
                              <br>
                               <div> <?php echo $categ->category_name;?></div>

            			
                                <?php foreach(App\PackageItems::whereRaw("category_name = '{$categ->category_name}' AND section_name = '{$section->section_name}' AND fa_package_id = {$package->id} AND is_deleted = 0")->distinct()->orderby("category_name")->get() as $product):?>
                                <?php $check_data = App\Products::select("id")->where("id",$product->selection_item_id)->where("is_deleted",0)->where("warehouse","!=",0)->get()->toArray();?>
                                 <?php  if(count($check_data)>0) { ?>
				                <div style="float: left; width:180px;margin: 15px;">
                               <div class="product_box <?php echo (in_array($product->id, $selected_package_items))?'selected':''?>" id="packitem_{{$product->id}}" style="height:230px;position: relative;" >
                            <a id="product_item_<?php echo e($product->id); ?>" class="pull-right" onclick="selectPackageItemsImageView(this)" style="position: absolute;right:10px;top:10px"><span class="glyphicon glyphicon-search"></span></a>
                                        <div style="width: 100%; border-bottom: 1px solid #bbbbbb; padding: 5px;"><img src="/uploads/{{$product->image}}" style="width:100%; height: 120px;top:0;" /></div>
                                        <div style="width: 100%;padding: 5px; text-align: center">{{$product->selection_item_name}}</div>

                                        @if ($product->add_on_price > 0)
                                        Add-on price: $<span class="add_on_price">{{$product->add_on_price}}</span>
                                        @endif
                                        <div class="button" style="position: absolute;left:0;right:0;bottom:0;">SELECT</div>

                                </div>
                               <div style="width:100%; text-align:center;font-weight: bold;font-size:13px;height: auto;">{{$product->section_name}}</div>
                               </div>

                                    
                         <?php } ?>
                                    
                                <?php endforeach;?>
                                     </div>  
                            <?php endforeach;?>
                            
                            
                            <div style="clear:both"></div>
                    <?php endforeach;?>
                </div>
					
							 </div>
							<div class="modal-footer">
								
								<button type="button" class="btn btn-primary" id="save_package_bttn">Save</button>
							</div>

						</div>
					</div>
				</div>
			   <?php endforeach;?>
                
                
                
                
                <br />
                <br />
                <br />
                <div class="form_title">Ala-carte</div>
                <table class="table table-striped table-bordered" style="margin-top: 30px">
                    <thead>
                        <tr>
                            <th>
                                Category Name
                            </th>
                            <th>
                                Selection Item
                            </th>
                            <th>
                                Price
                            </th>
                            <th>
                                Remarks
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0;?>
                        <?php foreach($items as $category => $selections):?>
                        <tr>
                            <td>
                                <?php echo (isset($category_names[$category]))? "<a href='#' id=".$category_names[$category].">".$category_names[$category]."</a>":"" ?>
                                <input type="hidden" name="ac_category[]" value="<?php echo $category?>" />
                            </td>
                            <td>
                                <?php 
                                    $saved_ac_selection_item = $saved_ac_price = $saved_ac_remarks = "";
                                    if (isset($ac) && isset($ac[$category])):
                                        $saved_ac_selection_item = (isset($ac[$category]["ac_selection_item"]))?$ac[$category]["selection_item"]:'';
                                        $saved_ac_price = (isset($ac[$category]["ac_price"]))?$ac[$category]["price"]:'';
                                        $saved_ac_remarks = (isset($ac[$category]["ac_remarks"]))?$ac[$category]["remarks"]:'';
                                    endif;
                                ?>
                                <select id="ac_selection_item_<?php echo $i?>" name="ac_selection_item[]" class="form-control">
                                    <option></option>
                                    <?php foreach($selections as $key => $group):?>
                                    <optgroup label="{{$key}}">
                                        <?php foreach($group as $item):?>
                                            <option value="<?php echo $item["id"]?>" data-price="<?php echo $item["unit_price"]?>"  <?php echo ($item["selection_item_id"] == $saved_ac_selection_item)?'selected="selected"':''?>>
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
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="ac_price_<?php echo $i?>" disabled="disabled" value="<?php echo $saved_ac_price;?>" />
                                <input type="hidden" class="form-control" id="ac_price_save_<?php echo $i?>" name="ac_price[]" value="<?php echo $saved_ac_price;?>" />
                            </td>
                            <td>
                                <textarea id="ac_remarks_<?php echo $i?>" name="ac_remarks[]" class="form-control" style="width: 100%;overflow: auto; min-height: 30px;">{{$saved_ac_remarks}}</textarea>
                            </td>
                        </tr>
                        <?php $i++;?>
                        <?php endforeach;?>
                        
                        <tr>
                            <td>
                                <a href="#" id="add_hearse_bttn">Hearse</a>
                            </td>
                            <td>
                                <input type="text" id="hearse_name" name="hearse_name" class="form-control"  value="{{(isset($hearse_name))?$hearse_name:''}}" />
                                <input type="hidden" id="hearse_id" name="hearse_id" class="form-control" value="{{(isset($hearse_id))?$hearse_id:''}}" />
                                <input type="hidden" id="hearse_hours" name="hearse_hours" class="form-control" value="{{(isset($hearse_hours))?$hearse_hours:''}}" />
                                <input type="hidden" id="hearse_order_id" name="hearse_order_id" class="form-control" value="{{(isset($hearse_order_id))?$hearse_order_id:''}}" />
                            </td>
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="hearse_price" disabled="disabled" value="{{(isset($hearse_price))?$hearse_price:''}}" />
                                <input type="hidden" class="form-control" id="hearse_price_save" name="hearse_price" value="{{(isset($hearse_price))?$hearse_price:''}}" />
                                
                                <input type="hidden" class="form-control" id="hearse_unit_price" name="hearse_unit_price" value="{{(isset($hearse_unit_price))?$hearse_unit_price:''}}" />
                            </td>
                            <td>
                                <textarea id="hearse_remarks" name="hearse_remarks" class="form-control" style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($hearse_remarks))?$hearse_remarks:''}}</textarea>
                                <input type="hidden" id="hearse_from" name="hearse_from" value="{{(isset($hearse_from))?$hearse_from:''}}" />
                                <input type="hidden" id="hearse_to" name="hearse_to" value="{{(isset($hearse_to))?$hearse_to:''}}" />
                            </td>
                        </tr>
                        <?php if (isset($parlours)):?>
                        <?php for( $i = 0; $i < count($parlours); $i++):?>
                        <tr id="parlour_row_<?php echo $i;?>">
                            <td>
                                Parlour
                            </td>
                            <td>
                                <input type="text" disabled="disabled" id="parlour_name_<?php echo $i;?>" name="parlour_name[]" class="form-control" value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_name"]))?$parlours[$i]["parlour_name"]:""?>" />
                            </td>
                            <td class="price_col">
                                <input type="text" class="form-control"disabled="disabled" value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_total_price"]))?$parlours[$i]["parlour_total_price"]:""?>" />
                                <input type="hidden" class="form-control" value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_total_price"]))?$parlours[$i]["parlour_total_price"]:""?>" />
                                
                            </td>
                            <td>
                                <textarea id="parlour_remarks_<?php echo $i;?>" name="parlour_remarks[]" class="form-control" style="width: 100%;overflow: auto; min-height: 30px;">@if(!empty($parlours[$i]["parlour_remarks"])){{ $parlours[$i]["parlour_remarks"] }}@else From <?php echo (isset($parlours) && isset($parlours[$i]["parlour_from_date"]))?$parlours[$i]["parlour_from_date"].' '.$parlours[$i]["parlour_from_time"] :""?> To <?php echo (isset($parlours) && isset($parlours[$i]))?$parlours[$i]["parlour_to_date"]. " " .$parlours[$i]["parlour_to_time"]:""?>@endif</textarea>
                            </td>
                        </tr>
                        <?php endfor;?>
                        <?php endif;?> 
                        
                        <tr>
                            <td>
                                CCK - Slab & Stand
                            </td>
                            <td>
                                <input type="text" class="form-control" id="cck_slab_stand" name="cck_slab_stand" value="{{(isset($cck_slab_stand))?$cck_slab_stand:''}}" />
                            </td>
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="cck_slab_stand_price" name="cck_slab_stand_price" value="{{(isset($cck_slab_stand_price))?$cck_slab_stand_price:''}}" />
                            </td>
                            <td>
                                <textarea name="cck_slab_stand_remarks" class="form-control" style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($cck_slab_stand_remarks))?$cck_slab_stand_remarks:''}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Charcoal & Lime
                            </td>
                            <td>
                                <input type="text" class="form-control" id="charcoal_lime" name="charcoal_lime" value="{{(isset($charcoal_lime))?$charcoal_lime:''}}" />
                            </td>
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="charcoal_lime_price" name="charcoal_lime_price" value="{{(isset($charcoal_lime_price))?$charcoal_lime_price:''}}" />
                            </td>
                            <td>
                                <textarea name="charcoal_lime_remarks" class="form-control" style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($charcoal_lime_remarks))?$charcoal_lime_remarks:''}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Obituary Posting in newspapers
                            </td>
                            <td>
                                <select id="obituary" name="obituary" class="form-control">
                                    <option></option>
                                    <option value="ST" <?php echo (isset($obituary) && $obituary == "ST")?'selected="selected"':''?> >ST (Straits Times)</option>
                                    <option value="LHZB" <?php echo (isset($obituary) && $obituary == "LHZB")?'selected="selected"':''?>>LHZB (Lian He Zao Bao)</option>
                                </select>
                            </td>
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="obituary_price" name="obituary_price" value="{{(isset($obituary_price))?$obituary_price:''}}" />
                            </td>
                            <td>
                                Arranged by:
                                <select class="form-control" id="obituary_arranged_by" name="obituary_arranged_by[]" data-toggle="select2" multiple class="form-control">
                                    <?php
                                    foreach ($users as $u):
                                    if (!empty($obituary_arranged_by)){
                                        $arrSel = explode(",",$obituary_arranged_by);
                                    }
                                    else{
                                        $arrSel = array($user->id);
                                    }
                                    ?>
                                    <option value="{{ $u->id }}"
                                            @if (in_array($u->id,$arrSel) && !empty($obituary))
                                            selected="selected"
                                            @endif
                                    >
                                        {{ $u->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <br />
                                Followed-up by: 
                                <select class="form-control" id="obituary_followed_up_by" name="obituary_followed_up_by[]" data-toggle="select2" multiple class="form-control">
                                    <?php 
                                        foreach ($users as $u): 
                                            if (!empty($obituary_followed_up_by)){
                                                $arrSel = explode(",",$obituary_followed_up_by);
                                            }
                                            else{
                                                $arrSel = array($user->id);
                                            }
                                    ?>
                                    
                                        <option value="{{ $u->id }}"
                                                @if (in_array($u->id, $arrSel) && !empty($obituary))
                                                selected="selected"
                                                @endif
                                                >
                                            {{ $u->name }}
                                        </option>
                                    <?php endforeach;?>
                                </select>
                                
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Highrise Apartment (3rd Floor Upwards)
                            </td>
                            <td>
                                <input type="text" class="form-control" id="highrise_apartment" name="highrise_apartment" value="{{(isset($highrise_apartment))?$highrise_apartment:''}}" />
                            </td>
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="highrise_apartment_price" name="highrise_apartment_price" value="{{(isset($highrise_apartment_price))?$highrise_apartment_price:''}}" />
                            </td>
                            <td>
                                <textarea name="highrise_apartment_remarks" class="form-control" style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($highrise_apartment_remarks))?$highrise_apartment_remarks:''}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Collection From
                            </td>
                            <td>
                                <select id="collection_from" name="collection_from" class="form-control">
                                    <option></option>
                                    <option value="Airport" <?php echo (isset($collection_from) && $collection_from == "Airport")?'selected="selected"':''?>>Airport</option>
                                    <option value="Wharf" <?php echo (isset($collection_from) && $collection_from == "Wharf")?'selected="selected"':''?>>Wharf</option>
                                </select>
                            </td>
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="collection_from_price" name="collection_from_price" value="{{(isset($collection_from_price))?$collection_from_price:''}}" />
                            </td>
                            <td>
                                <textarea name="collection_from_remarks" class="form-control" style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($collection_from_remarks))?$collection_from_remarks:''}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Port Health Permit
                            </td>
                            <td>
                                <input type="text" class="form-control" id="port_health_permit" name="port_health_permit" value="{{(isset($port_health_permit))?$port_health_permit:''}}" />
                            </td>
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="port_health_permit_price" name="port_health_permit_price" value="{{(isset($port_health_permit_price))?$port_health_permit_price:''}}" />
                            </td>
                            <td>
                                <textarea name="port_health_permit_remarks" class="form-control" style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($port_health_permit_remarks))?$port_health_permit_remarks:''}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Disposal of Coffin
                            </td>
                            <td>
                                <input type="text" class="form-control" id="disposal_of_coffin" name="disposal_of_coffin" value="{{(isset($disposal_of_coffin))?$disposal_of_coffin:''}}" />
                            </td>
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="disposal_of_coffin_price" name="disposal_of_coffin_price" value="{{(isset($disposal_of_coffin_price))?$disposal_of_coffin_price:''}}" />
                            </td>
                            <td>
                                <textarea name="disposal_of_coffin_remarks" class="form-control" style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($disposal_of_coffin_remarks))?$disposal_of_coffin_remarks:''}}</textarea>
                            </td>
                        </tr>
                      <!-- Remove discount mark -->
                        <tr>
                            <td>
                                Burial
                            </td>
                            <td>
                                <input type="text" class="form-control" id="burial" name="burial" value="{{(isset($burial))?$burial:''}}" />
                            </td>
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="burial_price" name="burial_price" value="{{(isset($burial_price))?$burial_price:''}}" />
                            </td>
                            <td>
                                <textarea name="burial_remarks" class="form-control" style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($burial_remarks))?$burial_remarks:''}}</textarea>
                            </td>
                        </tr>

                        @if(isset($others) && count($others) > 0)
                            @for($i=0; $i<count($others); $i++)
                                <tr id="other_row_{{$i+1}}">
                                    <td>
                                        Others
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="others_{{$i+1}}" name="others[]" value="{{(isset($others[$i]['title']))?$others[$i]['title']:''}}" />
                                    </td>
                                    <td class="price_col">
                                        <input type="number" min="0.01" step="0.01" class="form-control" id="others_price_{{$i+1}}" name="others_price[]" value="{{(isset($others[$i]['price']))?$others[$i]['price']:''}}" />
                                    </td>
                                    <td>
                                        <textarea id="others_remarks_{{$i+1}}" name="others_remarks[]" class="form-control" style="width: 100%;overflow: auto; min-height: 30px;">{{(isset($others[$i]['remarks']))?$others[$i]['remarks']:''}}</textarea>
                                    </td>
                                </tr>
                            @endfor
                        @else
                            <tr id="other_row_1">
                                <td>
                                    Others
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="others_1" name="others[]" />
                                </td>
                                <td class="price_col">
                                    <input type="number" min="0.01" step="0.01" class="form-control" id="others_price_1" name="others_price[]" />
                                </td>
                                <td>
                                    <textarea id="others_remarks_1" name="others_remarks[]" class="form-control" style="width: 100%;overflow: auto; min-height: 30px;"></textarea>
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td>
                                <a href="" id="add_more_other_rows">Click to add more</a>
                                <input type="hidden" id="other_rows" value="{{(isset($others))?count($others):'1'}}">
                            </td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <strong><i>Total</i></strong>
                            </td>
                            <td>
                                $<span id="total"></span>
                                <input type="hidden" id="total_input" name="total_step_2" />
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <br />
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
    </div>
</form>


<div class="modal fade" id="add_hearse" tabindex="-1" role="dialog" style="z-index: 2222">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="">Add Hearse</h4>
            </div>

            <div class="modal-body">

            </div>
            <div class="modal-footer">
                
            </div>

        </div>
    </div>
</div>

<!--  For point 2 -->


<div class="modal fade" id="add_coffin_catalog" tabindex="-1" role="dialog" style="overflow:scroll">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="coffin_catalog_title">Add Coffin</h4>
            </div>

            <div class="modal-body">
                    
                    
                
            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-default selected-item-ok" >OK</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="add_backdrop" tabindex="-1" role="dialog" style="overflow:scroll">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="backdrop_title">Add Back drop</h4>
            </div>

            <div class="modal-body">

            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-default selected-item-ok" >OK</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="add_urns" tabindex="-1" role="dialog" style="overflow:scroll">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="urns_title">Add Urns</h4>
            </div>

            <div class="modal-body">

            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-default selected-item-ok" >OK</button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="add_burial_plot" tabindex="-1" role="dialog" style="overflow:scroll">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="burial_plot_title">Add Burial plot</h4>
            </div>

            <div class="modal-body">

            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-default selected-item-ok" >OK</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="add_gem_stones" tabindex="-1" role="dialog" style="overflow:scroll">
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



<div class="modal fade" id="general_popupA" tabindex="-1" role="dialog" style="overflow:scroll">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id=""></h4>
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


