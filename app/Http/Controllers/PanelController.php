<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanelController extends BaseController
{



    public function index(Request $request)
    {
        return Panel::paginate($request->per_page);

    }

    public function store(Request $request)
    {

        return response()
            ->json(Panel::create($request->all())->load('guiche','om'),  201);

    }

    public function show($id)
    {

        $recurso = Panel::find($id);

        if (is_null($recurso)) {

            return response()->json('', 204);

        }

        return response()->json($recurso);

    }

    public function update(int $id, Request $request)
    {

        $recurso = Panel::find($id);


        if (is_null($recurso)) {

            return response()->json([
                'erro'=>'Recurso não encontrado'
            ], 404);

        }

        $recurso->fill($request->all());
        $recurso->save();

        return $recurso->load('guiche','om');

    }

    public function destroy($id)
    {

        $recurso = Panel::destroy($id);

        if ($recurso === 0) {

            return response()->json([
                'erro'=>'Recurso não encontrado'
            ], 404);

        } else {
            return response()->json('', 204);
        }

    }









    public function indexLoad(Request $request)
    {
        return Panel::paginate($request->per_page)->load('guiche','om');

    }

    public function showPanel(Request $request)
    {
        $user = Auth::user();
        if ($user->tipo === 'Administrador Geral') {
            return response()
                ->json(Panel::all()->load('guiche','om'), 200);
        } elseif ($user->tipo === 'Administrador') {
            return response()
                ->json(Panel::where('om_id', Auth::user()->om->id)->paginate($request->per_page)->load('guiche','om'), 200);
        } else {
            return response()
                ->json('', 403);
        }


    }
}
