<?php

use App\Http\Controllers\AutenticacaoController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\IngressoController;
use App\Http\Controllers\PedidoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("/eventos")->group(function () {
    Route::get("/", [EventosController::class, "index"]);
    Route::get("/{id}", [EventosController::class, "show"]);
    Route::post("/", [EventosController::class, "store"])->middleware(["auth:api", "permissao:PROMOTOR"]);
    Route::put("/{id}", [EventosController::class, "update"])->middleware(["auth:api", "permissao:PROMOTOR"]);
    Route::delete("/{id}", [EventosController::class, "destroy"])->middleware(["auth:api", "permissao:PROMOTOR"]);
});

Route::prefix("/pedidos")->middleware(["auth:api"])->group(function () {
    Route::get("/", [PedidoController::class, "index"]);
    Route::post("/", [PedidoController::class, "store"]);
    Route::post("/{id}/checkout", [PedidoController::class, "checkout"]);
});

Route::post('/pedidos/webhook', [PedidoController::class, "webhook"]);

Route::prefix("/ingressos")->group(function () {
    Route::get("/", [IngressoController::class, "index"]);
    Route::get("/{id}", [IngressoController::class, "show"]);
    Route::post("/", [IngressoController::class, "store"])->middleware(["auth:api", "permissao:PROMOTOR"]);
    Route::put("/{id}", [IngressoController::class, "update"])->middleware(["auth:api", "permissao:PROMOTOR"]);
    Route::delete("/{id}", [IngressoController::class, "destroy"])->middleware(["auth:api", "permissao:PROMOTOR"]);
});

Route::prefix("/credenciais")->group(function () {
    Route::post("/registrar", [AutenticacaoController::class, "registrar"]);
    Route::post("/login", [AutenticacaoController::class, "login"]);
    Route::get("/me", [AutenticacaoController::class, "me"]);
    Route::put("/refresh", [AutenticacaoController::class, "refresh"]);
});
