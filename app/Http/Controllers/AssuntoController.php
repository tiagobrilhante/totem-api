<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use App\Models\Historico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssuntoController extends Controller
{
    public function index()
    {
        return Assunto::all();

    }

    public function store(Request $request)
    {
        $ultimaOrdem = Assunto::max('ordem_exibicao');
        $ordemPassada = $request['ordem_exibicao'];

        // primeiro caso - a ordem é igual a uma existente maior
        // segundo caso - a ordem é igual a uma existente menor
        // terceiro caso, a ordem é mair em 2 do que a ultima ordem
        // se a ordem passada for em branco aí fica como ultima

        if ($ordemPassada === null || $ordemPassada === '') {
            $ordemPassada = $ultimaOrdem + 1;
        }

        if ($ordemPassada >= $ultimaOrdem + 2) {
            $ordemPassada = $ultimaOrdem + 1;
        }

        if ($ordemPassada === $ultimaOrdem) {
            $ordemPassada = $ultimaOrdem + 1;
        }

        if ($ordemPassada < $ultimaOrdem) {

            $assuntos = Assunto::all();

            foreach ($assuntos as $assunto){
                if ($ordemPassada <= $assunto->ordem_exibicao) {
                    $assunto->ordem_exibicao++;
                    $assunto->save();
                }
            }

        }

        $assuntoNovo = Assunto::create([
            'nome_assunto' => $request['nome_assunto'],
            'nome_assunto_en' => $request['nome_assunto_en'],
            'nome_assunto_es' => $request['nome_assunto_es'],
            'ordem_exibicao' => $ordemPassada,
        ]);

        Historico::create([
            'evento' => 'Foi criado o assunto: '.$assuntoNovo->nome_assunto . ', na ordem de exibição: '. $assuntoNovo->ordem_exibicao,
            'responsavel'=> Auth::user()->nome,
            'user_id'=> Auth::user()->id
        ]);

        return response()
            ->json($assuntoNovo, 201);

    }

    public function destroy($id)
    {

        $assunto = Assunto::find($id);

        if (is_null($assunto)) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }

        // Obtém a ordem do assunto que será excluído
        $ordemExcluido = $assunto->ordem_exibicao;


        Historico::create([
            'evento' => 'Foi removido o assunto: '.$assunto->nome_assunto . ', na ordem de exibição: '. $assunto->ordem_exibicao,
            'responsavel'=> Auth::user()->nome,
            'user_id'=> Auth::user()->id
        ]);


        // Exclui o assunto
        $assunto->delete();

        // Obtém todos os assuntos restantes após a exclusão
        $assuntosAjustar = Assunto::orderBy('ordem_exibicao')->get();

        // Reajusta as ordens dos outros assuntos
        foreach ($assuntosAjustar as $aa) {
            if ($aa->ordem_exibicao > $ordemExcluido) {
                $aa->ordem_exibicao = $aa->ordem_exibicao-1;
                $aa->save();
            }
        }



        return response()->json([
            'mensagem' => 'Assunto excluído e ordens reajustadas'
        ], 200);

    }

    public function update(int $id, Request $request)
    {
        $assunto = Assunto::find($id);

        if (is_null($assunto)) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }

        $novaOrdem = (int) $request['ordem_exibicao'];


        Historico::create([
            'evento' => 'Foi alterado o assunto de: '.$assunto->nome_assunto . ', para: '.$request['nome_assunto'].', na ordem de exibição de: '. $assunto->ordem_exibicao . ', para:' . $novaOrdem,
            'responsavel'=> Auth::user()->nome,
            'user_id'=> Auth::user()->id
        ]);

        // Obtém todos os assuntos exceto o assunto sendo atualizado
        $assuntosAjustar = Assunto::where('id', '!=', $id)->orderBy('ordem_exibicao')->get();

        // Verifica se a nova ordem está dentro do intervalo válido
        if ($novaOrdem >= 1 && $novaOrdem <= count($assuntosAjustar) + 1) {
            // Reajusta as ordens dos outros assuntos
            foreach ($assuntosAjustar as $index => $assuntoAjustar) {
                if ($index + 1 >= $novaOrdem) {
                    $assuntoAjustar->ordem_exibicao = $index + 2;
                    $assuntoAjustar->save();
                }
            }

            // Atualiza a ordem do assunto selecionado
            $assunto->nome_assunto = $request['nome_assunto'];
            $assunto->nome_assunto_en = $request['nome_assunto_en'];
            $assunto->nome_assunto_es = $request['nome_assunto_es'];
            $assunto->ordem_exibicao = $novaOrdem;
            $assunto->save();

            return $assunto;
        }

        return response()->json([
            'erro' => 'Nova ordem inválida'
        ], 400);
    }

    public function totemPcp(Request $request)
    {
        $assuntosPaginados = Assunto::whereHas('imagens')->orderBy('ordem_exibicao', 'ASC')->paginate($request->per_page);
        $assuntosPaginados->load('imagens');
        return response()->json($assuntosPaginados);
    }

    public function incrementaAcesso(Request $request)
    {
       $assunto = Assunto::find($request['id']);
       $assunto->acessos++;
       $assunto->save();

       return $assunto;
    }
}
