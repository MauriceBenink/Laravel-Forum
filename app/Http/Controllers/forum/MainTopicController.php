<?php

namespace App\Http\Controllers\forum;

use App\main_topics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainTopicController extends Controller
{
    public function showMainTopics(){
        $maintopic = main_topics::all();

        return view('forum/main_topic')->with(['maintopics' => $maintopic]);
    }
}
