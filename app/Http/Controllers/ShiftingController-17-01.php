<?php

namespace App\Http\Controllers;

use App\Department;
use App\Notification;
use App\Settings;
use App\Shifting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShiftingController extends Controller
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
     * List of shifting
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $args = [];
        $args['pendingShiftingList'] = Shifting::where(['status' => 'pending'])->get();
        $args['users'] = User::all();
        $args['canUpdate'] = false;

        $finishedShiftingList = Shifting::where(['status' => 'finished']);
        $fromFilter = $request->get('from', '');
        $toFilter = $request->get('to', '');
        $fromFilterFormatted = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $fromFilter)));
        $toFilterFormatted = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $toFilter)));

        if ($fromFilter && $toFilter) {
            $finishedShiftingList->where(function($q) use ($fromFilterFormatted, $toFilterFormatted) {
                $q->whereBetween('start_date', [$fromFilterFormatted, $toFilterFormatted]);
                $q->orWhereBetween('end_date', [$fromFilterFormatted, $toFilterFormatted]);
            });
        } elseif ($fromFilter) {
            $finishedShiftingList->where(function($q) use ($fromFilterFormatted) {
                $q->whereBetween('start_date', '>', $fromFilterFormatted)
                    ->orWhereBetween('end_date', '>', $fromFilterFormatted);
            });
        } elseif ($toFilter) {
            $finishedShiftingList->where(function($q) use ($toFilterFormatted) {
                $q->whereBetween('start_date', '<', $toFilterFormatted)
                    ->orWhereBetween('end_date', '<', $toFilterFormatted);
            });
        }


        $args['finishedShiftingList'] = $finishedShiftingList->get();
        $args['fromFilter'] = $fromFilter;
        $args['toFilter'] = $toFilter;

        $individualsSetting = Settings::where(['name' => Settings::KEY_SHIFTING_UPDATE_INDIVIDUALS])->first();

        if (in_array(Auth::User()->id, $individualsSetting->getValueArray())) {
            $args['canUpdate'] = true;
        } else {
            $departmentsSetting = Settings::where(['name' => Settings::KEY_SHIFTING_UPDATE_DEPARTMENTS])->first();
            if (in_array(Auth::User()->department_id, $departmentsSetting->getValueArray())) {
                $args['canUpdate'] = true;
            }
        }

        return view('shifting.index', $args);
    }
    
    
    public function listing(Request $request) {
        $user = Auth::user(); 
        
        $limit = $request->get("limit",5);
        $offset = ($request->get("p",1) - 1) * $limit;
        $data["orders"] = Shifting::orderby($request->get("sort","created_at"), $request->get("ord","desc"))->get();
            
        return view('shifting/listing', $data);
    }
    
    

    /**
     * Show shifting page
     * @param integer $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $args = [];

        $args['shifting'] = Shifting::find($id);

        return view('shifting.show', $args);
    }
    
    /**
     * Create new shifting
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_contact_name'   => 'required|max:255',
            'first_contact_number' => 'required|max:255',
            'deceased_name'        => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $shifting = new Shifting();

        $shifting->first_contact_name = $request->get('first_contact_name');
        $shifting->first_contact_number = $request->get('first_contact_number');
        $shifting->second_contact_name = $request->get('second_contact_name');
        $shifting->second_contact_number = $request->get('second_contact_number');
        $shifting->deceased_name = $request->get('deceased_name');
        $shifting->hospital = $request->get('hospital');
        $shifting->send_parlour = $request->get('send_parlour');
        $shifting->send_outside = $request->get('send_outside');
        $shifting->remarks = $request->get('remarks');
        $shifting->creator_id = $request->get('creator_id');
        $shifting->save();

        $notificationReceiversSetting = Settings::where(['name' => Settings::KEY_SHIFTING_NOTIFICATION_INDIVIDUALS])->first();
        $notificationDepartmentsSetting = Settings::where(['name' => Settings::KEY_SHIFTING_NOTIFICATION_DEPARTMENTS])->first();
        $notificationReceiversFromIndividuals = User::whereIn('id', $notificationReceiversSetting->getValueArray())->get();
        $notificationReceiversFromDepartments = User::whereIn('department_id', $notificationDepartmentsSetting->getValueArray())->get();

        $notificationReceivers = [];

        foreach ($notificationReceiversFromIndividuals as $user) {
            $notificationReceivers[$user->id] = $user;
        }
        foreach ($notificationReceiversFromDepartments as $user) {
            $notificationReceivers[$user->id] = $user;
        }

        foreach ($notificationReceivers as $user) {
            $notification = new Notification();
            $notification->action = 'new_shifting';
            $notification->page = '/shifting';
            $notification->section = 'New shifting';
            $notification->details = $shifting->deceased_name;
            $notification->link = '/shifting/' . $shifting->id;
            $notification->creator_id = Auth::User()->id;
            $notification->receiver_id = $user->id;
            $notification->receiver_type = 'user';
            $notification->title = $notification->getTitle();
            $notification->save();
        }

        return redirect()->back();
    }

    /**
     * Update user
     *
     * @param  integer  $id
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request) {
        $shifting = Shifting::find($id);

        if (!$shifting) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Wrong Request'
            ]);
        }

        $exceptedParams = [
            'remarks',
            'start_date',
            'end_date',
        ];
        foreach ($exceptedParams as $paramName) {
            $param = $request->get($paramName);

            if ($param) {
                if (in_array($paramName, ['start_date','end_date'])) {
                    $param = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $param)));
                }
                $shifting->{$paramName} = $param;
            }
        }

        $users_ids = $request->get('users_ids');

        $shifting->members()->sync($users_ids ? $users_ids : []);

        $result = [
            'status' => 'success',
        ];

        if ($shifting->start_date && $shifting->end_date) {
            $result['reload'] = true;
            $shifting->status = 'finished';
        }

        $shifting->save();



        $notificationReceiversSetting = Settings::where(['name' => Settings::KEY_SHIFTING_UPDATE_INDIVIDUALS])->first();
        $notificationDepartmentsSetting = Settings::where(['name' => Settings::KEY_SHIFTING_UPDATE_DEPARTMENTS])->first();
        $notificationReceiversFromIndividuals = User::whereIn('id', $notificationReceiversSetting->getValueArray())->get();
        $notificationReceiversFromDepartments = User::whereIn('department_id', $notificationDepartmentsSetting->getValueArray())->get();

        $notificationReceivers = [];

        foreach ($notificationReceiversFromIndividuals as $user) {
            $notificationReceivers[$user->id] = $user;
        }
        foreach ($notificationReceiversFromDepartments as $user) {
            $notificationReceivers[$user->id] = $user;
        }

        foreach ($notificationReceivers as $user) {
            $notification = new Notification();
            $notification->action = 'update_shifting';
            $notification->page = '/shifting';
            $notification->section = 'Update shifting';
            $notification->details = $shifting->deceased_name;
            $notification->link = '/shifting/' . $shifting->id;
            $notification->creator_id = Auth::User()->id;
            $notification->receiver_id = $user->id;
            $notification->receiver_type = 'user';
            $notification->title = $notification->getTitle();
            $notification->save();
        }

        return response()->json($result);
    }
    
    public function searchParlour(Request $request){
       
       $results = \App\Parlours::where('name','like','%'.$request->get('term').'%')->orderby('name','asc')->get()->toArray();
       return response()->json($results);
    }

}
