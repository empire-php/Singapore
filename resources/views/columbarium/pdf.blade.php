<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Columbarium {{ ($order->funeral_arrangement_id)?$order->funeralArrangement->getCompanyPrefix()." ".$order->funeralArrangement->generated_code:"" }}</title>
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
                width:700px;
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
                width: 250px;
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

    <div class="section_content" id="order_section" style="width:250px; margin-left:400px">
        <table >
            <tr>
                <td>Date:</td>
                <td class="field_to_be_completed">{{ ($order->created_at)?date("d-m-Y H:i:s",strtotime($order->created_at)):date("d-m-Y H:i:s")}}</td>
            </tr>
            <tr>
                <td>Ref / SC no:</td>
                <td class="field_to_be_completed">{{ ($order->funeral_arrangement_id)?$order->funeralArrangement->generated_code:"" }}</td>
            </tr>
            <tr>
                <td>Columbarium Order No:</td>
                <td class="field_to_be_completed">{{($order->order_nr)?$order->order_nr:$order_nr}}</td>
            </tr>
        </table>
    </div>
    
    <div class="section_title">Deceased details</div>
    <div class="section_content">
        <table class="form_content" style="width:80%">
            <tbody>
                <tr><td class="field_container">Deceased Name</td><td colspan="5" class="field_to_be_completed">{{$order->deceased_name}}</tr>
                <tr><td class="field_container">Religion</td>
                    <td class="field_to_be_completed">

                            @foreach($religionOptions as $religionOp)
                                    @if (($order->religion) && $religionOp->id == $order->religion)
                                    {{$religionOp->name}}
                                    @endif
                            @endforeach

                    </td>
                    <td style="width:5%"></td>
                    <td class="field_container" style="width:20%;">Church</td>
                    <td colspan="2" class="field_to_be_completed">{{$order->church}}</td>
                </tr>
                <tr>
                    <td class="field_container">Sex</td>
                    <td class="field_to_be_completed">
                        <?php echo ucfirst($order->sex); ?>
                    </td>
                    <td colspan="4" class="input_container"></td>
                </tr>
                <tr>
                    <td class="field_container">Race</td>
                    <td class="field_to_be_completed">
     
                            @foreach($raceOptions as $raceOp)
                                @if (($order->race) && $raceOp->id == $order->race)
                                     {{$raceOp->name}}
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td></td>
                    <td class="field_container">Dialects</td>
                    <td class="field_to_be_completed">
                        {{$order->dialect}}
                    </td>
                </tr>
                <tr>
                    <td class="field_container">Date of Birth</td>
                    <td class="field_to_be_completed">
                        {{$order->birthdate}}
                    </td>
                    <td></td>
                    <td class="field_container">Date of Death</td>
                    <td class="field_to_be_completed">
                        {{$order->deathdate}}
                    </td>
                </tr>
                <tr><td colspan="6" style="height: 30px"></td></tr>
                <tr>
                    <td class="field_container">Funeral Date</td>
                    <td class="field_to_be_completed">
                        {{$order->funeral_date}}
                    </td>
                    <td></td>
                    <td class="field_container">Type of install</td>
                    <td class="field_to_be_completed">
                        {{$order->type_of_install}}
                    </td>
                </tr>
                <tr>
                    <td class="field_container">Final Resting Place</td>
                    <td class="field_to_be_completed">
                        {{$order->final_resting_place}}
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="field_container">Niche Type</td>
                    <td class="field_to_be_completed">
                        {{$order->niche_type}}
                    </td>
                    <td></td>
                    <td class="field_container">Niche Location</td>
                    <td class="field_to_be_completed">
                        {{$order->niche_location}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    
    
    <div class="section_title">Customer Details</div>
    <div class="section_content">
        <table style="width:80%">
            <tr>
                <td style="width: 20% "><em>Point of Contact 1</em></td>
                <td></td>
                <td style="width:5%"></td>
                <td><em>Point of Contact 2</em></td>
                <td></td>
            </tr>
            <tr>
                <td>NRIC No:</td>
                <td class='field_to_be_completed'>{{$order->first_cp_nric}}</td>
                <td></td>
                <td>NRIC No:</td>
                <td class='field_to_be_completed'>{{$order->second_cp_nric}}</td>
            </tr>
            <tr>
                <td>Name:</td>
                <td class='field_to_be_completed'>{{$order->first_cp_name}}</td>
                <td></td>
                <td>Name:</td>
                <td class='field_to_be_completed'>{{$order->second_cp_name}}</td>
            </tr>
            <tr>
                <td>Address:</td>
                <td class='field_to_be_completed'>{{$order->first_cp_address}}</td>
                <td></td>
                <td>Address:</td>
                <td class='field_to_be_completed'>{{$order->second_cp_address}}</td>
            </tr>
            <tr>
                <td>Mobile number:</td>
                <td class='field_to_be_completed'>{{$order->first_cp_mobile}}</td>
                <td></td>
                <td>Mobile number:</td>
                <td class='field_to_be_completed'>{{$order->second_cp_mobile}}</td>
            </tr>

        </table>
    </div> 
    
        <div class="page-break"></div>
        
    <div class="section_title">Inscription Details</div>
    <div class="section_content ">
        <table class="bordered_table" id="order_items_tbl" style="width:96%" cellspacing="0">
            <tr>
                <th style="width: 25%">&nbsp;</th>
                <th style="width: 20%">SELECTION</th>
                <th style="width: 40%">COMMENTS</th>
                <th>Amount</th>
            </tr>
            <tr class="active_rows">
                <td>Columbarium Charges: (Click to view slab selection)</td>
                <td>
                    {{ (isset($item_selection["selection"][0]))?$item_selection["selection"][0]:"" }}
                </td>
                <td>{{ (isset($item_selection["comments"][0]))?$item_selection["comments"][0]:"" }}</td>
                <td>{{ (isset($item_selection["amount"][0]))?$item_selection["amount"][0]:"" }}</td>
            </tr>
            <tr class="active_rows">
                <td>Wording Colour:</td>
                <td>
                    {{ (isset($item_selection["selection"][1]))?$item_selection["selection"][1]:"" }}
                </td>
                <td>{{ (isset($item_selection["comments"][1]))?$item_selection["comments"][1]:"" }}</td>
                <td>{{ (isset($item_selection["amount"][1]))?$item_selection["amount"][1]:"" }}</td>
            </tr>
            <tr class="active_rows">
                <td>Porcelain Photo Size</td>
                <td>
                    {{ (isset($item_selection["selection"][2]))?$item_selection["selection"][2]:"" }}
                </td>
                <td>{{ (isset($item_selection["comments"][2]))?$item_selection["comments"][2]:"" }}</td>
                <td>{{ (isset($item_selection["amount"][2]))?$item_selection["amount"][2]:"" }}</td>
            </tr>
            <tr class="active_rows">
                <td>Porcelain Photo Design</td>
                <td>
                    {{ (isset($item_selection["selection"][3]))?$item_selection["selection"][3]:"" }}
                </td>
                <td>{{ (isset($item_selection["comments"][3]))?$item_selection["comments"][3]:"" }}</td>
                <td>{{ (isset($item_selection["amount"][3]))?$item_selection["amount"][3]:"" }}</td>
            </tr>
            <tr class="active_rows">
                <td>Porcelain Photo Type</td>
                <td>
                    {{ (isset($item_selection["selection"][4]))?$item_selection["selection"][4]:"" }}
                </td>
                <td>{{ (isset($item_selection["comments"][4]))?$item_selection["comments"][4]:"" }}</td>
                <td>{{ (isset($item_selection["amount"][4]))?$item_selection["amount"][4]:"" }}</td>
            </tr>
            <tr class="active_rows">
                <td>Urn Model: (click to view urns selection )</td>
                <td>
                    {{ (isset($item_selection["selection"][5]))?$item_selection["selection"][5]:"" }}
                </td>
                <td>{{ (isset($item_selection["comments"][5]))?$item_selection["comments"][5]:"" }}</td>
                <td>{{ (isset($item_selection["amount"][5]))?$item_selection["amount"][5]:"" }}</td>
            </tr>
            <tr class="active_rows">
                <td>Ashes with:</td>
                <td>
                    {{ (isset($item_selection["selection"][6]))?$item_selection["selection"][6]:"" }}
                </td>
                <td>{{ (isset($item_selection["comments"][6]))?$item_selection["comments"][6]:"" }}</td>
                <td>{{ (isset($item_selection["amount"][6]))?$item_selection["amount"][6]:"" }}</td>
            </tr>
            <tr class="active_rows">
                <td>Miscellaneous</td>
                <td>
                    {{ (isset($item_selection["selection"][7]))?$item_selection["selection"][7]:"" }}
                </td>
                <td>{{ (isset($item_selection["comments"][7]))?$item_selection["comments"][7]:"" }}</td>
                <td>{{ (isset($item_selection["amount"][7]))?$item_selection["amount"][7]:"" }}</td>
            </tr>
            <?php
            if (isset($item_selection["item_name"])):
                foreach ($item_selection["item_name"] as $key=>$item_name):
                    ?>
                    <tr class="active_rows">
                        <td>{{$item_name}}</td>
                        <td>{{ (isset($item_selection["selection"][$key + 8]))?$item_selection["selection"][$key + 8]:"" }}</td>
                        <td>{{ (isset($item_selection["comments"][$key + 8]))?$item_selection["comments"][$key + 8]:"" }}</td>
                        <td>{{ (isset($item_selection["amount"][$key + 8]))?$item_selection["amount"][$key + 8]:"" }}</td>
                    </tr>
                    <?php
                endforeach;
            endif;
            ?>
            <tr id="calc_zone">
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border" style="text-align:right">Total</td>
                <td>{{ (isset($item_selection["subtotal"]))?$item_selection["subtotal"]:"" }}</td>
            </tr>
            <tr>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border" style="text-align:right">GST</td>
                <td>{{ (isset($item_selection["gst"]))?$item_selection["gst"]:"" }}</td>
            </tr>
            <tr>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border" style="text-align:right">Total with GST</td>
                <td>{{ (isset($item_selection["total_amount"]))?$item_selection["total_amount"]:"" }}</td>
            </tr>
            <tr>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border" style="text-align:right">Deposit</td>
                <td>{{ (isset($item_selection["deposit"]))?$item_selection["deposit"]:"" }}</td>
            </tr>
            <tr>
                <td class="no_border"></td>
                <td class="no_border"></td>
                <td class="no_border" style="text-align:right">Balance Payable</td>
                <td>{{ (isset($item_selection["balance_payable"]))?$item_selection["balance_payable"]:"" }}</td>
            </tr>
        </table>
    </div>
    
    <div class="page-break"></div>
    
    <div class="section_title">Confirmation of Order</div>
    <div class="section_content">
        I confirmed that the inscriptions are correct:
        <br /><br />
        
        <div id="box1" >
            <div id="box1" style="border:1px solid; width:180px">
                            <?php $signatures = json_decode($order->signatures, true);?>
                            <img src="<?php echo $signatures[1];?>" style="width:100px"/>
                        </div>
        </div>

        Date: <?php 
                                if ($order->signature_date && $order->signature_date != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($order->signature_date));
                                endif;
                            ?>
    </div>
    
    
    <div class="section_title">Checking of Slab (for office use only)</div>
    <div class="section_content">
        <table style="width:100%" >
            <tr>
                <td >Slab Returned / Completed Date:</td>
                <td class='field_to_be_completed'>{{$order->slab_returned}}</td>
                <td colspan="2"></td>
                <td >Checked by:</td>
                <td colspan="2" class='field_to_be_completed'>{{$order->slab_returned_checked_by}}</td>
            </tr>
            <tr>
                <td>Porcelain Photo Returned Date:</td>
                <td class='field_to_be_completed'>{{$order->porcelain_photo_returned_date}}</td>
                <td colspan="2"></td>
                <td>Checked by:</td>
                <td colspan="2" class='field_to_be_completed'>{{$order->porcelain_photo_returned_date_checked_by}}</td>
            </tr>
            <tr>
                <td>Called Family by:</td>
                <td class='field_to_be_completed'>{{$order->called_family}}</td>
                <td colspan="2"></td>
                <td style="width: 50px">Date:</td>
                <td colspan="2" class='field_to_be_completed'>{{$order->called_family_date}}</td>
            </tr>
            <tr>
                <td>Slab Installation Date & Time:</td>
                <td class='field_to_be_completed'>{{$order->slab_instalation}}</td>
                <td></td>
                <td style="width:50px;">Photo <br /> installation</td>
                <td>Date & Time:</td>
                <td  colspan="2" class='field_to_be_completed'>{{$order->photo_instalation}}</td>
            </tr>
            <tr>
                <td>Meet Family:</td>
                <td class='field_to_be_completed'>{{$order->meet_family}}</td>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td>Remarks:</td>
                <td class='field_to_be_completed'>{{$order->slab_remarks}}</td>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td colspan="7"> &nbsp;</td>
            </tr>
            <tr>
                <td>Order taken by:</td>
                <td class='field_to_be_completed'>{{($order->slab_order_taken_by)?$order->slab_order_taken_by:$user->name}}</td>
                <td>Date:</td>
                <td class='field_to_be_completed'>{{$order->slab_order_date}}</td>
                <td>Remarks:</td>
                <td colspan="2" class='field_to_be_completed'>{{$order->slab_order_remarks}}</td>
            </tr>
            <tr>
                <td>Inscription taken by:</td>
                <td class='field_to_be_completed'>{{$order->inscription_taken_by}}</td>
                <td>Date:</td>
                <td class='field_to_be_completed'>{{$order->inscription_taken_date}}</td>
                <td>Remarks:</td>
                <td colspan="2" class='field_to_be_completed'>{{$order->inscription_taken_remarks}}</td>
            </tr>
            <tr>
                <td>Photo taken by:</td>
                <td class='field_to_be_completed'>
                    {{$order->photo_taken}}
                </td>
                <td>Date:</td>
                <td class='field_to_be_completed'>{{$order->photo_taken_date}}</td>
                <td>Remarks:</td>
                <td colspan="2" class='field_to_be_completed'>{{$order->photo_taken_remarks}}</td>
            </tr>
            <tr>
                <td>Photo returned by:</td>
                <td class='field_to_be_completed'>{{$order->photo_returned_by}}</td>
                <td>Date:</td>
                <td class='field_to_be_completed'>{{$order->photo_returned_date}}</td>
                <td>Remarks:</td>
                <td  colspan="2" class='field_to_be_completed'>{{$order->photo_returned_remarks}}</td>
            </tr>
        </table>
    </div>
    

</div>

</div>
    </body>
</html>
