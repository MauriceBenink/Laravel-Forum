<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Messages;
use App\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showMessages(){
        return view('message/main');
    }

    public function showsend($link = null){
        return view('message/send')->with([
            'link' => $link,
        ]);
    }

    public function showMessage($id){
        $message = Messages::where('id',$id)->get()->first();
        if(is_null($message)){
            return redirect('message')->with('returnError','This message doesnt exist !');
        }
        if(!(Auth::user()->id == $message->reciever || Auth::user()->id == $message->sender)){
            if(Auth::user()->level < min_mod_level()){
                return redirect('message')->with('returnError','You dont have the permissions to see this');
            }
        }

        if(!$message->is_read){
            if($message->reciever == Auth::user()->id) {
                $message->is_read = true;
                $message->save();
            }
        }

        if(!is_null($message->reply_to)){
            $upper = Messages::where('reply_to',$message->reply_to)->orderBy('created_at')->get()->all();
            $first = Messages::where('id',$message->reply_to)->get()->first();
        }

        return view('message/show')->with([
            'message' => $message,
            'upper' => isset($upper)?$upper:null,
            'first' => isset($first)?$first:null,
        ]);
    }

    public function showInbox(){
        $inbox = Messages::where('reciever',Auth::user()->id)->where('reciever_delete','0')->orderBy('created_at','desc')->get()->all();
        return view('message/inbox')->with([
            'inbox' => $inbox
        ]);
    }

    public function showOutbox(){
        $outbox = Messages::where('sender',Auth::user()->id)->where('sender_delete','0')->orderBy('created_at','desc')->get()->all();
        return view('message/outbox')->with([
            'outbox' => $outbox
        ]);
    }

    public function deleteMessage(Request $request){
        $message = Messages::where('id',$request->message)->get()->first();

        if(!(Auth::user()->id == $message->reciever || Auth::user()->id == $message->sender)){
            if(Auth::user()->level < min_mod_level()){
                return redirect('message')->with('returnError','You dont have the permissions to see this');
            }
        }

        if($message->sender == Auth::user()->id){
            $message->sender_delete = true;
            $return = 'outbox';
        }else{
            $message->reciever_delete = true;
            $return = "inbox";
        }

        if($message->sender_delete && $message->reciever_delete){
            Messages::destroy($message->id);
        }

        $message->save();

        return redirect("message/$return");
    }

    public function replyMessage($id,Request $request){

        Validator::make([
            'id' => $id,
            'message' => $request->message,
            'title' => $request->title,
        ],[
            'id' => 'required|integer|exists:messages',
            'message' => 'required|min:4',
            'title' => 'required|min:4',
        ])->validate();

        $reply = Messages::where('id',$id)->get()->first();

        $message = new Messages();

        $message->sender = Auth::user()->id;
        $message->reciever = $reply->sender == Auth::user()->id?$reply->reciever:$reply->sender;
        $message->subject = $request->title;
        $message->message = $request->message;
        $message->reply_to = is_null($reply->reply_to)?$reply->id:$reply->reply_to;

        $message->save();

        return redirect('message/outbox');

    }

    public function sendMessage(Request $request){
        Validator::make([
            'to' => $request->to,
            'message' => $request->message,
            'title' => $request->title,
        ],[
            'to' => 'required|exists:Users,display_name',
            'message' => 'required|min:4',
            'title' => 'required|min:4',
        ])->validate();

        if(Auth::user()->account_status != 0){
            return redirect('message')->with('returnError','You must validate before you\'re able to send messages');
        }
        $receiver = User::where('display_name',$request->to)->get()->first()->id;
        if($receiver == Auth::user()->id){
            return redirect('message/send')->with('returnError','You Cant Message yourself');
        }

        $message = new Messages();

        $message->reciever = $receiver;
        $message->sender = Auth::user()->id;
        $message->subject = $request->title;
        $message->message = $request->message;
        $message->save();

        return redirect('message/outbox');
    }
}
