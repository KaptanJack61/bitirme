<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Help extends Model
{
    protected $guarded = [];

    public function type() {
        return $this->belongsTo('App\Models\HelpType','help_types_id');
    }

    public function status() {
        return $this->belongsTo('App\Models\Status');
    }

    public function demandHelp() {
        return $this->hasOne('App\Models\DemandHelp');
    }

    public function demand(){
        return $this->belongsToMany('App\Models\Demand');
    }

    public function person() {
        return $this->belongsTo('App\Models\Person');
    }
}
