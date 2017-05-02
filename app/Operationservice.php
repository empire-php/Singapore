<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Operationservice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fa_operation_service';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'fa_id', 'signature_service_staff', 'signature_service_team', 'signature_night_care', 'created_at', 'updated_at'];

    protected $primaryKey = 'id';
    
    /**
     * Insert operation service 
     *
     * @param  array  $columns
     * @return User
     */
    public static function insertOperationService(Array $data)
    {        
        $postdataarr = array(
                            'fa_id' => $data['fa_id'],
                            'signature_service_staff' => $data['signature_service_staff'],
                            'signature_service_team' => $data['signature_service_team'],
                            'signature_night_care' => $data['signature_night_care'],
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                            );
        
        $insrtRes = Operationservice::Create($postdataarr);        
        
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
    public static function updateOperationService(Array $data)
    {   
        $updateRes = DB::table((new Operationservice)->getTable())
                     ->where('fa_id', '=', $data['fa_id'])
                     ->update(['signature_service_staff' => $data['signature_service_staff'],
                               'signature_service_team' => $data['signature_service_team'],
                               'signature_night_care' => $data['signature_night_care']]);
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
    public static function checkOperationAlreadyExists($fa_id)
    {   
        $operationData = DB::table((new Operationservice)->getTable())
                     ->select(DB::raw('*'))
                     ->where('fa_id', '=', $fa_id)
                     ->first();
        if( $operationData )
        {
            return $operationData;
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
