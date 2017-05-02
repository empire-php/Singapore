<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Session\Session;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        $session = new Session();
        View::share('headerCompany', Company::find($session->get('company_id')));
    }
}
