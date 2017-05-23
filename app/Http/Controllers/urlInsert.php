<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class urlInsert
{
    private static $comment = array();
    private static $post = array();
    private static $sub_topic = array();

    public static function geturl($object){
        switch(class_basename($object)){
            case "comments" :
                if(!isset(self::$comment[$object->id])||empty(self::$comment[$object->id])) {
                    $post = $object->up;
                    $subtopic = $post->up;
                    self::$comment[$object->id] = "forum/$subtopic->upper_level_id/$subtopic->id/$post->id";
                }
                return self::$comment[$object->id];
                break;
            case "posts" :
                if(!isset(self::$post[$object->id])||empty(self::$post[$object->id])) {
                    $subtopic = $object->up;
                    self::$post[$object->id] = "forum/$subtopic->upper_level_id/$subtopic->id";
                }
                return self::$post[$object->id];
                break;
            case "sub_topics" :
                if(!isset(self::$sub_topic[$object->id])||empty(self::$sub_topic[$object->id])) {
                    self::$comment[$object->id] = "forum/$object->upper_level_id";
                }
                return self::$comment[$object->id];
                break;
        }
    }
}
