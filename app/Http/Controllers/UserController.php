<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    //lista os usuários de acordo com o tipo e OM
    public function index(Request $request)
    {

        if (Auth::user()->tipo === 'Administrador Geral') {

            return User::paginate($request->per_page);

        } elseif (Auth::user()->tipo === 'Administrador') {

            return User::where('om_id', Auth::user()->om_id)->where('tipo','!=', 'Administrador Geral')->paginate($request->per_page);

        } else {

            return response()
                ->json('', 403);
        }

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

    //limpa os . e - de um cpf para resetar senha
    function limpaCPF_CNPJ($valor)
    {
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("/", "", $valor);
        return $valor;
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

    // reseta a senha de um usuário
    public function resetaSenha(Request $request)
    {
        $user = User::find($request['id']);
        $user->password = Hash::make($this->limpaCPF_CNPJ($request['cpf']));
        $user->reset = 1;
        $user->save();

        return $user;
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

    // altera um usuário
    public function update(int $id, Request $request)
    {

        $usuario = User::find($id);

        if (is_null($usuario)) {

            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);

        }

        $usuario->fill($request->all());
        $usuario->save();

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

    // devolve os tipos de usuários disponíveis para um tipo de usuário
    public function retornaTipo(Request $request)
    {

        $array_tipos = [];

        if (Auth::user()->tipo === 'Administrador Geral') {
            array_push($array_tipos, 'Administrador','Administrador Geral','Chamador');
        } elseif (Auth::user()->tipo === 'Administrador'){
            array_push($array_tipos, 'Administrador','Chamador');
        }

        return $array_tipos;
    }


}
