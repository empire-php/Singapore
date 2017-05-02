@extends('layouts.app')

@section('content')
<style>
 .price_col{
     text-align: right; 
           }
</style>
<div class="row" id="{{ $id }}">
    <div class="col-md-12" style="width: 100%">

      
<div class="section section-two">  
            <div class="page-header wsc-number-payment" id="<?php echo $wsc;?>">
                <h3> Transaction Summary </h3>
            </div>
           
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <th style="padding:5px">
                        <em class="fa-fw fa-plus fa" ></em>/<em class="fa-fw fa-minus fa" ></em>      
                    </th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Form</th>
                    <th>Sales Order ref# / Receipt ref#</th>
                    <th>Sub-total</th>
                    <th>GST</th>
                    <th>Total Amount</th>
                    <th></th>
                    
                </thead>
                <tbody>
                       
                    <?php  foreach($data as $key => $ordersales): ?>
                  
                    <?php if($ordersales): ?>
                        <?php if($key=="fa" ) { ?>
                  
                            <?php $order_nr = ucwords(substr($key, 0,1)); ?>
                   
                                        <tr>
                                            <td>
                                                <em class="fa-fw fa-plus fa" onclick="collapseTable(this);"></em>     
                                            </td>
                                            <td><?php echo date("d/m/Y",strtotime($ordersales->updated_at)); ?></td>
                                            <td>Sales order</td>
                                            <td>/ <?php echo $key; ?></td>
                                            <td class='wsc-number'><?php echo $key=="fa" ? "WSC".$ordersales->generated_code : $order_nr.$ordersales->order_nr ?></td>
                                            <td class="sub-total price_col">$
                                                <?php if($key == "columbarium"){ ?>
                                                <?php $decode = json_decode($ordersales->item_selection,true); ?>
                                                <?php echo $decode['subtotal'] ? number_format($decode['subtotal'],2) : 0;  ?>
                                                <?php } else if( $key == "gemstone") {  ?>
                                                <?php $decode = json_decode($ordersales->order_items,true); ?>
                                                <?php echo $decode['subtotal'] !="" ? number_format($decode['subtotal'],2) : 0; ?>
                                                <?php } else if($key == "fa") { ?>
                                                <?php $purch = json_decode($ordersales->purchased_items,true); 

                                                      if($purch['hearse_price']){
                                                         echo $ordersales->sub_total ? number_format($ordersales->sub_total-$purch['hearse_price'],2) : 0 ;
                                                      }else{
                                                ?>

                                                <?php echo $ordersales->sub_total ? number_format($ordersales->sub_total,2) : 0  ?>
                                                <?php }} else if($key == "hearse" || $key == "parlour") { ?>
                                                <?php echo $ordersales->total_price ? number_format($ordersales->total_price,2) : 0; ?>
                                                <?php }  ?>
                                            </td>
                                            <td class="gts-amount price_col"></td>
                                            <td class="total-with-gst price_col"></td>
                                            <td><a href="<?php echo url($key); ?>/view/<?php echo $ordersales->id; ?>">View full form</a></td>
                                        </tr>


                                        <!-- Start Order form info detail view part-->  
                                        
                                        <tr style="display:none">
                                            <td colspan="9" class="order-form-detail">

                                                <!--Detail view with sub - table-->

                                                <table class="table sub-table table-bordered table-hover">
                                                    <thead>
                                                        <th>
                                                            Category
                                                        </th>
                                                        <th>
                                                            Item
                                                        </th>
                                                        <th>
                                                            Quantity
                                                        </th>
                                                        <th>
                                                            Unit Price
                                                        </th>
                                                        <th>
                                                            Amount
                                                        </th>
                                                    </thead>
                                                    <tbody>

                                                        <?php if ($key == "fa") { ?>
                                                            <?php if($ordersales->package_total && $ordersales->package_items){

                                                                $items = str_replace("w", "",$ordersales->package_items);
                                                                $items = str_replace("Select location", "",$items);
                                                                $items = explode(",", $items);

                                                                    $rows = \App\FaPackageItems::where("id",$items[0])->first();
                                                                    $package = \App\FaPackage::where("id",$rows->fa_package_id)->first();
                                                                ?>
                                                         <tr>
                                                            <td><?php echo $package->category; ?></td>
                                                            <td><?php echo $package->name;?></td>
                                                            <td>1</td>
<!--                                                            <td class="price_col">$<?php //echo number_format($package->promo_price,2); ?></td>
                                                            <td class = "amount price_col">$<?php //echo number_format($package->promo_price,2); ?></td>-->
                                                             <td class="price_col">$<?php echo number_format($ordersales->package_total,2); ?></td>
                                                            <td class = "amount price_col">$<?php echo number_format($ordersales->package_total,2); ?></td>
                                                         </tr>
                                                        <?php


                                                            } ?>
                                                        <?php $purchased = json_decode($ordersales->purchased_items,true); ?>
                                                        <?php foreach ($purchased['ac'] as $key => $purchaseds) :

                                                                if(count($purchaseds)> 0){ 
                                                                $get_item = \App\SettingsGroupedItems::where("id",$purchaseds['selection_item'])->first();
                                                             ?>
                                                        <tr>
                                                            <td><?php echo $get_item->selection_category; ?></td>
                                                            <td><?php echo $get_item->selection_item_name;?></td>
                                                            <td>1</td>
                                                            <td class="price_col" >$<?php echo number_format($get_item->unit_price,2); ?></td>
                                                            <td class = "amount price_col">$<?php echo number_format($get_item->unit_price,2); ?></td>
                                                        </tr>
                                                            <?php }  ?>
                                                        <?php endforeach; ?>

                                                        <?php } else if ($key == "hearse" || $key == "parlour"){ ?>

                                                            <tr>
                                                                <td><?php echo ucfirst($key); ?></td>
                                                                <td><?php echo $ordersales->$key."_name"; ?></td>
                                                                <td class=""><?php echo $ordersales->total_price/$ordersales->unit_price ?></td>
                                                                <td class="price_col">$<?php echo number_format($ordersales->unit_price,2); ?></td>
                                                                <td class = "amount price_col">$<?php echo number_format($ordersales->total_price,2); ?></td>
                                                            </tr>


                                                        <?php } else if ($key == "gemstone"){ ?>
                                                        <?php   $gem = json_decode($ordersales->order_items,true); ?>

                                                            <tr>
                                                                <td><?php echo $gem['product'][0] !="" ? "Gemstone" :"" ?></td>
                                                                <td><?php echo $gem['product'][0]; ?></td>
                                                                <td><?php echo $gem['quantity'][0]; ?></td>
                                                                <td class="price_col">$<?php echo number_format($gem['price'][0],2); ?></td>
                                                                <td class = "amount price_col">$<?php echo $gem['subtotal'] !=""  ? number_format($gem['subtotal'],2) : 0; ?></td>
                                                            </tr>

                                                        <?php } else if($key == "columbarium") { ?>
                                                        <?php   $col = json_decode($ordersales->item_selection,true); ?>

                                                            <tr>
                                                                <td><?php echo $col['selection'][0] !="" ? "Columbarium" :"" ?></td>
                                                                <td><?php echo $col['selection'][0]; ?></td>
                                                                <td>1</td>
                                                                <td class="price_col">$<?php echo $col['subtotal'] !=""  ? number_format($col['subtotal'],2) : 0; ?></td>
                                                                <td class = "amount price_col">$<?php echo $col['subtotal'] !=""  ? number_format($col['subtotal'],2) : 0; ?></td>
                                                            </tr>

                                                        <?php } ?>
                                                        <!--For order sub-table details-->
                                                        <tr ><td colspan="5" style="border-bottom: 1px red solid"></td></tr>
                                                        <tr class="total-amount-order">
                                                            <td></td><td></td><td></td><td>Sub-total</td><td class="sub-total-for-table price_col"></td>
                                                        </tr>
                                                        <tr class="total-amount-order">
                                                            <td></td><td></td><td></td><td>GST</td><td class="gts-for-table price_col"></td>
                                                        </tr>
                                                        <tr class="total-amount-order">
                                                            <td></td><td></td><td></td> <td>Total Amount</td><td class="total-for-table price_col"></td>
                                                        </tr>






                                                       <!--End--> 
                                                    </tbody>
                                                </table>
                                                <!--End sub-table--> 
                                            </td>
                                        </tr>

                 
                             <?php } else {  ?>
                                
                                      <?php  foreach($ordersales as $keys => $order ){ ?>
                    
                                             <?php $order_nr = ucwords(substr($key, 0,1)); ?>
                   
                                        <tr>
                                            <td>
                                                <em class="fa-fw fa-plus fa" onclick="collapseTable(this);"></em>     
                                            </td>
                                            <td><?php echo date("d/m/Y",strtotime($order->updated_at)); ?></td>
                                            <td>Sales order</td>
                                            <td>/ <?php echo $key; ?></td>
                                            <td class='wsc-number'><?php echo $key=="fa" ? "WSC".$order->generated_code : $order_nr.$order->order_nr ?></td>
                                            <td class="sub-total price_col">$
                                                <?php if($key == "columbarium"){ ?>
                                                <?php $decode = json_decode($order->item_selection,true); ?>
                                                <?php echo $decode['subtotal'] ? number_format($decode['subtotal'],2) : 0;  ?>
                                                <?php } else if( $key == "gemstone") {  ?>
                                                <?php $decode = json_decode($order->order_items,true); ?>
                                                <?php echo $decode['subtotal'] !="" ? number_format($decode['subtotal'],2) : 0; ?>
                                                <?php } else if($key == "fa") { ?>
                                                <?php $purch = json_decode($order->purchased_items,true); 

                                                      if($purch['hearse_price']){
                                                         echo $order->sub_total ? number_format($order->sub_total-$purch['hearse_price'],2) : 0 ;
                                                      }else{
                                                ?>

                                                <?php echo $order->sub_total ? number_format($order->sub_total,2) : 0  ?>
                                                <?php }} else if($key == "hearse" || $key == "parlour") { ?>
                                                <?php echo $order->total_price ? number_format($order->total_price,2) : 0; ?>
                                                <?php }  ?>
                                            </td>
                                            <td class="gts-amount price_col"></td>
                                            <td class="total-with-gst price_col"></td>
                                            <td><a href="<?php echo url($key); ?>/view/<?php echo $order->id; ?>">View full form</a></td>
                                        </tr>


                                        <!-- Start Order form info detail view part-->  

                                        <tr style="display:none">
                                            <td colspan="9" class="order-form-detail">

                                                <!--Detail view with sub - table-->

                                                <table class="table sub-table table-bordered table-hover">
                                                    <thead>
                                                        <th>
                                                            Category
                                                        </th>
                                                        <th>
                                                            Item
                                                        </th>
                                                        <th>
                                                            Quantity
                                                        </th>
                                                        <th>
                                                            Unit Price
                                                        </th>
                                                        <th>
                                                            Amount
                                                        </th>
                                                    </thead>
                                                    <tbody>

                                                        <?php if ($key == "fa") { ?>
                                                            <?php if($order->package_total && $order->package_items){

                                                                $items = str_replace("w", "",$order->package_items);
                                                                $items = str_replace("Select location", "",$items);
                                                                $items = explode(",", $items);

                                                                    $rows = \App\FaPackageItems::where("id",$items[0])->first();
                                                                    $package = \App\FaPackage::where("id",$rows->fa_package_id)->first();
                                                                ?>
                                                         <tr>
                                                            <td><?php echo $package->category; ?></td>
                                                            <td><?php echo $package->name;?></td>
                                                            <td>1</td>
                                                            <td class="price_col">$<?php echo number_format($package->promo_price,2); ?></td>
                                                            <td class = "amount price_col">$<?php echo number_format($package->promo_price,2); ?></td>
                                                         </tr>
                                                        <?php


                                                            } ?>
                                                        <?php $purchased = json_decode($order->purchased_items,true); ?>
                                                        <?php foreach ($purchased['ac'] as $key => $purchaseds) :

                                                                if(count($purchaseds)> 0){ 
                                                                $get_item = \App\SettingsGroupedItems::where("id",$purchaseds['selection_item'])->first();
                                                             ?>
                                                        <tr>
                                                            <td><?php echo $get_item->selection_category; ?></td>
                                                            <td><?php echo $get_item->selection_item_name;?></td>
                                                            <td>1</td>
                                                            <td class="price_col" >$<?php echo number_format($get_item->unit_price,2); ?></td>
                                                            <td class = "amount price_col">$<?php echo number_format($get_item->unit_price,2); ?></td>
                                                        </tr>
                                                            <?php }  ?>
                                                        <?php endforeach; ?>

                                                        <?php } else if ($key == "hearse" || $key == "parlour"){ ?>

                                                            <tr>
                                                                <td><?php echo ucfirst($key); ?></td>
                                                                <td><?php echo $order->$key."_name"; ?></td>
                                                                <td class=""><?php echo (Float)$order->total_price/(Float)$order->unit_price ?></td>
                                                                <td class="price_col">$<?php echo number_format((Float)$order->unit_price,2); ?></td>
                                                                <td class = "amount price_col">$<?php echo number_format((Float)$order->total_price,2); ?></td>
                                                            </tr>


                                                        <?php } else if ($key == "gemstone"){ ?>
                                                        <?php   $gem = json_decode($order->order_items,true); ?>

                                                            <tr>
                                                                <td><?php echo $gem['product'][0] !="" ? "Gemstone" :"" ?></td>
                                                                <td><?php echo $gem['product'][0]; ?></td>
                                                                <td><?php echo $gem['quantity'][0]; ?></td>
                                                                <td class="price_col">$<?php echo number_format($gem['price'][0],2); ?></td>
                                                                <td class = "amount price_col">$<?php echo $gem['subtotal'] !=""  ? number_format($gem['subtotal'],2) : 0; ?></td>
                                                            </tr>

                                                        <?php } else if($key == "columbarium") { ?>
                                                        <?php   $col = json_decode($order->item_selection,true); ?>

                                                            <tr>
                                                                <td><?php echo $col['selection'][0] !="" ? "Columbarium" :"" ?></td>
                                                                <td><?php echo $col['selection'][0]; ?></td>
                                                                <td>1</td>
                                                                <td class="price_col">$<?php echo $col['subtotal'] !=""  ? number_format($col['subtotal'],2) : 0; ?></td>
                                                                <td class = "amount price_col">$<?php echo $col['subtotal'] !=""  ? number_format($col['subtotal'],2) : 0; ?></td>
                                                            </tr>

                                                        <?php } ?>
                                                        <!--For order sub-table details-->
                                                         <tr ><td colspan="5" style="border-bottom: 1px red solid"></td></tr>
                                                        <tr class="total-amount-order">
                                                            <td></td><td></td><td></td><td>Sub-total</td><td class="sub-total-for-table price_col"></td>
                                                        </tr>
                                                        <tr class="total-amount-order">
                                                            <td></td><td></td><td></td><td>GST</td><td class="gts-for-table price_col"></td>
                                                        </tr>
                                                        <tr class="total-amount-order">
                                                            <td></td><td></td><td></td> <td>Total Amount</td><td class="total-for-table price_col"></td>
                                                        </tr>






                                                       <!--End--> 
                                                    </tbody>
                                                </table>
                                                <!--End sub-table--> 
                                            </td>
                                        </tr>
                   
                                      <?php } ?>
                            <?php } ?>
                    <?php endif; ?>
                  
                    <?php endforeach; ?>
                  
                    <!--Sub - table for payment information--> 
                    <?php $data = \App\SalesOrder::where("wsc",$wsc)->orderBy("id","ASC")->get(); ?>
                    <?php foreach ($data as $key => $datas): ?>
                   
                    <tr>
                        <td>
                             <em class="fa-fw fa-plus fa" onclick="collapseTable(this);"></em>     
                        </td>
                        <td><?php echo date("d/m/Y",strtotime($datas->updated_at)); ?> </td>
                        <td>Payment</td>
                        <td>
                            <?php if($datas->pay_mode == 1) {
                                      echo "Cash";
                                  }else if ($datas->pay_mode == 2) {
                                      echo "NETS";
                                  }else if ($datas->pay_mode == 3) {
                                      echo "cheque";
                                  } else {
                                      echo "credit card";
                                  } 
                            ?>
                        </td>
                        <td><?php echo $datas->receiption_num; ?></td>
                        <td></td>
                        <td></td>
                        <td class="price_col" style='color:red' id="paid_amount_<?php echo $key; ?>">(<?php echo $datas->amount<0 ? "-$".number_format(abs($datas->amount),2) : "$".number_format($datas->amount,2); ?>)</td>
                        <td>View <a href="<?php echo url('public/uploads')."/".$datas->receiption_num.".pdf"; ?>" target="blank">company</a>/<a href="<?php echo url('public/uploads')."/customer-".$datas->receiption_num.".pdf"; ?>" target="blank">customer</a> receipt</td>
                    </tr>
                    
                    
                    
                    <tr style="display:none">
                         <td colspan="9" class="order-form-detail">
                            
                            <!--Detail view with sub - table-->
                            
                            <table class="table sub-table-payment table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Previous balance</td><td class="privious_balance_<?php echo $key; ?>">$<?php echo number_format((Float)$datas->previous_balance,2); ?></td>
                                    </tr>
                                    <tr>
                                         <td>Payment Date</td><td><?php echo date('d/m/Y',strtotime($datas->updated_at));?></td>
                                    </tr>
                                    <tr>
                                         <td>Payment mode</td>
                                         <td>
                                             <?php if($datas->pay_mode == 1){
                                                       echo "Cash";
                                                   }else if($datas->pay_mode == 2){
                                                       echo "NETS";
                                                   }else if($datas->pay_mode == 3){
                                                       echo "cheque";
                                                   }else {
                                                       echo "Credit card";
                                                   }
                                             ?>
                                         </td>
                                    </tr>
                                    <tr>
                                         <td>Payment amount</td><td class=""><?php echo $datas->amount<0 ? "-$".number_format(abs($datas->amount),2) : "$".number_format($datas->amount,2); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Balance amount</td><td class="" id="current_balance_<?php echo $key; ?>"></td>
                                    </tr>
                                    <tr>
                                         <td>Description</td><td class=""><?php echo $datas->description; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Collected by</td><td class=""><?php $user = \App\User::where("id",$datas->user_id)->first(); echo $user->name; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                         </td>
                    </tr>
                    
                    <?php endforeach; ?>
                    <!--End table for payment information--> 
                    <!--Outstanding and Button--> 
                  
                    <tr style="height:40px;border:0">
                        <td colspan="2" style="height:100px;border:0;vertical-align: middle">Total outstanding</td><td style="height:100px;border:0;vertical-align: middle" class="total-outstanding"></td>
                    </tr>
                    </br>
                    <tr >
                        <td colspan="3" style="height:100px;border:0;vertical-align: middle"><a href="javascript:void(0)" class="btn btn-success btn-for-payment-popup" onclick="popup();">Make Payment</a></td>
                    </tr>
                    <!--End Outstanding and Button-->
                </tbody>
            </table>
            <!--End detail view table--> 
        </div>
          
      </div>
    </div>
</div>


<!--Popup for make payment button event-->
<div class="modal fade" id="make_payment_popup" tabindex="-1" role="dialog">
     <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
    <input type="hidden" value="<?php echo date('m/d/Y',time()); ?>" name="payment_date" id="payment_date" />
    <input type="hidden" value="<?php $user = Auth::user();echo $user['id']; ?>" id="payment_user_id" />
    <div class="modal-dialog" role="document" style="width:40%">
            <div class="modal-content">
                <div class="modal-header" style="border:0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">payment details</h4>
                </div>

                <div class="modal-body" style="padding:0">
                    <div class="col-md-6" style="width:100%;text-align: center;">
                        <table class="table popup-table">
                            <tr>
                                <td>Payment date & time</td><td><?php echo date('m/d/Y',time());?></td>
                            </tr>
                            <tr>
                                <td>Payment amount</td><td><input class="form-control" type="text" id="payment_amount" /></td>
                            </tr>
                            <tr>
                                <td>Payment mode</td>
                                <td>
                                    <select class="form-control" name = "payment-mode-popup" id="payment_mode_popup">
                                        <option value="1">Cash</option>
                                        <option value="2">NET</option>
                                        <option value="3">cheque</option>
                                        <option value="4">Credit Card</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Payment reference/description</td><td><input class="form-control" type="text" id="payment_description" /></td>
                            </tr>
                            <tr>
                                <td></td> <td></td>
                            </tr>
                            <tr>
                                <td>Collected by</td><td><?php $user = Auth::user();echo $user['name']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default payment-submit" onclick="submit_payment()">Submit</button>
                </div>

            </div>
        </div>
    </div>
<!--End popup for make payment button event-->



@endsection

@push('css')
  
    <link href="/css/app/salesorder.css" rel="stylesheet">
@endpush

@push('scripts')

    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/salesorder.js"></script>
   
    
@endpush