<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrganizationController extends Controller
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

    protected function basicRolesAndTeams($user)
    {
        $role = Role::where('name', 'orgRep')->first();
        $permission = Permission::where('name', 'read')->first();
        $user->addRole($role);
        $user->givePermissions(['read', 'create', 'update', 'delete']);
    }

    public function newUserCreate($username, $email,$uid)
    {
        // $uid = (string) Str::uuid();
        $pass = Str::password(12, true, true, true, false);
        $user = new User();
        $user->uid = $uid;
        $user->name = $username;
        $user->email = $email;
        $user->password = Hash::make($pass);
        $user->activation_code = $this->badge(8, "");
        $savedUser = 0;
        try {
            $savedUser = $user->save();
            $this->basicRolesAndTeams($user);
            if ($savedUser) {
                $emailSent = (new AccountCreationController)->html_email($uid, $pass);
                return $emailSent ? true : false;
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Email Address already Exist error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }


    public function render()
    {
        return view('pages.organization');
    }

    public function getOrganization()
    {
        $organization = Organization::all();
        return $organization;
    }

    public function addOrganizationRender($id = null)
    {
        if ($id) {
            $organization = Organization::where('uid', $id)->firstOrFail();
            return view('pages.addOrganization', ['organization' => $organization]);
        } else {
            return view('pages.addOrganization');
        }
    }

    public function addOrganization(Request $req)
    {
        $organization = new Organization();
        $organization->uid = (string) Str::uuid();
        $organization->company_rep_uid = (string) Str::uuid();
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $organization[$key] = $value;
            }
        }
        try {
            $organizationSaved = $organization->save();
            $userCreated = $this->newUserCreate($organization->company_rep_name, $organization->company_rep_email,$organization->uid);
            if ($organizationSaved && $userCreated) {
                return $req->submitMore ? redirect()->route('pages.addOrganization')->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.organization')->with('message', 'Organization has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    public function updateOrganization(Request $req, $id)
    {
        $arrayToBeUpdate = [];
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $arrayToBeUpdate[$key] = $value;
            }
        }
        try {
            $updatedOrganisation = Organization::where('uid', $id)->update($arrayToBeUpdate);
            if ($updatedOrganisation) {
                return $req->submitMore ? redirect()->route('pages.addOrganization', $id)->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.organization')->with('message', 'Organization has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }
}
