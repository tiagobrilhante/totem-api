<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use App\Models\Evento;
use App\Models\Historico;
use App\Models\Imagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstatisticaController extends Controller
{
    public function getEstatisticas($tipo)
    {

        if ($tipo === 'data') {
            $eventos = Evento::where('acessos', '>', 0)->get();
            $quantidadeEventosCadastrados = Evento::all()->count();
            $eventoMaisAcessado = Evento::orderBy('acessos', 'desc')->select('ano','nome', 'acessos')->first();
            $todosEventos = Evento::select('ano','nome', 'acessos')->get();

            $anos = [];
            foreach ($eventos as $evento) {
                $anos[] = (int)$evento->ano;
            }
            $anos = array_values(array_unique($anos));
            $acessos = [];
            foreach ($anos as $ano) {
                $acessos[] = (int)$this->contaAcessosEventoAno($ano);
            }
            return [$anos, $acessos, $quantidadeEventosCadastrados, $eventoMaisAcessado, $todosEventos];

        } else {

            $assuntos = Assunto::where('acessos', '>', 0)->get();
            $quantidadeAssuntosCadastrados = Assunto::all()->count();
            $assuntoMaisAcessado = Assunto::orderBy('acessos', 'desc')->select('nome_assunto', 'acessos')->first();
            $todosAssuntos = Assunto::select('nome_assunto', 'acessos')->get();

            $assuntos_label = [];
            $acessos = [];
            foreach ($assuntos as $assunto) {
                $assuntos_label[] = $assunto->nome_assunto;
                $acessos[] = $assunto->acessos;
            }

            $imgMaisAcessada = Imagem::orderBy('acessos', 'desc')->first();

            $imgs = Imagem::where('acessos', '>', 0)->get();
            $img_label = [];
            $img_acessos = [];
            $todasImagens = Imagem::all();

            foreach ($imgs as $img) {
                $img_label[] = $img->nome;
                $img_acessos[] = $img->acessos;
            }

            return [$assuntos_label, $acessos, $quantidadeAssuntosCadastrados, $assuntoMaisAcessado, $todosAssuntos, $imgMaisAcessada, $img_label, $img_acessos, $todasImagens];

        }


    }

    private function contaAcessosEventoAno($ano)
    {
        return Evento::where('ano', $ano)->sum('acessos');
    }

}
