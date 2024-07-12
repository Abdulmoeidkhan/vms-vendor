<?php

namespace App\Http\Controllers;

use App\Models\ImageBlob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
{
    protected function isActivated($req)
    {
        $user = User::where('email', $req->email)->first();
        return $user ? $user->activated : false;
    }
    protected function isAvailable($req)
    {
        $user = User::where('email', $req->email)->first();
        return $user ? true : false;
    }
    public function signIn(Request $req)
    {
        $credentials = $req->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if ($this->isAvailable($req)) {

            if ($this->isActivated($req)) {
                if (Auth::attempt($credentials)) {
                    $req->session()->regenerate();
                    $user = User::with('roles', 'permissions')->where('id', Auth::user()->id)->first();
                    // switch ($user->roles[0]->name) {
                    //     case "delegate":
                    //         $delegation = Delegation::where('user_uid', Auth::user()->uid)->first('uid');
                    //         $delegation ? $user->delegationUid = $delegation->uid : null;
                    //         break;
                    //     case "liason" || "interpreter" || "receiving":
                    //         $user->officerUid = Officer::where('officer_user', Auth::user()->uid)->first('officer_uid');
                    //         break;
                    //     default:
                    //         return redirect()->back()->with('error', 'Something Went Wrong');
                    // }
                    $user->images = ImageBlob::where('uid', Auth::user()->uid)->first();
                    session(['user' => $user]);
                    return redirect()->route('pages.dashboard')->with('message', "You have successfully Signed In")->with('flash_message', "If you need to install this App please click below");
                } else {
                    return redirect()->route('login')->with('error', "Password credentials do not match our records.");
                }
            }
            // else {
            //     return redirect()->route('accountActivation')->with('error', "User is not activated");
            // }
        } else {
            return redirect()->route('login')->with('error', "User does not exist");
        }
    }
}
