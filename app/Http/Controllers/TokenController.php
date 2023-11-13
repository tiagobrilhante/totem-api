<?php


namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TokenController extends Controller
{

    public function gerarToken(Request $request)
    {

        // valida os dados
        $this->validate($request,[
            'email'=> 'required',
            'password'=>'required'
        ]);

        $user = User::where('email', $request['email'])->first();

        // caso senha errada
        if (is_null($user) || !Hash::check($request->password, $user->password)) {

           return response()->json('Usuário ou senha inválidos', 401);

        }

        // payload
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'email' => $user->email, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            //'exp' => time() + 60 * 60 * 60 * 24 // Expiration time
            'exp' => time() + 43200 // Expiration time (12 horas)

        ];

       $token =  JWT::encode($payload, env('JWT_KEY'));

        return [
            'access_token'=>$token,
            'user'=> $user
        ];

    }

}
