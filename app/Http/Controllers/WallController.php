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

    public function like($id)
    {
        $array = ['error' => ''];

        $user = auth()->user();

        $meLikes = WallLike::where(['id_wall' => $id, 'id_user' => $user['id']])->count();

        if ($meLikes > 0) {
            WallLike::where(['id_wall' => $id, 'id_user' => $user['id']])->delete();

            $array['liked'] = false;
        } else {
            $newLike = new WallLike();
            $newLike->id_wall = $id;
            $newLike->id_user = $user['id'];
            $newLike->save();
            $array['liked'] = true;
        }

        $array['likes'] = WallLike::where('id_wall', $id)->count();

        return $array;
    }
}
