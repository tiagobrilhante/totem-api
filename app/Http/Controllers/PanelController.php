<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanelController extends BaseController
{
    public function __construct()
    {
        $this->classe = Panel::class;

    }

    public function indexLoad(Request $request)
    {
        return Panel::paginate($request->per_page)->load('guiche');

    }

    public function showPanel(Request $request)
    {
        $user = Auth::user();
        if ($user->tipo === 'Administrador Geral') {
            return response()
                ->json(Panel::all()->load('guiche','om'), 200);
        } elseif ($user->tipo === 'Administrador') {
            return response()
                ->json(Panel::where('om_id', Auth::user()->om->id)->paginate($request->per_page)->load('guiche','om'), 200);
        } else {
            return response()
                ->json('', 403);
        }


    }
}
