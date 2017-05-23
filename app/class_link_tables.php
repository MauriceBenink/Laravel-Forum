<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class class_link_table extends Model
{
    protected $fillable = ['user_id','sub_topic_id','post_id','comment_id','user_group_id','content_group_id','permission'];

    protected $hidden =[];

    public function users(){
        return $this->belongsTo('App\User','user_id');
    }

    public function sub_topics(){
        return $this->belongsTo('App\sub_topics','sub_topic_id');
    }

    public function posts(){
        return $this->belongsTo('App\posts','post_id');
    }

    public function comments(){
        return $this->belongsTo('App\comments','comment_id');
    }


    public function userGroup(){
        return $this->hasMany('App\class_link_table','user_id');
    }


    public function contentGroup(){
        return $this->hasMany('App\class_link_table');
    }

    public static function killAll($number,$colum){
        $deadrows = self::where($colum,$number)->get()->all();
        foreach($deadrows as $deadrow){
            self::destroy($deadrow->id);
        }
    }


}
