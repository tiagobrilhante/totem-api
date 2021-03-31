<?php

namespace App\Http\Controllers;

use App\Models\PublicoAlvo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicoAlvoController extends BaseController
{
    public function __construct()
    {
        $this->classe = PublicoAlvo::class;

    }

    // retorna lista de tipos por OM
    public function tiposOm(Request $request)
    {

        if (Auth::user()->tipo === 'Administrador Geral') {
            return PublicoAlvo::orderBy('id','DESC')->paginate($request->per_page);
        } else {
            return PublicoAlvo::where('om_id',Auth::user()->om_id)->orderBy('id','DESC')->paginate($request->per_page);
        }


    }
}
