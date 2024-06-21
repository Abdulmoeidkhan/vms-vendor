<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    public function render()
    {
        return view('pages.organization');
    }

    public function getOrganization()
    {
        $organization = Organization::all();
        return $organization;
    }

    public function addOrganizationRender()
    {
        return view('pages.addOrganization');
    }

    public function addOrganization(Request $req)
    {
        $organization = new Organization();
        $organization->uid = (string) Str::uuid();
        $organization->company_rep_uid = (string) Str::uuid();
        foreach ($req->all() as $key => $value) {
            if ($key != 'submit' && $key != 'submitMore' && $key != '_token' && strlen($value) > 0) {
                $organization[$key] = $value;
            }
        }
        try {
            // return $organization;
            $organizationSaved = $organization->save();
            if ($organizationSaved) {
                return $req->submitAndRetain ? redirect()->back()->with('message', 'Organisation has been updated Successfully') : redirect()->route('pages.organization')->with('message', 'Organization has been updated Successfully');
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
