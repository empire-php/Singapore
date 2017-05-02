<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shifting extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shifting';

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'creator_id');
    }

    public function members()
    {
        return $this->belongsToMany('App\User', 'shifters', 'user_id', 'shifting_id');
    }
    
    public function fa()
    {
        return $this->hasOne('App\FuneralArrangements', 'shifting_id', 'id')->where("is_draft",0);
    }

    public function parlour_order()
    {
        return $this->hasOne('App\ParlourOrders', 'id', 'parlour_order_id');
    }
}
