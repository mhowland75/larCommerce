<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Basket;
use App\ProductsImage;
use Auth;
use Illuminate\Support\Facades\Cookie;
class BasketController extends Controller
{
    public function index(){
      //return basket::getTemporaryBasket();
      //Basket::deleteBasketItem(1);
      $basket = Basket::getBasket();
      foreach($basket as $product){
        $product->image = ProductsImage::returnProductMainImage($product->id);
      }
      $basketTotal = Basket::getBasketTotal($basket);
      //return $basket;
      return view('basket.index', compact('basket','basketTotal'));
    }
    public function store(request $request){
      if(Auth::check()){
        $data = new Basket;
        $data->user_id = Auth::id();
        $data->product_id = $request->product_id;
        $data->quantity = $request->quantity;
        $data->product_size_id = 0;
        $data->save();
        return redirect()->back();
      }
      else {
        Basket::addTemporaryBasket($request->product_id,$request->quantity);
        return redirect()->back();
      }
    }
    public function delete($product_id){

    }
    public function update(request $request){
      Basket::updateBasketItemQuantity($request->all());
      //  return $basket = Basket::getBasket();
      return redirect()->back();
    }
}
