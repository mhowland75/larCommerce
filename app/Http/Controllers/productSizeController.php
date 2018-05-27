<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class productSizeController extends Controller
{
    public function store(request $request){
      $data = new productSize;
      $data->product_id = $request->product_id;
      $data->size = $request->size;
      $data->size = $request->price;
      $data->stock = $request->stock;
      $data->low_stock_level = $request->low_stock_level;
      $data->sku = $request->sku;
      $data->active = 0;
      $data->discount_percentage = $request->discount_percentage;
      $data->save();
      Product::find($product_id)->update(['size_variation' => 1]);
    }

    public function create(){
      $product = 1;
      return view('products.productSize.create', compact('product'));
    }

}
