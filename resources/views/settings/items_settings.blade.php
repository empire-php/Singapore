@if($elem == "scc_buddhist" || $elem == "scc_christian" || $elem == "scc_tidbits" || $elem == "scc_tentage" || $elem == "scc_chanting")
<form id="form_pdf_{{$elem}}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <input type="hidden" id="elem" name="elem" value="<?php echo $elem;?>" />
        <input type="hidden" name="id" value="<?php echo (isset($pdf["id"]))?$pdf["id"]:"";?>" />
    <table>
        <tr>
            <?php if (!empty($pdf["pdf"])):?>
                <td colspan="2">
                    <?php if ($pdf["pdf"] == "error"):?>
                        <span style="color: red">Please select other file</span>
                    <?php else:?>
                        <a href="{{url("/uploads/".$pdf["pdf"])}}" target="_blank">Click to view PDF file</a>
                        <div id="{{$pdf["pdf"]}}" class="fa fa-remove" onclick="removePdf(this);"></div>
                    <?php endif;?>
                </td>
            <?php endif;?>
            <td style="padding-left: 30px">
                <input type="file" name="file" class="form-control"  accept=".pdf" style="width: 200px;" />
            </td>
            <td style="padding-left: 30px">
                <input type="button" name="pdf_save_bttn" value="Save" class="btn" />
            </td>
        </tr>
    </table>
    </form>
        <br />
@endif

<table class="table table-striped table-bordered table-hover" id="tbl_{{$elem}}">
    <thead>
        <tr>
            @if ($elem == "hearse")
                <th>Hearse Name</th>
                <th>Image</th>
                <th>Unit Price</th>
            @elseif($elem == "ala_carte")
                <th>Category Name</th>
                <th>Selection Category</th>
                <th>Selection Item</th>
                <th>Image</th>
                <th>Unit Price</th>
            <!-- for point 5 -->
            @elseif($elem == "columbarium")
                <th>Category Name</th>
                <th>Selection Category</th>
                <th>Selection Item</th>
                <th>Image</th>
                <th>Unit Price</th>
            <!-- -->
            @elseif($elem == "individual_sales")
                <th>Package Name</th>
                <th>Selection Category</th>
                <th>Selection Item</th>
                <th>Unit Price</th>
            @elseif($elem == "parlour")
                <th>Parlour Name</th>
                <th>Capacity</th>
                <th>Image</th>
                <th>Unit Price</th>
            @elseif($elem == "scc_buddhist" || $elem == "scc_christian" || $elem == "scc_tidbits" || $elem == "scc_tentage" || $elem == "scc_chanting")
                <th>Category Name</th>
                <th>Selection Category</th>
                <th>Selection Item</th>
                <th>Image</th>
                <th>Unit Price</th>
                
            @elseif($elem == "far")
                <th>Package Name</th>
                <th>Selection Category</th>
                <th>Selection Item</th>
                 <th>Image</th>
                <th>Unit Price</th>
            @endif
            
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @if ($items)
        @foreach($items as $order => $arr)
        <tr class="list_item_{{(isset($arr["id"]))?$arr["id"]:$order}}">
            @if ($elem == "hearse")
                <td class="hearse_name" data-value="{{(isset($arr["name"]))?$arr["name"]:''}}">{{(isset($arr["name"]))?$arr["name"]:''}}</td>
                <td class="image" data-value=""><img src="/uploads/{{(isset($arr["image"]))?$arr["image"]:''}}" style="width:50px;" /></td>
                <td class="unit_price" data-value="{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}">{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}</td>
            @elseif($elem == "ala_carte" || $elem == "columbarium")
                <?php $arrCategNames = array("Backdrop","Burial plot","Coffin catalog","Flowers","Gem stones","Urns");?>
                <td class="category_name" data-value="{{(isset($arr["group_name"]))?$arr["group_name"]:''}}">{{(isset($arr["group_name"]))?$arrCategNames[$arr["group_name"]-1]:''}}</td>
                <td class="selection_category" data-value="{{(isset($arr["selection_category"]))?$arr["selection_category"]:''}}">{{(isset($arr["selection_category"]))?$arr["selection_category"]:''}}</td>
                <td class="selection_item_name" data-value="{{(isset($arr["selection_item_name"]))?$arr["selection_item_name"]:''}}" data-id="{{(isset($arr["selection_item_id"]))?$arr["selection_item_id"]:''}}">
                    @if (isset($arr["selection_item_id"]))
                    @foreach(\App\Products::select("id","item")->get() as $product)
                        @if ($product->id == $arr["selection_item_id"])
                            {{$product->item}}
                        @endif
                    @endforeach
                    @endif
                </td>
                <td class="ala_images" data-value="">
                    
        <!-- For point 1 : Add multiple images for Ala-carte  -->
                <?php  if(isset($arr['image'])){ ?>
                <?php  $ala_image = explode("|", $arr['image']);?>
				@foreach($ala_image as $eachImage)
                                    @if($eachImage !="")
                                        <img src="/uploads/{{$eachImage}}" style="width:50px;" />
                                    @endif
                                @endforeach
		<?php } ?>
       <!--    END      -->
                </td>
                <td class="unit_price" data-value="{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}">{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}</td>
            @elseif($elem == "individual_sales")
                <td class="package_name" data-value="{{(isset($arr["group_name"]))?$arr["group_name"]:''}}">{{(isset($arr["group_name"]))?$arr["group_name"]:''}}</td>
                <td class="selection_category" data-value="{{(isset($arr["selection_category"]))?$arr["selection_category"]:''}}">{{(isset($arr["selection_category"]))?$arr["selection_category"]:''}}</td>
                <td class="selection_item_name" data-value="{{(isset($arr["selection_item_name"]))?$arr["selection_item_name"]:''}}" data-id="{{(isset($arr["selection_item_id"]))?$arr["selection_item_id"]:''}}">
                    @if (isset($arr["selection_item_id"]))
                    @foreach(\App\Products::select("id","item")->get() as $product)
                        @if ($product->id == $arr["selection_item_id"])
                            {{$product->item}}
                        @endif
                    @endforeach
                    @endif
                </td>
                <td class="unit_price" data-value="{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}">{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}</td>
            @elseif($elem == "parlour")
            
                <td class="parlour_name" data-value="{{(isset($arr["name"]))?$arr["name"]:''}}">{{(isset($arr["name"]))?$arr["name"]:''}}</td>
                <td class="capacity" data-value="{{(isset($arr["capacity"]))?$arr["capacity"]:''}}">{{(isset($arr["capacity"]))?$arr["capacity"]:''}}</td>
                <td class="image" data-value="">
				<?php if(is_array($arr['image'])){; ?>
				@foreach($arr["image"] as $eachImage)
				<img src="/uploads/{{(isset($eachImage))?$eachImage:''}}" style="width:50px;" />
				@endforeach
				<?php } ?>
		</td>
                <td class="unit_price" data-value="{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}">{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}</td>
            
            @elseif($elem == "scc_buddhist" || $elem == "scc_christian" || $elem == "scc_tidbits" || $elem == "scc_tentage" || $elem == "scc_chanting")
           
                <td class="category_name" data-value="{{(isset($arr["group_name"]))?$arr["group_name"]:''}}">{{(isset($arr["group_name"]))?$arr["group_name"]:''}}</td>
                <td class="selection_category" data-value="{{(isset($arr["selection_category"]))?$arr["selection_category"]:''}}">{{(isset($arr["selection_category"]))?$arr["selection_category"]:''}}</td>
                <td class="selection_item_name" data-value="{{(isset($arr["selection_item_name"]))?$arr["selection_item_name"]:''}}" data-id="{{(isset($arr["selection_item_id"]))?$arr["selection_item_id"]:''}}">
                    @if (isset($arr["selection_item_id"]))
                    @foreach(\App\Products::select("id","item")->get() as $product)
                        @if ($product->id == $arr["selection_item_id"])
                            {{$product->item}}
                        @endif
                    @endforeach
                    @endif
                </td>
                <td class="scc_images" data-value="">
                    
        <!-- For point 1 : Add multiple images for Ala-carte  -->
                <?php  if(isset($arr['image'])){ ?>
                <?php  $ala_image = explode("|", $arr['image']);?>
				@foreach($ala_image as $eachImage)
                                    @if($eachImage !="")
                                        <img src="/uploads/{{$eachImage}}" style="width:50px;" />
                                    @endif
                                @endforeach
		<?php } ?>
       <!--    END      -->
                </td>
                <td class="unit_price" data-value="{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}">{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}</td>
           
            @elseif($elem == "far")
                <td class="package_name" data-value="{{(isset($arr["group_name"]))?$arr["group_name"]:''}}">{{(isset($arr["group_name"]))?$arr["group_name"]:''}}</td>
                <td class="selection_category" data-value="{{(isset($arr["selection_category"]))?$arr["selection_category"]:''}}">{{(isset($arr["selection_category"]))?$arr["selection_category"]:''}}</td>
                <td class="selection_item_name" data-value="{{(isset($arr["selection_item_name"]))?$arr["selection_item_name"]:''}}" data-id="{{(isset($arr["selection_item_id"]))?$arr["selection_item_id"]:''}}">
                    @if (isset($arr["selection_item_id"]))
                    @foreach(\App\Products::select("id","item")->get() as $product)
                        @if ($product->id == $arr["selection_item_id"])
                            {{$product->item}}
                        @endif
                    @endforeach
                    @endif
                </td>
                <td class="far_images" data-value="">
                    
        <!-- For point 1 : Add multiple images for Ala-carte  -->
                <?php  if(isset($arr['image'])){ ?>
                <?php  $ala_image = explode("|", $arr['image']);?>
				@foreach($ala_image as $eachImage)
                                    @if($eachImage !="")
                                        <img src="/uploads/{{$eachImage}}" style="width:50px;" />
                                    @endif
                                @endforeach
		<?php } ?>
       <!--    END      -->
                </td>
                <td class="unit_price" data-value="{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}">{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}</td>
            @endif
            <td><a href="#" id="{{$elem}}_edit_item_{{(isset($arr["id"]))?$arr["id"]:$order}}"><i class="fa fa-pencil"></i> edit</a></td>
            <td><a href="#" id="{{$elem}}_delete_item_{{(isset($arr["id"]))?$arr["id"]:$order}}"><i class="fa fa-remove"></i> delete</a></td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>

<script type="text/javascript">
    
    
$(document).ready(function(){
    $("#form_pdf_<?php echo $elem;?> input[type=button]").click(function(){
        var elem = $(this).parents("form");
        var fd = new FormData();    
        if (elem.find("[name=file]").length > 0){
            fd.append( 'file',elem.find("[name=file]")[0].files[0] );
        }
        elem.find("input, select, textarea").each(function(){
            fd.append( $(this).attr("name"),$(this).val() );
        });
        $.ajax({
                url: "/settings/save_items_settings",
                method: "POST",
                data: fd,
                processData: false,
                contentType: false,
            }).done(function() {
                $.ajax({
                    url: "/settings/get_items_settings",
                    method: "GET",
                    data: {elem: '<?php echo $elem;?>'}
                }).done(function(data) {
                     $("#add_<?php echo $elem;?>_items").parents(".panel-body").find(".table_container").html( data );
                });
            });
    });
    
    
    $("#tbl_<?php echo $elem;?> [id^=<?php echo $elem;?>_edit_item]").click(function(e){
        console.log( $(this).attr("id"));
        e.preventDefault();
        var arr = $(this).attr("id").split("_edit_item");
        var elemType = arr[0];
        
        var foundId = $(this).parents(".table_container").parent().find(".add_items").attr("id");
        if (foundId == "add_scc_chanting_items" || foundId == "add_scc_tentage_items" || foundId == "add_scc_tidbits_items" || foundId == "add_scc_christian_items" || foundId == "add_scc_buddhist_items"|| foundId == "add_far_items" ){
            foundId = "add_general_items";
        }
        var popupId = "#" + foundId + "_popup";
        if ($(this).attr("id") == "add_scc_chanting_items" || $(this).attr("id") == "add_scc_tentage_items" || $(this).attr("id") == "add_scc_tidbits_items" || $(this).attr("id") == "add_scc_christian_items" || $(this).attr("id") == "add_scc_buddhist_items"|| $(this).attr("id") == "add_far_items"){
            popupId = "#add_general_items_popup";
        }
        
        
        
        
        var clPopup = $(popupId);
        if (foundId == "add_general_items"){
            if (elemType == "far"){
              
                clPopup.find("#category_label, #category_name").hide();
                clPopup.find("#package_label, #package_name").show();
            }
            else{
                clPopup.find("#package_label, #package_name").hide();
                clPopup.find("#category_label, #category_name").show();
            }
        }
        
        
        if (elemType == "scc_chanting"){
            clPopup.find(".modal-title").html("Chanting Items");
        }
        if (elemType == "far"){
            clPopup.find(".modal-title").html("FA for Repatriation Item");
        }
        
        
        clPopup.find("#item_type").val(elemType);
        clPopup.find("#id").val(arr[3]);
        
        <!-- For point 1 -->
        clPopup.find("[type=file]").attr("id",elemType+"_images");
        <!-- END -->
        
        $(this).parents("tr").find("td").each(function(){
            var el = $(this).attr("class");
            if (el != "image"){

                var value = $(this).data("value");

                clPopup.find("[name="+ el +"]").val(value);
                clPopup.find("[name="+ el +"] option").each(function(){
                    if ($(this).val() == value){
                        $(this).attr("selected","selected");
                    }
                });
                if ($(this).data("id")){
                    clPopup.find("[name="+ el.replace("_name","_id") +"]").val($(this).data("id"));
                }
                if (clPopup.find("[name="+ el +"_selected]").length > 0){
                    clPopup.find("[name="+ el +"_selected]").val(value);
                }
            }
            clPopup.find("[name=image]").val("");
            clPopup.find('select').selectpicker('refresh');
        });
        
        if (clPopup.find("#general_item_type").length){
            var strId = $(this).attr("id").split("_edit_item_");
            if (typeof strId[0] != 'undefined'){
                clPopup.find("#general_item_type").val(strId[0])
                clPopup.find("#id").val(strId[1])
            }
        }

        clPopup.find("[name=id]").val($(this).attr("id").replace("<?php echo $elem;?>_edit_item_",""));
        clPopup.find("[name=order_nr]").val($(this).attr("id").replace("<?php echo $elem;?>_edit_item_",""));
        clPopup.modal("show");
        
        
        
        
        
        
        clPopup.find( "#package_name" ).autocomplete({
            source: function( request, response ) {
              $.getJSON( "/settings/search_fa_sales_package", {
                term: request.term 
              }, response );
            }
        });  

        clPopup.find('#package_name').autocomplete({ minLength: 0 });
        clPopup.find('#package_name').click(function() { $(this).autocomplete("search", ""); });
        
    });
    $("#tbl_<?php echo $elem;?> [id^=<?php echo $elem;?>_delete_item]").click(function(e){
        e.preventDefault();
        if (confirm("Are you sure?")){
            $.ajax({
                    url: "/settings/delete_items_settings",
                    method: "POST",
                    data: {elem: '<?php echo $elem;?>', id: $(this).attr("id").replace("<?php echo $elem;?>_delete_item_",""), _token: $("[name=_token]").val()},
                }).done(function() {
                    $.ajax({
                        url: "/settings/get_items_settings",
                        method: "GET",
                        data: {elem: '<?php echo $elem;?>'}
                    }).done(function(data) {
                         $("#add_<?php echo $elem;?>_items").parents(".panel-body").find(".table_container").html( data );
                    });
                });
        }
    });
});
</script>