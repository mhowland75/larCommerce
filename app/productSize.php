<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productSize extends Model
{
    public static function getProductSizes($product_id){
      static::where('product_id',$product_id)->where('active',1)->get();
    }
}
