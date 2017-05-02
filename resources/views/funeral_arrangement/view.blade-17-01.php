   @if (!$object)
   Form no found
   @else

    <form action="{{ URL::to('/fa/saveForm') }}"  id="info_frm" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="hidden" name="generated_code" value="{{ $object->generated_code }}" />
    <input type="hidden" name="changes_made" id="changes_made" value="" />
    <input type="hidden" name="faid" id="faid" value="{{ $object->id }}" />
    <input type="hidden" name="is_view" id="is_view" value="1" />
    <div id="fa_form">
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
                        <tr><td class="field_container">Deceased Name</td><td colspan="5" class="input_container"><input type="text" name="deceased_name"  id="deceased_name" class="form-control" value="{{$object->deceased_name}}"  /></tr>
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
                        <tr>
                            <td colspan="6" style="text-align:center; padding-top: 23px; font-weight: bold">
                                @if ($object->filename)
                                <a href="{{ url("/fa/download/" . $object->id) }}" target="_blank">Download file</a>
                                @else
                                    No file uploaded
                                @endif
                            </td>
                        </tr>
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
                                <input type="hidden" id="total_price_1" name="parlour_unit_price[]"  value="<?php echo (isset($parlours) && isset($parlours[0]["parlour_unit_price"]))?$parlours[0]["parlour_unit_price"]:""?>" />
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
                                <input type="hidden" id="total_price_2" name="parlour_unit_price[]"  value="<?php echo (isset($parlours) && isset($parlours[1]["parlour_unit_price"]))?$parlours[1]["parlour_unit_price"]:""?>" />
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
                                <input type="hidden" id="total_price_<?php echo $i+1;?>" name="parlour_unit_price[]"  value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_unit_price"]))?$parlours[$i]["parlour_unit_price"]:""?>" />
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
                                    <option value="no" <?php echo ($object->own_ash_collection == "no")?'selected="true"':'';?>>No</option>
                                </select>
                            </td>
                            <td class="field_container"><span id="same_collection_txt" <?php echo ($object->own_ash_collection == "yes")?'style="display:none"':'';?>>Same date collection</span></td>
                            <td colspan="3" class="input_container" <?php echo ($object->own_ash_collection == "yes")?'style="display:none"':'';?>>
                                <select id="same_date_collection" name="same_date_collection" style="width: 170px;<?php echo ($object->own_ash_collection == "no")?'display:none':'';?>" class="form-control">
                                    <option value="yes" <?php echo ($object->same_date_collection == "yes")?'selected="true"':'';?>>Yes</option>
                                    <option value="no" <?php echo ($object->same_date_collection == "yes")?'selected="true"':'';?>>No</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="ashes_to_be_collected_at_container" <?php echo ($object->own_ash_collection == "yes")?'style="display:none"':'';?>>
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
                    </tbody>
                </table>
            </div>
            
            
            
            <div class="fa_section">
                <div class="form_title">Purchase</div>
                <table class="table table-striped table-bordered" style="margin-top: 30px">
                    <thead>
                        <tr>
                            <th>
                                Category Name
                            </th>
                            <th>
                                Selection Item
                            </th>
                            
                            <th colspan="5">
                                Remarks
                            </th>
                            <th>
                                Price
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0;?>
                        <?php foreach($items as $category => $selections):?>
                        <tr>
                            <td>
                                <?php echo (isset($category_names[$category]))?$category_names[$category]:""?>
                                <input type="hidden" name="ac_category[]" value="<?php echo $category?>" />
                            </td>
                            <td>
                                <?php 
                                    $saved_ac_selection_item = $saved_ac_price = $saved_ac_remarks = "";
                                    if (isset($ac) && isset($ac[$category])):
                                        $saved_ac_selection_item = (isset($ac[$category]["selection_item"]))?$ac[$category]["selection_item"]:'';
                                        $saved_ac_price = (isset($ac[$category]["price"]))?$ac[$category]["price"]:'';
                                        $saved_ac_remarks = (isset($ac[$category]["remarks"]))?$ac[$category]["remarks"]:'';
                                    endif;
                                    
                                ?>
                                <select id="ac_selection_item_<?php echo $i?>" name="ac_selection_item[]" class="form-control">
                                    <option></option>
                                    <?php foreach($selections as $key => $group):?>
                                    <optgroup label="{{$key}}">
                                        <?php foreach($group as $item):?>
                                            <option value="<?php echo $item["selection_item_id"]?>" data-price="<?php echo $item["unit_price"]?>"  <?php echo ($item["selection_item_id"] == $saved_ac_selection_item)?'selected="selected"':''?>>
                                                <?php 
                                                    $product = App\Products::find($item["selection_item_id"]);
                                                    if ($product){
                                                        echo $product->item;
                                                    }
                                                    else{
                                                        echo $item["selection_item_name"];
                                                    }
                                                    
                                                ?>
                                            </option>
                                        <?php endforeach;?>
                                    </optgroup>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            <td colspan="5"><input type="text" id="ac_remarks_<?php echo $i?>" name="ac_remarks[]" class="form-control" value="<?php echo $saved_ac_remarks;?>" /></td>
                            
                            <td class="price_col">
                                <input  type="number" min="0.01" step="0.01" class="form-control" id="ac_price_<?php echo $i?>"  value="<?php echo $saved_ac_price;?>" />
                                <input type="hidden" class="form-control" id="ac_price_save_<?php echo $i?>" name="ac_price[]" value="<?php echo $saved_ac_price;?>" />
                            </td>
                            
                        </tr>
                        <?php $i++;?>
                        <?php endforeach;?>
                        
                        <tr>
                            <td>
                                <a href="#" id="add_hearse_bttn">Hearse</a>
                            </td>
                            <td>
                                <input type="text" id="hearse_name" name="hearse_name" class="form-control"  value="{{(isset($hearse_name))?$hearse_name:''}}" />
                                <input type="hidden" id="hearse_id" name="hearse_id" class="form-control" value="{{(isset($hearse_id))?$hearse_id:''}}" />
                                <input type="hidden" id="hearse_hours" name="hearse_hours" class="form-control" value="{{(isset($hearse_hours))?$hearse_hours:''}}" />
                            </td>
                            
                            <td colspan="5">
                                <input type="text" id="hearse_remarks" name="hearse_remarks" class="form-control" value="{{(isset($hearse_remarks))?$hearse_remarks:''}}" />
                                <input type="hidden" id="hearse_from" name="hearse_from" value="{{(isset($hearse_from))?$hearse_from:''}}" />
                                <input type="hidden" id="hearse_to" name="hearse_to" value="{{(isset($hearse_to))?$hearse_to:''}}" />
                            </td>
                            
                            <td class="price_col">
                                <input  type="number" min="0.01" step="0.01" class="form-control" id="hearse_price" value="{{(isset($hearse_price))?$hearse_price:''}}" />
                                <input type="hidden" class="form-control" id="hearse_price_save" name="hearse_price" value="{{(isset($hearse_price))?$hearse_price:''}}" />
                            </td>
                        </tr>
                        <?php if (isset($parlours)):?>
                        <?php for( $i = 0; $i < count($parlours); $i++):?>
                        <tr id="parlour_row_<?php echo $i;?>">
                            <td>
                                Parlour
                            </td>
                            <td>
                                <input type="text" id="parlour_name_<?php echo $i;?>" disabled="disabled" class="form-control" value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_name"]))?$parlours[$i]["parlour_name"]:""?>" />
                            </td>
                            
                            <td colspan="5">
                                <input type="text" id="parlour_remarks_<?php echo $i;?>" disabled="disabled" class="form-control" <?php if (!empty($parlours[$i]["parlour_remarks"])):?> value="<?php echo $parlours[$i]["parlour_remarks"];?>" <?php else:?>value="from <?php echo (isset($parlours) && isset($parlours[$i]["parlour_from"]))?$parlours[$i]["parlour_from"]:""?> to <?php echo (isset($parlours) && isset($parlours[$i]))?$parlours[$i]["parlour_to"]:""?>"<?php endif?> />
                            </td>
                            
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01"  disabled="disabled" class="form-control" value="<?php echo (isset($parlours) && isset($parlours[$i]["parlour_total_price"]))?$parlours[$i]["parlour_total_price"]:""?>" />

                                
                            </td>
                        </tr>
                        <?php endfor;?>
                        <?php endif;?> 
                        
                        <tr>
                            <td>
                                CCK - Slab & Stand
                            </td>
                            <td>
                                <input type="text" class="form-control" id="cck_slab_stand" name="cck_slab_stand" value="{{(isset($cck_slab_stand))?$cck_slab_stand:''}}" />
                            </td>
                            
                            <td colspan="5">
                                <input type="text" name="cck_slab_stand_remarks" name="cck_slab_stand_remarks" class="form-control" value="{{(isset($cck_slab_stand_remarks))?$cck_slab_stand_remarks:''}}" />
                            </td>
                            
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="cck_slab_stand_price" name="cck_slab_stand_price" value="{{(isset($cck_slab_stand_price))?$cck_slab_stand_price:''}}" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Charcoal & Lime
                            </td>
                            <td>
                                <input type="text" class="form-control" id="charcoal_lime" name="charcoal_lime" value="{{(isset($charcoal_lime))?$charcoal_lime:''}}" />
                            </td>
                            
                            <td colspan="5">
                                <input type="text" name="charcoal_lime_remarks" name="charcoal_lime_remarks" class="form-control" value="{{(isset($charcoal_lime_remarks))?$charcoal_lime_remarks:''}}" />
                            </td>
                            
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="charcoal_lime_price" name="charcoal_lime_price" value="{{(isset($charcoal_lime_price))?$charcoal_lime_price:''}}" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Obituary Posting in newspapers
                            </td>
                            <td>
                                <select id="obituary" name="obituary" class="form-control">
                                    <option></option>
                                    <option value="ST" <?php echo (isset($obituary) && $obituary == "ST")?'selected="selected"':''?> >ST (Straits Times)</option>
                                    <option value="LHZB" <?php echo (isset($obituary) && $obituary == "ST")?'selected="selected"':''?>>LHZB (Lian He Zao Bao)</option>
                                </select>
                            </td>
                            <td></td>
                            <td>
                                Arranged by: 
                            </td>
                            <td>
                                <select class="form-control" name="obituary_arranged_by[]" data-toggle="select2" multiple class="form-control">
                                    <?php 
                                        foreach ($users as $u): 
                                            if (!empty($obituary_followed_up_by)){
                                                $arrSel = explode(",",$obituary_followed_up_by);
                                            }
                                            else{
                                                $arrSel = array($user->id);
                                            }
                                    ?>
                                        <option value="{{ $u->id }}"
                                                @if (in_array($u->id,$arrSel))
                                                selected="selected"
                                                @endif
                                                >
                                            {{ $u->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                Followed-up by: 
                            </td>
                            <td>
                                <select class="form-control" name="obituary_followed_up_by[]" data-toggle="select2" multiple class="form-control">
                                    <?php 
                                        foreach ($users as $u): 
                                            if (!empty($obituary_followed_up_by)){
                                                $arrSel = explode(",",$obituary_followed_up_by);
                                            }
                                            else{
                                                $arrSel = array($user->id);
                                            }
                                    ?>

                                        <option value="{{ $u->id }}"
                                                @if (in_array($u->id, $arrSel))
                                                selected="selected"
                                                @endif
                                                >
                                            {{ $u->name }}
                                        </option>
                                    <?php endforeach;?>
                                </select>
                                
                            </td>
                            
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="obituary_price" name="obituary_price" value="{{(isset($obituary_price))?$obituary_price:''}}" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Highrise Apartment (3rd Floor Upwards)
                            </td>
                            <td>
                                <input type="text" class="form-control" id="highrise_apartment" name="highrise_apartment" value="{{(isset($highrise_apartment))?$highrise_apartment:''}}" />
                            </td>
                            
                            <td colspan="5">
                                <input type="text" name="highrise_apartment_remarks" name="highrise_apartment_remarks" class="form-control" value="{{(isset($highrise_apartment_remarks))?$highrise_apartment_remarks:''}}" />
                            </td>
                            
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="highrise_apartment_price" name="highrise_apartment_price" value="{{(isset($highrise_apartment_price))?$highrise_apartment_price:''}}" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Collection From
                            </td>
                            <td>
                                <select id="collection_from" name="collection_from" class="form-control">
                                    <option></option>
                                    <option value="Airport" <?php echo (isset($collection_from) && $collection_from == "Airport")?'selected="selected"':''?>>Airport</option>
                                    <option value="Wharf" <?php echo (isset($collection_from) && $collection_from == "Wharf")?'selected="selected"':''?>>Wharf</option>
                                </select>
                            </td>
                            
                            <td colspan="5">
                                <input type="text" name="collection_from_remarks" name="collection_from_remarks" class="form-control" value="{{(isset($collection_from_remarks))?$collection_from_remarks:''}}" />
                            </td>
                            
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="collection_from_price" name="collection_from_price" value="{{(isset($collection_from_price))?$collection_from_price:''}}" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Port Health Permit
                            </td>
                            <td>
                                <input type="text" class="form-control" id="port_health_permit" name="port_health_permit" value="{{(isset($port_health_permit))?$port_health_permit:''}}" />
                            </td>
                            
                            <td colspan="5">
                                <input type="text" name="port_health_permit_remarks" name="port_health_permit_remarks" class="form-control" value="{{(isset($port_health_permit_remarks))?$port_health_permit_remarks:''}}" />
                            </td>
                            
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="port_health_permit_price" name="port_health_permit_price" value="{{(isset($port_health_permit_price))?$port_health_permit_price:''}}" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Disposal of Coffin
                            </td>
                            <td>
                                <input type="text" class="form-control" id="disposal_of_coffin" name="disposal_of_coffin" value="{{(isset($disposal_of_coffin))?$disposal_of_coffin:''}}" />
                            </td>
                            
                            <td colspan="5">
                                <input type="text" name="disposal_of_coffin_remarks" name="disposal_of_coffin_remarks" class="form-control" value="{{(isset($disposal_of_coffin_remarks))?$disposal_of_coffin_remarks:''}}" />
                            </td>
                            
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="disposal_of_coffin_price" name="disposal_of_coffin_price" value="{{(isset($disposal_of_coffin_price))?$disposal_of_coffin_price:''}}" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Coffin Discount 5%
                            </td>
                            <td>
                               
                            </td>
                            <td>
                                
                            </td>
                            <td colspan="4"></td>
                            <td>
                               
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Burial
                            </td>
                            <td>
                                <input type="text" class="form-control" id="burial" name="burial" value="{{(isset($burial))?$burial:''}}" />
                            </td>
                            
                            <td colspan="5">
                                <input type="text" name="burial_remarks" name="burial_remarks" class="form-control" value="{{(isset($burial_remarks))?$burial_remarks:''}}" />
                            </td>
                            
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="burial_price" name="burial_price" value="{{(isset($burial_price))?$burial_price:''}}" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Others
                            </td>
                            <td>
                                <input type="text" class="form-control" id="others" name="others" value="{{(isset($others))?$others:''}}" />
                            </td>
                            
                            <td colspan="5">
                                <input type="text" name="others_remarks" name="others_remarks" class="form-control" value="{{(isset($others_remarks))?$others_remarks:''}}" />
                            </td>
                            
                            <td class="price_col">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="others_price" name="others_price" value="{{(isset($others_price))?$others_price:''}}" />
                            </td>
                        </tr>
     
                    
                    
                    <tr>
                        <td>
                            Columbarium Order
                        </td>
                        <td>
                            <input type="text" id="columbarium_order_number" name="columbarium_order_number" class="form-control" value="{{(isset($columbarium_order_number))?$columbarium_order_number:''}}" />
                            <input type="hidden" id="columbarium_order_id" name="columbarium_order_id" value="{{(isset($columbarium_order_id))?$columbarium_order_id:''}}" />
                        </td>
                        <td><input type="text" id="columbarium_order_remarks" name="columbarium_order_remarks" class="form-control" value="{{(isset($columbarium_order_remarks))?$columbarium_order_remarks:''}}" /></td>
                        <td>Arranged by:</td>
                        <td>    
                            <select class="form-control" name="columbarium_order_arranged_by[]" data-toggle="select2" multiple class="form-control">
                                <?php 
                                    foreach ($users as $u): 
                                        if (!empty($columbarium_order_arranged_by)){
                                            $arrSel = explode(",",$columbarium_order_arranged_by);
                                        }
                                        else{
                                            $arrSel = array($user->id);
                                        }
                                ?>
                                    <option value="{{ $u->id }}"
                                            @if (in_array($u->id,$arrSel))
                                            selected="selected"
                                            @endif
                                            >
                                        {{ $u->name }}
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td>Followed-up by:</td>
                        <td>
                            <select class="form-control" name="columbarium_order_followed_up_by[]" data-toggle="select2" multiple class="form-control">
                                <?php 
                                    foreach ($users as $u): 
                                        if (!empty($columbarium_order_followed_up_by)){
                                            $arrSel = explode(",",$columbarium_order_followed_up_by);
                                        }
                                        else{
                                            $arrSel = array($user->id);
                                        }
                                ?>

                                    <option value="{{ $u->id }}"
                                            @if (in_array($u->id, $arrSel))
                                            selected="selected"
                                            @endif
                                            >
                                        {{ $u->name }}
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="columbarium_price" name="columbarium_price" class="form-control" value="{{(isset($columbarium_price))?$columbarium_price:''}}" />
                        </td>
                    </tr>
                    
                    
                    
                    
                    <tr>
                        <td>
                            Cremation Fee
                        </td>
                        <td>
                            <input type="text" id="cremation_fee" name="cremation_fee" class="form-control" value="{{(isset($cremation_fee))?$cremation_fee:''}}" />
                        </td>
                        
                        <td colspan="5">
                            <input type="text" id="cremation_fee_remarks" name="cremation_fee_remarks" class="form-control" value="{{(isset($cremation_fee_remarks))?$cremation_fee_remarks:''}}" />
                        </td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="cremation_fee_price" name="cremation_fee_price" class="form-control" value="{{(isset($cremation_fee_price))?$cremation_fee_price:''}}" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Night Care service team ( services )
                        </td>
                        <td>
                            <input type="text" id="night_care" name="night_care" class="form-control" value="{{(isset($night_care))?$night_care:''}}" /> 
                        </td>
                        
                        <td colspan="5">
                            <input type="text" id="night_care_remarks" name="night_care_remarks" class="form-control" value="{{(isset($night_care_price))?$night_care_price:''}}" />
                        </td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="night_care_price" name="night_care_price" class="form-control" value="{{(isset($night_care_price))?$night_care_price:''}}" />
                        </td>
                    </tr>
                    
                    
                     <tr>
                        <td>
                            Disposal of coffin
                        </td>
                        <td>
                            <input type="text" id="disposal_coffin" name="disposal_coffin" class="form-control" value="{{(isset($disposal_coffin))?$disposal_coffin:''}}" /> 
                        </td>
                        
                        <td colspan="5">
                            <input type="text" id="disposal_coffin_remarks" name="disposal_coffin_remarks" class="form-control" value="{{(isset($disposal_coffin_price))?$disposal_coffin_price:''}}" />
                        </td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="disposal_coffin_price" name="disposal_coffin_price" class="form-control" value="{{(isset($disposal_coffin_price))?$disposal_coffin_price:''}}" />
                        </td>
                    </tr>
                    
                    
                    
                    
                    
                    <tr>
                        <td>
                            Gem stone
                        </td>
                        <td>
                            <input type="text" id="gemstone_order_number" name="gemstone_order_number" class="form-control" value="{{(isset($gemstone_order_number))?$gemstone_order_number:''}}" /> <!-- autocomplete -->
                            <input type="hidden" id="gemstone_order_id" name="gemstone_order_id" value="{{(isset($gemstone_order_id))?$gemstone_order_id:''}}" />
                        </td>
                        
                        <td>
                            <input type="text" id="gemstone_order_remarks" name="gemstone_order_remarks" class="form-control" value="{{(isset($gemstone_order_remarks))?$gemstone_order_remarks:''}}" />
                        </td>
                        <td>Arranged by:</td>
                        <td>    
                            <select class="form-control" name="gemstone_order_arranged_by[]" data-toggle="select2" multiple class="form-control">
                                <?php 
                                    foreach ($users as $u): 
                                        if (!empty($gemstone_order_arranged_by)){
                                            $arrSel = explode(",",$gemstone_order_arranged_by);
                                        }
                                        else{
                                            $arrSel = array($user->id);
                                        }
                                ?>
                                    <option value="{{ $u->id }}"
                                            @if (in_array($u->id,$arrSel))
                                            selected="selected"
                                            @endif
                                            >
                                        {{ $u->name }}
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td>Followed-up by:</td>
                        <td>
                            <select class="form-control" name="gemstone_order_followed_up_by[]" data-toggle="select2" multiple class="form-control">
                                <?php 
                                    foreach ($users as $u): 
                                        if (!empty($gemstone_order_followed_up_by)){
                                            $arrSel = explode(",",$gemstone_order_followed_up_by);
                                        }
                                        else{
                                            $arrSel = array($user->id);
                                        }
                                ?>

                                    <option value="{{ $u->id }}"
                                            @if (in_array($u->id, $arrSel))
                                            selected="selected"
                                            @endif
                                            >
                                        {{ $u->name }}
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td class="price_col">
                            <input type="number" min="0.01" step="0.01" id="gemstone_order_price" name="gemstone_order_price" class="form-control" value="{{(isset($gemstone_order_price))?$gemstone_order_price:''}}" />
                        </td>
                    </tr>
                    
                    
                    <tr>
                        <td>
                            FA Package
                        </td>
                        <td>
                            <input type="text" disabled="disabled" class="form-control"  value="{{$selected_package->name}}" />
                        </td>
                        
                        <td colspan="5">
                            <input type="text" disabled="disabled" class="form-control" value="" />
                        </td>
                        <td class="price_col">
                            <div></div><input type="number" min="0.01" step="0.01" class="form-control" disabled="disabled" value="{{$object->package_total}}" />
                        </td>
                    </tr>
                    
                    
                    
                    
                    
                    
                    
                    
                    <?php // MORE PACKS ----------------------------------------------------- ?>
                    <?php if (isset($mp)):?>
                    <?php $inc = 0;?>
                    <?php foreach($mp as $package => $other_item):?>
                    <tr>
                        <td>
                            <select id="more_package_name_{{$inc}}" name="more_package_name[]" class="form-control">
                                <?php $sel = 1;?>
                                <?php foreach($sales_items as $list_package => $selections):?>
                                    <option value="{{$list_package}}|<?php echo $sel++;?>" <?php echo ($list_package == $package)?'selected="selected"':''?>><?php echo $list_package?></option>    
                                <?php endforeach;?>
                            </select>
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
                            
                            <select id="more_package_selection_item_<?php echo $sel;?>_{{$inc}}" name="more_package_selection_<?php echo $sel;?>_item[]" class="form-control" <?php echo ($list_package == $package)?'':'style="display:none"'?>>
                                <option></option>
                                <?php foreach($selections as $key => $group):?>
                                <optgroup label="{{$key}}">
                                    <?php foreach($group as $item):?>
                                        <option value="<?php echo $item["selection_item_id"]?>" data-price="<?php echo $item["unit_price"]?>"  <?php echo ($list_package == $package && $item["selection_item_id"] == $saved_mp_selection_item)?'selected="selected"':''?>>
                                            <?php 
                                                $product = App\Products::find($item["selection_item_id"]);
                                                if ($product){
                                                    echo $product->item;
                                                }
                                                else{
                                                    echo $item["selection_item_name"];
                                                }

                                            ?>
                                        </option>
                                    <?php endforeach;?>
                                </optgroup>
                                <?php endforeach;?>
                            </select>
                            <?php $sel++; ?>
                            <?php endforeach;?>
                        </td>
                        <td colspan="5"><input type="text" class="form-control" id="more_package_remarks_{{$inc}}" name="more_package_remarks[]" value="<?php echo $saved_mp_remarks;?>" /></td>
                        <td class="price_col">
                            <div></div><input type="number" min="0.01" step="0.01" class="form-control" id="more_package_price_{{$inc}}" value="<?php echo $saved_mp_price;?>" />
                            <input type="hidden" class="form-control" id="more_package_price_save_{{$inc}}" name="more_package_price[]" value="<?php echo $saved_mp_price;?>" />
                        </td>
                    </tr>
                    <?php $inc++;?>
                    <?php endforeach;?>
                    <?php endif;?>
                    
                    
                    
                    
                    
                    
                    <tr id="draft_add_package" style="display:none">
                        <td>
                            <select id="more_package_name_0" name="more_package_name[]" class="form-control">
                                <?php $sel = 1;?>
                                <?php foreach($sales_items as $package => $selections):?>
                                    <option value="{{$package}}|<?php echo $sel++;?>">{{$package}}</option>    
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td>
                            <?php $sel = 1;?>
                            <?php foreach($sales_items as $package => $selections):?>
                                   
                            <select id="more_package_selection_item_{{$sel}}_0" name="more_package_selection_{{$sel}}_item[]" class="form-control" <?php echo ( $sel > 1 )?'style="display:none"':''?>>
                                <option></option>
                                <?php foreach($selections as $key => $group):?>
                                <optgroup label="{{$key}}">
                                    <?php foreach($group as $item):?>
                                        <option value="<?php echo $item["selection_item_id"]?>" data-price="<?php echo $item["unit_price"]?>" >
                                            <?php 
                                                $product = App\Products::find($item["selection_item_id"]);
                                                if ($product){
                                                    echo $product->item;
                                                }
                                                else{
                                                    echo $item["selection_item_name"];
                                                }

                                            ?>
                                        </option>
                                    <?php endforeach;?>
                                </optgroup>
                                <?php endforeach;?>
                            </select>
                            <?php $sel++?>
                            <?php endforeach;?>
                        </td>
                        <td colspan="5"><input type="text" class="form-control" id="more_package_remarks_0" name="more_package_remarks[]" value="" /></td>
                        <td class="price_col">
                            <div></div><input type="number" min="0.01" step="0.01" class="form-control" id="more_package_price_0"  value="" />
                            <input type="hidden" class="form-control" id="more_package_price_save_0" name="more_package_price[]" value="" />
                        </td>
                    </tr>
                    
                    
                    <tr>
                        <td  colspan="8" style="text-align:left">
                            <a href="#" id="add_package">Click to add</a>
                        </td>
  
                    </tr>
                    
                    <tr>
                        <td>
                            Miscellaneous 
                        </td>
                        <td>
                            <select id="miscellaneous_selection" name="miscellaneous" class="form-control">
                                <option></option>
                                @if ($discounts)
                                    @foreach($discounts as $discount)
                                    <option value="{{$discount}}">Discount {{$discount}}%</option>
                                    @endforeach
                                @endif
                                <option value="special_discount" <?php echo (isset($miscellaneous) && $miscellaneous == "special_discount")?'selected="selected"':''?>>Special Discount</option>
                            </select>
                            
                            
                            <input type="hidden" id="miscellaneous_amount" name="miscellaneous_amount" value="{{$object->miscellaneous_amount}}" />
                            <input type="hidden" id="miscellaneous_approving_supervisor" name="miscellaneous_approving_supervisor" value="{{$object->miscellaneous_approving_supervisor}}" />
                            <input type="hidden" id="miscellaneous_approval_code" name="miscellaneous_approval_code" value="{{$object->miscellaneous_approval_code}}" />
                        </td>
                        
                        <td  colspan="5"></td>
                        <td>
                            <span id="total"></span>
                            <input type="hidden" id="total_input" name="total_step_3" />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            
            
            
        </div>
        
        
        
        
        
        
        
    
        <div id="number"></div>
        
        <div style="text-align: center;border-top: 1px solid;padding-top: 22px;margin-top: 63px;">

            <table style="width:88%; margin-left:6%; margin-top: 40px">
                <tr>
                    <td colspan="5" style="text-align: right;">
                        <table style="float:right">
                            <tr>
                                <td>Sub-Total&nbsp;</td>
                                <td><input type="text" class="form-control" id="sub_total" name="sub_total" value="{{$object->total_step_3}}" /></td>
                            </tr>
                            @if ($object->miscellaneous == "discount")
                            <tr>
                                <td><span style="color: #CCC">Discount&nbsp;</span></td>
                                <td><input type="text" class="form-control" id="discount" name="discount" value="{{$object->miscellaneous_amount}}" /></td>
                            </tr>
                            @endif
                            @if ($object->miscellaneous == "special_discount")
                            <tr>
                                <td><span style="color: #CCC">Special discount(approved by: {{$object->miscellaneous_approving_supervisor}})&nbsp;</span></td>
                                <td><input type="text" class="form-control" id="special_discount" name="special_discount" value="{{$object->miscellaneous_amount}}" /></td>
                            </tr>
                            @endif
                            <tr>
                                <td>Total&nbsp;</td>
                                <td><input type="text" class="form-control" id="final_total" name="final_total" value="{{$object->final_total}}" /></td>
                            </tr>
                            <tr>
                                <td>GST 7%&nbsp;</td>
                                <td><input type="text" class="form-control" id="gst_value" name="gst_value" value="{{$object->gst_value}}" /></td>
                            </tr>
                            <tr>
                                <td>Total with GST&nbsp;</td>
                                <td><input type="text" class="form-control" id="total_with_gst" name="total_with_gst" value="{{$object->total_with_gst}}" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="height: 100px">&nbsp;</td>
                </tr>
                <tr>
                    <td id="" colspan="5" style="text-align: left;">
                        <table style="width: 70%">
                            <tr>
                                <td style="text-align: left;">
                                    Coffin Lifting on Funeral Day
                                </td>
                                <td style="text-align: left;">
                                    <select class="form-control" name="coffin_lifting">
                                        <option></option>
                                        <option value="Yes" <?php echo ($object->coffin_lifting == "Yes")?'selected="selected"':'';?>>Yes</option>
                                        <option value="No" <?php echo ($object->coffin_lifting == "No")?'selected="selected"':'';?>>No</option>
                                    </select>
                                </td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">
                                    SCC Care Monk Chanting
                                </td>
                                <td style="text-align: left;">
                                    <select class="form-control" name="monk_chanting">
                                        <option></option>
                                        <option value="Yes" <?php echo ($object->monk_chanting == "Yes")?'selected="selected"':'';?>>Yes</option>
                                        <option value="No" <?php echo ($object->monk_chanting == "No")?'selected="selected"':'';?>>No</option>
                                    </select>
                                </td>
                                <td style="text-align: left;">
                                    <input type="text" class="form-control"  name="monk_chanting_remarks" value="{{$object->monk_chanting_remarks}}" />
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
                                    <textarea class="form-control" name="final_remarks" cols="2"> {{$object->final_remarks}}</textarea>
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
                    <td>
                        <table style="width:100%">
                            <tr>

                                <td>
                                    Accepted and agreed
                                </td>
                                <td>
                                    Accepted and agreed
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center; width: 250px;">
                                    <div style="margin-left: 3px;" >
                                        <?php $signatures = json_decode($object->signatures, true);?>
                                        <img src="<?php echo $signatures[1];?>" style="width:100px; border: 1px solid;height:51px"/>
                                    </div>

                                </td>
                                <td style="text-align: center; width: 250px;">
                                    <div style="margin-left: 3px;">
                                        <img src="<?php echo $signatures[2];?>" style="width:100px; border: 1px solid;height:51px"/>
                                    </div>

                                </td>
                            </tr>

                            <tr>
                                <td style="text-align:center">
                                    Date: <?php 
                                        if ($object->signature_date && $object->signature_date != "0000-00-00"):
                                            echo date("d/m/Y", strtotime($object->signature_date));
                                        endif;
                                    ?>
                                </td>
                                <td style="text-align:center">
                                    Date: <?php 
                                        if ($object->signature_date && $object->signature_date != "0000-00-00"):
                                            echo date("d/m/Y", strtotime($object->signature_date));
                                        endif;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="height: 100px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><input type="button" value="SAVE" id="save_bttn" style="width:100px" /></td>
                                <td><input type="button" value="SAVE & Print" id="save_print_bttn" style="width:100px" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="height: 100px">&nbsp;</td>
                </tr>
            </table>
        </div>
    </div>
    
</form>
   
<div class="modal fade" id="save_msg" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Status</h4>
            </div>

            <div class="modal-body">
                <div class="form-group" id="message_container">
                    
                </div>
            </div>
            <div class="modal-footer">
                
            </div>

        </div>
    </div>
</div>
@endif



<div class="modal fade" id="add_hearse" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Hearse</h4>
            </div>

            <div class="modal-body">

            </div>
            <div class="modal-footer">
                
            </div>

        </div>
    </div>
</div>


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

<div class="modal fade" id="special_discount_popup" tabindex="-1" role="dialog" style="display:none">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Special Discount</h4>
            </div>

            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <table class="discount_popup_table">
                        <tr>
                            <td><label class="control-label" for="inputWarning1">Amount</label></td>
                            <td><input type="text" id="discount_amount" name="discount_amount" value="" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td><label class="control-label" for="inputWarning1">Approving supervisor</label></td>
                            <td><input type="text" id="approving_supervisor" name="approving_supervisor" value="{{$user->getSupervisor()}}" disabled="disabled" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td><label class="control-label" for="inputWarning1">Approval code</label></td>
                            <td><input type="text" id="approval_code" name="approval_code" value="{{$object->approval_code}}" class="form-control" /></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submit_bttn">SUBMIT</button>
            </div>

        </div>
    </div>
</div>