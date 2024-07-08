<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use App\Models\User;

class MailOtpController extends Controller
{
    public function html_email($id)
    {
        try {
            $user = User::where("uid", $id)->firstOrFail();
            $user = json_decode($user);
            $host = request()->getHttpHost();
            if ($user) {
                $data = array('user' => $user, 'host' => $host);
                $myEmail = $user->email;
                Mail::send('pages.mails.otp', $data, function ($message) use ($myEmail) {
                    $message->to($myEmail, "VMS")->subject('Your Activation Code');
                    $message->bcc("abdul.moeid@badarexpo.com", "VMS")->subject('Your Activation Code');
                    $message->from("noreply.badarvms@gmail.com", "VMS REGISTRATION");
                });
                return true;
            }
        } catch (QueryException $exception) {
            print_r($exception->errorInfo);
        }
    }
}
