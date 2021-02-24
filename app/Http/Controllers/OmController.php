<?php

namespace App\Http\Controllers;

use App\Models\Om;

class OmController extends BaseController
{
    public function __construct()
    {
        $this->classe = Om::class;

    }


    public function withusers()
    {
        return Om::all()->load('users');

    }

}
