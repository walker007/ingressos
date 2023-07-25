<?php

use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return response(null, 403);
});


Route::get("pagamento/success", [PedidoController::class, "success"])->name("pagamento.success");
Route::get("pagamento/error", [PedidoController::class, "error"])->name("pagamento.error");
