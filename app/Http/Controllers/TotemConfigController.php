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
            'altura_detail' => $config->altura_detail,
            'largura_detail' => $config->largura_detail,
            'altura_index' => $config->altura_index,
            'tipo_totem' => $config->tipo_totem,
            'largura_index' => $config->largura_index,
            'bg_img' => $config->bg_img,
            'bg_color' => $config->bg_color
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
        $totemConfig->access_code = $request['access_code'];
        $totemConfig->altura_detail = $request['altura_detail'];
        $totemConfig->largura_detail = $request['largura_detail'];
        $totemConfig->altura_index = $request['altura_index'];
        $totemConfig->largura_index = $request['largura_index'];
        $totemConfig->tipo_totem = $request['tipo_totem'];
        $totemConfig->bg_img = $request['bg_img'];
        $totemConfig->bg_color = $request['bg_color'];
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
