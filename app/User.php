<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function userBasketIdentification(){
      if(!Auth::id() && !Session::get('temp_id')){

        $id = rand(1000000,9999999);
        $x = 0;
        while($x <= 1){
          $xa = DB::table('basket')->where('user_id',$id)->get();
          if(empty($xa[0]->id) ){
            break;
          }
          $id = rand(1000000,9999999);
        }
          Session::put('temp_id', $id);

        }
        elseif(!Auth::id() && Session::get('temp_id')){
          $id = Session::get('temp_id');

        }
        elseif(Auth::id()){
          $id = Auth::id();
        }
        return $id;
    }
}
