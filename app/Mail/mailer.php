<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class mailer extends Mailable
{
    use Queueable, SerializesModels;


    public static $to_user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }

    public static function registration($user){
        if($user->account_status != 1){
            return redirect('/');
        }

        $data = array(
            'user' => $user,
        );

        Mail::send('emails.registration', $data, function ($message) {

            $message->from('LaravelForum@gmail.com', 'Forum@noreply');

            $message->to(Auth::user()->email)->subject("Register Email for laravel forum");

        });
    }

    public static function forgotUsername($user){

        if($user->account_status != 3){
            return redirect('/');
        }

        $holder = self::mailsetup($user);

        Mail::send('emails.usernameReset', $holder[0], $holder[1]);
    }

    public static function forgotPass($user){

        if($user->account_status != 2){
            return redirect('/');
        }

        $holder = self::mailsetup($user);
        Mail::send('emails.passwordReset', $holder[0], $holder[1]);
    }

    private static function mailsetup($user){

        $data = array(
            'user' => $user,
        );

        self::$to_user = $user->email;

        $message = function ($message) {

            $message->from('LaravelForum@gmail.com', 'Forum@noreply');

            $message->to(self::$to_user)->subject("Password reset");

        };

        return [$data,$message];
    }
}
