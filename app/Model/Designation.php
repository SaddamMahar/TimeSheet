<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = "designation";
    public $timestamps = false;

    public function charge(){
        return $this->hasMany(Charge::class);
    }

    public function staffDetail(){
        return $this->hasMany(StaffDetail::class);
    }
}
