<?php

/* 
 * Letter of authorisation
 */

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Declaration on Embalming</title>
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
            
            
            
            .list_td_check {
                border: 1px solid #000;
                font-size: 12px;
                width: 20px;
            }
            .list_td {
                border-top: 1px solid #000;
                border-bottom: 1px solid #000;
                font-size: 12px;
                padding-left: 8px;
                padding-right: 8px;
            }
            
            ul{
                margin-left: 30px;
            }

            .big_table_with_borders td{
                border: 1px solid black;
                padding: 3px;
                font-weight: bold;
            }
            p{
                text-indent: 40px;
            }
        </style>
    </head>
    <body>
        
        <table class="form">  
            <tr>
                <td>
                    <img src="<?php echo App::make('url')->to('/');?>/images/loa_logo.jpg" style="width:200px" />
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td class="title">
                    LETTER OF AUTHORISATION
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td style="border: 1px solid; padding:5px">
                    This form may take you 2 minutes to fill in. You will need the following information to fill in the form.
                    <br />
                    <ul>
                        <li>Deceased's Particulars</li>
                        <li>Applicant's / Next-of-kin's Particulars</li>
                        <li>Representative's Particulars</li>
                    </ul>
                    Please complete the Application Form and submit/fax it to the relevant office
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>
                    To: Officer-in-chargeable
                    <br style="line-height:30px" />

                    
                    Please (v) at the appropriate box
                    <br />
                    <table style='border-right: 1px solid #000' cellspacing="0" cellpadding="0">
                        <tr>
                            <td class='list_td_check'>&nbsp;</td>
                            <td class='list_td'>Mandai Crematorium & Columbarium</td>
                            <td class='list_td'>300 Mandai Road, Singapore 779393</td>
                            <td class='list_td'>Tel. 65545655</td>
                            <td class='list_td'>Fax. 64595228</td>
                        </tr>
                        <tr>
                            <td class='list_td_check'></td>
                            <td class='list_td'>Choa Chu Kang Cemetery Office</td>
                            <td class='list_td'>910 Choa Chu Lang Road, Singapore 699819</td>
                            <td class='list_td'>Tel. 67937428</td>
                            <td class='list_td'>Fax. 67937400</td>
                        </tr>
                        <tr>
                            <td class='list_td_check'></td>
                            <td class='list_td'>Choa Chu Kang Columbarium</td>
                            <td class='list_td'>51 Chinese Cemetery Path 4, Singapore 698932</td>
                            <td class='list_td'>Tel. 67957931</td>
                            <td class='list_td'>Fax. 67950885</td>
                        </tr>
                        <tr>
                            <td class='list_td_check'></td>
                            <td class='list_td'>Choa Chu Kang Crematorium</td>
                            <td class='list_td'>960 Choa Chu Kang Road, Singapore 699818</td>
                            <td class='list_td'>Tel. 67955511</td>
                            <td class='list_td'>Fax. 6862735</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>
                    I would like to apply the following service for the below named deceased person
                </td>
            </tr>
            <tr>
                <td>
                    <span style='font-style: italic; font-weight: bold; font-size: 11px'>Please (v) at the appropriate box and fill in the appropriate information</span>
                    <table cellspacing='4' class="big_table_with_borders" style="width: 100%">
                        <tr>
                            <td style="width: 30px">&nbsp;</td>
                            <td style="width: 200px">
                                <div style="width:100%; text-align: center">Cremation Booking Details</div>
                                <div style="width:100%;">
                                    Date / Time:
                                    <br />
                                    <br />
                                    Service Hall No.:
                                </div>
                            </td>
                            <td>To have the body of the deceased person cremated at Government Crematorium and I accept full responsibility for it. I declared that the said deceased person is not known to have left any written direction that he/she should not be cremated. I shall be bound by the terms and conditions for cremation.</td>
                        </tr>
                        
                        <tr>
                            <td></td>
                            <td>
                                <div style="width:100%; text-align: center">Storage/Removal of Cremated Remains</div>
                                <div style="width:100%;">
                                    Columbarium Location:
                                    <br />
                                    <br />
                                    Niche No.:
                                </div>
                            </td>
                            <td>To store / remove cremated remains in niche at Government Columbarium for the said deceased person. I shall be bound by the terms and conditions for the storage / removal of cremated remains in the niche(s)</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div style="width:100%; text-align: center">Application for Lease of Buridal Plot(s) at CCK Cemetery</div>
                                <div style="width:100%;">
                                    Chinese/Muslim/Christian/Lawn/ Hindu/Others
                                </div>
                            </td>
                            <td>To have the body of the deceased person buried at Choa Chu Kang Cemetery and I accept full responsibility for it. I shall be bound by the termn and conditions of lease of the burial plot(s) and rules and regulations of Choa Chu Kang Cemetery</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div style="width:100%; text-align: center">Erection of the tombstone/monument and for inscription to be made on such tombstone or monument</div>
                                <div style="width:100%;">
                                    Chinese/Muslim/Christian/Lawn/ Hindu/Others
                                </div>
                            </td>
                            <td>
                                To erect tombstone / monument at Choa Chu Kang Cemetery. I shall be bound by the terms and conditions for erection of the tombstone / monument and its rules and regulations of Choa Chu Kang Cemetery.
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div style="width:100%; text-align: center">Search / Extract Certified True Copy</div>
                                <div style="width:100%; height: 60px;">
                                    Type of Search:
                                </div>
                            </td>
                            <td>
                                To search for the deceased's information and obtain a certified true copy. I shall be bound by the terms and conditions for obtaining the deceased's information
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <div class="page-break"></div>
        
        
        <table class="form">  
            <tr>
                <td>
                    <table style="width: 100%">
                        <tr>
                            <td style='border: 1px solid;width: 55%'>
                                <table style="width: 100%;">
                                    <tr><td style="padding: 10px">Name of Deceased:</td></tr>
                                    <tr><td style="text-align:center; height: 100px">{{$object->deceased_name}}</td></tr>
                                </table>
                            </td>
                            <td style='border: 1px solid'>
                                <table style="width: 100%">
                                    <tr><td style="padding: 10px">Death Certificate / Permit No.:</td></tr>
                                    <tr><td style="text-align:center; height: 100px"></td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <span style="font-style: italic; font-size: 12px;"><strong>Please produce supporting documents for verification.</strong> Terms and conditions apply for burial / cremation / storage / removal services at Government's cemetery, crematorium and columbarium, a copy of which may be viewed at <u>www.nea.gov.sg</u> or at the Booking Office on request.</span>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>
                    <p>I hereby instruct and authorise my representative:</p>
                    <table style="width:80%; padding-left: 5%">
                        <tr>
                            <td style='border: 1px solid;'>
                                <table>
                                    <tr><td style="height: 110px; padding-left: 50px">Particulars of Representative</td></tr>
                                </table>
                            </td>
                            <td style='border: 1px solid'>
                                <table>
                                    <tr><td>Singapore Casket Company (Pte) Ltd</td></tr>
                                    <tr><td style='font-style: italic; height: 110px; padding-top:50px'> Name / NRIC No. / Contact No or Company's Stamp</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <br /><br />
                    to act on my behalf on the above matter and do all the things necessary in connection with the said matter, including signing of the aforesaid application.
                    <p>The particulars given are true to the best of my knowledge. I hereby agree to indemnify and hold harmless to NEA against any legal suit, claims, losses, expenses or costs (including those asserted by third parties) arising directly or indirectly from the burial / cremation / storage / removal of the deceased person / cremated remains</p>
                    <p>The National Environment Agency (NEA) collects personal information to carry out its various functions and duties under the National Environment Agency Act ( Cap 195 ) including the implementation of environmental and public health policies in Singapore and any other related purposes. I hereby consent to NEA's use of information provided by me in the course of any application I have made to the NEA, to facilitate the processing of such application for such purposes. I hereby further consent to NEA sharing the information in such application with other Government agencies, or non-government entities authorised to carry out specific government services, unless prohibited by legislation.</p>
                </td>
            </tr>
            <tr><td style="height: 20px;">&nbsp;</td></tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="border-top: 1px solid">
                                (Signature of Applicant & Date)
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td style="height: 20px;">&nbsp;</td></tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                Name of Applicant*:
                            </td>
                            <td style="border-bottom: 1px solid; width: 200px">
                                 {{$object->first_cp_name}}
                            </td>
                        </tr>
                        <tr><td  colspan="2" style="line-height: 5px;">&nbsp;</td></tr>
                        <tr>
                            <td>
                                NRIC No. of Applicant:
                            </td>
                             <td style="border-bottom: 1px solid">
                                {{$object->first_cp_nric}}
                            </td>
                        </tr>
                        <tr><td  colspan="2" style="line-height: 5px;">&nbsp;</td></tr>
                        <tr>
                            <td>
                                Address of Applicant:
                            </td>
                            <td style="border-bottom: 1px solid">
                                {{$object->first_cp_address}}
                            </td>
                        </tr>
                        <tr><td  colspan="2" style="line-height: 5px;">&nbsp;</td></tr>
                        <tr>
                            <td>
                                Applicant Contact No.:
                            </td>
                            <td style="border-bottom: 1px solid">
                                {{$object->first_cp_mobile_nr}}
                            </td>
                        </tr>
                        <tr><td  colspan="2" style="line-height: 5px;">&nbsp;</td></tr>
                        <tr>
                            <td>
                                Applicant Relationship to the Deceased:
                            </td>
                            <td style="border-bottom: 1px solid">
                                
                            </td>
                        </tr>
                        <tr><td  colspan="2" style="line-height: 5px;">&nbsp;</td></tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <em>* Applicant is deemed to be the next-of-kin / nearest surviving relative of the deceased and the rest of the family members have consented to this application</em>
                </td>
            </tr>
            <tr><td style="line-height: 5px;">&nbsp;</td></tr>
            <tr>
                <td style="font-weight: bold; font-size:10px">
                    Version 3 / 21 Feb 14
                </td>
            </tr>
        </table>
        
    </body>
</html>