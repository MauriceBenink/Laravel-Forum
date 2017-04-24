<?php

/**
 * Here you'll be able to find all default value's
 *
 */

if(! function_exists('defaultPNG')){

    /**
     * @return mixed urlPath to default png
     */


    function defaultPNG(){
        return 'default path';
    }
}


if(! function_exists('MNC')){

    function MNC(){
        return 'Make new Comment';
    }
}

if(! function_exists('MNP')){

    function MNP(){
        return 'Make new Post';
    }
}

if(! function_exists('MNS')){

    function MNS(){
        return 'Make new SubTopic';
    }
}

if(! function_exists('MNM')){

    function MNM(){
        return 'Make new MainTopic';
    }
}

if(! function_exists('BTM')){
    /**
     * Back to Subtopics
     *
     * @return string
     */
    function BTM(){
        return "Back to MainTopics";
    }
}

if(! function_exists('BTS')){
    /**
     * Back to Subtopics
     *
     * @return string
     */
    function BTS(){
        return "Back to SubTopics";
    }
}

if(! function_exists('BTP')){
    /**
     * Back to Subtopics
     *
     * @return string
     */
    function BTP(){
        return "Back to Posts";
    }
}