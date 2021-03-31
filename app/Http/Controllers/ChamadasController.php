<?php

namespace App\Http\Controllers;

use App\Models\Chamada;
use App\Models\ChamadaNormalParametro;
use App\Models\ChamadaPrioridadeParametro;
use App\Models\ChamadaTipoAtendimento;
use App\Models\Guiche;
use App\Models\PublicoAlvo;
use App\Models\TipoAtendimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChamadasController extends Controller
{

    public function myCallsNormal(Request $request)
    {
        // a referencia de chamadas é o guiche
        //$guiche = Guiche::where('ip', $request->ip())->first();
        $guiche = Guiche::find(1);

        return Chamada::where('tipo', 'Normal')->where('guiche_id', $guiche->id)->get()->load('chamadaTipoAtendimento.tipoAtendimento');
    }

    public function myCallsPreferencial()
    {
        // a referencia de chamadas é o guiche
        //$guiche = Guiche::where('ip', $request->ip())->first();
        $guiche = Guiche::find(1);

        return Chamada::where('tipo', 'Preferencial')->where('guiche_id', $guiche->id)->get()->load('chamadaTipoAtendimento.tipoAtendimento');

    }

    public function myCallsNominal()
    {
        // a referencia de chamadas é o guiche
        //$guiche = Guiche::where('ip', $request->ip())->first();
        $guiche = Guiche::find(1);

        return Chamada::where('tipo', 'Nominal')->where('guiche_id', $guiche->id)->get()->load('chamadaTipoAtendimento.tipoAtendimento');

    }

    // retorna as previsões de chamadas normal e prioridade
    public function previsaoChamada(Request $request)
    {
        /*
        primeiro tem que entender que se existir algo em parametro e não existir chamadas no dia de hoje,
        vale o num_ref do parametro
        caso exista mais de um parametro pro dia de hj, vale o num_ref do ultimo parametro
        caso exista parametro e chamada, vale o num_ref da ultima chamada +1
        */

        $prev_norm = '';
        $prev_pref = '';
        $diaHoje = date('Y-m-d ');

        // tem que ver qual é o painel de referencia
        //$guiche = Guiche::where('ip', $request->ip())->first();
        $guiche = Guiche::find(1);
        $panel = $guiche->panel;


        // preciso verificar se existem chamados no dia de hj
        $verifica_chamados_normais = Chamada::where('tipo', 'Normal')->where('created_at', 'LIKE', "$diaHoje%")->count();

        if ($verifica_chamados_normais === 0) {

            // nesse caso, não existem chamadas ainda no dia de hoje

            // significa que o numero de referencia é o ultimo parametro
            // nessa situação eu tenho que trocar o paramentro para validadeo (OK)
            $previsao_normal = ChamadaNormalParametro::where('data_ref', $diaHoje)->where('validacao', '!=', 'OK')->orderBy('id', 'DESC')->first();

            //return $verifica_chamados;
            $prev_norm = $previsao_normal->numero_inicial;
        } else {

            // nesse caso existem chamados...
            // tenho que ver se existem mais de 1 parametro... se existir só um, vale o numero_ref da ultima chamada

            $previsao_normal = ChamadaNormalParametro::where('data_ref', $diaHoje)->where('validacao', '!=', 'OK')->orderBy('id', 'DESC')->count();


            if ($previsao_normal == 0) {
                // nesse caso, todos os parametros já foram usados , então vale o último numero chamado + 1

                $verifica_ult_chamado_normal = Chamada::where('tipo', 'Normal')->where('created_at', 'LIKE', "$diaHoje%")->orderBy('id', 'DESC')->first();

                $prev_norm = $verifica_ult_chamado_normal->numero_ref + 1;

            } else {
                // nesse caso significa que tem algum parametro recem inserido, mas não validado...
                // então o que vale como numero é esse parametro...

                $previsao_normal_ultima = ChamadaNormalParametro::where('data_ref', $diaHoje)->where('validacao', '!=', 'OK')->orderBy('id', 'DESC')->first();
                $prev_norm = $previsao_normal_ultima + 1;
            }
        }


        // preciso verificar se existem chamados no dia de hj
        $verifica_chamados_pref = Chamada::where('tipo', 'Preferencial')->where('created_at', 'LIKE', "$diaHoje%")->count();

        if ($verifica_chamados_pref === 0) {

            // nesse caso, não existem chamadas ainda no dia de hoje

            // significa que o numero de referencia é o ultimo parametro
            // nessa situação eu tenho que trocar o paramentro para validadeo (OK)
            $previsao_preferencial = ChamadaPrioridadeParametro::where('data_ref', $diaHoje)->where('validacao', '!=', 'OK')->orderBy('id', 'DESC')->first();

            //return $verifica_chamados;
            $prev_pref = $previsao_preferencial->numero_inicial;
        } else {

            // nesse caso existem chamados...
            // tenho que ver se existem mais de 1 parametro... se existir só um, vale o numero_ref da ultima chamada

            $previsao_preferencial = ChamadaPrioridadeParametro::where('data_ref', $diaHoje)->where('validacao', '!=', 'OK')->orderBy('id', 'DESC')->count();

            if ($previsao_preferencial == 0) {
                // nesse caso, todos os parametros já foram usados , então vale o último numero chamado + 1

                $verifica_ult_chamado_preferencial = Chamada::where('tipo', 'Preferencial')->where('created_at', 'LIKE', "$diaHoje%")->orderBy('id', 'DESC')->first();

                $prev_pref = $verifica_ult_chamado_preferencial->numero_ref + 1;

            } else {
                // nesse caso significa que tem algum parametro recem inserido, mas não validado...
                // então o que vale como numero é esse parametro...

                $previsao_preferencial_ultima = ChamadaPrioridadeParametro::where('data_ref', $diaHoje)->where('validacao', '!=', 'OK')->orderBy('id', 'DESC')->first();
                $prev_pref = $previsao_preferencial_ultima + 1;
            }
        }

        // retorna as chamadas do painel
        $chamadasPainel = Chamada::where('panel_id', $panel->id)->get();

        return [$prev_norm, $prev_pref, $chamadasPainel];

    }

    // realiza uma chamada
    public function geraChamada(Request $request)
    {

        $usuario = Auth::user()->posto_grad . ' ' . Auth::user()->nome_guerra;

        $previsao = $this->previsaoChamada($request);

        if ($request->tipo === 'Normal') {
            $numero_ref = $previsao[0];
            $nome_ref = null;
        } elseif ($request->tipo === 'Preferencial') {
            $numero_ref = $previsao[1];
            $nome_ref = null;
        } else {
            $numero_ref = null;
            $nome_ref = $request->nome_ref;
        }

        $chamada = Chamada::create([
            'tipo' => $request->tipo,
            'guiche_id' => $request->guiche['id'],
            'numero_ref' => $numero_ref,
            'nome_ref' => $nome_ref,
            'panel_id' => $request->guiche['panel_id'],
            'status' => 'Aguardando',
            'chamador' => $usuario,
            'rechamada' => false,
            'tipo_atendimento' => null

        ]);

        // levar em consideração o dia
        $diaHoje = date('Y-m-d ');
        if ($request->tipo === 'Normal') {

            $parametro = ChamadaNormalParametro::where('validacao', 'Não Validado')->where('data_ref', $diaHoje)->where('numero_inicial', $numero_ref)->count();

            // se tem algo aqui nessa situação ( count > 0), significa que existem chamadas não validadas... logo tenho que validar

            if ($parametro > 0) {

                $chamadoNaoValidado = ChamadaNormalParametro::where('validacao', 'Não Validado')->where('data_ref', $diaHoje)->where('numero_inicial', $numero_ref)->get();

                foreach ($chamadoNaoValidado as $chamado) {
                    $chamado->validacao = 'Ok';
                    $chamado->save();
                }


            }

        } elseif ($request->tipo === 'Preferencial') {

            $parametro = ChamadaPrioridadeParametro::where('validacao', 'Não Validado')->where('data_ref', $diaHoje)->where('numero_inicial', $numero_ref)->count();

            if ($parametro > 0) {

                $chamadoNaoValidado = ChamadaPrioridadeParametro::where('validacao', 'Não Validado')->where('data_ref', $diaHoje)->where('numero_inicial', $numero_ref)->get();

                foreach ($chamadoNaoValidado as $chamado) {
                    $chamado->validacao = 'Ok';
                    $chamado->save();
                }

            }
        }


        return $chamada;


    }

    // verifica se existe alguma chamada em aberto que precisa de definição
    /*
     *  evita que o utilizador ao recarregar a página , possa chamar mais um
     * número sem terminar o atendimento de algum numero em aberto
    */
    public function checaAberto(Request $request)
    {

        $ipAddress = $request->ip();
        //$guiche = Guiche::where('ip', $ipAddress)->first();
        $guiche = Guiche::find(1)->load('panel.om');
        $chamada_aberta = Chamada::where('guiche_id', $guiche->id)->where('status', 'Aguardando')->count();

        //return $chamada_aberta;

        if ($chamada_aberta > 0) {
            // aqui eu retorno um objeto do tipo chamada
            return $chamada_aberta = Chamada::where('guiche_id', $guiche->id)->where('status', 'Aguardando')->first();
        } else {
            // aqui eu retorno um status 'OK'
            return 'Ok';
        }

    }

    // descarta uma chamda ativa
    public function descartaAtiva($id)
    {

        //$guiche = Guiche::where('ip', $request->ip())->first();
        $guiche = Guiche::find(1);

        // se o guiche for o dono da chamada, prossegue

        $chamada = Chamada::find($id);
        $chamada->status = 'Descartada';
        $chamada->save();
        return $chamada;
    }

    // finaliza uma chamada ativa
    public function finalizaAtiva(Request $request)
    {

        //$guiche = Guiche::where('ip', $request->ip())->first();
        $guiche = Guiche::find(1);

        // se o guiche for o dono da chamada, prossegue

        // encontro o público alvo
        $publicoAlvo = PublicoAlvo::find($request->publico_alvo);

        // encontro a chamada em questão
        // tenho que ver se essa chamada pertence ao guiche (implementar depois)
        $chamada = Chamada::find($request->id_chamada);

        // atribuo o tipo de chamada e o publico alvo para finalizar
        //status OK

        $lista_de_tipos = '';

        // ajusto os tipos

        for ($i = 0; $i < count($request->tipo_atendimento); $i++) {

            // primeiro encontro o tipo de atendimento
            $tipoAtendimento = TipoAtendimento::find($request->tipo_atendimento[$i]);

            if ($i === (count($request->tipo_atendimento) - 1)) {
                $textfinal = '';
            } else {
                $textfinal = ', ';
            }

            $lista_de_tipos = $lista_de_tipos . $tipoAtendimento->tipo . $textfinal;

            ChamadaTipoAtendimento::create([
                'tipo_atendimento_id' => $tipoAtendimento->id,
                'chamada_id' => $request->id_chamada
            ]);

        }

        $chamada->tipo_atendimento = $lista_de_tipos;

        $chamada->publico_alvo_id = $publicoAlvo->id;
        $chamada->publico_alvo = $publicoAlvo->tipo;
        $chamada->status = 'Ok';
        $chamada->save();

        return $chamada->load('chamadaTipoAtendimento.tipoAtendimento');
    }

    // realiza uma rechamada
    public function rechamadaAtiva($id)
    {
        //$guiche = Guiche::where('ip', $request->ip())->first();
        $guiche = Guiche::find(1);

        // se o guiche for o dono da chamada, prossegue

        $chamada = Chamada::find($id);

        $chamada->rechamada = 1;
        $chamada->status = 'Descartado por Rechamada';
        $chamada->save();

        $novaRechamada = Chamada::create([
            'panel_id' =>$chamada->panel_id,
            'tipo' =>$chamada->tipo,
            'tipo_atendimento' =>$chamada->tipo_atendimento,
            'publico_alvo' =>$chamada->publico_alvo,
            'publico_alvo_id' =>$chamada->publico_alvo_id,
            'guiche_id' =>$chamada->guiche_id,
            'numero_ref' =>$chamada->numero_ref,
            'nome_ref' =>$chamada->nome_ref,
            'chamador' =>$chamada->chamador,
            'rechamada' =>0,
            'status'=> 'Aguardando'
        ]);

        return [$novaRechamada,$chamada];
    }
}
