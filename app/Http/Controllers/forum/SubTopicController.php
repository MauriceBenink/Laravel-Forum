<?php

namespace App\Http\Controllers\forum;

use App\sub_topics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class SubTopicController extends Controller
{
    public function __construct(Request $request)
    {
        $par = $request->route()->parameters();
        if(isset($par['subtopic'])){
            $this->middleware("path.check:{$par['maintopic']},{$par['subtopic']}",['only' => ['showEditSubTopic', 'makeEditSubTopic']]);
            $this->middleware("create.perm:3,{$par['maintopic']},{$par['subtopic']}", ['only' => ['showEditSubTopic', 'makeEditSubTopic']]);
        }else {
            $this->middleware("path.check:{$par['maintopic']}", ['except' => ['showEditSubTopic', 'makeEditSubTopic']]);
            $this->middleware("create.perm:3,{$par['maintopic']}", ['only' => ['showNewSubTopic', 'makeNewSubTopic', 'editSubTopic']]);
        }
        $this->middleware('account.status:false')->only(['showNewSubTopic', 'makeNewSubTopic', 'editSubTopic','showEditSubTopic', 'makeEditSubTopic']);

    }


    public function showSubTopics($maintopic){
        $subtopics = sub_topics::where("upper_level_id",$maintopic)->orderBy('created_at','desc')->get();

        return view('forum/sub_topic')->with(['subtopics' => $subtopics]);
    }

    public function showNewSubTopic($maintopic){

        return view('forum/new/subtopics')->with([
            'maintopic' => $maintopic
        ]);
    }

    public function showEditSubTopic($maintopic,$subtopic){

        $subtopic = sub_topics::where('id',$subtopic)->get()->first();

        return view('forum/edit/sub_topic')->with([
            'subtopic' => $subtopic,
            'maintopic' => $maintopic,
        ]);
    }


    public function editSubTopic(Request $request,$maintopic){

        switch($request->type){

            case "edit":
                return redirect("forum/$maintopic/$request->id/edit");
                break;

            case "remove":
                return $this->removeSubTopic($request->id);
                break;
            case "ban":
                return $this->banSubTopic($request->id,$request->reason);
                break;

            default :
                return redirect('forum')->with('returnError',noPermError());
        }
    }

    private function banSubTopic($id,$reason){
        $subtopic = sub_topics::find($id);

        $this->banObject($subtopic,$reason);

        return redirect(url()->current());
    }

    private function removeSubTopic($id){

        sub_topics::killme(sub_topics::find($id));

        return redirect(url()->current());
    }

    public function makeEditSubTopic(Request $request,$maintopic,$subtopic)
    {

        $sub = sub_topics::find($subtopic);

        if (user_edit_permission($sub)) {

            $this->EditSubTopicValidator($request->all())->validate();

            $sub->description = $request->description;
            $sub->name = $request->title;
            $sub->user_level_req_vieuw = $request->cansee;

            if (Auth::user()->level >= subtopiclevel()) {
                if (isset($request->canedit)) {
                    $sub->user_level_req_edit = $request->canedit;
                }
                if (isset($request->priority)) {
                    $sub->priority = $request->priority;
                }
                if (isset($request->author)) {
                    $sub->user_id = $request->author;
                }
                if (isset($request->upper)) {
                    $sub->upper_level_id = $request->upper;
                }
            }

            $sub->save();

            $this->specialperm($sub, $request->specialperm0, $request->specialperm1);

            return redirect("forum/$maintopic");
        }
        return redirect('forum')->with('returnError', noPermError());
    }

    public function EditSubTopicValidator(array $data){

        return Validator::make($data, [
            'author' => "exists:users,id|integer",
            'description' => "required|min:10|max:200",
            'title' => "required|min:10|max:50",
            'cansee' =>"required|integer|max:".Auth::user()->level."|min:0",
            'canedit' =>"integer|max:".Auth::user()->level."|min:".subtopiclevel(),
            'priority' => "required|integer|max:9|min:0",
            'upper' => "integer|exists:posts,id"
        ]);
    }


    public function makeNewSubTopic(Request $request,$maintopic){

        $this->NewSubTopicValidator($request->all())->validate();

        $send =[
            'user_id' => $request->user_id,
            'name' => $request->title,
            'description' => $request->description,
            'upper_level_id' => $maintopic,
            'user_level_req_vieuw' => $request->cansee,
            'user_level_req_edit' => subtopiclevel(),
        ];

        Auth::user()->subTopics()->save($send = new sub_topics($send));

        return redirect("forum/{$maintopic}/{$send->id}");
    }

    protected function NewSubTopicValidator(array $data)
    {
        return Validator::make($data, [
            'title' => "required|min:10|max:50",
            'description' => "required|min:10|max:500",
            'cansee' =>"required|integer|max:".Auth::user()->level."|min:0",
            'user_id' => "exists:users,id|integer|max:".Auth::user()->level."|min:".Auth::user()->level,
        ]);
    }
}
