<?php

namespace App\Http\Controllers\forum;

use App\main_topics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MainTopicController extends Controller
{

    public function __construct(Request $request)
    {
        $par = $request->route()->parameters();

        $this->middleware("create.perm:4",['only' => ['showNewMainTopics', 'makeNewMainTopic','editMainTopic']]);
        if(isset($par['maintopic'])){
            $this->middleware("path.check:{$par['maintopic']}",['only' => ['showEditMainTopic', 'makeEditMainTopic']]);
            $this->middleware("create.perm:4,{$par['maintopic']}",['only' => ['showEditMainTopic', 'makeEditMainTopic']]);
        }
    }

    public function showMainTopics(){
        $maintopic = main_topics::orderBy('created_at','desc')->get();;

        return view('forum/main_topic')->with(['maintopics' => $maintopic]);
    }

    public function showNewMainTopics(){
        return view('forum/new/maintopics');
    }

    public function showEditMainTopic($maintopic){

        $maintopic = main_topics::where('id',$maintopic)->get()->first();

        return view("forum/edit/main_topic")->with([
            'maintopic' => $maintopic,
        ]);
    }

    public function editMainTopic(Request $request){

        switch($request->type){

            case "edit":
                return redirect("forum/{$request->id}/edit");
                break;

            case "remove":
                return $this->removeMainTopic($request->id);
                break;
            case "ban":
                return $this->banMainTopic($request->id,$request->reason);
                break;

            default :
                return redirect('forum')->with('returnError',noPermError());
        }
    }

    private function banMainTopic($id,$reason){
        $maintopic = main_topics::find($id);

        $this->banObject($maintopic,$reason);

        return redirect(url()->current());
    }

    private function removeMainTopic($id){

        main_topics::killme(main_topics::find($id));

        return redirect(url()->current());
    }

    public function makeEditMainTopic(Request $request,$maintopic){

        $main = main_topics::find($maintopic);

       if(user_edit_permission($main)){

        }
    }


    public function makeNewMainTopic(Request $request){

        $request['user_id'] = Auth::user()->id;

        $this->NewMainTopicValidator($request->all())->validate();

        $new = new main_topics;

        $new->name = $request->title;
        $new->description = $request->description;
        $new->user_level_req_vieuw = $request->cansee;
        $new->user_level_req_edit = maintopiclevel();

        $new -> save();

        return redirect("forum");
    }

    protected function NewMainTopicValidator(array $data)
    {
        return Validator::make($data, [
            'title' => "required|min:10|max:50",
            'description' => "required|min:10|max:500",
            'cansee' =>"required|integer|max:".Auth::user()->level."|min:0",
            'user_id' => "exists:users,id",
        ]);
    }
}
