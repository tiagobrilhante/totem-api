<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use App\Models\Panel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensagemController extends BaseController
{
    public function index(Request $request)
    {

        return Mensagem::where('om_id',Auth::user()->om_id)->paginate($request->per_page);

    }

    public function mensagemPainel(Request $request)
    {

        $painel_ip = $request->ip();
        $painel = Panel::where('ip', $painel_ip)->first();


        return Mensagem::where('om_id',$painel->om_id)->paginate($request->per_page);

    }

    public function store(Request $request)
    {

        $mensagem = Mensagem::create([
            'mensagem'=>$request['mensagem'],
            'responsavel'=>Auth::user()->posto_grad . ' ' . Auth::user()->nome_guerra,
            'om_id'=>Auth::user()->om_id
        ]);

        return response()
            ->json($mensagem,  201);

    }

    public function show($id)
    {

        $recurso = Mensagem::find($id);

        if (is_null($recurso)) {

            return response()->json('', 204);

        }

        return response()->json($recurso);

    }

    public function update(int $id, Request $request)
    {

        $recurso = Mensagem::find($id);

        if (is_null($recurso)) {

            return response()->json([
                'erro'=>'Recurso não encontrado'
            ], 404);

        }

        $request['responsavel'] = Auth::user()->posto_grad . ' ' . Auth::user()->nome_guerra;

        $recurso->fill($request->all());
        $recurso->save();

        return $recurso;

    }

    public function destroy($id)
    {

        $recurso = Mensagem::destroy($id);

        if ($recurso === 0) {

            return response()->json([
                'erro'=>'Recurso não encontrado'
            ], 404);

        } else {
            return response()->json('', 204);
        }

    }

}
