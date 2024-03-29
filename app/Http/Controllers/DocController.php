<?php

namespace App\Http\Controllers;

use App\Models\Doc;
use Illuminate\Http\Request;

class DocController extends Controller
{
    public function getAll()
    {
        $array = ['error' => ''];

        $docs = Doc::all();

        foreach ($docs as $key => $doc) {
            $docs[$key]['fileurl'] = asset('storage/'.$doc['fileurl']);
        }

        $array['list'] = $docs;
        return $array;
    }
}
