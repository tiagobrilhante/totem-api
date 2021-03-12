<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IpController extends Controller
{

    public function myIp(Request $request)
    {
        $ipAddress = $request->ip();

        return $ipAddress;
    }

}
