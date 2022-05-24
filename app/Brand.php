<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name','status','cat_id','slug'
    ];
    function product_cats(){
        return $this->belongsTo('App\ProductCat','cat_id');
    }
    function products(){
        return $this->hasMany('App\Product','brand_id');
    }
}
