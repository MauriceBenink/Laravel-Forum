<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Messages extends Model
{
    public function sendBy(){
        return $this->belongsTo('App\User','sender','id');
    }

    public function sendTo(){
        return $this->belongsTo('App\User','reciever','id');
    }

    public static function hasUnread(){
        $messages = self::where('reciever',Auth::user()->id)->where('reciever_delete',0)->get()->all();
        foreach($messages as $message){
            if($message->is_read == 0){
                return true;
            }
        }
        return false;
    }

}
