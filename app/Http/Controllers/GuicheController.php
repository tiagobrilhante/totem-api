<?php

namespace App\Http\Controllers;

use App\Models\Guiche;
use App\Models\Om;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuicheController extends Controller
{

    public function index(Request $request)
    {
        return Guiche::paginate($request->per_page);

    }

    public function store(Request $request)
    {

        return response()
            ->json(Guiche::create($request->all())->load('panel.om'),  201);

    }

    public function show($id)
    {

        $recurso = Guiche::find($id);

        if (is_null($recurso)) {

            return response()->json('', 204);

        }

        return response()->json($recurso);

    }

    public function update(int $id, Request $request)
    {

        $recurso = Guiche::find($id);


        if (is_null($recurso)) {

            return response()->json([
                'erro'=>'Recurso não encontrado'
            ], 404);

        }

        $recurso->fill($request->all());
        $recurso->save();

        return $recurso;

    }

    public function destroy($id)
    {

        $recurso = Guiche::destroy($id);

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
        return Guiche::paginate($request->per_page)->load('panel.om');

    }

    public function myGuiche(Request $request)
    {
        $ipAddress = $request->ip();
        //return Guiche::where('ip', $ipAddress)->first();
        return Guiche::find(1)->load('panel.om');

    }
}
