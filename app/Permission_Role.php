<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission_Role extends Model
{
    protected $fillable = [
        'role_id','permission_id'
    ];
}
