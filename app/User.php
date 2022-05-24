<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;
    use EloquentSoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    function posts(){
        return $this->hasMany('App\Post');
    }
    function pages(){
        return $this->hasMany('App\Page');
    }
    function roles(){
        return $this->belongsToMany('App\Role','role_user','user_id','role_id');
    }
    function checkPermissionAccess($permissionCheck){
        //B1: Lấy tất cả các quyền của user đang login
        $roles = auth()->user()->roles;
        //B2 So sánh giá trị đưa vào route xem có tồn tại hay không
        foreach($roles as $role){
            $permissions = $role->permissions;
            // dd($permissions);
            if($permissions->contains('id',$permissionCheck)){
                return true;
            }
        }
        return false;
    }
}
