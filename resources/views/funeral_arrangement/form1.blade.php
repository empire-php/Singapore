<form action="{{ URL::to('/fa/saveForm') }}" id="info_frm" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="hidden" name="generated_code" value="{{ $object->generated_code }}"/>
    <input type="hidden" name="faid" id="faid" value="{{ $object->id }}"/>
    <input type="hidden" name="step" id="step" value="1"/>
    <input type="hidden" name="changes_made" id="changes_made" value=""/>
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
                    <tr>
                        <td class="field_container">Title</td>
                        <td class="input_container">
                            <select id="deceased_title" name="deceased_title" style="width: 170px; padding-left: 8px;"
                                    class="form-control">
                                <option value=""></option>
                                <option value="Mr"
                                        @if ($object->deceased_title == "Mr")
                                        selected="true"
                                        @endif
                                >Mr
                                </option>
                                <option value="Mdm"
                                        @if ($object->deceased_title == "Mdm")
                                        selected="true"
                                        @endif
                                >Mdm
                                </option>
                                <option value="Miss"
                                        @if ($object->deceased_title == "Miss")
                                        selected="true"
                                        @endif
                                >Miss
                                </option>
                                <option value="Dr"
                                        @if ($object->deceased_title == "Dr")
                                        selected="true"
                                        @endif
                                >Dr
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                    <td class="field_container">Deceased Name</td>
                    <td colspan="5" class="input_container">
                        <input type="text" name="deceased_name" id="deceased_name" class="form-control"
                               value="{{$object->deceased_name}}"/>
                        <input type="hidden" name="shifting_id" id="shifting_id" value="{{ $object->id }}"/>
                        </tr>
                        <tr>
                            <td class="field_container">Religion</td>
                            <td class="input_container">
                                <select id="deceased_religion" name="religion" style="width: 170px; padding-left: 8px;"
                                        class="form-control">
                                    <option></option>
                                    {{--<option value="Buddhism"--}}
                                    {{--@if ($object->deceased_title == "Buddhism")--}}
                                    {{--selected="true"--}}
                                    {{--@endif--}}
                                    {{-->Buddhism</option>--}}
                                    @foreach($religionOptions as $religionOp)
                                        <option value="{{$religionOp->id}}"

                                                @if ($religionOp->id == $object->religion)
                                                selected="true"
                                                @endif
                                        >{{$religionOp->name}}
                                        </option>

                                    @endforeach
                                </select>
                            </td>
                            <td class="field_container">Church</td>
                            <td colspan="3" class="input_container"><input type="text" name="church"
                                                                           class="form-control" id="church"
                                                                           value="{{$object->church}}"/></td>
                        </tr>
                        <tr>
                            <td class="field_container">Sex</td>
                            <td colspan="5" class="input_container">
                                <select name="sex" style="width: 170px;" class="form-control">
                                    <option value=""></option>
                                    <option value="male" <?php  echo ($object->sex == "male") ? 'selected="true"' : '';?>>
                                        Male
                                    </option>
                                    <option value="female" <?php  echo ($object->sex == "female") ? 'selected="true"' : '';?>>
                                        Female
                                    </option>
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
                                <input type="text" id="dialect" name="dialect" class="form-control"
                                       value="{{$object->dialect}}"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="field_container">Date of Birth</td>
                            <td class="input_container"><input type="text" id="birthdate" name="birthdate"
                                                               class="datepicker_fa form-control"
                                                               value="{{$object->birthdate}}"/></td>
                            <td class="field_container">Date of Death</td>
                            <td class="input_container"><input type="text" id="deathdate" name="deathdate"
                                                               class="datepicker_fa form-control"
                                                               value="{{$object->deathdate}}"/></td>
                            <td id="age_field_container" class="field_container">Age</td>
                            <td id="age_input_container" class="input_container"><input type="text" id="age"
                                                                                        class="form-control" name="age"
                                                                                        value="{{$object->age}}"/></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align:center;padding-left: 40%; padding-top: 23px;"><input
                                        type="file" name='files'/></td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div id="point_contact">
                <div class="form_title">Point of Contact</div>
                <table class="form_content">
                    <tbody>
                    <tr>
                        <td colspan="2" class="field_container" style="text-align: left; font-weight:bold;">1st Contact
                            Person
                        </td>
                        <td colspan="2" class="field_container" style="text-align: left;font-weight:bold;">2nd Contact
                            Person
                        </td>
                    </tr>
                    <tr>
                        <td class="field_container">Title</td>
                        <td class="input_container">
                            <select id="first_cp_title" name="first_cp_title" style="width: 170px;padding-left: 8px;"
                                    class="form-control">
                                <option value=""></option>
                                <option value="Mr"
                                        @if ($object->first_cp_title == "Mr")
                                        selected="true"
                                        @endif
                                >Mr
                                </option>
                                <option value="Mdm"
                                        @if ($object->first_cp_title == "Mdm")
                                        selected="true"
                                        @endif
                                >Mdm
                                </option>
                                <option value="Miss"
                                        @if ($object->first_cp_title == "Miss")
                                        selected="true"
                                        @endif
                                >Miss
                                </option>
                                <option value="Dr"
                                        @if ($object->first_cp_title == "Dr")
                                        selected="true"
                                        @endif
                                >Dr
                                </option>
                            </select>
                        </td>
                        <td class="field_container">Title</td>
                        <td class="input_container">
                            <select id="second_cp_title" name="second_cp_title"
                                    style="width: 170px;padding-left: 8px;" class="form-control">
                                <option value=""></option>
                                <option value="Mr"
                                        @if ($object->second_cp_title == "Mr")
                                        selected="true"
                                        @endif
                                >Mr
                                </option>
                                <option value="Mdm"
                                        @if ($object->second_cp_title == "Mdm")
                                        selected="true"
                                        @endif
                                >Mdm
                                </option>
                                <option value="Miss"
                                        @if ($object->second_cp_title == "Miss")
                                        selected="true"
                                        @endif
                                >Miss
                                </option>
                                <option value="DR"
                                        @if ($object->second_cp_title == "Dr")
                                        selected="true"
                                        @endif
                                >Dr
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="field_container">Name</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="first_cp_name" name="first_cp_name"
                                   value="{{$object->first_cp_name}}"/></td>
                        <td class="field_container">Name</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="second_cp_name" name="second_cp_name"
                                   value="{{$object->second_cp_name}}"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="field_container">Religion</td>
                        <td class="input_container">
                            <select id="first_cp_religion" name="first_cp_religion"
                                    style="width: 170px;padding-left: 8px;" class="form-control">
                                <option value=""></option>
                                @foreach($religionOptions as $religionOp)
                                    <option value="{{$religionOp->id}}"
                                            @if ($religionOp->name == $object->first_cp_religion)
                                            selected="true"
                                            @endif
                                    >{{$religionOp->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="field_container">Religion</td>
                        <td class="input_container">
                            <select id="second_cp_religion" name="second_cp_religion"
                                    style="width: 170px;padding-left: 8px;" class="form-control">
                                <option value=""></option>
                                @foreach($religionOptions as $religionOp)
                                    <option value="{{$religionOp->id}}"
                                            @if ($religionOp->name == $object->second_cp_religion)
                                            selected="true"
                                            @endif
                                    >{{$religionOp->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="field_container">
                            NRIC No
                        </td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="first_cp_nric" name="first_cp_nric"
                                   value="{{$object->first_cp_nric}}"/>
                        </td>
                        <td class="field_container">
                            NRIC No
                        </td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="second_cp_nric" name="second_cp_nric"
                                   value="{{$object->second_cp_nric}}"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="field_container">Email address
                        </td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="first_cp_email" name="first_cp_email"
                                   value="{{$object->first_cp_email}}"/>
                        </td>
                        <td class="field_container">Email address</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="second_cp_email" name="second_cp_email"
                                   value="{{$object->second_cp_email}}"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="field_container">Postal Code</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="first_cp_postal_code"
                                   name="first_cp_postal_code" value="{{$object->first_cp_postal_code}}"/>
                        </td>
                        <td class="field_container">Postal Code</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="second_cp_postal_code"
                                   name="second_cp_postal_code" value="{{$object->second_cp_postal_code}}"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="field_container">Address</td>
                        <td class="input_container">
                            <textarea rows="3" class="form-control" id="first_cp_address" name="first_cp_address"
                                      value="{{$object->first_cp_address}}"></textarea>
                        </td>
                        <td class="field_container">Address</td>
                        <td class="input_container">
                            <textarea rows="3" class="form-control" id="second_cp_address" name="second_cp_address"
                                      value="{{$object->second_cp_address}}"></textarea></td>
                    </tr>
                    <tr>
                        <td class="field_container">Address-Unit number</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="first_cp_address-un" name="first_cp_address-un"
                                   value="{{$object->first_cp_address_nr}}"/>
                        </td>
                        <td class="field_container">Address-Unit number</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="second_cp_address-un"
                                   name="second_cp_address-un" value="{{$object->second_cp_address_nr}}"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="field_container">Home Number</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="first_cp_home_nr" name="first_cp_home_nr"
                                   value="{{$object->first_cp_home_nr}}"/>
                        </td>
                        <td class="field_container">Home Number</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="second_cp_home_nr" name="second_cp_home_nr"
                                   value="{{$object->second_cp_home_nr}}"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="field_container">Mobile Number</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="first_cp_mobile_nr" name="first_cp_mobile_nr"
                                   value="{{$object->first_cp_mobile_nr}}"/>
                        </td>
                        <td class="field_container">Mobile Number</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="second_cp_mobile_nr" name="second_cp_mobile_nr"
                                   value="{{$object->second_cp_mobile_nr}}"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="field_container">Office Number</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="first_cp_office_nr" name="first_cp_fax_nr"
                                   value="{{$object->first_cp_fax_nr}}"/>
                        </td>
                        <td class="field_container">Office Number</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="second_cp_office_nr" name="second_cp_office_nr"
                                   value="{{$object->second_cp_office_nr}}"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="field_container">Fax Number</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="first_cp_fax_nr" name="first_cp_fax_nr"
                                   value="{{$object->first_cp_fax_nr}}"/>
                        </td>
                        <td class="field_container">Fax Number</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="second_cp_fax_nr" name="second_cp_fax_nr"
                                   value="{{$object->second_cp_fax_nr}}"/>
                        </td>
                    </tr>
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


            <div id="funeral_day">
                <div class="form_title">Funeral Day</div>
                <table class="form_content">
                    <tbody>
                    <tr>
                        <td class="field_container">Cortege in date</td>
                        <td class="input_container"><input type="text" id="cortege_date" name="cortege_date"
                                                           class="datepicker_fa form-control"
                                                           value="{{$object->cortege_date}}"/></td>
                        <td class="field_container">Day</td>
                        <td class="input_container"><input type="text" class="form-control" id="cortege_date_day"
                                                           name="cortege_date_day"
                                                           value="{{$object->cortege_date_day}}"/></td>
                        <td class="field_container">Time</td>
                        <td class="input_container"><input type="text" class="form-control" id="cortege_date_time"
                                                           name="cortege_date_time"
                                                           value="{{$object->cortege_date_time}}"/>
                    </tr>
                    <tr>
                        <td class="field_container">Funeral Date</td>
                        <td class="input_container"><input type="text" id="funeral_date" name="funeral_date"
                                                           class="datepicker_fa form-control"
                                                           value="{{$object->funeral_date}}"/></td>
                        <td class="field_container">Day</td>
                        <td class="input_container"><input type="text" class="form-control" id="funeral_date_day"
                                                           name="funeral_date_day"
                                                           value="{{$object->funeral_date_day}}"/></td>
                        <td class="field_container">Time</td>
                        <td class="input_container"><input type="text" class="form-control" id="funeral_date_time"
                                                           name="funeral_date_time"
                                                           value="{{$object->funeral_date_time}}"/>
                    </tr>
                    <tr>
                        <td class="field_container">Service at</td>
                        <td class="input_container"><input type="text" class="form-control" id="service_date"
                                                           name="service_date" value="{{$object->service_date}}"/></td>
                        <td class="field_container" colspan="2"> &nbsp;
                        <td class="field_container">Time</td>
                        <td class="input_container"><input type="text" class="form-control" id="service_date_time"
                                                           name="service_date_time"
                                                           value="{{$object->service_date_time}}"/></td>
                    </tr>
                    <tr>
                        <td class="field_container">For (CCK / MC / TTA / KMS)</td>
                        <td class="input_container">
                            <select name="for_op" id="for_op" style="width: 170px;" class="form-control">
                                <option></option>
                                <option value="CCK" <?php echo ($object->for_op == "CCK") ? 'selected="true"' : '';?>>
                                    CCK
                                </option>
                                <option value="MC" <?php echo ($object->or_op == "MC") ? 'selected="true"' : '';?>>MC
                                </option>
                                <option value="RRA" <?php echo ($object->for_op == "RRA") ? 'selected="true"' : '';?>>
                                    RRA
                                </option>
                                <option value="KMS" <?php echo ($object->for_op == "KMS") ? 'selected="true"' : '';?>>
                                    KMS
                                </option>
                            </select>
                        </td>
                        <td class="field_container">Hall</td>
                        <td class="input_container"><input type="text" id="hall" name="hall" value="{{$object->hall}}"
                                                           class="form-control"/>
                        <td class="field_container">Time</td>
                        <td class="input_container"><input type="text" class="form-control" id="hall_time"
                                                           name="hall_time" value="{{$object->hall_time}}"/>
                    </tr>
                    <tr>
                        <td class="field_container">Confirmed & checked by:</td>
                        <td colspan="5">
                            <div style="width: 300px">
                                <select class="form-control" name="users_ids" data-toggle="select2" multiple
                                        class="form-control">
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
                        </td>
                    </tr>
                    <tr>
                        <td class="field_container" colspan="6"><a
                                    href="https://eservices.nea.gov.sg/atad/JSP/ilsc/security/start.jsp"
                                    target="_blank">[Click here for NEA website]</a></td>
                    </tr>
                    <tr>
                        <td class="field_container" colspan="3">&nbsp;</td>
                        <td class="field_container" colspan="3"><a
                                    href="<?php echo App::make('url')->to('/');?>/fa/genpdf/embalming/{{$object->id}}"
                                    target="_blank">Click to generate Embalming Declaration form</a></td>
                    </tr>
                    <tr>
                        <td class="field_container" colspan="3"><a
                                    href="<?php echo App::make('url')->to('/');?>/fa/genpdf/loa/{{$object->id}}"
                                    target="_blank">Click to generate LOA form</a></td>
                        <td class="field_container" colspan="3"><a
                                    href="<?php echo App::make('url')->to('/');?>/fa/genpdf/declination/{{$object->id}}"
                                    target="_blank">Click to generate Embalming Declination form</a></td>
                    </tr>

                    </tbody>
                </table>
            </div>

            <div id="removal">
                <div class="form_title">Removal of Body</div>
                <table class="form_content">
                    <tbody>
                    <tr>
                        <td class="field_container">Collected from</td>
                        <td class="input_container"><input type="text" id="collected_from1" name="collected_from1"
                                                           value="{{$object->collected_from1}}" class="form-control"/>
                        </td>
                        <td colspan="4" class="input_container"><input type="text" id="collected_from2"
                                                                       name="collected_from2"
                                                                       value="{{$object->collected_from2}}"
                                                                       class="form-control"/></td>
                    </tr>
                    <tr>
                        <td class="field_container"><i class='btn btn-success' id='sent_to_parlour'>Sent to</i></td>
                        <td class="input_container"><input type="text" id="sent_to1" name="sent_to1"
                                                           value="{{$object->sent_to1}}" class="form-control"/></td>
                        <td colspan="4" class="input_container"><input type="text" id="sent_to2" name="sent_to2"
                                                                       value="{{$object->sent_to2}}"
                                                                       class="form-control"/></td>
                    </tr>
                    <tr>
                        <td class="field_container" colspan="6">&nbsp;</td>
                    </tr>

                    <tr id="parlour_row_0_1" style="display: none;">
                        <td class="field_container">
                            <a href="#" id="add_parlour_0" class="add_parlour">Change parlour</a>
                            <input type="hidden" id="parlour_id_0" name="parlour_id[]"/>
                            <input type="hidden" id="parlour_unit_price_0" name="parlour_unit_price[]"/>
                            <input type="hidden" id="parlour_total_price_0" name="parlour_total_price[]"/>
                            <input type="hidden" id="parlour_order_id_0" name="parlour_order_id[]"/>
                        </td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="parlour_name_0" name="parlour_name[]"/>
                        </td>
                        <td class="field_container">From date</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="parlour_from_date0" name="parlour_from_date[]"/>
                        </td>
                        <td class="field_container">From Time</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="parlour_from_time0" name="parlour_from_time[]"/>
                        </td>
                    </tr>
                    <tr id="parlour_row_0_2" style="display: none;">
                        <td></td>
                        <td></td>
                        <td class="field_container">To date</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="parlour_to_date0" name="parlour_to_date[]"/>
                        </td>
                        <td class="field_container">To Time</td>
                        <td class="input_container">
                            <input type="text" class="form-control" id="parlour_to_time0" name="parlour_to_time[]"/>
                        </td>
                    </tr>

                    <?php $nr = 1; ?>

                    @if (isset($parlours) && count($parlours) > 0)
                        @foreach($parlours as $parlour)
                            <tr id="parlour_row_{{$nr}}_1">
                                <td class="field_container">
                                    <a href="#" id="add_parlour_{{$nr}}" parlour_order_id="{{$parlour['parlour_order_id']}}" class="add_parlour">Change parlour</a>
                                    <input type="hidden" id="parlour_id_{{$nr}}" name="parlour_id[]" value="{{$parlour['parlour_id']}}"/>
                                    <input type="hidden" id="parlour_unit_price_{{$nr}}" name="parlour_unit_price[]" value="{{$parlour['parlour_unit_price']}}"/>
                                    <input type="hidden" id="parlour_total_price_{{$nr}}" name="parlour_total_price[]" value="{{$parlour['parlour_total_price']}}"/>
                                    <input type="hidden" id="parlour_order_id_{{$nr}}" name="parlour_order_id[]" value="{{$parlour['parlour_order_id']}}"/>
                                </td>
                                <td class="input_container">
                                    <input type="text" class="form-control" id="parlour_name_{{$nr}}" name="parlour_name[]" value="{{$parlour['parlour_name']}}"/>
                                </td>
                                <td class="field_container">From date</td>
                                <td class="input_container">
                                    <input type="text" class="form-control" id="parlour_from_date{{$nr}}" name="parlour_from_date[]" value="{{$parlour['parlour_from_date']}}"/>
                                </td>
                                <td class="field_container">From Time</td>
                                <td class="input_container">
                                    <input type="text" class="form-control" id="parlour_from_time{{$nr}}" name="parlour_from_time[]" value="{{$parlour['parlour_from_time']}}"/>
                                </td>
                            </tr>
                            <tr id="parlour_row_{{$parlour['parlour_order_id']}}_2">
                                <td></td>
                                <td></td>
                                <td class="field_container">To date</td>
                                <td class="input_container">
                                    <input type="text" class="form-control" id="parlour_to_date{{$nr}}" name="parlour_to_date[]" value="{{$parlour['parlour_to_date']}}"/>
                                </td>
                                <td class="field_container">To Time</td>
                                <td class="input_container">
                                    <input type="text" class="form-control" id="parlour_to_time{{$nr}}" name="parlour_to_time[]" value="{{$parlour['parlour_to_time']}}"/>
                                </td>
                            </tr>
                        <?php $nr ++; ?>
                        @endforeach

                    @else

                        <tr id="parlour_row_1_1">
                            <td class="field_container">
                                <a href="#" id="add_parlour_1" class="add_parlour">Add parlour</a>
                                <input type="hidden" id="parlour_id_1" name="parlour_id[]"/>
                                <input type="hidden" id="parlour_unit_price_1" name="parlour_unit_price[]"/>
                                <input type="hidden" id="parlour_total_price_1" name="parlour_total_price[]"/>
                                <input type="hidden" id="parlour_order_id_1" name="parlour_order_id[]"/>
                            </td>
                            <td class="input_container">
                                <input type="text" class="form-control" id="parlour_name_1" name="parlour_name[]"/>
                            </td>
                            <td class="field_container">From date</td>
                            <td class="input_container">
                                <input type="text" class="form-control" id="parlour_from_date1" name="parlour_from_date[]"/>
                            </td>
                            <td class="field_container">From Time</td>
                            <td class="input_container">
                                <input type="text" class="form-control" id="parlour_from_time1" name="parlour_from_time[]"/>
                            </td>
                        </tr>
                        <tr id="parlour_row_1_2">
                            <td></td>
                            <td></td>
                            <td class="field_container">To date</td>
                            <td class="input_container">
                                <input type="text" class="form-control" id="parlour_to_date1" name="parlour_to_date[]"/>
                            </td>
                            <td class="field_container">To Time</td>
                            <td class="input_container">
                                <input type="text" class="form-control" id="parlour_to_time1" name="parlour_to_time[]"/>
                            </td>
                        </tr>
                    @endif


                    <tr id="add_more_parlour">
                        <td class="field_container" colspan="6">
                            <a href="" id="add_more_parlour_rows">Click to add more</a>
                            <input type="hidden" id="parlour_rows" value="{{$nr+1}}">
                        </td>
                    </tr>
                    <tr>
                        <td class="field_container" colspan="6">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="field_container" colspan="6"><a
                                    href="<?php echo App::make('url')->to('/');?>/fa/genpdf/parlour/{{$object->id}}"
                                    target="_blank">Click to generate Parlour form</a></td>
                    </tr>
                    <tr>
                        <td class="field_container" colspan="6">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="field_container">Final Resting Place</td>
                        <td class="input_container" colspan="1">

                            <select id="resting_place" name="resting_place" style="width: 170px;" class="form-control">
                                <option></option>
                                <option value="Sea Burial" <?php echo ($object->resting_place == "Sea Burial") ? 'selected="true"' : '';?>>
                                    Sea Burial
                                </option>
                                <option value="Nirvana" <?php echo ($object->resting_place == "Nirvana") ? 'selected="true"' : '';?>>
                                    Nirvana
                                </option>
                                <option value="KMS" <?php echo ($object->resting_place == "KMS") ? 'selected="true"' : '';?>>
                                    KMS
                                </option>
                                <option value="other">Other</option>
                            </select>
                        </td>
                        <td class="input_container">
                            <input type="text" id="other_resting_place" name="other_resting_place"
                                   value="{{$object->resting_place}}"
                                   <?php echo (!in_array($object->resting_place, array("Sea Burial", "Nirvana", "KMS"))) ? '' : 'style="display:none"';?>  class="form-control"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="field_container">Own ash collection</td>
                        <td class="input_container">
                            <select id="own_ash_collection" name="own_ash_collection" style="width: 170px;"
                                    class="form-control">
                                <option></option>
                                <option value="yes" <?php echo ($object->own_ash_collection == "yes") ? 'selected="true"' : '';?>>
                                    Yes
                                </option>
                                <option value="no" <?php echo ($object->own_ash_collection == "no") ? 'selected="true"' : '';?>>
                                    No
                                </option>
                            </select>
                        </td>
                        <td class="field_container"><span
                                    id="same_collection_txt" <?php echo ($object->own_ash_collection == "yes") ? 'style="display:none"' : '';?>>Same date collection</span>
                        </td>
                        <td colspan="3"
                            class="input_container" <?php echo ($object->own_ash_collection == "yes") ? 'style="display:none"' : '';?>>

                            <select id="same_date_collection" name="same_date_collection"
                                    style="width: 170px;<?php echo ($object->own_ash_collection == "no") ? 'display:none' : '';?>"
                                    class="form-control">
                                <option></option>
                                <option value="yes" <?php echo ($object->same_date_collection == "yes") ? 'selected="true"' : '';?>>
                                    Yes
                                </option>
                                <option value="no" <?php echo ($object->same_date_collection == "no") ? 'selected="true"' : '';?>>
                                    No
                                </option>

                            </select>
                        </td>
                    </tr>
                    <tr id="ashes_to_be_collected_at_container" <?php echo ($object->own_ash_collection && $object->own_ash_collection == "yes") ? 'style="display:none"' : '';?>>
                        <td class="field_container">Ashes to be collected at</td>
                        <td class="input_container">
                            <select id="ash_collected_at" name="ash_collected_at" style="width: 170px;"
                                    class="form-control">
                                <option></option>
                                <option value="SCC Level 2" <?php echo ($object->ash_collected_at == "SCC Level 2") ? 'selected="true"' : '';?>>
                                    SCC Level 2
                                </option>
                                <option value="Mandai" <?php echo ($object->ash_collected_at == "Mandai") ? 'selected="true"' : '';?>>
                                    Mandai
                                </option>
                                <option value="KMS" <?php echo ($object->ash_collected_at == "KMS") ? 'selected="true"' : '';?>>
                                    KMS
                                </option>
                                <option value="other">Other</option>
                            <!--<option value="other" <?php //echo (!in_array($object->resting_place, array("SCC Level 2","Mandai","KMS")))?'selected="true"':'';?>>Other</option>-->
                            </select>
                            <input type="text" id="other_ash_collected_at" name="other_ash_collected_at"
                                   class="form-control"
                                   <?php echo (!in_array($object->resting_place, array("SCC Level 2","Mandai","KMS")))?'':'style="display:none"';?> value="{{$object->ash_collected_at}}"/>
                        </td>
                        <td class="field_container">between</td>
                        <td class="input_container">
                            <input type="text" id="ash_collect_start" name="ash_collect_start"
                                   class="datetimepicker form-control" value="{{$object->ash_collect_start}}"/></td>
                        <td class="field_container">to</td>
                        <td class="input_container">
                            <input type="text" id="ash_collect_end" name="ash_collect_end"
                                   value="{{$object->ash_collect_end}}" class="datetimepicker form-control"/></td>
                    </tr>
                    <tr>
                        <td colspan="6" style="height: 70px"></td>
                    </tr>
                    <tr>
                        <td>

                        </td>
                        <td colspan="5" style="text-align: right;">
                            <input type="hidden" id="go_to_step" name="go_to_step" value=""/>
                            <a class="btn btn-primary" id="next_bttn"/> Next &nbsp;<i class="fa fa-forward"></i></a>
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


<!--    Add parlours modal popup window -->
<div class="modal fade" id="parlour_popup" tabindex="-1" role="dialog" style="overflow:scroll">
    <div class="modal-dialog" role="document" style="width:57%">
        <div class="modal-content" style="overflow-x:scroll">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="text-align:center">Parlour</h4>
            </div>

            <div class="modal-body" style="width:100%;">
                <div class="parlour_form">
                    <div class="section">
                        <div class="section_title">Parlour selection</div>
                        <div>
                            <div class="capacity_filter_text">Capacity:</div> <input class="form-control capacity_filter_input" type="text" id="capacity_filter" />
                            <div style="clear:both; height:30px"></div>
                            <?php $i = 0;?>

                            @foreach($items as $key => $item)
                                <div id="item_{{$item['id']}}" class="item2select
								@if (isset($order))
                                @if ($order->parlour_name == $item['name'])
                                        selected_item
                                        @endif
                                @endif
                                <?php echo (!isset($is_popup))?'':'popup_view'?>" >
                                    <table style="width:100%">
                                        <tr><td class="img_container">
                                                @if (!empty($item["image"][0]))
                                                    <img src="/uploads/{{$item['image'][0]}}" />
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="item_text">
                                                <span class="parlour_name_container">{{(isset($item['name']))?$item['name']:''}}</span>
                                                <br <?php echo (!isset($is_popup))?'':'style="line-height:5px"'?> />
                                                Capacity: <span class="parlour_capacity_container">{{(isset($item['capacity']))?$item['capacity']:''}}</span>
                                                <br <?php echo (!isset($is_popup))?'':'style="line-height:5px"'?> />
                                                Unit price: $<span class="unit_price">{{(isset($item['unit_price']))?$item['unit_price']:''}}</span>
                                            </td>
                                        </tr>
                                        <tr><td class="item_btn">SELECT</td></tr>
                                    </table>
                                </div>
                                <?php if (isset($is_popup) && $i++ % 4 == 3):?>
                                <div style="clear:both"></div>
                                <?php endif;?>
                            @endforeach
                            <div style="clear:both"></div>
                        </div>
                    </div>

                    <div class="section" <?php echo (!isset($is_popup))?'':'style="margin-bottom:0px"'?>>
                        <div class="section_title">Parlour booking details</div>
                        <div>
                            <form id="booking_parlour" action="/parlour/save" method="post" class="master_form parlour_form" onsubmit="return false">
                                {!! csrf_field() !!}
                                <input type="hidden" id="order_id" name="id" value="{{(isset($order))?$order->id:""}}" />
                                <input type="hidden" id="parlour_id" name="parlour_id" value="{{(isset($order))?$order->parlour_id:""}}" />
                                <input type="hidden" id="is_order" name="is_order" value="1" />
                                <input type="hidden" id="form_nr">
                                <table id="order_form_tbl">
                                    @if (!isset($is_popup))
                                        <tr>
                                            <td style="width: 20%">Capacity </td>
                                            <td style="width: 236px"><input type="text" class="form-control" name="capacity" id="capacity" value="" /></td>
                                            <td style="width: 10%"></td>
                                            <td></td>
                                            <td style="width: 8%">Date </td>
                                            <td><span id="created_at">{{date("d/m/Y H:i")}}</span></td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>Parlour selection </td>
                                        <td><span id="parlour_selection_container"></span><input type="hidden" name="parlour_name" id="parlour_name" /></td>
                                        <td></td>
                                        <td></td>

                                        <td>Ref No: </td>
                                        <td><input type="text" style="width:150px" class="form-control" id="fa_code" name="fa_code" disabled/><input type="hidden"  id="fa_id" name="fa_id" value="@if(isset($object)){{$object->id}}@endif" /></td>

                                    </tr>
                                    <tr>
                                        <td>Unit price </td>
                                        <td><span id="unit_price_container"></span><input type="hidden" name="unit_price" id="unit_price" /></td>
                                        <td></td>
                                        <td></td>
                                        <td>Order No. </td>
                                        <td><span id="order_nr">P{{$order_nr}}</span> <?php echo (!isset($order))?"<span style='color: #CCC; font-size:11px'>(might change after saving)</span>":"";?></td>

                                    </tr>
                                    <tr>
                                        <td>Date from: </td>
                                        <td><input type="text"  class="form-control" id="booked_from_day" name="booked_from_day" /></td>
                                        <td style="padding-left: 10px;">Date to: </td><td></td><td></td>
                                        <td><input type="text" class="form-control" id="booked_to_day" name="booked_to_day" /></td>
                                    </tr>
                                    <tr>
                                        <td>Time from: </td>
                                        <td>
                                            <select class="form-control" title="" name="booked_from_time" id="booked_from_time">
                                                <option></option>
                                                <?php $booked_from_time = (isset($order))?substr($order->booked_from_time, 0, -3):""; ?>
                                                <?php for ($i = 0; $i < 24; $i++):?>
                                                <option value="<?php echo sprintf("%02d", $i) . ":00";?>"
                                                        @if ($booked_from_time == sprintf("%02d", $i) . ":00")
                                                        selected="selected"
                                                        @endif
                                                ><?php echo sprintf("%02d", $i) . ":00";?></option>
                                                <option value="<?php echo sprintf("%02d", $i) . ":30";?>"
                                                        @if ($booked_from_time == sprintf("%02d", $i) . ":30")
                                                        selected="selected"
                                                        @endif
                                                ><?php echo sprintf("%02d", $i) . ":30";?></option>
                                                <?php endfor?>
                                            </select>
                                        </td>
                                        <td style="padding-left: 10px;">Time to: </td><td></td><td></td>
                                        <td>
                                            <select class="form-control" title="" name="booked_to_time" id="booked_to_time">

                                                <?php $booked_to_time = (isset($order))?substr($order->booked_to_time, 0, -3):""; ?>
                                                <option></option>
                                                <?php for ($i = 1; $i <= 24; $i++):?>
                                                <option value="<?php echo sprintf("%02d", $i-1) . ":30";?>"
                                                        @if ($booked_to_time == sprintf("%02d", $i) . ":30")
                                                        selected="selected"
                                                        @endif
                                                ><?php echo sprintf("%02d", $i-1) . ":30";?></option>
                                                <?php if ($i == 24):?>
                                                <option value="23:59"
                                                        @if ( $booked_to_time == "23:59:00")
                                                        selected="selected"
                                                        @endif
                                                >23:59</option>
                                                <?php else:?>
                                                <option value="<?php echo sprintf("%02d", $i) . ":00";?>"
                                                        @if ($booked_to_time == sprintf("%02d", $i) . ":00")
                                                        selected="selected"
                                                        @endif
                                                ><?php echo sprintf("%02d", $i) . ":00";?></option>
                                                <?php endif;?>
                                                <?php endfor?>
                                            </select>
                                        </td>
                                        @if (!isset($is_popup))
                                            <td></td>
                                            <td></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Total price </td>
                                        <td>
                                            <span id="total_price_span"></span>
                                            <input type="hidden" class="form-control" name="total_price" id="total_price" value="{{(isset($order))? $order->total_price:""}}" />
                                            <input type="hidden" class="form-control" name="hours" id="hours" value="" />
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="height: 50px"></td>
                                    </tr>
                                    <tr>
                                        <td>Deceased Name</td>
                                        <td><input type="text" name="deceased_name"  id="parlour_deceased_name" class="form-control" value=""/></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="height: 50px"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Confirmed By</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>NRIC</td>
                                        <td><input type="text" class="form-control" id="parlour_cp_nric" name="cp_nric"  value=""  /></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Name</td>
                                        <td><input type="text" class="form-control" id="parlour_cp_name" name="cp_name" value="" /></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Signature</td>
                                        <td colspan="5">
                                            <div id="box1" style="margin-left: 1px; ">
                                                @if (isset($order) && $order->signature)
                                                    <img src="{{$order->signature}}" style="width:100px"/>
                                                @endif
                                            </div>
                                            <div class="signature_box" id="signature_box_1">
                                                <div id="signature1" data-name="signature1" data-max-size="2048"
                                                     data-pen-tickness="3" data-pen-color="black"
                                                     class="sign-field"></div>
                                                <input type="hidden" id="signature_image_1" name="signature_image_1" value="{{(isset($order))? $order->signature:""}}" />
                                                <button class="btn btn-primary" >Ok</button>

                                            </div>

                                        </td>
                                    </tr>
                                        <tr>
                                            <td> </td>
                                            <td colspan="5">
                                                Date: <span id="date_signature_1">{{(isset($order))?$order->signature_date:""}}</span><input type="hidden" name="date_signature_1" id="input_date_signature_1" value="{{(isset($order))?$order->signature_date:""}}" />
                                            </td>
                                        </tr>

                                    <tr>
                                        <td colspan="6" style="height: 50px"></td>
                                    </tr>
                                    <tr>
                                        <td>Taken by</td>
                                        <td><sapn id="taken_by">{{ Auth::user()->name}}</sapn></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Date, Time</td>
                                        <td><sapn id="taken_date">{{date("d/m/Y H:i")}}</sapn></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="height: 50px"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="text-align:center"><input type="button" value="SUBMIT" id="submit_bttn_form" class="btn btn-grey-500" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="height: 20px"></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                    <input type='hidden' id='dp_start_date' />
                    <input type='hidden' id='dp_end_date' />
                </div>

                <div class="section">
                    <div class="section_title">Parlour booking summary</div>
                    <div>
                        <div class="filter_zone">
                            <form>
                                <table>
                                    <tr>
                                        <td>Date from</td>
                                        <td><input type="text" class="form-control" id="filter_booked_from_day" name="filter_booked_from_day" /></td>
                                        <td>to</td>
                                        <td><input type="text" class="form-control" id="filter_booked_to_day" name="filter_booked_to_day" /></td>
                                    </tr>
                                    <tr>
                                        <td>Parlour</td>
                                        <td colspan="3">
                                            <select class="form-control" name="filter_parlour" id="filter_parlour" style="width:150px;">
                                                <option></option>
                                                @foreach($items as $key => $item)
                                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="button" value="Filter" class="btn btn-blue-500" id="filter_bttn" /></td>
                                        <td colspan="3"></td>
                                    </tr>
                                </table>
                            </form>
                        </div>

                        <div style="clear: both; height:50px"></div>
                        <div id="listing">
                            <table  id="listing_tbl" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Parlour Name</th>
                                    <th>Capacity</th>
                                    <th>Date From</th>
                                    <th>Date From sec</th>
                                    <th>Date To</th>
                                    <th>Date To sec</th>
                                    <th>Time from</th>
                                    <th>Time from sec</th>
                                    <th>Time to</th>
                                    <th>Time to sec</th>
                                    <th>{{$company_prefix}} no.</th>
                                    <th>Order taken by</th>
                                    <th>Order no.</th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="booking_save_msg" tabindex="-1" role="dialog" style="z-index:11111;overflow:scroll">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Status</h4>
            </div>

            <div class="modal-body">
                <div class="form-group" id="booking_message_container">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="close_all_popup();">OK
                </button>
            </div>

        </div>
    </div>
</div>
<!--  -->
<!---   Add popup for to view all images -->
<div class="modal fade" id="view_all_images" tabindex="-2" role="dialog" style="z-index:22222">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id=""></h4>
            </div>

            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <!--  <button type="button" class="btn btn-default" id="cancel_general_bttn">Cancel</button>  -->
                <!--  <button type="button" class="btn btn-primary" id="save_general_bttn">Save</button>  -->
            </div>

        </div>
    </div>
</div>
<script>
    $send_to_value = $("#sent_to1").val();

    if ($send_to_value == "Outside" || $send_to_value == "outside") {
        //$("#parlour_name_1").parent().parent().next().hide();
        //$("#parlour_name_1").parent().parent().hide();
    }
    $("#sent_to1").keyup(function (event) {
        if (event.which == 8 || event.which == 46 || $(this).val().length > 1) {

            if ($("#sent_to1").val() == "outside" || $("#sent_to1").val() == "Outside") {
                $("#parlour_name_1").parent().parent().next().hide();
                $("#parlour_name_1").parent().parent().hide();
            } else {
                $("#parlour_name_1").parent().parent().next().show();
                $("#parlour_name_1").parent().parent().show();
            }
        }
    });


    $(document).ready(function () {


        $("#capacity_filter").keyup(function(){
            var capacity_val = $(this).val();
            $('#capacity').val(capacity_val);
        });
        $("#submit_bttn_form").click(function(){
            if( $("#parlour_selection_container").text() == ""){
                $("#message_container").html("Please select a Parlour ");
                $("#save_msg").modal("show");
                return false;
            }else {

                $.ajax({
                    url: "parlour/parlour_modal_save",
                    method: "POST",
                    data: $(this).parents("form").serialize(),
                    statusCode: {
                        401: function() {
                            alert( "Login expired. Please sign in again." );
                        }
                    },
                    success: function (result) {
                        var form_nr = $("#form_nr").val();
                        var message;
                        if(result.id) {
                            console.log(form_nr);

                            message = "Successful Parlour Booking!";
                            //Update input box
                            $('#add_parlour_'+form_nr).attr("parlour_order_id", result.id);


                            $('#parlour_name_'+ form_nr).val(result.parlour_name);

                            //console.log($('#parlour_name_'+ form_nr).val());
                            $('#parlour_id_'+ form_nr).val(result.parlour_id);
                            $('#parlour_order_id_'+ form_nr).val(result.id);
                            $('#parlour_unit_price_'+ form_nr).val(result.unit_price);
                            $('#parlour_total_price_'+ form_nr).val(result.total_price);

                            var booked_from_day = dateFormat(result.booked_from_day);
                            var booked_to_day = dateFormat(result.booked_to_day);
                            $('#parlour_from_date'+ form_nr).val(booked_from_day);
                            $('#parlour_from_time'+ form_nr).val(result.booked_from_time);
                            $('#parlour_to_date'+ form_nr).val(booked_to_day);
                            $('#parlour_to_time'+ form_nr).val(result.booked_to_time);

                            var parlour_rows = $("#parlour_rows").val();
                            /*if(form_nr == 2)
                             {*/
                            parlour_rows ++;
                            $("#parlour_rows").val(parlour_rows);
                            //}
                        }
                        else {
                            message = "Fail Parlour Booking!";
                        }

                        $("#message_container").html(message);
                        $("#save_msg").modal("show");
                        $("#parlour_popup").modal("hide");
                    }
                });

            }

        });


    });



</script>
<script>var baseUrl = $(".master_form").attr("action").replace("/save", "");</script>
