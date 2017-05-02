<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmbalmingTimelog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'embalming_timelog';

    public function shiftedByUser()
    {
        return $this->hasOne('App\User', 'id', 'shifted_by');
    }
}
