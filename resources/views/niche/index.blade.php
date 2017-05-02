@extends('layouts.app')
@section('content')

    <?php if ($session->get("niche_msg")):?>
    <script type="text/javascript">
        var saveMessage = '<?php echo implode("<br />", $session->get("niche_msg"))?>';
        var openPdf = <?php echo ($session->get("niche_" . $object->id . "_open_pdf") == 1) ? "true" : "false"?>;
    </script>
    <?php $session->set("niche_msg", null); $session->set("niche_" . $object->id . "_open_pdf", null);?>
    <?php endif; ?>

    <style>
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
        <h3>
            Purchase order - Niche
        </h3>

        <form action="{{ URL::to('/niche/save') }}" class="master_form needs_exit_warning" id="info_frm" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <input type="hidden" name="order_id" id="order_id" value="{{ $object->id }}" />
            <input type="hidden" name="is_draft" id="is_draft" value="{{ $object->is_draft }}" />
            {{--<input type="hidden" name="order_type" id="order_type" value="{{ $type }}" />--}}
            <input type="hidden" name="changes_made" id="changes_made" value="" />
            <input type="hidden" name="niche_cell_id" id="niche_cell_id" value="" />

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
                                <td><input type="text" class="form-control" id="fa_code" name="fa_code" value="{{ ($object->funeral_arrangement_id)?$object->funeralArrangement->generated_code:"" }}" />
                                    <input type="hidden" id="fa_id" name="fa_id" value="{{($object->funeral_arrangement_id)?$object->funeral_arrangement_id:""}}"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Order No:</td>
                                <td><input type="text" disabled="disabled" class="form-control" name="order_nr" id="order_nr" value="{{ $object->order_nr}}"/></td>
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
                            <td><input type="text" class="form-control" id="first_cp_name" name="first_cp_name" value="{{$object->first_cp_name}}" /></td>
                            <td>NRIC:</td>
                            <td><input type="text" class="form-control" id="first_cp_nric" name="first_cp_nric" value="{{$object->first_cp_nric}}"/></td>
                        </tr>
                        <tr>
                            <td>Nationality:</td>
                            <td>
                                <select name="race" style="width: 170px;" class="form-control">
                                    <option></option>
                                    @foreach($raceOptions as $raceOp)
                                        <option value="{{$raceOp->id}}" @if ($raceOp->id == $object->race) selected="true" @endif >{{$raceOp->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>Gender:</td>
                            <td><input type="text" class="form-control" id="sex" name="sex" value="{{$object->sex}}"/></td>
                        </tr>
                        <tr>
                            <td>Date of Birth:</td>
                            <td><input type="text" class="form-control" id="first_cp_birthdate" name="first_cp_birthdate" value="{{$object->first_cp_birthdate}}"/></td>
                            <td>Address:</td>
                            <td><input type="text" class="form-control" id="first_cp_address" name="first_cp_address" value="{{$object->first_cp_address}}"/></td>
                        </tr>
                        <tr>
                            <td>Postal Code:</td>
                            <td><input type="text" class="form-control" id="first_cp_postal_code" name="first_cp_postal_code" value="{{$object->first_cp_postal_code}}"/></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Home Number:</td>
                            <td><input type="text" class="form-control" id="first_cp_home" name="first_cp_home" value="{{$object->first_cp_home}}"/></td>
                            <td>Mobile Number:</td>
                            <td><input type="text" class="form-control" id="first_cp_mobile" name="first_cp_mobile" value="{{$object->first_cp_mobile}}"/></td>
                        </tr>
                        <tr>
                            <td>Office Number :</td>
                            <td><input type="text" class="form-control" id="first_cp_office" name="first_cp_office" value="{{$object->first_cp_office}}"/></td>
                            <td>Email:</td>
                            <td><input type="text" class="form-control" id="first_cp_email" name="first_cp_email" value="{{$object->first_cp_email}}"/></td>
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
                            <td><input type="text" class="form-control" id="deceased_name" name="deceased_name" value="{{$object->deceased_name}}"/></td>
                            <td>Name:</td>
                            <td><input type="text" class="form-control" id="second_deceased_name" name="second_deceased_name" value="{{$object->second_deceased_name}}"/></td>
                        </tr>
                        <tr>
                            <td>NRIC:</td>
                            <td><input type="text" class="form-control" id="deceased_nric" name="deceased_nric" value="{{$object->deceased_nric}}"/></td>
                            <td>NRIC:</td>
                            <td><input type="text" class="form-control" id="second_deceased_nric" name="second_deceased_nric" value="{{$object->second_deceased_nric}}"/></td>
                        </tr>
                        <tr>
                            <td>Relationship:</td>
                            <td><input type="text" class="form-control" id="relationship" name="relationship" value="{{$object->relationship}}"/></td>
                            <td>Relationship:</td>
                            <td><input type="text" class="form-control" id="second_relationship" name="second_relationship" value="{{$object->second_relationship}}"/></td>
                        </tr>
                        <tr><td colspan="4" style="height: 20px;"></td></tr>
                        <tr>
                            <td>upload file(s)</td>
                            <td colspan="3">
                                <input type="file" name='files[]' multiple="multiple" />
                            </td>

                        </tr>
                    </table>

                    <div class="space"></div>

                    <div class="section_title" style="width: 100%;">Particulars of the Niche to which this Licence Relates</div>
                    <div class="section">
                        <div class="printable">
                            <div class="row"><!--- Select box ---->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="block">Block  </label>
                                        <div class="col-sm-10">
                                            <select name="niche_block_id" id="niche_block_id" class="form-control" style="min-width: 200px; width:auto;">
                                                <option>[Select Block]</option>
                                                @if($blocks)
                                                    @foreach($blocks as $block)
                                                        <option value="{{$block->id}}" @if ($block->id == $object->niche_block_id) selected="true" @endif >{{ $block->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="suite">Suite </label>
                                        <div class="col-sm-10">
                                            <select name="niche_suite_id" id="niche_suite_id" class="form-control" style="min-width: 200px; width:auto;">
                                                <option>[Select Suite]</option>
                                                @if ($object->niche_suite_id)
                                                    <?php
                                                        $suite = App\NicheSuite::find($object->niche_suite_id);
                                                    ?>
                                                    <option value="{{ $object->niche_suite_id }}" selected="true">{{ $suite->name }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="section">Section </label>
                                        <div class="col-sm-10">
                                            <select name="niche_section_id" id="niche_section_id" class="form-control" style="min-width: 200px; width:auto;">
                                                <option>[Select Section]</option>
                                                @if ($object->niche_section_id)
                                                    <?php
                                                    $section = App\NicheSection::find($object->niche_section_id);
                                                    ?>
                                                    <option value="{{ $object->niche_section_id }}" selected="true">{{ $section->name }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-12" style="padding-top: 20px;text-align: center; " id="niche_table">
                                    <div style="text-align: center" id="help">
                                        @if ($object->niche_section_id)
                                            <?php $rows = App\NicheRow::where('niche_section_id', $object->niche_section_id)->count(); $rowspan = $rows + 1;?>
                                            <?php $leftColumns = App\NicheColumn::where('niche_section_id', $object->niche_section_id)->where('side', 'left')->count(); ?>
                                            <?php $rightColumns = App\NicheColumn::where('niche_section_id', $object->niche_section_id)->where('side', 'right')->count(); ?>
                                            <?php $columns = $leftColumns + $rightColumns; ?>

                                            @if($rows > 0)
                                                <table class="table table-bordered suite-table" id="suiteTable" style="width: 100%;">
                                                    <tr>
                                                        <td></td>
                                                        @if($leftColumns > 0)
                                                            <?php $left_columns = App\NicheColumn::where('niche_section_id', $object->niche_section_id)->where('side', 'left')->orderby('sort_order')->get(); ?>
                                                            @foreach($left_columns as $left_column)
                                                                <td side="left">{{ $left_column->name }}</td>
                                                            @endforeach
                                                        @else
                                                            <td side="left" style="display: none;"></td>
                                                        @endif

                                                        <?php if($rows == 0) $rowspan = 2; else $rowspan=$rowspan+1; ?>
                                                        <td align="center" class="border-td" rowspan="{{$rowspan}}" style="width: 30px;vertical-align:middle;" id="entrance">Entrance</td>

                                                        @if($rightColumns > 0)
                                                            <?php $right_columns = App\NicheColumn::where('niche_section_id', $object->niche_section_id)->where('side', 'right')->orderby('sort_order','desc')->get(); ?>
                                                            @foreach($right_columns as $right_column)
                                                                <td side="right">{{ $right_column->name }}</td>
                                                            @endforeach
                                                        @else
                                                            <td side="right" style="display:none;"></td>
                                                        @endif
                                                        <td></td>
                                                    </tr>

                                                    <?php $rrows = App\NicheRow::where('niche_section_id', $object->niche_section_id)->orderby('sort_order')->get(); ?>

                                                    @foreach($rrows as $row)
                                                        <tr rowid="{{ $row->id }}">
                                                            <td>{{ $row->name }}</td>
                                                            @if($leftColumns > 0)
                                                                <?php $left_columns = App\NicheColumn::where('niche_section_id', $object->niche_section_id)->where('side', 'left')->orderby('sort_order')->get(); ?>
                                                                @foreach($left_columns as $left_column)
                                                                    <?php $cell = App\NicheCell::where('niche_row_id', $row->id)->where('niche_column_id', $left_column->id)->first(); ?>
                                                                    @if($cell)
                                                                        <?php
                                                                        if($cell->status == 0){
                                                                            $style = "background-color:#92cf51;";
                                                                            $class = "selectable";
                                                                        }

                                                                        if($cell->status == 1) {
                                                                            $class = "selectable";
                                                                            $style = "background-color:#fff;";
                                                                        }

                                                                        if($cell->status == 2) {
                                                                            $class = "";
                                                                            $style = "background-color:yellow;";
                                                                        }
                                                                        if($cell->status == 3){
                                                                            $class = "";
                                                                            $style = "background-color:#abb8ca;";
                                                                        }
                                                                        ?>
                                                                        <td class="border-td re-editable {{ $class }}" columnid="{{$left_column->id}}" cellid="{{ $cell->id }}" side="left" id="td_{{$row->id}}_{{$left_column->id}}" style="{{ $style }}">{{ $cell->name }} @if($cell->customer_name)[{{ $cell->customer_name }}]@endif </td>
                                                                    @else
                                                                        <td class="border-td editable" columnid="{{$left_column->id}}"  id="td_{{$row->id}}_{{$left_column->id}}" side="left"></td>
                                                                    @endif

                                                                @endforeach
                                                            @else
                                                                <td side="left" class="border-td editable" style="display:none"></td>
                                                            @endif

                                                            @if($rightColumns > 0)
                                                                <?php $right_columns = App\NicheColumn::where('niche_section_id', $object->niche_section_id)->where('side', 'right')->orderby('sort_order','desc')->get(); ?>

                                                                @foreach($right_columns as $right_column)
                                                                    <?php $cell = App\NicheCell::where('niche_row_id', $row->id)->where('niche_column_id', $right_column->id)->first(); ?>
                                                                    @if($cell)
                                                                        <?php
                                                                        if($cell->status == 0){
                                                                            $style = "background-color:#92cf51;";
                                                                            $class = "selectable";
                                                                        }

                                                                        if($cell->status == 1) {
                                                                            $class = "selectable";
                                                                            $style = "background-color:#fff;";
                                                                        }

                                                                        if($cell->status == 2) {
                                                                            $class = "";
                                                                            $style = "background-color:yellow;";
                                                                        }
                                                                        if($cell->status == 3){
                                                                            $class = "";
                                                                            $style = "background-color:#abb8ca;";
                                                                        }

                                                                        ?>
                                                                        <td class="border-td re-editable {{ $class }}" columnid="{{$right_column->id}}" cellid="{{ $cell->id }}" side="right" id="td_{{$row->id}}_{{$right_column->id}}" style="{{ $style }}">{{ $cell->name }}@if($cell->customer_name)[{{ $cell->customer_name }}]@endif</td>
                                                                    @else
                                                                        <td class="border-td editable" columnid="{{$right_column->id}}" id="td_{{$row->id}}_{{$right_column->id}}" side="right"></td>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <td side="right" class="border-td editable" style="display: none;"></td>
                                                            @endif
                                                            <td>{{ $row->name }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            @else
                                                <table class="table table-bordered suite-table">
                                                    <tr>
                                                        <td></td>
                                                        @if($leftColumns > 0)
                                                            <?php $left_columns = App\NicheColumn::where('niche_section_id', $object->niche_section_id)->where('side', 'left')->orderby('sort_order')->get(); ?>
                                                            @foreach($left_columns as $left_column)
                                                                <td columnid="{{ $left_column->id }}" side="left">{{ $left_column->name }}</td>
                                                            @endforeach
                                                        @else
                                                            <td side="left" style="display: none;"></td>
                                                        @endif

                                                        <?php if($rows == 0) $rowspan = 2; else $rowspan = $rowspan+1; ?>
                                                        <td align="center" class="border-td" rowspan="{{$rowspan}}" style="width: 30px;vertical-align:middle;" id="entrance">Entrance</td>

                                                        @if($rightColumns > 0)
                                                            <?php $right_columns = App\NicheColumn::where('niche_section_id', $object->niche_section_id)->where('side', 'right')->orderby('sort_order','desc')->get(); ?>

                                                            @foreach($right_columns as $right_column)
                                                                <td columnid="{{ $right_column->id }}" side="right">{{ $right_column->name }}</td>
                                                            @endforeach
                                                        @else
                                                            <td side="right" style="display:none;"></td>
                                                        @endif
                                                        <td></td>
                                                    </tr>
                                                    <tr style="display: none;">
                                                        <td></td>
                                                        @if($leftColumns > 0)
                                                            @for($i=0; $i<$leftColumns; $i++)
                                                                <td side="left" class="border-td"></td>
                                                            @endfor
                                                        @else
                                                            <td side="left" class="border-td"></td>
                                                        @endif
                                                        @if($rightColumns > 0)
                                                            @for($i=0; $i<$leftColumns; $i++)
                                                                <td side="right" class="border-td"></td>
                                                            @endfor
                                                        @else
                                                            <td side="right" class="border-td"></td>
                                                        @endif
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            @endif
                                        @else
                                            <h5>Select a section, please.</h5>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="padding-top: 20px;">
                                <table class="table table-bordered" id="legend_table" style="width:300px;">
                                    <tbody>
                                    <tr><td style="min-height: 30px; font-size:14px;" colspan="2">Legend</td></tr>
                                    <tr><td style="width:100px; background: yellow; height:30px;">&nbsp;</td><td>Not Avail</td></tr>
                                    <tr><td style="width:100px;background: #fff; height:30px;">&nbsp;</td><td>Avail</td></tr>
                                    <tr><td style="width:100px;background: #92cf51; height:30px;">&nbsp;</td><td>On Hold</td></tr>
                                    <tr><td style="width:100px;background: #abb8ca; height:30px;">&nbsp;</td><td>Future Development</td></tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
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
                                <td class="border-td"><input type="text" class="form-control" style="width: 100%;" name="columbarium" id="columbarium" value="{{$object->columbarium}}"> </td>
                                <td class="border-td"><input type="text" class="form-control" style="width: 100%;" name="suite_nr" id="suite_nr" value="{{$object->suite_nr}}"></td>
                                <td class="border-td"><input type="text" class="form-control" style="width: 100%;" name="section_nr" id="section_nr" value="{{$object->section_nr}}"></td>
                                <td class="border-td"><input type="text" class="form-control" style="width: 100%;" name="level" id="level" value="{{$object->level}}"></td>
                                <td class="border-td"><input type="text" class="form-control" style="width: 100%;" name="compartment" id="compartment" value="{{$object->compartment}}"></td>
                                <td class="border-td"><input type="text" class="form-control" style="width: 100%;" name="unit" id="unit" value="{{$object->unit}}"></td>
                                <td class="border-td"><input type="text" class="form-control" style="width: 100%;" name="unit_type" id="unit_type" value="{{$object->unit_type}}"></td>
                            </tr>
                        </table>

                    <div class="space"></div>

                    <div class="section_title">Niche Purchase Price(Total)</div>
                    <div class="row">
                        <div class="col-md-5">
                            <table style="width: 80%;">
                                <tr>
                                    <td width="25%">Niche Price:</td>
                                    <td width="75%"><input type="number" step="0.01" class="form-control" id="niche_price" name="niche_price" value="{{$object->niche_price}}"></td>
                                </tr>
                                <tr>
                                    <td>Maintenance Fee:</td>
                                    <td><input type="number" step="0.01" class="form-control" id="maintenance_fee" name="maintenance_fee" value="{{$object->maintenance_fee}}"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Others:</td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control" id="other_text" name="other_text" style="width: 80%" value="{{$object->other_text}}"></td>
                                    <td><input type="number" step="0.01" class="form-control" id="other_price" name="other_price" value="{{$object->other_price}}"></td>
                                </tr>
                                <tr>
                                    <td>GST</td>
                                    <td><input type="number" class="form-control" id="gst" name="gst" value="{{$object->gst}}"></td>
                                </tr>
                                <tr>
                                    <td>Total:</td>
                                    <td><input type="number" class="form-control" id="total_price" name="total_price" value="{{$object->total_price}}"></td>
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
                            <td>
                                <select class="form-control" name="collected_by" id="collected_by">
                                    <option value="Purchaser" @if($object->collected_by == "Purchaser") selected="true" @endif>Purchaser</option>
                                    <option value="Authorised" @if($object->collected_by == "Authorised") selected="true" @endif>Authorised</option>
                                    <option value="Mail" @if($object->collected_by == "Mail") selected="true" @endif>Mail</option>
                                    <option value="Ets" @if($object->collected_by == "Ets") selected="true" @endif>Ets</option>
                                </select>
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
                        <div id="box1" >
                            @if ($object->signatures)
                                <?php $signatures = json_decode($object->signatures, true);?>
                                <img src="<?php echo $signatures[1];?>" style="width:100px"/>
                            @endif
                        </div>
                        <div class="signature_box" id="signature_box_1">
                            <div id="signature1" data-name="signature1" data-max-size="2048"
                                 data-pen-tickness="3" data-pen-color="black"
                                 class="sign-field"></div>
                            <input type="hidden" id="signature_image_1" name="signature_image_1" value="<?php echo (isset($signatures))?$signatures[1]:'';?>" />
                            <button class="btn btn-primary" >Ok</button>

                        </div>
                    </div>

                    <table>
                        <tr>
                            <td>Name : </td>
                            <td><input type="text" class="form-control" id="customer_name" name="customer_name" value="{{$object->customer_name}}"></td>
                        </tr>
                        <tr>
                            <td>Date : </td>
                            <td style="padding: 10px 0px;">
                                <span id="date_signature_1"><?php
                                    if ($object->signature_date && $object->signature_date != "0000-00-00"):
                                        echo date("d/m/Y", strtotime($object->signature_date));
                                    endif;
                                    ?>
                                </span>
                                <input type="hidden" name="date_signature_1" id="input_date_signature_1" value="{{$object->signature_date}}" />
                            </td>
                        </tr>
                        <tr>
                            <td>Staff ID:</td>
                            <td><input type="text" class="form-control" id="staff_id" name="staff_id" value="{{$object->staff_id}}"></td>
                        </tr>

                        <tr>
                            <td>Remarks:</td>
                            <td><input type="text" class="form-control" id="remarks" name="remarks" value="{{$object->remarks}}"></td>
                        </tr>
                    </table>

                    <div class="space"></div>

                    <div style="text-align: center; width: 100%">
                        <table style="margin-left: 22%;">
                            <tr>
                                <td><input type="button" value="SUBMIT" id="submit_bttn"/></td>
                                <td><input type="button" value="SUBMIT & E-mail" id="submit_email_bttn" style="width:200px"/></td>
                                <td><input type="button" value="SUBMIT & Print" id="submit_print_bttn"/></td>
                            </tr>
                        </table>
                    </div>

                    <div class="space"></div>
                </div>
            </div>
        </form>

    <div class="modal fade" id="box_other_email" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">E-mail address requested</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="inputWarning1">E-mail address</label>
                        <input type="text" id="popup_new_email" value="" class="form-control"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="popup_send_bttn">SEND</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="cell_popup" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cell Information</h4>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="row_text" id="row_text" />
                    <input type="hidden" name="column_text" id="column_text" />
                    <input type="hidden" name="cell_id" id="cell_id" />
                    <input type="hidden" name="customer" id="customer" />
                    <input type="hidden" name="previous_cell" id="previous_cell" />

                    <div class="form-group">
                        <label class="control-label" for="cell_name">Name</label>
                        <input type="text" name="cell_name" id="cell_name" value="" class="form-control" maxlength="30"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="cell_description">Description</label>
                        <textarea name="cell_description" id="cell_description" class="form-control" maxlength="100"/></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="selling_price">Selling Price</label>
                        <input type="number" name="selling_price" id="selling_price" step='0.01' placeholder='0.00' class="form-control"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="maintenance_fee">Maintenance Fees</label>
                        <input type="number" name="m_fee" id="m_fee" step='0.01' placeholder='0.00' class="form-control"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="cell_type">Type</label>
                        <input type="text" name="cell_type" id="cell_type" value="" class="form-control" maxlength="30"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary submit_btn" id="select_cell">Select</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view_all_images_for_product" tabindex="-1" role="dialog" style="z-index:22222">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 700px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Detail View</h4>
                </div>

                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="all_image_view_close">Close</button>
                    <!--   <button type="button" class="btn btn-primary" id="save_general_bttn">Save</button> -->
                </div>

            </div>
        </div>
    </div>
@endsection


@push('css')
<link href="/css/app/scc_care.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="/js/vendor/jquery.signfield-master/js/sketch.min.js"></script>
<script src="/js/vendor/jquery.signfield-master/js/jquery.signfield.min.js"></script>
<script src="/js/vendor/core/jquery-ui/autocomplete.js"></script>
<script src="/js/app/scc_care.js"></script>
<script src="/js/app/general_form.js"></script>
<script type="text/javascript">
    $(document).ready(function () {


        $('#niche_block_id').change(function(e){
            e.preventDefault();
            if(this.value) {
                $.get('/holdniche/suites/' + this.value + '/suites.json', function(suites)
                {
                    var $suite = $('#niche_suite_id');

                    $suite.find('option').remove().end();
                    $suite.append('<option value="">[Select Suite]</option>');
                    $.each(suites, function(index, suite) {
                        $suite.append('<option value="' + suite.id + '">' + suite.name + '</option>');
                    });
                });
            }

        });

        $('#niche_suite_id').change(function(e){
            e.preventDefault();
            if(this.value) {
                $.get('/holdniche/sections/' + this.value + '/sections.json', function (sections) {
                    var $section = $('#niche_section_id');

                    $section.find('option').remove().end();
                    $section.append('<option value="">[Select Section]</option>');
                    $.each(sections, function (index, section) {
                        $section.append('<option value="' + section.id + '">' + section.name + '</option>');
                    });
                });
            }
        });

        $('#niche_section_id').change(function(e){
            e.preventDefault();
            if(this.value) {
                //
                $.ajax({
                    url: "{{ url('')}}/holdniche/index",
                    method: "POST",
                    data: {
                        section_id: this.value,
                        "_token": "{{ csrf_token() }}",
                    },
                    statusCode: {
                        401: function () {
                            alert("Login expired. Please sign in again.");
                        }
                    }
                }).done(function (html) {
                    $('#niche_table').html(html);
                });
            }
        });

        //Edit Cell information
        $('body').on("click",".selectable", function(e){
            e.preventDefault();
            var columnText = $(this).closest("tr").find("td:first-child").html();
            var td_index = $(this).index();
            var side = $(this).attr('side');
            if(side == "right")
                td_index += 2;
            else
                td_index ++;

            var rowText =$(this).closest('table').find('tr:first').find('td:nth-child('+td_index+')').html();

            var cell_id = $(this).attr('cellid');
            $.ajax({
                url: "{{ url('')}}/settings/read_niche_cell",
                method: "POST",
                data: {
                    cell_id: cell_id,
                    "_token": "{{ csrf_token() }}",
                },
                statusCode: {
                    401: function () {
                        alert("Login expired. Please sign in again.");
                    }
                }
            }).done(function (cell) {
                $('#cell_id').val(cell.id);
                $('#cell_name').val(cell.name);
                $('#cell_description').val(cell.description);
                $('#selling_price').val(cell.selling_price);
                $('#m_fee').val(cell.maintenance_fee);
                $('#cell_type').val(cell.type);
                $('#row_text').val(rowText);
                $('#column_text').val(columnText);
                $('#customer').val(cell.customer_name);
                $('#cell_popup').modal();
            });
        });

        $('#select_cell').on("click", function (e) {
            e.preventDefault();

            var columbarium = $("#niche_block_id option:selected").text();
            var suite_nr = $("#niche_suite_id option:selected").text();
            var section_nr = $("#niche_section_id option:selected").text();
            var level = $('#row_text').val();
            var compartment = $('#column_text').val();
            var unit = $('#cell_name').val();
            var unit_type = $('#cell_type').val();
            var niche_price = $('#selling_price').val();
            var fee = $('#m_fee').val();
            var customer = $('#customer').val();
            var cell = $('#cell_id').val();

            var previous_cell = $('#previous_cell').val();

            $('#columbarium').val(columbarium);
            $('#suite_nr').val(suite_nr);
            $('#section_nr').val(section_nr);
            $('#level').val(level);
            $('#compartment').val(compartment);
            $('#unit').val(unit);
            $('#unit_type').val(unit_type);

            $('#customer_name').val(customer);

            $('#niche_cell_id').val(cell);

            $('#niche_price').val(parseFloat(niche_price).toFixed(2));
            $('#maintenance_fee').val(parseFloat(fee).toFixed(2));

            var other_price = $('#other_price').val();

            if(!other_price)
                other_price = 0;

            var gst;

            gst = ((parseFloat(niche_price) + parseFloat(fee) + parseFloat(other_price) ) * 7 / 100).toFixed(2);

            var total = (parseFloat(niche_price) + parseFloat(fee) + parseFloat(other_price) + parseFloat(gst)).toFixed(2);

            $('#gst').val(gst);
            $('#total_price').val(total);

            //set disable to select other sell
            $('.suite-table').find('td').each(function(){
                if($(this).attr('cellid') == cell) {
                    $(this).css('background-color', 'yellow');
                }
                if($(this).attr('cellid') == previous_cell) {
                    $(this).css('background-color', '#fff');
                }
            });

            //save previous cell
            $('#previous_cell').val(cell);

            $('#cell_popup').modal('hide');

        });

        $("#other_price").keyup(function(){
            var niche_price = $('#niche_price').val();
            var fee = $('#maintenance_fee').val();
            var gst;
            var other_price = $(this).val()

            gst = ((parseFloat(niche_price) + parseFloat(fee) + parseFloat(other_price) ) * 7 / 100).toFixed(2);
            var total = (parseFloat(niche_price) + parseFloat(fee) + parseFloat(other_price) + parseFloat(gst)).toFixed(2);
            $('#total_price').val(total);
            $('#gst').val(gst);
        });
    });
</script>
@endpush