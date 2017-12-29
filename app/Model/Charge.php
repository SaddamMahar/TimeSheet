<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    public $timestamps = false;
    public function designation()
    {
        return $this->belongsTo('App\Model\Designation');
    }
}
