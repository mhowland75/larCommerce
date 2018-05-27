<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    public function products(){
       return $this->belongsTo('App\Product');
    }
}
