<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivationRequest extends Controller
{
    public function activation(Request $req)
    {
        $credentials = $req->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        // return $credentials;
        try {
            $userVerified = Auth::attempt($credentials);
            if ($userVerified) {
                $user = Auth::user();
                if ($user->activation_code == $req->activationCode) {
                    $activated = User::where("id", $user->id)->update(['activated' => 1]);
                    $req->session()->regenerate();
                    $user = User::with('roles', 'permissions')->where('id', Auth::user()->id)->first();
                    session(['user' => $user]);
                    return $activated ? redirect()->route('pages.dashboard')->with('message', 'Profile has been activated') : redirect()->back()->with('error', 'Something Went Wrong');
                } else {
                    Auth::logout();
                    return redirect()->back()->with('error', 'Activation Code is not correct');
                }
            } else {
                return redirect()->back()->with('error', 'Email/Password is not correct');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return  redirect()->back()->with('error', $exception->errorInfo[2]);
        }
    }
}
