<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    protected $fillable = [
        'name','content','upper_level_id','user_level_req_vieuw','user_level_req_edit','published_at',
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
        return $this->belongsTo('App\posts','upper_level_id');
    }

    public function link(){
        return $this->hasMany('App\class_link_table','comments_id','id');
    }

    public static function killme($comment){
        foreach($comment->link->all() as $link){
            class_link_table::destroy($link->id);
        }
        comments::destroy($comment->id);
    }
}
