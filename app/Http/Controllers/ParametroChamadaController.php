<?php

namespace App\Http\Controllers;

use App\Models\ChamadaNormalParametro;
use App\Models\ChamadaPrioridadeParametro;
use App\Models\Guiche;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class ParametroChamadaController extends Controller
{

    public function verificaParametros(Request $request)
    {

        // esse é o ip do guiche
        $ipAddressGuiche = $request->ip();

        // daí tem que encontrar qual é o ip vinculado ao painel
        $guiche = Guiche::where('ip', $ipAddressGuiche)->first();

        // o id do painel de referencia é $guiche->panel->id
        $idPanel = $guiche->panel_id;

        $dataHoje = date('Y-m-d');

        $retorno = '';

        // checa os parametros normais e pref

        $parametro_normal = ChamadaNormalParametro::where('data_ref', $dataHoje)->where('panel_id', $idPanel)->count();
        $parametro_prioridade = ChamadaPrioridadeParametro::where('data_ref', $dataHoje)->where('panel_id', $idPanel)->count();

        if ($parametro_normal > 0 && $parametro_prioridade > 0) {
            $retorno = 'true';
        } else {
            $retorno = 'false';
        }

        return $retorno;
    }

}
