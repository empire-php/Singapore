<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Dutyroster extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'duty_roster';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'calendarunique_id', 'duty_month', 'duty_year', 'column_1', 'column_2', 'date_column_1', 'date_column_2', 'date_column_3',
                            'date_column_4', 'date_column_5', 'date_column_6', 'date_column_7', 'date_column_8', 'date_column_9', 'date_column_10', 'date_column_11',
                            'date_column_12', 'date_column_13', 'date_column_14', 'date_column_15', 'date_column_16', 'date_column_17', 'date_column_18', 'date_column_19',
                            'date_column_20', 'date_column_21', 'date_column_22', 'date_column_23', 'date_column_24', 'date_column_25', 'date_column_26', 'date_column_27',
                            'date_column_28', 'date_column_29', 'date_column_30', 'date_column_31', 'created_at', 'updated_at'];

    protected $primaryKey = 'id';
    
    /**
     * Insert operation service 
     *
     * @param  array  $columns
     * @return User
     */
    public static function insertDutyRoster(Array $data)
    {        
        $postdataarr = array(
                            'calendarunique_id' => $data['calendarunique_id'],
                            'duty_month' => $data['duty_month'],
                            'duty_year' => $data['duty_year'],
                            'column_1' => $data['column_1'],
                            'column_2' => $data['column_2'],
                            'date_column_1' => $data['date_column_1'],
                            'date_column_2' => $data['date_column_2'],
                            'date_column_3' => $data['date_column_3'],
                            'date_column_4' => $data['date_column_4'],
                            'date_column_5' => $data['date_column_5'],
                            'date_column_6' => $data['date_column_6'],
                            'date_column_7' => $data['date_column_7'],
                            'date_column_8' => $data['date_column_8'],
                            'date_column_9' => $data['date_column_9'],
                            'date_column_10' => $data['date_column_10'],
                            'date_column_11' => $data['date_column_11'],
                            'date_column_12' => $data['date_column_12'],
                            'date_column_13' => $data['date_column_13'],
                            'date_column_14' => $data['date_column_14'],
                            'date_column_15' => $data['date_column_15'],
                            'date_column_16' => $data['date_column_16'],
                            'date_column_17' => $data['date_column_17'],
                            'date_column_18' => $data['date_column_18'],
                            'date_column_19' => $data['date_column_19'],
                            'date_column_20' => $data['date_column_20'],
                            'date_column_21' => $data['date_column_21'],
                            'date_column_22' => $data['date_column_22'],
                            'date_column_23' => $data['date_column_23'],
                            'date_column_24' => $data['date_column_24'],
                            'date_column_25' => $data['date_column_25'],
                            'date_column_26' => $data['date_column_26'],
                            'date_column_27' => $data['date_column_27'],
                            'date_column_28' => $data['date_column_28'],
                            'date_column_29' => $data['date_column_29'],
                            'date_column_30' => $data['date_column_30'],
                            'date_column_31' => $data['date_column_31'],
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                            );
        
        $insrtRes = Dutyroster::Create($postdataarr);        
        
        if( $insrtRes )
        {
            return $insrtRes->id;
        }
        else{
            return false;
        }
    }    
    
    /**
     * Update operation service
     *
     * @param  array  $columns
     * @return User
     */
    public static function updateDutyRoster(Array $data)
    {   
        $updateRes = DB::table((new Dutyroster)->getTable())
                     ->where('calendarunique_id', '=', $data['calendarunique_id'])
                     ->update(['duty_month' => $data['duty_month'],
                                'duty_year' => $data['duty_year'],
                                'column_1' => $data['column_1'],
                                'column_2' => $data['column_2'],
                                'date_column_1' => $data['date_column_1'],
                                'date_column_2' => $data['date_column_2'],
                                'date_column_3' => $data['date_column_3'],
                                'date_column_4' => $data['date_column_4'],
                                'date_column_5' => $data['date_column_5'],
                                'date_column_6' => $data['date_column_6'],
                                'date_column_7' => $data['date_column_7'],
                                'date_column_8' => $data['date_column_8'],
                                'date_column_9' => $data['date_column_9'],
                                'date_column_10' => $data['date_column_10'],
                                'date_column_11' => $data['date_column_11'],
                                'date_column_12' => $data['date_column_12'],
                                'date_column_13' => $data['date_column_13'],
                                'date_column_14' => $data['date_column_14'],
                                'date_column_15' => $data['date_column_15'],
                                'date_column_16' => $data['date_column_16'],
                                'date_column_17' => $data['date_column_17'],
                                'date_column_18' => $data['date_column_18'],
                                'date_column_19' => $data['date_column_19'],
                                'date_column_20' => $data['date_column_20'],
                                'date_column_21' => $data['date_column_21'],
                                'date_column_22' => $data['date_column_22'],
                                'date_column_23' => $data['date_column_23'],
                                'date_column_24' => $data['date_column_24'],
                                'date_column_25' => $data['date_column_25'],
                                'date_column_26' => $data['date_column_26'],
                                'date_column_27' => $data['date_column_27'],
                                'date_column_28' => $data['date_column_28'],
                                'date_column_29' => $data['date_column_29'],
                                'date_column_30' => $data['date_column_30'],
                                'date_column_31' => $data['date_column_31']]);
        if( $updateRes )
        {
            return true;
        }
        else{
            return false;
        }
    }
    
    
    /**
     * Get recent user on home page
     *
     * @param  array  $columns
     * @return User
     */
    public static function checkDutyRosterAlreadyExists($calendarunique_id)
    {   
        $dutyRosterData = DB::table((new Dutyroster)->getTable())
                     ->select(DB::raw('*'))
                     ->where('calendarunique_id', '=', $calendarunique_id)
                     ->first();
        if( $dutyRosterData )
        {
            return $dutyRosterData;
        }
        else{
            return false;
        }
    }
    
    /**
     * Get month data
     *
     * @param  array  $columns
     * @return User
     */
    public static function getMonthData($month_id)
    {   
        $dutyRosterData = DB::table((new Dutyroster)->getTable())
                     ->select(DB::raw('*'))
                     ->where('duty_month', '=', $month_id)
                     ->get();
        if( $dutyRosterData )
        {
            return $dutyRosterData;
        }
        else{
            return false;
        }
    }
    
    public function membersServiceStaff()
    {
        return $this->belongsToMany('App\User', 'fa_operation_service_staff', 'fa_op_service_id', 'user_id');
    }
    
    public function membersServiceTeam()
    {
        return $this->belongsToMany('App\User', 'fa_operation_service_team', 'fa_op_service_id', 'user_id');
    }
    
    public function membersNightCare()
    {
        return $this->belongsToMany('App\User', 'fa_operation_night_care', 'fa_op_service_id', 'user_id');
    }
}
