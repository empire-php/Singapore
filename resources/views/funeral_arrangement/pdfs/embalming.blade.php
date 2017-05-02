<?php

/* 
 * Declaration on embalming forms
 * 
 */
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Declaration on Embalming</title>
        <style>
            body, table, td{
                margin:0px; padding: 0px;
            }
            
            body{
                font-size: 15px;
                line-height: 19px;
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
        </style>
    </head>
    <body>
        
        <table class="form">  
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="width:200px; height:50px;">&nbsp;</td>
                            <td class="title"style="width:280px">
                                DECLARATION ON EMBALMING
                                <div class='box_form_title' style="margin-left: 90px;"> FORM 1</div>
                            </td>
                            <td style="vertical-align:middle; width:200px;">
                                <table style="width:150px; margin-left:20px;">
                                  <tr>
                                    <td style="width:20px">SC</td><td class='field_to_be_completed'  style="margin-left: 20px">&nbsp;{{$object->getCompanyPrefix()}}{{$object->generated_code}}</td>
                                  </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="margin-top:10px">
                        <tr>
                            <td style="vertical-align: top; width: 30px">To:</td>
                            <td>Director General Public Health
                                <br />
                                c/o Mandai Crematorium
                                <br />
                                300 Mandai Road(S) 779393
                                <br />
                                [Fax: 6459 5228]
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="margin-top:10px">
                        <tr>
                            <td style="width: 300px;">NAME OF DECEASED</td>
                            <td style="width: 300px;border-bottom: 1px solid #000">{{ $object->deceased_name }}</td>
                        </tr>
                        <tr>
                            <td>DATE OF DEATH</td>
                            <td style="border-bottom: 1px solid #000">{{ $object->deathdate }}</td>
                        </tr>
                        <tr>
                            <td>DATE OF CREMATION / BURIDAL *</td>
                            <td style="border-bottom: 1px solid #000">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>PLACE OF CREMATION / BURIDAL *</td>
                            <td style="border-bottom: 1px solid #000">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>PLACE EMBALMED</td>
                            <td style="border-bottom: 1px solid #000">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>DATE EMBALMED</td>
                            <td style="border-bottom: 1px solid #000">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>TIME EMBALMED</td>
                            <td >
                                <table style="width:100%; margin-left: -2px"><tr><td style="width: 20px;">From</td><td style="width:140px;border-bottom: 1px solid #000">&nbsp;</td><td style="width:10px">to</td><td style="width:140px;border-bottom: 1px solid #000">&nbsp;</td></tr></table>
                            </td>
                        </tr>
                        <tr>
                            <td cosplan='5'>* delete where applicable</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 15px;">
                    <span class="section">Section I - Declaration by Embalmer</span>
                     <br /><br />
                    I, (full name of embalmer) <span class="field_to_be_completed" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> NRIC <span class="field_to_be_completed">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> hereby declare that I carried out embalming of the above-named deceased at the licensed embalming facility as stated above.
                    <br /><br />
                    <table style="width:100%; margin-top:20px">
                        <tr>
                            <td>
                                <div style='border-top: 1px solid #000;width:200px;'>Signature of Embalmer</div>
                            </td>
                            <td>
                                <div style='border-top: 1px solid #000;width:100px; text-align: center'>Date</div>
                            </td>
                        </tr>
                    </table>
                    
                    <table style="margin-top:15px; padding-bottom: 5px;">
                        <tr>
                            <td>
                                Contact No. (H/P)
                            </td>
                            <td style='border-bottom: 1px solid #00'>
                                &nbsp;
                            </td>
                        </tr>
                    </table>   
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px dashed #000; height:5px">
                </td>
            </tr>
            <tr>
                <td>
                    <span class="section">Section II - Declaration by Funeral Parlour</span>
                    <br /><br />
                    I, <span class="field_to_be_completed">Singapore Casket Company (Pte) Ltd</span>, NRIC <span class="field_to_be_completed">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> of <span class="field_to_be_completed">&nbsp;&nbsp;131 Lavender Street, Singapore 338737 &nbsp;&nbsp;</span> hereby declare that <span class="field_to_be_completed">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> carried out the embalming of the above-named deceased at the licensed embalming facility as stated above.
                    <br /><br />
                    <table style="width:100%; margin-top:20px">
                        <tr>
                            <td>
                                <div style='border-top: 1px solid #000;width:200px;'>Signature of Embalmer</div>
                            </td>
                            <td>
                                <div style='border-top: 1px solid #000;width:100px; text-align: center'>Date</div>
                            </td>
                        </tr>
                    </table>
                    
                    <table style="margin-top:15px; padding-bottom: 10px;">
                        <tr>
                            <td>
                                Contact No. (H/P)
                            </td>
                            <td style='border-bottom: 1px solid #00'>
                                &nbsp;+65 6293 4388
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Name of Company
                            </td>
                            <td style='border-bottom: 1px solid #00'>
                                &nbsp;Singapore Casket Company (Pte) Ltd
                            </td>
                        </tr>
                    </table> 
                </td>
            </tr>
            <tr>
                <td style="border-top: 2px solid #000; height: 80px">
                    <span style="font-weight: bold; text-decoration: underline">Important Note - Please read</span>
                    <br />
                    Your attention is drawn to regulation 8 of the Environmental Public Health ( Funeral Parlour ) Regulations, which states "No corpse shall be embalmed or prepared for burial, cremation or put into a coffin in a funeral parlour otherwise than in a room used exclusively for such purpose".
                    <br /><br />
                    A person who contravenes of falls to comply with any if the provisions of these Regulations shall be guilty of an offence and shall be liable n conviction to a fine not exceeding $1,000 in the case of a second of subsequent conviction, to a fine not exceeding $2,000.
                </td>
            </tr>
        </table>
        
        
        <div class="page-break"></div>
        
        
        <!---------------------------------- FORM 2 -------------------------------------------->
        
        <table class="form">  
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="width:200px; height:50px;">&nbsp;</td>
                            <td class="title"style="width:280px">
                                DECLARATION ON EMBALMING
                                <div class='box_form_title' style="margin-left: 90px;"> FORM 2</div>
                            </td>
                            <td style="vertical-align:middle; width:200px;">
                                <table style="width:150px; margin-left:20px;">
                                  <tr>
                                    <td style="width:20px">SC</td><td class='field_to_be_completed'  style="margin-left: 20px">&nbsp;{{$object->getCompanyPrefix()}}{{$object->generated_code}}</td>
                                  </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="margin-top:10px">
                        <tr>
                            <td style="vertical-align: top; width: 30px">To:</td>
                            <td>Director General Public Health
                                <br />
                                c/o Mandai Crematorium
                                <br />
                                300 Mandai Road(S) 779393
                                <br />
                                [Fax: 6459 5228]
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                     <table style="margin-top:10px">
                        <tr>
                            <td style="width: 300px;">NAME OF DECEASED</td>
                            <td style="width: 300px; border-bottom: 1px solid #000">{{ $object->deceased_name }}</td>
                        </tr>
                        <tr>
                            <td>DATE OF DEATH</td>
                            <td style="border-bottom: 1px solid #000">{{ $object->deathdate }}</td>
                        </tr>
                        <tr>
                            <td>DATE OF CREMATION</td>
                            <td style="border-bottom: 1px solid #000">&nbsp;</td>
                        </tr>
                        <tr>
                            <td cosplan='2'>Declaration by Funeral Director</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 33px;">  
                    I, (full name of funeral director) <span class="field_to_be_completed">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> NRIC <span class="field_to_be_completed">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> hereby declare that:
                    <br /><br />
                    <table>
                        <tr>
                            <td rowspan="8" style="vertical-align:top; width:50px;">
                                <div style='border: 1px solid #000; width: 40px; height: 20px'></div>
                            </td>
                            <td colspan="3">
                                Embalming of the above-named deceased was carried out. Details are as follows:
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="line-height: 20px">&nbsp; </td>
                        </tr>
                        <tr>
                            <td style=" width: 250px; height:10px;">
                                Embalmer
                            </td>
                            <td style="width: 300px; border-bottom: 1px solid #000;">
                               &nbsp;
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="line-height: 10px">&nbsp; </td>
                        </tr>
                        <tr>
                            <td style="">
                                Place Embalmer
                            </td>
                            <td style="border-bottom: 1px solid #000;">
                                &nbsp;Singapore Casket Company (Pte) Ltd
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="line-height: 10px">&nbsp; </td>
                        </tr>
                        <tr>
                            <td style="">
                                Date Embalmer
                            </td>
                            <td style="border-bottom: 1px solid #000;">
                                &nbsp;
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="line-height: 20px">&nbsp; </td>
                        </tr>
                        <tr>
                            <td>
                                <div style='border: 1px solid #000; width: 40px; height: 20px'></div>
                            </td>
                            <td colspan="3">
                                No Embalming was carried out to the above named deceased because
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="border-bottom: 1px solid #000; padding-bottom: 10px">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: center">
                                (state reason(s) for not embalming)
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="height: 50px">
                                Additional information is given below,
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2"></td>
                            <td style="height: 20px">
                                Coffin with viewing window
                            </td>
                            <td>
                                Yes / No
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                Hermetically sealed coffin
                            </td>
                            <td>
                                Yes / No
                            </td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width:100%; margin-top:40px">
                        <tr>
                            <td>
                                <div style='border-top: 1px solid #000;width:200px;'>Signature of Embalmer</div>
                            </td>
                            <td>
                                <div style='border-top: 1px solid #000;width:100px; text-align: center'>Date</div>
                            </td>
                        </tr>
                    </table>
                    
                    <table style="margin-top:15px; padding-bottom: 10px;">
                        <tr>
                            <td>
                                Contact No. (H/P)
                            </td>
                            <td style='border-bottom: 1px solid #00'>
                                &nbsp;&nbsp;+65 6293 4388
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Name of Company
                            </td>
                            <td style='border-bottom: 1px solid #00'>
                                &nbsp;Singapore Casket Company (Pte) Ltd
                            </td>
                        </tr>
                    </table> 
                </td>
            </tr>
            <tr>
                <td style="border-top: 2px solid #000; height: 80px;">
                    <span style="font-weight: bold; text-decoration: underline">Important Note - Please read</span>
                    <br />
                    Your attention is drawn to regulation 8 of the Environmental Public Health ( Funeral Parlour ) Regulations, which states "No corpse shall be embalmed or prepared for burial, cremation or put into a coffin in a funeral parlour otherwise than in a room used exclusively for such purpose".
                    <br /><br />
                    A person who contravenes of falls to comply with any if the provisions of these Regulations shall be guilty of an offence and shall be liable n conviction to a fine not exceeding $1,000 in the case of a second of subsequent conviction, to a fine not exceeding $2,000.
                </td>
            </tr>
        </table>
        
        
    </body>
</html>