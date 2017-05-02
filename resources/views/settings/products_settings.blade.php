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
                <th>Unit Price</th>
            @else
                <th>Package Name</th>
                <th>Selection Category</th>
                <th>Selection Item</th>
                <th>Unit Price</th>
            @endif
            
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @if ($items)
        @foreach($items as $order => $arr)
        <tr class="list_item_{{$order}}">
            @if ($elem == "hearse")
                <td class="hearse_name" data-value="{{(isset($arr["hearse_name"]))?$arr["hearse_name"]:''}}">{{(isset($arr["hearse_name"]))?$arr["hearse_name"]:''}}</td>
                <td class="image" data-value=""><img src="/uploads/{{(isset($arr["image"]))?$arr["image"]:''}}" style="width:50px;" /></td>
                <td class="unit_price" data-value="{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}">{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}</td>
            @elseif($elem == "ala_carte")
                <?php $arrCategNames = array("Backdrop","Burial plot","Coffin catalog","Flowers","Gem stones","Urns");?>
                <td class="category_name" data-value="{{(isset($arr["category_name"]))?$arr["category_name"]:''}}">{{(isset($arr["category_name"]))?$arrCategNames[$arr["category_name"]-1]:''}}</td>
                <td class="selection_category" data-value="{{(isset($arr["selection_category"]))?$arr["selection_category"]:''}}">{{(isset($arr["selection_category"]))?$arr["selection_category"]:''}}</td>
                <td class="selection_item" data-value="{{(isset($arr["selection_item"]))?$arr["selection_item"]:''}}">
                    @if (isset($arr["selection_item"]))
                    @foreach(\App\Products::select("id","item")->get() as $product)
                        @if ($product->id == $arr["selection_item"])
                            {{$product->item}}
                        @endif
                    @endforeach
                    @endif
                </td>
                <td class="unit_price" data-value="{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}">{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}</td>
            @else
                <?php $arrPackageNames = array("Coffin","Manpower","Embalming","Makeup","Photo enlargement","Passport photo","Package flower","Frame size","Hearse flower","Itemisation Flower","Backdrop","Hearse","Urns","Gem stone");?>
                <td class="package_name" data-value="{{(isset($arr["package_name"]))?$arr["package_name"]:''}}">{{(isset($arr["package_name"]))?$arrPackageNames[$arr["package_name"] - 1 ]:''}}</td>
                <td class="selection_category" data-value="{{(isset($arr["selection_category"]))?$arr["selection_category"]:''}}">{{(isset($arr["selection_category"]))?$arr["selection_category"]:''}}</td>
                <td class="selection_item" data-value="{{(isset($arr["selection_item"]))?$arr["selection_item"]:''}}">
                    @if (isset($arr["selection_item"]))
                    @foreach(\App\Products::select("id","item")->get() as $product)
                        @if ($product->id == $arr["selection_item"])
                            {{$product->item}}
                        @endif
                    @endforeach
                    @endif
                </td>
                <td class="unit_price" data-value="{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}">{{(isset($arr["unit_price"]))?$arr["unit_price"]:''}}</td>
            @endif
            <td><a href="#" id="{{$elem}}_edit_item_{{$order}}"><i class="fa fa-pencil"></i> edit</a></td>
            <td><a href="#" id="{{$elem}}_delete_item_{{$order}}"><i class="fa fa-remove"></i> delete</a></td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>

<script type="text/javascript">
    
    
$(document).ready(function(){
    $("#tbl_<?php echo $elem;?> [id^=<?php echo $elem;?>_edit_item]").click(function(e){
        e.preventDefault();

        var popupId = "#" + $(this).parents(".table_container").parent().find(".add_invetory_items").attr("id") + "_popup";
        var clPopup = $(popupId);
        //var clPopup = $(popupId).clone();
        //clPopup.attr("tmp_popup");
        
        $(this).parents("tr").find("td").each(function(){
            var el = $(this).attr("class");
            if (el != "image"){
                /*var value = "";
                if ($(this).find("input").length > 0){
                    value = $(this).find("input").val();
                }
                else{
                    value = $(this).html().trim();
                }*/

                var value = $(this).data("value");

                clPopup.find("[name="+ el +"]").val(value);
                clPopup.find("[name="+ el +"] option").each(function(){
                    if ($(this).val() == value){
                        $(this).attr("selected","selected");
                    }
                });
            }
            
            clPopup.find('select').selectpicker('refresh');
        });

        clPopup.find("[name=order_nr]").val($(this).attr("id").replace("<?php echo $elem;?>_edit_item_",""));
        clPopup.modal("show");
        
        
        /*$(clPopup).find(".submit_bttn").click(function(){
            var fd = new FormData();  
            fd.append( 'elem', '<?php echo $elem;?>' );
            if (clPopup.find("[name=image]").length > 0){
                fd.append( 'image', clPopup.find("[name=image]")[0].files[0] );
            }
            clPopup.find("form input, form select, form textarea").each(function(){
                if ($(this).attr("name") != "image"){
                    fd.append( $(this).attr("name"),$(this).val() );
                }
            });
            clPopup.modal("hide");
            
            $.ajax({
                url: "/settings/save_products_settings",
                method: "POST",
                data: fd,
                processData: false,
                contentType: false,
            }).done(function() {
                
                
                $.ajax({
                    url: "/settings/get_products_settings",
                    method: "GET",
                    data: {elem: '<?php echo $elem;?>'}
                }).done(function(data) {
                    $("#add_<?php echo $elem;?>_items").parents(".panel-body").find(".table_container").html( data );
                    //$(clPopup).remove();
                });
            });
        });*/
        
    });
    $("#tbl_<?php echo $elem;?> [id^=<?php echo $elem;?>_delete_item]").click(function(e){
        e.preventDefault();
        $.ajax({
                url: "/settings/delete_products_settings",
                method: "POST",
                data: {elem: '<?php echo $elem;?>', order_nr: $(this).attr("id").replace("<?php echo $elem;?>_delete_item_",""), _token: $("[name=_token]").val()},
            }).done(function() {
                $.ajax({
                    url: "/settings/get_products_settings",
                    method: "GET",
                    data: {elem: '<?php echo $elem;?>'}
                }).done(function(data) {
                     $("#add_<?php echo $elem;?>_items").parents(".panel-body").find(".table_container").html( data );
                });
            });
    });
});
</script>