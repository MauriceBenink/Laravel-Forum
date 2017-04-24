<?php

use \Illuminate\Support\Facades\Auth;

if(! function_exists('defaultPNG')){

    /**
     * @return mixed urlPath to default png
     */


    function defaultPNG(){
        return 'default path';
    }
}

if(! function_exists('url_add')) {


    /*
    adds to the url
    */

    function url_add($addition)
    {
        $new = url()->current() . '/' . $addition;
        return url($new);
    }
}

if(!function_exists('user_permission')){

    /**
     * @param object $object
     *
     * @return bool
     */

    function user_permission($object){


        if(is_null(Auth::user())){
            if($object->user_level_req_vieuw != 0){
                return false;
            }
        }
        if(Auth::user()->id != $object->user_id) {
            if (Auth::user()->level < $object->user_level_req_vieuw) {
                if(empty(specialPermission($object))){
                    return false;
                }
            }
        }

        return true;
    }
}

if(!function_exists('user_edit_permission')){

    /**
     * @param object $object
     *
     * @return bool
     */

    function user_edit_permission($object){
        if(is_null(Auth::user())){
            return false;
        }

        if(Auth::user()->id != $object->user_id) {
            if (Auth::user()->level < $object->user_level_req_vieuw) {
                $perm = specialPermission($object);
                if(empty($perm)){
                    return false;
                }
                if($perm[0]->permission == 0){
                    return false;
                }
            }
        }
        return true;
    }
}

if(!function_exists("specialPermission")){
    /**
     * @param object $object
     *
     * @return mixed
     */

    function specialPermission($object){
        if(class_basename($object) == 'main_topics'){
            return false;
        }
        $type = class_basename($object);
        $id = Auth::user()->id;

       return  \Illuminate\Support\Facades\DB::select("
SELECT c.id as userId,p.id as userGroupId,k.id as contentGoupId,c.user_id,p.user_group_id,k.content_group_id,
        IF(!ISNULL(c.{$type}_id),c.{$type}_id,IF(!ISNULL(p.{$type}_id),p.{$type}_id,k.{$type}_id))as{$type}_id,           
	    IF((c.permission > k.permission AND c.permission > p.permission) OR (ISNULL(p.permission) AND ISNULL(k.permission)),c.permission,IF(k.permission > p.permission OR ISNULL(p.permission),k.permission,p.permission))as permission
       
FROM class_link_tables c

LEFT JOIN class_link_tables p
ON c.`user_group_id` = p.`user_group_id`

LEFT JOIN class_link_tables k
ON c.content_group_id OR p.content_group_id = k.content_group_id

WHERE c.user_id = {$id} AND (c.{$type}_id = {$object->id} OR k.{$type}_id = {$object->id} OR p.{$type}_id = {$object->id})
ORDER BY permission DESC");
    }
}
