<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NicheColumn extends Model
{
    //
    protected $table = 'niche_columns';

    public function niche_cells()
    {
        return $this->hasMany('App\NicheCell');
    }

    public function niche_section()
    {
        return $this->belongsTo('App\NicheSection');
    }
}
