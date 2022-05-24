<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCats extends Model
{
    //
    protected $fillable = [
        'name','parent_id'
    ];
    function posts(){
        return $this->hasMany('App\Post');
    }
}
