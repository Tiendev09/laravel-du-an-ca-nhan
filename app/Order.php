<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'fullname','email','address','phone_number','note','pay','total','code'
    ];
    public function products(){
        return $this->belongsToMany('App\Product','detail_order');
    }
}
