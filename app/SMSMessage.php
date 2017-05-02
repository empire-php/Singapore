<?php
/**
 * Created by PhpStorm.
 * User: Nimfus
 * Date: 14.05.16
 * Time: 18:14
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use DB;

class SMSMessage extends Model
{
    protected $table = 'sent_messages';
    
    protected $fillable = ['display_name', 'recipient_no', 'recipient_name', 'date', 'time', 'message', 'sent_by', 'status'];
    
    /**
     * Get searched user
     *
     * @param  array  $columns
     * @return \App\Models\User
     */
    public static function getSMSNotification()
    {        
        
        $smsdata = DB::table((new SMSMessage)->getTable().' as S')
                     ->select('S.*', 'U.name')
                     ->leftJoin((new User)->getTable().' as U', 'U.id', '=', 'S.sent_by')
                     ->orderBy('S.date', 'desc')
                     ->orderBy('S.time', 'desc')
                     ->get();
                    //->toSql();
        //echo "<pre>";
        //print_r($users);
          //dd(DB::getQueryLog());

        return $smsdata;
    }
}