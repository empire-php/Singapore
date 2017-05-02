<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NicheSuite extends Model
{
    //
    protected $table = 'niche_suites';

    public function niche_sections()
    {
        return $this->hasMany('App\NicheSection');
    }

    public function niche_block()
    {
        return $this->belongsTo('App\NicheBlock');
    }
}
