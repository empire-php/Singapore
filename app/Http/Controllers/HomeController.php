<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Parlours;
use App\ParlourOrders;
use App\Hearses;
use App\HearseOrders;
use App\Company;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data["company_prefix"] = Company::getCurrentCompanyPrefix();
        $data["items"] = Parlours::where("is_deleted",0)->orderBy("name")->get();
        
        $data["hearses_items"] = Hearses::where("is_deleted",0)->orderBy("name")->get();
        
        return view('home', $data);
    }
}
