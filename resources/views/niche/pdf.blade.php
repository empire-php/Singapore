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

        .suite-table td {
            border : 1px solid #aeaeae !important;
            word-wrap:break-word;
            text-align:center;
            cursor: pointer;
        }
        .suite-table tr:first-child, .suite-table td:nth-child(1), .suite-table td:last-child {
            background-color: #494949;
            color: #fff;
            border-color: #3a3a3a;
            cursor: default;
        }
        .suite-table tr:first-child > td:nth-child(1), .suite-table tr:first-child > td:last-child, .suite-table tr:first-child > td:nth-child(1)
        {
            background-color: #fff;
            border: 0px solid #fff !important;
        }
        .suite-table tr:first-child > td {
            cursor: default;
        }
        .border-td {
            border: 1px solid #424242;

            height: 30px;
            text-align: center;
            padding: 10px 10px;
        }

    </style>
</head>
<body>
<div class="page-header">

    <h3>
        Purchase order - Niche
    </h3>
        <div id="order_form" class="needs_exit_warning">
            <div class="section">
                <div id="order_info">
                    <table style="width: 100%">
                        <tr>
                            <td>Date:</td>
                            <td>{{ date('d/m/Y h:i') }} </td>
                        </tr>
                        <tr>
                            <td>Ref No:</td>
                            <td>{{ ($object->funeral_arrangement_id)?$object->funeralArrangement->generated_code:"" }}"</td>
                        </tr>
                        <tr>
                            <td>Order No:</td>
                            <td>{{ $object->order_nr}}"</td>
                        </tr>
                        <tr>
                            <td>Issued and Arranged by:</td>
                            <td>{{($object->created_by)?$object->creator->name: $user->name }}</td>
                        </tr>
                    </table>
                </div>

                <div style="clear:both"></div>

                <div class="section_title">Customer Details</div>
                <table>
                    <tr>
                        <td>Name:</td>
                        <td>{{$object->first_cp_name}}</td>
                        <td>NIRC:</td>
                        <td>{{$object->first_cp_nric}}</td>
                    </tr>
                    <tr>
                        <td>Nationality:</td>
                        <td>
                            @foreach($raceOptions as $raceOp)
                                @if ($raceOp->id == $object->race)
                                    {{$raceOp->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>Gender:</td>
                        <td>{{$object->sex}}</td>
                    </tr>
                    <tr>
                        <td>Date of Birth:</td>
                        <td>{{$object->birthdate}}</td>
                        <td>Correspondence<br/> Address:</td>
                        <td>{{$object->first_cp_address}}</td>
                    </tr>
                    <tr>
                        <td>Permanent Address:</td>
                        <td>{{$object->first_cp_postal_code}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Home Number:</td>
                        <td>{{$object->first_cp_home}}</td>
                        <td>Mobile Number:</td>
                        <td>{{$object->first_cp_mobile}}</td>
                    </tr>
                    <tr>
                        <td>Office Number :</td>
                        <td>{{$object->first_cp_office}}</td>
                        <td>Email:</td>
                        <td>{{$object->first_cp_email}}</td>
                    </tr>
                </table>

                <div class="space"></div>
                <div class="section_title">Particulars of Intended User</div>
                <table>
                    <tr>
                        <td style="width: 20% "><em>Intended User 1</em></td>
                        <td></td>
                        <td><em>Intended User 2</em></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td>{{$object->deceased_name}}</td>
                        <td>Name:</td>
                        <td>{{--{{$object->deceased_name}}--}}</td>
                    </tr>
                    <tr>
                        <td>NIRC:</td>
                        <td></td>
                        <td>NIRC:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Relationship:</td>
                        <td></td>
                        <td>Relationship:</td>
                        <td></td>
                    </tr>

                </table>

                <div class="space"></div>


                <div class="section_title">Selection</div>

                <table style="width: 100%;" >
                    <tr>
                        <td align="center">Columbarium No.</td>
                        <td align="center">Suite No.</td>
                        <td align="center">Section/Side</td>
                        <td align="center">Level</td>
                        <td align="center">Compartment No.</td>
                        <td align="center">Unit</td>
                        <td align="center">Type</td>
                    </tr>
                    <tr>
                        <td class="border-td">{{ $object->columbarium }}</td>
                        <td class="border-td">{{ $object->suite_nr }}</td>
                        <td class="border-td">{{ $object->section_nr }}</td>
                        <td class="border-td">{{ $object->level }}</td>
                        <td class="border-td">{{ $object->compartment }}</td>
                        <td class="border-td">{{ $object->unit }}</td>
                        <td class="border-td">{{ $object->unit_type }}</td>
                    </tr>
                </table>

                <div class="page-break"></div>

                <div class="section_title">Niche Purchase Price(Total)</div>
                <div class="row">
                    <div class="col-md-5">
                        <table style="width: 80%;">
                            <tr>
                                <td width="25%">Niche Price:</td>
                                <td width="75%">{{ $object->niche_price }} </td>
                            </tr>
                            <tr>
                                <td>Maintenance Fee:</td>
                                <td>{{ $object->maintenance_fee }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Others:</td>
                            </tr>
                            <tr>
                                <td>{{ $object->other_text }}</td>
                                <td>{{ $object->other_price }}</td>
                            </tr>
                            <tr>
                                <td>GST</td>
                                <td>{{ $object->gst }}</td>
                            </tr>
                            <tr>
                                <td>Total:</td>
                                <td>{{ $object->total_price }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-7">
                        <p>
                            <span style="text-transform: uppercase; font-weight: bold">Note</span>
                            <br/>
                            1). This Purchase shall be subjected to the attached Terms and conditions, the contents of which I have read and fully understood.
                            <br/>
                            2). I have read, consent and agree to the collection use and disclosure of my personal data for the purpose
                            listed and in accordance with the terms as set out in the attached customer Privacy Policy Statement and
                            Customer Personal Data Confirmation.
                            <br/>
                            3). This Purchase order serves aa a Tax Invoice if GST is charged.
                        </p>
                    </div>
                </div>
                <div class="space"></div>
                <table>
                    <tr>
                        <td>CERTIFICATE TO BE COLLECTED BY : </td>
                        <td>{{ $object->collected_by }}
                        </td>
                    </tr>
                </table>
                <div class="space"></div>

                <div class="section_title">Terms & Conditions</div>
                <div>
                    {{ $terms_condition->value }}
                </div>
                <div class="space"></div>

                <div>
                    <p>Agreed and Acknowledged by :</p>
                    <div id="box1" style="border:1px solid; width:180px">
                        <?php $signatures = json_decode($object->signatures, true);?>
                        <img src="<?php echo $signatures[1];?>" style="width:100px"/>
                    </div>

                </div>

                <table>
                    <tr>
                        <td>Name : </td>
                        <td>{{ $object->customer_name }}</td>
                    </tr>
                    <tr>
                        <td>Date : </td>
                        <td style="padding: 10px 0px;"><span id="date_signature">
                                <?php
                                if ($object->signature_date && $object->signature_date != "0000-00-00"):
                                    echo date("d/m/Y", strtotime($object->signature_date));
                                endif;
                                ?></span>
                            <input type="hidden" class="form-control" id="signature_date_1" name="signature_date_1" value="{{$object->signature_date_1}}"></td>
                    </tr>
                    <tr>
                        <td>Staff ID:</td>
                        <td>{{ $object->staff_id }}</td>
                    </tr>

                    <tr>
                        <td>Remarks:</td>
                        <td>{{ $object->remarks }}</td>
                    </tr>
                </table>

                <div class="space"></div>
            </div>
        </div>
    </form>

</div>


</body>
</html>
