<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SummaryPanelController extends Controller
{
    public function render()
    {
        $categories = ['Vendor' => new OrganizationController,'HR'=> new HRController,'Media'=> new MediaController];
        $categoriesToBePush = [];
        foreach ($categories as $key => $value) {
            $values = $value->getStats();
            $array = ['name' => $key, 'value' => $values];
            array_push($categoriesToBePush, $array);
        }
        // return $categoriesToBePush;
        return view('pages.summaryPanel', ['majorcategories' => $categoriesToBePush]);
    }
}
