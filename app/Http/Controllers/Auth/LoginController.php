<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Basket;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated()
    {
      $newBasket = Basket::basketMerge();
      Basket::deleteUserBasket();
      if(!empty($newBasket)){
        foreach($newBasket as $product_id => $quantity){
            $data = new Basket;
            $data->product_id = $product_id;
            $data->quantity = $quantity;
            $data->user_id = Auth::id();
            $data->product_size_id = 0;
            $data->save();
        }
      }
      Basket::endBasketCookie();
    }
}
