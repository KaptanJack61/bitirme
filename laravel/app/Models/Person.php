<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public function demands() {
        return $this->hasMany('App\Models\Demand');
    }
}
