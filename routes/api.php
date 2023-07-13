<?php

use App\Http\Controllers\AutenticacaoController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\IngressoController;
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
    Route::post("/", [EventosController::class, "store"]);
    Route::get("/", [EventosController::class, "index"]);
    Route::get("/{id}", [EventosController::class, "show"]);
    Route::put("/{id}", [EventosController::class, "update"]);
    Route::delete("/{id}", [EventosController::class, "destroy"]);
});


Route::prefix("/ingressos")->group(function () {
    Route::get("/", [IngressoController::class, "index"]);
    Route::get("/{id}", [IngressoController::class, "show"]);
    Route::post("/", [IngressoController::class, "store"]);
    Route::put("/{id}", [IngressoController::class, "update"]);
    Route::delete("/{id}", [IngressoController::class, "destroy"]);
});

Route::prefix("/credenciais")->group(function () {
    Route::post("/registrar", [AutenticacaoController::class, "registrar"]);
});
