<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ImageBlob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileImageController extends Controller
{
    protected function hisOwnProfile($uid)
    {
        if ($uid == auth()->user()->uid) {
            $user = User::with('roles', 'permissions')->where('id', Auth::user()->id)->first();
            $user->images = ImageBlob::where('uid', Auth::user()->uid)->first();
            session(['user' => $user]);
            return true;
        } else {
            return false;
        }
    }

    function imageBlobUpload(Request $req)
    {
        if ($req->savedpicture) {
            $imgBlob = new ImageBlob();
            $imageBlob = $req->savedpicture;
            $imgBlob->uid = $req->id;
            $imageAlreadyExist = ImageBlob::where('uid', $imgBlob->uid)->first();
            $imgBlob->img_blob = $imageBlob;
            $imgSaved = $imageAlreadyExist ? $this->imageBlobUpdate($imgBlob->img_blob, $imgBlob->uid) : $imgBlob->save();
            return $imgSaved ? redirect()->back()->with('message', 'Image Updated Successfully') : redirect()->back()->with('error', 'SomeThing Went Wrong');
        } else {
            return redirect()->back()->with('error', 'Please save and try to upload again');
        }
    }

    function imageBlobUpdate($file, $id)
    {
        $imageBlob = $file;
        $updateImageBlob = ImageBlob::where('uid', $id)->first() ? ImageBlob::where('uid', $id)->update(['img_blob' => $imageBlob]) : $this->imageBlobUpload($file, $id);
        return $updateImageBlob ? redirect()->back()->with('message', 'Image Updated Successfully') : redirect()->back()->with('error', 'SomeThing Went Wrong');;
    }
}
