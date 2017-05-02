<?php $total = 0;$paid=0;$totalGts = 0; ?>
<?php  foreach($data as $key => $ordersales): 
                     if($ordersales): 
                         if($key == "fa"){
                          if($key == "columbarium"){ 
                                 $decode = json_decode($ordersales->item_selection,true); 
                                 $total += $decode['subtotal'] ;
                          } else if( $key == "gemstone") {  
                                 $decode = json_decode($ordersales->order_items,true); 
                                 $total += $decode['subtotal'] ;
                          } else if($key == "fa") { 
                                 $total += $ordersales->sub_total ;
                          } else if($key == "parlour") { 
                                 $total += $ordersales->unit_price ;
                          } else if($key =="hearse") {
                                 
                                 $total += $ordersales->total_price;
                          } 
                         } else {
                             foreach ($ordersales as $orders){
                                 if($key == "columbarium"){ 
                                        $decode = json_decode($orders->item_selection,true); 
                                        $total += $decode['subtotal'] ;
                                 } else if( $key == "gemstone") {  
                                        $decode = json_decode($orders->order_items,true); 
                                        $total += $decode['subtotal'] ;
                                 } else if($key == "fa") { 
                                        $total += $orders->sub_total ;
                                 } else if($key == "parlour") { 
                                        $total += $orders->total_price ;
                                 } else if($key =="hearse") {
//                                     $total += $orders->total_price;
                                 }
                             }
                         }
                      endif;
      endforeach;
    
    //  $totals = explode(".", $total) ; 
      $totals = explode(".", $amount) ; 
    
     //   var_dump($total);exit;
      $formatw = number_format($total,2);
      $format= explode(".", $formatw);
     //   var_dump($total);exit;
      $dollars = $totals[0] ;
     
     if( isset($totals[1]) ){
         if(strlen($totals[1]) == 1){
             $cents =$totals[1]*10 ;
           
         }else{
             $cents =(int)$totals[1] ;
         }
     }else{
          $cents =0 ;
     }
      $session = new Symfony\Component\HttpFoundation\Session\Session();
      $company = $session->get('company_id');
      $company_name = \App\Company::where("id",$company)->first();
      
   function convertTowords($x){
       $nwords = array('zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 
					'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 
					'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 
					'Nineteen', 'Twenty', 30 => 'Thirty', 40 => 'Forty', 
					50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 
					90 => 'Ninety',
					'dollars' => 'dollars', 'cents' => 'cents');

		if(!is_float($x) && !is_numeric($x))
		{
			$w = '#';
		}
		else
		{
			if($x < 0)
			{
				$w = 'minus '; 
				$x = -$x; 
			}
			else
			{
				$w = ''; 
			}
			if($x < 21)
			{
				$w .= $nwords[$x];
			}
			else if($x < 100)
			{
				$w .= $nwords[10 * floor($x/10)];
				$r = fmod($x, 10);
				if($r > 0)
				{
					$w .= ' '. $nwords[$r];
				}
				
				/*if(is_float($x))
				{
					$w .= ' ' . $nwords['cents'];
				}
				else if(is_int($x))
				{
					$w .= ' ' . $nwords['dollars'];
				}*/
			}
			else if($x < 1000)
			{
				$w .= $nwords[floor($x/100)] .' Hundred and';
				$r = fmod($x, 100);
				if($r > 0)
				{
					$w .= '  '. convertTowords($r);
				}
			}
			else if($x < 1000000)
			{
				$w .= convertTowords(floor($x/1000)) .' Thousand ';
				$r = fmod($x, 1000);
				if($r > 0)
				{
					$w .= ' '; 
					if($r < 100)
					{
						$w .= 'and'; 
					}
					$w .= convertTowords($r); 
				}
			}
			else
			{
				$w .= convertTowords(floor($x/1000000)) .' Million'; 
				$r = fmod($x, 1000000);
				if($r > 0)
				{ 
					$w .= ' ';
					if($r < 100)
					{
						$word .= 'and ';
					}
					$w .= convertTowords($r);
				}
			}
		}
		return $w; 
   }
?>
<style>
    
    .table-bordered{
         width:90%;
         max-width: 90%;
      
        
         border-collapse: inherit;
         border-spacing: 0;
         padding:0;margin:0 0 20px 0;
         font-size:12px;
    }
    .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
             border: 0.5px solid #e0e7e8;
           
            }
            .table td, th{
                padding: 5px 10px;
      
               
            }
            .price_col{
                text-align: right;
                
            }
    
</style>
<div class="section section-two">  
            <div class="page-header" style="height:70px;text-align: center;border-style: solid;border-width: 1px">
                <h2>Company header</h2>
            </div><br>
            
            <div>
                <table style="width:100%; border-spacing: 3px">
                    <tr>
                        <td>Date & time</td><td><?php echo date('d/m/Y, h:m',time()); ?></td><td style='text-align:right'>Official receipt- Company copy</td>
                   </tr>
                   <tr>
                       <td>Reference No</td><td><?php echo $wsc; ?></td><td style='text-align:right'>Receipt no. <b><?php echo $reception_num; ?></b></td>
                   </tr>
                   <tr>
                       <td style="height:20px"></td>
                   </tr>
                   <tr>
                       <td>The sum in dollars</td><td><b> <?php echo convertTowords($dollars); ?>&nbsp;Dollars&nbsp;
                           <?php if($cents != 0){ ?>
                           and
                           <?php echo convertTowords($cents); ?> &nbsp;Cents Only
                           <?php } else  { echo "Only" ;}?>
                           </b></td><td></td>
                   </tr>
                   <tr>
                       <td>Payable to </td><td><?php echo $company_name->name;?></td><td></td>
                   </tr>
                   <tr>
                       <td>Payment method</td>
                       <td>
                           <?php $row = \App\SalesOrder::where("receiption_num",$reception_num)->first(); ?>
                           <?php if($row->pay_mode ==1){
                                echo "Cash";
                           }else if($row->pay_mode ==2){
                               echo "NETS";
                           }else if($row->pay_mode ==3){
                               echo "cheque";
                           }else {
                               echo "Credit card";
                           }
                           ?>
                       </td><td></td>
                   </tr>
                   <tr>
                       <td>Payment reference </td><td>Payment refer</td><td></td>
                   </tr>
                   <tr><td style="height:20px"></td></tr>
                   <tr>
                       <td>Payment for</td>
                   </tr>
                </table>
            </div>
            
            
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th  style="width:30px">Date</th>
                    <th  style="width:70px">Type</th>
                    <th  style="width:80px">Form</th>
                    <th style="width:180px">Sales Order ref# / Receipt ref#</th>
                    <th style="width:50px">Sub-total</th>
                    <th style="width:50px">GST</th>
                    <th style="width:80px">Total Payable</th>
                    <th style="width:80px">Amount Paid</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php  foreach($data as $key => $ordersales): ?>
                    <?php if($ordersales): ?>
                    
                      <?php if($key=="fa") { ?>
                    
                                    <?php $order_nr = ucwords(substr($key, 0,1)); ?>
                   
                                    <tr>
                                        <td><?php echo date("d/m/Y",strtotime($ordersales->updated_at)); ?></td>
                                        <td>Sales order</td>
                                        <td>/ <?php echo $key; ?></td>
                                        <td><?php echo $key=="fa" ? "WSC".$ordersales->generated_code : $order_nr.$ordersales->order_nr ?></td>
                                        <td class="sub-total price_col">$
                                            <?php 
                                             if($key == "columbarium"){ 
                                                     $decode = json_decode($ordersales->item_selection,true); 
                                                     echo $decode['subtotal'] ? number_format($decode['subtotal'],2) : 0; 

                                             ?>
                                                     </td><td class="gts-amount price_col">$<?php $gts = $decode['subtotal'] * 0.07;$totalGts +=$gts; echo number_format($gts,2); ?></td>
                                                    <td class="total-with-gst price_col">$<?php echo number_format($decode['subtotal']+ $gts,2); ?></td>
                                            <?php
                                             } else if( $key == "gemstone") {  
                                                     $decode = json_decode($ordersales->order_items,true); 
                                                     echo $decode['subtotal'] !="" ? number_format($decode['subtotal'],2) : 0;
                                             ?>         
                                                     </td><td class="gts-amount price_col">$<?php $gts = $decode['subtotal'] * 0.07;$totalGts +=$gts; echo number_format($gts,2); ?></td>
                                                    <td class="total-with-gst price_col">$<?php echo number_format($decode['subtotal']+ $gts,2); ?></td>
                                             <?php
                                             } else if($key == "fa") { ?>
                                                     <?php $purch = json_decode($ordersales->purchased_items,true); 

                                                  if($purch['hearse_price']){
                                                      $hearse = $purch['hearse_price'];
                                                     echo $ordersales->sub_total ? number_format($ordersales->sub_total-$purch['hearse_price'],2) : 0 ;?>
                                                     </td><td class="gts-amount price_col">$<?php $gts = ($ordersales->sub_total-$hearse) * 0.07;$totalGts+=$gts; echo number_format($gts,2); ?></td>
                                                    <td class="total-with-gst price_col">$<?php echo number_format($ordersales->sub_total+ $gts-$hearse,2); ?></td>
                                                    <?php
                                                  }else{  $hearse=0;
                                            ?>

                                            <?php echo $ordersales->sub_total ? number_format($ordersales->sub_total,2) : 0  ?>

                                                     </td><td class="gts-amount price_col">$<?php $gts = ($ordersales->sub_total-$hearse) * 0.07;$totalGts+=$gts; echo number_format($gts,2); ?></td>
                                                    <td class="total-with-gst price_col">$<?php echo number_format($ordersales->sub_total+ $gts,2); ?></td>
                                             <?php
                                             }} else if($key == "hearse" || $key == "parlour") { 
                                                     echo $ordersales->unit_price ? number_format($ordersales->total_price,2) : 0; 
                                             ?>
                                                    </td> <td class="gts-amount price_col">$<?php $gts = $ordersales->total_price * 0.07;$totalGts+=$gts;echo number_format($gts,2); ?></td>
                                                    <td class="total-with-gst price_col">$<?php echo number_format($ordersales->total_price + $gts,2); ?></td>
                                             <?php
                                             }  ?>



                                        <td></td>
                                    </tr>
                      <?php }else { ?>
                                    
                                     <?php  foreach($ordersales as $keys => $order ){ ?>
                                            <?php $order_nr = ucwords(substr($key, 0,1)); ?>
                                           <tr>
                                               <td><?php echo date("d/m/Y",strtotime($order->updated_at)); ?></td>
                                               <td>Sales order</td>
                                               <td>/ <?php echo $key; ?></td>
                                               <td><?php echo $key=="fa" ? "WSC".$order->generated_code : $order_nr.$order->order_nr ?></td>
                                               <td class="sub-total price_col">$
                                                   <?php 
                                                    if($key == "columbarium"){ 
                                                            $decode = json_decode($order->item_selection,true); 
                                                            echo $decode['subtotal'] ? number_format($decode['subtotal'],2) : 0; 

                                                    ?>
                                                            </td><td class="gts-amount price_col">$<?php $gts = $decode['subtotal'] * 0.07;$totalGts +=$gts; echo number_format($gts,2); ?></td>
                                                           <td class="total-with-gst price_col">$<?php echo number_format($decode['subtotal']+ $gts,2); ?></td>
                                                   <?php
                                                    } else if( $key == "gemstone") {  
                                                            $decode = json_decode($order->order_items,true); 
                                                            echo $decode['subtotal'] !="" ? number_format($decode['subtotal'],2) : 0;
                                                    ?>         
                                                            </td><td class="gts-amount price_col">$<?php $gts = $decode['subtotal'] * 0.07;$totalGts +=$gts; echo number_format($gts,2); ?></td>
                                                           <td class="total-with-gst price_col">$<?php echo number_format($decode['subtotal']+ $gts,2); ?></td>
                                                    <?php
                                                    } else if($key == "fa") { ?>
                                                            <?php $purch = json_decode($order->purchased_items,true); 

                                                         if($purch['hearse_price']){
                                                             $hearse = $purch['hearse_price'];
                                                            echo $order->sub_total ? number_format($order->sub_total-$purch['hearse_price'],2) : 0 ;?>
                                                            </td><td class="gts-amount price_col">$<?php $gts = ($order->sub_total-$hearse) * 0.07;$totalGts+=$gts; echo number_format($gts,2); ?></td>
                                                           <td class="total-with-gst price_col">$<?php echo number_format($order->sub_total+ $gts-$hearse,2); ?></td>
                                                           <?php
                                                         }else{  $hearse=0;
                                                   ?>

                                                   <?php echo $order->sub_total ? number_format($order->sub_total,2) : 0  ?>

                                                            </td><td class="gts-amount price_col">$<?php $gts = ($order->sub_total-$hearse) * 0.07;$totalGts+=$gts; echo number_format($gts,2); ?></td>
                                                           <td class="total-with-gst price_col">$<?php echo number_format($order->sub_total+ $gts,2); ?></td>
                                                    <?php
                                                    }} else if($key == "hearse" || $key == "parlour") { 
                                                            echo $order->unit_price ? number_format($order->total_price,2) : 0; 
                                                    ?>
                                                           </td> <td class="gts-amount price_col">$<?php $gts = $order->total_price * 0.07;$totalGts+=$gts;echo number_format($gts,2); ?></td>
                                                           <td class="total-with-gst price_col">$<?php echo number_format($order->total_price + $gts,2); ?></td>
                                                    <?php
                                                    }  ?>



                                               <td></td>
                                           </tr>

                                    
                                <?php } ?>          
                      <?php } ?>
                    
                    <!-- Start Order form info detail view part-->  
                    
                    
                      <?php endif; ?>    
                    <?php endforeach; ?>
                  
                    <!--Sub - table for payment information--> 
                    <?php $data = \App\SalesOrder::where("wsc",$wsc)->orderBy("id","ASC")->get(); ?>
                    <?php foreach ($data as $key => $datas): ?>
                   
                    <tr>
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
                        <td class='price_col' style='color:red' id="paid_amount_<?php echo $key; ?>">(<?php echo $datas->amount<0 ? "-$".number_format(abs($datas->amount),2) : "$".number_format($datas->amount,2); ?>)</td>
                        <td class='price_col'>$<?php $paid += $datas->amount; echo number_format($datas->amount,2); ?></td>
                        
                    </tr>
                    
                    <?php endforeach; ?>
                    <!--End table for payment information--> 
                    <!--Outstanding and Button--> 
                    <tr>
                        <td colspan="6" style="border:0"></td><td style="height:40px;border:0;background: linen">Total outstanding</td><td class="total-outstanding price_col" style="border:0;background: linen;font-size:16px "><b>$<?php echo number_format($total+$totalGts-$paid,2); ?></b></td>
                    </tr>
                   
                    <!--End Outstanding and Button-->
                </tbody>
            </table>
            <!--End detail view table--> 
        </div>
