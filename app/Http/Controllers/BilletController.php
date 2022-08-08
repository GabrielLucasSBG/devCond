<?php

namespace App\Http\Controllers;

use App\Models\Billet;
use App\Models\Unit;
use Illuminate\Http\Request;

class BilletController extends Controller
{
    public function getAll(Request $request)
    {
        $array = ['error' => ''];

        $user = auth()->user();

        $property = $request->get('property');

        if ($property) {
            $unit = Unit::where(['id' => $property, 'id_owner' => $user['id']])->count();

            if ($unit > 0) {
                $billets = Billet::where('id_unit', $property)->get();

                foreach ($billets as $key => $billet) {
                    $billets[$key]['fileurl'] = asset('storage/' . $billet['fileurl']);
                }

                $array['list'] = $billets;
            } else {
                $array['error'] = 'Esta unidade não é sua';
            }
        } else {
            $array['error'] = 'A propriedade é obrigatória.';
        }

        return $array;
    }
}
