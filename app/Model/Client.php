<?php

namespace App\Model;

use App\Model\DailyInput;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = "client";
    public $timestamps = false;

    public function dailyInput(){
        return $this->hasMany(DailyInput::class);
    }
}
