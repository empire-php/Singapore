<?php

/* 
 * Parlour Form
 * 
 */
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Parlour</title>
        <style>
            body, table, td{
                margin:0px; padding: 0px;
            }
            
            body{
                font-size: 15px;
                line-height: 19px;
                font-family: "Times New Roman", Georgia, Serif;
            }
            .page-break {
                page-break-after: always;
            }
            .form{
                width:680px;
                margin-left:20px;
            }
            .title{
                text-align: center;
                font-size: 16px;
                font-weight: bold;
            }
            
            .box_form_title {
                border: 1px solid #000;
                text-align: center;
                padding: 5px;
                width: 100px;
                font-weight: normal;
                font-size:12px;
            }
            .field_to_be_completed{
                border-bottom: 1px solid #000;
                padding-left: 10px;
                padding-right: 10px;
            }
            .section{
                font-weight: bold;
                font-size: 17px;
            }
            .table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
            }
            table {
                border-collapse: collapse;
                border-spacing: 0;
            }
            thead {
                display: table-header-group;
                vertical-align: middle;
                border-color: inherit;
            }
            .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
                border: 1px solid #e0e7e8;
            }
            td, th{
                padding: 5px;
            }
            .footer_tbl td{
                padding: 0px;
            }
        </style>
    </head>
    <body>
        
        <table class="form">  
            <tr>
                <td style="border-bottom: 3px solid #000; text-align:center; height: 50px; font-size: 20px; font-weight: bold">
                  SINGAPORE CASKET COMPANY PRIVATE LIMITED
                </td>
            </tr>
            <tr>
                <td style="height: 50px;">
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                  <span style="font-size: 17px; font-weight: bold; text-decoration: underline;">Agreement on Funeral Parlor at the premises of Singapore Casket</span>
                  <br /><br />
                  <table class="table table-bordered">
                    <tr>
                      <td>Parlor</td>
                      <td colspan="3"><?php echo (isset($parlours) && isset($parlours[0]))?$parlours[0]["parlour_name"]:""?></td>
                    </tr>
                    <tr>
                      <td>Deceased Name</td>
                      <td colspan="3">{{ $object->deceased_name }}</td>
                    </tr>
                    <tr>
                      <td>Period From</td>
                      <td>
                            <?php 
                            if (isset($parlours) && isset($parlours[0]["parlour_date_from"])){
                              $arr_from = explode(" ",$parlours[0]["parlour_date_from"]);
                              echo $arr_from[0];
                            }
                           ?>
                      </td>
                      <td> To </td>
                      <td>
                          <?php 
                            if (isset($parlours) && isset($parlours[0]["parlour_date_to"])){
                              $arr_from = explode(" ",$parlours[0]["parlour_date_to"]);
                              echo $arr_to[0];
                            }
                           ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Time In</td>
                      <td><?php echo (isset($arr_from[1]))?$arr_from[1]:""?></td>
                      <td> Time Out: </td>
                      <td><?php echo (isset($arr_to[1]))?$arr_to[1]:""?></td>
                    </tr>
                    <tr>
                      <td>Rate Per Hours</td>
                      <td>$<?php echo (isset($parlours) && isset($parlours[0]["parlour_unit_price"]))?$parlours[0]["parlour_unit_price"]:""?></td>
                      <td>No. of Hours</td>
                      <td><?php echo (isset($parlours) && isset($parlours[0]["parlour_hours"]))?$parlours[0]["parlour_hours"]:""?></td>
                    </tr>
                    <tr>
                      <td>Total Amount</td>
                      <td colspan="3">$<?php echo (isset($parlours) && isset($parlours[0]["parlour_total_price"]))?$parlours[0]["parlour_total_price"]:""?></td>
                    </tr>
                  </table>
                </td>
            </tr>
            <tr>
                <td>
                  Terms and Conditions on the usage of the Funeral Parlors:
                  
                  <ol>
                    <li><span style="font-weight: bold">The parlor charge is on daily basis rate regardless of time in or time out.</span></li>
                    <li>I / we agree to rent and settle the total rental cost of the funeral parlor at Singapore Casket according to the terms stipulated in the Funeral Arrangement Form.</li>
                    <li>I / we agree that I am / we are not allowed to extend the usage of the parlor once the funeral's date and time is fixed and confirmed. I / we will also not allow my / our family members and guests to utilize the parlor for any gathering after the funeral.</li>
                    <li>As soon as the coffin left the parlor, I / we will not be allowed to utilize the parlor and Singapore Casket reserves the right to rent out the parlor thereafter.</li>
                    <li>I / we agree to keep the furniture, sofa, TV, keyboard, fixtures, sanitary wares and electrical equipment in good condition throughout the rental period and agree to compensate for any damages on the abovementioned items caused by my / our negligence. THe said items may not be available in all parlors. Damage, herein refer to fire caused incident, e.g. burning of candless, joss paper and joss sticks.</li>
                    <li>I / we understand that is my / our responsability to safe guard my / our belonging and valuables. I / we will not hold Singapore Casket's responsability for any loss of my / out belonging and valuables and any mishaps.</li>
                    <li>I am / we are <span style="font-weight: bold; text-decoration: underline">NOT ALLOWED</span> to engage any outside caterer and supplier that provide food, drinks, groundnuts, melon seeds, sweets, other tidbits, paper plates and fridge. Only Singapore Casket's appointed caterers and suppliers are allowed to provide such services.</li>
                    <li>I / we agree NOT to bring in any metal panel setup or back drop to be displayed in the parlor ( e.g. Kuan Peng, Sian Tng ). This is only applicable for Budisht and Taoist</li>
                    <li>There will be an additional charge for disposal of flower wreaths which exceeds 20 units.</li>
                    <li>I / we understand that Amber, Silver and Diamond Rooms are NOT allowed to burn joss paper in the said parlors.</li>
                  </ol>
                </td>
            </tr>
            <tr>
                <td style="height: 5px;"></td>
            </tr>
            <tr>
                <td style="font-size: 12px; border-top: 1px solid #000">
                    <table class="footer_tbl" style="width: 100%">
                        <tr><td colspan="2">Agreement on Funeral Parlor at the premises of Singapore Casket</td></tr>
                        <tr><td>Updated on 9th March 2011</td><td style="text-align: right">Page 1</td></tr>
                    </table>
                </td>
            </tr>
            </table>
            
            
            <div class="page-break"></div>
            
            
            
            <table class="form">  
                <tr>
                    <td style="border-bottom: 3px solid #000; text-align:center; height: 50px; font-size: 20px; font-weight: bold">
                      SINGAPORE CASKET COMPANY PRIVATE LIMITED
                    </td>
                </tr>
                <tr>
                    <td style="height: 50px;">
                    </td>
                </tr>
                <tr>
                  <td>
                    <ol start="11">
                      <li>Parlors' cleaning time starts at 8:30am.</li>
                      <li>All the parlors are furnished with a contribution box which provides convenient to the bereaved family to collect condolences money. However, bereaved family MUST clear all contributions from the box daily before they leave the parlor. Singapore Casket will not hold the responsibility for any loss of the condolences money and valuable items that found lost in the parlor.</li>
                      <li>There will be a charge of $180 for any damage or broken of the contribution box.</li>
                      <li>Bereaved family member should prepare a lock to lock up the contribution box and ensure to take back the lock before they leave on the funeral day.</li>
                      <li>Singapore Casket reserves the right to amend the terms and conditions of the usage of the parlors without prior notice.</li>
                    </ol>
                  </td>
                </tr>
                <tr>
                  <td>
                    I  we <span style="text-decoration: underline">&nbsp;{{ $object->first_cp_name }}&nbsp;</span> hereby declare that I / we have read, agreed and accepted on the above mentioned terms and conditions. I / we agree to compensate Singapore Casket in full for all the services rendered and any damages caused (if any).
                    <br />
                    <br />
                    Contact Person: <span style="text-decoration:underline">&nbsp;{{ $object->first_cp_name }}&nbsp;</span>, Mobile Phone: <span style="text-decoration:underline">&nbsp;{{ $object->first_cp_mobile_nr }}&nbsp;</span>
                    <br />
                    Signature: <span style="text-decoration:underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> NRIC <span style="text-decoration:underline">&nbsp;{{ $object->first_cp_nric }}&nbsp;</span> Data: <span style="text-decoration:underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <br /><br /><br /><br />
                    Witnessed by Singapore Casket's staff <span style="text-decoration:underline">&nbsp;{{$object->user->name}}&nbsp;</span> Date: <span style="text-decoration:underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    
                    <br /><br /><br /><br />
                    Remarks:<br />
                    
                    <div style="width: 100%; border-bottom: 1px solid #000; height: 25px">&nbsp;</div>
                    <div style="width: 100%; border-bottom: 1px solid #000; height: 25px">&nbsp;</div>
                    <div style="width: 100%; border-bottom: 1px solid #000; height: 25px">&nbsp;</div>
                    <div style="width: 100%; border-bottom: 1px solid #000; height: 25px">&nbsp;</div>
                    
                  </td>
                </tr>
                <tr>
                    <td style="height: 155px;"></td>
                </tr>
                <tr>
                    <td style="font-size: 12px; border-top: 1px solid #000">
                        <table class="footer_tbl" style="width: 100%">
                            <tr><td colspan="2">Agreement on Funeral Parlor at the premises of Singapore Casket</td></tr>
                            <tr><td>Updated on 9th March 2011</td><td style="text-align: right">Page 2</td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            
      
        
        
    </body>
</html>