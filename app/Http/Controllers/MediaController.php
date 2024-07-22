<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaGroup;
use App\Models\MediaStaff;
use App\Models\StaffImages;
use App\Models\CnicBack;
use App\Models\CnicFront;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MediaController extends Controller
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
        $role = Role::where('name', 'mediaRep')->first();
        $permission = Permission::where('name', 'read')->first();
        $user->addRole($role);
        $user->givePermissions(['read', 'create', 'update', 'delete']);
    }

    // User Creatuib on request

    protected function newUserCreate($username, $email, $uid)
    {
        $pass = Str::password(12, true, true, true, false);
        $user = new User();
        $user->uid = $uid;
        $user->name = $username;
        $user->email = $email;
        $user->password = Hash::make($pass);
        $user->activation_code = $this->badge(8, "");
        $user->activated = 1;
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
        return view('pages.mediaGroups');
    }

    public function getMedia()
    {
        $mediaGroups = MediaGroup::all();
        foreach ($mediaGroups as $key => $mediaGroup) {
            $mediaGroups[$key]->functionaryCount = MediaGroup::where('uid', $mediaGroup->uid)->where('staff_type', 'Functionary')->count();
            $mediaGroups[$key]->temporaryCount = MediaGroup::where('uid', $mediaGroup->uid)->where('staff_type', 'Temporary')->count();
        }
        return $mediaGroups;
    }

    public function addMedia()
    {
        return view('pages.addMediaGroup');
    }

    public function getMediaStats()
    {
        $mediaGroups = MediaGroup::all(['media_name', 'uid']);
        foreach ($mediaGroups as $key => $mediaGroup) {
            $mediaGroups[$key]->sent = MediaStaff::where('uid', $mediaGroup->uid)->where('media_staff_security_status', 'sent')->count();
            $mediaGroups[$key]->pending = MediaStaff::where('uid', $mediaGroup->uid)->where('media_staff_security_status', 'pending')->count();
            $mediaGroups[$key]->rejected = MediaStaff::where('uid', $mediaGroup->uid)->where('media_staff_security_status', 'rejected')->count();
            $mediaGroups[$key]->approved = MediaStaff::where('uid', $mediaGroup->uid)->where('media_staff_security_status', 'approved')->count();
        }
        return $mediaGroups;
    }

    public function addMediaRequest(Request $req)
    {
        $mediaGroup = new MediaGroup();
        $mediaGroup->uid = (string) Str::uuid();
        $mediaGroup->company_rep_uid = (string) Str::uuid();
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $mediaGroup[$key] = $value;
            }
        }
        try {
            $mediaGroupSaved = $mediaGroup->save();
            $userCreated = $this->newUserCreate($mediaGroup->company_rep_name, $mediaGroup->company_rep_email, $mediaGroup->uid);
            if ($mediaGroupSaved && $userCreated) {
                return $req->submitMore ? redirect()->route('pages.addMedia')->with('message', 'Media Group has been updated Successfully') : redirect()->route('pages.media')->with('message', 'Organization has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    public function updateMediaRequest(Request $req, $id)
    {
        $arrayToBeUpdate = [];
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key !=  'media_rep_email' &&  $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $arrayToBeUpdate[$key] = $value;
            }
        }
        try {
            $updatedMedia = MediaGroup::where('uid', $id)->update($arrayToBeUpdate);
            if ($updatedMedia) {
                return $req->submitMore ? redirect()->route('pages.addMedia', $id)->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.mediaGroups')->with('message', 'Organization has been updated Successfully');
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
