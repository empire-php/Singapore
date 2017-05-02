<?php

use App\ParlourOrders;

function testHelper () {
  echo 'this is helper';
}

/**
* Author: Jinandra
* Date: 11-24-2016
* Get the string as per defined limit
*
* @param  string  $string
* @param  integer $limit
* @return string
*/
function limitString($string, $limit = 100) {
   $tail = max(0, $limit-10);
   $trunk = substr($string, 0, $tail);
   $trunk .= strrev(preg_replace('~^..+?[\s,:]\b|^...~', '...', strrev(substr($string, $tail, $limit-$tail))));
   return $trunk;
}

/**
* Author: Jinandra
* Date: 11-24-2016
* Get the string as per defined limit
*
* @param  string  $string
* @param  integer $limit
* @return string
*/
function checkParlourAvailability( $date_availability, $parlour_id) {
    $startTimeStr = "00:00";
    $endTimeStr = "23:59";
    $pq = ParlourOrders::select(DB::raw("max(TIMESTAMP(parlour_orders.booked_to_day, parlour_orders.booked_to_time)) as last_date"));
    $pq->where("parlour_id",$parlour_id);
    
    //$pq->whereRaw("TIMESTAMP(booked_from_day, booked_from_time) >='".date("Y-m-d H:i:s", strtotime($date_availability." ".$startTimeStr.":00"))."'");
    //$pq->whereRaw("TIMESTAMP(booked_to_day, booked_to_time) <='".date("Y-m-d H:i:s", strtotime($date_availability." ".$endTimeStr.":00"))."'");
    //$pq->orderByRaw("TIMESTAMP(booked_to_day, booked_to_time) ASC");
    //$pq->groupBy("parlour_id");
    $parlourOrders = $pq->get();
    //$parlourOrders = $pq->toSql();
    /* for debbug query *    
        echo "<pre>";
        print_r($parlourOrders);
        dd(DB::getQueryLog());
        /* end */
    if( $parlourOrders[0]->last_date != "" ){
        $lastdate = $parlourOrders[0]->last_date;
    } else {
        $lastdate = "";
    }
    return $lastdate;
}