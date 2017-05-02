<style>
    input.form-control{
        width: 170px;
    }
</style>
<form action="{{ URL::to('/FArepatriation/save') }}"  id="info_frm" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    
    <input type="hidden" name="id" id="id" value="{{ $object->id }}" />
    <input type="hidden" name="step" id="step" value="1" />
    <input type="hidden" name="changes_made" id="changes_made" value="" />
    <div id="fa_form" class="needs_exit_warning">
        
        
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
                        <tr>
                        <td class="field_container">Title</td>
                            <td class="input_container">
                                <select name="deceased_title" style="width: 170px;" class="form-control">
									<option value=""></option>
                                    <option value="Mr"   
                                            @if ($object->deceased_title == "Mr")
                                            selected="true"
                                            @endif
                                            >Mr</option> 
									<option value="MDM"
                                            @if ($object->deceased_title == "MDM")
                                            selected="true"
                                            @endif
                                            >Mdm</option>
									<option value="Miss"
                                            @if ($object->deceased_title == "Miss")
                                            selected="true"
                                            @endif
                                            >Miss</option>
									<option value="DR"
                                            @if ($object->deceased_title == "DR")
                                            selected="true"
                                            @endif
                                            >Dr</option>
                                </select>
                            </td>
						</tr>
						<tr><td class="field_container">Deceased Name</td><td colspan="5" class="input_container"><input type="text" name="deceased_name"  id="deceased_name" class="form-control" value="{{$object->deceased_name}}"  /><input type="hidden" name="shifting_id" id="shifting_id" value="{{ $object->id }}" /></tr>
                        <tr><td class="field_container">Religion</td>
                            <td class="input_container">
                                <select name="religion" style="width: 170px;" class="form-control">
                                    <option></option>
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
                                    <option></option>
                                    <option value="male" <?php echo ($object->sex == "male")?'selected="true"':'';?>>Male</option>
                                    <option value="female" <?php echo ($object->sex == "female")?'selected="true"':'';?>>Female</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Race</td>
                            <td class="input_container">
                                <select name="race" style="width: 170px;" class="form-control">
                                    <option></option>
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
            
            
            
            <div class="fa_section">
                <div class="form_title">Point of Contact</div>
                <table class="form_content">
                    <tbody>
                        <tr><td colspan="2" class="field_container" style="text-align: center">1st Contact Person</td><td colspan="2" class="field_container" style="text-align: center">2st Contact Person</td></tr>
                         <tr>
                            <td class="field_container">Title</td>
                            <td class="input_container">
                                <select name="first_cp_title" style="width: 170px;" class="form-control">
								<option value=""></option>
                                    <option value="Mr"   
                                            @if ($object->first_cp_title == "Mr")
                                            selected="true"
                                            @endif
                                            >Mr</option> 
									<option value="MDM"
                                            @if ($object->first_cp_title == "MDM")
                                            selected="true"
                                            @endif
                                            >Mdm</option>
									<option value="Miss"
                                            @if ($object->first_cp_title == "Miss")
                                            selected="true"
                                            @endif
                                            >Miss</option>
									<option value="DR"
                                            @if ($object->first_cp_title == "DR")
                                            selected="true"
                                            @endif
                                            >Dr</option>
                                </select>
                            </td>
                            <td class="field_container">Title</td>
                            <td class="input_container">
                                <select name="second_cp_title" style="width: 170px;" class="form-control">
								<option value=""></option>
                                    <option value="Mr"   
                                            @if ($object->second_cp_title == "Mr")
                                            selected="true"
                                            @endif
                                            >Mr</option> 
									<option value="MDM"
                                            @if ($object->second_cp_title == "MDM")
                                            selected="true"
                                            @endif
                                            >Mdm</option>
									<option value="Miss"
                                            @if ($object->second_cp_title == "Miss")
                                            selected="true"
                                            @endif
                                            >Miss</option>
									<option value="DR"
                                            @if ($object->second_cp_title == "DR")
                                            selected="true"
                                            @endif
                                            >Dr</option>
                                </select>
                            </td>
                        </tr>
						<tr><td class="field_container">Name</td><td class="input_container" ><input type="text"  class="form-control" id="first_cp_name" name="first_cp_name" value="{{$object->first_cp_name}}" /></td><td class="field_container">Name</td><td class="input_container"><input type="text" class="form-control" id="second_cp_name" name="second_cp_name" value="{{$object->second_cp_name}}" /></td></tr>
						<tr>
                            <td class="field_container">Religion</td>
                            <td class="input_container">
                                <select name="first_cp_religion" style="width: 170px;" class="form-control">
								 <option value=""></option>
                                   @foreach($religionOptions as $religionOp)
                                    <option value="{{$religionOp->name}}" 
                                            @if ($religionOp->name == $object->first_cp_religion)
                                            selected="true"
                                            @endif
                                            >{{$religionOp->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="field_container">Religion</td>
                            <td class="input_container">
                                <select name="second_cp_religion" style="width: 170px;" class="form-control">
									 <option value=""></option>
                                    @foreach($religionOptions as $religionOp)
                                    <option value="{{$religionOp->name}}" 
                                            @if ($religionOp->name == $object->second_cp_religion)
                                            selected="true"
                                            @endif
                                            >{{$religionOp->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
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
                                    <option></option>
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
                                    <option></option>
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
    
            
            <div class="fa_section">
                <div class="form_title">Flight Details / Consignee</div>
                <table class="form_content">
                    <tbody>
                        <tr>
                            <td class="field_container">Packing Date/Time</td>
                            <td class="input_container">
                                <input type="text" name="packing" maxlength="255"  id="packing" class="form-control" value="{{$object->packing}}"  />
                            </td>
                            <td class="field_container">Pick-up Date/Time</td>
                            <td class="input_container">
                                <input type="text" name="pick_up" maxlength="255" id="pick_up" class="form-control" value="{{$object->pick_up}}"  />
                            </td>
                            <td class="field_container">Date of Export</td>
                            <td class="input_container">
                                <input type="text" name="export_date" maxlength="50" id="export_date" class="form-control" value="{{$object->export_date}}"  />
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Airway Bill No</td>
                            <td class="input_container">
                                <input type="text" name="airway_bill" maxlength="255" id="airway_bill" class="form-control" value="{{$object->airway_bill}}"  />
                            </td>
                            <td class="field_container">From</td>
                            <td class="input_container">
                                <input type="text" name="airway_from" maxlength="255" id="airway_from" class="form-control" value="{{$object->airway_from}}"  />
                            </td>
                            <td class="field_container">To</td>
                            <td class="input_container">
                                <input type="text" name="airway_to" maxlength="255" id="airway_to" class="form-control" value="{{$object->airway_to}}"  />
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">E.T.D.</td>
                            <td class="input_container">
                                <input type="text" name="etd_1" maxlength="255" id="etd_1" class="form-control" value="{{$object->etd_1}}"  />
                            </td>
                            <td class="field_container">Date</td>
                            <td class="input_container">
                                <input type="text" name="etd_date_1" maxlength="50" id="etd_date_1" class="form-control" value="{{$object->etd_date_1}}"  />
                            </td>
                            <td class="field_container">Flight No</td>
                            <td class="input_container">
                                <input type="text" name="etd_flight_1" maxlength="50" id="etd_flight_1" class="form-control" value="{{$object->etd_flight_1}}"  />
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">E.T.A.</td>
                            <td class="input_container">
                                <input type="text" name="eta_1" maxlength="255" id="eta_1" class="form-control" value="{{$object->eta_1}}"  />
                            </td>
                            <td class="field_container">Date</td>
                            <td class="input_container">
                                <input type="text" name="eta_date_1" maxlength="50" id="eta_date_1" class="form-control" value="{{$object->eta_date_1}}"  />
                            </td>
                            <td colspan="2" class="field_container"></td>
                        </tr>
                        <tr>
                            <td class="field_container">E.T.D.</td>
                            <td class="input_container">
                                <input type="text" name="etd_2" maxlength="255" id="etd_2" class="form-control" value="{{$object->etd_2}}"  />
                            </td>
                            <td class="field_container">Date</td>
                            <td class="input_container">
                                <input type="text" name="etd_date_2" maxlength="50" id="etd_date_2" class="form-control" value="{{$object->etd_date_2}}"  />
                            </td>
                            <td class="field_container">Flight No</td>
                            <td class="input_container">
                                <input type="text" name="etd_flight_2" maxlength="50" id="etd_flight_2" class="form-control" value="{{$object->etd_flight_2}}"  />
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">E.T.A.</td>
                            <td class="input_container">
                                <input type="text" name="eta_2" id="eta_2" maxlength="255" class="form-control" value="{{$object->eta_2}}"  />
                            </td>
                            <td class="field_container">Date</td>
                            <td class="input_container">
                                <input type="text" name="eta_date_2"  maxlength="50" id="eta_date_2" class="form-control" value="{{$object->eta_date_2}}"  />
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
                                <textarea class="form-control" id="consignee" name="consignee">{{$object->consignee}}</textarea>
                            </td>
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