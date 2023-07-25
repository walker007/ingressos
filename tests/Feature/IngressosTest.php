<?php

namespace Tests\Feature;

use App\Models\Evento;
use App\Models\Ingresso;
use App\Models\Permissao;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class IngressosTest extends TestCase
{
    use RefreshDatabase;

    public const BASE_URL = "/api/ingressos";

    public function test_se_retorna_uma_lista_de_ingressos()
    {
        $this->cadastraIngresso();

        $response = $this->get(self::BASE_URL, [
            "Accept" => "application/json"
        ]);

        $response->assertOk();
    }

    public function test_se_retorna_401_quando_nao_autenticado()
    {
        $this->cadastraIngresso();

        $response = $this->post(self::BASE_URL, [
            "lote" => "Lote teste",
            "inicio" => "2023-07-17",
            "fim" => "2023-07-25",
            "quantidade_disponivel" => 250,
            "preco" => 130.89,
            "evento_id" => 1,
        ], [
            "Accept" => "application/json"
        ]);

        $response->assertUnauthorized();
    }

    public function test_se_retorna_403_quando_nao_possui_presmissao()
    {
        $this->cadastraIngresso();

        $token = auth()->attempt([
            "email" => "dummyTest@email.com",
            "password" => "12345678"
        ]);

        $response = $this->post(self::BASE_URL, [
            "lote" => "Lote teste",
            "inicio" => "2023-07-17",
            "fim" => "2023-07-25",
            "quantidade_disponivel" => 250,
            "preco" => 130.89,
            "evento_id" => 1,
        ], [
            "Accept" => "application/json",
            "Authorization" => "Bearer " . $token
        ]);

        $response->assertForbidden();
    }

    public function test_cadastra_ingresso_corretamente()
    {
        $this->cadastraIngresso();
        $user = User::where("email", "dummyTest@email.com")->first();
        $role = Permissao::create([
            'nome' => "PROMOTOR"
        ]);
        $user->permissoes()->sync([$role->id]);
        $evento = Evento::all()->first();

        $token = auth()->attempt([
            "email" => "dummyTest@email.com",
            "password" => "12345678"
        ]);

        $response = $this->post(self::BASE_URL, [
            "lote" => "Lote teste",
            "inicio" => "2023-07-17",
            "fim" => "2023-07-25",
            "quantidade_disponivel" => 250,
            "preco" => 130.89,
            "evento_id" => $evento->id,
        ], [
            "Accept" => "application/json",
            "Authorization" => "Bearer " . $token
        ]);

        $response->assertCreated();
    }

    private function cadastraIngresso()
    {
        $ingresso = Ingresso::find(1);

        if ($ingresso) {
            return;
        }

        $user = User::create([
            "name" => "Usuário Dummy",
            "email" => "dummyTest@email.com",
            "password" => Hash::make("12345678"),
        ]);

        $evento = Evento::create([
            "nome" => "Evento Teste",
            "descricao" => "teste de ingressos",
            "local" => "Pasta de testes",
            "data_evento" => "2023-01-01",
            "user_id" => $user->id,
            "slug" => "evento-teste"
        ]);

        $evento->ingressos()->create([
            "lote" => "Lote teste",
            "inicio" => "2023-07-17",
            "fim" => "2023-07-25",
            "quantidade_disponivel" => 250,
            "preco" => 130.89
        ]);
    }
}
