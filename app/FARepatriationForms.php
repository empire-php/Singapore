<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Company;

class FARepatriationForms extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fa_repatriation_forms';

    public function user()
    {
        return $this->belongsTo('App\User');
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
    
    public function getLastSavedByUser(){
        if ($this->last_saved_by){
            return User::find($this->last_saved_by);
        }
        else{
            return false;
        }
    }
}
