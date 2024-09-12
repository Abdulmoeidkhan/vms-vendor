<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepoGroup;
use App\Models\DepoGuest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\StaffImages;
use App\Models\CnicBack;
use App\Models\CnicFront;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DepoGroupController extends Controller
{
    protected function codeIdentifier($type)
    {

        $code = '';
        switch ($type) {
            case 'Trade_visitor':
                $code = 'TV';
                break;
            case 'Volunteer':
                $code = 'VL';
                break;
            case 'Local_delegate':
                $code = 'LD';
                break;
            case 'Organiser':
                $code = 'OR';
                break;
            case 'Event_manager':
                $code = 'EM';
                break;
            default:
                $code = 'HR';
                break;
        }

        return $code;
    }

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
        $role = Role::where('name', 'DepoRep')->first();
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


    // Main Hr Groups Request
    public function render()
    {
        $StaffCount = DepoGuest::count();
        return view('pages.depoGroups', ['StaffCount' => $StaffCount]);
    }

    public function getDepoGroups()
    {
        $depoGroups = DepoGroup::orderBy('depo_name', 'asc')->get();
        foreach ($depoGroups as $key => $depoGroup) {
            $depoGroups[$key]->guestCount = DepoGuest::where('depo_uid', $depoGroup->uid)->count();
            $depoGroups[$key]->guestSend = DepoGuest::where('depo_uid', $depoGroup->uid)->where('depoStaff_security_status', 'sent')->count();
            $depoGroups[$key]->guestPending = DepoGuest::where('depo_uid', $depoGroup->uid)->where('depoStaff_security_status', 'pending')->count();
            $depoGroups[$key]->guestApproved = DepoGuest::where('depo_uid', $depoGroup->uid)->where('depoStaff_security_status', 'approved')->count();
            $depoGroups[$key]->guestRejection = DepoGuest::where('depo_uid', $depoGroup->uid)->where('depoStaff_security_status', 'rejected')->count();
        }
        return $depoGroups;
    }

    public function getDepoGroupsStats()
    {
        $depoGroups = DepoGroup::all(['depo_name', 'uid']);
        foreach ($depoGroups as $key => $depoGroup) {
            $depoGroups[$key]->sent = DepoGuest::where('depo_uid', $depoGroup->uid)->where('depoStaff_security_status', 'sent')->count();
            $depoGroups[$key]->pending = DepoGuest::where('depo_uid', $depoGroup->uid)->where('depoStaff_security_status', 'pending')->count();
            $depoGroups[$key]->rejected = DepoGuest::where('depo_uid', $depoGroup->uid)->where('depoStaff_security_status', 'rejected')->count();
            $depoGroups[$key]->approved = DepoGuest::where('depo_uid', $depoGroup->uid)->where('depoStaff_security_status', 'approved')->count();
        }
        return $depoGroups;
    }

    public function getSpecificDepoGroupStats()
    {
        $depoGroups = DepoGroup::where('uid', session('user')->uid)->get(['hr_name', 'uid']);
        foreach ($depoGroups as $key => $depoGroup) {
            $depoGroups[$key]->sent = DepoGuest::where('depo_uid', $depoGroup->uid)->where('depoStaff_security_status', 'sent')->count();
            $depoGroups[$key]->pending = DepoGuest::where('depo_uid', $depoGroup->uid)->where('depoStaff_security_status', 'pending')->count();
            $depoGroups[$key]->rejected = DepoGuest::where('depo_uid', $depoGroup->uid)->where('depoStaff_security_status', 'rejected')->count();
            $depoGroups[$key]->approved = DepoGuest::where('depo_uid', $depoGroup->uid)->where('depoStaff_security_status', 'approved')->count();
        }
        return $depoGroups;
    }

    // DepoGroup and staff render page 
    public function renderDepoGroup($id)
    {
        $depoName = DepoGroup::where('uid', $id)->first('hr_name');
        $depoGuestLimit = DepoGroup::where('uid', $id)->first('staff_quantity');
        $depoGuestUpdated = DepoGuest::where('depo_uid', $id)->count();
        $depoGuestRemaing = $depoGuestLimit->staff_quantity - $depoGuestUpdated;
        return view('pages.depoGroup', ['id' => $id, 'depoGuestLimit' => $depoGuestLimit, 'depoGuestRemaing' => $depoGuestRemaing, 'depoName' => $depoName]);
    }

    public function getDepoGroupGuest($id)
    {
        $depoGroupsGuest = DepoGuest::where('depo_uid', $id)->get();
        foreach ($depoGroupsGuest as $key => $guest) {
            $depoGroupsGuest[$key]->depoName = DepoGroup::where('uid', $guest->depo_uid)->first('depo_rep_name');
            $depoGroupsGuest[$key]->picture = StaffImages::where('uid', $guest->uid)->first('img_blob');
            $depoGroupsGuest[$key]->cnicfront = CnicFront::where('uid', $guest->uid)->first('img_blob');
            $depoGroupsGuest[$key]->cnicback = CnicBack::where('uid', $guest->uid)->first('img_blob');
        }
        return $depoGroupsGuest;
    }

    public function addDepoGroupGuestRender($id, $guestId = null)
    {
        $guest = $guestId ? DepoGuest::where('uid', $guestId)->first() : null;
        $GuestLimit = $id ? DepoGroup::where('uid', $id)->first('guest_quantity') : null;
        $GuestSaturated = $id ? (DepoGuest::where('uid', $guestId)->count() < $GuestLimit?->staff_quantity ? false : true) : null;
        return view('pages.addDepoGroupStaff', ['uid' => $id, 'guest' => $guest, 'GuestSaturated' => $GuestSaturated]);
    }

    public function addDepoGroupGuest(Request $req, $id, $guestId = null)
    {
        // return $req->hr_type;
        $depoGroupsGuest = new DepoGroup();
        $depoGroupsGuest->uid = (string) Str::uuid();
        $depoGroupsGuest->code =  $this->badge(8, $this->codeIdentifier($req->hr_type));
        $depoGroupsGuest->depo_uid = $id;
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $depoGroupsGuest[$key] = $value;
            }
        }
        try {
            $depoGroupsGuestSaved = $depoGroupsGuest->save();
            if ($depoGroupsGuestSaved) {
                return $req->submitMore ? redirect('depoGroup/' . $id . '/' . 'addDepoGuestRender/' . $depoGroupsGuest->uid)->with('message', 'Depo Group Guest has been updated Successfully') : redirect()->route('pages.depoGroup', $id)->with('message', 'Guest has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    public function updateHrGroupStaff(Request $req, $staffId)
    {
        $arrayToBeUpdate = [];
        $arrayToBeUpdate['code'] =  $this->badge(8, $this->codeIdentifier($req->hr_type));
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' &&  $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $arrayToBeUpdate[$key] = $value;
            }
        }
        try {
            $updatedHRStaff = HrStaff::where('uid', $staffId)->update($arrayToBeUpdate);
            $uid = HrStaff::where('uid', $staffId)->first('hr_uid');
            if ($updatedHRStaff) {
                return $req->submitMore ? redirect()->route('pages.addHrGroupStaffRender', ['id' => $uid->hr_uid, 'staffId' => $staffId])->with('message', 'HR has been updated Successfully') : redirect()->route('pages.hrGroups', $uid->hr_uid)->with('message', 'Staff has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    public function updateHrGroupStaffSecurityStatus(Request $req)
    {
        try {
            $updatedHRStaff = HrStaff::whereIn('uid', $req->uidArray)->update(['hr_security_status' => $req->status]);
            return $updatedHRStaff ? 'Staff Status Updated Successfully' : 'Something Went Wrong';
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }


    // HRGroup Add/Update Form Render & Request
    public function addDepoGroupRender($id = null)
    {
        if ($id) {
            $depoGroups = DepoGroup::where('uid', $id)->firstOrFail();
            return view('pages.addDepoGroup', ['depoGroups' => $depoGroups]);
        } else {
            return view('pages.addDepoGroup');
        }
    }

    public function addDepoGroup(Request $req)
    {
        $depoGroup = new DepoGroup();
        $depoGroup->uid = (string) Str::uuid();
        $depoGroup->depo_rep_uid = (string) Str::uuid();
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $depoGroup[$key] = $value;
            }
        }
        // return $hrGroup;
        try {
            $depoGroupsSaved = $depoGroup->save();
            $userCreated = $this->newUserCreate($depoGroup->depo_rep_name, $depoGroup->depo_rep_email, $depoGroup->uid);
            if ($depoGroupsSaved && $userCreated) {
                return $req->submitMore ? redirect()->route('pages.addDepoGroups')->with('message', 'Depo Group has been updated Successfully') : redirect()->route('pages.depoGroups')->with('message', 'Depo Group has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    public function updateHrGroup(Request $req, $id)
    {
        $arrayToBeUpdate = [];
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key !=  'hr_rep_email' &&  $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $arrayToBeUpdate[$key] = $value;
            }
        }
        try {
            $updatedHR = HrGroup::where('uid', $id)->update($arrayToBeUpdate);
            if ($updatedHR) {
                return $req->submitMore ? redirect()->route('pages.addHrGroup', $id)->with('message', 'HR has been updated Successfully') : redirect()->route('pages.hrGroups')->with('message', 'HRGroup has been updated Successfully');
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
