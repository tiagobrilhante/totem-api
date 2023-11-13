<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPerfilBasico;
use App\Models\UserPerfilS;
use App\Models\UserPerfilSBD;
use App\Models\UserPerfilSBL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    //lista os usuários
    public function index()
    {
        return User::all();
    }

    // retorna se o usuário pode ou não usar o cpf ao se cadastrar / editar
    public function emailExist(Request $request)
    {
        $id_usuario = $request['id'];
        if ($id_usuario === null) {
            $teste = User::where('email', $request['email'])->count();
        } else {
            $teste = User::where('email', $request['email'])->where('id', '!=', $id_usuario)->count();
        }
        return $teste;
    }

    // altera a senha de um usuário resetado
    public function alteraSenhaResetada(Request $request)
    {
        $user = User::find($request['id']);
        $user->password = Hash::make($request['password']);
        $user->reset = 0;
        $user->save();
    }

    // altera a senha de um usuário normal
    public function alteraSenhaNormal(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request['password']);
        $user->save();
    }


    // cria um novo usuário
    public function createUser(Request $request)
    {

        return User::create([
            'email' => $request['email'],
            'nome' => $request['nome'],
            'password' => Hash::make($request['password'])
        ]);

    }

    // altera um usuário
    public function update(int $id, Request $request)
    {

        $usuario = User::find($id);

        if (is_null($usuario)) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);

        }

        // implementar testes de null nos request do back
        if ($request['editSenha']) {
            $usuario->nome = $request['nome'];
            $usuario->email = $request['email'];
            $usuario->password = Hash::make($request['password']);
            $usuario->save();

        } else {
            $usuario->nome = $request['nome'];
            $usuario->email = $request['email'];
            $usuario->save();
        }

        return $usuario;

    }

    // remove um usuário
    public function destroy($id)
    {

        $usuario = User::destroy($id);

        if ($usuario === 0) {

            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);

        } else {
            return response()->json('', 204);
        }

    }

}
