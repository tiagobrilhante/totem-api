<?php

namespace App\Http\Controllers;


use App\Models\UserType;


class UserTypeController extends BaseController
{
    public function __construct()
    {
        $this->classe = UserType::class;

    }

    public function withusers()
    {
        return UserType::all()->load('users');

    }

}
