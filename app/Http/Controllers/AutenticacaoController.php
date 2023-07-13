<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistraUsuarioRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AutenticacaoController extends Controller
{
    public function registrar(RegistraUsuarioRequest $request)
    {
        $usuarioRequestData = $request->all();
        $usuarioRequestData["password"] = Hash::make($usuarioRequestData["password"]);

        $usuario = User::create($usuarioRequestData);

        return response()->json(["message" => "Usuário cadastrado com sucesso", "usuario" => $usuario], Response::HTTP_CREATED);
    }
}
