<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StaffImages;
use App\Models\CnicBack;
use App\Models\CnicFront;
use App\Models\HRGroup;
use App\Models\HrStaff;
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
        $hrGroups = HrGroup::orderBy('hr_name', 'asc')->get();
        foreach ($hrGroups as $key => $hrGroup) {
            $hrGroups[$key]->functionaryCount = HrStaff::where('uid', $hrGroup->uid)->where('hr_type', 'Functionary')->count();
            $hrGroups[$key]->functionaryPending = HrStaff::where('uid', $hrGroup->uid)->where('hr_type', 'Functionary')->where('hr_security_status', 'pending')->count();
            $hrGroups[$key]->functionaryApproved = HrStaff::where('uid', $hrGroup->uid)->where('hr_type', 'Functionary')->where('hr_security_status', 'approved')->count();
            $hrGroups[$key]->functionaryRejection = HrStaff::where('uid', $hrGroup->uid)->where('hr_type', 'Functionary')->where('hr_security_status', 'rejected')->count();
            $hrGroups[$key]->temporaryCount = HrStaff::where('uid', $hrGroup->uid)->where('hr_type', 'Temporary')->count();
        }
        return $hrGroups;
    }

    public function getHrGroupsStats()
    {
        $hrGroups = HrGroup::all(['hr_name', 'uid']);
        foreach ($hrGroups as $key => $hrGroup) {
            $hrGroups[$key]->sent = HrStaff::where('uid', $hrGroup->uid)->where('hr_security_status', 'sent')->count();
            $hrGroups[$key]->pending = HrStaff::where('uid', $hrGroup->uid)->where('hr_security_status', 'pending')->count();
            $hrGroups[$key]->rejected = HrStaff::where('uid', $hrGroup->uid)->where('hr_security_status', 'rejected')->count();
            $hrGroups[$key]->approved = HrStaff::where('uid', $hrGroup->uid)->where('hr_security_status', 'approved')->count();
        }
        return $hrGroups;
    }

    public function getSpecificHrGroupStats()
    {
        $hrGroups = HrGroup::where('uid', session('user')->uid)->get(['hr_name', 'uid']);
        foreach ($hrGroups as $key => $hrGroup) {
            $hrGroups[$key]->sent = HrStaff::where('uid', $hrGroup->uid)->where('hr_security_status', 'sent')->count();
            $hrGroups[$key]->pending = HrStaff::where('uid', $hrGroup->uid)->where('hr_security_status', 'pending')->count();
            $hrGroups[$key]->rejected = HrStaff::where('uid', $hrGroup->uid)->where('hr_security_status', 'rejected')->count();
            $hrGroups[$key]->approved = HrStaff::where('uid', $hrGroup->uid)->where('hr_security_status', 'approved')->count();
        }
        return $hrGroups;
    }

    // HRGroup and staff render page 
    public function renderHrGroup($id)
    {
        $hrName = HrGroup::where('uid', $id)->first('hr_name');
        $functionaryStaffLimit = HrGroup::where('uid', $id)->first('staff_quantity');
        $functionaryStaffUpdated = HrStaff::where('uid', $id)->where('hr_type', 'Functionary')->count();
        $functionaryStaffRemaing = $functionaryStaffLimit->staff_quantity - $functionaryStaffUpdated;
        return view('pages.hrGroup', ['id' => $id, 'functionaryStaffLimit' => $functionaryStaffLimit, 'functionaryStaffRemaing' => $functionaryStaffRemaing, 'hrName' => $hrName]);
    }

    public function getHrGroupStaff($id)
    {
        $hrGroupsStaff = HrStaff::where('hr_uid', $id)->get();
        foreach ($hrGroupsStaff as $key => $staff) {
            $hrGroupsStaff[$key]->hrName = HrGroup::where('uid', $staff->uid)->first('hr_name');
            $hrGroupsStaff[$key]->picture = StaffImages::where('uid', $staff->uid)->first('img_blob');
            $hrGroupsStaff[$key]->cnicfront = CnicFront::where('uid', $staff->uid)->first('img_blob');
            $hrGroupsStaff[$key]->cnicback = CnicBack::where('uid', $staff->uid)->first('img_blob');
        }
        return $hrGroupsStaff;
    }

    public function addHrGroupStaffRender($id, $staffId = null)
    {
        $staff = $staffId ? HrStaff::where('uid', $staffId)->first() : null;
        $functionaryStaffLimit = $id ? HrGroup::where('uid', $id)->first('staff_quantity') : null;
        $functionaryStaffSaturated = $id ? (HrStaff::where('uid', $id)->where('hr_type', 'Functionary')->count() < $functionaryStaffLimit?->staff_quantity ? false : true) : null;
        return view('pages.addHrGroupStaff', ['uid' => $id, 'staff' => $staff, 'functionaryStaffSaturated' => $functionaryStaffSaturated]);
    }

    public function addHrGroupStaff(Request $req, $id, $staffId = null)
    {
        $hrGroupsStaff = new HrStaff();
        $hrGroupsStaff->uid = (string) Str::uuid();
        $hrGroupsStaff->code =  $this->badge(8, "HR");;
        $hrGroupsStaff->hr_uid = $id;
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $hrGroupsStaff[$key] = $value;
            }
        }
        try {
            $hrGroupsStaffSaved = $hrGroupsStaff->save();
            if ($hrGroupsStaffSaved) {
                return $req->submitMore ? redirect('hrGroup/' . $id . '/' . 'addHrStaffRender/' . $hrGroupsStaff->uid)->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.hrGroup', $id)->with('message', 'Staff has been updated Successfully');
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
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' &&  $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $arrayToBeUpdate[$key] = $value;
            }
        }
        try {
            $updatedOrganisationStaff = HrStaff::where('uid', $staffId)->update($arrayToBeUpdate);
            $uid = HrStaff::where('uid', $staffId)->first('uid');
            if ($updatedOrganisationStaff) {
                return $req->submitMore ? redirect()->route('pages.addHrGroupStaffRender', ['id' => $uid->uid, 'staffId' => $staffId])->with('message', 'HR has been updated Successfully') : redirect()->route('pages.hrGroups', $uid->uid)->with('message', 'Staff has been updated Successfully');
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
            $updatedOrganisationStaff = HrStaff::whereIn('uid', $req->uidArray)->update(['hr_security_status' => $req->status]);
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
    public function addHrGroupRender($id = null)
    {
        if ($id) {
            $hrGroups = HrGroup::where('uid', $id)->firstOrFail();
            // return $hrGroups;
            return view('pages.addHrGroup', ['hrGroups' => $hrGroups]);
        } else {
            return view('pages.addHrGroup');
        }
    }

    public function addHrGroup(Request $req)
    {
        $hrGroup = new HRGroup();
        $hrGroup->uid = (string) Str::uuid();
        $hrGroup->hr_rep_uid = (string) Str::uuid();
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $hrGroups[$key] = $value;
            }
        }
        try {
            $hrGroupsSaved = $hrGroup->save();
            $userCreated = $this->newUserCreate($hrGroup->hr_rep_name, $hrGroup->hr_rep_email, $hrGroup->uid);
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

    public function updateHrGroup(Request $req, $id)
    {
        $arrayToBeUpdate = [];
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key !=  'hr_rep_email' &&  $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $arrayToBeUpdate[$key] = $value;
            }
        }
        try {
            $updatedOrganisation = HrGroup::where('uid', $id)->update($arrayToBeUpdate);
            if ($updatedOrganisation) {
                return $req->submitMore ? redirect()->route('pages.addHRGroup', $id)->with('message', 'HR has been updated Successfully') : redirect()->route('pages.hrGroups')->with('message', 'HRGroup has been updated Successfully');
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
