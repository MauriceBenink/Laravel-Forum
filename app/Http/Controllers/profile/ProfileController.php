<?php

namespace App\Http\Controllers\profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function __construct()
    {

    }

    public function showProfile(){
        return view('profile/profile');
    }

    public function editProfile(){
        return view ('profile/editSelf');
    }

    public function showOtherProfile(){
        return view('profile/otherProfile');
    }

    public function editOtherProfile(){
        return view('profile/editOther');
    }
}
