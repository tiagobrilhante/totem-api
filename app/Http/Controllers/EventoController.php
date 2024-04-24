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


    public function store(Request $request)
    {
        $eventoTeste = 0;

        if ($request['imagem'] === null) {
            $eventoTeste = 1;
        }

        if ($request['imagem'] === 'undefined') {
            $eventoTeste = 1;
        }

        if ($request['imagem'] === '') {
            $eventoTeste = 1;
        }
        $evento = new Evento();

        $saibamais = $request['saibamais'];
        if ($request['saibamais'] == '' || $request['saibamais'] == null || $request['saibamais'] == 'null') {
            $saibamais = null;

        }

        $saibamais_en = $request['saibamais_en'];
        if ($request['saibamais_en'] == '' || $request['saibamais_en'] == null || $request['saibamais_en'] == 'null') {
            $saibamais_en = null;

        }

        $saibamais_es = $request['saibamais_es'];
        if ($request['saibamais_es'] == '' || $request['saibamais_es'] == null || $request['saibamais_es'] == 'null') {
            $saibamais_es = null;

        }

        $nome_en = $request['nome_en'];
        if ($request['nome_en'] == '' || $request['nome_en'] == null || $request['nome_en'] == 'null') {
            $nome_en = null;

        }

        $nome_es = $request['nome_es'];
        if ($request['nome_es'] == '' || $request['nome_es'] == null || $request['nome_es'] == 'null') {
            $nome_es = null;

        }

        $legenda_en = $request['legenda_en'];
        if ($request['legenda_en'] == '' || $request['legenda_en'] == null || $request['legenda_en'] == 'null') {
            $legenda_en = null;

        }

        $legenda_es = $request['legenda_es'];
        if ($request['legenda_es'] == '' || $request['legenda_es'] == null || $request['legenda_es'] == 'null') {
            $legenda_es = null;

        }

        if ($eventoTeste === 0) {
            // upload file //
            $file = $request['imagem'];
            $destination_path = 'eventos/' . $request['ano'] . '/';
            $file_mime = $file->extension();
            $filenameBase = 'img_' . time();
            $file->move($destination_path, $filenameBase . '.' . $file_mime);
            $evento->imagem = $destination_path . $filenameBase . '.' . $file_mime;

            $le_fonte = $request['fonteimagempcp'];
            if ($request['fonteimagempcp'] == '' || $request['fonteimagempcp'] == null || $request['fonteimagempcp'] == 'null') {
                $le_fonte = null;

            }

            $evento->fonteimagempcp = $le_fonte;
        } else {
            $evento->imagem = null;
            $evento->fonteimagempcp = null;
        }

        $dia = null;
        if ($request['dia'] != '') {
            $dia = $request['dia'];
        }

        $mes = null;
        if ($request['mes'] != '') {
            $mes = $request['mes'];
        }

        $evento->dia = $dia;
        $evento->mes = $mes;
        $evento->ano = $request['ano'];
        $evento->nome = $request['nome'];
        $evento->nome_en = $nome_en;
        $evento->nome_es = $nome_es;
        $evento->legenda = $request['legenda'];
        $evento->legenda_en = $legenda_en;
        $evento->legenda_es = $legenda_es;
        $evento->saibamais = $saibamais;
        $evento->saibamais_en = $saibamais_en;
        $evento->saibamais_es = $saibamais_es;
        $evento->save();


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


        Historico::create([
            'evento' => 'Foi criado o evento: ' . $evento->nome . ', data: ' . $dataEventoFormatado . ', imagem: ' . $evento->imagem .', fonte imagem: '. $evento->fonteimagempcp. ', legenda:' . $evento->legenda . ', Saiba Mais: ' . $evento->saibamais,
            'responsavel' => Auth::user()->nome,
            'user_id' => Auth::user()->id
        ]);



        return response()
            ->json($evento, 201);

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

        $evento = Evento::find($request['id']);

        $dataEventoFormatadoAntigo = '';
        $dataEventoFormatadoNovo = '';
        $caminhoImagemAntigo = $evento->imagem;
        $legendaOriginalAntiga = $evento->legenda;
        $saibaMaisOriginalAntiga = $evento->saibamais;
        $fonteImagemOriginalAntiga = $evento->fonteimagempcp;

        $requestDia = $request['dia'];
        if ($requestDia == "null" || $requestDia == '') {
            $requestDia = null;
        } else {
            $requestDia = (int)$requestDia;
        }
        $requestMes = $request['mes'];
        if ($requestMes == "null" || $requestMes == '') {
            $requestMes = null;
        } else {
            $requestMes = (int)$requestMes;
        }
        $requestAno = $request['ano'];
        $requestAno = (int)$requestAno;


        if ($evento->mes !== null && $evento->dia !== null) {
            $dataEventoFormatadoAntigo = $evento->dia . '/' . $evento->mes . '/' . $evento->ano;
        }
        if ($evento->mes !== null && $evento->dia === null) {
            $dataEventoFormatadoAntigo = $evento->mes . '/' . $evento->ano;
        }
        if ($evento->mes === null && $evento->dia === null) {
            $dataEventoFormatadoAntigo = $evento->ano;
        }

        if (($request['mes'] !== '' && $request['mes'] != "null") && ($request['dia'] !== '' && $request['dia'] != "null")) {
            $dataEventoFormatadoNovo = $request['dia'] . '/' . $request['mes'] . '/' . $request['ano'];
        }
        if (($request['mes'] !== '' && $request['mes'] != "null") && ($request['dia'] === '' || $request['dia'] == "null")) {
            $dataEventoFormatadoNovo = $request['mes'] . '/' . $request['ano'];
        }
        if (($request['mes'] === '' || $request['mes'] == "null") && ($request['dia'] === '' || $request['dia'] == "null")) {
            $dataEventoFormatadoNovo = $request['ano'];
        }

        if ($evento->dia !== $requestDia) {
            $evento->dia = $requestDia;
        }
        if ($evento->mes !== $requestMes) {
            $evento->mes = $requestMes;
        }
        if ($evento->ano !== $requestAno) {
            $evento->ano = $requestAno;
        }
        if ($evento->nome !== $request['nome']) {
            $evento->nome = $request['nome'];
        }
        if ($evento->nome_en !== $request['nome_en']) {
            $evento->nome_en = $request['nome_en'];
        }
        if ($evento->nome_es !== $request['nome_es']) {
            $evento->nome_es = $request['nome_es'];
        }
        if ($evento->legenda !== $request['legenda']) {
            $evento->legenda = $request['legenda'];
        }
        if ($evento->legenda_en !== $request['legenda_en']) {
            $evento->legenda_en = $request['legenda_en'];
        }
        if ($evento->legenda_es !== $request['legenda_es']) {
            $evento->legenda_es = $request['legenda_es'];
        }

        $saibamais = $request['saibamais'];
        if ($evento->saibamais !== $request['saibamais']) {

            if ($request['saibamais'] == '' || $request['saibamais'] == null || $request['saibamais'] == 'null') {
                $saibamais = null;

            }
            $evento->saibamais = $saibamais;
        }

        $saibamais_en = $request['saibamais_en'];
        if ($evento->saibamais_en !== $request['saibamais_en']) {

            if ($request['saibamais_en'] == '' || $request['saibamais_en'] == null || $request['saibamais_en'] == 'null') {
                $saibamais_en = null;

            }
            $evento->saibamais_en = $saibamais_en;
        }

        $saibamais_es = $request['saibamais_es'];
        if ($evento->saibamais_es !== $request['saibamais_es']) {

            if ($request['saibamais_es'] == '' || $request['saibamais_es'] == null || $request['saibamais_es'] == 'null') {
                $saibamais_es = null;

            }
            $evento->saibamais_es = $saibamais_es;
        }

        if ($evento->fonteimagempcp !== $request['fonteimagempcp']) {

            $fonteimagempcp = $request['fonteimagempcp'];
            if ($request['fonteimagempcp'] == '' || $request['fonteimagempcp'] == null || $request['fonteimagempcp'] == 'null') {
                $fonteimagempcp = null;

            }

            $evento->saibamais = $saibamais;
            $evento->fonteimagempcp = $fonteimagempcp;
        }

        $eventoTeste = 0;

        if ($request['imagem'] === null) {
            $eventoTeste = 1;
        }

        if ($request['imagem'] === 'null') {
            $eventoTeste = 1;
        }

        if ($request['imagem'] === 'undefined') {
            $eventoTeste = 1;
        }

        if ($request['imagem'] === '') {
            $eventoTeste = 1;
        }


        if ($eventoTeste === 0) {
            // upload file //

            if ($evento->imagem !== null) {
                unlink($evento->imagem);
            }

            $file = $request->file('imagem');
            $destination_path = 'eventos/' . $request['ano'] . '/';
            $file_mime = $file->extension();
            $filenameBase = 'img_' . time();
            $file->move($destination_path, $filenameBase . '.' . $file_mime);
            $evento->imagem = $destination_path . $filenameBase . '.' . $file_mime;
        }
        Historico::create([
            'evento' => 'Foi alterado o evento de: ' . $evento->nome . ' para: ' . $request['nome'] . ', data de: ' . $dataEventoFormatadoAntigo . ', para: ' . $dataEventoFormatadoNovo . ', imagem de: ' . $caminhoImagemAntigo . ', para: ' . $evento->imagem . ', legenda de: ' . $legendaOriginalAntiga . ', para: ' . $evento->legenda . ', Saiba Mais de: ' . $saibaMaisOriginalAntiga . ', para: ' . $evento->saibamais,
            'responsavel' => Auth::user()->nome,
            'user_id' => Auth::user()->id
        ]);
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


            $juca = ['ano' => $arrayDeArrays[0][$j], 'eventos' => $eventos, 'imagem' => $imagem];
            $montagemRetorno[] = $juca;
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

            $juca = ['ano' => $arrayDeArrays[$pag - 1][$j], 'eventos' => Evento::where('ano', $arrayDeArrays[$pag - 1][$j])->get()->load('imagensAdicionais'), 'imagem' => $imagem];
            $montagemRetorno[] = $juca;
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

        if ($request['imagem'] === null) {
            $eventoTeste = 1;
        }

        if ($request['imagem'] === 'undefined') {
            $eventoTeste = 1;
        }

        if ($request['imagem'] === '') {
            $eventoTeste = 1;
        }
        $imagemAdicional = new ImagemEventoAdicional();

        if($request['descricao'] === '' || $request['descricao'] === null || $request['descricao'] === 'null') {
            $descricao = null;
        } else{
            $descricao = $request['descricao'];
        }

        if($request['descricao_en'] === '' || $request['descricao_en'] === null || $request['descricao_en'] === 'null') {
            $descricao_en = null;
        } else{
            $descricao_en = $request['descricao_en'];
        }

        if($request['descricao_es'] === '' || $request['descricao_es'] === null || $request['descricao_es'] === 'null') {
            $descricao_es = null;
        } else{
            $descricao_es = $request['descricao_es'];
        }

        if ($eventoTeste === 0) {
            // upload file //
            $file = $request['imagem'];
            $destination_path = 'eventosimgadicional/' . $request['evento_id'] . '/';
            $file_mime = $file->extension();
            $filenameBase = 'img_' . time();
            $file->move($destination_path, $filenameBase . '.' . $file_mime);
            $imagemAdicional->imagem = $destination_path . $filenameBase . '.' . $file_mime;
            $imagemAdicional->fonte = $request['fonte'];
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
}
