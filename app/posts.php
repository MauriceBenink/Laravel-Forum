<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
    protected $fillable = [
        'name','description','content','upper_level_id','user_level_req_vieuw','user_level_req_edit','published_at',
    ];

    protected $hidden = [
        'user_level_req_vieuw','user_level_req_edit','published_at',
    ];

    public function author(){
        return $this->belongsTo('App\User','user_id');
    }

    public function bannedBy(){
        return $this->belongsTo('App\User','banned_by');
    }

    public function up(){
        return $this->belongsTo('App\sub_topics','upper_level_id');
    }

    public function down(){
        return $this->hasMany('App\comments','upper_level_id');
    }
}
