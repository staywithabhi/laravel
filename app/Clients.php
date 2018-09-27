<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $connection = 'mysql2';
    protected $fillable = [
        'name', 'email', 'password','avatar','usertype',
    ];
    //
}
