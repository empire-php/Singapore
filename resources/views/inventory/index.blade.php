@extends('layouts.app')
@section('content')

<?php $companies = App\Company::all(); ?>

<div class="section">
    <div class="section_content" id="products_list">
        <div id="search_div" class="row" style="width: 100%;">
            <div style="width: 640px; float: left; border: 2px solid #bbbbbb; border-radius: 7px; padding: 20px;">
            <form class="form-horizontal" id="search_form" action="" method="post" onsubmit="return false">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="control-label col-sm-2" for="search_word">Search:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="search_word" name="search_word" placeholder="Item number or Description">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">filter : </label>
                    <div class="col-sm-10">

                            <div class="form-group">
                                <label for="category" style="font-size: 15px">Category</label><br/>
                                <select class="form-control" id="filter_categories" name="filter_categories[]"
                                        data-toggle="select2" multiple>
                                    @foreach($categories as $category)
                                        <option value="{{$category->category}}">{{$category->category}}</option>
                                    @endforeach
                                </select>
                                {{--@if(isset($categories))
                                    @foreach($categories as $category)
                                        <label><input type="checkbox" class="filter_check" value="{{$category->category}}" name="filter_categories[]"> {{$category->category}}</label> <br/>
                                    @endforeach
                                @endif--}}
                            </div>


                            <div class="form-group">
                                <label for="company" style="font-size: 15px">Company</label><br/>
                                <select class="form-control" id="filter_companies" name="filter_companies[]"
                                        data-toggle="select2" multiple>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->name}}</option>
                                    @endforeach
                                </select>
                                {{--@foreach($companies as $company)
                                    <label><input type="checkbox" class="filter_check" value="{{$company->id}}" name="filter_companies[]"> {{$company->name}}</label> <br/>
                                @endforeach--}}
                            </div>


                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-success btn-filter">Search/Filter</button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-default btn-clear">Clear Search/Filter</button>
                    </div>
                </div>
            </form>
            </div>
        </div>

        <div style="padding: 10px; height: 50px; "><input type="button" class="btn add_new" value="Add New Item" /></div>
        <div id="product_items">
        @if(isset($categories))
            <?php $nr = 0; ?>
        @foreach($categories as $category)
        <?php $products = App\Products::where("is_deleted",0)->where('category', $category->category)->orderby("category")->get(); ?>

        <div class="panel panel-default" id="category">
            <div class="panel-heading" role="tab" id="heading{{$nr}}">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$nr}}" aria-expanded="false" aria-controls="collapse{{$nr}}">
                        <em class="fa fa-fw fa-plus"></em> {{$category->category}} &nbsp;&nbsp; ({{count($products)}})
                    </a>
                </h4>
            </div>
            <div id="collapse{{$nr}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$nr}}" aria-expanded="false">
                <div class="panel-body">
                    <!----------------------Table--------------------------->
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <th>Category</th>
                            <th>Item Number</th>
                            <th>Item</th>
                            <th>Warehouse</th>
                            <th>Store Room</th>
                            <th>Total Balance</th>
                            <th>Unit Price</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Remarks</th>
                            <th>Low Stock Amount</th>
                            @foreach($companies as $company)
                                <th>{{$company->name}}</th>
                            @endforeach
                            <th style="text-align: center">Actions</th>
                        </tr>

                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    {{ $product->category }}
                                </td>
                                <td>
                                    {{$product->item_number}}
                                </td>
                                <td>
                                    {{$product->item}}
                                </td>
                                <td>
                                    @if ($product->unlimited_stock == 0)
                                        {{$product->warehouse}}
                                    @else
                                        Unlimited
                                    @endif
                                </td>
                                <td>
                                    @if ($product->unlimited_stock == 0)
                                        {{ $product->store_room }}
                                    @else
                                        Unlimited
                                    @endif
                                </td>
                                <td>
                                    @if($product->unlimited_stock == 0)
                                        {{$product->warehouse + $product->store_room}}
                                    @else
                                        Unlimited
                                    @endif
                                </td>
                                <td>
                                    @if ($product->unit_price > 0)
                                        {{ $product->unit_price }}
                                    @else
                                        Unlimited
                                    @endif

                                </td>
                                <td id="status_{{$product->id}}">
                                    {{($product->status == 1)?"Available":"Not Available"}}
                                </td>
                                <td>
                                    @if ($product->image)
                                        <img src="/uploads/products/{{$product->image}}" style="width:60px" />
                                    @endif
                                </td>
                                <td id="remarks_{{$product->id}}">
                                    {{$product->remarks}}
                                </td>
                                <td>
                                    @if($product->unlimited_stock == 0)
                                        {{$product->low_stock_amount}}
                                    @else
                                        Unlimited
                                    @endif
                                </td>
                                <?php
                                if(!empty($product->companies))
                                    $product_companies = explode(',', $product->companies);
                                else
                                    $product_companies =[];
                                ?>
                                @for($i=0; $i<count($companies); $i++)
                                    <td align="center" style="color:#00a957;">
                                        @if(in_array($companies[$i]->id, $product_companies))
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                @endfor
                                <td>
                                    <input type="button" id="add_more_prod_{{$product->id}}" class="btn add_more_bttn" value="Add More" />
                                    <input type="button" id="mark_damage_prod_{{$product->id}}" class="btn mark_damage_bttn" value="Mark Damage" />
                                    <input type="button" id="edit_remarks_prod_{{$product->id}}" class="btn edit_remarks_bttn" value="Edit remarks" />
                                    <input type="button" id="change_status_prod_{{$product->id}}" class="btn change_status_bttn" value="Change Status" />
                                    <input type="button" id="stock_transfer_{{$product->id}}" class="btn stock_transfer_bttn" value="Stock Transfer" />
                                    @if ($can_edit)
                                        <input type="button" id="edit_prod_{{$product->id}}" class="btn edit_bttn" style="background-color: #3498db;color: white;font-weight: bold;" value="Edit" />
                                    @endif
                                    @if ($can_delete)
                                        <input type="button" id="delete_prod_{{$product->id}}" class="btn delete_bttn" value="Delete" style="background-color: red;color: white;font-weight: bold;" />
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
            <?php $nr++; ?>
        @endforeach
        @endif
        </div>
    </div>
</div>
    
    
<div class="modal fade" id="new_product_form_container" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Product</h4>
            </div>

            <div class="modal-body">
                <div class="form-group form_container_elements">
                    <form  action="/inventory/save" id="info_frm1" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group" style="display: -webkit-box">
                          <label class="col-md-4 control-label" for="unlimited">Unlimited stock :</label>
                          <div class="col-md-4">
                            <label class="radio-inline">
                              <input type="radio" name="unlimited_stock" id="unlimited_1" value="1" checked="checked">
                              Yes
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="unlimited_stock" id="unlimited_0" value="0">
                              No
                            </label>
                          </div>
                        </div>
                        <label class="control-label">Category</label>
                        <input type="text" id="category" name="category" value="" class="form-control" />
                        <label class="control-label">Item number</label>
                        <input type="text" id="item_number" name="item_number" value="" class="form-control" />
                        <label class="control-label">Item</label>
                        <input type="text" id="item" name="item" value="" class="form-control" />
                        <label class="control-label">Warehouse</label>
                        <input type="number" step="1" min="1" id="warehouse" name="warehouse" value="" class="form-control" placeholder="unlimited" readonly />
                        <label class="control-label">Store Room</label>
                        <input type="number" step="1" min="1" id="store_room" name="store_room" value="" class="form-control" placeholder="unlimited" readonly/>
                        <label class="control-label">Unit Price</label>
                        <input type="text" id="unit_price" name="unit_price" value="" class="form-control" />
                        <label class="control-label">Status</label>
                        <select id="status" name="status" class="form-control" ><option value="1">Available</option><option value="0">Not available</option></select>
                        <label class="control-label">Image</label>
                        <input type="file" id="image" name="image" value="" class="form-control" />
                        <label class="control-label">Remarks</label>
                        <input type="text" id="remarks" name="remarks" value="" class="form-control" />
                        <label class="control-label">Low Stock Amount</label>
                        <input type="number" step="1" min="1" id="low_stock_amount" name="low_stock_amount" value="" class="form-control" placeholder="unlimited" readonly/>
                        <label class="control-label">Companies</label><br/>
                        @foreach($companies as $company)
                            <label><input type="checkbox" class="" value="{{$company->id}}" name="companies[]"> {{$company->name}}</label> <br/>
                        @endforeach


                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default cancel_bttn">Cancel</button>
                <button type="button" class="btn btn-primary save_bttn">Submit</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="add_more_form_container" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add more</h4>
            </div>

            <div class="modal-body">
                <div class="form-group form_container_elements">
                    <form  action="/inventory/save" id="info_frm2" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" id="add_product_id" name="product_id" />
                        <label class="control-label">Quantity for</label>
                        <select id="add_location" name="location" class="form-control" ><option value="1">Warehouse</option><option value="2">Store room</option></select>
                        <label class="control-label">Quantity to add</label>
                        <input type="text" id="add_quantity" name="add_quantity" value="" class="form-control" />
                        <label class="control-label">Date</label>
                        <input type="text" id="add_date_modif" name="date_modif" value="<?php echo date("d/m/Y H:i")?>" class="form-control" />
                        <label class="control-label">User</label>
                        <select class="form-control" name="user_modif" data-toggle="select2" class="form-control">
                            @foreach ($users as $object)
                                <option value="{{ $object->id }}"
                                        @if ($object->id == $user->id)
                                        selected="selected"
                                        @endif
                                        >
                                    {{ $object->name }}
                                </option>
                            @endforeach
                        </select>
                        
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default cancel_bttn">Cancel</button>
                <button type="button" class="btn btn-primary save_bttn">Submit</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="stock_transfer_form_container" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Stock Transfer</h4>
            </div>

            <div class="modal-body">
                <div class="form-group form_container_elements">
                    <form  action="/inventory/transfer" id="info_frm2" method="post" class="form-horizontal">
                        {!! csrf_field() !!}
                        <input type="hidden" id="transfer_product_id" name="product_id" />
                        <div class="form-group">
                            <label class="control-label col-sm-2">Transfer</label>
                            <div class="col-sm-10">
                                <div class="col-sm-6">
                                    from
                                    <select id="from_stock" name="from_stock" class="form-control" ><option value="w" selected>Warehouse</option><option value="s">Store room</option></select>
                                </div>
                                <div class="col-sm-6">
                                    to
                                    <select id="to_stock" name="to_stock" class="form-control" ><option value="w">Warehouse</option><option value="s" selected>Store room</option></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="quantities">Quantities</label>
                            <div class="col-sm-10">
                                <input type="number" step="1" min="1" class="form-control" id="quantities" name="quantities" placeholder="Quantities">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="transfer_user">User</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="transfer_user" id="transfer_user" data-toggle="select2" class="form-control">
                                    @foreach ($users as $object)
                                        <option value="{{ $object->id }}"
                                                @if ($object->id == $user->id)
                                                selected="selected"
                                                @endif
                                        >
                                            {{ $object->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="transfer_date">Date</label>
                            <div class="col-sm-10">
                                <input type="text" id="transfer_date" name="transfer_date" value="<?php echo date("d/m/Y H:i")?>" class="form-control" />
                            </div>
                        </div>



                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default cancel_bttn">Cancel</button>
                <button type="button" class="btn btn-primary save_bttn">Submit</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="mark_damage_form_container" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Mark Damage</h4>
            </div>

            <div class="modal-body">
                <div class="form-group form_container_elements">
                    <form  action="/inventory/save" id="info_frm3" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" id="damage_product_id" name="product_id" />
                        <label class="control-label">Quantity for</label>
                        <select id="damage_location" name="location" class="form-control" ><option value="1">Warehouse</option><option value="2">Store room</option></select>
                        <label class="control-label">Damaged quantity</label>
                        <input type="text" id="damage_quantity" name="damage_quantity" value="" class="form-control" />
                        <label class="control-label">Remarks</label>
                        <input type="text" id="damage_remarks" name="remarks" value="" class="form-control" />
                        <label class="control-label">Date</label>
                        <input type="text" id="damage_date_modif" name="date_modif" value="<?php echo date("d/m/Y H:i")?>" class="form-control" />
                        <label class="control-label">User</label>
                        <select class="form-control" name="user_modif" data-toggle="select2" class="form-control">
                            @foreach ($users as $object)
                                <option value="{{ $object->id }}"
                                        @if ($object->id == $user->id)
                                        selected="selected"
                                        @endif
                                        >
                                    {{ $object->name }}
                                </option>
                            @endforeach
                        </select>
                        
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default cancel_bttn">Cancel</button>
                <button type="button" class="btn btn-primary save_bttn">Submit</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="edit_remarks_form_container" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Remarks</h4>
            </div>

            <div class="modal-body">
                <div class="form-group form_container_elements">
                    <form  action="/inventory/save" id="info_frm3" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" id="er_product_id" name="product_id" />
                        <label class="control-label">Remarks</label>
                        <textarea id="edit_remarks_txt" name="remarks" class="form-control"></textarea>
                        
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default cancel_bttn">Cancel</button>
                <button type="button" class="btn btn-primary save_bttn">Submit</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="change_status_form_container" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Change Status</h4>
            </div>

            <div class="modal-body">
                <div class="form-group form_container_elements">
                    <form  action="/inventory/save" id="info_frm3" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" id="cs_product_id" name="product_id" />
                        <label class="control-label">Status</label>
                        <select name="status" id="change_status_sel" class="form-control" ><option value="1">Available</option><option value="0">Not available</option></select>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default cancel_bttn">Cancel</button>
                <button type="button" class="btn btn-primary save_bttn">Submit</button>
            </div>

        </div>
    </div>
</div>


@endsection

@push('css')
    <link href="/css/app/inventory.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="/js/app/inventory.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    
    <script type="text/javascript">
    $(document).ready(function(){
        @if ($can_edit)
        $(".edit_bttn").click(function(){
            $.get( "/inventory/get/" + $(this).attr("id").replace("edit_prod_",""), function( data ) {
                var editPopup = $("#new_product_form_container").clone();
                editPopup.attr("id","edit_product");
                editPopup.find(".modal-title").html("Edit product " + data.item);
                editPopup.find("[name=category]").val(data.category);
                editPopup.find("[name=item_number]").val(data.item_number);
                editPopup.find("[name=item]").val(data.item);
                editPopup.find("[name=warehouse]").val(data.warehouse);
                editPopup.find("[name=store_room]").val(data.store_room);
                editPopup.find("[name=unit_price]").val(data.unit_price);
                editPopup.find("[name=status]").val(data.status);
                editPopup.find("[name=remarks]").val(data.remarks);
                editPopup.find("[name=low_stock_amount]").val(data.low_stock_amount);
                editPopup.find("form").append('<input type="hidden" name="product_id" value="' + data.id + '" />');
                var companies;
                if(data.companies != null && data.companies.length > 0)
                    companies = data.companies.split(',');
                else
                    companies = [];
                editPopup.find('input[type=checkbox]').each(function(){
                    var checked = companies.indexOf($(this).val());
                    if(checked > -1)
                        $(this).attr('checked', 'checked');

                });

                var unlimited_stock = data.unlimited_stock;
                if(unlimited_stock == 1) {
                    editPopup.find('#unlimited_1').attr('checked', 'checked');
                    editPopup.find("#warehouse").attr("readonly", "true");
                    editPopup.find("#store_room").attr("readonly", "true");
                    editPopup.find("#low_stock_amount").attr("readonly", "true");
                    editPopup.find("#warehouse").attr("placeholder", "unlimited");
                    editPopup.find("#store_room").attr("placeholder", "unlimited");
                    editPopup.find("#low_stock_amount").attr("placeholder", "unlimited");
                } else{
                    editPopup.find('#unlimited_0').attr('checked', 'checked');
                    editPopup.find("#warehouse").removeAttr("readonly");
                    editPopup.find("#store_room").removeAttr("readonly");
                    editPopup.find("#low_stock_amount").removeAttr("readonly");
                    editPopup.find("#warehouse").attr("placeholder", "");
                    editPopup.find("#store_room").attr("placeholder", "");
                    editPopup.find("#low_stock_amount").attr("placeholder", "");
                }
                editPopup.modal("show");
                
                editPopup.find(".save_bttn").click(function(){
                    editPopup.find("form").submit();
                });
                editPopup.find(".cancel_bttn").click(function(){
                    editPopup.modal("hide");
                    
                    editPopup.on('hide', function () {
                        editPopup.remove();
                    })
                });

                editPopup.find('input:radio[name="unlimited_stock"]').change(
                    function(){

                        if ($(this).is(':checked') && $(this).val() == '1') {
                            editPopup.find("#warehouse").attr("readonly", "true");
                            editPopup.find("#store_room").attr("readonly", "true");
                            editPopup.find("#low_stock_amount").attr("readonly", "true");
                            editPopup.find("#warehouse").attr("placeholder", "unlimited");
                            editPopup.find("#store_room").attr("placeholder", "unlimited");
                            editPopup.find("#low_stock_amount").attr("placeholder", "unlimited");
                        }
                        else{
                            editPopup.find("#warehouse").removeAttr("readonly");
                            editPopup.find("#store_room").removeAttr("readonly");
                            editPopup.find("#low_stock_amount").removeAttr("readonly");
                            editPopup.find("#warehouse").attr("placeholder", "");
                            editPopup.find("#store_room").attr("placeholder", "");
                            editPopup.find("#low_stock_amount").attr("placeholder", "");
                        }
                    });
            }, "json");



        });
        @endif;

        @if ($can_delete)
        $(".delete_bttn").click(function(){
            if (confirm("Are you sure?")){
                window.location = "/inventory/delete/" + $(this).attr("id").replace("delete_prod_","");
            }
        });
        @endif;
        


        $('.btn-filter').click(function(){
            var form = $("#search_form");
            $.ajax({
                url: "/inventory/filter",
                method: "POST",
                dataType: "html",
                data: form.serialize(),

                statusCode: {
                    401: function() {
                        alert( "Login expired. Please sign in again." );
                    }
                },
                success: function (html) {
                    $("#product_items").html(html);
                }
            });
        });

        /*$(".filter_check").change(function () {
            filterProducts();
        });
*/
        $('.btn-clear').click(function () {

            $('#search_word').val('');
            $('.filter_check').each(function(){
                $(this).attr('checked', false);
            })
            window.location = "/inventory";
        });

        $("#from_stock").change(function () {
           if($(this).val() == "w")
               $("#to_stock").val('s');
            else
               $("#to_stock").val('w');
        });

        $("#to_stock").change(function () {
            if($(this).val() == "w")
                $("#from_stock").val('s');
            else
                $("#from_stock").val('w');
        });

    });

    </script>
@endpush