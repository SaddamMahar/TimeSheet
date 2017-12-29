<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DailyInput extends Model
{
    protected $table = "daily_inputs";
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function client()
    {
        return $this->belongsTo('App\Model\Client');
    }
}
