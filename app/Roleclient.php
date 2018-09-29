<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roleclient extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'roles';
    public function users()
    {
        return $this->belongsToMany('App\Members', 'role_user', 'role_id', 'user_id');
    }
}
