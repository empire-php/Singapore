<div class="section section-two">  
            <div class="page-header">
                    Transaction Summary
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
                    <?php $order_nr = ucwords(substr($key, 0,1)); ?>
                    <tr>
                        <td>
                            <em class="fa-fw fa-plus fa" onclick="collapseTable(this);"></em>     
                        </td>
                        <td><?php echo date("d/m/Y",strtotime($ordersales->updated_at)); ?></td>
                        <td>Sales order</td>
                        <td>/ <?php echo $key; ?></td>
                        <td><?php echo $key=="fa" ? "WSC".$ordersales->generated_code : $order_nr.$ordersales->order_nr ?></td>
                        <td class="sub-total">$
                            <?php if($key == "columbarium"){ ?>
                            <?php $decode = json_decode($ordersales->item_selection,true); ?>
                            <?php echo $decode['subtotal'] ? $decode['subtotal'] : 0;  ?>
                            <?php } else if( $key == "gemstone") {  ?>
                            <?php $decode = json_decode($ordersales->order_items,true); ?>
                            <?php echo $decode['subtotal'] !="" ? $decode['subtotal'] : 0; ?>
                            <?php } else if($key == "fa") { ?>
                            <?php echo $ordersales->sub_total ? $ordersales->sub_total : 0  ?>
                            <?php } else if($key == "hearse" || $key == "parlour") { ?>
                            <?php echo $ordersales->unit_price ? $ordersales->unit_price : 0; ?>
                            <?php }  ?>
                        </td>
                        <td class="gts-amount"></td>
                        <td class="total-with-gst"></td>
                        <td><a href="<?php echo $key; ?>/view/<?php echo $ordersales->id; ?>">View full form</a></td>
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
                                    <?php $purchased = json_decode($ordersales->purchased_items,true); ?>
                                    <?php foreach ($purchased['ac'] as $key => $purchaseds) :
                                            if(isset($purchaseds['selection_item'])){ 
                                            $get_item = \App\SettingsGroupedItems::where("id",$purchaseds['selection_item'])->first();
                                         ?>
                                    <tr>
                                        <td><?php echo $get_item->selection_category; ?></td>
                                        <td><?php echo $get_item->selection_item_name;?></td>
                                        <td>1</td>
                                        <td>$<?php echo $get_item->unit_price; ?></td>
                                        <td class = "amount">$<?php echo $get_item->unit_price; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php endforeach; ?>
                                    <?php } else if ($key == "hearse" || $key == "parlour"){ ?>
                                
                                        <tr>
                                            <td><?php echo ucfirst($key); ?></td>
                                            <td><?php echo $ordersales->$key."_name"; ?></td>
                                            <td>1</td>
                                            <td>$<?php echo $ordersales->unit_price; ?></td>
                                            <td class = "amount">$<?php echo $ordersales->unit_price; ?></td>
                                        </tr>
                                 
                                  
                                    <?php } else if ($key == "gemstone"){ ?>
                                    <?php   $gem = json_decode($ordersales->order_items,true); ?>
                                   
                                        <tr>
                                            <td><?php echo $gem['product'][0] !="" ? "Gemstone" :"" ?></td>
                                            <td><?php echo $gem['product'][0]; ?></td>
                                            <td><?php echo $gem['quantity'][0]; ?></td>
                                            <td>$<?php echo $gem['price'][0]; ?></td>
                                            <td class = "amount">$<?php echo $gem['subtotal'] !=""  ? $gem['subtotal'] : 0; ?></td>
                                        </tr>
                                        
                                    <?php } else if($key == "columbarium") { ?>
                                    <?php   $col = json_decode($ordersales->item_selection,true); ?>
                                 
                                        <tr>
                                            <td><?php echo $col['selection'][0] !="" ? "Columbarium" :"" ?></td>
                                            <td><?php echo $col['selection'][0]; ?></td>
                                            <td>1</td>
                                            <td>$<?php echo $col['subtotal'] !=""  ? $col['subtotal'] : 0; ?></td>
                                            <td class = "amount">$<?php echo $col['subtotal'] !=""  ? $col['subtotal'] : 0; ?></td>
                                        </tr>
                                        
                                    <?php } ?>
                                    <!--For order sub-table details-->
                                    <tr class="total-amount-order">
                                        <td></td><td></td><td></td><td>Sub-total</td><td class="sub-total-for-table"></td>
                                    </tr>
                                    <tr class="total-amount-order">
                                        <td></td><td></td><td></td><td>GST</td><td class="gts-for-table"></td>
                                    </tr>
                                    <tr class="total-amount-order">
                                        <td></td><td></td><td></td> <td>Total Amount</td><td class="total-for-table"></td>
                                    </tr>
                                  
                                        
                            
                                   
                                       
                                   
                                   <!--End--> 
                                </tbody>
                            </table>
                            <!--End sub-table--> 
                        </td>
                    </tr>
                      <?php endif; ?>    
                    <?php endforeach; ?>
                  
                    <!--Sub - table for payment information--> 
                    <?php $data = \App\SalesOrder::where("wsc",$wsc)->get(); ?>
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
                        <td style='color:red' id="paid_amount_<?php echo $key; ?>">$<?php echo $datas->amount; ?></td>
                        <td><a href="<?php echo url('public/uploads')."/".$datas->receiption_num.".pdf"; ?>" target="blank">View receipt</a></td>
                    </tr>
                    
                    
                    
                    <tr style="display:none">
                         <td colspan="9" class="order-form-detail">
                            
                            <!--Detail view with sub - table-->
                            
                            <table class="table sub-table-payment table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Previous balance</td><td class="privious_balance_<?php echo $key; ?>"></td>
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
                                         <td>Payment amount</td><td>$<?php echo $datas->amount; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Balance amount</td><td id="current_balance_<?php echo $key; ?>"></td>
                                    </tr>
                                    <tr>
                                         <td>Description</td><td><?php echo $datas->description; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Collected by</td><td><?php $user = \App\User::where("id",$datas->user_id)->first(); echo $user->name; ?></td>
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