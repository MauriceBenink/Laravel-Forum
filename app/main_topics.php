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
        return $this->hasMany('App\sub_topics','upper_level_id');
    }

    public function link(){
        return $this->hasMany('App\class_link_table','main_topics_id','id');
    }

    public static function killme($maintopic){
        foreach($maintopic->down as $subtopic){
            sub_topics::killme($subtopic);
        }
        foreach($maintopic->link as $link){
            class_link_table::destroy($link->id);
        }
        self::destroy($maintopic->id);

    }


}
