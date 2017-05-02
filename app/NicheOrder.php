<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NicheOrder extends Model
{
    protected $table = 'niche_orders';

    public function funeralArrangement()
    {
        return $this->hasOne('App\FuneralArrangements', 'id', 'funeral_arrangement_id');
    }

    public function niche_block(){
        return $this->belongsTo('App\NicheBlock');
    }

    public function niche_suite() {
        return $this->belongsTo('App\NicheSuite');
    }

    public function niche_section() {
        return $this->belongsTo('App\NicheSection');
    }

    public function niche_cell() {
        return $this->belongsTo('App\NicheCell');
    }

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function setNextNumber(){
        $result = self::orderby("order_nr","desc")->first();
        if (!$result){
            return 1;
        }
        else{
            return $result->order_nr + 1;
        }
    }
}
