<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NicheSection extends Model
{
    //
    protected $table = 'niche_sections';

    public function niche_rows()
    {
        return $this->hasMany('App\NicheRow');
    }

    public function niche_columns()
    {
        return $this->hasMany('App\NicheColumn');
    }

    public function niche_suite()
    {
        return $this->belongsTo('App\NicheSuite');
    }
}
