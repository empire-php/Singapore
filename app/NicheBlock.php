<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NicheBlock extends Model
{
    //
    protected $table = 'niche_blocks';

    public function niche_suites()
    {
        return $this->hasMany('App\NicheSuite');
    }

}
