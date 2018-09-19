<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    //
     protected $table = 'client_members';

         protected $fillable = [
        'name', 'email', 'password','avatar'
    ];
    //
}
