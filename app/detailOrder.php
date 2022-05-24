<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detailOrder extends Model
{
    //
    protected $fillable = [
        'product_id','order_id','status','quantity'
    ];
    protected $table = 'detail_order';
    function products(){
        return $this->belongsTo('App\Product','product_id');
    }
    function orders(){
        return $this->belongsTo('App\Order','order_id');
    }
}
