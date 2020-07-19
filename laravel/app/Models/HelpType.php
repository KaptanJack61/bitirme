<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpType extends Model
{
    protected $table = "help_types";

    public function helps() {
        return $this->hasMany('App\Models\Help','help_types_id');
    }
}
