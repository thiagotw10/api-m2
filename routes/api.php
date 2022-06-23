<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\CidadeController;

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

});
