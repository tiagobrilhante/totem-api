<?php

namespace App\Http\Controllers;

use App\Models\Guiche;
use App\Models\Om;
use Illuminate\Support\Facades\Auth;

class GuicheController extends BaseController
{
    public function __construct()
    {
        $this->classe = Guiche::class;

    }
}
