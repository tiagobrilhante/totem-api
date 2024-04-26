<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Historico;
use App\Models\Imagem;
use App\Models\ImagemEventoAdicional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\JsonDecoder;

class EventoController extends Controller
{
    public function index()
    {
        return Evento::all()->load('imagensAdicionais');

    }

    public function show($id)
    {
        $imagem = Imagem::find($id);
        if (is_null($imagem)) {
            return response()->json('', 204);
        }
        return response()->json($imagem);
    }

    public function store(Request $request)
    {

        //--------------------------------//
        //------- DIA - MES - ANO --------//
        //--------------------------------//

        /*
         * devo me certificar que se não existir ano, mas veio dia e mes, a informação não pode ser persistida
         * o ano tem que sempre existir
         * se vier dia sem mês, isso tb é um erro
         * os casos possíveis são
         * --- dia-mes-ano
         * --- mes-ano
         * --- ano
         */

        // dia
        $dia = $this->validaCampo($request['dia'], 'string');
        // mes
        $mes = $this->validaCampo($request['mes'], 'string');
        // ano
        // anos são obrigatórios em eventos
        $ano = $request['ano'];

        // formatando os dados para gerar o histórico
        $dataEventoFormatado = '';
        if ($mes !== null && $dia !== null) {
            $dataEventoFormatado = $dia . '/' . $mes . '/' . $request['ano'];
        }
        if ($mes !== null && $dia === null) {
            $dataEventoFormatado = $mes . '/' . $request['ano'];
        }
        if ($mes === null && $dia === null) {
            $dataEventoFormatado = $request['ano'];
        }

        //--------------------------------//
        //--------Testes de Img ----------//
        //--------------------------------//

        $eventoTeste = 0;

        // tenho que saber se veio ou não uma imagem
        if ($request['imagem'] === null || $request['imagem'] === 'undefined' || $request['imagem'] === '') {
            $eventoTeste = 1;
        }

        //--------------------------------//
        //------------- NOME -------------//
        //--------------------------------//

        // pt_br
        // nomes em pt_br são obrigatórios
        //mtenho que verificar se existe nome em pt_be para solicitar que existam nomes em outra linguas
        $nome = $request['nome'];

        // en
        $nome_en = $this->validaCampo($request['nome_en'], 'string');
        // es
        $nome_es = $this->validaCampo($request['nome_es'], 'string');

        //--------------------------------//
        //----------- LEGENDA ------------//
        //--------------------------------//

        //pt_br
        //legendas em ptbr não são obrigatórias
        $legenda = $this->validaCampo($request['legenda'], 'string');

        // en
        $legenda_en = $this->validaCampo($request['legenda_en'], 'string');

        // es
        $legenda_es = $this->validaCampo($request['legenda_es'], 'string');

        //--------------------------------//
        //-----------SAIBA MAIS ----------//
        //--------------------------------//

        // pt_br
        /*
        pode ou não existir saiba mais em pt_br
        devo me certificar de como lidar com um evento que tenha saiba mais em outros idiomas, mas não tenha em pt_br
        devo ou não permitir?
        */
        $saibamais = $this->validaCampo($request['saibamais'], 'string');

        // en
        $saibamais_en = $this->validaCampo($request['saibamais_en'], 'string');

        // es
        $saibamais_es = $this->validaCampo($request['saibamais_es'], 'string');

        // inicio a construção do evento
        $evento = new Evento();

        // envio a imagem se ela veio no form
        if ($eventoTeste === 0) {
            // upload file //
            $file = $request['imagem'];
            $destination_path = 'eventos/' . $request['ano'] . '/';
            $file_mime = $file->extension();
            $filenameBase = 'img_' . time();
            $file->move($destination_path, $filenameBase . '.' . $file_mime);
            $evento->imagem = $destination_path . $filenameBase . '.' . $file_mime;

            // só vai existir uma fonte de imagem se veio uma i magem
            $evento->fonteimagempcp = $this->validaCampo($request['fonteimagempcp'], 'string');
        } else {
            $evento->imagem = null;
            $evento->fonteimagempcp = null;
        }

        // salvo o evento
        $evento->dia = $dia;
        $evento->mes = $mes;
        $evento->ano = $ano;
        $evento->nome = $nome;
        $evento->nome_en = $nome_en;
        $evento->nome_es = $nome_es;
        $evento->legenda = $legenda;
        $evento->legenda_en = $legenda_en;
        $evento->legenda_es = $legenda_es;
        $evento->saibamais = $saibamais;
        $evento->saibamais_en = $saibamais_en;
        $evento->saibamais_es = $saibamais_es;
        $evento->save();

        // criando histórico do evento (melhorar a geração de históricos
        Historico::create([
            'evento' => 'Foi criado o evento: ' . $evento->nome . ', data: ' . $dataEventoFormatado . ', imagem: ' . $evento->imagem . ', fonte imagem: ' . $evento->fonteimagempcp . ', legenda:' . $evento->legenda . ', Saiba Mais: ' . $evento->saibamais,
            'responsavel' => Auth::user()->nome,
            'user_id' => Auth::user()->id
        ]);

        // retorna o evento recém criado
        return response()
            ->json($evento, 201);
    }

    public function update(Request $request)
    {
        // encontro o evento
        $evento = Evento::find($request['id']);

        //--------------------------------//
        //------- DIA - MES - ANO --------//
        //--------------------------------//

        // dia
        $requestDia = $this->validaCampo($request['dia'], 'int');

        // mes
        $requestMes = $this->validaCampo($request['mes'], 'int');

        // anos são obrigatórios
        $requestAno = $request['ano'];
        $requestAno = (int)$requestAno;

        //--------------------------------//
        //------- IMAGEM E FONTE ---------//
        //--------------------------------//

        // testando se veio ou não a imagem
        $eventoTeste = 0;

        if ($request['imagem'] === null || $request['imagem'] === '' || $request['imagem'] === 'null' || $request['imagem'] === 'undefined') {
            $eventoTeste = 1;
        }
        if ($eventoTeste === 0) {
            $fonteimagempcp = $this->validaCampo($request['fonteimagempcp'], 'string');
        } else {
            $fonteimagempcp = null;
        }

        //--------------------------------//
        //------------ Nome -----------//
        //--------------------------------//

        // pt_br nomes são obrigatórios
        $nome = $request['nome'];

        // en
        $nome_en = $this->validaCampo($request['nome_en'], 'string');

        //es
        $nome_es = $this->validaCampo($request['nome_es'], 'string');

        //--------------------------------//
        //------------ Legenda -----------//
        //--------------------------------//

        // pt_br
        $legenda = $this->validaCampo($request['legenda'], 'string');

        // en
        $legenda_en = $this->validaCampo($request['legenda_en'], 'string');

        //es
        $legenda_es = $this->validaCampo($request['legenda_es'], 'string');

        //--------------------------------//
        //---------- Saiba Mais ----------//
        //--------------------------------//

        // pt_br
        $saibamais = $this->validaCampo($request['saibamais'], 'string');

        // en
        $saibamais_en = $this->validaCampo($request['saibamais_en'], 'string');

        //es
        $saibamais_es = $this->validaCampo($request['saibamais_es'], 'string');

        //--------------------------------//
        //-- Preparacoes para Historico --//
        //--------------------------------//

        $dataEventoFormatadoAntigo = '';
        $dataEventoFormatadoNovo = '';
        $caminhoImagemAntigo = $evento->imagem;
        $legendaOriginalAntiga = $evento->legenda;
        $saibaMaisOriginalAntiga = $evento->saibamais;
        $fonteImagemOriginalAntiga = $evento->fonteimagempcp;

        if ($evento->mes !== null && $evento->dia !== null) {
            $dataEventoFormatadoAntigo = $evento->dia . '/' . $evento->mes . '/' . $evento->ano;
        }
        if ($evento->mes !== null && $evento->dia === null) {
            $dataEventoFormatadoAntigo = $evento->mes . '/' . $evento->ano;
        }
        if ($evento->mes === null && $evento->dia === null) {
            $dataEventoFormatadoAntigo = $evento->ano;
        }

        if (($requestMes !== '' && $requestMes !== 'null') && ($requestDia !== '' && $requestDia !== 'null')) {
            $dataEventoFormatadoNovo = $requestDia . '/' . $requestMes . '/' . $requestAno;
        }

        if (($requestMes !== '' && $requestMes !== 'null') && ($requestDia === '' || $requestDia === 'null')) {
            $dataEventoFormatadoNovo = $requestMes . '/' . $requestAno;
        }
        if (($requestMes === '' || $requestMes === 'null') && ($requestDia === '' || $requestDia === 'null')) {
            $dataEventoFormatadoNovo = $requestAno;
        }

        //--------------------------------//
        //-- verificações de alteraçao ---//
        //--------------------------------//

        $evento->dia = $requestDia;
        $evento->mes = $requestMes;
        $evento->ano = $requestAno;
        $evento->nome = $nome;
        $evento->nome_en = $nome_en;
        $evento->nome_es = $nome_es;
        $evento->legenda = $legenda;
        $evento->legenda_en = $legenda_en;
        $evento->legenda_es = $legenda_es;
        $evento->saibamais = $saibamais;
        $evento->saibamais_en = $saibamais_en;
        $evento->saibamais_es = $saibamais_es;
        $evento->fonteimagempcp = $fonteimagempcp;


        // troca a imagem
        if ($eventoTeste === 0) {
            // apago a imagem anterior
            if ($evento->imagem !== null) {
                unlink($evento->imagem);
            }

            // subo a nova imagem
            $file = $request->file('imagem');
            $destination_path = 'eventos/' . $request['ano'] . '/';
            $file_mime = $file->extension();
            $filenameBase = 'img_' . time();
            $file->move($destination_path, $filenameBase . '.' . $file_mime);
            $evento->imagem = $destination_path . $filenameBase . '.' . $file_mime;
        }

        // cria o hstorico (preciso melhorar o processo de criação de históricos
        Historico::create([
            'evento' =>
                'Foi alterado o evento de: ' . $evento->nome . ' para: ' . $request['nome'] .
                ', data de: ' . $dataEventoFormatadoAntigo . ', para: ' . $dataEventoFormatadoNovo .
                ', imagem de: ' . $caminhoImagemAntigo . ', para: ' . $evento->imagem .
                ', legenda de: ' . $legendaOriginalAntiga . ', para: ' . $evento->legenda .
                ', Saiba Mais de: ' . $saibaMaisOriginalAntiga . ', para: ' . $evento->saibamais,
            'responsavel' => Auth::user()->nome,
            'user_id' => Auth::user()->id
        ]);

        //salva e devolve
        $evento->save();
        return $evento;
    }

    public function destroy($id)
    {

        $evento = Evento::find($id);

        Historico::create([
            'evento' => 'Foi excluído o evento : ' . $evento->nome,
            'responsavel' => Auth::user()->nome,
            'user_id' => Auth::user()->id
        ]);

        if ($evento->imagem !== null) {
            unlink($evento->imagem);
        }

        $evento = Evento::destroy($id);

        if ($evento === 0) {

            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);

        } else {
            return response()->json('', 204);
        }

    }

    public function removeImagem(Request $request)
    {
        $evento = Evento::find($request['id']);

        if ($evento->imagem !== null) {
            unlink($evento->imagem);
        }

        $evento->imagem = null;
        $evento->fonteimagempcp = null;
        $evento->save();

        return $evento;

    }

    public function totemPcp(Request $request)
    {
        // Obter todos os eventos
        $todosEventos = Evento::all();

        // Agrupar eventos por ano usando a Collection
        $anosExistentes = [];

        foreach ($todosEventos as $te) {
            $anosExistentes[] = $te->ano;
        }

        $anosExistentes = array_unique($anosExistentes);

        sort($anosExistentes);

        $itensPorPag = 8;

        $totalPaginas = ceil(count($anosExistentes) / $itensPorPag);
        $arrayDeArrays = [];

        for ($i = 0; $i < $totalPaginas; $i++) {
            $inicio = $i * $itensPorPag;
            $subarray = array_slice($anosExistentes, $inicio, $itensPorPag);
            $arrayDeArrays[] = $subarray;
        }

        $montagemRetorno = [];


        foreach ($arrayDeArrays[0] as $j => $jValue) {
            $eventos = Evento::where('ano', $arrayDeArrays[0][$j])->get()->load('imagensAdicionais');

            $imagem = $this->retornaBanner($jValue);

            $grupo = ['ano' => $arrayDeArrays[0][$j], 'eventos' => $eventos, 'imagem' => $imagem];
            $montagemRetorno[] = $grupo;
        }

        $temProxPag = false;

        if ($totalPaginas > 1) {
            $temProxPag = true;
        }

        return [$montagemRetorno, 1, $temProxPag];

    }

    public function pegaPorPag($pag)
    {

        // Obter todos os eventos
        $todosEventos = Evento::all()->load('imagensAdicionais');

        // Agrupar eventos por ano usando a Collection
        $anosExistentes = [];

        foreach ($todosEventos as $te) {
            $anosExistentes[] = $te->ano;
        }

        $anosExistentes = array_unique($anosExistentes);

        sort($anosExistentes);

        $itensPorPag = 8;

        $totalPaginas = ceil(count($anosExistentes) / $itensPorPag);
        $arrayDeArrays = [];

        for ($i = 0; $i < $totalPaginas; $i++) {
            $inicio = $i * $itensPorPag;
            $subarray = array_slice($anosExistentes, $inicio, $itensPorPag);
            $arrayDeArrays[] = $subarray;
        }

        $montagemRetorno = [];

        foreach ($arrayDeArrays[$pag - 1] as $j => $jValue) {

            $imagem = $this->retornaBanner($jValue);

            $grupo = ['ano' => $arrayDeArrays[$pag - 1][$j], 'eventos' => Evento::where('ano', $arrayDeArrays[$pag - 1][$j])->get()->load('imagensAdicionais'), 'imagem' => $imagem];
            $montagemRetorno[] = $grupo;
        }

        $temProxPag = false;

        if ($totalPaginas != $pag) {
            $temProxPag = true;
        }

        return [$montagemRetorno, (int)$pag, $temProxPag];

    }


    public function retornaBanner($ano)
    {
        $eventos = Evento::where('ano', $ano)->get();
        $numeroEventos = Evento::where('ano', $ano)->count();
        if ($numeroEventos >= 1) {

            foreach ($eventos as $evento) {
                if ($evento->imagem !== null) {
                    return $evento->imagem;
                }
            }

        } else {
            return 'nada';
        }
    }

    public function addimgadicional(Request $request)
    {

        $eventoTeste = 0;

        if ($request['imagem'] === null || $request['imagem'] === 'undefined' || $request['imagem'] === '') {
            $eventoTeste = 1;
        }

        if ($eventoTeste === 0) {
            $fonte = $this->validaCampo($request['fonte'], 'string');
        } else {
            $fonte = null;
        }

        $imagemAdicional = new ImagemEventoAdicional();

        $descricao = $this->validaCampo($request['descricao'], 'string');
        $descricao_en = $this->validaCampo($request['descricao_en'], 'string');
        $descricao_es = $this->validaCampo($request['descricao_es'], 'string');

        if ($eventoTeste === 0) {
            // upload file //
            $file = $request['imagem'];
            $destination_path = 'eventosimgadicional/' . $request['evento_id'] . '/';
            $file_mime = $file->extension();
            $filenameBase = 'img_' . time();
            $file->move($destination_path, $filenameBase . '.' . $file_mime);
            $imagemAdicional->imagem = $destination_path . $filenameBase . '.' . $file_mime;
            $imagemAdicional->fonte = $fonte;
            $imagemAdicional->descricao = $descricao;
            $imagemAdicional->descricao_en = $descricao_en;
            $imagemAdicional->descricao_es = $descricao_es;
            $imagemAdicional->evento_id = $request['evento_id'];
            $imagemAdicional->save();
            return response()
                ->json(Evento::find($request['evento_id'])->load('imagensAdicionais'), 201);
        } else {
            return 'nada';
        }
    }

    public function deletaimgadicional($id)
    {
        $imagem = ImagemEventoAdicional::find($id);

        unlink($imagem->imagem);

        ImagemEventoAdicional::destroy($id);

        if ($imagem === 0) {

            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);

        } else {
            return response()->json('', 204);
        }

    }

    public function incrementaAcesso(Request $request)
    {
        $evento = Evento::find($request['id']);
        $evento->acessos++;
        $evento->save();
        return $evento;
    }

    public function validaCampo($campo, $tipo)
    {
        if ($campo === '' || $campo === 'null') {
            $campo = null;
        }
        // String e int
        if ($tipo === 'int') {
            if ($campo === 0 || $campo === '0' || $campo === 'null' || $campo === null) {
                $campo = null;
            } else {
                $campo = (int)$campo;
            }
        }

        return $campo;
    }
}
