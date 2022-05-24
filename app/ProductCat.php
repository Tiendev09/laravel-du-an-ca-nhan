<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCat extends Model
{
    protected $fillable =[
        'name','parent_id','slug'
    ];
    public function products(){
        return $this->hasMany('App\Product','cat_id');
    }
    function brand(){
        return $this->hasMany('App\Brand','cat_id');
    }
}
