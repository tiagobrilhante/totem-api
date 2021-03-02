<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends BaseController
{
    public function __construct()
    {
        $this->classe = User::class;

    }
    public function cpfExist(Request $request)
    {

        $id_usuario = $request['id'];

        if ($id_usuario === '') {
            $teste = User::where('cpf',$request['cpf'])->count();

        }else {
            $teste = User::where('cpf',$request['cpf'])->where('id','!=',$id_usuario)->count();

        }

        if ($teste > 0){
            return false;
        } else {
            return true;
        }

    }

}
