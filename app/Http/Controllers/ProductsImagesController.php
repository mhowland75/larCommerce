<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductsImage;

class ProductsImagesController extends Controller
{
    public function create(Product $product_id){
      return view('products.productImages.create' , compact('product_id'));
    }

    public function store(request $request){
    //  return $request->all();
      foreach($request->image as $image){
        $filename = $image->getClientOriginalName();
        $data = new ProductsImage;
        $data->product_id = $request->product_id;
        $data->image = $filename;
        $data->active = 1;
        $data->main_image = 1;
        $data->save();
        $image->storeAs('public', $filename);
      }

      return redirect()->back();
    }
}
