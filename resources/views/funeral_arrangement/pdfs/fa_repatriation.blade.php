<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Funeral Arrangement Form</title>
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
             #deceased_details .form_title,  #point_contact .form_title, #funeral_day .form_title, #removal .form_title, .fa_section .form_title {
                border-bottom: 1px solid #000;
                padding-left: 5px;
                font-weight: bold;
                padding-top: 30px;
                text-align: left;
                font-size: 15px;
             }
             
             #deceased_details, #point_contact, #funeral_day, #removal, .fa_section {
                width: 650px;
                text-align: left;
                padding-left: 10px;
            }
            
            #number {
                width: 660px;
                text-align: right;
                padding-right: 19px;
                margin-top: 15px;
            }
            .price_col{
                text-align: right;
            }
            .price_col input{
                width: 50px;
            }
            .table-bordered {
                border: 1px solid #e0e7e8;
            }
            .table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
            }
            table {
                border-collapse: collapse;
                border-spacing: 0;
            }
            thead {
                display: table-header-group;
                vertical-align: middle;
                border-color: inherit;
            }
            .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
                border: 1px solid #e0e7e8;
            }
            td, th{
                padding: 5px;
            }
           </style>
</head>
<body>
    <div class="form" style="margin-top:20px;">
        <div id="number"> {{ $object->getCompanyPrefix() }}{{ $object->generated_code }}</div>
        
        <div style="text-align:center">
            <div id="deceased_details">
                <div class="form_title">Deceased details</div>
                <table class="form_content">
                    <tbody>
                        <tr><td class="field_container">Deceased Name</td><td colspan="5" class="input_container">{{$object->deceased_name}}</tr>
                        <tr><td class="field_container">Religion</td>
                            <td class="input_container">

                                    @foreach($religionOptions as $religionOp)

                                            @if ($religionOp->id == $object->religion)
                                            {{$religionOp->name}}
                                            @endif

                                    @endforeach

                            </td>
                            <td class="field_container">Church</td><td colspan="3" class="input_container">{{$object->church}}</td>
                        </tr>
                        <tr>
                            <td class="field_container">Sex</td>
                            <td colspan="5" class="input_container">
                                <?php echo (ucfirst($object->sex));?>
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Race</td>
                            <td class="input_container">
                                    @foreach($raceOptions as $raceOp)
                                            @if ($raceOp->id == $object->race)
                                            {{$raceOp->name}}
                                            @endif
                                    @endforeach
                            </td>
                            <td class="field_container">Dialects</td>
                            <td colspan="2" class="input_container">
                                {{$object->dialect}}
                            </td>
                        </tr>
                        <tr><td class="field_container">Date of Birth</td><td class="input_container">{{$object->birthdate}}</td><td class="field_container">Date of Death</td><td class="input_container">{{$object->deathdate}}</td><td id="age_field_container" class="field_container">Age</td><td id="age_input_container" class="input_container">{{$object->age}}</td></tr>
                        <tr><td colspan="6" style="text-align:center;padding-left: 40%; padding-top: 23px;"></td></tr>
                    </tbody>
                </table>
            </div>
            
            
            
            <div id="point_contact">
                <div class="form_title">Point of Contact</div>
                <table class="form_content">
                    <tbody>
                        <tr><td colspan="2"  class="field_container" style="text-align: center">1st Contact Person</td><td colspan="2" class="field_container" style="text-align: center">2st Contact Person</td></tr>
                        <tr><td class="field_container">Name</td><td class="input_container" >{{$object->first_cp_name}}</td><td class="field_container">Name</td><td class="input_container">{{$object->second_cp_name}}</td></tr>
                        <tr><td class="field_container">NRIC No</td><td class="input_container">{{$object->first_cp_nric}}</td><td class="field_container">NRIC No</td><td class="input_container">{{$object->second_cp_nric}}</td></tr>
                        <tr><td class="field_container">Email address</td><td class="input_container">{{$object->first_cp_email}}</td><td class="field_container">Email address</td><td class="input_container">{{$object->second_cp_email}}</td></tr>
                        <tr><td class="field_container">Postal Code</td><td class="input_container">{{$object->first_cp_postal_code}}</td><td class="field_container">Postal Code</td><td class="input_container">{{$object->second_cp_postal_code}}</td></tr>
                        <tr><td class="field_container">Address</td><td class="input_container">{{$object->first_cp_address}}</td><td class="field_container">Address</td><td class="input_container">{{$object->second_cp_address}}</td></tr>
                        <tr><td class="field_container">Home Number</td><td class="input_container">{{$object->first_cp_home_nr}}</td><td class="field_container">Home Number</td><td class="input_container">{{$object->second_cp_home_nr}}</td></tr>
                        <tr><td class="field_container">Mobile Number</td><td class="input_container">{{$object->first_cp_mobile_nr}}</td><td class="field_container">Mobile Number</td><td class="input_container">{{$object->second_cp_mobile_nr}}</td></tr>
                        <tr><td class="field_container">Office Number</td><td class="input_container">{{$object->first_cp_fax_nr}}</td><td class="field_container">Office Number</td><td class="input_container">{{$object->second_cp_office_nr}}</td></tr>
                        <tr><td class="field_container">Fax Number</td><td class="input_container">{{$object->first_cp_fax_nr}}</td><td class="field_container">Fax Number</td><td class="input_container">{{$object->second_cp_fax_nr}}</td></tr>
                        <tr>
                            <td class="field_container" style="width:20%">How did you find out about Singapore Casket?</td>
                            <td class="input_container">
                                    @foreach($sourceOptions as $source)
                                            @if ($source->id == $object->first_cp_info_source)
                                            {{$source->name}}
                                            @endif
                                    @endforeach
                            </td>
                            <td class="field_container" style="width:20%">How did you find out about Singapore Casket?</td>
                            <td class="input_container">
                                    @foreach($sourceOptions as $source)
                                            @if ($source->id == $object->second_cp_info_source)
                                            {{$source->name}}
                                            @endif
                                    @endforeach
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            
            
            <div class="fa_section">
                <div class="form_title">Flight Details / Consignee</div>
                <table class="form_content" style="width: 80%">
                    <tbody>
                        <tr>
                            <td class="field_container">Packing Date/Time</td>
                            <td class="input_container">
                                {{$object->packing}}
                            </td>
                            <td class="field_container">Pick-up Date/Time</td>
                            <td class="input_container">
                                {{$object->pick_up}}
                            </td>
                            <td class="field_container">Date of Export</td>
                            <td class="input_container">
                                {{$object->export_date}}
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Airway Bill No</td>
                            <td class="input_container">
                                {{$object->airway_bill}}
                            </td>
                            <td class="field_container">From</td>
                            <td class="input_container">
                                {{$object->airway_from}}
                            </td>
                            <td class="field_container">To</td>
                            <td class="input_container">
                                {{$object->airway_to}}
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">E.T.D.</td>
                            <td class="input_container">
                                {{$object->etd_1}}
                            </td>
                            <td class="field_container">Date</td>
                            <td class="input_container">
                                {{$object->etd_date_1}}
                            </td>
                            <td class="field_container">Flight No</td>
                            <td class="input_container">
                                {{$object->etd_flight_1}}
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">E.T.A.</td>
                            <td class="input_container">
                                {{$object->eta_1}}
                            </td>
                            <td class="field_container">Date</td>
                            <td class="input_container">
                                {{$object->eta_date_1}}
                            </td>
                            <td colspan="2" class="field_container"></td>
                        </tr>
                        <tr>
                            <td class="field_container">E.T.D.</td>
                            <td class="input_container">
                                {{$object->etd_2}}
                            </td>
                            <td class="field_container">Date</td>
                            <td class="input_container">
                                {{$object->etd_date_2}}
                            </td>
                            <td class="field_container">Flight No</td>
                            <td class="input_container">
                                {{$object->etd_flight_2}}
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">E.T.A.</td>
                            <td class="input_container">
                                {{$object->eta_2}}
                            </td>
                            <td class="field_container">Date</td>
                            <td class="input_container">
                                {{$object->eta_date_2}}
                            </td>
                            <td colspan="2" class="field_container"></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="height: 30px"></td>
                        </tr>
                        <tr>
                            <td colspan="6" class="field_container">
                                Consignee
                                <br />
                                {{$object->consignee}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="height: 20px"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="page-break"></div>
            
            
            
            <div id="fa_form" class="needs_exit_warning">
        <div class="fa_section">
            <div class="form_title">Purchase</div>
            <table class="table table-striped table-bordered" style="margin-top: 30px;">
                <thead>
                    <tr>
                        <th>
                            
                        </th>
                        <th>
                            
                        </th>
                        <th></th>
                        <th colspan="2">
                            
                        </th>
                        <th>
                            Amount
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->price_1)?$object->price_1:''}}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->price_2)?$object->price_2:''}}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><strong>Selection</strong></td>
                        <td><strong>Comments</strong></td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->price_3)?$object->price_3:''}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Coffin
                        </td>
                        <td>
                            {{(isset($object))?$object->coffin_selection:''}}
                        </td>
                        
                        <td>
                            {{(isset($object))?$object->coffin_comments:''}}
                        </td>
                        <td>Sold by </td>
                        <td>{{(isset($object))?$object->coffin_sold_by:''}}</td>
                        <td class="price_col">
                            {{(isset($object) && $object->coffin_price)?$object->coffin_price:''}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Embalming for Repatriation
                        </td>
                        <td>
                            {{(isset($object))?$object->embalming_selection:''}}
                        </td>
                        
                        <td>
                            {{(isset($object))?$object->embalming_comments:''}}
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->embalming_price)?$object->embalming_price:''}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Parlour
                        </td>
                        <td>
                            {{(isset($object))?$object->parlour_selection:''}}
                        </td>
                        
                        <td>
                            {{(isset($object))?$object->parlour_comments:''}}
                        </td>
                        <td>Days </td>
                        <td>{{(isset($object))?$object->parlour_days:''}}</td>
                        <td class="price_col">
                            {{(isset($object) && $object->parlour_price)?$object->parlour_price:''}}
                        </td>
                    </tr>
                    
                    
                    
                    <tr>
                        <td>
                            Overtime
                        </td>
                        <td>
                            {{(isset($object))?$object->overtime_selection:''}}
                        </td>
                        
                        <td>
                            {{(isset($object))?$object->overtime_comments:''}}
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->overtime_price)?$object->overtime_price:''}}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Clothes
                        </td>
                        <td>
                            {{(isset($object))?$object->clothes_selection:''}}
                        </td>
                        
                        <td>
                            {{(isset($object))?$object->clothes_comments:''}}
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->clothes_price)?$object->clothes_price:''}}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Fumigation
                        </td>
                        <td>
                            {{(isset($object))?$object->fumigation_selection:''}}
                        </td>
                        
                        <td>
                            {{(isset($object))?$object->fumigation_comments:''}}
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->fumigation_price)?$object->fumigation_price:''}}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Removal from Airport / Wharf / On board vessel
                        </td>
                        <td>
                            {{(isset($object))?$object->wharf_selection:''}}
                        </td>
                        
                        <td>
                            {{(isset($object))?$object->wharf_comments:''}}
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->wharf_price)?$object->wharf_price:''}}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Metal Lining / Plastic Sealing
                        </td>
                        <td>
                            {{(isset($object))?$object->materials_selection:''}}
                        </td>
                        
                        <td>
                            {{(isset($object))?$object->materials_comments:''}}
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->materials_price)?$object->materials_price:''}}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Outer Wooden Packing Case / Hessian Covering
                        </td>
                        <td>
                            {{(isset($object))?$object->covering_selection:''}}
                        </td>
                        
                        <td>
                            {{(isset($object))?$object->covering_comments:''}}
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->covering_price)?$object->covering_price:''}}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Singapore Port Health ( Export / Transit )
                        </td>
                        <td>
                            {{(isset($object))?$object->export_selection:''}}
                        </td>
                        
                        <td>
                            {{(isset($object))?$object->export_comments:''}}
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->export_price)?$object->export_price:''}}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Airfreight Charges ( Ashes / Remains ) / Delivery Airport
                        </td>
                        <td>
                            {{(isset($object))?$object->airport_charges_selection:''}}
                        </td>
                        
                        <td>
                            {{(isset($object))?$object->airport_charges_comments:''}}
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->airport_charges_price)?$object->airport_charges_price:''}}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Professional services
                        </td>
                        <td>
                            {{(isset($object))?$object->pro_services_selection:''}}
                        </td>
                        
                        <td>
                            {{(isset($object))?$object->pro_services_comments:''}}
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->pro_services_price)?$object->pro_services_price:''}}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Disposal of Coffin
                        </td>
                        <td>
                            {{(isset($object))?$object->coffin_disposal_selection:''}}
                        </td>
                        
                        <td>
                            {{(isset($object))?$object->coffin_disposal_comments:''}}
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->coffin_disposal_price)?$object->coffin_disposal_price:''}}
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Rituals & rites
                        </td>
                        <td>
                            {{(isset($object))?$object->rituals_selection:''}}
                        </td>
                        
                        <td>
                            {{(isset($object))?$object->rituals_comments:''}}
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            {{(isset($object) && $object->rituals_price)?$object->rituals_price:''}}
                        </td>
                    </tr>
                    
                    <?php $i = 0;?>
                    <?php foreach($sales_items as $package => $selections):?>
                    <tr>
                        <td>
                            <?php echo (isset($package))?$package:""?>
                        </td>
                        <td>
                            <?php 
                                $saved_si_selection_item = $saved_si_price = $saved_si_remarks = "";
                            if (isset($si) && isset($si[$package])):
                                $saved_si_selection_item = (isset($si[$package]["selection_item"]))?$si[$package]["selection_item"]:'';
                                $saved_si_price = (isset($si[$package]["price"]))?$si[$package]["price"]:'';
                                $saved_si_remarks = (isset($si[$package]["remarks"]))?$si[$package]["remarks"]:'';
                            endif;

                            ?>

                                <?php foreach($selections as $key => $group):?>

                                    <?php foreach($group as $item):?>
                                        <?php if ($item["selection_item_id"] == $saved_si_selection_item):?>
                                            <?php 
                                                $product = App\Products::find($item["selection_item_id"]);
                                                if ($product){
                                                    echo $product->item;
                                                }
                                                else{
                                                    echo $item["selection_item_name"];
                                                }

                                            ?>
                                        <?php endif;?>
                                    <?php endforeach;?>

                                <?php endforeach;?>

                        </td>
                        <td colspan="3"><?php echo $saved_si_remarks;?></td>

                        <td class="price_col">
                            <?php echo $saved_si_price;?>
                        </td>

                    </tr>
                    <?php $i++;?>
                    <?php endforeach;?>
                    
                    
                    
                    <?php // MORE PACKS ----------------------------------------------------- ?>
                    <?php if (isset($mp)):?>
                    <?php $inc = 0;?>
                    <?php foreach($mp as $package => $other_item):?>
                    <tr>
                        <td>
                            
                                <?php $sel = 1;?>
                                <?php foreach($sales_items as $list_package => $selections):?>
                                    <?php echo ($list_package == $package)?$list_package:''?>
                                <?php endforeach;?>
                           
                        </td>
                        <td>
                            <?php $sel = 1;?>
                            <?php foreach($sales_items as $list_package => $selections):?>
                            
                            <?php 
                                $saved_mp_selection_item = $saved_mp_price = $saved_mp_remarks = "";
                                
                                if (isset($si) && isset($si[$list_package])):
                                    $saved_mp_selection_item = (isset($mp[$package]["selection_item"]))?$mp[$package]["selection_item"]:'';
                                    $saved_mp_price = (isset($mp[$package]["price"]))?$mp[$package]["price"]:'';
                                    $saved_mp_remarks = (isset($mp[$package]["remarks"]))?$mp[$package]["remarks"]:'';
                                endif;
                            ?>
                            
                            
                                <?php foreach($selections as $key => $group):?>
                                
                                    <?php foreach($group as $item):?>
                                        <?php if ($list_package == $package && $item["selection_item_id"] == $saved_mp_selection_item):?>
                                            <?php 
                                                $product = App\Products::find($item["selection_item_id"]);
                                                if ($product){
                                                    echo $product->item;
                                                }
                                                else{
                                                    echo $item["selection_item_name"];
                                                }

                                            ?>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                
                                <?php endforeach;?>
                            </select>
                            <?php $sel++; ?>
                            <?php endforeach;?>
                        </td>
                        <td colspan="3"><?php echo $saved_mp_remarks;?></td>
                        <td class="price_col">
                            <?php echo $saved_mp_price;?>
                            
                        </td>
                    </tr>
                    <?php $inc++;?>
                    <?php endforeach;?>
                    <?php endif;?>
                    
                    <tr>
                        <td>
                            Miscellaneous
                        </td>
                        <td class="form-control">
                            {{(isset($object))?$object->miscellaneous_selection_1:''}}
                        </td>
                        
                        <td class="form-control">
                            {{(isset($object))?$object->miscellaneous_comments_1:''}}
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col form-control">
                            {{(isset($object) && $object->miscellaneous_price_1)?$object->miscellaneous_price_1:''}}
                        </td>
                    </tr>
                    
                    <?php if (is_array($other_purchased_items)):?>
                    <?php foreach($other_purchased_items as $items):?>
                    <tr>
                        <td>
                            <?php echo (isset($items["name"]))?$items["name"]:""?>
                        </td>
                        <td>
                            <?php echo (isset($items["selection"]))?$items["selection"]:""?>
                        </td>
                        
                        <td>
                            <?php echo (isset($items["comments"]))?$items["comments"]:""?>
                        </td>
                        <td colspan="2"></td>
                        <td class="price_col">
                            <?php echo (isset($items["price"]))?$items["price"]:""?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    <?php endif;?>
                    
                    
                    
                    <tr>
                        <td>
                            Miscellaneous
                        </td>
                        <td>
                            <?php echo (isset($object) && $object->miscellaneous_selection_2 == "special_discount")?'Special Discount':''?>
                        </td>
                        
                        <td ></td>
                        <td colspan="2">Total</td>
                        <td style="text-align: right">
                            <span id="total" style="font-weight: bold; font-style: italic">${{$object->total_step_3}}</span>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            
            
        </div>
    </div>
            
            
            <div class="page-break"></div>
            
            
            <div class="form">
                
                <table style="margin-top: 40px; width:500px">
                    <tr>
                        <td colspan="5" style="text-align: right;">
                            <table style="float:right">
                                <tr>
                                    <td>Sub-Total&nbsp;</td>
                                    <td style="width:100px; text-align: right">${{$object->total_step_3}}</td>
                                </tr>
                                @if ($object->miscellaneous_selection_2 &&  $object->miscellaneous_selection_2 != "special_discount")
                                <tr>
                                    <td><span >Discount (%)&nbsp;</span></td>
                                    <td style=" text-align: right">{{$object->miscellaneous_selection_2}}</td>
                                </tr>
                                @endif
                                
                               
                                @if ($object->miscellaneous_selection_2 == "special_discount")
                                <tr>
                                    <td><span style="color: #CCC">Special discount(approved by: {{$object->miscellaneous_approving_supervisor}})&nbsp;</span></td>
                                    <td style=" text-align: right">{{$object->miscellaneous_amount}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Total&nbsp;</td>
                                    <td style=" text-align: right">${{$object->final_total}}</td>
                                </tr>
                                <tr>
                                    <td>GST 7%&nbsp;</td>
                                    <td style=" text-align: right">${{$object->gst_value}}</td>
                                </tr>
                                <tr>
                                    <td>Total with GST&nbsp;</td>
                                    <td style="text-align: right">${{$object->total_with_gst}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="height: 100px">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left;">
                            <br /><br /><br />
                            <strong>Remarks</strong>
                            <br />
                            {{$object->final_remarks}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="height: 100px">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="border-bottom: 1px solid #000; text-align: left; font-weight: bold">Declaration</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="height: 30px">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: justify;">We, the undersigned, guarantee payment in full for the above goods sold and services rendered. We also accept that any additional goods sold and services rendered at the request of the undersigned or family members will be charged accordingly to this order form without further reference. Late payment interest of 2% per month will be imposed for any outstanding balance.</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="height: 30px">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left;">I have also read and understood the terms and conditions for embalming</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="height: 100px">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width: 50px">
                            &nbsp; 
                        </td>
                        <td style="text-align:center">
                            Accepted and agreed
                        </td>
                        <td>
                            &nbsp; 
                        </td>
                        <td style="text-align:center">
                            Accepted and agreed
                        </td>
                        <td>
                            &nbsp; 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp; 
                        </td>
                        <td style="text-align: center; width: 250px;">
                            <div id="box1" >
                                <?php $signatures = json_decode($object->signatures, true);?>
                                <img src="<?php echo $signatures[1];?>" style="width:100px"/>
                            </div>

                        </td>
                        <td>
                            &nbsp; 
                        </td>
                        <td style="text-align: center; width: 250px;">
                            <div id="box2">
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
                        <td style="text-align:center">
                            Date: <?php 
                                if ($object->signature_date && $object->signature_date != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($object->signature_date));
                                endif;
                            ?>
                        </td>
                        <td>
                            &nbsp; 
                        </td>
                        <td style="text-align:center">
                            Date: <?php 
                                if ($object->signature_date && $object->signature_date != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($object->signature_date));
                                endif;
                            ?>
                        </td>
                        <td>
                            &nbsp; 
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="height: 100px">&nbsp;</td>
                    </tr>

                </table>
            </div>

        </div>
    </div>
  </body>
</html>