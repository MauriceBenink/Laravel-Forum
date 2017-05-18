<?php

namespace App\Http\Controllers\profile;

use App\profile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['showOtherProfile']);
        $this->middleware('level:'.profileEditLevel())->only(['editOtherProfile','makeEditOtherProfile']);
    }

    public function showProfile(){
        return view('profile/profile');
    }

    public function editProfile(){
        return view ('profile/editSelf');
    }

    public function makeEditProfilePicture(Request $request, $profile){
        $user = User::where('display_name',$profile)->get()->first();
        if(!is_null($user)) {
            if ($user->id == Auth::user()->id || Auth::user()->level >= profileEditLevel()) {

                $path = "\profilePhotos\\$user->id.png";

                $this->ProfilePictureValidator($request->all())->validate();

                $img = Image::make($_FILES['image']['tmp_name'])->fit(300,200);
                $img->save($_SERVER['DOCUMENT_ROOT'].$path);

                $user->png = $path;
                $user->save();
            }
        }

        if($user->id == Auth::user()->id ){
            return redirect('profile');
        }
        return redirect("profile/show/$user->display_name");
    }

    public function editProfilePicture($profile){
        $user = User::where('display_name',$profile)->get()->first();
        if(!is_null($user)) {
            if($user->id == Auth::user()->id||Auth::user()->level >= profileEditLevel()) {
                return view('profile/editprofilepicture')->with(['user' => $user]);
            }
            return redirect("forum")->with("returnError","You do not have the permissions to do this");
        }
        return redirect("forum")->with("returnError","This Profile doesnt exist");
    }

    public function showOtherProfile($profile){
        $user = User::where('display_name',$profile)->get()->first();
        if(!is_null($user)) {
            return view('profile/otherProfile')->with(['user' => $user]);
        }
        return redirect("forum")->with("returnError","This Profile doesnt exist");
    }

    public function editOtherProfile($profile){
        $user = User::where('display_name',$profile)->get()->first();
        if(!is_null($user)) {
            return view('profile/editOther')->with(['user' => $user]);
        }
        return redirect("forum")->with("returnError","This Profile doesnt exist");
    }

    public function makeEditProfile(Request $request){
        $profile = profile::where("user_id",Auth::user()->id)->get()->first();
        $user = User::where('id',Auth::user()->id)->get()->first();


        $this->ProfileValidator($request->all())->validate();


        $profile->name = $request->real_name;
        $profile->bio = $request->bio;
        $profile->birthday = $request->bday;
        $profile->site = $request->site;
        $profile->github = $request->github;

        $user->location = $request->location;
        $user->comment_footer = $request->footer;

        $profile->save();
        $user->save();

        return redirect('profile');

    }

    public function makeEditOtherProfile(Request $request,$profile){
        $user = User::where('display_name',$profile)->get()->first();
        $profile = profile::where("user_id",$user->id)->get()->first();

        if($request->displayname === $user->display_name){
            unset($request->displayname);
        }
        if($request->email === $user->email){
            unset($request->email);
        }

        $this->ProfileValidator($request->all())->validate();

        $profile->name = $request->real_name;
        $profile->bio = $request->bio;
        $profile->birthday = $request->bday;
        $profile->site = $request->site;
        $profile->github = $request->github;

        $user->location = $request->location;
        $user->comment_footer = $request->footer;

        if(isset($request->level)){
            $user->level = $request->level;
        }
        if(isset($request->display_name)){
            $user->display_name = $request->display_name;
        }
        if(isset($request->email)){
            $user->email = $request->email;
        }

        $profile->save();
        $user->save();

        return redirect(url_remove(url()->current()));
    }

    private function ProfilePictureValidator(array $data)
    {
        return Validator::make($data,[
            'image' => 'image'
        ]);
    }


    private function ProfileValidator(array $data)
    {
        return Validator::make($data, [
            "display_name" => 'nullable|'.display_req(),
            "level" => "nullable|integer|exists:levels,level|max:".Auth::user()->level,
            "email" => 'nullable|'.email_req(),
            "file" => 'nullable|image',
            "comment_footer" => "nullable|min:5|max:500",
            "real_name" => 'nullable|min:2|max:50',
            "bio" => "nullable|min:10|max:2000",
            "location" => "nullable|min:5|max:50",
            "bday" => "nullable|date",
            "site" => "nullable|url",
            "github" => "nullable",
        ]);
    }
}
