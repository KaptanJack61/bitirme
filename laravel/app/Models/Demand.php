<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    public function helps() {
        return $this->belongsToMany('App\Models\Help')->withTimestamps();
    }

    public function person(){
        return $this->belongsTo('App\Models\Person');
    }

    public function help() {
        return $this->hasOne('App\Models\DemandHelp');
    }

}
