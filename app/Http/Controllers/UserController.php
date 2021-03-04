<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends BaseController
{
    public function __construct()
    {
        $this->classe = User::class;

    }

    // retorna se o usuário pode ou não usar o cpf ao se cadastrar / editar
    public function cpfExist(Request $request)
    {
        $id_usuario = $request['id'];
        if ($id_usuario === null) {
            $teste = User::where('cpf', $request['cpf'])->count();
        } else {
            $teste = User::where('cpf', $request['cpf'])->where('id', '!=', $id_usuario)->count();
        }
        return $teste;
    }

    // cria um novo usuário
    public function createUser(Request $request)
    {
        return response()
            ->json(User::create([
                'nome' => $request['nome'],
                'nome_guerra' => $request['nome_guerra'],
                'posto_grad' => $request['posto_grad'],
                'cpf' => $request['cpf'],
                'password' => Hash::make($this->limpaCPF_CNPJ($request['cpf'])),
                'om_id' => $request['om'],
                'tipo' => $request['tipo'],
                'reset' => 1
    ]), 201);

    }

    //limpa os . e - de um cpf para resetar senha
    function limpaCPF_CNPJ($valor){
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("/", "", $valor);
        return $valor;
    }

    // altera a senha de um usuário
    public function alteraSenhaResetada(Request $request)
    {
        $user = User::find($request['id']);
        $user->password = Hash::make($request['password']);
        $user->reset = 0;
        $user->save();
    }

    // reseta a senha de um usuário
    public function resetaSenha(Request $request)
    {
        $user = User::find($request['id']);
        $user->password = Hash::make($this->limpaCPF_CNPJ($request['cpf']));
        $user->reset = 1;
        $user->save();

        return $user;
    }

    //devolve o usuário logado
    public function usuarioLogado()
    {
        return Auth::user();
    }

}
