<form action="{{ URL::to('/fa/saveForm') }}"  id="info_frm" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="hidden" name="generated_code" value="{{ $object->generated_code }}" />
    <input type="hidden" name="faid" id="faid" value="{{ $object->id }}" />
    <input type="hidden" name="step" id="step" value="1" />
    <input type="hidden" name="changes_made" id="changes_made" value="" />
    <div id="fa_form" class="needs_exit_warning">
        <div id="number"> {{ $object->getCompanyPrefix() }}{{ $object->generated_code }}</div>
        
        <div style="text-align:center">
            <div id="deceased_details">
                @if(Session::has('msg'))
                    <div class="alert alert-info">
                        <a class="close" data-dismiss="alert">×</a>
                        {!!Session::get('msg')!!} 
                    </div>
                @endif
                <?php Session::remove('msg'); ?>
                <div class="form_title">Deceased details</div>
                <table class="form_content">
                    <tbody>
                        <tr><td class="field_container">Deceased Name</td><td colspan="5" class="input_container"><input type="text" name="deceased_name"  id="deceased_name" class="form-control" value="{{$object->deceased_name}}"  /><input type="hidden" name="shifting_id" id="shifting_id" value="{{ $object->id }}" /></tr>
                        <tr><td class="field_container">Religion</td>
                            <td class="input_container">
                                <select name="religion" style="width: 170px;" class="form-control">
                                    @foreach($religionOptions as $religionOp)
                                    <option value="{{$religionOp->id}}" 
                                            @if ($religionOp->id == $object->religion)
                                            selected="true"
                                            @endif
                                            >{{$religionOp->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="field_container">Church</td><td colspan="3" class="input_container"><input type="text" name="church"  class="form-control" id="church" value="{{$object->church}}" /></td>
                        </tr>
                        <tr>
                            <td class="field_container">Sex</td>
                            <td colspan="5" class="input_container">
                                <select name="sex" style="width: 170px;" class="form-control">
                                    <option value="male" <?php echo ($object->sex == "male")?'selected="true"':'';?>>Male</option>
                                    <option value="female" <?php echo ($object->sex == "female")?'selected="true"':'';?>>Female</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Race</td>
                            <td class="input_container">
                                <select name="race" style="width: 170px;" class="form-control">
                                    @foreach($raceOptions as $raceOp)
                                    <option value="{{$raceOp->id}}"
                                            @if ($raceOp->id == $object->race)
                                            selected="true"
                                            @endif
                                            >{{$raceOp->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="field_container">Dialects</td>
                            <td colspan="2" class="input_container">
                                <input type="text" id="dialect" name="dialect"  class="form-control" value="{{$object->dialect}}" />
                            </td>
                        </tr>
                        <tr><td class="field_container">Date of Birth</td><td class="input_container"><input type="text" id="birthdate" name="birthdate" class="datepicker_fa form-control" value="{{$object->birthdate}}"  /></td><td class="field_container">Date of Death</td><td class="input_container"><input type="text" id="deathdate" name="deathdate" class="datepicker_fa form-control" value="{{$object->deathdate}}" /></td><td id="age_field_container" class="field_container">Age</td><td id="age_input_container" class="input_container"><input type="text" id="age"  class="form-control" name="age" value="{{$object->age}}" /></td></tr>
                        <tr><td colspan="6" style="text-align:center;padding-left: 40%; padding-top: 23px;"><input type="file" name='files' /></td></tr>
                    </tbody>
                </table>
            </div>
            
            
            
            <div id="point_contact">
                <div class="form_title">Point of Contact</div>
                <table class="form_content">
                    <tbody>
                        <tr><td colspan="2" class="field_container" style="text-align: center">1st Contact Person</td><td colspan="2" class="field_container" style="text-align: center">2st Contact Person</td></tr>
                        <tr><td class="field_container">Name</td><td class="input_container" ><input type="text"  class="form-control" id="first_cp_name" name="first_cp_name" value="{{$object->first_cp_name}}" /></td><td class="field_container">Name</td><td class="input_container"><input type="text" class="form-control" id="second_cp_name" name="second_cp_name" value="{{$object->second_cp_name}}" /></td></tr>
                        <tr><td class="field_container">NRIC No</td><td class="input_container"><input type="text" class="form-control" id="first_cp_nric" name="first_cp_nric" value="{{$object->first_cp_nric}}" /></td><td class="field_container">NRIC No</td><td class="input_container"><input type="text" class="form-control" id="second_cp_nric" name="second_cp_nric" value="{{$object->second_cp_nric}}" /></td></tr>
                        <tr><td class="field_container">Email address</td><td class="input_container"><input type="text"  class="form-control" id="first_cp_email" name="first_cp_email" value="{{$object->first_cp_email}}" /></td><td class="field_container">Email address</td><td class="input_container"><input type="text" class="form-control" id="second_cp_email" name="second_cp_email" value="{{$object->second_cp_email}}" /></td></tr>
                        <tr><td class="field_container">Postal Code</td><td class="input_container"><input type="text"  class="form-control" id="first_cp_postal_code" name="first_cp_postal_code" value="{{$object->first_cp_postal_code}}" /></td><td class="field_container">Postal Code</td><td class="input_container"><input type="text" class="form-control" id="second_cp_postal_code" name="second_cp_postal_code" value="{{$object->second_cp_postal_code}}" /></td></tr>
                        <tr><td class="field_container">Address</td><td class="input_container"><input type="text" class="form-control" class="address" id="first_cp_address" name="first_cp_address" value="{{$object->first_cp_address}}" /></td><td class="field_container">Address</td><td class="input_container"><input type="text" class="form-control" id="second_cp_address" name="second_cp_address" class="address" value="{{$object->second_cp_address}}" /></td></tr>
                        <tr><td class="field_container">Home Number</td><td class="input_container"><input type="text" class="form-control"  id="first_cp_home_nr" name="first_cp_home_nr" value="{{$object->first_cp_home_nr}}" /></td><td class="field_container">Home Number</td><td class="input_container"><input type="text" class="form-control" id="second_cp_home_nr" name="second_cp_home_nr" value="{{$object->second_cp_home_nr}}" /></td></tr>
                        <tr><td class="field_container">Mobile Number</td><td class="input_container"><input type="text"  class="form-control" id="first_cp_mobile_nr" name="first_cp_mobile_nr" value="{{$object->first_cp_mobile_nr}}" /></td><td class="field_container">Mobile Number</td><td class="input_container"><input type="text" class="form-control" id="second_cp_mobile_nr" name="second_cp_mobile_nr" value="{{$object->second_cp_mobile_nr}}" /></td></tr>
                        <tr><td class="field_container">Office Number</td><td class="input_container"><input type="text"  class="form-control" id="first_cp_office_nr" name="first_cp_fax_nr" value="{{$object->first_cp_fax_nr}}" /></td><td class="field_container">Office Number</td><td class="input_container"><input type="text" class="form-control" id="second_cp_office_nr" name="second_cp_office_nr" value="{{$object->second_cp_office_nr}}" /></td></tr>
                        <tr><td class="field_container">Fax Number</td><td class="input_container"><input type="text" class="form-control"  id="first_cp_fax_nr" name="first_cp_fax_nr" value="{{$object->first_cp_fax_nr}}" /></td><td class="field_container">Fax Number</td><td class="input_container"><input type="text" class="form-control" id="second_cp_fax_nr" name="second_cp_fax_nr" value="{{$object->second_cp_fax_nr}}" /></td></tr>
                        <tr>
                            <td class="field_container">How did you find out about Singapore Casket?</td>
                            <td class="input_container">
                                <select name="first_cp_info_source" style="width: 170px;" class="form-control">
                                    @foreach($sourceOptions as $source)
                                    <option value="{{$source->id}}"
                                            @if ($source->id == $object->first_cp_info_source)
                                            selected="true"
                                            @endif
                                            >{{$source->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="field_container">How did you find out about Singapore Casket?</td>
                            <td class="input_container">
                                <select name="second_cp_info_source" style="width: 170px;" class="form-control">
                                    @foreach($sourceOptions as $source)
                                    <option value="{{$source->id}}"
                                            @if ($source->id == $object->second_cp_info_source)
                                            selected="true"
                                            @endif
                                            >{{$source->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            
            
            <div id="funeral_day">
                <div class="form_title">Funeral Day</div>
                <table class="form_content">
                    <tbody>
                        <tr><td class="field_container">Cortege in date</td><td class="input_container"><input type="text" id="cortege_date" name="cortege_date" class="datepicker_fa form-control" value="{{$object->cortege_date}}" /></td><td class="field_container">Day</td><td class="input_container"><input type="text"  class="form-control" id="cortege_date_day" name="cortege_date_day" value="{{$object->cortege_date_day}}" /></td><td class="field_container">Time </td><td class="input_container"><input type="text"  class="form-control" id="cortege_date_time" name="cortege_date_time" value="{{$object->cortege_date_time}}" /></tr>
                        <tr><td class="field_container">Funeral Date</td><td class="input_container"><input type="text"  id="funeral_date" name="funeral_date" class="datepicker_fa form-control" value="{{$object->funeral_date}}" /></td><td class="field_container">Day</td><td class="input_container"><input type="text"  class="form-control" id="funeral_date_day" name="funeral_date_day" value="{{$object->funeral_date_day}}" /></td><td class="field_container">Time </td><td class="input_container"><input type="text"  class="form-control" id="funeral_date_time" name="funeral_date_time" value="{{$object->funeral_date_time}}" /></tr>
                        <tr><td class="field_container">Service at</td><td class="input_container"><input type="text"  class="form-control" id="service_date" name="service_date" value="{{$object->service_date}}" /></td><td class="field_container" colspan="2"> &nbsp; <td class="field_container">Time </td><td class="input_container"><input type="text"  class="form-control" id="service_date_time" name="service_date_time" value="{{$object->service_date_time}}" /></td></tr>
                        <tr><td class="field_container">For (CCK / MC / TTA / KMS)</td>
                            <td class="input_container">
                                <select name="for_op" id="for_op" style="width: 170px;" class="form-control">
                                    <option value="CCK" <?php echo ($object->for_op == "CCK")?'selected="true"':'';?>>CCK</option>
                                    <option value="MC" <?php echo ($object->or_op == "MC")?'selected="true"':'';?>>MC</option>
                                    <option value="RRA" <?php echo ($object->for_op == "RRA")?'selected="true"':'';?>>RRA</option>
                                    <option value="KMS" <?php echo ($object->for_op == "KMS")?'selected="true"':'';?>>KMS</option>
                                </select>
                            </td>
                            <td class="field_container">Hall</td>
                            <td class="input_container"><input type="text"  id="hall" name="hall" value="{{$object->hall}}" class="form-control" /><td class="field_container">Time </td><td class="input_container"><input type="text"  class="form-control" id="hall_time" name="hall_time" value="{{$object->hall_time}}" /></tr>
                        <tr><td class="field_container">Confirmed & checked by: </td><td colspan = "5"><div  style="width: 300px">
                                            <select class="form-control" name="users_ids" data-toggle="select2" multiple class="form-control">
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                            @if (in_array($user->id, explode(",",$object->users_ids)))
                                                            selected="selected"
                                                            @endif
                                                            >
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                </div>
                                        </td></tr>
                        <tr><td class="field_container" colspan="6"><a href="http://www.nea.gov.sg/public-health/care-for-the-dead" target="_blank">[Click here for NEA website]</a></td></tr>
                        <tr><td class="field_container" colspan="3">&nbsp;</td><td class="field_container" colspan="3"><a href="<?php echo App::make('url')->to('/');?>/fa/genpdf/embalming/{{$object->id}}"  target="_blank">Click to generate Embalming Declaration form</a></td></tr>
                        <tr><td class="field_container" colspan="3"><a href="<?php echo App::make('url')->to('/');?>/fa/genpdf/loa/{{$object->id}}"  target="_blank">Click to generate LOA form</a></td><td class="field_container" colspan="3"><a href="<?php echo App::make('url')->to('/');?>/fa/genpdf/declination/{{$object->id}}" target="_blank">Click to generate Embalming Declination form</a></td></tr>
                        
                    </tbody>
                </table>
            </div>
          
            <div id="removal">
                <div class="form_title">Removal of Body</div>
                <table class="form_content">
                    <tbody>
                        <tr><td class="field_container">Collected from</td><td class="input_container"><input type="text" id="collected_from1" name="collected_from1" value="{{$object->collected_from1}}" class="form-control" /></td><td colspan="4" class="input_container"><input type="text" id="collected_from2" name="collected_from2" value="{{$object->collected_from2}}" class="form-control" /></td></tr>
                        <tr><td class="field_container">Sent to</td><td class="input_container"><input type="text" id="sent_to1" name="sent_to1" value="{{$object->sent_to1}}" class="form-control" /></td><td colspan="4" class="input_container"><input type="text" id="sent_to2" name="sent_to2" value="{{$object->sent_to2}}" class="form-control" /></td></tr>
                        <tr><td class="field_container" colspan="6">&nbsp;</td></tr>
                        <tr>
                            <td class="field_container">
                                <a href="#" id="add_parlour_1" class="add_parlour">Change parlour</a>
                                <input type="hidden" id="parlour_id_1" name="parlour_id[]" value="<?php echo (isset($parlours) && isset($parlours[0]["parlour_id"]))?$parlours[0]["parlour_id"]:""?>" />
                                <input type="hidden" id="parlour_unit_price_1" name="parlour_unit_price[]"  value="<?php echo (isset($parlours) && isset($parlours[0]["parlour_unit_price"]))?$parlours[0]["parlour_unit_price"]:""?>" />
                                <input type="hidden" id="parlour_total_price_1" name="parlour_total_price[]"  value="<?php echo (isset($parlours) && isset($parlours[0]["parlour_total_price"]))?$parlours[0]["parlour_total_price"]:""?>" />
                                <input type="hidden" id="parlour_hours_1" name="parlour_hours[]"  value="<?php echo (isset($parlours) && isset($parlours[0]["parlour_hours"]))?$parlours[0]["parlour_hours"]:""?>" />
                                <input type="hidden" id="parlour_order_id_1" name="parlour_order_id[]"  value="<?php echo (isset($parlours) && isset($parlours[0]["parlour_order_id"]))?$parlours[0]["parlour_order_id"]:""?>" />
                            </td>
                            <td class="input_container">
                                <input type="text" class="form-control" id="parlour_name_1" name="parlour_name[]" value="<?php echo (isset($parlours) && isset($parlours[0]))?$parlours[0]["parlour_name"]:""?>" />
                            </td>
                            <td class="field_container">From date & Time</td>
                            <td class="input_container">
                                <input type="text"  class="form-control" id="parlour_from_1" name="parlour_from[]" value="<?php echo (isset($parlours) && isset($parlours[0]))?$parlours[0]["parlour_from"]:""?>" />
                            </td>
                            <td class="field_container">To date & Time</td>
                            <td class="input_container">
                                <input type="text" class="form-control" id="parlour_to_1" name="parlour_to[]" value="<?php echo (isset($parlours) && isset($parlours[0]))?$parlours[0]["parlour_to"]:""?>" />
                            </td>
                        </tr>
                        <tr id="parlour_row_2">
                            <td class="field_container">
                                <a href="#" id="add_parlour_2" class="add_parlour">Add parlour</a>
                                <input type="hidden" id="parlour_id_2" name="parlour_id[]"  value="<?php echo (isset($parlours) && isset($parlours[1]["parlour_id"]))?$parlours[1]["parlour_id"]:""?>" />
                                <input type="hidden" id="parlour_unit_price_2" name="parlour_unit_price[]"  value="<?php echo (isset($parlours) && isset($parlours[1]["parlour_unit_price"]))?$parlours[1]["parlour_unit_price"]:""?>" />
                                <input type="hidden" id="parlour_total_price_2" name="parlour_total_price[]"  value="<?php echo (isset($parlours) && isset($parlours[1]["parlour_total_price"]))?$parlours[1]["parlour_total_price"]:""?>" />
                                <input type="hidden" id="parlour_hours_2" name="parlour_hours[]"  value="<?php echo (isset($parlours) && isset($parlours[1]["parlour_hours"]))?$parlours[1]["parlour_hours"]:""?>" />
                                <input type="hidden" id="parlour_order_id_2" name="parlour_order_id[]"  value="<?php echo (isset($parlours) && isset($parlours[1]["parlour_order_id"]))?$parlours[1]["parlour_order_id"]:""?>" />
                            </td>
                            <td class="input_container">
                                <input type="text" class="form-control" id="parlour_name_2" name="parlour_name[]"  value="<?php echo (isset($parlours) && isset($parlours[1]["parlour_name"]))?$parlours[1]["parlour_name"]:""?>" />
                            </td>
                            <td class="field_container">From date & Time</td>
                            <td class="input_container">
                                <input type="text"  class="form-control" id="parlour_from_2" name="parlour_from[]"  value="<?php echo (isset($parlours) && isset($parlours[1]["parlour_from"]))?$parlours[1]["parlour_from"]:""?>" />
                            </td>
                            <td class="field_container">To date & Time</td>
                            <td class="input_container">
                                <input type="text" class="form-control" id="parlour_to_2" name="parlour_to[]"  value="<?php echo (isset($parlours) && isset($parlours[1]["parlour_to"]))?$parlours[1]["parlour_to"]:""?>" />
                            </td>
                        </tr>
                        
                        <?php if (isset($parlours) && count($parlours) > 2):?>
                        <?php for( $i = 2; $i < count($parlours); $i++):?>
                        <?php if (!empty($parlours[$i]["parlour_name"])):?>
                        <tr id="parlour_row_<?php echo $i+1;?>">
                            <td class="field_container">
                                <a href="#" id="add_parlour_<?php echo $i+1;?>" class="add_parlour">Add parlour</a>
                                <input type="hidden" id="parlour_id_<?php echo $i+1;?>" name="parlour_id[]"  value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_id"]))?$parlours[$i]["parlour_id"]:""?>" />
                                <input type="hidden" id="parlour_unit_price_<?php echo $i+1;?>" name="parlour_unit_price[]"  value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_unit_price"]))?$parlours[$i]["parlour_unit_price"]:""?>" />
                                <input type="hidden" id="parlour_total_price_<?php echo $i+1;?>" name="parlour_total_price[]"  value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_total_price"]))?$parlours[$i]["parlour_total_price"]:""?>" />
                                <input type="hidden" id="parlour_hours_<?php echo $i+1;?>" name="parlour_hours[]"  value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_hours"]))?$parlours[$i]["parlour_hours"]:""?>" />
                                <input type="hidden" id="parlour_order_id_<?php echo $i+1;?>" name="parlour_order_id[]"  value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_order_id"]))?$parlours[$i]["parlour_order_id"]:""?>" />
                            </td>
                            <td class="input_container">
                                <input type="text" class="form-control" id="parlour_name_<?php echo $i+1;?>" name="parlour_name[]"  value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_name"]))?$parlours[$i]["parlour_name"]:""?>" />
                            </td>
                            <td class="field_container">From date & Time</td>
                            <td class="input_container">
                                <input type="text"  class="form-control" id="parlour_from_<?php echo $i+1;?>" name="parlour_from[]"  value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_from"]))?$parlours[$i]["parlour_from"]:""?>" />
                            </td>
                            <td class="field_container">To date & Time</td>
                            <td class="input_container">
                                <input type="text" class="form-control" id="parlour_to_<?php echo $i+1;?>" name="parlour_to[]"  value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_to"]))?$parlours[$i]["parlour_to"]:""?>" />
                            </td>
                        </tr>
                        <?php endif;?>                 
                        <?php endfor;?>
                        <?php endif;?>                 
                        
                        <tr><td class="field_container" colspan="6"><a href="" id="add_more_parlour_rows">Click to add more</a></td></tr>
                        <tr><td class="field_container" colspan="6">&nbsp;</td></tr>
                        <tr><td class="field_container" colspan="6"><a href="<?php echo App::make('url')->to('/');?>/fa/genpdf/parlour/{{$object->id}}"  target="_blank">Click to generate Parlour form</a></td></tr>
                        <tr><td class="field_container" colspan="6">&nbsp;</td></tr>
                        <tr>
                            <td class="field_container">Final Resting Place</td>
                            <td class="input_container"  colspan="5">
                                <select id="resting_place" name="resting_place" style="width: 170px;" class="form-control">
                                    <option value="Sea Burial" <?php echo ($object->resting_place == "Sea Burial")?'selected="true"':'';?>>Sea Burial</option>
                                    <option value="Nirvana" <?php echo ($object->resting_place == "Nirvana")?'selected="true"':'';?>>Nirvana</option>
                                    <option value="KMS" <?php echo ($object->resting_place == "KMS")?'selected="true"':'';?>>KMS</option>
                                    <option value="other" <?php echo (!in_array($object->resting_place, array("Sea Burial","Nirvana","KMS")))?'selected="true"':'';?>>Other</option>
                                </select>
                                <input type="text" id="other_resting_place" name="other_resting_place"  value="{{$object->resting_place}}" <?php echo (!in_array($object->resting_place, array("Sea Burial","Nirvana","KMS")))?'':'style="display:none"';?>  class="form-control" />
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Own ash collection</td>
                            <td class="input_container">
                                <select id="own_ash_collection" name="own_ash_collection" style="width: 170px;" class="form-control">
                                    <option value="yes" <?php echo ($object->own_ash_collection == "yes")?'selected="true"':'';?>>Yes</option>
                                    <option value="no" <?php echo ($object->own_ash_collection != "yes")?'selected="true"':'';?>>No</option>
                                </select>
                            </td>
                            <td class="field_container"><span id="same_collection_txt" <?php echo ($object->own_ash_collection == "yes")?'style="display:none"':'';?>>Same date collection</span></td>
                            <td colspan="3" class="input_container" <?php echo ($object->own_ash_collection == "yes")?'style="display:none"':'';?>>
                                
                                <select id="same_date_collection" name="same_date_collection" style="width: 170px;<?php echo ($object->own_ash_collection == "no")?'display:none':'';?>" class="form-control">
                                    <option value="yes" <?php echo ($object->same_date_collection == "yes")?'selected="true"':'';?>>Yes</option>
                                    <option value="no" <?php echo ($object->same_date_collection == "no")?'selected="true"':'';?>>No</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="ashes_to_be_collected_at_container"  <?php echo ($object->own_ash_collection && $object->own_ash_collection == "yes")?'style="display:none"':'';?>>
                            <td class="field_container">Ashes to be collected at</td>
                            <td class="input_container">
                                <select id="ash_collected_at" name="ash_collected_at" style="width: 170px;" class="form-control">
                                    <option value="SCC Level 2" <?php echo ($object->ash_collected_at == "SCC Level 2")?'selected="true"':'';?>>SCC Level 2</option>
                                    <option value="Mandai" <?php echo ($object->ash_collected_at == "Mandai")?'selected="true"':'';?>>Mandai</option>
                                    <option value="KMS" <?php echo ($object->ash_collected_at == "KMS")?'selected="true"':'';?>>KMS</option>
                                    <option value="other" <?php echo (!in_array($object->resting_place, array("SCC Level 2","Mandai","KMS")))?'selected="true"':'';?>>Other</option>
                                </select>
                                <input type="text" id="other_ash_collected_at" name="other_ash_collected_at" class="form-control" <?php echo (!in_array($object->resting_place, array("SCC Level 2","Mandai","KMS")))?'':'style="display:none"';?> value="{{$object->ash_collected_at}}" />
                            </td>
                            <td class="field_container">between</td>
                            <td class="input_container"><input type="text" id="ash_collect_start" name="ash_collect_start" class="datetimepicker form-control" value="{{$object->ash_collect_start}}" class="form-control" /></td><td class="field_container">to</td><td class="input_container"><input type="text" id="ash_collect_end" name="ash_collect_end" value="{{$object->ash_collect_end}}"  class="datetimepicker form-control" /></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="height: 70px"></td>
                        </tr>
                        <tr>
                            <td>
                                
                            </td>
                            <td colspan="5" style="text-align: right;">
                                <input type="hidden" id="go_to_step" name="go_to_step" value="" />
                                <a class="btn btn-primary" id="next_bttn" /> Next &nbsp;<i class="fa fa-forward"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="height: 20px"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</form>


<div class="modal fade" id="add_parlour" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Parlour</h4>
            </div>

            <div class="modal-body">

            </div>
            <div class="modal-footer">
                
            </div>

        </div>
    </div>
</div>