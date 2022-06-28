<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CampanhaController;
use App\Http\Controllers\DescontoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {

    // grupo
    Route::get('grupo', [GrupoController::class, 'index']);
    Route::post('grupo', [GrupoController::class, 'create']);
    Route::get('grupo/{id}', [GrupoController::class, 'show']);
    Route::put('grupo/{id}', [GrupoController::class, 'update']);
    Route::delete('grupo/{id}', [GrupoController::class, 'delete']);
    // fim do grupo

    // cidade
    Route::get('cidade', [CidadeController::class, 'index']);
    Route::post('cidade', [CidadeController::class, 'create']);
    Route::get('cidade/{cidade}', [CidadeController::class, 'show']);
    Route::put('cidade/{id}', [CidadeController::class, 'update']);
    Route::delete('cidade/{id}', [CidadeController::class, 'delete']);
    // fim da cidade

    // campanha
    Route::get('campanha', [CampanhaController::class, 'index']);
    Route::post('campanha', [CampanhaController::class, 'create']);
    Route::get('campanha/{campanha}', [CampanhaController::class, 'show']);
    Route::put('campanha/{id}', [CampanhaController::class, 'update']);
    Route::delete('campanha/{id}', [CampanhaController::class, 'delete']);
    // fim da campanha

     // produto
     Route::get('produto', [ProdutoController::class, 'index']);
     Route::post('produto', [ProdutoController::class, 'create']);
     Route::get('produto/{produto}', [ProdutoController::class, 'show']);
     Route::put('produto/{id}', [ProdutoController::class, 'update']);
     Route::delete('produto/{id}', [ProdutoController::class, 'delete']);
     // fim de produto

      // cupom de desconto
      Route::get('desconto', [DescontoController::class, 'index']);
      Route::post('desconto', [DescontoController::class, 'create']);
      Route::get('desconto/{cupom}', [DescontoController::class, 'show']);
      Route::put('desconto/{id}', [DescontoController::class, 'update']);
      Route::delete('desconto/{id}', [DescontoController::class, 'delete']);
      // fim de cupom


});
