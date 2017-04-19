<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class level extends Model
{
    public function users(){
        return $this->hasMany("App/Users","level",'level');
    }
}
