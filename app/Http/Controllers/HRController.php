<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\StaffImages;
// use App\Models\CnicBack;
// use App\Models\CnicFront;
use App\Models\HrGroup;
use App\Models\HrStaff;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HRController extends Controller
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
        $StaffCount = HrStaff::count();
        return view('pages.hrGroups', ['StaffCount' => $StaffCount]);
    }

    public function getHrGroups()
    {
        $hrGroups = HrGroup::orderBy('hr_name', 'asc')->get();
        foreach ($hrGroups as $key => $hrGroup) {
            $hrGroups[$key]->functionaryCount = HrStaff::where('hr_uid', $hrGroup->uid)->where('hr_type', 'Functionary')->count();
            $hrGroups[$key]->functionarySent = HrStaff::where('hr_uid', $hrGroup->uid)->where('hr_security_status', 'sent')->count();
            $hrGroups[$key]->functionaryPending = HrStaff::where('hr_uid', $hrGroup->uid)->where('hr_security_status', 'pending')->count();
            $hrGroups[$key]->functionaryApproved = HrStaff::where('hr_uid', $hrGroup->uid)->where('hr_security_status', 'approved')->count();
            $hrGroups[$key]->functionaryRejection = HrStaff::where('hr_uid', $hrGroup->uid)->where('hr_security_status', 'rejected')->count();
            $hrGroups[$key]->temporaryCount = HrStaff::where('hr_uid', $hrGroup->uid)->where('hr_type', 'Temporary')->count();
        }
        return $hrGroups;
    }

    public function getStats()
    {
        $hrGroups = HrGroup::select('hr_name as entity_name','uid as uid')->get();
        foreach ($hrGroups as $key => $hrGroup) {
            $hrGroups[$key]->total = HrStaff::where('hr_uid', $hrGroup->uid)->count();
            $hrGroups[$key]->sent = HrStaff::where('hr_uid', $hrGroup->uid)->where('hr_security_status', 'sent')->count();
            $hrGroups[$key]->pending = HrStaff::where('hr_uid', $hrGroup->uid)->where('hr_security_status', 'pending')->count();
            $hrGroups[$key]->rejected = HrStaff::where('hr_uid', $hrGroup->uid)->where('hr_security_status', 'rejected')->count();
            $hrGroups[$key]->approved = HrStaff::where('hr_uid', $hrGroup->uid)->where('hr_security_status', 'approved')->count();
        }

        if ($hrGroups->count() > 0) {
            $hrGroups[$hrGroups->count()] = [
                'entity_name' => 'Total',
                'uid' => '',
                'sent' => $hrGroups->sum('sent'),
                'total' => $hrGroups->sum('total'),
                'pending' => $hrGroups->sum('pending'),
                'rejected' => $hrGroups->sum('rejected'),
                'approved' => $hrGroups->sum('approved'),
            ];
        }
        return $hrGroups;
    }

    public function getSpecificHrGroupStats()
    {
        $hrGroups = HrGroup::where('uid', session('user')->uid)->get(['hr_name', 'uid']);
        foreach ($hrGroups as $key => $hrGroup) {
            $hrGroups[$key]->sent = HrStaff::where('hr_uid', $hrGroup->uid)->where('hr_security_status', 'sent')->count();
            $hrGroups[$key]->pending = HrStaff::where('hr_uid', $hrGroup->uid)->where('hr_security_status', 'pending')->count();
            $hrGroups[$key]->rejected = HrStaff::where('hr_uid', $hrGroup->uid)->where('hr_security_status', 'rejected')->count();
            $hrGroups[$key]->approved = HrStaff::where('hr_uid', $hrGroup->uid)->where('hr_security_status', 'approved')->count();
        }
        return $hrGroups;
    }

    // HRGroup and staff render page 
    public function renderHrGroup($id)
    {
        $hrName = HrGroup::where('uid', $id)->first('hr_name');
        $functionaryStaffLimit = HrGroup::where('uid', $id)->first('staff_quantity');
        $functionaryStaffUpdated = HrStaff::where('hr_uid', $id)->where('hr_type', 'Functionary')->count();
        $functionaryStaffRemaing = $functionaryStaffLimit->staff_quantity - $functionaryStaffUpdated;
        return view('pages.hrGroup', ['id' => $id, 'functionaryStaffLimit' => $functionaryStaffLimit, 'functionaryStaffRemaing' => $functionaryStaffRemaing, 'hrName' => $hrName]);
    }

    public function getHrGroupStaff($id)
    {
        $hrGroupsStaff = HrStaff::where('hr_uid', $id)->get();
        foreach ($hrGroupsStaff as $key => $staff) {
            $hrGroupsStaff[$key]->hrName = HrGroup::where('uid', $staff->hr_uid)->first('hr_name');
            $hrGroupsStaff[$key]->pictureUrl = 'https://res.cloudinary.com/dj6mfrbth/image/upload/v1727959664/Images/' . $staff->uid . '.png';
            // $hrGroupsStaff[$key]->picture = StaffImages::where('uid', $staff->uid)->first('img_blob');
            // $hrGroupsStaff[$key]->cnicfront = CnicFront::where('uid', $staff->uid)->first('img_blob');
            // $hrGroupsStaff[$key]->cnicback = CnicBack::where('uid', $staff->uid)->first('img_blob');
        }
        return $hrGroupsStaff;
    }

    public function addHrGroupStaffRender($id, $staffId = null)
    {
        $staff = $staffId ? HrStaff::where('uid', $staffId)->first() : null;
        $functionaryStaffLimit = $id ? HrGroup::where('uid', $id)->first('staff_quantity') : null;
        $functionaryStaffSaturated = $id ? (HrStaff::where('uid', $staffId)->where('hr_type', 'Functionary')->count() < $functionaryStaffLimit?->staff_quantity ? false : true) : null;
        return view('pages.addHrGroupStaff', ['uid' => $id, 'staff' => $staff, 'functionaryStaffSaturated' => $functionaryStaffSaturated]);
    }

    public function addHrGroupStaff(Request $req, $id, $staffId = null)
    {
        // return $req->hr_type;
        $hrGroupsStaff = new HrStaff();
        $hrGroupsStaff->uid = (string) Str::uuid();
        $hrGroupsStaff->code =  $this->badge(8, $this->codeIdentifier($req->hr_type));
        $hrGroupsStaff->hr_uid = $id;
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $hrGroupsStaff[$key] = $value;
            }
        }
        try {
            $hrGroupsStaffSaved = $hrGroupsStaff->save();
            if ($hrGroupsStaffSaved) {
                return $req->submitMore ? redirect('hrGroup/' . $id . '/' . 'addHrStaffRender/' . $hrGroupsStaff->uid)->with('message', 'HR Group Staff has been updated Successfully') : redirect()->route('pages.hrGroup', $id)->with('message', 'Staff has been updated Successfully');
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[2]) {
                return  redirect()->back()->withInput()->with('error', 'Error : ' . $exception->errorInfo[2]);
            } else {
                return  redirect()->back()->withInput()->with('error', $exception->errorInfo[2]);
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
        $hrGroup = new HrGroup();
        $hrGroup->uid = (string) Str::uuid();
        $hrGroup->hr_rep_uid = (string) Str::uuid();
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $hrGroup[$key] = $value;
            }
        }
        // return $hrGroup;
        try {
            $hrGroupsSaved = $hrGroup->save();
            $userCreated = $this->newUserCreate($hrGroup->hr_rep_name, $hrGroup->hr_rep_email, $hrGroup->uid);
            if ($hrGroupsSaved && $userCreated) {
                return $req->submitMore ? redirect()->route('pages.addHrGroups')->with('message', 'HR Group has been updated Successfully') : redirect()->route('pages.hrGroups')->with('message', 'HRGroup has been updated Successfully');
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
