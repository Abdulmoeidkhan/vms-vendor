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

    // User Create on request

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

    // Media Groups
    public function render()
    {
        return view('pages.mediaGroups');
    }

    public function getMedia()
    {
        $mediaGroups = MediaGroup::all();
        foreach ($mediaGroups as $key => $mediaGroup) {
            $mediaGroups[$key]->functionaryCount = MediaStaff::where('uid', $mediaGroup->uid)->where('media_staff_type', 'Functionary')->count();
            $mediaGroups[$key]->temporaryCount = MediaStaff::where('uid', $mediaGroup->uid)->where('media_staff_type', 'Temporary')->count();
        }
        return $mediaGroups;
    }

    public function addMedia($id = null)
    {
        if ($id) {
            $mediaGroup = MediaGroup::where('uid', $id)->firstOrFail();
            return view('pages.addMediaGroup', ['mediagroup' => $mediaGroup]);
        } else {
            return view('pages.addMediaGroup');
        }
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
        $mediaGroup->media_rep_uid = (string) Str::uuid();
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $mediaGroup[$key] = $value;
            }
        }
        try {
            $mediaGroupSaved = $mediaGroup->save();
            $userCreated = $this->newUserCreate($mediaGroup->media_rep_name, $mediaGroup->media_rep_email, $mediaGroup->uid);
            if ($mediaGroupSaved && $userCreated) {
                return $req->submitMore ? redirect()->route('pages.addMedia')->with('message', 'Media Group has been updated Successfully') : redirect()->route('pages.media')->with('message', 'Media Group has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    public function updateMedia(Request $req, $id)
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
                return $req->submitMore ? redirect()->route('pages.addMedia', $id)->with('message', 'Media has been updated Successfully') : redirect()->route('pages.mediaGroups')->with('message', 'Media has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    // Media staff render page 
    public function rendermediaGroup($id)
    {
        $mediaName = MediaGroup::where('uid', $id)->first('media_name');
        $functionaryStaffLimit = MediaGroup::where('uid', $id)->first('staff_quantity');
        $functionaryStaffUpdated = MediaStaff::where('media_uid', $id)->where('media_staff_type', 'Functionary')->count();
        $functionaryStaffRemaing = $functionaryStaffLimit ? $functionaryStaffLimit->staff_quantity - $functionaryStaffUpdated : 0;
        return view('pages.mediaGroup', ['id' => $id, 'functionaryStaffLimit' => $functionaryStaffLimit, 'functionaryStaffRemaing' => $functionaryStaffRemaing, 'mediaName' => $mediaName]);
    }

    public function getMediaStaff($id)
    {
        $mediaStaff = MediaStaff::where('media_uid', $id)->get();
        foreach ($mediaStaff as $key => $staff) {
            $mediaStaff[$key]->mediaName = MediaGroup::where('uid', $staff->media_uid)->first('media_name');
            $mediaStaff[$key]->picture = StaffImages::where('uid', $staff->uid)->first('img_blob');
            $mediaStaff[$key]->cnicfront = CnicFront::where('uid', $staff->uid)->first('img_blob');
            $mediaStaff[$key]->cnicback = CnicBack::where('uid', $staff->uid)->first('img_blob');
        }
        return $mediaStaff;
    }

    public function addMediaStaffRender($id, $staffId = null)
    {
        $staff = $staffId ? MediaStaff::where('uid', $staffId)->first() : null;
        $functionaryStaffLimit = $id ? MediaGroup::where('uid', $id)->first('staff_quantity') : null;
        $functionaryStaffSaturated = $id ? (MediaStaff::where('media_uid', $id)->where('staff_type', 'Functionary')->count() < $functionaryStaffLimit->staff_quantity ? false : true) : null;
        return view('pages.addMediaStaff', ['media_uid' => $id, 'staff' => $staff, 'functionaryStaffSaturated' => $functionaryStaffSaturated]);
    }

    public function addMediaStaff(Request $req, $id, $staffId = null)
    {
        $mediaStaff = new MediaStaff();
        $mediaStaff->uid = (string) Str::uuid();
        $mediaStaff->media_uid = $id;
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $mediaStaff[$key] = $value;
            }
        }
        try {
            $mediaStaffSaved = $mediaStaff->save();
            if ($mediaStaffSaved) {
                return $req->submitMore ? redirect('organization/' . $id . '/' . 'addMediaStaff/' . $mediaStaff->uid)->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.organization', $id)->with('message', 'Staff has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    public function updateMediaStaff(Request $req, $staffId)
    {
        $arrayToBeUpdate = [];
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' &&  $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $arrayToBeUpdate[$key] = $value;
            }
        }
        try {
            $updatedOrganisationStaff = MediaStaff::where('uid', $staffId)->update($arrayToBeUpdate);
            $media_uid = MediaStaff::where('uid', $staffId)->first('media_uid');
            if ($updatedOrganisationStaff) {
                return $req->submitMore ? redirect()->route('pages.addMediaStaff', ['id' => $media_uid->media_uid, 'staffId' => $staffId])->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.organization', $media_uid->media_uid)->with('message', 'Staff has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    public function updateMediaStaffSecurityStatus(Request $req)
    {
        try {
            $updatedMediaStaff = MediaStaff::whereIn('uid', $req->uidArray)->update(['media_staff_security_status' => $req->status]);
            return $updatedMediaStaff ? 'Staff Status Updated Successfully' : 'Something Went Wrong';
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }
}
