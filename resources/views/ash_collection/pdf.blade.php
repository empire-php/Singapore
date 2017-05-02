<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Ash Collection {{ ($form->funeral_arrangement_id)?$form->funeralArrangement->getCompanyPrefix()." ".$form->funeralArrangement->generated_code:"" }}</title>
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

    <div class="section_title" style="margin-top:10px">Acknowledgement Slip</div>
    <div class="section_content">
        <table class="form_content" style="width:100%">
            <tr>
                <td style="width:15%">Date:</td>
                <td style="width:30%" class="field_to_be_completed">{{ date("d/m/Y", strtotime($form->created_at))}}</td>
                <td style="width:10%">Ref: </td>
                <td style="width:15%" class="field_to_be_completed">
                    {{ ($form->funeral_arrangement_id)?$form->funeralArrangement->getCompanyPrefix()." ".$form->funeralArrangement->generated_code:"" }}
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
										>MDM</option>
								<option value="Miss"
										@if ($form->deceased_title == "Miss")
										selected="true"
										@endif
										>Miss</option>
								<option value="DR"
										@if ($form->deceased_title == "DR")
										selected="true"
										@endif
										>DR</option>
							</select>
							</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
            </tr>
			<tr>
                <td>Deceased Name:</td>
                <td class="field_to_be_completed">{{$form->deceased_name}}</td>
                <td></td>
                <td>Funeral Date: </td>
                <td class="field_to_be_completed">
                    {{$form->funeral_date}}
                </td>
            </tr>
            <tr>
                <td>Type of Urn:</td>
                <td class="field_to_be_completed">{{$form->type_of_urn}}</td>
                <td></td>
                <td>Final Resting Place: </td>
                <td class="field_to_be_completed">
                    {{$form->final_resting_place}}
                </td>
            </tr>
            <tr>
                <td class="field_container">Religion</td>
                <td class="field_to_be_completed">@foreach($religionOptions as $religionOp)
                        @if (($form->religion) && $religionOp->id == $form->religion)
                        {{$religionOp->name}}<
                        @endif
                    @endforeach
                </td>
                <td colspan="3"></td>
            </tr>
        </table>
    </div>
    
    
    <div class="section_title">Details of Ashes</div>
    <div class="section_content">
        <table class="form_content" style="width:100%">
            <tr>
                <td style="width:15%">Ashes Transfer Date:</td>
                <td style="width:30%" class="field_to_be_completed">{{$form->ashes_transfer_date}}</td>
                <td style="width:10%"></td>
                <td style="width:15%"></td>
                <td></td>
            </tr>
            <tr>
                <td>Time:</td>
                <td class="field_to_be_completed">{{$form->ashes_transfer_time}}</td>
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
                <td class="field_to_be_completed">
                    {{$form->confirmed_by_nric}}
                </td>
                <td></td>
                <td>NRIC</td>
                <td class="field_to_be_completed">
                    {{$form->received_by_nric}}
                </td>
            </tr>
            <tr>
                <td>Name</td>
                <td class="field_to_be_completed">{{$form->confirmed_by_name}}</td>
                <td></td>
                <td>Name</td>
                <td class="field_to_be_completed">{{$form->received_by_name}}</td>
            </tr>
            <tr>
                <td>Signature</td>
                <td>
                    <div id="box1" >
                        @if ($form->signatures != "")
                        <?php $signaturesData = json_decode($form->signatures, true);?>
                        <img src="<?php echo $signaturesData["signatures"][1];?>" style="width:100px"/>
                        @endif
                    </div>
                    Date: <span id="date_signature_1"><?php 
                                if ($form->signatures != "" && isset($signaturesData["dates"][1]) && $signaturesData["dates"][1] != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($signaturesData["dates"][1]));
                                else:
                                    echo date("d/m/Y");
                                endif;
                         ?></span>
                </td>
                <td></td>
                <td>Signature</td>
                <td>
                    <div id="box2" >
                        
                        @if ($form->signatures != "" && isset($signaturesData["signatures"][2]))
                        <img src="<?php echo $signaturesData["signatures"][2];?>" style="width:100px"/>
                        @endif
                    </div>
                    
                    Date: <span id="date_signature_2"><?php 
                                if ($form->signatures != "" && isset($signaturesData["dates"][2]) && $signaturesData["dates"][2] != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($signaturesData["dates"][2]));
                                else:
                                    echo date("d/m/Y");
                                endif;
                         ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="5" style="height: 50px"></td>
            </tr>
            <tr>
                <td>Ashes Transfer by </td>
                <td class="field_to_be_completed">
                    @foreach ($users as $user)
                        @if (in_array($user->id, explode(",",$form->ashes_transfer_by)))
                        {{ $user->name }}
                        @endif
                    @endforeach
                </td>
                <td></td>
                <td>Ashes Location:</td>
                <td class="field_to_be_completed">
                    @foreach(\App\AshCollectionForms::ashesLocationOptions as $key => $text)
                        @if ($form->ashes_location && $form->ashes_location == $key)
                        {{$text}}
                        @endif
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>Date </td>
                <td class="field_to_be_completed">{{$form->ashes_transfer_by_date}}</td>
                <td colspan="3"></td>
            </tr>
        </table>
    </div>
    
    <div class="page-break"></div>
    
    
    <div class="section_title">Details of Ash Installation</div>
    <div class="section_content">
        <table class="form_content" style="width:100%">
            <tr>
                <td style="width:20%">Final Resting Place</td>
                <td style="width:30%" class="field_to_be_completed">{{$form->final_resting_place}}</td>
                <td style="width:10%"></td>
                <td style="width:15%">Niche Location</td>
                <td class="field_to_be_completed">{{$form->niche_location}}</td>
            </tr>
            <tr>
                <td>Slab Installation Date & Time</td>
                <td class="field_to_be_completed">{{$form->slab_install}}</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>Photo Installation Date & Time</td>
                <td class="field_to_be_completed">{{$form->photo_install}}</td>
                <td></td>
                <td>Type of Install</td>
                <td class="field_to_be_completed">{{$form->type_of_install}}</td>
            </tr>
            <tr>
                <td colspan="5" style="height: 50px"></td>
            </tr>
            <tr>
                <td>Meet Family</td>
                <td class="field_to_be_completed">{{$form->meet_family}}</td>
                <td></td>
                <td>Monk Chanting</td>
                <td class="field_to_be_completed">{{$form->monk_chanting}}</td>
            </tr>
            <tr>
                <td colspan="5" style="height: 50px"></td>
            </tr>
            <tr>
                <td style="vertical-align: top">Remarks</td>
                <td colspan="4" class="field_to_be_completed">{{$form->remarks}}</td>
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
                <td class="field_to_be_completed">
                    @foreach ($users as $user)
                        @if (in_array($user->id, explode(",",$form->staff_name)))
                        {{ $user->name }}
                        @endif  
                    @endforeach
                </td>
                <td colspan="3"></td>
            </tr>
        </table>
    </div>

</div>

</div>
    </body>
</html>
