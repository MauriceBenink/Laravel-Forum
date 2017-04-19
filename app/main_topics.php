<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class main_topics extends Model
{
    protected $fillable = [
        'name','description','user_level_req_vieuw','user_level_req_edit','published_at',
    ];

    protected $hidden = [
        'user_level_req_vieuw','user_level_req_edit','published_at',
    ];

    public function down(){
        return $this->hasMany('App/sub_topics','upper_level_id');
    }


}
