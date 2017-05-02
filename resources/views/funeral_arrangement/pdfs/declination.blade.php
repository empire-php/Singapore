<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Letter of Declaration to Perform Embalming</title>
        <style>
            body{
                font-family: Arial, Helvetica, sans-serif;
            }
        </style>
    </head>
    <body>
        
        <table style="width:700px; margin-left:40px; padding-top: 150px;">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td rowspan="3" style="vertical-align: top; width: 30px">To:</td>
                            <td>Singapore Casket Co Pte Ltd</td>
                        </tr>
                        <tr>
                            <td>131 Lavender Street</td>
                        </tr>
                        <tr>
                            <td>Singapore 338737</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: center; text-decoration: underline; height: 123px; font-size: 19px; font-weight: bold;">
                    LETTER OF DECLINATION TO PERFORM EMBALMING
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="width: 150px;">Name of Deceased</td>
                            <td>:&nbsp;<span style="text-decoration: underline">{{ $object->deceased_name }}</span></td>
                        </tr>
                        <tr>
                            <td>Date of Death</td>
                            <td>:&nbsp;<span style="text-decoration: underline">{{ $object->deathdate }}</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
             <tr>
                <td style="padding-top: 33px;">
                    I, <span style="text-decoration: underline">{{ $object->first_cp_name }}</span> NRIC <span style="text-decoration: underline">{{ $object->first_cp_nric }}</span> hereby confirmed that I and the other members of the family do not wish for an embalming to be done on the deceased.
                    <br /><br />
                    In view of the above, I and the other members of the family will not hold Singapore Casket Co Pte Ltd liable for whatsoever that may arise from acting upon our instructions. We will fully bear the responsibilities should any consequences arises pertaining to this.
                </td>
            </tr>
            <tr>
                <td style="padding-top: 30px;">
                    Yours sincerely,
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:200px; border-bottom: 1px solid #000; height: 80px"></div>
                </td>
            </tr>
            <tr>
                <td>
                    Signature <br />Date
                </td>
            </tr>
        </table>
    </body>
</html>