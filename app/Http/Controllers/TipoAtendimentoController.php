<?php

namespace App\Http\Controllers;

use App\Models\TipoAtendimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoAtendimentoController extends BaseController
{
    public function __construct()
    {
        $this->classe = TipoAtendimento::class;

    }

    // retorna lista de tipos por OM
    public function tiposOm(Request $request)
    {
        if (Auth::user()->tipo === 'Administrador Geral') {
            return TipoAtendimento::orderBy('id','DESC')->paginate($request->per_page);
        } else {
            return TipoAtendimento::where('om_id',Auth::user()->om_id)->orderBy('id','DESC')->paginate($request->per_page);
        }



    }
}
