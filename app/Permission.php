<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name','desc','parent_id'
    ];
    function permissionChild(){
        return $this->hasMany('App\Permission','parent_id');
    }
}
