<?php


namespace App\Http\Controllers;


use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TokenController extends Controller
{

    public function gerarToken(Request $request)
    {

        $this->validate($request,[
            'cpf'=> 'required',
            'password'=>'required'

        ]);

        $user = User::where('cpf', $request['cpf'])->first();

        if (is_null($user) || !Hash::check($request->password, $user->password)) {

            return response()->json('Usuário ou senha inválidos', 401);

        }

       $token =  JWT::encode(['cpf' => $user->cpf], env('JWT_KEY'));

        return [
            'access_token'=>$token,
            'user'=> $user
        ];

    }

}
