<?php
/**
 * Created by PhpStorm.
 * User: Nimfus
 * Date: 14.05.16
 * Time: 18:18
 */

namespace App\Http\Requests;


class SendSMSRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'display_name' => 'required|min:3',
            'recipient_no' => 'required',
            'new_password' => 'recipient_no|min:6',
            'message' => 'required',
        ];
    }
}