<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GemstoneOrders extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gemstone_orders';

    public function funeralArrangement()
    {
        return $this->hasOne('App\FuneralArrangements', 'id', 'funeral_arrangement_id');
    }
    public static function getNextNumber(){
        $result = self::where("is_draft",0)->orderby("order_nr","desc")->first();
        if (!$result){
            return 1;
        }
        else{
            return $result->order_nr + 1;
        }
    }
    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
