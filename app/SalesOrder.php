<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'salesorder';

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'creator_id');
    }

  
}
