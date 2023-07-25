<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AutenticacaoTest extends TestCase
{
    use RefreshDatabase;

    public const BASE_URL = "/api/credenciais";

    public function test_cadastro_usuarios()
    {
        $response = $this->post(self::BASE_URL . "/registrar", [
            "name" => "Usuário Dummy",
            "email" => "dummy@email.com",
            "password" => "12345678",
            "password_confirmation" => "12345678"
        ], [
            "Accept" => "application/json"
        ]);

        $response->assertCreated();
        $response->assertJsonPath("message", "Usuário cadastrado com sucesso");
    }

    public function test_login_usuario()
    {
        $this->cadastraUsuario();

        $response = $this->post(self::BASE_URL . "/login", [
            "email" => "dummyTest@email.com",
            "password" => "12345678",
        ], [
            "Accept" => "application/json"
        ]);

        $response->assertOk();
        $response->assertJsonPath("tipo", "Bearer");
    }

    public function test_exibe_usuario_autenticado()
    {
        $this->cadastraUsuario();
        $token = auth()->attempt([
            'email' => "dummyTest@email.com",
            "password" => "12345678"
        ]);

        $response = $this->get(self::BASE_URL . "/me", [
            "Accept" => "application/json",
            "Authorization" => "Bearer " . $token,
        ]);

        $response->assertOk();
        $response->assertJsonPath("email", "dummyTest@email.com");
    }

    public function test_atualiza_token()
    {
        $this->cadastraUsuario();
        $token = auth()->attempt([
            'email' => "dummyTest@email.com",
            "password" => "12345678"
        ]);

        $response = $this->put(self::BASE_URL . "/refresh", [
            "Accept" => "application/json",
            "Authorization" => "Bearer " . $token,
        ]);

        $response->assertOk();
        $this->assertTrue($token != $response->json("token"), "O token não pode ser igual ao enviado");
    }

    private function cadastraUsuario()
    {
        $user = User::where("email", "dummyTest@email.com")->exists();

        if ($user) {
            return;
        }

        return User::create([
            "name" => "Usuário Dummy",
            "email" => "dummyTest@email.com",
            "password" => Hash::make("12345678"),
        ]);
    }
}
