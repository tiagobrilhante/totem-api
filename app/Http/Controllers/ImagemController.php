<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use App\Models\Historico;
use App\Models\Imagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ImagemController extends Controller
{
    public function index()
    {
        return Imagem::all();

    }

    public function store(Request $request)
    {

        // instancio a nova imagem
        $imagem = new Imagem();

        // verifico a ordem das imagens
        $todasImagens = Imagem::where('assunto_id', $request['assunto_id'])->orderBy('ordem')->get();

        // preparativos para upload file //
        $file = $request['imagem'];
        $destination_path = 'imagens/' . $request['assunto_id'] . '/';
        $file_mime = $file->extension();
        $filenameBase = 'img_' . time();

        //-------------------------------------------------//
        // -------- Ajustes de situação de banner -------- //
        //-------------------------------------------------//

        $eBanner = 0;

        // caso não exista nenhuma imagem, a imagem cadastrada passa a ser banner
        if ($todasImagens->count() === 0) {
            $eBanner = 1;
        }

        // somente pode existir um banner
        if ($request['banner'] === "true" || $request['banner'] === true) {

            foreach ($todasImagens as $ti) {
                $ti->banner = 0;
                $ti->save();
            }

            $eBanner = 1;
        }

        //-------------------------------------------------//
        // ------ Ajustes de ordenação de assuntos ------- //
        //-------------------------------------------------//

        $ordemReal = $request['ordem'];

        // caso não exista nenhuma imagem, a ordem começa em 1
        if ($todasImagens->count() === 0) {
            $ordemReal = 1;
        } elseif ($ordemReal === '' || $ordemReal > $todasImagens->count() + 1) {
            // caso o usuário não passe nenhuma ordem, ou a ordem passada seja maior que a quantidade de imagens + 1
            // a ordem passa a ser a próxima
            // Exemplo:
            // se o numero de imagens existentes com 8 e eu passar a ordem real como 9
            // vamos manter o 9 (o óbvio precisa ser tratado)
            $ordemReal = $todasImagens->count() + 1;

        } elseif ($ordemReal <= $todasImagens->count()) {

            // nesse caso eu verifico se a ordemRecebida é igual a uma ordem existente

            foreach ($todasImagens as $ti) {
                // em todass as imagens eu verifico
                // se a ordem é maior ou igual a algo que já existe
                if ($ti->ordem >= $request['ordem']) {
                    // eu somo a ordem em 1, empurrando todas as outras para depois dela
                    ++$ti->ordem;
                    // e salvo
                    $ti->save();
                }
            }
        }

        // save file data into database //
        $imagem->imagem = $destination_path . $filenameBase . '.' . $file_mime;
        $imagem->nome = $request['nome'];
        $imagem->ordem = $ordemReal;
        $imagem->legenda = $request['legenda'];
        $imagem->saibamais = $request['saibamais'];
        $imagem->fonte = $request['fonte'];
        $imagem->banner = $eBanner;
        $imagem->assunto_id = $request['assunto_id'];
        $imagem->save();
        $file->move($destination_path, $filenameBase . '.' . $file_mime);

        $assuntoo = Assunto::find($request['assunto_id']);

        Historico::create([
            'evento' => 'Foi inserida a imagem: '.$imagem->imagem . ', nome: '.$imagem->nome.', ordem: '. $imagem->ordem . ', legenda:' . $imagem->legenda . 'saiba mais: ' . $imagem->saibamais . ', assunto de referência: '. $assuntoo->nome_assunto,
            'responsavel'=> Auth::user()->nome,
            'user_id'=> Auth::user()->id
        ]);

        return response()
            ->json($imagem, 201);

    }

    public function show($id)
    {

        $imagem = Imagem::find($id);

        if (is_null($imagem)) {

            return response()->json('', 204);

        }

        return response()->json($imagem);

    }

    public function update(Request $request)
    {
        // encontra o objeto imagem a ser alterado
        $imagem = Imagem::find($request['id']);

        //dados da imagem existente (antes da modificação)
        if ($request['trocaImagem'] == "true") {
            $file = $imagem->imagem;
            $filenameBase = explode('img_', $file)[1];
            $filenameBaseFinal = 'img_' . $filenameBase;
        }


        // todas as imagens do assunto informado
        $todasImagens = Imagem::where('assunto_id', $request['assunto_id'])->orderBy('ordem')->get();

        $todasImagensAntigas = Imagem::where('assunto_id', $imagem->assunto_id)->where('id', '!=', $imagem->id)->orderBy('ordem')->get();

        // se é nulo ( retorna )
        if (is_null($imagem)) {

            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);

        }

        // o assunto está mudando?
        if ($request['assunto_id'] != $imagem->assunto_id) {

            $destination_path = 'imagens/' . $request['assunto_id'] . '/';
            $origem = base_path('public/' . $file); // Caminho completo do arquivo de origem
            $destino = base_path('public/' . $destination_path . $filenameBaseFinal); // Caminho completo do destino

            // nesse caso eu mantendo a imagem, mas mudando ela de pasta
            if ($request['imagem'] === 'undefined') {
                // Verifica se o arquivo de origem existe e move para o novo local (referente ao assunto)
                // (retorna a $imagemNovaBanco )
                if (File::exists($origem)) {
                    // Crie a pasta de destino, se não existir
                    if (!File::isDirectory(dirname($destino))) {
                        File::makeDirectory(dirname($destino), 0755, true, true);
                    }

                    // Move o arquivo para o destino
                    File::move($origem, $destino);

                    // Atualize o caminho da imagem no banco de dados
                    $imagemNovaBanco = $destination_path . $filenameBaseFinal;
                    $imagem->imagem = $imagemNovaBanco;
                }

            } else {
                // nesse caso está entrando outra imagem no lugar da antiga
                unlink($imagem->imagem);
                $filenameBaseAjuste = 'img_' . time();
                $file = $request['imagem'];
                $file_mime = $file->extension();
                $imagemNovaBanco = $destination_path . $filenameBaseAjuste . '.' . $file_mime;
                $file->move($destination_path, $filenameBaseAjuste . '.' . $file_mime);
                $imagem->imagem = $imagemNovaBanco;

            }

            // agora eu reajusto a ordem das imagens do assunto antigo e o banner caso mude
            $ordemAntiga = $imagem->ordem;
            $contadorBanner = 0;

            if ($todasImagensAntigas->count() > 0) {
                foreach ($todasImagensAntigas as $imgAntiga) {
                    if ($imgAntiga->banner == 1) {
                        $contadorBanner++;
                    }

                    if ($imgAntiga->ordem > $ordemAntiga) {
                        --$imgAntiga->ordem;
                        $imgAntiga->save();
                    }

                }

                if ($contadorBanner == 0) {
                    $ajuste = $todasImagensAntigas->first();
                    $ajuste->banner = 1;
                    $ajuste->save();
                }
            }

            // em seguida eu verifico a ordem dentro do novo assunto (se eu mudei o assunto, com certeza tenho que adequar a nova ordem)
            // essa é a ordem que eu recebi
            $ordemReal = $request['ordem'];

            // a ordem é relativa ao assunto considerado, mas impacta no assunto anterior tb, pois vai ser removido um
            // começo testando se no assunto novo existem novas imagens

            if ($ordemReal != $imagem->ordem ) {
                if ($todasImagens->count() === 0) {
                    $ordemReal = 1;
                } // aqui eu sei que existem imagens lá
                elseif ($ordemReal === '' || $ordemReal > $todasImagens->count() + 1) {
                    $ordemReal = $todasImagens->count() + 1;
                } elseif ($ordemReal <= $todasImagens->count()) {
                    // nesse caso eu verifico se a ordemRecebida é igual a uma ordem existente
                    foreach ($todasImagens as $ti) {
                        if ($ti->ordem >= $request['ordem']) {
                            ++$ti->ordem;
                            $ti->save();
                        }
                    }
                }
            }


            // agora verifico a situação sobre banner (no novo assunto)
            $eBanner = $request['banner'];

            // somente pode existir um banner no assunto novo
            if ($eBanner) {

                foreach ($todasImagens as $ti) {
                    $ti->banner = 0;
                    $ti->save();
                }

                $eBanner = 1;
            } else {
                $eBanner = 0;
            }

            // se não estou mudando a imagem, mas o assunto muda
            $imagem->nome = $request['nome'];
            $imagem->ordem = $ordemReal;

            $imagem->legenda = $request['legenda'];
            $imagem->fonte = $request['fonte'];
            $imagem->saibamais = $request['saibamais'];
            $imagem->banner = $eBanner;
            $imagem->assunto_id = $request['assunto_id'];
            $imagem->save();

        } else {

            // não vou mudar de assunto

            // se eu for mudar a imagem entro aqui
            if ($request['imagem'] !== 'undefined') {
                unlink($imagem->imagem);
                $destination_path = 'imagens/' . $request['assunto_id'] . '/';
                $filenameBaseAjuste = 'img_' . time();
                $file = $request['imagem'];
                $file_mime = $file->extension();
                $imagemNovaBanco = $destination_path . $filenameBaseAjuste . '.' . $file_mime;
                $file->move($destination_path, $filenameBaseAjuste . '.' . $file_mime);
                $imagem->imagem = $imagemNovaBanco;

            }

            $todasImagens = Imagem::where('assunto_id', $imagem->assunto_id)->where('id', '!=', $imagem->id)->orderBy('ordem')->get();

            // ajusto a odem se for o caso
            $ordemReal = $request['ordem'];

            if ($ordemReal != $imagem->ordem) {
                // NOVO LOCAL
                if ($todasImagens->count() === 0) {
                    $ordemReal = 1;
                } // aqui eu sei que existem imagens lá
                elseif ($ordemReal === '' || $ordemReal > $todasImagens->count() + 1) {
                    $ordemReal = $todasImagens->count() + 1;
                } elseif ($ordemReal <= $todasImagens->count()) {
                    // nesse caso eu verifico se a ordemRecebida é igual a uma ordem existente
                    foreach ($todasImagens as $ti) {
                        if ($ti->ordem >= $request['ordem']) {
                            ++$ti->ordem;
                            $ti->save();
                        }
                    }
                }
            }


            // austo o banner se for o caso
            $eBanner = $request['banner'];

            // somente pode existir um banner no assunto novo
            if ($eBanner) {

                foreach ($todasImagens as $ti) {
                    $ti->banner = 0;
                    $ti->save();
                }

                $eBanner = 1;
            } else {
                if ($todasImagens->count() === 0) {
                    $eBanner = 1;
                } else {
                    $eBanner = 0;
                }
            }


            $imagem->nome = $request['nome'];
            $imagem->ordem = $ordemReal;
            $imagem->legenda = $request['legenda'];
            $imagem->fonte = $request['fonte'];
            $imagem->saibamais = $request['saibamais'];
            $imagem->banner = $eBanner;
            $imagem->assunto_id = $request['assunto_id'];
            $imagem->save();

        }


        /*
        $assuntoo = Assunto::find($request['assunto_id']);

        Historico::create([
            'evento' => 'Foi inserida a imagem: '.$imagem->imagem . ', nome: '.$imagem->nome.', ordem: '. $imagem->ordem . ', legenda:' . $imagem->legenda . ', assunto de referência: '. $assuntoo->nome_assunto,
            'responsavel'=> Auth::user()->nome,
            'user_id'=> Auth::user()->id
        ]);
        */

        return $imagem;

    }

    public function destroy($id)
    {

        $imagem = Imagem::find($id);

        $assuntoo = Assunto::find($imagem->assunto_id);


        Historico::create([
            'evento' => 'Foi excluída a imagem: '.$imagem->imagem . ', nome: '.$imagem->nome.', ordem: '. $imagem->ordem . ', legenda:' . $imagem->legenda . ', assunto de referência: '. $assuntoo->nome_assunto,
            'responsavel'=> Auth::user()->nome,
            'user_id'=> Auth::user()->id
        ]);


        unlink($imagem->imagem);


        // tenho que verificar as novas ordens das imagens

        $imagem = Imagem::destroy($id);

        if ($imagem === 0) {

            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);

        } else {
            return response()->json('', 204);
        }

    }

    public function getImagemAssunto($id)
    {
        return Imagem::where('assunto_id', $id)->orderBy('ordem')->get();

    }

    public function incrementaAcesso(Request $request)
    {
        $imagem = Imagem::find($request['id']);
        $imagem->acessos++;
        $imagem->save();

        return $imagem;
    }

}
