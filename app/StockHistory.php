<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stock_history';

    public function product(){
        return $this->belongsTo('App\Products');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

}
