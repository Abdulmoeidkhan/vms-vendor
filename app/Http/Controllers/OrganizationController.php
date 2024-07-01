<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\OrganizationStaff;
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

    // User Creatuib on request

    public function newUserCreate($username, $email, $uid)
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


    // Main Organizations Request

    public function render()
    {
        return view('pages.organizations');
    }

    public function getOrganizations()
    {
        $organization = Organization::all();
        return $organization;
    }

    // Organization and staff render page 
    public function renderOrganisation($id)
    {
        return view('pages.organization', ['id' => $id]);
    }

    public function getOrganizationStaff($id)
    {
        $organizationStaff = OrganizationStaff::where('company_uid', $id)->get();
        return $organizationStaff;
    }

    public function addOrganizationStaffRender($id, $staffId = null)
    {
        $staff = $staffId ? OrganizationStaff::where('uid', $staffId)->first() : null;
        return view('pages.addOrganizationStaff', ['company_uid' => $id, 'staff' => $staff]);
    }

    public function addOrganizationStaff(Request $req, $id, $staffId = null)
    {
        $organizationStaff = new OrganizationStaff();
        $organizationStaff->uid = (string) Str::uuid();
        $organizationStaff->company_uid = $id;
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $organizationStaff[$key] = $value;
            }
        }
        try {
            $organizationStaffSaved = $organizationStaff->save();
            if ($organizationStaffSaved) {
                return $req->submitMore ? redirect()->route('pages.addOrganizationStaff', $staffId)->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.organization', $id)->with('message', 'Staff has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    public function updateOrganizationStaff(Request $req, $staffId)
    {
        $arrayToBeUpdate = [];
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' &&  $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $arrayToBeUpdate[$key] = $value;
            }
        }
        try {
            $updatedOrganisationStaff = OrganizationStaff::where('uid', $staffId)->update($arrayToBeUpdate);
            $company_uid = OrganizationStaff::where('uid', $staffId)->first('company_uid');
            if ($updatedOrganisationStaff) {
                return $req->submitMore ? redirect()->route('pages.addOrganizationStaff', ['id' => $company_uid->company_uid, 'staffId' => $staffId])->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.organization', $company_uid->company_uid)->with('message', 'Staff has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }


    // Organization Add/Update Form Render & Request
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
            $userCreated = $this->newUserCreate($organization->company_rep_name, $organization->company_rep_email, $organization->uid);
            if ($organizationSaved && $userCreated) {
                return $req->submitMore ? redirect()->route('pages.addOrganization')->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.organizations')->with('message', 'Organization has been updated Successfully');
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
            if ($key != 'submit' && $key !=  'company_rep_email' &&  $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $arrayToBeUpdate[$key] = $value;
            }
        }
        try {
            $updatedOrganisation = Organization::where('uid', $id)->update($arrayToBeUpdate);
            if ($updatedOrganisation) {
                return $req->submitMore ? redirect()->route('pages.addOrganization', $id)->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.organizations')->with('message', 'Organization has been updated Successfully');
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
