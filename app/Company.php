<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Session\Session;

class Company extends Model
{
    const WSC = 1;
    const WFA = 2;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';
    
    public static function getCurrentCompanyPrefix(){
        $session = new Session();
        $companyId = $session->get('company_id');
        return ($companyId == self::WSC)?"WSC":"WFA";
    }
}
