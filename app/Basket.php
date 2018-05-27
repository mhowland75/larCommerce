<?php

namespace App;
use App\Product;
use Auth;
use Session;
use DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
class Basket extends Model
{

  protected $table = 'basket';

  public static function priceOfProductQuantity($product_id,$quantity){
    //calculate product cost times qunatity
    $price = Product::select('price')->where('id',$product_id)->get();
    if(!empty($price[0]->price)){
      return $price[0]->price * $quantity;
    }
    else{
      return NULL;
    }
  }
  public static function getBasketTotal(){
    $basket = static::getbasket();
    if(!empty($basket)){
      $basketTotal = 0;
      foreach($basket as $product){
        $basketTotal = $basketTotal + $product->totalProductPriceByQty;
      }
      return number_format($basketTotal,2);
    }
    else{
      return NULL;
    }

  }
  public static function getBasket(){
    // determins if a basket exits and in which form. formats the data if needed and then retives and returns a object of products that exits in the basket.
    if(Auth::check()){
      return static::getBasketProducts(Basket::getUsersBasket(Auth::id()));
    }
    elseif(!empty(Basket::getTemporaryBasket())){
      return static::getBasketProducts(Basket::getTemporaryBasket());
    }
    else{
      return array();
    }
  }
  public static function getBasketProducts(array $products){
    // Builds an object of products
    $basket = array();
    foreach($products as $product_id => $quantity){
      $product = Product::getProduct($product_id);
      $product->totalProductPriceByQty = static::priceOfProductQuantity($product_id,$quantity);
      $product->quantity = $quantity;
      $basket[] = $product;
    }
    return $basket;
  }
  public static function product(){
    return $this->belongsTo(Product::class, 'product_id');
  }
  public static function getUsersBasket($user_id){
    $products = array();
    $basket = static::where('user_id',$user_id)->get();
    foreach($basket as $x){
      $products[$x->product_id] = $x->quantity;
    }
    return $products;
  }
  public static function addTemporaryBasket($product_id,$quantity){
    $basket = array();
    $productQuantity = Product::getProductQuantity($product_id);
    if($quantity > $productQuantity){
      //$quantity = $productQuantity;
    }
    if(!empty(Cookie::get('basket'))){
       $basket = Cookie::get('basket');
       if(!empty($basket[$product_id])){
         $oldQuantity = $basket[$product_id];
         $newQuantity = $oldQuantity + $quantity;
         if($newQuantity > $productQuantity){
           $newQuantity = $productQuantity;
         }
         $basket[$product_id] = (int)$newQuantity;
       }
       else{
         $basket[$product_id] = (int)$quantity;
       }
       Cookie::queue('basket', $basket, '60');
    }
    else{
      $basket[$product_id] = $quantity;
      Cookie::queue('basket', $basket, '60');
    }
  }
  public static function getTemporaryBasket(){
    return Cookie::get('basket');
  }
  public static function basketTotal(){
    if(Auth::check()){
      $basket = DB::table('basket')->where('user_id',Auth::id())->get();
      $basketTotal = 0;
      foreach ($basket as $item) {
        if($item->product_size_id == 0){
          $product = DB::table('products')->where('id',$item->product_id)->get();
          if($product[0]->sale_percentage > 0){
            $y = $product[0]->price/100 * $product[0]->sale_percentage;
            $y = $product[0]->price - $y;
            $product->price = $y;
          }

        }
        else{
          $product = DB::table('product_sizes')->where('id',$item->product_size_id)->get();
          if($product[0]->sale_percentage > 0){
            $y = $product[0]->price/100 * $product[0]->sale_percentage;
            $y = $product[0]->price - $y;
            $product[0]->price = $y;
          }
        }
          $basketTotal = $basketTotal + $item->quantity * $product[0]->price;
      }
    }
      else{
        $basket = DB::table('basket')->where('user_id', Session::get('temp_id'))->get();
        $basketTotal = 0;
        foreach ($basket as $item) {
          if($item->product_size_id == 0){
            $product = DB::table('products')->where('id',$item->product_id)->get();
            if($product[0]->sale_percentage > 0){
              $y = $product[0]->price/100 * $product[0]->sale_percentage;
              $y = $product[0]->price - $y;
              $product[0]->price = $y;
            }
          }
          else{
            $product = DB::table('product_sizes')->where('id',$item->product_size_id)->get();
            if($product[0]->sale_percentage > 0){
              $y = $product[0]->price/100 * $product[0]->sale_percentage;
              $y = $product[0]->price - $y;
              $product[0]->price = $y;
            }
          }
          //return $product;
          $basketTotal = $basketTotal + $item->quantity * $product[0]->price;
      }
    }
      return number_format($basketTotal,2);
  }
  public static function basketMerge(){
    $tempBasket = static::getTemporaryBasket();
    $userBasket = static::getUsersBasket(Auth::id());
    Basket::endBasketCookie();
    if(!empty($tempBasket) && !empty($userBasket)){
      return $tempBasket + $userBasket;
    }
    elseif(!empty($tempBasket) && empty($userBasket)){
      return $tempBasket;
    }
    elseif(empty($tempBasket) && !empty($userBasket)){
      return $userBasket;
    }
    else{
      return NULL;
    }
  }
  public static function endBasketCookie(){
    Cookie::queue('basket', NULL, '60');
  }
  public static function deleteUserBasket(){
    static::where('user_id',Auth::id())->delete();
  }
  public static function deleteBasketItem($product_id){
    if(!empty(Product::find($product_id))){
      if(Auth::check()){
        static::where('product_id',$product_id)->where('user_id',Auth::id())->delete();
      }
      elseif(!empty(static::getTemporaryBasket())){
        $basket = static::getTemporaryBasket();
        if(!empty($basket[$product_id])){
          unset($basket[$product_id]);
        }
        Cookie::queue('basket', $basket, '60');
      }
      return redirect()->back();
    }
    else{
      return redirect()->back();
    }
  }
  public static function updateBasketItemQuantity($basket){
    unset($basket['_token']);
    if(Auth::check()){
      foreach($basket as $product_id => $newQuantity){
        if(!empty(Product::find($product_id))){
          static::where('product_id',$product_id)->where('user_id',Auth::id())->update(['quantity'=> static::checkStockAvailability($product_id ,$newQuantity)]);
        }
      }
    }
    else{
        foreach($basket as $product_id => $newQuantity){
          if(is_numeric($newQuantity)){
             $basket[$product_id] = static::checkStockAvailability($product_id ,$newQuantity);
             Cookie::queue('basket', $basket, '1');
          }
          else{
            if(!empty(static::getTemporaryBasket()) && is_numeric($product_id)){
              $tempBasket = static::getTemporaryBasket();
              $basket[$product_id] = $tempBasket[$product_id];
              Cookie::queue('basket', $basket, '1');
            }else{
              Cookie::queue('basket', array(), '1');
            }
          }
        }
      }
    }
  public static function checkStockAvailability($product_id, $newQuantity){
    if($newQuantity > Product::getProductQuantity($product_id) && $newQuantity > 0){
      return Product::getProductQuantity($product_id);
    }
    elseif($newQuantity < 0){
      return 1;
      static::deleteBasketItem($product_id);
    }
    else{
      return $newQuantity;
    }
  }
}
