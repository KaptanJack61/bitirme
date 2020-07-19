<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    public function helps() {
        return $this->hasMany('App\Models\Help');
    }
}
