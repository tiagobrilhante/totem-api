<?php

namespace App\Http\Controllers;

use App\Models\ChamadaPrioridadeParametro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChamadaPrioridadeParametrosController extends BaseController
{
    // retorna lista de parametros de chamada Prioritária
    public function index(Request $request)
    {
        return ChamadaPrioridadeParametro::where('om_id',Auth::user()->om_id)->orderBy('id','DESC')->paginate($request->per_page);

    }

    // grava um novo parâmetro de chamada
    public function store(Request $request)
    {

        return response()
            ->json(ChamadaPrioridadeParametro::create([
                'numero_inicial' => $request['numero_inicial'],
                'data_ref' => $request['data_ref'],
                'responsavel' => Auth::user()->posto_grad . ' ' . Auth::user()->nome_guerra,
                'om_id' => Auth::user()->om_id
            ]),  201);

    }

    // retorna o ultimo parâmetro cadastrado
    public function last()
    {
        return ChamadaPrioridadeParametro::where('om_id',Auth::user()->om_id)->orderBy('id','DESC')->first();

    }
}
