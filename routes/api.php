<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthorizedAccessTokenController;
use Symfony\Component\HttpFoundation\Response;

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

Route::post('/register', [ApiController::class, 'register'])->name('api.register');
Route::post('/token', [ApiController::class, 'token'])->name('api.token');
Route::get('/status', [ApiController::class, 'index'])->name('api.index');

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('/', [ApiController::class, 'store'])->name('api.store');
    Route::get('/', function () {
        return response()->json(['error' => 'Método não permitido'], Response::HTTP_METHOD_NOT_ALLOWED);
    });
    Route::put('/', function () {
        return response()->json(['error' => 'Método não permitido'], Response::HTTP_METHOD_NOT_ALLOWED);
    });
    Route::delete('/', function () {
        return response()->json(['error' => 'Método não permitido'], Response::HTTP_METHOD_NOT_ALLOWED);
    });
    Route::post('/{id}', function () {
        return response()->json(['error' => 'Método não permitido'], Response::HTTP_METHOD_NOT_ALLOWED);
    });
    Route::get('/{id}', [ApiController::class, 'show'])->name('api.show');
    Route::put('/{id}', [ApiController::class, 'update'])->name('api.update');
    Route::delete('/{id}', [ApiController::class, 'destroy'])->name('api.destroy');    
});