<?php

namespace App\Http\Controllers;

use App\Models\DepoGroup;
use App\Models\Organization;
use App\Models\DepoGuest;
use App\Models\HrGroup;
use App\Models\HrStaff;
use App\Models\MediaGroup;
use App\Models\MediaStaff;
use App\Models\OrganizationStaff;
// use App\Models\StaffImages;
use Illuminate\Http\Request;
use Termwind\Components\Hr;

class BadgeConotroller extends Controller
{
    public function render(Request $req, $type, $ids)
    {
        $arr = explode(",", $ids);
        $data = [];
        switch ($type) {
            case 'org':
                $data = OrganizationStaff::whereIn('id', $arr)->get();
                foreach ($data as $key => $dataList) {
                    $data[$key]->companyName = Organization::where('uid', $dataList->company_uid)->first('company_name');
                }
                break;
            case 'hr':
                $data = HrStaff::whereIn('id', $arr)->get(['hr_first_name', 'hr_last_name', 'hr_designation', 'code', 'hr_identity', 'uid', 'hr_uid', 'hr_country']);
                foreach ($data as $key => $dataList) {
                    $data[$key]->companyName = HrGroup::where('uid', $dataList->hr_uid)->first('hr_name');
                    $data[$key]->companyName->company_name = $data[$key]->companyName->hr_name;
                    $data[$key]->staff_first_name = $data[$key]->hr_first_name;
                    $data[$key]->staff_last_name = $data[$key]->hr_last_name;
                    $data[$key]->staff_designation = $data[$key]->i;
                    $data[$key]->staff_identity = $data[$key]->hr_identity;
                    $data[$key]->staff_country = $data[$key]->hr_country;
                }
                break;
            case 'media':
                $data = MediaStaff::whereIn('id', $arr)->get(['media_staff_first_name', 'media_staff_last_name', 'media_staff_designation', 'code', 'media_staff_identity', 'uid', 'media_uid', 'media_staff_country']);
                foreach ($data as $key => $dataList) {
                    $data[$key]->companyName = MediaGroup::where('uid', $dataList->media_uid)->first('media_name');
                    $data[$key]->companyName->company_name = $data[$key]->companyName->media_name;
                    $data[$key]->staff_first_name = $data[$key]->media_staff_first_name;
                    $data[$key]->staff_last_name = $data[$key]->media_staff_last_name;
                    $data[$key]->staff_designation = $data[$key]->media_staff_designation;
                    $data[$key]->staff_identity = $data[$key]->media_staff_identity;
                    $data[$key]->staff_country = $data[$key]->media_staff_country;
                }
                break;
            case 'depo':
                $data = DepoGuest::whereIn('uid', $arr)->get(['depo_guest_name','depo_guest_designation','depo_identity','uid','depo_uid','depo_guest_service']);
                foreach ($data as $key => $dataList) {
                    $data[$key]->companyName = DepoGroup::where('uid', $dataList->depo_uid)->first('depo_rep_name');
                    $data[$key]->companyName->company_name = $data[$key]->companyName->depo_rep_name;
                    $data[$key]->staff_first_name = $data[$key]->depo_guest_name;
                    $data[$key]->staff_last_name = '';
                    $data[$key]->code = 'DP'.$data[$key]->depo_guest_service;
                    $data[$key]->staff_designation = $data[$key]->depo_guest_designation;
                    $data[$key]->staff_identity = $data[$key]->depo_identity;
                    $data[$key]->staff_country = 'Pakistan';
                }
                break;
            default:
                $code = [];
                break;
        }
        // $data->image = StaffImages::whereIn('uid', $arr)->get('img_blob');
        // return $data;
        return view('pages.badges', ['data' => $data]);
    }
}
