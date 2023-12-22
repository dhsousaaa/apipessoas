<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

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
    return view('welcome');
});

Route::get('/api/status', [ApiController::class, 'index'])->name('api.index');

Route::post('/api', [ApiController::class, 'store'])->name('api.store');
Route::get('/api', function () {
    return response()->json(['error' => 'Método não permitido'], Response::HTTP_METHOD_NOT_ALLOWED);
});
Route::put('/api', function () {
    return response()->json(['error' => 'Método não permitido'], Response::HTTP_METHOD_NOT_ALLOWED);
});
Route::delete('/api', function () {
    return response()->json(['error' => 'Método não permitido'], Response::HTTP_METHOD_NOT_ALLOWED);
});
Route::post('/api/{id}', function () {
    return response()->json(['error' => 'Método não permitido'], Response::HTTP_METHOD_NOT_ALLOWED);
});
Route::get('/api/{id}', [ApiController::class, 'show'])->name('api.show');
Route::put('/api/{id}', [ApiController::class, 'update'])->name('api.update');
Route::delete('/api/{id}', [ApiController::class, 'destroy'])->name('api.destroy');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
