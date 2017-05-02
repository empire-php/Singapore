<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NicheCell extends Model
{
    //
    protected $table = 'niche_cells';

    public function niche_row()
    {
        return $this->belongsTo('App\NicheRow');
    }

    public function niche_column()
    {
        return $this->belongsTo('App\NicheColumn');
    }

}
