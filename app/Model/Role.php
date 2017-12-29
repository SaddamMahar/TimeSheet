<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;
    protected $table = "roles";

    public function user(){
        return $this->hasMany(User::class);
    }
}
