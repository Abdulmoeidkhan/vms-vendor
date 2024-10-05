<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ImageBlob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laratrust\Models\Role;
use Laratrust\Models\Permission;


class UpdateProfileController extends Controller
{
    protected function badge($characters, $prefix)
    {
        $possible = '0123456789';
        $code = $prefix;
        $i = 0;
        while ($i < $characters) {
            $code .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            if ($i < $characters - 1) {
                $code .= "";
            }
            $i++;
        }
        return $code;
    }

    public function updateProflie(Request $req)
    {
        $contact_number = str_replace(['+', '-'], '', $req->inputContactNumber);
        User::where('uid', $req->uid)->update(['name' => $req->inputUserName, 'contact_number' => $contact_number]);
        $user = User::with('roles', 'permissions')->where('uid', $req->uid)->first();
        $user->images = ImageBlob::where('uid', $req->uid)->first();
        if ($req->uid === Auth::user()->uid) {
            session(['user' => '']);
            session(['user' => $user]);
        }
        return "Profile has been updated";
        // return $user;
    }

    public function updateAuthority(Request $req)
    {
        $user = User::with('roles', 'permissions')->where('uid', $req->uid)->first();
        $roleToBeAdd = Role::where('name', $req->role)->first();
        $allPermissions = Permission::all();
        $rolesRemoved = $user->removeRole($user->roles[0], $user->roles[0]);
        $rolesAdded = $user->addRole($roleToBeAdd);
        $oldPermissions = $user->permissions;
        foreach ($oldPermissions as $oldPermission) {
            $user->removePermission($oldPermission, $user->roles[0]);
        }
        $newPermissions = $req->permissions;
        $permissionsToBeGrant = [];
        foreach ($newPermissions as $newPermission) {
            foreach ($allPermissions as $permission) {
                $permission->name == $newPermission && array_push($permissionsToBeGrant, $permission);
            }
        }

        $permissionsAdded = $user->givePermissions($permissionsToBeGrant);
        $updatedUser = User::with('roles', 'permissions')->where('uid', $req->uid)->first();
        return "Profile has been updated";
    }
    
    public function updatePassword(Request $req)
    {
        $password = Hash::make($req->userInputPassword);
        $activation_code = $this->badge(8, "");
        // return $req->userInputPassword;
        User::where('uid', $req->uid)->update(['password' => $password, 'activation_code' => $activation_code, 'activated' => 1]);
        return "Profile has been updated";
    }
}
