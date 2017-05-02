<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'avatar', 'password', 'is_supervisor', 'supervisor_id', 'department_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function getSupervisor(){
        if ($this->supervisor_id){

            $res = DB::table('users')->where('id', $this->supervisor_id)->first();
            if ($res){
                return $res->name;
            }
        }
        return "";
    }
    
}
