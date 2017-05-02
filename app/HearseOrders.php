<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HearseOrders extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hearse_orders';

    public function funeralArrangement()
    {
        return $this->hasOne('App\FuneralArrangements', 'id', 'funeral_arrangement_id');
    }
    
    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }
    
    public function members()
    {
        return $this->belongsToMany('App\User', 'hearse_order_manpower', 'user_id', 'hearse_order_id');
    }
    
    public static function getNextNumber(){
        $result = self::orderby("order_nr","desc")->first();
        if (!$result){
            return 1;
        }
        else{
            return $result->order_nr + 1;
        }
    }
    
   
    public static function getBookedTime( $hearseId, $booked_from_day, $booked_to_day, $orderId = null  ){
        
        $arrStart = array();
        $arrEnd = array();
        
        if ($hearseId){
            if ($booked_from_day){
                $q = self::select("booked_to_day","booked_from_time","booked_to_time")
                        ->where("hearse_id",$hearseId)
                        ->where("booked_from_day", date("Y-m-d", strtotime(str_replace("/","-",$booked_from_day))))
                        ->orderBy("booked_from_day");
                if ($orderId){
                    $q->where("id","!=",$orderId);
                }
                $res = $q->get()->toArray();
                
                foreach($res as $line){
                    $t = strtotime($line["booked_from_time"]);
                    $arrStart[] = date("H:i", $t);
                    
                    $end = "23:30:00";
                    if ($line["booked_to_day"] == date("Y-m-d", strtotime(str_replace("/","-",$booked_from_day)))){
                        $end = $line["booked_to_time"];
                    }
                    if ($end){
                        $last = date("H:i",$t + 30*60);
                        $i = 0;
                        while ($last .":00" != $end && $i < 48){
                            $arrStart[] = $last;
                            $last = date("H:i", strtotime($last . ":00") + 30*60);
                            $i++;
                        }
                        $arrStart[] = $last;
                    }
                }
            }
            if ($booked_to_day){
                $q = self::select("booked_from_day","booked_from_time","booked_to_time")
                        ->where("hearse_id",$hearseId)
                        ->where("booked_to_day", date("Y-m-d", strtotime(str_replace("/","-",$booked_to_day))))
                        ->orderBy("booked_to_day");
                if ($orderId){
                    $q->where("id","!=",$orderId);
                }
                $res = $q->get()->toArray();
                foreach($res as $line){
                    
                    $start = "00:30";
                    if ($line["booked_from_day"] == date("Y-m-d", strtotime(str_replace("/","-",$booked_to_day)))){
                        $start = $line["booked_from_time"];
                    }
                    
                    $t = strtotime($start);
                    $arrEnd[] = date("H:i", $t);
                    if ($line["booked_to_time"]){
                        $last = date("H:i",$t + 30*60);
                        $i = 0;
                        while ($last .":00" != $line["booked_to_time"] && $i < 48){
                            $arrEnd[] = $last;
                            $last = date("H:i", strtotime($last . ":00") + 30*60);
                            $i++;
                        }
                        $arrEnd[] = $last;
                    }
                }
            }
        }
        return array("start"=>$arrStart, "end"=>$arrEnd);
    }
}
