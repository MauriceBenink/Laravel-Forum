<?php

/**
 * Here you'll be able to find all default value's
 *
 */



if(! function_exists("profileEditLevel")){

    function profileEditLevel(){
        return 6;
    }
}

if(! function_exists("display_req")){

    function display_req(){
       return 'min:7|max:50|unique:users';
    }
}

if(! function_exists("email_req")){

    function email_req(){
        return 'email|max:255|unique:users|confirmed';
    }
}

if(! function_exists("login_req")){

    function login_req(){
        return "min:7|max:255|confirmed|unique:users";
    }
}

if(! function_exists('defaultBanPNG')){

    function defaultBanPNG(){
        return server_url()."\profilePhotos\banned.png";
    }
}

if(! function_exists('defaultBanPop')){

    function defaultBanPop(){
        return ":(";
    }
}

if(!function_exists('validation_level')){
    function validation_level(){
        return 2;
    }
}

if(! function_exists('defaultBanDisplay')){

    function defaultBanDisplay(){
        return "Deleted Account";
    }
}

if(! function_exists('noPermError')){
    /**
     * @return mixed standard no permission error
     */

    function noPermError(){
        return "You do not have the required permissions !";
    }
}

if(! function_exists('defaultPNG')){

    /**
     * @return mixed urlPath to default png
     */


    function defaultPNG(){
        return server_url()."\profilePhotos\default.png";
    }
}

if(! function_exists('MNC')){

    function MNC(){
        return "Make new ".comment();
    }
}

if(! function_exists('MNP')){

    function MNP(){
        return "Make new ".post();
    }
}

if(! function_exists('MNS')){

    function MNS(){
        return "Make new ".subtopic();
    }
}

if(! function_exists('MNM')){

    function MNM(){
        return "Make new ".maintopic();
    }
}

if(! function_exists('BTM')){
    /**
     * Back to Subtopics
     *
     * @return string
     */
    function BTM(){
        return "Back to ".maintopic()."s";
    }
}

if(! function_exists('BTS')){
    /**
     * Back to Subtopics
     *
     * @return string
     */
    function BTS(){
        return "Back to ".subtopic()."s";
    }
}

if(! function_exists('BTP')){
    /**
     * Back to Subtopics
     *
     * @return string
     */
    function BTP(){
        return "Back to ".post()."s";
    }
}

if(!function_exists('commentlevel')){
    /**
     * default level for making comments
     *
     * @return int
     */
    function commentlevel(){
        return 2;
    }
}

if(!function_exists('postlevel')){
    /**
     * default level for making posts
     *
     * @return int
     */
    function postlevel(){
        return 4;
    }
}

if(!function_exists('subtopiclevel')){
    /**
     * default level for making subtopics
     *
     * @return int
     */
    function subtopiclevel(){
        return 6;
    }
}

if(!function_exists('maintopiclevel')){
    /**
     * default level for making maintopics
     *
     * @return int
     */
    function maintopiclevel(){
        return 8;
    }
}

if(!function_exists('post')){
    /**
     * Standard name for posts
     * @return string
     */
    function post(){
        return "Post";
    }
}

if(!function_exists('comment')){
    /**
     * Standard name for comments
     * @return string
     */
    function comment(){
        return "Comment";
    }
}

if(!function_exists('subtopic')){
    /**
     * Standard name for subtopcis
     * @return string
     */
    function subtopic(){
        return "SubTopic";
    }
}

if(!function_exists('maintopic')){
    /**
     * Standard name for maintopics
     * @return string
     */
    function maintopic(){
        return "MainTopic";
    }
}