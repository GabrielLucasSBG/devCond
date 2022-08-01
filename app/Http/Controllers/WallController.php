<?php

namespace App\Http\Controllers;

use App\Models\Wall;
use App\Models\WallLike;
use Illuminate\Http\Request;

class WallController extends Controller
{
    public function getAll()
    {
        $array = ['error' => '', 'list' => []];

        $user = auth()->user();

        $walls = Wall::all();

        foreach ($walls as $key => $wall) {
            $walls[$key]['likes'] = 0;
            $walls[$key]['liked'] = false;

            $likes = WallLike::where('id_wall', $wall['id'])->count();
            $walls[$key]['likes'] = $likes;

            $meLikes = WallLike::where(['id_wall' => $wall['id'], 'id_user' => $user['id']])->count();

            $walls[$key]['liked'] = $meLikes > 0;
        }

        $array['list'] = $walls;

        return $array;
    }
}
