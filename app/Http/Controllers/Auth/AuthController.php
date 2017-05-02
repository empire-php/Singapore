<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Session\Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
//    protected $redirectTo = '/';
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $view = property_exists($this, 'loginView')
            ? $this->loginView : 'auth.authenticate';

        if (view()->exists($view)) {
            return view($view);
        }

        $session = new Session();
        if (!$session->get('passed')) {
            return redirect('/pre-login');
        }

        $args = [];

        $args['companies'] = Company::all();

        return view('auth.login', $args);
    }

    /**
     * Check secret key.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function preLoginCheck(\Illuminate\Http\Request $request)
    {
        $session = new Session();
        if ($session->get('passed')) {
            return redirect('/login');
        }

        $validator = Validator::make($request->all(), [
            'secret_key' => 'required|max:255',
        ]);

        if (!$validator->fails()) {
            $secretKey = \App\Settings::where([
                'name' => 'secret_key',
                'value' => $request->get('secret_key')
            ])->first();
            if ($secretKey) {
                $session = new Session();
                $session->set('passed', true);
                return redirect('/login');
            } else {
                $validator->errors()->add('secret_key', 'Wrong key');
            }
        }

        return redirect('/pre-login')
            ->withErrors($validator)
            ->withInput();
    }

    /**
     * Check secret key.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function preLogin(\Illuminate\Http\Request $request)
    {
        $session = new Session();
        if ($session->get('passed')) {
            return redirect('/login');
        }

        return view('auth.pre_login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $session = new Session();
        $session->set('company_id', $request->get('company_id'));

        return $this->login($request);
    }
}
