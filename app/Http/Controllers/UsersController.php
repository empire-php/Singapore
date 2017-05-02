<?php

namespace App\Http\Controllers;

use App\Department;
use App\Settings;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $args = [];

        $args['users'] = User::all();
        $args['departments'] = Department::all();

        $args['supervisors'] = [];
        foreach ($args['users'] as $user) {
            if ($user->is_supervisor) {
                $args['supervisors'][$user->id] = $user;
            }
        }
        $args['managers'] = User::all();
        
        return view('users.index', $args);
    }

    /**
     * Edit User page.
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $args = [];

        $args['user'] = User::find($id);
        $args['departments'] = Department::all();
        $args['supervisors'] = User::where('is_supervisor', 1)->get();
        $args['managers'] = User::all();

        return view('users.edit', $args);
    }

    /**
     * Update user
     * @param  integer $id
     * @param  Request $request
     * @return Response
     */
    public function updateByFiled($id, Request $request)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Wrong Request',
            ]);
        }

        $is_supervisor = $request->get('is_supervisor');

        if ($is_supervisor !== null) {
            $user->is_supervisor = $is_supervisor;
            User::where('supervisor_id', $id)
                ->update(['supervisor_id' => 0]);
        }

        $supervisor_id = $request->get('supervisor_id');

        if ($supervisor_id !== null) {
            $user->supervisor_id = $supervisor_id;
        }

        $department_id = $request->get('department_id');

        if ($department_id !== null) {
            $user->department_id = $department_id;
        }

        $password = $request->get('password');

        if ($password !== null) {
            $user->password = bcrypt($password);
        }

        $manager_id = $request->get('manager_id');

        if ($manager_id !== null) {
            $user->manager_id = $manager_id;
        }
        
        $user->save();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Saved',
        ]);
    }

    /**
     * Create new user
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|max:255',
            'email'    => 'required|max:255|unique:users',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|min:6',
            'nickname' => 'required|max:3',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User();

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        $user->nickname= $request->get('nickname');
        $user->password = bcrypt($request->get('password'));
        $user->department_id = $request->get('department_id');
        $user->supervisor_id = $request->get('supervisor_id');
        $user->is_supervisor = $request->get('is_supervisor');
        $user->manager_id = $request->get('manager_id');
        $user->save();

        return redirect()->back();
    }

    /**
     * Update new user
     * @param integer $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $user = User::find($id);

        $emailUnique = '';
        if ($user->email != $request->get('email')) {
            $emailUnique = '|unique:users';
        }

        $usernameUnique = '';
        if ($user->username != $request->get('username')) {
            $usernameUnique = '|unique:users';
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'required|max:255',
            'email'    => 'required|max:255' . $emailUnique,
            'username' => 'required|max:255' . $usernameUnique,
            'nickname' => 'required|max:3',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }


        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        $user->nickname= $request->get('nickname');
        $user->department_id = $request->get('department_id');
        $user->supervisor_id = $request->get('supervisor_id');
        $user->is_supervisor = $request->get('is_supervisor');
        $user->manager_id = $request->get('manager_id');
        $user->save();

        return redirect()->back();
    }
}
