<?php
/**
 * Created by PhpStorm.
 * User: Nimfus
 * Date: 14.05.16
 * Time: 19:25
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    protected $table = 'contact_forms';
    
    protected $fillable = ['name', 'mobile', 'email', 'message', 'notification'];
}