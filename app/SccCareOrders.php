<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SccCareOrders extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scc_care_orders';
    
    public static function getName($scc_type, $title_type){
        $arr = array();
        switch ($scc_type){
            case "buddhist":
                $arr["page_title"] = "Buddhist";
            break;
        
            case "christian":
                $arr["page_title"] = "Christian ";
            break;
        
            case "tidbits":
                $arr["page_title"] = "Tidbits ";
            break;
        
            case "chanting":
                $arr["page_title"] = "Chanting";
            break;
        
            case "tentage":
                $arr["page_title"] = "Tentage";
            break;
        }
        
        if (isset($arr[$title_type])){
            return $arr[$title_type];
        }
        else{
            return $scc_type;
        }
    }
    
    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function setNextNumber(){
        $result = self::where("care_type",$this->care_type)->orderby("order_nr","desc")->first();
        if (!$result){
            return 1;
        }
        else{
            return $result->order_nr + 1;
        }
    }
    
    public function funeralArrangement()
    {
        return $this->hasOne('App\FuneralArrangements', 'id', 'funeral_arrangement_id');
    }
}
