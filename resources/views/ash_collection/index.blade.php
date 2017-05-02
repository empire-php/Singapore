@extends('layouts.app')

@section('content')

<?php if ($session->get("ac_msg")):?>
<script type="text/javascript">
    var saveMessage = '<?php echo implode("<br />",$session->get("ac_msg"))?>';
    var openPdf = <?php echo ($session->get("ac_open_pdf") == 1)? "true" : "false"?>;
</script>
<?php $session->set("ac_msg", null); $session->set("ac_open_pdf", null);?>
<?php endif; ?>


<form action="/ashcollection/save"  id="info_frm" method="post" enctype="multipart/form-data" class="master_form needs_exit_warning">
    {!! csrf_field() !!}
    
    <input type="hidden"  id="form_id" name="id" value="{{$form->id}}"  />
    <input type="hidden"  id="is_draft" value="{{$form->is_draft}}"  />
<div class="section">

    <div class="section_title" style="margin-top:10px">Acknowledgement Slip</div>
    <div class="section_content">
        <table class="form_content" style="width:70%">
            <tr>
                <td style="width:15%">Date:</td>
                <td style="width:30%">{{ date("d/m/Y", strtotime($form->created_at))}}</td>
                <td style="width:10%">Ref: </td>
                <td style="width:15%">
                    <input type="text" class="form-control" id="fa_code" name="fa_code" value="{{ ($form->funeral_arrangement_id)?$form->funeralArrangement->generated_code:"" }}"  />
                    <input type="hidden"  id="fa_id" name="funeral_arrangement_id" value="{{($form->funeral_arrangement_id)?$form->funeral_arrangement_id:""}}"  />
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" style="height: 50px"></td>
            </tr>
            <tr>
					<td>Title</td>
							<td>
							<select name="deceased_title" class="form-control">
							<option value="">Select</option>
								<option value="Mr"   
										@if ($form->deceased_title == "Mr")
										selected="true"
										@endif
										>Mr</option> 
								<option value="MDM"
										@if ($form->deceased_title == "MDM")
										selected="true"
										@endif
										>Mdm</option>
								<option value="Miss"
										@if ($form->deceased_title == "Miss")
										selected="true"
										@endif
										>Miss</option>
								<option value="DR"
										@if ($form->deceased_title == "DR")
										selected="true"
										@endif
										>Dr</option>
							</select>
							</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
            </tr> 
			<tr>
                <td>Deceased Name:</td>
                <td><input type="text" name="deceased_name"  id="deceased_name" class="form-control" value="{{$form->deceased_name}}"  /></td>
                <td></td>
                <td>Funeral Date: </td>
                <td>
                    <input type="text" name="funeral_date"  id="funeral_date" class="form-control datepicker_day_format" value="{{$form->funeral_date}}"  />
                </td>
            </tr>
            <tr>
                <td>Type of Urn:</td>
                <td><input type="text" name="type_of_urn"  id="type_of_urn" class="form-control" value="{{$form->type_of_urn}}"  /></td>
                <td></td>
                <td>Final Resting Place: </td>
                <td>
                    <input type="text" name="final_resting_place"  id="final_resting_place2" class="form-control" value="{{$form->final_resting_place}}"  />
                </td>
            </tr>
            <tr>
                <td class="field_container">Religion</td>
                <td class="input_container">
                    <select name="religion"  class="form-control">
                        @foreach($religionOptions as $religionOp)
                        <option value="{{$religionOp->id}}"
                                        @if (($form->religion) && $religionOp->id == $form->religion)
                                        selected="true"
                                        @endif
                                >{{$religionOp->name}}</option>
                        @endforeach
                    </select>
                </td>
                <td colspan="3"></td>
            </tr>
        </table>
    </div>
    
    
    <div class="section_title">Details of Ashes</div>
    <div class="section_content">
        <table class="form_content" style="width:70%">
            <tr>
                <td style="width:15%">Ashes Transfer Date:</td>
                <td style="width:30%"><input type="text" id="ashes_transfer_date" name="ashes_transfer_date" class="form-control datepicker_day_format" value="{{$form->ashes_transfer_date}}"  /></td>
                <td style="width:10%"></td>
                <td style="width:15%"></td>
                <td></td>
            </tr>
            <tr>
                <td>Time:</td>
                <td><input type="text" id="ashes_transfer_time" name="ashes_transfer_time" class="form-control" value="{{$form->ashes_transfer_time}}"  /></td>
                <td></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="5" style="height: 50px"></td>
            </tr>
            <tr>
                <td><strong>Confirmed by</strong></td>
                <td></td>
                <td></td>
                <td colspan="2"><strong>Ashes Received By Family</strong></td>
            </tr>
            <tr>
                <td>NRIC</td>
                <td>
                    <input type="text" id="confirmed_by_nric" name="confirmed_by_nric" class="form-control nric_autocomplete" value="{{$form->confirmed_by_nric}}"  />
                    <input type="hidden" id="confirmed_by_email" name="confirmed_by_email" value="{{$form->confirmed_by_email}}"  />
                </td>
                <td></td>
                <td>NRIC</td>
                <td>
                    <input type="text" id="received_by_nric" name="received_by_nric" class="form-control nric_autocomplete" value="{{$form->received_by_nric}}"  />
                    <input type="hidden" id="received_by_email" name="received_by_email" value="{{$form->received_by_email}}"  />
                </td>
            </tr>
            <tr>
                <td>Name</td>
                <td><input type="text" id="confirmed_by_name" name="confirmed_by_name" class="form-control" value="{{$form->confirmed_by_name}}"  /></td>
                <td></td>
                <td>Name</td>
                <td><input type="text" id="received_by_name" name="received_by_name" class="form-control" value="{{$form->received_by_name}}"  /></td>
            </tr>
            <tr>
                <td>Signature</td>
                <td>
                    <div id="box1" >
                        @if ($form->signatures != "")
                        <?php $signaturesData = json_decode($form->signatures, true); //echo "<pre>"; print_r($signaturesData);?>
                        <img src="<?php  echo (isset($signaturesData["signatures"][1]))?$signaturesData["signatures"][1]:''?>" style="width:100px"/>
                        @endif
                    </div>
                    <div class="signature_box" id="signature_box_1">
                        <div id="signature1" data-name="signature1" data-max-size="2048" 
                               data-pen-tickness="3" data-pen-color="black" 
                               class="sign-field"></div>
                               <input type="hidden" id="signature_image_1" name="signature_image_1" value="<?php echo (isset($signaturesData["signatures"][1]))?$signaturesData["signatures"][1]:''?>" />
                               <button class="btn btn-primary" >Ok</button>

                    </div>
                    Date: <span id="date_signature_1"><?php 
                                if ($form->signatures != "" && isset($signaturesData["dates"][1]) && $signaturesData["dates"][1] != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($signaturesData["dates"][1]));
                                else:
                                    echo date("d/m/Y");
                                endif;
                         ?></span><input type="hidden" name="date_signature_1" id="input_date_signature_1" value="<?php echo (isset($signaturesData["dates"][1]))?$signaturesData["dates"][1]:"";?>" />
                </td>
                <td></td>
                <td>Signature</td>
                <td>
                    <div id="box2" >
                        @if ($form->signatures != "" )
                        <img src="<?php echo (isset($signaturesData["signatures"][2]))?$signaturesData["signatures"][2]:''?>" style="width:100px"/>
                        @endif
                    </div>
                    <div class="signature_box" id="signature_box_2">
                        <div id="signature2" data-name="signature2" data-max-size="2048" 
                               data-pen-tickness="3" data-pen-color="black" 
                               class="sign-field"></div>
                               <input type="hidden" id="signature_image_2" name="signature_image_2" value="<?php echo (isset($signaturesData["signatures"][2]))?$signaturesData["signatures"][2]:''?>" />
                               <button class="btn btn-primary" >Ok</button>

                    </div>
                    Date: <span id="date_signature_2"><?php 
                                if ($form->signatures != "" && isset($signaturesData["dates"][2]) && $signaturesData["dates"][2] != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($signaturesData["dates"][2]));
                                else:
                                    echo date("d/m/Y");
                                endif;
                         ?></span><input type="hidden" name="date_signature_2" id="input_date_signature_2" value="<?php echo (isset($signaturesData["dates"][2]))?$signaturesData["dates"][2]:"";?>" />
                </td>
            </tr>
            <tr>
                <td colspan="5" style="height: 50px"></td>
            </tr>
            <tr>
                <td>Ashes Transfer by </td>
                <td>
                    <select class="form-control" name="ashes_transfer_by" data-toggle="select2" multiple class="form-control">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                    @if (in_array($user->id, explode(",",$form->ashes_transfer_by)))
                                    selected="selected"
                                    @endif
                                    >
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td></td>
                <td>Ashes Location:</td>
                <td>
                    <select id="ashes_location" name="ashes_location" class="form-control">
                        <option></option>
                        @foreach(\App\AshCollectionForms::ashesLocationOptions as $key => $text)
                        <option value="{{$key}}" 
                                @if ($form->ashes_location && $form->ashes_location == $key)
                                selected="selected"
                                @endif
                                >{{$text}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>Date </td>
                <td><input type="text" id="ashes_transfer_by_date" name="ashes_transfer_by_date" class="form-control datepicker_day_format" value="{{$form->ashes_transfer_by_date}}"  /></td>
                <td colspan="3"></td>
            </tr>
        </table>
    </div>
    
    
    
    
    <div class="section_title">Details of Ash Installation</div>
    <div class="section_content">
        <table class="form_content" style="width:70%">
            <tr>
                <td style="width:20%">Final Resting Place</td>
                <td style="width:30%"><input type="text" id="final_resting_place1" name="final_resting_place" class="form-control" value="{{$form->final_resting_place}}"  /></td>
                <td style="width:10%"></td>
                <td style="width:15%">Niche Location</td>
                <td><input type="text" id="niche_location" name="niche_location" class="form-control" value="{{$form->niche_location}}"  /></td>
            </tr>
            <tr>
                <td>Slab Installation Date & Time</td>
                <td><input type="text" id="slab_install" name="slab_install" class="form-control" value="{{$form->slab_install}}"  /></td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>Photo Installation Date & Time</td>
                <td><input type="text" id="photo_install" name="photo_install" class="form-control" value="{{$form->photo_install}}"  /></td>
                <td></td>
                <td>Type of Install</td>
                <td><input type="text" id="type_of_install" name="type_of_install" class="form-control" value="{{$form->type_of_install}}"  /></td>
            </tr>
            <tr>
                <td colspan="5" style="height: 50px"></td>
            </tr>
            <tr>
                <td>Meet Family</td>
                <td><input type="text" id="meet_family" name="meet_family" class="form-control" value="{{$form->meet_family}}"  /></td>
                <td></td>
                <td>Monk Chanting</td>
                <td><input type="text" id="monk_chanting" name="monk_chanting" class="form-control" value="{{$form->monk_chanting}}"  /></td>
            </tr>
            <tr>
                <td colspan="5" style="height: 50px"></td>
            </tr>
            <tr>
                <td>Remarks</td>
                <td colspan="4"><textarea id="remarks" name="remarks" class="form-control" cols="2">{{$form->remarks}}</textarea> </td>
            </tr>
            <tr>
                <td colspan="5" style="height: 50px"></td>
            </tr>
            <tr>
                <td><strong>Ashes Installed by</strong></td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td>Staff name</td>
                <td>
                    <select class="form-control" name="staff_name" data-toggle="select2" multiple class="form-control">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                    @if (in_array($user->id, explode(",",$form->staff_name)))
                                    selected="selected"
                                    @endif
                                    >
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td colspan="3"></td>
            </tr>
        </table>
    </div>
    
    <div class="section_content" style="margin-top: 100px; height: 100px;">
        <table style="width: 100%">
            <tr>
                <td style="width: 33%; text-align: right"><input type="button" value="SUBMIT" id="submit_bttn" /></td>
                <td style="width: 33%; text-align: center"><input type="button" value="SUBMIT & E-mail" id="submit_email_bttn" /><br style="line-height:30px" /><input type="button" value="SUBMIT & E-mail (other e-mail)"   id="submit_other_email_bttn" /></td>
                <td style=" text-align: left"><input type="button" value="SUBMIT & Print" id="submit_print_bttn" /></td>
            </tr>
        </table>
    </div>
</div>
    

</form>
@endsection


@push('css')
    <link href="/css/app/ashcollection.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
    <script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
    <script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
    <script src="/js/app/general_form.js"></script>
    <script src="/js/app/ashcollection.js"></script>
@endpush