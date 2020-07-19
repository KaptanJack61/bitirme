<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandHelp extends Model
{
    protected $table = 'demand_help';

    public function help() {
        return $this->belongsTo('App\Models\Help');
    }

    public function demand() {
        return $this->belongsTo('App\Models\Demand');
    }
}
