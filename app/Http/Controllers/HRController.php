<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StaffImages;
use App\Models\CnicBack;
use App\Models\CnicFront;
use App\Models\HRGroup;
use App\Models\HRStaff;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HRController extends Controller
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
        $role = Role::where('name', 'HrRep')->first();
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
        return view('pages.hrGroups');
    }

    public function getHrGroups()
    {
        $hrGroups = HRGroup::orderBy('hr_name', 'asc')->get();
        foreach ($hrGroups as $key => $hrGroups) {
            $hrGroups[$key]->functionaryCount = HRStaff::where('hr_uid', $hrGroups->uid)->where('staff_type', 'Functionary')->count();
            $hrGroups[$key]->functionaryPending = HRStaff::where('hr_uid', $hrGroups->uid)->where('staff_type', 'Functionary')->where('staff_security_status', 'pending')->count();
            $hrGroups[$key]->functionaryApproved = HRStaff::where('hr_uid', $hrGroups->uid)->where('staff_type', 'Functionary')->where('staff_security_status', 'approved')->count();
            $hrGroups[$key]->functionaryRejection = HRStaff::where('hr_uid', $hrGroups->uid)->where('staff_type', 'Functionary')->where('staff_security_status', 'rejected')->count();
            $hrGroups[$key]->temporaryCount = HRStaff::where('hr_uid', $hrGroups->uid)->where('staff_type', 'Temporary')->count();
        }
        return $hrGroups;
    }

    public function getHRGroupStats()
    {
        $hrGroups = HRGroup::all(['hr_name', 'uid']);
        foreach ($hrGroups as $key => $hrGroups) {
            $hrGroups[$key]->sent = HRStaff::where('hr_uid', $hrGroups->uid)->where('staff_security_status', 'sent')->count();
            $hrGroups[$key]->pending = HRStaff::where('hr_uid', $hrGroups->uid)->where('staff_security_status', 'pending')->count();
            $hrGroups[$key]->rejected = HRStaff::where('hr_uid', $hrGroups->uid)->where('staff_security_status', 'rejected')->count();
            $hrGroups[$key]->approved = HRStaff::where('hr_uid', $hrGroups->uid)->where('staff_security_status', 'approved')->count();
        }
        return $hrGroups;
    }

    public function getSpecificHRGroupStats()
    {
        $hrGroups = HRGroup::where('uid', session('user')->uid)->get(['hr_name', 'uid']);
        foreach ($hrGroups as $key => $hrGroups) {
            $hrGroups[$key]->sent = HRStaff::where('hr_uid', $hrGroups->uid)->where('staff_security_status', 'sent')->count();
            $hrGroups[$key]->pending = HRStaff::where('hr_uid', $hrGroups->uid)->where('staff_security_status', 'pending')->count();
            $hrGroups[$key]->rejected = HRStaff::where('hr_uid', $hrGroups->uid)->where('staff_security_status', 'rejected')->count();
            $hrGroups[$key]->approved = HRStaff::where('hr_uid', $hrGroups->uid)->where('staff_security_status', 'approved')->count();
        }
        return $hrGroups;
    }

    // HRGroup and staff render page 
    public function renderOrganisation($id)
    {
        $hrName = HRGroup::where('uid', $id)->first('hr_name');
        $functionaryStaffLimit = HRGroup::where('uid', $id)->first('staff_quantity');
        $functionaryStaffUpdated = HRStaff::where('hr_uid', $id)->where('staff_type', 'Functionary')->count();
        $functionaryStaffRemaing = $functionaryStaffLimit->staff_quantity - $functionaryStaffUpdated;
        return view('pages.hrGroups', ['id' => $id, 'functionaryStaffLimit' => $functionaryStaffLimit, 'functionaryStaffRemaing' => $functionaryStaffRemaing, 'hrName' => $hrName]);
    }

    public function getHRGroupStaff($id)
    {
        $hrGroupsStaff = HRStaff::where('hr_uid', $id)->get();
        foreach ($hrGroupsStaff as $key => $staff) {
            $hrGroupsStaff[$key]->hrName = HRGroup::where('uid', $staff->hr_uid)->first('hr_name');
            $hrGroupsStaff[$key]->picture = StaffImages::where('uid', $staff->uid)->first('img_blob');
            $hrGroupsStaff[$key]->cnicfront = CnicFront::where('uid', $staff->uid)->first('img_blob');
            $hrGroupsStaff[$key]->cnicback = CnicBack::where('uid', $staff->uid)->first('img_blob');
        }
        return $hrGroupsStaff;
    }

    public function addHRGroupStaffRender($id, $staffId = null)
    {
        $staff = $staffId ? HRStaff::where('uid', $staffId)->first() : null;
        $functionaryStaffLimit = $id ? HRGroup::where('uid', $id)->first('staff_quantity') : null;
        $functionaryStaffSaturated = $id ? (HRStaff::where('hr_uid', $id)->where('staff_type', 'Functionary')->count() < $functionaryStaffLimit->staff_quantity ? false : true) : null;
        return view('pages.addHRGroupStaff', ['hr_uid' => $id, 'staff' => $staff, 'functionaryStaffSaturated' => $functionaryStaffSaturated]);
    }

    public function addHRGroupStaff(Request $req, $id, $staffId = null)
    {
        $hrGroupsStaff = new HRStaff();
        $hrGroupsStaff->uid = (string) Str::uuid();
        $hrGroupsStaff->code =  $this->badge(8, "OR");;
        $hrGroupsStaff->hr_uid = $id;
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $hrGroupsStaff[$key] = $value;
            }
        }
        try {
            $hrGroupsStaffSaved = $hrGroupsStaff->save();
            if ($hrGroupsStaffSaved) {
                return $req->submitMore ? redirect('hrGroups/' . $id . '/' . 'addHRGroupStaff/' . $hrGroupsStaff->uid)->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.hrGroups', $id)->with('message', 'Staff has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    public function updateHRGroupStaff(Request $req, $staffId)
    {
        $arrayToBeUpdate = [];
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' &&  $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $arrayToBeUpdate[$key] = $value;
            }
        }
        try {
            $updatedOrganisationStaff = HRStaff::where('uid', $staffId)->update($arrayToBeUpdate);
            $hr_uid = HRStaff::where('uid', $staffId)->first('hr_uid');
            if ($updatedOrganisationStaff) {
                return $req->submitMore ? redirect()->route('pages.addHRGroupStaff', ['id' => $hr_uid->hr_uid, 'staffId' => $staffId])->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.hrGroups', $hr_uid->hr_uid)->with('message', 'Staff has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    public function updateOrganisationStaffSecurityStatus(Request $req)
    {
        try {
            $updatedOrganisationStaff = HRStaff::whereIn('uid', $req->uidArray)->update(['staff_security_status' => $req->status]);
            return $updatedOrganisationStaff ? 'Staff Status Updated Successfully' : 'Something Went Wrong';
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }


    // HRGroup Add/Update Form Render & Request
    public function addHRGroupRender($id = null)
    {
        if ($id) {
            $hrGroups = HRGroup::where('uid', $id)->firstOrFail();
            return view('pages.addHRGroup', ['hrGroups' => $hrGroups]);
        } else {
            return view('pages.addHRGroup');
        }
    }

    public function addHRGroup(Request $req)
    {
        $hrGroups = new HRGroup();
        $hrGroups->uid = (string) Str::uuid();
        $hrGroups->hr_rep_uid = (string) Str::uuid();
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $hrGroups[$key] = $value;
            }
        }
        try {
            $hrGroupsSaved = $hrGroups->save();
            $userCreated = $this->newUserCreate($hrGroups->hr_rep_name, $hrGroups->hr_rep_email, $hrGroups->uid);
            if ($hrGroupsSaved && $userCreated) {
                return $req->submitMore ? redirect()->route('pages.addHRGroup')->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.hrGroups')->with('message', 'HRGroup has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->with('error', $exception->errorInfo[2]);
            }
        }
    }

    public function updateHRGroup(Request $req, $id)
    {
        $arrayToBeUpdate = [];
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key !=  'hr_rep_email' &&  $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $arrayToBeUpdate[$key] = $value;
            }
        }
        try {
            $updatedOrganisation = HRGroup::where('uid', $id)->update($arrayToBeUpdate);
            if ($updatedOrganisation) {
                return $req->submitMore ? redirect()->route('pages.addHRGroup', $id)->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.hrGroups')->with('message', 'HRGroup has been updated Successfully');
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
