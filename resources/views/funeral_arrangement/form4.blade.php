<form action="{{ URL::to('/fa/saveForm') }}"  id="info_frm" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="hidden" name="fa_id" id="fa_id" value="{{$object->id}}" />
    <input type="hidden" name="bttn_clicked" id="bttn_clicked" value="" />
    <input type="hidden" name="faid" id="faid" value="{{ $object->id }}" />
    <input type="hidden" name="step" id="step" value="{{$step}}" />
    <input type="hidden" name="new_email" id="new_email" value="" />
    <div id="fa_form" class="needs_exit_warning">
        <div id="number"></div>

        <div style="text-align:center">

            <table style="width:88%; margin-left:6%; margin-top: 40px">
                <tr>
                    <td colspan="5" style="text-align: right;">
                        <table style="float:right">
                            <tr>
                                <td>Sub-Total&nbsp; $ &nbsp;</td>
                                <td><input type="number" min="0.01" step="0.01" class="form-control" id="sub_total" name="sub_total" value="{{ number_format((float)$object->total_step_3, 2, '.', '') }}" /></td>
                            </tr>
                            @if ($object->miscellaneous &&  $object->miscellaneous != "special_discount")
                            <tr>
                                <td><span style="color: #CCC">Discount (%)&nbsp;</span></td>
                                <td><input type="number" min="0.01" step="0.01" class="form-control" id="discount" name="discount" value="{{ number_format((float)$object->miscellaneous, 2, '.', '') }}" readonly /></td>
                            </tr>
                            @endif
                            @if ($object->miscellaneous == "special_discount")
                            <tr>
                                <td><span style="color: #CCC">Special discount(approved by: {{$object->miscellaneous_approving_supervisor}})&nbsp;</span></td>
                                <td><input type="number" min="0.01" step="0.01" class="form-control" id="special_discount" name="special_discount" value="{{ number_format((float)$object->miscellaneous_amount, 2, '.', '') }}" /></td>
                            </tr>
                            @endif
                            <tr>
                                <td>Total&nbsp; $ &nbsp;</td>
                                <td><input type="number" min="0.01" step="0.01" class="form-control" id="final_total" name="final_total" value="{{ number_format((float)$object->final_total, 2, '.', '') }}" /></td>
                            </tr>
                            <tr>
                                <td>GST 7%&nbsp; $ &nbsp;</td>
                                <td><input type="number" min="0.01" step="0.01" class="form-control" id="gst_value" name="gst_value" value="{{ number_format((float)$object->gst_value, 2, '.', '') }}" /></td>
                            </tr>
                            <tr>
                                <td>Total with GST&nbsp; $ &nbsp;</td>
                                <td><input type="number" min="0.01" step="0.01" class="form-control" id="total_with_gst" name="total_with_gst" value="{{ number_format((float)$object->total_with_gst, 2, '.', '') }}" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="height: 100px">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5" style="height: 50px">
                        <table>
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
                                <td colspan="2" style="text-align: left;">
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
                    <td style="width: 200px; text-align: left;">Accepted and agreed</td>
                    <td style="width: 200px; text-align: left;">Accepted and agreed</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align: left; width: 300px;">
                        <div id="box1" style="text-align: left;">
                            @if ($object->signatures)
                                <?php $signatures = json_decode($object->signatures, true);?>
                                <img src="<?php echo $signatures[1];?>" style="width:100px"/>
                            @endif
                        </div>
                        <div class="signature_box" id="signature_box_1">
                            <div id="signature1" data-name="signature1" data-max-size="2048"
                                 data-pen-tickness="3" data-pen-color="black"
                                 class="sign-field"></div>
                            <input type="hidden" id="signature_image_1" name="signature_image_1" value="<?php echo isset($signatures[1])?$signatures[1]:'';?>" />
                            <button class="btn btn-primary" >Ok</button>

                        </div>
                    </td>
                    <td style="text-align: left; width: 300px;">
                        <div id="box2" style="text-align: left;">
                            @if ($object->signatures)
                                <img src="<?php echo $signatures[2];?>" style="width:100px"/>
                            @endif
                        </div>
                        <div class="signature_box" id="signature_box_2">
                            <div id="signature2" data-name="signature2" data-max-size="2048"
                                 data-pen-tickness="3" data-pen-color="black"
                                 class="sign-field"></div>
                            <input type="hidden" name="signature_image_2" id="signature_image_2" value="<?php echo isset($signatures[2])?$signatures[2]:'';?>" />
                            <button class="btn btn-primary" >Ok</button>

                        </div>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td style="text-align: left; width: 300px;">
                        Date:
                        <span id="date_signature_1"><?php
                            if ($object->signature_date && $object->signature_date != "0000-00-00"):
                                echo date("d/m/Y", strtotime($object->signature_date));
                            endif;
                            ?></span><input type="hidden" name="date_signature_1" id="input_date_signature_1" value="{{$object->signature_date}}" />
                    </td>
                    <td style="text-align: left; width: 300px;">
                        Date:
                        <span id="date_signature_2"><?php
                            if ($object->signature_date && $object->signature_date != "0000-00-00"):
                                echo date("d/m/Y", strtotime($object->signature_date));
                            endif;
                            ?></span><input type="hidden" name="date_signature_2" id="input_date_signature_2" value="{{$object->signature_date}}" />

                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align: left; width: 300px;">
                        Name  <input type="text" name="" id="" style="width: 150px;">

                    </td>
                    <td style="text-align: left; width: 300px;">
                        Name  <input type="text" name="" id="" style="width: 150px;">

                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5" style="height: 100px">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table style="width: 100%">
                            <tr>
                                <td><input type="button" value="SUBMIT" id="submit_bttn" /></td>
                                <td><input type="button" value="SUBMIT & E-mail" id="submit_email_bttn" /><br style="line-height:30px" /><input type="button" value="SUBMIT & E-mail (other e-mail)"   id="submit_other_email_bttn" /></td>
                                <td><input type="button" value="SUBMIT & Print" id="submit_print_bttn" /></td>

                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="height: 100px;"></td>
                </tr>
                <tr>
                    <td style="text-align: left">
                        <input type="hidden" id="go_to_step" name="go_to_step" value="" />
                        <a class="btn btn-primary" id="back_button" /><i class="fa fa-backward"></i> &nbsp;Previous</a>
                    </td>
                    <td colspan="5" style="height: 100px; text-align: right" ><span id="autosave_msg">Autosaved at <?php echo date("d-m-Y H:i:s", strtotime($object->updated_at))?></span></td>
                </tr>
            </table>
            <br />

            <br />
            <br />
        </div>
    </div>

</form>

<input type="hidden" name ="coffin_price_4" value = "{{$coffin_price}}"  />
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
                    <input type="text" id="popup_new_email" value="" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="popup_send_bttn">SEND</button>
            </div>

        </div>
    </div>
</div>