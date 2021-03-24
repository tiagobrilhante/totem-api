<?php

namespace App\Http\Controllers;

use App\Models\ChamadaNormalParametro;
use App\Models\Guiche;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChamadaNormalParametrosController extends BaseController
{

    // retorna lista de parametros de chamada Normal
    public function index(Request $request)
    {
        // esse é o ip do guiche
        $ipAddressGuiche = $request->ip();

        // daí tem que encontrar qual é o ip vinculado ao painel
        $guiche = Guiche::where('ip', $ipAddressGuiche)->first();

        // o id do painel de referencia é $guiche->panel->id
        $idPanel = 1;

        return ChamadaNormalParametro::where('panel_id',$idPanel)->orderBy('id','DESC')->paginate($request->per_page);

    }

    // grava um novo parâmetro de chamada
    public function store(Request $request)
    {

        // esse é o ip do guiche
        $ipAddressGuiche = $request->ip();

        // daí tem que encontrar qual é o ip vinculado ao painel
        $guiche = Guiche::where('ip', $ipAddressGuiche)->first();

        // o id do painel de referencia é $guiche->panel->id
        $idPanel = 1;

        return response()
            ->json(ChamadaNormalParametro::create([
                'numero_inicial' => $request['numero_inicial'],
                'data_ref' => $request['data_ref'],
                'responsavel' => Auth::user()->posto_grad . ' ' . Auth::user()->nome_guerra,
                'validacao'=>'Não Validado',
                'panel_id' => $idPanel
            ]),  201);

    }
    // retorna o ultimo parâmetro cadastrado
    public function last(Request $request)
    {

        // esse é o ip do guiche
        $ipAddressGuiche = $request->ip();

        // daí tem que encontrar qual é o ip vinculado ao painel
        $guiche = Guiche::where('ip', $ipAddressGuiche)->first();

        // o id do painel de referencia é $guiche->panel->id
        $idPanel = 1;

        return ChamadaNormalParametro::where('panel_id',$idPanel)->orderBy('id','DESC')->first();

    }
}
