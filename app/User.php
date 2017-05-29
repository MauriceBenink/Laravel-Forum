<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login_name', 'display_name', 'email', 'password','hashcode',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','hashcode','login_name',
    ];

    public function levelName(){
        return $this->belongsTo('App\level','level','level');
    }

    public function subTopics(){
        return $this->hasMany('App\sub_topics');
    }

    public function posts(){
        return $this->hasMany('App\posts');
    }

    public function comments(){
        return $this->hasMany('App\comments');
    }

    public function banned($type){
        return $this->hasMany("App\\$type",'banned_by');
    }

    public function link(){
        return $this->hasMany('App\class_link_table','user_id','id');
    }

    public function accountStatus(){
        switch($this->account_status){
            case 0:
                $message = 'Already Confirmed';
                break;
            case 1:
                $message = 'Activate Account';
                break;
            case 2:
                $message = "Reset Password";
                break;
            case 4:
                $message = "Validate Email";
                break;
        }
        return $message;
    }

}
