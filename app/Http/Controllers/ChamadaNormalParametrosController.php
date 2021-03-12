<?php

namespace App\Http\Controllers;

use App\Models\ChamadaNormalParametro;

class ChamadaNormalParametrosController extends BaseController
{
    public function __construct()
    {
        $this->classe = ChamadaNormalParametro::class;

    }
}
