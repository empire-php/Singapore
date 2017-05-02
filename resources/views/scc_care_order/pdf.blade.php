<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>SCC Care Order {{ $object->order_nr }}</title>
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
                margin-top: 10px;
                margin-bottom: 10px;
            }
            .bordered_table th{
                font-weight: bold;
                border: 1px solid #CCC;
                padding: 5px;
                text-align: center;
            }
            .bordered_table td{
                border: 1px solid #CCC;
                padding: 5px;
                text-align: center;
            }

            .bordered_table td.no_border{
                border: 0px;
            }
            .table-bordered {
                border: 1px solid #e0e7e8;
            }
            .table {
                
                margin-bottom: 20px;
            }
            
            thead {
                display: table-header-group;
                vertical-align: middle;
                border-color: inherit;
            }
            .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
                border: 1px solid #e0e7e8;
            }
            
           </style>
</head>
<body>
<div class="page-header">

        <div id="order_form" class="needs_exit_warning">
            <div class="section">
                <div id="order_info" style="margin-left: 700px">
                    <table style="width: 100%">
                        <tr>
                            <td>Date:</td>
                            <td>{{ ($object->created_at)?date("d-m-Y H:i:s",strtotime($object->created_at)):date("d-m-Y H:i:s")}}</td>
                        </tr>
                        <tr>
                            <td>Ref No:</td>
                            <td>{{ ($object->funeral_arrangement_id)?$object->funeralArrangement->generated_code:"" }}</td>
                        </tr>
                        <tr>
                            <td>Order No:</td>
                            <td><?php echo $prefix. (($object->order_nr)?sprintf("%05d",$object->order_nr):'')?></td>
                        </tr>
                        <tr>
                            <td>Issued and Arranged by:</td>
                            <td>{{($object->created_by)?$object->creator->name: $user->name }}</td>
                        </tr>
                    </table>
                </div>
                <div style="clear:both"></div>
                
                
                <div class="section_title">Deceased Details</div>
                <table class="form_content" style="width: 600px">
                    <tbody>
                        <tr>
                            <td class="field_container">Deceased Name</td>
                            <td class="field_to_be_completed">
                                {{$object->deceased_name}}
                            </td>
                            <td colspan="2">
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Religion</td>
                            <td  class="field_to_be_completed">
                                    @foreach($religionOptions as $religionOp)
                                            @if ($religionOp->id == $object->religion)
                                            {{$religionOp->name}}
                                            @endif
                                            
                                    @endforeach
                                </select>
                            </td>
                            <td class="field_container">&nbsp;&nbsp;&nbsp;Church</td>
                            <td  class="field_to_be_completed">
                                {{$object->church}}
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Sex</td>
                            <td class="field_to_be_completed">
                                <?php echo $object->sex;?>
                            </td>
                            <td colspan="2" ></td>
                        </tr>
                        <tr>
                            <td class="field_container">Race</td>
                            <td class="field_to_be_completed">
                                    @foreach($raceOptions as $raceOp)
                                    
                                            @if ($raceOp->id == $object->race)
                                            {{$raceOp->name}}
                                            @endif
                                           
                                    @endforeach
                                </select>
                            </td>
                            <td class="field_container">&nbsp;&nbsp;&nbsp;Dialects</td>
                            <td class="field_to_be_completed">
                                {{$object->dialect}}
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Date of Birth</td>
                            <td class="field_to_be_completed">{{$object->birthdate}}</td>
                            <td class="field_container">&nbsp;&nbsp;&nbsp;Date of Death</td>
                            <td class="field_to_be_completed">{{$object->deathdate}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="space"></td>
                        </tr>
                        <tr>
                            <td class="field_container">Cremation Location</td>
                            <td class="field_to_be_completed">
                                {{$object->cremation_location}}
                            </td>
                            <td colspan="2" >
                               
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Cortage Leave Date</td>
                            <td class="field_to_be_completed">
                                {{ ($object->cortage_leave_date != "0000-00-00")?date("d/m/Y", strtotime($object->cortage_leave_date)):""}}
                            </td>
                            <td colspan="2">
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Cortage Leaving Time</td>
                            <td class="field_to_be_completed">
                                {{date("H:i", strtotime($object->cortage_leaving_time))}}
                            </td>
                            <td colspan="2">
                                
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Location of Wake</td>
                            <td class="field_to_be_completed">
                                {{$object->wake_location}}
                            </td>
                            <td colspan="2">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="height: 30px"></div>
                
                
                <div class="section_title">Customer Details</div>
                <table style="width: 600px">
                    <tr>
                        <td style="widt: 20% "><em>Point of Contact 1</em></td>
                        <td></td>

                        <td>&nbsp;&nbsp;&nbsp;<em>Point of Contact 2</em></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>NRIC No:</td>
                        <td class="field_to_be_completed">{{$object->first_cp_nric}}</td>
                        <td>&nbsp;&nbsp;&nbsp;NRIC No:</td>
                        <td class="field_to_be_completed">{{$object->second_cp_nric}}</td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td class="field_to_be_completed">{{$object->first_cp_name}}</td>
                        <td>&nbsp;&nbsp;&nbsp;Name:</td>
                        <td class="field_to_be_completed">{{$object->second_cp_name}}</td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td class="field_to_be_completed">{{$object->first_cp_address}}</td>
                        <td>&nbsp;&nbsp;&nbsp;Address:</td>
                        <td class="field_to_be_completed">{{$object->second_cp_address}}</td>
                    </tr>
                    <tr>
                        <td>Mobile number:</td>
                        <td class="field_to_be_completed">{{$object->first_cp_mobile}}</td>
                        <td>&nbsp;&nbsp;&nbsp;Mobile number:</td>
                        <td class="field_to_be_completed">{{$object->second_cp_mobile}}</td>
                    </tr>
                </table>
                
                
                <div class="page-break"></div>
                
                <div class="section_title">Product Details</div>

                <table class="bordered_table" id="products_table" style="width:980px" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="text-align:center; vertical-align: middle">Description</th>
                            <th style="text-align:center; vertical-align: middle">Selection</th>
                            <th style="text-align:center; vertical-align: middle; width:50px" id="base_th_qty">
                                Qty Order
                                <br />
                                <?php echo (!empty($qty_dates[0]))?$qty_dates[0]:""?>
                            </th>
                            <?php if ($extra_q_td > 0):?>
                                <?php for($i = 1;$i < $extra_q_td; $i++):?>
                                <th style="text-align:center; vertical-align: middle; width:50px">
                                    Qty Order
                                    <br />
                                    <?php echo (!empty($qty_dates[$i]))?$qty_dates[$i]:""?>
                                </th>
                                <?php endfor;?>
                            <?php endif;?>
                            <?php if (!in_array($object->care_type, array("chanting","tentage"))):?>
                            <th style="text-align:center; vertical-align: middle; width:100px">Return QTY</th>
                            <?php endif;?>
                            <th style="text-align:center; vertical-align: middle; width:100px">Total Sold</th>
                            <th style="text-align:center; vertical-align: middle; width:100px">Unit Price</th>
                            <th style="text-align:center; vertical-align: middle; width:100px">Amount</th>
                            <th style="text-align:center; vertical-align: middle">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($purchased_items):?>
                            <?php foreach($purchased_items as $key => $product_info):?>
                                <?php if (!empty($product_info["category_name"]) && $key != "new"):?>
                                <tr >
                                    <td>
                                        <?php echo (!empty($product_info["category_name"]))?$product_info["category_name"]:""?>
                                    </td>

                                    <td>
                                        <?php echo (!empty($product_info["item"]))?$product_info["item"]:""?>
                                    </td>
                                    <td ><?php echo $product_info["quantities"][0]?></td>
                                    <?php if ($extra_q_td > 0):?>
                                        <?php for($i = 1;$i < $extra_q_td; $i++):?>
                                                <td class="qty" ><?php echo (!empty($product_info["quantities"][$i]))?$product_info["quantities"][$i]:""?></td>
                                        <?php endfor;?>
                                    <?php endif;?>
                                    <?php if (!in_array($object->care_type, array("chanting","tentage"))):?>
                                    <td style="text-align:right; margin-right: 10px"><?php echo (!empty($product_info["return_qty"]))?$product_info["return_qty"]:""?> </td>
                                    <?php endif;?>
                                    <td style="text-align:right"><?php echo (!empty($product_info["total_sold"]))?$product_info["total_sold"]:""?> </td>
                                    <td style="text-align:right"><?php echo (!empty($product_info["unit_price"]))?$product_info["unit_price"]:""?> </td>
                                    <td style="text-align:right"><?php echo (!empty($product_info["amount"]))?$product_info["amount"]:""?>         </td>
                                    <td style="text-align:right"><?php echo (!empty($product_info["remarks"]))?$product_info["remarks"]:""?>       </td>
                                    
                                 
                                </tr>
                                <?php endif;?>
                            <?php endforeach;?>
                        
                            
                        <?php endif;?>
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <?php if (!in_array($object->care_type, array("chanting","tentage"))):?>
                            <td colspan="<?php echo 6 + (($extra_q_td > 0)? ($extra_q_td -1):0) - 1 ?>" id="click_add_td"></td>
                            <?php else:?>
                            <td colspan="<?php echo 5 + (($extra_q_td > 0)? ($extra_q_td -1):0) - 1 ?>" id="click_add_td"></td>
                            <?php endif;?>
                            <td style="font-weight: bold; font-style:italic">Total Amount</td>
                            <td style="text-align:right; margin-right: 10px"><span id="total">{{$object->total}}</span></td>
                            <td> </td>
                        </tr>
                    </tfoot>
                </table>
                
                
                
                <div class="page-break"></div>
                
                
                <div class="signature_container" style="margin-left: 300px; margin-top: 50px;">
                    <table style=" width: 400px">
                        
                        <tr>
                            <td>
                                <span style="font-weight: bold">Confirmed & Agreed</span>
                                <div id="box1" >
                                    @if ($object->signature_1)
                                    <img src="{{$object->signature_1}}" style="width:100px"/>
                                    @endif
                                </div>
                                
                                
                                Date: <span id="date_signature_1"><?php 
                                if ($object->signature_date_1 && $object->signature_date_1 != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($object->signature_date_1));
                                endif;
                                ?></span>
                            </td>
                            <td>
                                <span style="font-weight: bold">Goods Return</span>
                                <div id="box2" >
                                    @if ($object->signature_2)
                                    <img src="{{$object->signature_2}}" style="width:100px"/>
                                    @endif
                                </div>
                                
                                Date: <span id="date_signature_2"><?php 
                                if ($object->signature_date_2 && $object->signature_date_2 != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($object->signature_date_2));
                                endif;
                                ?></span>
                            </td>
                        </tr>
                        <tr><td colspan="2" style="height: 50px"></td></tr>
                        <tr>
                            <td>
                                <span style="font-weight: bold">Goods Received</span>
                                <div id="box3" >
                                    @if ($object->signature_3)
                                    <img src="{{$object->signature_3}}" style="width:100px"/>
                                    @endif
                                </div>
                                
                                Date: <span id="date_signature_3"><?php 
                                if ($object->signature_date_3 && $object->signature_date_3 != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($object->signature_date_3));
                                endif;
                                ?></span>
                            </td>
                            <td></td>
                        </tr>
                        <tr><td colspan="2" style="height: 50px"></td></tr>
                    </table>
                </div>
                
                
               
                
                <p>
                    <span style="text-transform: uppercase; font-weight: bold">Payment by cash, cheque or nets only</span>
                    <br />
                    1. <span style="text-transform: uppercase; font-weight: bold; text-decoration: underline">Payments:</span> We the undersigned quarantee payment in full for the above goods sold. We also accepted that any additional goods sold and services rendered ar the request of the undersigned or family members will be charged accordingly to this order form without further reference. Late payment interest of 2% per month will be imposed for any outstanding balance.
                    <br />
                    2. <span style="text-transform: uppercase; font-weight: bold; text-decoration: underline">Returns:</span> We only accept unopened packages that are purchased from Singapore Casket. Goods return shall be in good condition.
                    <br />
                    3. All cheques payable to <span style="text-transform: uppercase; font-weight: bold">SCC Care Services PTE. LTD.</span>
                    <br />
                    4. Total amount payable including <span style="text-transform: uppercase; font-weight: bold">GST</span>.
                </p>
                
               
            </div>
        </div>

</div>


</body>
</html>
