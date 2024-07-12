<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laratrust\Models\Role;

class ActivateProfileController extends Controller
{


    protected function operatorRolesAndTeams($uid, $rolesAndTeam)
    {
        $role = Role::where('name', $rolesAndTeam)->first();
        $user = User::with('roles', 'permissions')->where('uid', $uid)->first();
        $oldPermissions = $user->permissions;
        $rolesRemoved = $user->removeRole($user->roles[0], $user->roles[0]);
        foreach ($oldPermissions as $oldPermission) {
            $user->removePermission($oldPermission, $user->roles[0]);
        }
        if ($rolesRemoved) {
            try {
                $rolesAdded = $user->addRole($role);
                $newdPermissions = $user->givePermissions(['read', 'create']);
                $updatedUser = User::with('roles', 'permissions')->where('uid', $uid)->first();
                session(['user' => '']);
                session(['user' => $updatedUser]);
                return true;
            } catch (\Illuminate\Database\QueryException $exception) {
                if ($exception->errorInfo[2]) {
                    return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
                } else {
                    return  redirect()->back()->with('error', $exception->errorInfo[2]);
                }
            }
        } else {
            return false;
        }
    }


    public function activateProfile(Request $req)
    {
        $prefixSelect = substr(trim($req->activationCode), 0, 2);
        // switch ($prefixSelect) {
        //     case "DL":
        //         $delegateActivated = $this->activateDelegate($req);
        //         return $delegateActivated ? redirect()->back()->with('message', 'Delegation Updated Successfully') : redirect()->back()->with('error', 'Delegation already assigned');
        //         break;
        //     case "CA":
        //         $carOperator = $this->activateCarOperator($req);
        //         return $carOperator ? redirect()->back()->with('message', 'Car Operator Updated Successfully') : redirect()->back()->with('error', 'Operator already assigned');
        //         break;
        //     default:
        //         return redirect()->back()->with('error', 'Something Went Wrong');
        // }
    }

    public function renderProfileActivation()
    {
        $user = User::with('roles', 'permissions')->where('id', Auth::user()->id)->first();
        return view('pages.dashboard', ['user' => $user]);
    }
}
