<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ImageBlob;
use Laratrust\Models\Role;
use Illuminate\Http\Request;
use Laratrust\Models\Permission;
use App\Http\Controllers\Controller;

class UserFullProfileController extends Controller
{
    public function render(Request $req, $id)
    {
        $roles = Role::all();
        $selectiveRoles = Role::all();
        $permissions = Permission::all();
        $user = User::with('roles', 'permissions')->where('uid', $id)->first();
        $image = ImageBlob::where('uid', $id)->first();
        $user->images = $image;
        return view('pages.profileUser', ['user' => $user, 'roles' => $roles, 'permissions' => $permissions, 'selectiveRoles' => $selectiveRoles]);
    }
    public function renderMyProfile(Request $req)
    {
        $roles = Role::all();
        $selectiveRoles = Role::all();
        $permissions = Permission::all();
        $user = session('user');
        return view('pages.profileUser', ['user' => $user,  'roles' => $roles, 'permissions' => $permissions, 'selectiveRoles' => $selectiveRoles]);
    }

}
