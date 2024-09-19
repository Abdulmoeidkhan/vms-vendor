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
        $role = Role::where('name', 'Depo')->first();
        $permission = Permission::where('name', 'read')->first();
        $user->addRole($role);
        $user->givePermissions(['read', 'create', 'update', 'delete']);
    }

    // User Creat user on request
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


    // Main Depo Groups Request
    public function render()
    {
        $StaffCount = DepoGuest::count();
        return view('pages.depoGroups', ['StaffCount' => $StaffCount]);
    }

    //  Main Depo Group Data
    public function getDepoGroups()
    {
        $depoGroups = DepoGroup::orderBy('depo_rep_name', 'asc')->get();
        foreach ($depoGroups as $key => $depoGroup) {
            $depoGroups[$key]->guestCount = DepoGuest::where('depo_uid', $depoGroup->uid)->count();
        }
        return $depoGroups;
    }

    //  Main Depo Group Stats
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

    // DepoGroup Add/Update Form Render
    public function addDepoGroupRender($id = null)
    {
        if ($id) {
            $depoGroups = DepoGroup::where('uid', $id)->firstOrFail();
            return view('pages.addDepoGroup', ['depoGroups' => $depoGroups]);
        } else {
            return view('pages.addDepoGroup');
        }
    }

    // DepoGroup Add Request
    public function addDepoGroup(Request $req)
    {
        $depoGroup = new DepoGroup();
        $depoGroup->uid = (string) Str::uuid();
        $depoGroup->depo_rep_uid = $req->depo_rep_email !== null ? (string) Str::uuid() : null;
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $depoGroup[$key] = $value;
            }
        }
        try {
            $depoGroupsSaved = $depoGroup->save();
            $userCreated = $req->depo_rep_uid !== null ? $this->newUserCreate($depoGroup->depo_rep_name, $depoGroup->depo_rep_email, $depoGroup->uid) : true;
            if ($depoGroupsSaved && $userCreated) {
                return $req->submitMore ? redirect()->route('pages.addDepoGroup')->with('message', 'Depo Group has been updated Successfully') : redirect()->route('pages.depoGroups')->with('message', 'Depo Group has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    // DepoGroup Update Request
    public function updateDepoGroup(Request $req, $id)
    {
        $arrayToBeUpdate = [];
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' &&  $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $arrayToBeUpdate[$key] = $value;
            }
        }
        try {
            $emailExist = DepoGroup::where('uid', $id)->first();
            // return $req;
            if ($emailExist->depo_rep_email == null) {
                $arrayToBeUpdate['depo_rep_uid'] = $emailExist->uid;
                $this->newUserCreate($req->depo_rep_name, $req->depo_rep_email, $emailExist->uid);
            }
            $updatedDepo = DepoGroup::where('uid', $id)->update($arrayToBeUpdate);
            if ($updatedDepo) {
                return $req->submitMore ? redirect()->route('pages.addDepoGroup', $id)->with('message', 'Depo Group has been updated Successfully') : redirect()->route('pages.addDepoGroup')->with('message', 'Depo Group has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }


    //  Specefic Depo Group Stats
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


    // Depo Guest Page render
    public function depoGuestRender($id)
    {
        $GuestCount = DepoGuest::where('depo_uid', $id)->get();
        $depo = DepoGroup::where('uid', $id)->first();
        $depoGuestLimit = DepoGroup::where('uid', $id)->first('staff_quantity');
        $depoGuestUpdated = DepoGuest::where('depo_uid', $id)->count();
        $depoGuestRemaing = $depoGuestLimit->staff_quantity - $depoGuestUpdated;
        return view('pages.depoGroup', ['GuestCount' => $GuestCount, 'id' => $id, 'depo' => $depo, 'depoGuestRemaing' => $depoGuestRemaing]);
    }

    //  Main Depo Guest Data
    public function getDepoGuest($id)
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


    //Add DepoGroup Page render
    public function addDepoGuestRender($id, $guestId = null)
    {
        $guest = $guestId ? DepoGuest::where('uid', $guestId)->first() : null;
        $GuestLimit = $id ? DepoGroup::where('uid', $id)->first('staff_quantity') : null;
        $GuestSaturated = $id ? (DepoGuest::where('uid', $guestId)->count() < $GuestLimit?->staff_quantity ? false : true) : null;
        return view('pages.addDepoGroupGuest', ['uid' => $id, 'guest' => $guest, 'GuestSaturated' => $GuestSaturated]);
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
        $depoGroupsGuest = new DepoGuest();
        $depoGroupsGuest->uid = (string) Str::uuid();
        $depoGroupsGuest->badge_type =  $this->badge(8, $this->codeIdentifier($req->badge_type));
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

    public function updateDepoGuest(Request $req, $staffId)
    {
        $arrayToBeUpdate = [];
        $arrayToBeUpdate['badge_type'] =  $this->badge(8, $this->codeIdentifier($req->badge_type));
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' &&  $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $arrayToBeUpdate[$key] = $value;
            }
        }
        try {
            $updatedDepoGroup = DepoGuest::where('uid', $staffId)->update($arrayToBeUpdate);
            $uid = DepoGuest::where('uid', $staffId)->first('depo_uid');
            if ($updatedDepoGroup) {
                return redirect('depoGroup/' . $uid->depo_uid . '/' . 'addDepoGuestRender/' . $staffId)->with('message', 'Depo has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    // public function updateHrGroupStaffSecurityStatus(Request $req)
    // {
    //     try {
    //         $updatedHRStaff = HrStaff::whereIn('uid', $req->uidArray)->update(['hr_security_status' => $req->status]);
    //         return $updatedHRStaff ? 'Staff Status Updated Successfully' : 'Something Went Wrong';
    //     } catch (\Illuminate\Database\QueryException $exception) {
    //         if ($exception->errorInfo[2]) {
    //             return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
    //         } else {
    //             return  redirect()->back()->with('error', $exception->errorInfo[2]);
    //         }
    //     }
    // }
}
