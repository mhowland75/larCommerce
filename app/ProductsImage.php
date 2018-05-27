<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductsImage extends Model
{
    public static function returnProductMainImage($product_id){
      $image = static::select('image')->where('product_id',$product_id)->where('active', 1)->where('main_image',1)->get();
      if(!empty($image[0]->image)){
        return Storage::url($image[0]->image);;
      }
      else{
        return NULL;
      }
    }
}
