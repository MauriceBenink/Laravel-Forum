<?php

use \Illuminate\Support\Facades\Auth;

include "default.php";

if(file_exists($_SERVER['DOCUMENT_ROOT'].'\..\app\Http\customEncrypt.php')){
    include 'customEncrypt.php';
}

/**
 * Custom Helper Commands
 */


if(! function_exists('auth_level')){
    /**
     * @param int $level
     *
     * Auth user is bigger or equal to level
     *
     * @return boolean
     */

    function auth_level($level){
        if(!is_null(Auth::user())){
            if(Auth::user()->level >= $level){
                return true;
            }
        }
        return false;
    }
}

if(! function_exists('newItem')){

    /**
     * @param string $type
     *
     * @return mixed
     */
    function newItem($type)
    {
        if (!is_null(Auth::user())) {
            switch ($type) {
                case 1:
                case "comment":
                    if(Auth::user()->level >= commentlevel()){
                        return true;
                    }
                    break;

                case 2:
                case "post":
                    if(Auth::user()->level >= postlevel()){
                        return true;
                    }
                    break;
                case 3:
                case "subtopic":
                    if(Auth::user()->level >= subtopiclevel()){
                        return true;
                    }

                    break;
                case 4:
                case "maintopic":
                    if(Auth::user()->level >= maintopiclevel()){
                        return true;
                    }
                    break;
            }
        }
        return false;
    }
}

if (!function_exists('url_remove')){
    /**
     * removes from the url input
     *
     * @param  mixed $input
     *
     * @return mixed
     */
    function url_remove($input = null){
        if($input == null){
            $input = url()->current();
        }


        $holder = explode('/',$input);
        unset($holder[count($holder)-1]);
        return (implode('/',$holder));
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
        if(!is_null($object->banned_by)){
            return false;
        }

        if(is_null(Auth::user())){
            if($object->user_level_req_vieuw != 0){
                return false;
            }
        }else {
            if (Auth::user()->id != $object->user_id) {
                if (Auth::user()->level < $object->user_level_req_vieuw) {
                    if (empty(specialPermission($object))) {
                        return false;
                    }
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
            if (Auth::user()->level < $object->user_level_req_edit) {
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
