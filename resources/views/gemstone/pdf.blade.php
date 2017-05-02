<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Gemstone {{ ($order->funeralArrangement)?$order->funeralArrangement->getCompanyPrefix()." ".$order->funeralArrangement->generated_code:"" }}</title>
        <style>
            body, table, td, ul,li{
                margin:0px; padding: 0px;
            }
            
            body{
                font-size: 13px;
                line-height: 15px;
            }
            .page-break {
                page-break-after: always;
            }
            .title{
                text-align: center;
                font-size: 16px;
                font-weight: bold;
            }

            .field_to_be_completed{
                border-bottom: 1px solid #000;
                padding-left: 10px;
                padding-right: 10px;
            }
             
            .form{
                width:680px;
                margin-left:20px;
            }
            
            .section {
                width: 100%;
                background-color: #FFF;
                padding: 21px;
                margin-bottom: 30px;
            }
            .section_title {
                font-weight: bold;
                border-bottom: 1px solid #000;
                margin-bottom: 28px;
                width: 200px;
                margin-top: 100px;
            }

            .section_content table{

            }

            .section_content td{
                padding-left: 5px;
                padding-right: 5px;
            }

            .bordered_table{
                margin-top: 50px;
                margin-bottom: 50px;
            }
            .bordered_table th{
                font-weight: bold;
                border: 1px solid #CCC;
                padding: 10px;
                text-align: center;
            }
            .bordered_table td{
                border: 1px solid #CCC;
                padding: 10px;
            }

            .bordered_table td.no_border{
                border: 0px;
            }
           </style>
</head>
<body>
<div class="form">
<div class="section">

    <div class="section_content" style="padding-left:480px">
        <table>
            <tr>
                <td>Date:</td>
                <td class='field_to_be_completed'>{{date("d-m-Y H:i:s", strtotime($order->created_at))}}</td>
            </tr>
            <tr>
                <td>Ref / SC no:</td>
                <td class='field_to_be_completed'>{{($order->funeralArrangement)?$order->funeralArrangement->getCompanyPrefix():""}} {{($order->funeralArrangement)?$order->funeralArrangement->generated_code:""}}</td>
            </tr>
            <tr>
                <td>GEM Order No:</td>
                <td class='field_to_be_completed'>{{$order->order_nr}}</td>
            </tr>
        </table>
    </div>
  
    <div class="section_title customer_details_title" style="margin-top:100px">Customer Details</div>
    <div class="section_content customer_details_content">
        <table>
            <tr>
                <td style="widt: 20% "><em>Point of Contact 1</em></td>
                <td></td>
                
                <td><em>Point of Contact 2</em></td>
                <td></td>
            </tr>
            <tr>
                <td>NRIC No:</td>
                <td class='field_to_be_completed'>{{ $order->first_cp_nric }}</td>
                <td>NRIC No:</td>
                <td class='field_to_be_completed'>{{ $order->second_cp_nric }}</td>
            </tr>
            <tr>
                <td>Name:</td>
                <td class='field_to_be_completed'>{{ $order->first_cp_name}}</td>
                <td>Name:</td>
                <td class='field_to_be_completed'>{{ $order->second_cp_name}}</td>
            </tr>
            <tr>
                <td>Address:</td>
                <td class='field_to_be_completed'>{{ $order->first_cp_address}}</td>
                <td>Address:</td>
                <td class='field_to_be_completed'>{{ $order->second_cp_address}}</td>
            </tr>
            <tr>
                <td>Mobile number:</td>
                <td class='field_to_be_completed'>{{ $order->first_cp_mobile }}</td>
                <td>Mobile number:</td>
                <td class='field_to_be_completed'>{{ $order->second_cp_mobile }}</td>
            </tr>
        </table>
        
        
        
        <table class="bordered_table" id="order_items_tbl" cellspacing="0">
            <tr>
                <th>Name of Your Loved One</th>
                <th>Product Type</th>
                <th>Weight of Ashes(g)</th>
                <th>Unit Price (SGD)</th>
                <th>Quantity</th>
                <th>Amount (SGD)</th>
            </tr>
            @for ($i = 0; $i < count($order_items["deceased_name"]); $i++)
            <tr id="default_product" class="active_rows">
                <td>{{ $order_items["deceased_name"][$i] }}</td>
                <td>
                    {{ $order_items["product"][$i] }}
                </td>
                <td>{{ $order_items["weight_ashes"][$i] }}</td>
                <td>{{ $order_items["price"][$i] }}</td>
                <td>{{ $order_items["quantity"][$i] }}</td>
                <td>{{ $order_items["amount"][$i] }}</td>
            </tr>
            @endfor
            <tr id="calc_zone">
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td>Sub-total</td>
                <td>{{ $order_items["subtotal"] }}</td>
            </tr>
            <tr>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td>GST</td>
                <td>{{ $order_items["gst"] }}</td>
            </tr>
            <tr>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td>Total Amount</td>
                <td>{{ $order_items["total_amount"] }}</td>
            </tr>
        </table>
        
        
        <div class="page-break "></div>
        
        
        <table style="margin-top: 50px; width: 250px">
            <tr>
                <td rowspan="2" style="vertical-align: top; width:50px">Remarks</td>
                <td class='field_to_be_completed' style="width: 300px">{{ $order->remarks }}</td>
            </tr>
        </table>
    </div>
    
    
    <div class="section_title">Acknowledgements</div>
    <div class="section_content">
        1. I hereby consent and authorize Singapore Casket Company (Private) Limited ("Singapore Casket") to send the ashes described above to SAGE Funeral Services Limited to transform the ashes into Eternity Gem Stone(s).
        <br />
        2. I understand and accept that the eventual size, shape, color and luster of the Eternity Gem Stone(s) produced may be different from the sample shown to me by Singapore Casket. I understand and am aware that the sample shown to me by Singapore Casket is for my reference only and that the eventual Eternity Gem Stone(s) produced may be different from the sample shown to me.
        <br />
        3. I confirm that I have read Singapore Casket's "Terms and Conditions of Sale" and I accept that Singapore Casket's "Terms and Conditions of Sale" is also an integral part of the agreement between Singapore Casket and me herein.
        
    </div>
    
    <div class="section_title">Terms & Conditions</div>
    <div class="section_content" style="height: 100px;">
        
    </div>
    
    <div class="section_content">
        <table style="width: 500px">
            <tr>
                    <td>
                        &nbsp; 
                    </td>
                    <td colspan="2">
                        Accepted and Acknowledged by:
                    </td>
                    <td>
                        &nbsp; 
                    </td>
                    <td colspan="2">
                        Gem Stone Received by:
                    </td>
                    <td>
                        &nbsp; 
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp; 
                    </td>
                    <td style="text-align: center; width:200px;" colspan="2">
                        <div id="box1" style="border:1px solid; width:180px">
                            <?php $signatures = json_decode($order->signatures, true);?>
                            <img src="<?php echo $signatures[1];?>" style="width:100px"/>
                        </div>
                    </td>
                    <td style="width:150px">
                        &nbsp; 
                    </td>
                    <td style="text-align: center; width: 200px;" colspan="2">
                        <div id="box2" style="border:1px solid; width:180px">
                            <img src="<?php echo $signatures[2];?>" style="width:100px"/>
                        </div>
                    </td>
                    <td>
                        &nbsp; 
                    </td>
                </tr>
 
                <tr>
                    <td>
                        &nbsp; 
                    </td>
                    <td >
                        Name: 
                    </td>
                    <td style="text-align: left">
                        {{ $order->first_cp_name}}
                    </td>
                    <td>
                        &nbsp; 
                    </td>
                    <td>
                        Name: 
                    </td>
                    <td style="text-align: left">
                        {{ $order->second_cp_name}}
                    </td>
                    <td>
                        &nbsp; 
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp; 
                    </td>
                    <td>
                        Date: 
                    </td>
                    <td style="text-align: left">
                        <?php 
                                if ($order->signature_date && $order->signature_date != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($order->signature_date));
                                endif;
                            ?>
                    </td>
                    <td>
                        &nbsp; 
                    </td>
                    <td>
                        Date: 
                    </td>
                    <td style="text-align: left">
                        <?php 
                                if ($order->signature_date && $order->signature_date != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($order->signature_date));
                                endif;
                            ?>
                    </td>
                    <td>
                        &nbsp; 
                    </td>
                </tr>
                <tr>
                    <td colspan="7" style="padding-top: 100px">
                        <strong>ASHES TRANSFER LOCATION</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp; 
                    </td>
                    <td>
                        Date: 
                    </td>
                    <td style="text-align: right" class='field_to_be_completed'>
                        {{$order->ashes_transfer_date}}
                    </td>
                    <td colspan="4">
                        &nbsp; 
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp; 
                    </td>
                    <td>
                        Ashes Transfered by: 
                    </td>
                    <td style="text-align: right" class='field_to_be_completed'>
                        {{$order->ashes_transfered_by}}
                    </td>
                    <td colspan="4">
                        &nbsp; 
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp; 
                    </td>
                    <td>
                        Address: 
                    </td>
                    <td style="text-align: right" class='field_to_be_completed'>
                        {{$order->ashes_transfer_address}}
                    </td>
                    <td colspan="4">
                        &nbsp; 
                    </td>
                </tr>
        </table>
    </div>
</div>
</div>
    </body>
</html>
