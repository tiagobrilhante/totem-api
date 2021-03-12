<?php

namespace App\Http\Controllers;

use App\Models\Panel;

class PanelController extends BaseController
{
    public function __construct()
    {
        $this->classe = Panel::class;

    }
}
