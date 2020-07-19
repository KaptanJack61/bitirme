<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public function demands() {
        return $this->hasMany('App\Models\Demand');
    }

    public function helps() {
        return $this->hasMany('App\Models\Help');
    }

    public function neighborhood() {
        return $this->belongsTo('App\Models\Neighborhood');
    }

    protected $appends = ["full_name","address"];

    public function getFullNameAttribute(){
        return $this->first_name. ' ' .$this->last_name;
    }

    public function getAddressAttribute(){
        return $this->neighborhood->name. " " .$this->street." ".$this->city_name." No: ".$this->gate_no;
    }

}
