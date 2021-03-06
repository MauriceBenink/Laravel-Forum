<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sub_topics extends Model
{
    protected $fillable = [
        'name','description','upper_level_id','user_level_req_vieuw','user_level_req_edit','published_at',
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
        return $this->belongsTo('App\main_topics','upper_level_id');
    }

    public function down(){
        return $this->hasMany('App\posts','upper_level_id');
    }

    public function link(){
        return $this->hasMany('App\class_link_table','sub_topics_id','id');
    }

    public static function killme($subtopic){
        foreach($subtopic->down as $post){
            posts::killme($post);
        }
        foreach($subtopic->link as $link){
            class_link_table::destroy($link->id);
        }
        self::destroy($subtopic->id);
    }
}
