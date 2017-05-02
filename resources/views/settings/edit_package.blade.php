<div class="table_container" id="edit_package_content">
    
    {!! csrf_field() !!}
    <input type="hidden" name="id" id="id" value="{{$id}}" />


    <div class="section_title" style="width: 30%; margin-bottom: 0px; margin-top: 60px">
        @if ($id > 0)
        Edit package
        @else
        Add new package
        @endif
    </div>
    <table>
        <tr><td colspan="2">
                @if ($id > 0)
                <strong>Currently editing: {{$package->name}}</strong>
                @endif
            </td></tr>
        <tr>
            <td>
                Package category:
            </td>
            <td>
                <input type="text" class="form-control" name="category" id="category" value="{{$package->category}}" />
            </td>
        </tr>
        <tr>
            <td>
                Package name:
            </td>
            <td>
                <input type="text" class="form-control" name="name" id="name" value="{{$package->name}}" />
            </td>
        </tr>
        <tr>
            <td>
                Original price:
            </td>
            <td>
                <input type="number" class="form-control" name="original_price" id="original_price" value="{{$package->original_price}}" />
            </td>
        </tr>
        <tr>
            <td>
                Promotional price:
            </td>
            <td>
                <input type="text" class="form-control" name="promotional_price" id="promotional_price" value="{{$package->promo_price}}" />
            </td>
        </tr>
        <tr>
       <!--     <td colspan="2">	-->
       <!--         <button class="btn btn-primary" type="button" id="package_save_bttn">  -->
       <!--             <i class="fa fa-save"></i> Save				-->
       <!--         </button>							-->
       <!--     </td>								-->
        </tr>
    </table>
    <br />
    <br />
    <table class="table-bordered" id="tbl_list_package">
        <thead>
            <tr>
                <th>Section Name</th>
                <th>Category Name</th>
                <th>Selection Category</th>
                <th>Selection Item</th>
                <th>Usual Price</th>
                <th>Package Price</th>
                <th>Add-on Price</th>
                <th>Image</th>
                <th></th>
            </tr>
        </thead>
        @foreach($package->items() as $item)
        <tbody>
            <td data-id="section_name" data-sel="{{$item->section_name}}">{{$item->section_name}}</td>
            <td data-id="category_name" data-sel="{{$item->category_name}}">{{$item->category_name}}</td>
            <td data-id="selection_category" data-sel="{{$item->selection_category}}" data-name="{{$item->selection_category}}">{{$item->selection_category}}</td>
            <td data-id="selection_item" data-sel="{{$item->selection_item_id}}" data-name="{{$item->selection_item_name}}">{{$item->selection_item_name}}</td>
            <td data-id="usual_price" data-sel="{{$item->usual_price}}">{{$item->usual_price}}</td>
            <td data-id="package_price" data-sel="{{$item->package_price}}">{{$item->package_price}}</td>
            <td data-id="add_on_price" data-sel="{{$item->add_on_price}}">{{$item->add_on_price}}</td>
            <td>
                @if ($item->image)
                <img src="/uploads/{{$item->image}}" style="width:100px" />
                @endif
            </td>
            <td>
                <a href="#" id="package_item_edit_{{$item->id}}"><i class="fa fa-pencil"></i> edit</a>
                <a href="#" id="package_item_delete_{{$item->id}}"><i class="fa fa-remove"></i> delete</a>
            </td>
        </tbody>
        @endforeach
    </table>
</div>
<div class="form-group">
    <div class="input-group">
        <button class="btn btn-success add_items" type="button" id="show_package_item_popup_btn">
            <i class="fa fa-plus"></i> Add new item
        </button>
    </div>
     <div class="input-group" style="margin-top:15px;">
        <button class="btn btn-primary" type="button" id="package_save_bttn" style="width:127px;text-align:left">
                    <i class="fa fa-save"></i> Save
        </button>
    </div>
</div> 


<div class="modal fade" id="add_package_item_popup" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Package Item</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <form>
                        {!! csrf_field() !!}
                        
                        <input type="hidden" id="item_id" name="item_id" value="" />
                        
                        <label class="control-label">Section Name</label>
                        <input type="text" name="section_name" id="section_name" class="form-control" />
                        
                        <div style="height: 20px"></div>
                        
                        <label class="control-label">Category Name</label>
                        <input type="text" name="category_name" id="category_name" class="form-control" />

                        <div style="height: 20px"></div>
                        <label class="control-label">Selection category</label>
                        <input type="text" id="selection_category" name="selection_category" class="form-control" />
                        <input type="hidden" id="selection_category_selected" name="selection_category_selected" class="form-control" />
                        <div style="height: 20px"></div>
                        <label class="control-label">Selection item</label>
                        <input type="text" id="selection_item_name" name="selection_item_name" class="form-control" />
                        <input type="hidden" id="selection_item_id" name="selection_item_id" class="form-control" />

                        <div style="height: 20px"></div>
                        <label class="control-label">Usual Price</label>
                        <input type="text" disabled="disabled" id="usual_price_d" value="" class="form-control" />
                        <input type="hidden" name="usual_price" value="" class="form-control" />
                        
                        <div style="height: 20px"></div>
                        <label class="control-label">Package Price</label>
                        <input type="text" name="package_price" value="" class="form-control" />
                        
                        <div style="height: 20px"></div>
                        <label class="control-label">Add-on Price</label>
                        <input type="text" name="add_on_price" value="" class="form-control" />
                        
                        
                        <div style="height: 20px"></div>
                        <label class="control-label">Image</label>
                        <input type="file" name="image" value="" class="form-control" />
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submit_bttn">SAVE</button>
            </div>

        </div>
    </div>
</div>



<script type="text/javascript">
$(document).ready(function(){
    $("#package_save_bttn").click(function(e){
       e.preventDefault();
        
        $.ajax({
            url: "/settings/save_fa_package",
            method: "POST",
            dataType: "html",
            data: { _token: $("#edit_package_content [name=_token]").val(),
                    id: $("#edit_package_content #id").val(),
                    category: $("#edit_package_content #category").val(),
                    name: $("#edit_package_content #name").val(),
                    original_price: $("#edit_package_content #original_price").val(),
                    promo_price: $("#edit_package_content #promotional_price").val(),
                  },
        
            statusCode: {
                401: function() {
                  alert( "Login expired. Please sign in again." );
                }
            }
        }).done(function(html) {
            $("#edit_package_container").html(html);
            $("#edit_package_container").show();
            
            $.ajax({
                url: "/settings/list_fa_packages",
                method: "GET",
                dataType: "html",

                statusCode: {
                    401: function() {
                      alert( "Login expired. Please sign in again." );
                    }
                }
            }).done(function(html) {
                $("#tbl_list_package").html(html);
            });
            
            $("#general_popup").find(".modal-title").html("Status");
            $("#general_popup").find(".modal-body").html("Information saved.");
            $("#general_popup").modal("show");
        });
    });
    
    $("#show_package_item_popup_btn").click(function(e){
    
		if($("#category").val() =="" || $("#name").val() == "" || $("#original_price").val() =="" || $("#promotional_price").val()==""){
			alert("Please select a package to add items first");
			return false;
		}
		if($("#edit_package_content div").text().trim() == "Edit package"){
			 e.preventDefault();
       			 $("#add_package_item_popup").modal("show");
		}else {
			alert("After add a package first , you can add items.");
			return false;
		}
       
    });
    
    
    
    if ($( "#add_package_item_popup [name=selection_category]"  ).length > 0){
        $( "#add_package_item_popup [name=selection_category]"  ).autocomplete({
            source: function( request, response ) {
              $.getJSON( "/settings/search_inventory_category", {
                term: request.term 
              }, response );
            },
            select: function( event, ui ) {
                $( "#add_package_item_popup [name=selection_category]"  ).val( ui.item.category );
                $( "#add_package_item_popup [name=selection_category_selected]"  ).val( ui.item.category );
                return false;
            },
            search: function( event, ui ) {
                $( "#add_package_item_popup [name=selection_category_selected]"  ).val("");
            }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            
            return $( "<li>" )
              .append( "<div>" + item.category + "</div>" )
              .appendTo( ul );
        };
    }
    $("#add_package_item_popup [name=selection_category]").autocomplete({ minLength: 0 });
    $("#add_package_item_popup [name=selection_category]").click(function() { $(this).autocomplete("search", ""); });
    $( "#add_package_item_popup [name=selection_category]" ).blur(function(){
        if (!$( "#add_package_item_popup [name=selection_category_selected]" ).val()){
            $( "#add_package_item_popup [name=selection_category]" ).val("");
        }
    });
    
    
    
    
    if ($( "#add_package_item_popup [name=selection_item_name]" ).length > 0){
        $( "#add_package_item_popup [name=selection_item_name]" ).autocomplete({
            source: function( request, response ) {
              $.getJSON( "/settings/search_inventory_item", {
                term: request.term , category:  $( "#add_package_item_popup [name=selection_category]" ).val()
              }, response );
            },
            select: function( event, ui ) {
                $( "#add_package_item_popup [name=selection_item_name]" ).val( ui.item.item );
                $( "#add_package_item_popup [name=selection_item_id]" ).val( ui.item.id );
                $( "#add_package_item_popup [name=usual_price]").val( ui.item.unit_price );
                $( "#add_package_item_popup #usual_price_d").val( ui.item.unit_price );
                return false;
            },
            search: function( event, ui ) {
                $( "#add_package_item_popup [name=selection_item_id]" ).val( "" );
                $( "#add_package_item_popup [name=unit_price]").val( "" );
            }
        })
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
              .append( "<div>" + item.item + "</div>" )
              .appendTo( ul );
        };
    }
    $("#add_package_item_popup [name=selection_item_name]").autocomplete({ minLength: 0 });
    $("#add_package_item_popup [name=selection_item_name]").click(function() { $(this).autocomplete("search", ""); });
    $( "#add_package_item_popup [name=selection_item_name]" ).blur(function(){
        if (!$( "#add_package_item_popup [name=selection_item_id]" ).val()){
            $( "#add_package_item_popup [name=selection_item_name]" ).val("");
        }
    });
    
    
    $("#add_package_item_popup .submit_bttn").click(function(e){
        e.preventDefault();
        
        $("#add_package_item_popup").modal("hide");
        
        var elem = $(this).parents(".modal");
        
        var fd = new FormData();    
        if (elem.find("[name=image]").length > 0){
            fd.append( 'image',elem.find("[name=image]")[0].files[0] );
        }
        elem.find("form input, form select, form textarea").each(function(){
            if ($(this).attr("name") != "image"){
                fd.append( $(this).attr("name"),$(this).val() );
            }
        });
        
        fd.append( 'id', $("#edit_package_content #id").val());
        fd.append( 'act', "edit_item");
        
        
        
        $.ajax({
            url: "/settings/save_fa_package",
            method: "POST",
            dataType: "html",
            data: fd,
            processData: false,
            contentType: false,
            statusCode: {
                401: function() {
                  alert( "Login expired. Please sign in again." );
                }
            }
        }).done(function(html) {
            
            $("#edit_package_container").html(html);
            $("#edit_package_container").show();
        });
    });
    
    $("#edit_package_content [id^=package_item_edit]").click(function(e){
        e.preventDefault();
        $("#add_package_item_popup").find("#item_id").val($(this).attr("id").replace("package_item_edit_",""));
        $(this).parents("tr").find("td").each(function(){
            if ($(this).data("id")){
                if ($(this).data("id") == "selection_item"){
                    $("#add_package_item_popup").find("[name="+ $(this).data("id") + "_name]").val($(this).data("name"));
                    $("#add_package_item_popup").find("[name="+ $(this).data("id") + "_id]").val($(this).data("sel"));
                }
                else if ($(this).data("id") == "selection_category"){
                    $("#add_package_item_popup").find("[name="+ $(this).data("id")+ "]").val($(this).data("name"));
                    $("#add_package_item_popup").find("[name="+ $(this).data("id")+ "_selected]").val($(this).data("sel"));
                }
                else if ($(this).data("id") == "usual_price"){
                    $("#add_package_item_popup").find("[name="+ $(this).data("id")+ "]").val($(this).data("sel"));
                    $("#add_package_item_popup").find("[id="+ $(this).data("id")+ "_d]").val($(this).data("sel"));
                }
                else{
                    $("#add_package_item_popup").find("[name="+ $(this).data("id")+"]").val($(this).data("sel"));
                }
            }
        });
        $("#add_package_item_popup").find("[name=image]").val("");
        $("#add_package_item_popup").modal("show");
    });
    
    $("#edit_package_content [id^=package_item_delete]").click(function(e){
        e.preventDefault();
        if (confirm("Are you sure?")){
            $.ajax({
                url: "/settings/delete_fa_package_item",
                method: "GET",
                data: { id: $(this).attr("id").replace("package_item_delete_","") },
                statusCode: {
                    401: function() {
                      alert( "Login expired. Please sign in again." );
                    }
                }
            }).done(function(html) {

                $("#edit_package_container").html(html);
                $("#edit_package_container").show();
            });
        }
    });
   
});
</script>