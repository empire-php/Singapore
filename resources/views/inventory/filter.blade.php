@if(isset($categories))
    <?php $nr = 0; ?>
    @foreach($categories as $category)

        <?php

        $products = App\Products::where("is_deleted",0)->where('category', $category)->get();

        if(isset($search_word) && !empty($search_word)) {

            $products = $products->filter(function ($product) use ($search_word) {
                return strpos(strtolower($product->remarks), strtolower($search_word))!== false || strpos(strtolower($product->item_number), strtolower($search_word)) !== false || strpos(strtolower($product->item), strtolower($search_word)) !== false;
            });

        }


        if (isset($filter_companies) && count($filter_companies) > 0) {
            $products = $products->filter(function ($product) use ($filter_companies) {
                $companies = explode(',', $product->companies);
                return count(array_intersect($companies, $filter_companies)) == count($filter_companies);
            });
        }

        ?>
        @if(count($products) > 0 )

        <div class="panel panel-default" id="category">
            <div class="panel-heading" role="tab" id="heading{{$nr}}">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$nr}}" aria-expanded="false" aria-controls="collapse{{$nr}}">
                        <em class="fa fa-fw fa-plus"></em> {{$category}} &nbsp;&nbsp; ({{count($products)}})
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
                            <?php $all_companies = App\Company::all(); ?>
                            @foreach($all_companies as $all_company)
                                <th>{{$all_company->name}}</th>
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
                                    @if($product->unlimited_stock == 0)
                                        {{$product->warehouse}}
                                    @else
                                        Unlimited
                                    @endif
                                </td>
                                <td>
                                    @if($product->unlimited_stock == 0)
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
                                @for($i=0; $i<count($all_companies); $i++)
                                    <td align="center" style="color:#00a957;">
                                        @if(in_array($all_companies[$i]->id, $product_companies))
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
        @endif

    @endforeach

@endif