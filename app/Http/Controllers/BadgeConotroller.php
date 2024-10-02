<?php

namespace App\Http\Controllers;

use App\Models\DepoGuest;
use App\Models\HrStaff;
use App\Models\MediaStaff;
use App\Models\OrganizationStaff;
use App\Models\StaffImages;
use Illuminate\Http\Request;

class BadgeConotroller extends Controller
{
    public function render(Request $req, $type, $ids)
    {
        $arr = explode(",", $ids);
        $data = [];
        switch ($type) {
            case 'org':
                $data = OrganizationStaff::whereIn('uid', $arr)->get();
                $data->image=StaffImages::whereIn('uid', $arr)->get('img_blob');
                break;
            case 'hr':
                $data = HrStaff::whereIn('uid', $arr)->get();
                $data->image=StaffImages::whereIn('uid', $arr)->get('img_blob');
                break;
            case 'media':
                $data = MediaStaff::whereIn('uid', $arr)->get();
                $data->image=StaffImages::whereIn('uid', $arr)->get('img_blob');
                break;
            case 'depo':
                $data = DepoGuest::whereIn('uid', $arr)->get();
                $data->image=StaffImages::whereIn('uid', $arr)->get('img_blob');
                break;
            default:
                $code = [];
                break;
        }
        // return $data;
        return view('pages.badges', ['data' => $data]);
    }
}
