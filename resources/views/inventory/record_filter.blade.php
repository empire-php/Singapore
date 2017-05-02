<table id="table" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th rowspan="2">Date</th>
        <th rowspan="2">User Name</th>
        <th rowspan="2">Type</th>
        <th rowspan="2">Category</th>
        <th colspan="3" style="text-align: center; cursor: default;">Companies</th>
        <th rowspan="2">Item no</th>
        <th rowspan="2">Description</th>
        <th rowspan="2">Unit Price</th>
        <th colspan="3" style="text-align: center; cursor: default;">Added to</th>
        <th colspan="3" style="text-align: center; cursor: default;">Remove from</th>
        <th colspan="3" style="text-align: center; cursor: default;">Balance</th>
        <th rowspan="2">Reference no</th>
        <th rowspan="2">Sales Order</th>
    </tr>
    <tr>
        @foreach($companies as $company)
            <th>{{$company->name}}</th>
        @endforeach
        <th>Warehouse</th>
        <th>Store room</th>
        <th>Total Balance</th>
        <th>Warehouse</th>
        <th>Store room</th>
        <th>Total Balance</th>
        <th>Warehouse</th>
        <th>Store room</th>
        <th>Total Balance</th>
    </tr>
    </thead>

    <tbody id="filter_body">
    @foreach($histories as $history)
        <tr>
            <td>
                <?php
                $date = new DateTime($history->editable_date_modif);
                echo $date->format('d/m/Y H:i');
                ?>
            </td>
            <td>{{ $history->user->name }}</td>
            <td>{{ $history->type }}</td>
            <td>{{ $history->product->category }}</td>
            <?php
            if (!empty($history->product->companies))
                $product_companies = explode(',', $history->product->companies);
            else
                $product_companies = [];
            ?>
            @for($i=0; $i<count($companies); $i++)
                <td align="center" style="color:#00a957;">
                    @if(in_array($companies[$i]->id, $product_companies))
                        <i class="fa fa-check" aria-hidden="true"></i>
                    @endif
                </td>
            @endfor
            <td>{{ $history->product->item_number }}</td>
            <td>{{ $history->remarks }}</td>
            <td>@if($history->product->unit_price != 0){{ $history->product->unit_price }}@endif</td>
            <?php
            if (empty($history->warehouse))
                $history->warehouse = 0;
            if (empty($history->store_room))
                $history->store_room = 0;

            if ($history->warehouse > 0) {
                $add_warehouse = $history->warehouse;
                $remove_warehouse = 0;
            } else {
                $add_warehouse = 0;
                $remove_warehouse = $history->warehouse;
            }

            if ($history->store_room > 0) {
                $add_store_room = $history->store_room;
                $remove_store_room = 0;
            } else {
                $add_store_room = 0;
                $remove_store_room = $history->store_room;
            }

            $add_balance = $add_warehouse + $add_store_room;
            $remove_balance = $remove_warehouse + $remove_store_room;

            $total_balance = $history->balance_w +  $history->balance_s;
            ?>
            <td>@if($add_warehouse != 0){{ $add_warehouse }}@endif</td>
            <td>@if($add_store_room != 0){{ $add_store_room }}@endif</td>
            <td>@if($add_balance != 0){{ $add_balance }}@endif</td>
            <td>@if($remove_warehouse != 0){{ abs($remove_warehouse) }}@endif</td>
            <td>@if($remove_store_room != 0){{ abs($remove_store_room) }}@endif</td>
            <td>@if($remove_balance != 0){{ abs($remove_balance) }}@endif</td>
            <td>@if($history->balance_w != 0){{ $history->balance_w }}@endif</td>
            <td>@if($history->balance_s != 0){{ $history->balance_s }}@endif</td>
            <td>@if($total_balance !=0 ){{ $history->balance_w +  $history->balance_s }}@endif</td>
            <td>{{ $history->reference_no }}</td>
            <td>{{ $history->sales_order }}</td>
        </tr>

    @endforeach

    </tbody>

</table>