<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    //
    protected $connection = 'mysql2';
     protected $table = 'users';

         protected $fillable = [
        'name', 'email', 'password','avatar'
    ];
    //
}
