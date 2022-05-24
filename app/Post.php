<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'img','title','user_id','content','cat_id','status','thumbnail'
    ];
    function user(){
        return $this->belongsTo('App\User','user_id');
    }
    function cat(){
        return $this->belongsTo('App\PostCats','cat_id');
    }
}
