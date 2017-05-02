<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Company;

class FuneralArrangements extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'funeral_arrangements';
    
    public static function getDraft(){
        $user = Auth::user();
        
        $draft = self::where('is_draft', 1)->where('user_id', $user->id)->first();
        if (!$draft){
            $dataSet["is_draft"] = 1;
            $session = new Session();
            $dataSet["company_id"] = $session->get('company_id');
            $dataSet["generated_code"] = self::getNextCode();
            $dataSet["user_id"] = $user->id;
            self::insert($dataSet);
            $draft = self::where('is_draft', 1)->where('user_id', $user->id)->orderby("id","DESC")->first();
        }
        return $draft;
    }
    
    public static function getFuneralData($funeral_id){
        $user = Auth::user();
        
        $funeralData = self::where('id', $funeral_id)->first();
        
        return $funeralData;
    }
    
    public static function getNextCode(){
        $row = self::orderBy("generated_code","desc")->first();
        if ( $row ){
            return $row->generated_code + 1;
        }
        else{
            return 10001;
        }
    }
    
    public function getCompanyPrefix(){
        return ($this->company_id == Company::WSC )?"WSC":"WFA";
    }
    public function getFullCode(){
        return $this->getCompanyPrefix() . $this->generated_code;
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function getLastSavedByUser(){
        if ($this->last_saved_by){
            return User::find($this->last_saved_by);
        }
        else{
            return false;
        }
    }


    
    
    /**
     * Get funeral data with operation service
     *
     * @param  array  $columns
     * @return User
     */
    public static function getFAWithOperationService($orderbyTbl, $orderby)
    {   
        $funerallist = DB::table((new FuneralArrangements)->getTable().' as FA')
                     ->select('FA.*', 'OP.signature_service_staff', 'OP.signature_service_team', 'OP.signature_night_care')
                     ->leftJoin((new Operationservice)->getTable().' as OP', 'FA.id', '=', 'OP.fa_id')
                     ->where('FA.is_draft', '=', 0)
                     ->orderByRaw("STR_TO_DATE(FA.".$orderbyTbl.", '%d/%m/%Y') ".$orderby)
                     ->get();
        
        
        if( $funerallist )
        {
            return $funerallist;
        }
        else{
            return false;
        }
    }
    
    
    
}
