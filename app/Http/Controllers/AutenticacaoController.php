<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistraUsuarioRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class AutenticacaoController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth:api", ["except" => ["login", "registrar"]]);
    }

    public function registrar(RegistraUsuarioRequest $request)
    {
        $usuarioRequestData = $request->all();
        $usuarioRequestData["password"] = Hash::make($usuarioRequestData["password"]);

        $usuario = User::create($usuarioRequestData);

        return response()->json(["message" => "Usuário cadastrado com sucesso", "usuario" => $usuario], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $token = auth()->attempt($request->only(["email", "password"]));

        if (!$token) {
            return response()->json(["message" => "Usuário ou senha inválidos"], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respostaToken($token);
    }

    public function refresh()
    {
        return $this->respostaToken(auth()->refresh());
    }

    public function me()
    {
        return response()->json(auth()->user(), Response::HTTP_OK);
    }

    protected function respostaToken(string $token)
    {
        return response()->json([
            "token" => $token,
            "tipo" => "Bearer",
        ], Response::HTTP_OK);
    }
}
