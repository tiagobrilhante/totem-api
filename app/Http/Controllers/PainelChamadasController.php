<?php

namespace App\Http\Controllers;

use App\Models\Chamada;
use App\Models\ChamadaNormalParametro;
use App\Models\ChamadaPrioridadeParametro;
use App\Models\ChamadaTipoAtendimento;
use App\Models\Guiche;
use App\Models\Panel;
use App\Models\PublicoAlvo;
use App\Models\TipoAtendimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PainelChamadasController extends Controller
{

    // retorna as previsões de chamadas normal e prioridade
    public function chamadasPainel(Request $request)
    {
        /*
        primeiro tem que entender que se existir algo em parametro e não existir chamadas no dia de hoje,
        vale o num_ref do parametro
        caso exista mais de um parametro pro dia de hj, vale o num_ref do ultimo parametro
        caso exista parametro e chamada, vale o num_ref da ultima chamada +1
        */

        $diaHoje = date('Y-m-d ');

        // tem que ver qual é o painel de referencia
        //$panel = Panel::where('ip', $request->ip())->first();
        $panel = Panel::find(1);


        $chamadasPainel='';

        // preciso verificar se existem chamados no dia de hj
        $verifica_chamados = Chamada::where('created_at', 'LIKE', "$diaHoje%")->count();

        if ($verifica_chamados === 0) {

            // nesse caso, não existem chamadas ainda no dia de hoje

            $chamadasPainel = 'sem chamadas';

            return $chamadasPainel;
        } else {

            // nesse caso existem chamados...

            $chamadasPainel = Chamada::where('created_at', 'LIKE', "$diaHoje%")->orderBy('id', 'DESC')->limit(4)->get();

        }


        return  $chamadasPainel;

    }

    //retorna o painel ativo
    public function painelAtivo(Request $request)
    {
        $ipAddress = $request->ip();
        //return Guiche::where('ip', $ipAddress)->first();
        return Panel::find(1)->load('om');

    }

}
