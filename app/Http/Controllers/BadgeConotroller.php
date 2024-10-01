<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BadgeConotroller extends Controller
{
    public function render(Request $req, $ids)
    {
        $arr = explode(",", $ids);
        return view('pages.badges',['ids'=>$arr]);
    }
}
