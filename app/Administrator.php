<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    protected $table = 'administrator_privileges';

    public function scopePrivalages($query){
      return $query->where('access_level',1);
    }
}
