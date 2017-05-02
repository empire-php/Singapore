<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    public static function getLowStockProducts(){
        return self::select("item","category")->whereRaw("low_stock_amount >  warehouse + store_room ")->orderby("item")->get()->toArray();
    }

    public function stock_history() {
        return $this->hasMany('App\StockHistory');
    }
}
