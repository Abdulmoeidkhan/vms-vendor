<?php

namespace App\Http\Controllers;

use App\Models\DepoGuest;
use App\Models\HrStaff;
use App\Models\MediaStaff;
use App\Models\OrganizationStaff;
// use App\Models\StaffImages;
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
                break;
            case 'hr':
                $data = HrStaff::whereIn('uid', $arr)->get();
                break;
            case 'media':
                $data = MediaStaff::whereIn('uid', $arr)->get();
                break;
            case 'depo':
                $data = DepoGuest::whereIn('uid', $arr)->get();
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
