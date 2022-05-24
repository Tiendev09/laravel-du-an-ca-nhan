<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'thumbnail','name','price','cat_id','status','content','intro','brand_id','slug'
    ];
    public function productCat(){
        // return $this->belongsTo('App\ProductCat');
        return $this ->belongsTo('App\ProductCat','cat_id');
    }
    public function orders(){
        return $this->belongsToMany('App\Order','detail_order');
    }
    function brand(){
        return $this->belongsTo('App\brand','brand_id');
    }
    function img(){
        return $this->hasMany('App\Feature_image');
    }
    // function img(){
    //     return $this->belongsToMany('App\Feature_image','feature_images','product_id','img_url');
    // }
}
