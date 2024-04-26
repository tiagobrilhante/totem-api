<?php

namespace App\Http\Controllers;

use App\Models\OS;
use App\Models\TotemConfig;
use Illuminate\Http\Request;

class TotemConfigController extends Controller
{
    public function index()
    {
        $config = TotemConfig::first();

        $filteredConfig = [
            'nome_totem' => $config->nome_totem,
            'nome_totem_en' => $config->nome_totem_en,
            'nome_totem_es' => $config->nome_totem_es,
            'permite_multi_lang' => $config->permite_multi_lang,
            'en_habilitado' => $config->en_habilitado,
            'es_habilitado' => $config->es_habilitado,
            'altura_detail' => $config->altura_detail,
            'largura_detail' => $config->largura_detail,
            'altura_index' => $config->altura_index,
            'tipo_totem' => $config->tipo_totem,
            'largura_index' => $config->largura_index,
            'bg_img' => $config->bg_img,
            'bg_color' => $config->bg_color,
            'quiz' =>$config->quiz
        ];

        return $filteredConfig;

    }

    public function plus()
    {
        return TotemConfig::first();
    }

    public function store(Request $request)
    {

        $totemConfig = TotemConfig::first();
        $totemConfig->nome_totem = $request['nome_totem'];

        $permite_multi_lang = $request['permite_multi_lang'];
        if (!$request['en_habilitado'] && !$request['es_habilitado']) {
            $permite_multi_lang = false;
        }


        $totemConfig->en_habilitado = $request['en_habilitado'];
        $totemConfig->es_habilitado = $request['es_habilitado'];

        if (!$permite_multi_lang) {
            $totemConfig->en_habilitado = false;
            $totemConfig->es_habilitado = false;
        }

        $totemConfig->permite_multi_lang = $permite_multi_lang;
        $totemConfig->nome_totem_en = $request['nome_totem_en'];
        $totemConfig->nome_totem_es = $request['nome_totem_es'];
        $totemConfig->access_code = $request['access_code'];
        $totemConfig->altura_detail = $request['altura_detail'];
        $totemConfig->largura_detail = $request['largura_detail'];
        $totemConfig->altura_index = $request['altura_index'];
        $totemConfig->largura_index = $request['largura_index'];
        $totemConfig->tipo_totem = $request['tipo_totem'];
        $totemConfig->bg_img = $request['bg_img'];
        $totemConfig->bg_color = $request['bg_color'];
        $totemConfig->quiz = $request['quiz'];
        $totemConfig->save();

        return $totemConfig;


    }

    public function acesso( Request $request)
    {
        $totemConfig = TotemConfig::first();

        return $request['cod_acesso'] == $totemConfig->access_code;


    }

    public function removeBg()
    {

        // dar unlink na imagem
        $totemConfig = TotemConfig::first();
        unlink($totemConfig->bg_img);
        $totemConfig->bg_img = null;
        $totemConfig->save();
        return response()->json([
            'mensagem' => 'BG removido'
        ], 200);
    }

    public function updateBg(Request $request)
    {

        // dar unlink na imagem
        $totemConfig = TotemConfig::first();

        // upload file //

        if ($totemConfig->bg_img !== null) {
            unlink($totemConfig->bg_img);
        }

        if ($request['imagem'] !== 'undefined') {


            $file = $request['imagem'];
            $destination_path = 'bg/';
            $file_mime = $file->extension();
            $filenameBase = 'bg_' . time();


            $totemConfig->bg_img = $destination_path . $filenameBase . '.' . $file_mime;
            $totemConfig->save();
            $file->move($destination_path, $filenameBase . '.' . $file_mime);
        }
        return response()->json([
            'mensagem' => 'BG alterado'
        ], 200);
    }

}
