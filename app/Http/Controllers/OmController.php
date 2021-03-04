<?php

namespace App\Http\Controllers;

use App\Models\Om;
use Illuminate\Support\Facades\Auth;

class OmController extends BaseController
{
    public function __construct()
    {
        $this->classe = Om::class;

    }

    public function omsDisponives()
    {
        $user = Auth::user();
        if ($user->tipo === 'Administrador Geral') {
            return response()
                ->json(Om::all(), 200);
        } elseif ($user->tipo === 'Administrador') {
            return response()
                ->json([Om::find($user->om_id)], 200);
        } else {
            return response()
                ->json('', 403);
        }
    }

    public function withusers()
    {
        return Om::all()->load('users');
    }

}
