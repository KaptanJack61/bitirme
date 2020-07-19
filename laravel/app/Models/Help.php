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

    public function demand() {
        return $this->hasOne('App\Models\DemandHelp');
    }

    /*public function neighborhood() {
        return $this->belongsTo('App\Models\Neighborhood');
    }

    protected $appends = ["full_name","address"];

    public function getFullNameAttribute(){
        return $this->first_name. ' ' .$this->last_name;
    }

    public function getAddressAttribute(){
        return $this->neighborhood->name. " " .$this->street." ".$this->city_name." No: ".$this->gate_no;
    }
    */
}
