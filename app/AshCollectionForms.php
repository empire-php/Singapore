<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AshCollectionForms extends Model
{
    const ashesLocationOptions = array( 1 => "SCC Level 2", 2 => "With Family");
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ash_collection_forms';

    public function funeralArrangement()
    {
        return $this->hasOne('App\FuneralArrangements', 'id', 'funeral_arrangement_id');
    }
    public function ashes_location_option(){
        $arr = self::ashesLocationOptions;
        if (isset($arr[$this->ashes_location])){
            return $arr[$this->ashes_location];
        }
        else{
            return "";
        }
    }
    
    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
