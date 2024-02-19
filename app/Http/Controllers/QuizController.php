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

class QuizController extends Controller
{
    public function index()
    {
        return Quiz::all()->load('perguntas.respostas', 'estatisticas');

    }

    public function get($id)
    {

    }

    public function store(Request $request)
    {
        /*
         * testes a serem realizados...
         * tem que ter cabecalho, pontuaçao maxima
         * e ao menos uma pergunta
         * para cada pergunta existente tem que ter ao menos 2 respostas, sendo que uma delas tem que ser a correta
         * não podem existir 2 respoistas corretas
         */

        if ($request['cabecalho'] === '') {
            return 'erro de ausência de cabeçalho';

        }

        if (count($request['perguntas']) === 0) {
            return 'erro de quantidade de perguntas';
        }

        foreach ($request['perguntas'] as $iValue) {

            if (count($iValue['respostas']) < 2) {
                return 'erro de quantidade de respostas';
            } else {
                $qtdCorreta = 0;
                foreach ($iValue['respostas'] as $resposta) {
                    if ($resposta['correta']) {
                        $qtdCorreta++;
                    }

                    if ($qtdCorreta > 1) {
                        return 'erro de quantidade de respostas corretas';
                    }
                }

            }

        }


        $quiz = Quiz::create([
            'cabecalho' => $request['cabecalho'],
            'maxscore' => (int)$request['maxscore'],
            'ativo' => false
        ]);

        // cadastro as perguntas
        foreach ($request['perguntas'] as $dadosPergunta) {

            $perguntaCriada = QuizPergunta::create([
                'enunciado' => $dadosPergunta['enunciado'],
                'quiz_id' => $quiz->id
            ]);

            // Cadastra as respostas
            foreach ($dadosPergunta['respostas'] as $dadosResposta) {
                QuizResposta::create([
                    'resposta' => $dadosResposta['resposta'],
                    'correta' => $dadosResposta['correta'], // Atenção à chave 'correta'
                    'quiz_pergunta_id' => $perguntaCriada->id
                ]);
            }
        }

        // Retorna o objeto criado
        return $quiz->load('perguntas.respostas');
    }

    public function update(int $id, Request $request)
    {
        $quiz = Quiz::find($id);

        if ($request['cabecalho'] === '') {
            return 'erro de ausência de cabeçalho';
        }

        if (count($request['perguntas']) === 0) {
            return 'erro de quantidade de perguntas';
        }

        $perguntasIds = [];
        $respostasIds = [];

        foreach ($request['perguntas'] as $dadosPergunta) {
            // Validação da quantidade de respostas
            if (count($dadosPergunta['respostas']) < 2) {
                return response()->json(['error' => 'Erro de quantidade de respostas'], 400);
            }

            // Controle de respostas corretas
            $qtdCorreta = 0;
            foreach ($dadosPergunta['respostas'] as $dadosResposta) {
                if ($dadosResposta['correta']) {
                    $qtdCorreta++;
                }
            }
            if ($qtdCorreta !== 1) {
                return response()->json(['error' => 'Erro de quantidade de respostas corretas'], 400);
            }

            // Atualiza ou cria a pergunta
            $pergunta = QuizPergunta::updateOrCreate(
                ['id' => $dadosPergunta['id'] ?? null],
                ['enunciado' => $dadosPergunta['enunciado'], 'quiz_id' => $quiz->id]
            );

            $perguntasIds[] = $pergunta->id;

            foreach ($dadosPergunta['respostas'] as $dadosResposta) {
                // Atualiza ou cria a resposta
                $resposta = QuizResposta::updateOrCreate(
                    ['id' => $dadosResposta['id'] ?? null],
                    [
                        'resposta' => $dadosResposta['resposta'],
                        'correta' => $dadosResposta['correta'],
                        'quiz_pergunta_id' => $pergunta->id
                    ]
                );

                $respostasIds[] = $resposta->id;
            }
        }



        $quiz->update([
            'cabecalho' => $request['cabecalho'],
            'maxscore' => (int)$request['maxscore']
        ]);


        // Remove perguntas e respostas que não estão mais presentes
        QuizPergunta::where('quiz_id', $quiz->id)->whereNotIn('id', $perguntasIds)->delete();
        QuizResposta::whereNotIn('id', $respostasIds)->delete();


        // Retorna o objeto criado
        return $quiz->load('perguntas.respostas');

    }

    public function destroy($id)
    {

        $quiz = Quiz::find($id);

        if (is_null($quiz)) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }

        Historico::create([
            'evento' => 'Foi removido o quiz: ' . $quiz->enunciado,
            'responsavel' => Auth::user()->nome,
            'user_id' => Auth::user()->id
        ]);


        // Exclui o quiz
        $quiz->delete();

        return response()->json([
            'mensagem' => 'Quiz Excluído com sucesso'
        ], 200);

    }

    public function ativaDesativa(Request $request)
    {

        $quiz = Quiz::find($request['id']);

        if ($request['acao'] === 'desativa') {
            $quiz->ativo = false;
        } else {
            $quiz->ativo = true;
        }

        $quiz->save();

    }

    public function pegaQuiz()
    {
        return Quiz::where('ativo', true)->get();
    }

    public function pegaQuizCompleto($id)
    {
        $quiz = Quiz::findOrFail($id)->load('perguntas.respostas');

        // Oculta o atributo 'correta' de cada resposta
        foreach ($quiz->perguntas as $pergunta) {
            foreach ($pergunta->respostas as $resposta) {
                $resposta->makeHidden('correta');
            }
        }

        return $quiz;
    }

    public function confereRespostas(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id)->load('perguntas.respostas');
        $respostasUsuario = $request->all(); // Recebe as respostas do usuário

        $quantidadeCorretas = 0; // Inicializa o contador de respostas corretas

        $quantidadePerguntas = 0;

        foreach ($quiz->perguntas as $pergunta) {
            $quantidadePerguntas++;
            $idRespostaEscolhida = $respostasUsuario[$pergunta->id] ?? null;

            // Encontra a resposta escolhida pelo usuário
            $respostaEscolhida = $pergunta->respostas->firstWhere('id', $idRespostaEscolhida);

            // Incrementa o contador se a resposta escolhida for a correta
            if ($respostaEscolhida && $respostaEscolhida->correta) {
                $quantidadeCorretas++;
            }
        }

        // verifico a pontuação final

        $pontoPorAcerto = $quiz->maxscore / $quantidadePerguntas;

        $scoreUsuario = ceil($quantidadeCorretas * $pontoPorAcerto * 10) / 10;

        QuizEstatistica::create([
            'quiz_id'=>$quiz->id,
            'score'=>$scoreUsuario
        ]);

        return response()->json([$quantidadeCorretas,$scoreUsuario]);
    }
}
