<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manpower extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'manpower';

    
    public function members()
    {
        return $this->belongsToMany('App\User', 'manpower_allocation', 'user_id', 'manpower_id');
    }
}
