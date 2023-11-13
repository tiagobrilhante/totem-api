<?php

namespace App\Http\Controllers;

use App\Models\Historico;

class HistoricoController extends Controller
{
    public function index()
    {
        return Historico::all();

    }

}
