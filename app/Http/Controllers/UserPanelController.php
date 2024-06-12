<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPanelController extends Controller
{
    public function render(Request $req)
    {
        $users = User::with('roles')->where('id', '!=', Auth::user()->id)->get();
        return view('pages.userPanel', ['users' => $users]);

    }
}
