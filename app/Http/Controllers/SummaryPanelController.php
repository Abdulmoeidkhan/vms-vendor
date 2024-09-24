<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SummaryPanelController extends Controller
{
    public function render()
    {
        $categories = ['organisation' => new OrganizationController];
        $categoriesToBePush = [];
        foreach ($categories as $key => $value) {
            $values = $value->getOrganizationStats();
            $array = ['name' => $key, 'value' => $values];
            array_push($categoriesToBePush, $array);
        }
        return view('pages.summaryPanel', ['categories' => $categoriesToBePush[0]['value']]);
    }
}
