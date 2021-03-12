<?php

namespace App\Http\Controllers;

use App\Models\ChamadaPrioridadeParametro;

class ChamadaPrioridadeParametrosController extends BaseController
{
    public function __construct()
    {
        $this->classe = ChamadaPrioridadeParametro::class;

    }
}
