<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Manpowertext extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'manpower_allocation_text';

    
    /**
     * Get record
     *
     * @param  array  $columns
     * @return \App\Models\User
     */
    public function getManpowerTextRecord($manpowerId)
    {        
        
        $manpowerText = DB::table((new Manpowertext)->getTable())
                     ->select(DB::raw('*'))
                     ->where('manpower_id', '=', $manpowerId)
                     ->first();

        return $manpowerText;
    }
    
    /**
     * delete record
     *
     * @param  array  $columns
     * @return User
     */
    public function deleteTextRecord($manpowerId)
    {   
        $deleteRec = DB::table((new Manpowertext)->getTable())
                     ->where('manpower_id', '=', $manpowerId)
                     ->delete();  
//        echo "<pre>";
//        print_r($friendlist);
//        dd(DB::getQueryLog());
        if( $deleteRec )
        {
            return $deleteRec;
        }
        else{
            return false;
        }
    }
    
    public function members()
    {
        return $this->belongsToMany('App\User', 'manpower_allocation', 'user_id', 'manpower_id');
    }
}
