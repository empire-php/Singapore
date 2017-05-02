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
            .table-bordered {
                border: 1px solid #e0e7e8;
            }
            .table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
            
                border-collapse: collapse;
                border-spacing: 0;
            }
            .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
                border: 1px solid #e0e7e8;
            }
            .table td, th{
                padding: 5px;
            }
            .price_col{
                text-align: right;
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
                         @if ($object->first_cp_name)
                        <tr><td colspan="2"  class="field_container" style="text-align: center">1st Contact Person</td>
                            @if($object->second_cp_name)
                            <td colspan="2" class="field_container" style="text-align: center">2st Contact Person</td>
                            @endif
                        </tr>
                         @endif
                        @if ($object->first_cp_name)
                        <tr><td class="field_container">Name</td><td class="input_container" >{{$object->first_cp_name}}</td>
                            @if($object->second_cp_name)
                            <td class="field_container">Name</td><td class="input_container">{{$object->second_cp_name}}</td>
                            @endif
                        </tr>
                         @endif
                        @if ($object->first_cp_nric)
                        <tr><td class="field_container">NRIC No</td><td class="input_container">{{$object->first_cp_nric}}</td>
                            @if($object->second_cp_nric)
                            <td class="field_container">NRIC No</td><td class="input_container">{{$object->second_cp_nric}}</td>
                            @endif
                        </tr>
                         @endif
                        @if ($object->first_cp_email)
                        <tr><td class="field_container">Email address</td><td class="input_container">{{$object->first_cp_email}}</td>
                            @if($object->second_cp_email)
                            <td class="field_container">Email address</td><td class="input_container">{{$object->second_cp_email}}</td>
                            @endif
                        </tr>
                         @endif
                         @if ($object->first_cp_postal_code)
                        <tr><td class="field_container">Postal Code</td><td class="input_container">{{$object->first_cp_postal_code}}</td>
                            @if($object->second_cp_postal_code)
                            <td class="field_container">Postal Code</td><td class="input_container">{{$object->second_cp_postal_code}}</td>
                            @endif
                        </tr>
                         @endif
                        @if ($object->first_cp_address)
                        <tr><td class="field_container">Address</td><td class="input_container">{{$object->first_cp_address}}</td>
                            @if($object->second_cp_address)
                            <td class="field_container">Address</td><td class="input_container">{{$object->second_cp_address}}</td>
                            @endif
                        </tr>
                         @endif
                        @if ($object->first_cp_home_nr)
                        <tr><td class="field_container">Home Number</td><td class="input_container">{{$object->first_cp_home_nr}}</td>
                            @if($object->second_cp_home_nr)
                            <td class="field_container">Home Number</td><td class="input_container">{{$object->second_cp_home_nr}}</td>
                            @endif
                        </tr>
                         @endif
                        @if ($object->first_cp_mobile_nr)
                        <tr><td class="field_container">Mobile Number</td><td class="input_container">{{$object->first_cp_mobile_nr}}</td>
                            @if($object->second_cp_mobile_nr)
                            <td class="field_container">Mobile Number</td><td class="input_container">{{$object->second_cp_mobile_nr}}</td>
                            @endif
                        </tr>
                         @endif
                        @if ($object->first_cp_office_nr)
                        <tr><td class="field_container">Office Number</td><td class="input_container">{{$object->first_cp_office_nr}}</td>
                            @if($object->second_cp_office_nr)
                            <td class="field_container">Office Number</td><td class="input_container">{{$object->second_cp_office_nr}}</td>
                            @endif
                        </tr>
                         @endif
                        @if ($object->first_cp_fax_nr)
                        <tr><td class="field_container">Fax Number</td><td class="input_container">{{$object->first_cp_fax_nr}}</td>
                            @if($object->second_cp_fax_nr)
                            <td class="field_container">Fax Number</td><td class="input_container">{{$object->second_cp_fax_nr}}</td>
                            @endif
                        </tr>
                         @endif
                        @if ($object->first_cp_name  )
                        <tr>
                            <td class="field_container" style="width:20%">How did you find out about Singapore Casket?</td>
                            <td class="input_container">
                                    @foreach($sourceOptions as $source)
                                            @if ($source->id == $object->first_cp_info_source)
                                            {{$source->name}}
                                            @endif
                                    @endforeach
                            </td>
                            @if($object->second_cp_name)
                            <td class="field_container" style="width:20%">How did you find out about Singapore Casket?</td>
                            <td class="input_container">
                                    @foreach($sourceOptions as $source)
                                            @if ($source->id == $object->second_cp_info_source)
                                            {{$source->name}}
                                            @endif
                                    @endforeach
                            </td>
                            @endif
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div id="funeral_day">
                <div class="form_title">Funeral Day</div>
                <table class="form_content">
                    <tbody>
                         @if ($object->cortege_date)
                        <tr><td class="field_container">Cortege in date</td><td class="input_container">{{$object->cortege_date}}</td><td class="field_container">Day</td><td class="input_container">{{$object->cortege_date_day}}</td>
                            @if($object->cortege_date_time)
                            <td class="field_container">Time </td>
                            <td class="input_container">{{$object->cortege_date_time}}</td>
                            @endif
                        </tr>
                         @endif
                         @if ($object->funeral_date)
                        <tr><td class="field_container">Funeral Date</td><td class="input_container">{{$object->funeral_date}}</td><td class="field_container">Day</td><td class="input_container">{{$object->funeral_date_day}}</td>
                            @if($object->funeral_date_time)
                            <td class="field_container">Time </td>
                            <td class="input_container">{{$object->funeral_date_time}}</td>
                            @endif
                        </tr>
                         @endif
                         @if ($object->service_date)
                        <tr><td class="field_container">Service at</td><td class="input_container">{{$object->service_date}}</td><td class="field_container" colspan="2"> &nbsp; 
                           @if($object->service_date_time)
                            <td class="field_container">Time </td>
                            <td class="input_container">{{$object->service_date_time}}</td>
                            @endif
                        </tr>
                         @endif
                         @if ($object->for_op || $object->hall)
                        <tr><td class="field_container">For (CCK / MC / TTA / KMS)</td>
                            <td class="input_container">
                                {{$object->for_op}}
                            </td>
                            <td class="field_container">Hall</td>
                            <td class="input_container">{{$object->hall}}
                                @if($object->hall_time)
                                <td class="field_container">Time </td>
                                <td class="input_container">{{$object->hall_time}}</td>
                                @endif
                        </tr>
                        @endif

                        <tr><td class="field_container">Confirmed & checked by: </td>
                            <td colspan = "5">
                                <div  style="width: 300px">
                                    <?php
                                    $i = 0;
                                    foreach ($users as $user):
                                        if (in_array($user->id, explode(",",$object->users_ids))):
                                            echo $user->name .(($i++>0)?", ":"");
                                        endif;
                                    endforeach;
                                    ?>

                                </div>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>

            <div id="removal">
                <div class="form_title">Removal of Body</div>
                <table class="form_content">
                    <tbody>
                        @if($object->collected_from1 || $object->collected_from2)
                        <tr><td class="field_container" style="width:30%">Collected from</td><td class="input_container">{{$object->collected_from1}}</td><td colspan="4" class="input_container">{{$object->collected_from2}}</td></tr>
                        @endif
                        @if($object->sent_to1 || $object->sent_to2)
                        <tr><td class="field_container">Sent to</td><td class="input_container">{{$object->sent_to1}}</td><td colspan="4" class="input_container">{{$object->sent_to2}}</td></tr>
                        @endif
                        <tr><td class="field_container" colspan="6">&nbsp;</td></tr>
                        @if(isset($parlours) && isset($parlours[0]))
                        <tr>
                            <td class="field_container">Change parlour</td>
                            <td class="input_container"><?php echo (isset($parlours) && isset($parlours[0]))?$parlours[0]["parlour_name"]:""?></td>
                            @if(isset($parlours[0]) && $parlours[0]["parlour_from_date"])
                            <td class="field_container">From DateTime</td>
                            <td class="input_container"><?php echo (isset($parlours) && isset($parlours[0]))?$parlours[0]["parlour_from_date"].' '.$parlours[0]["parlour_from_time"]:""?></td>
                            @endif
                            @if(isset($parlours) && $parlours[0]["parlour_to_date"])
                            <td class="field_container">To DateTime</td>
                            <td class="input_container"><?php echo (isset($parlours) && isset($parlours[0]))?$parlours[0]["parlour_to_date"].' '.$parlours[0]["parlour_to_time"]:""?></td>
                            @endif
                        </tr>
                        @endif
                        @if (isset($parlours) && isset($parlours[1]["parlour_name"]))
                        <tr>
                            <td class="field_container">Add parlour</td>
                            <td class="input_container"><?php echo (isset($parlours) && isset($parlours[1]["parlour_name"]))?$parlours[1]["parlour_name"]:""?></td>
                            <td class="field_container">From date & Time</td>
                            <td class="input_container"><?php echo (isset($parlours) && isset($parlours[1]["parlour_from_date"]))?$parlours[1]["parlour_from_date"].' '.$parlours[1]["parlour_from_time"]:""?></td>
                            <td class="field_container">To date & Time</td>
                            <td class="input_container"><?php echo (isset($parlours) && isset($parlours[1]["parlour_to_date"]))?$parlours[1]["parlour_to_date"].' '.$parlours[1]["parlour_to_time"]:""?></td>
                        </tr>

                        <?php if (isset($parlours) && count($parlours) > 2):?>
                        <?php for( $i = 2; $i < count($parlours); $i++):?>
                        <?php if (!empty($parlours[$i]["parlour_name"])):?>
                        <tr>
                            <td class="field_container">Add parlour</td>
                            <td class="input_container"><?php echo (isset($parlours) && isset($parlours[$i]["parlour_name"]))?$parlours[$i]["parlour_name"]:""?></td>
                            <td class="field_container">From date & Time</td>
                            <td class="input_container"><?php echo (isset($parlours) && isset($parlours[$i]["parlour_from_date"]))?$parlours[$i]["parlour_from_date"].' '.$parlours[$i]["parlour_from_time"]:""?></td>
                            <td class="field_container">To date & Time</td>
                            <td class="input_container"><?php echo (isset($parlours) && isset($parlours[$i]["parlour_to_date"]))?$parlours[$i]["parlour_to_date"].' '.$parlours[$i]["parlour_to_time"]:""?></td>
                        </tr>
                        <?php endif;?>
                        <?php endfor;?>
                        <?php endif;?>
                        @endif
                        <tr><td class="field_container" colspan="6">&nbsp;</td></tr>
                        <tr><td class="field_container" colspan="6">&nbsp;</td></tr>
                        @if($object->resting_place)
                        <tr>
                            <td class="field_container">Final Resting Place</td>
                            <td class="input_container"  colspan="5">
                                {{$object->resting_place}}
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="field_container">Own ash collection</td>
                            <td class="input_container">

                                <?php echo ucfirst($object->own_ash_collection);?>
                            </td>
                            <td class="field_container"><span id="same_collection_txt" <?php echo ($object->own_ash_collection == "yes")?'style="display:none"':'';?>>Same date collection</span></td>
                            <td colspan="3" class="input_container" <?php echo ($object->own_ash_collection == "yes")?'style="display:none"':'';?>>
                                <?php echo ucfirst($object->same_date_collection);?>
                            </td>
                        </tr>
                        <tr <?php echo ($object->own_ash_collection == "yes")? 'style=display:none':'';?>>
                            <td class="field_container">Ashes to be collected at</td>
                            <td class="input_container">
                                {{$object->ash_collected_at == "SCC Level 2"}}
                            </td>
                            <td class="field_container">between</td>
                            <td class="input_container">{{$object->ash_collect_start}}</td><td class="field_container">to</td><td class="input_container">{{$object->ash_collect_end}}</td>
                        </tr>

                        <tr>
                            <td colspan="4">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div class="fa_section">
                <div class="form_title">Purchase</div>
                <table class="table table-striped table-bordered" style="margin-top: 30px">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Selection Item</th>
                            <th colspan="5">Remarks</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; $packge = array();?>
                    @foreach($items as $category => $selections)
                        <?php
                        $saved_ac_selection_item = $saved_ac_price = $saved_ac_remarks = "";
                        if (isset($ac) && isset($ac[$category])):
                            $saved_ac_selection_item = (isset($ac[$category]["selection_item"]))?$ac[$category]["selection_item"]:'';
                            $saved_ac_price = (isset($ac[$category]["price"]))?$ac[$category]["price"]:'';
                            $saved_ac_remarks = (isset($ac[$category]["remarks"]))?$ac[$category]["remarks"]:'';
                        endif;
                        ?>
                        @foreach($selections as $key => $group)
                            @foreach($group as $item)
                                @if ($item["id"] == $saved_ac_selection_item)
                                    <?php
                                    $product = App\Products::find($item["selection_item_id"]);
                                    if ($product){
                                        if($product->item != ""){
                                            $packge[$i]['name'] = isset($category_names[$category])?$category_names[$category]:"";
                                            $packge[$i]['item'] = $product->item;
                                            $packge[$i]['remark'] = $saved_ac_remarks;
                                            $packge[$i]['price'] = $saved_ac_price;
                                        }
                                    }
                                    else{
                                        $item["selection_item_name"];
                                    }

                                    ?>
                                @endif
                            @endforeach
                        @endforeach
                        <?php $i++;?>
                    @endforeach

                    @foreach ($packge as $key => $packages)
                    <tr>
                        <td> <?php echo $packages['name']; ?>
                        </td>

                        <td><?php echo $packages['item'];?>
                        </td>
                        <td colspan="5"><?php echo $packages['remark'];?></td>

                        <td class="price_col">
                            <?php echo $packages['price'];?>
                        </td>
                    </tr>
                    @endforeach


                    <?php $i = 0;$packge = array();?>
                    <?php foreach($sales_items as $package => $selections):?>
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
                                            <?php if ($item["id"] == $saved_si_selection_item):?>
                                                <?php
                            $product = App\Products::find($item["selection_item_id"]);
                            if ($product){
                                if($product->item == ''){
                                    continue;
                                }else{
                                    $packge[$i]['name'] = isset($package)?$package:"";
                                    $packge[$i]['item'] = $product->item;
                                    $packge[$i]['remark'] = $saved_ac_remarks;
                                    $packge[$i]['price'] = $saved_ac_price;
                                }
                            }
                            else{
                                $item["selection_item_name"];
                            }

                            ?>
                                            <?php endif;?>
                                        <?php endforeach;?>

                                    <?php endforeach;?>
                          <?php $i++;?>
                        <?php endforeach;?>

                    @foreach ($packge as $key => $packages)
                    <tr>
                        <td> <?php echo $packages['name']; ?>
                        </td>

                        <td><?php echo $packages['item'];?>
                        </td>
                        <td colspan="5"><?php echo $packages['remark'];?></td>

                        <td class="price_col">
                            <?php echo $packages['price'];?>
                        </td>

                    </tr>
                   @endforeach


                    @if(isset($hearse_name) && $hearse_name !="" && $hearse_remarks != "")
                        <tr>
                            <td>
                                Hearse
                            </td>
                            <td>
                                {{(isset($hearse_name))?$hearse_name:''}}
                            </td>

                            <td colspan="5">
                                {{(isset($hearse_remarks))?$hearse_remarks:''}}
                            </td>

                            <td class="price_col">
                                {{(isset($hearse_price))?$hearse_price:''}}
                            </td>
                        </tr>
                    @endif

                    <?php if (isset($parlours)):?>
                    <?php for( $i = 0; $i < count($parlours); $i++):?>
                    <tr id="parlour_row_<?php echo $i;?>">
                        <td>
                            Parlour
                        </td>
                        <td>
                            <?php echo (isset($parlours) && isset($parlours[$i]["parlour_name"]))?$parlours[$i]["parlour_name"]:""?>
                        </td>

                        <td colspan="5">
                            <?php echo (isset($parlours) && isset($parlours[$i]["parlour_remarks"]))?$parlours[$i]["parlour_remarks"]:"";?>
                        </td>

                        <td class="price_col">
                            <?php echo (isset($parlours) && isset($parlours[$i]["parlour_total_price"]))?$parlours[$i]["parlour_total_price"]:""?>
                        </td>
                    </tr>
                    <?php endfor;?>
                    <?php endif;?>

                    @if(isset($cck_slab_stand) && $cck_slab_stand !="" && $cck_slab_stand_remarks !="")
                        <tr>
                            <td>
                                CCK - Slab & Stand
                            </td>
                            <td>
                                {{(isset($cck_slab_stand))?$cck_slab_stand:''}}
                            </td>

                            <td colspan="5">
                                {{(isset($cck_slab_stand_remarks))?$cck_slab_stand_remarks:''}}
                            </td>

                            <td class="price_col">
                                {{(isset($cck_slab_stand_price))?$cck_slab_stand_price:''}}
                            </td>
                        </tr>
                    @endif

                    @if(isset($charcoal_lime) && $charcoal_lime !="" && $charcoal_lime_remarks !="")
                        <tr>
                            <td>
                                Charcoal & Lime
                            </td>
                            <td>
                                {{(isset($charcoal_lime))?$charcoal_lime:''}}
                            </td>

                            <td colspan="5">
                                {{(isset($charcoal_lime_remarks))?$charcoal_lime_remarks:''}}
                            </td>

                            <td class="price_col">
                                {{(isset($charcoal_lime_price))?$charcoal_lime_price:''}}
                            </td>
                        </tr>
                    @endif

                    @if(isset($obituary) && $obituary !="")
                        <tr>
                            <td>
                                Obituary Posting in newspapers
                            </td>
                            <td>
                                <?php echo $obituary ?>
                            </td>
                            <td></td>
                            <td>
                                Arranged by:
                            </td>
                            <td>

                                <?php
                                foreach ($users as $u):
                                if (!empty($obituary_arranged_by)){
                                    $arrSel = explode(",",$obituary_arranged_by);
                                }
                                else{
                                    $arrSel = array($user->id);
                                }
                                ?>

                                @if (in_array($u->id,$arrSel))
                                    {{ $u->name }}
                                @endif

                                @endforeach
                            </td>
                            <td>
                                Followed-up by:
                            </td>
                            <td>
                                <?php
                                foreach ($users as $u):
                                if (!empty($obituary_followed_up_by)){
                                    $arrSel = explode(",",$obituary_followed_up_by);
                                }
                                else{
                                    $arrSel = array($user->id);
                                }
                                ?>

                                @if (in_array($u->id, $arrSel))
                                    {{ $u->name }}
                                @endif

                                <?php endforeach;?>
                            </td>

                            <td class="price_col">
                                {{(isset($obituary_price))?$obituary_price:''}}
                            </td>
                        </tr>
                    @endif

                    @if(isset($highrise_apartment) && $highrise_apartment !="")
                        <tr>
                            <td>
                                Highrise Apartment (3rd Floor Upwards)
                            </td>
                            <td>
                                {{(isset($highrise_apartment))?$highrise_apartment:''}}
                            </td>

                            <td colspan="5">
                                {{(isset($highrise_apartment_remarks))?$highrise_apartment_remarks:''}}
                            </td>

                            <td class="price_col">
                                {{(isset($highrise_apartment_price))?$highrise_apartment_price:''}}
                            </td>
                        </tr>
                    @endif
                    @if(isset($collection_from) && $collection_from !="")
                        <tr>
                            <td>
                                Collection From
                            </td>
                            <td>
                                <?php echo $collection_from?>
                            </td>

                            <td colspan="5">
                                {{(isset($collection_from_remarks))?$collection_from_remarks:''}}
                            </td>

                            <td class="price_col">
                                {{(isset($collection_from_price))?$collection_from_price:''}}
                            </td>
                        </tr>
                    @endif

                    @if(isset($port_health_permit) && $port_health_permit !="")
                        <tr>
                            <td>
                                Port Health Permit
                            </td>
                            <td>
                                {{(isset($port_health_permit))?$port_health_permit:''}}
                            </td>

                            <td colspan="5">
                                {{(isset($port_health_permit_remarks))?$port_health_permit_remarks:''}}
                            </td>

                            <td class="price_col">
                                {{(isset($port_health_permit_price))?$port_health_permit_price:''}}
                            </td>
                        </tr>
                    @endif

                    @if(isset($disposal_of_coffin) && $disposal_of_coffin !="")
                        <tr>
                            <td>
                                Disposal of Coffin
                            </td>
                            <td>
                                {{(isset($disposal_of_coffin))?$disposal_of_coffin:''}}
                            </td>

                            <td colspan="5">
                                {{(isset($disposal_of_coffin_remarks))?$disposal_of_coffin_remarks:''}}
                            </td>

                            <td class="price_col">
                                {{(isset($disposal_of_coffin_price))?$disposal_of_coffin_price:''}}
                            </td>
                        </tr>
                    @endif

                    @if(isset($burial) && $burial !="")
                        <tr>
                            <td>
                                Burial
                            </td>
                            <td>
                                {{(isset($burial))?$burial:''}}
                            </td>

                            <td colspan="5">
                                {{(isset($burial_remarks))?$burial_remarks:''}}
                            </td>

                            <td class="price_col">
                                {{(isset($burial_price))?$burial_price:''}}
                            </td>
                        </tr>
                    @endif

                    @if(isset($others) && count($others) > 0)
                        @for($i=0; $i<count($others); $i++)
                            @if($others[$i]['price'] > 0)
                                <tr id="other_row">
                                    <td>
                                        Others
                                    </td>
                                    <td>
                                        {{$others[$i]['title']}}
                                    </td>
                                    <td colspan="5">
                                        {{$others[$i]['remarks']}}
                                    </td>
                                    <td class="price_col">
                                        {{$others[$i]['price']}}
                                    </td>
                                </tr>
                            @endif
                        @endfor
                    @endif

                    @if(isset($columbarium_order_number) && $columbarium_order_number !="")
                        <tr>
                            <td>
                                Columbarium Order
                            </td>
                            <td>
                                {{(isset($columbarium_order_number))?$columbarium_order_number:''}}
                            </td>
                            <td>{{(isset($columbarium_order_remarks))?$columbarium_order_remarks:''}}</td>
                            <td>Arranged by:</td>
                            <td>
                                <?php
                                foreach ($users as $u):
                                if (!empty($columbarium_order_arranged_by)){
                                    $arrSel = explode(",",$columbarium_order_arranged_by);
                                }
                                else{
                                    $arrSel = array($user->id);
                                }
                                ?>

                                @if (in_array($u->id,$arrSel))
                                    {{ $u->name }}
                                @endif

                                <?php endforeach;?>

                            </td>
                            <td>Followed-up by:</td>
                            <td>
                                <?php
                                foreach ($users as $u):
                                if (!empty($columbarium_order_followed_up_by)){
                                    $arrSel = explode(",",$columbarium_order_followed_up_by);
                                }
                                else{
                                    $arrSel = array($user->id);
                                }
                                ?>
                                @if (in_array($u->id, $arrSel))
                                    {{ $u->name }}
                                @endif
                                <?php endforeach;?>

                            </td>
                            <td class="price_col">
                                {{(isset($columbarium_price))?$columbarium_price:''}}
                            </td>
                        </tr>

                    @endif

                    @if(isset($cremation_fee) && $cremation_fee !="")
                        <tr>
                            <td>
                                Cremation Fee
                            </td>
                            <td>
                                {{(isset($cremation_fee))?$cremation_fee:''}}
                            </td>

                            <td colspan="5">
                                {{(isset($cremation_fee_remarks))?$cremation_fee_remarks:''}}
                            </td>
                            <td class="price_col">
                                {{(isset($cremation_fee_price))?$cremation_fee_price:''}}
                            </td>
                        </tr>
                    @endif
                    @if(isset($night_care) && $night_care != "")
                        <tr>
                            <td>
                                Night Care service team ( services )
                            </td>
                            <td>
                                {{(isset($night_care))?$night_care:''}}
                            </td>

                            <td colspan="5">
                                {{(isset($night_care_price))?$night_care_price:''}}
                            </td>
                            <td class="price_col">
                                {{(isset($night_care_price))?$night_care_price:''}}
                            </td>
                        </tr>
                    @endif

                    @if(isset($disposal_coffin) && $disposal_coffin !="")
                        <tr>
                            <td>
                                Disposal of coffin
                            </td>
                            <td>
                                {{(isset($disposal_coffin))?$disposal_coffin:''}}
                            </td>

                            <td colspan="5">
                                {{(isset($disposal_coffin_price))?$disposal_coffin_price:''}}
                            </td>
                            <td class="price_col">
                                {{(isset($disposal_coffin_price))?$disposal_coffin_price:''}}
                            </td>
                        </tr>
                    @endif
                    @if(isset($gemstone_order_number) && $gemstone_order_number !="")
                        <tr>
                            <td>
                                Gem stone
                            </td>
                            <td>
                                {{(isset($gemstone_order_number))?$gemstone_order_number:''}}
                            </td>

                            <td>
                                {{(isset($gemstone_order_remarks))?$gemstone_order_remarks:''}}
                            </td>
                            <td>Arranged by:</td>
                            <td>
                                <?php
                                foreach ($users as $u):
                                if (!empty($gemstone_order_arranged_by)){
                                    $arrSel = explode(",",$gemstone_order_arranged_by);
                                }
                                else{
                                    $arrSel = array($user->id);
                                }
                                ?>

                                @if (in_array($u->id,$arrSel))
                                    {{ $u->name }}
                                @endif

                                <?php endforeach;?>

                            </td>
                            <td>Followed-up by:</td>
                            <td>
                                <?php
                                foreach ($users as $u):
                                if (!empty($gemstone_order_followed_up_by)){
                                    $arrSel = explode(",",$gemstone_order_followed_up_by);
                                }
                                else{
                                    $arrSel = array($user->id);
                                }
                                ?>


                                @if (in_array($u->id, $arrSel))
                                    {{ $u->name }}
                                @endif


                                <?php endforeach;?>

                            </td>
                            <td class="price_col">
                                {{(isset($gemstone_order_price))?$gemstone_order_price:''}}
                            </td>
                        </tr>
                    @endif

                    @if($object->package_total > 0)
                        <tr>
                            <td>
                                FA Package
                            </td>
                            <td>
                                <?php
                                    $selected_item = "[".$selected_package->category."] - \n[".$selected_package->name."] - \n[".$selected_package->promo_price."]";
                                ?>
                                <textarea disabled="disabled" class="form-control" style="width: 100%;overflow: auto; min-height: 100px;">{{$selected_item}}</textarea>
                            </td>

                            <td colspan="5">
                                <?php $item_text = ""; ?>
                                @foreach($selected_package_items as $selected_package_item)
                                    <?php
                                    $package_item = App\PackageItems::find($selected_package_item);
                                    $item_text .= $package_item->selection_category.' - '.$package_item->selection_item_name;
                                    if($package_item->add_on_price>0)
                                        $item_text .= "(Add on: $".$package_item->add_on_price.")";
                                    $item_text .= "\n";
                                    ?>
                                @endforeach
                                <textarea disabled="disabled" class="form-control"  style="width: 100%;overflow: auto; min-height: 100px;">{{$item_text}}</textarea>
                            </td>
                            <td class="price_col">
                                <div></div><input type="number" min="0.01" step="0.01" class="form-control" disabled="disabled" value="{{number_format($object->package_total, 2, '.', '')}}" />
                            </td>
                        </tr>
                    @endif


                    <?php // MORE PACKS ----------------------------------------------------- ?>
                    <?php if (isset($mp)):?>
                    <?php $i = 0;$packge=array();?>
                    <?php foreach($mp as $package => $other_item):?>


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
                                        <?php if ($list_package == $package && $item["id"] == $saved_mp_selection_item):?>
                                            <?php
                            $product = App\Products::find($item["selection_item_id"]);
                            if ($product){
                                if($product->item == ''){
                                    continue;
                                }else{
                                    $packge[$i]['name'] = $list_package == $package?$list_package:'';
                                    $packge[$i]['item'] = $product->item;
                                    $packge[$i]['remark'] = $saved_ac_remarks;
                                    $packge[$i]['price'] = $saved_ac_price;
                                }
                            }
                            else{
                                $item["selection_item_name"];
                            }

                            ?>
                                        <?php endif;?>
                                    <?php endforeach;?>

                                <?php endforeach;?>
                            <?php $sel++; ?>
                            <?php endforeach;?>
                             <?php $i++;?>
                    <?php endforeach;?>
                    <?php endif;?>


                    <?php foreach($packge as $packages){?>
                    <tr>
                        <td>
                            <?php echo $packge['name'] ?>
                        </td>
                        <td>
                            <?php echo $packge['item'] ?>
                        </td>
                        <td colspan="5"><?php echo $packge['remark'] ?></td>
                        <td class="price_col">
                            <?php echo $packge['price'] ?>
                        </td>
                    </tr>
                    <?php } ?>



                    <?php if($miscellaneous != ""){?>
                    <tr>
                        <td>
                            Miscellaneous
                        </td>
                        <td>
                            <?php echo $miscellaneous . (($miscellaneous != "" && $miscellaneous != "special_discount")?"%":"")?>
                        </td>


                        <td  colspan="5"></td>
                        <td class="price_col">

                        </td>
                    </tr>
                    <?php } ?>
                    <tr>

                        <td></td>
                        <td></td>
                        <td colspan="5"><b>Total</b></td>
                        <td class="price_col"> ${{$total_step_3}}</td>
                    </tr>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="form">

                <table style="margin-top: 40px; width:500px">
                    <tr>
                        <td colspan="5" style="text-align: right;">
                            <table style="float:right">
                                <tr>
                                    <td>Sub-Total&nbsp;</td>
                                    <td style="width:100px; float:right;">${{$object->total_step_3}}</td>
                                </tr>
                                @if ($object->miscellaneous &&  $object->miscellaneous != "special_discount")
                                <tr>
                                    <td><span >Discount (%)&nbsp;</span></td>
                                    <td>{{$object->miscellaneous}}</td>
                                </tr>
                                @endif



                                @if ($object->miscellaneous == "special_discount")
                                <tr>
                                    <td><span style="color: #CCC">Special discount(approved by: )&nbsp;</span></td>
                                    <td>{{$object->miscellaneous_amount}}</td>
                                </tr>
                                @endif

                                <tr>
                                    <td>Total&nbsp;</td>
                                    <td>${{$object->final_total}}</td>
                                </tr>
                                <tr>
                                    <td>GST 7%&nbsp;</td>
                                    <td>${{$object->gst_value}}</td>
                                </tr>
                                <tr>
                                    <td>Total with GST&nbsp;</td>
                                    <td>${{$object->total_with_gst}}</td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="height: 100px">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: left;">
                            <table style="width: 50%">
                            <tr>
                                <td style="text-align: left;">
                                    Coffin Lifting on Funeral Day
                                </td>
                                <td style="text-align: left;">
                                    <?php echo $object->coffin_lifting ?>
                                </td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">
                                    SCC Care Monk Chanting
                                </td>
                                <td style="text-align: left;">
                                    <?php echo $object->monk_chanting?>
                                </td>
                                <td style="text-align: left;">
                                    {{$object->monk_chanting_remarks}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="height: 20px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td id="f2_remarks_container" colspan="3" style="text-align: left;">
                                    <strong>Remarks</strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: left;">
                                    {{$object->final_remarks}}
                                </td>
                                <td>
                                </td>
                            </tr>
                        </table>
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
                            Date:

                                @if ($object->signature_date && $object->signature_date != "0000-00-00")
                                    {{date("d/m/Y", strtotime($object->signature_date))}}
                                @endif

                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td style="text-align:center">
                            Date:
                            @if($object->signature_date && $object->signature_date != "0000-00-00")
                                    {{date("d/m/Y", strtotime($object->signature_date))}}

                            @endif
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