<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use App\Models\Historico;
use App\Models\Quiz;
use App\Models\QuizEstatistica;
use App\Models\QuizPergunta;
use App\Models\QuizResposta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizEstatisticaController extends Controller
{
    public function index()
    {
        return QuizEstatistica::all();

    }

    public function get($id)
    {

        $estatisticas = QuizEstatistica::where('quiz_id', $id)->get();

        $arrayLabel = [];
        $arrayScore =[];

        foreach ($estatisticas as $estatistica){
            $arrayLabel[] = $estatistica->score;
        }

        $arrayLabel = array_values(array_unique($arrayLabel));


        foreach ($arrayLabel as $iValue) {
            $arrayScore[] = $this->contaScore($id, $iValue);
        }

        $arrayTransformadoLabel = array_map(function($item) {
            return "nota $item";
        }, $arrayLabel);

        $dadosCombinados = [];
        foreach ($arrayLabel as $index => $label) {
            $dadosCombinados[] = [
                'label' => "nota $label",
                'score' => $arrayScore[$index] ?? null
            ];
        }



        return [$arrayTransformadoLabel, $arrayScore, $dadosCombinados];


    }

    private function contaScore($id, $score)
    {

        return QuizEstatistica::where('quiz_id', $id)->where('score', $score)->count();

    }

    public function store(Request $request)
    {

    }

    public function update(int $id, Request $request)
    {


    }
}
