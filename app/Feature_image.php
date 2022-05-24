<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature_image extends Model
{
    protected $fillable = [
        'img_url','product_id'
    ];
    function product(){
        return $this->belongsTo('App\Product','product_id');
    }
}
