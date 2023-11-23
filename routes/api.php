<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InformationController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('api.key')->group(function () {
    Route::prefix('/auth' )->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'loginUser'])->name('login');
        Route::post('/logout', [AuthController::class, 'logoutUser'])->name('logout')->middleware('auth:sanctum');
    });
    Route::get('/profile/', [UserController::class, 'profile'])->name('profile')->middleware('auth:sanctum');
    Route::post('/update-profile/', [UserController::class, 'updateProfile'])->name('update-profile')->middleware('auth:sanctum');
    Route::get('/user-all/', [UserController::class, 'alluser'])->name('user');
    Route::prefix('/store')->group(function () {
        Route::get('/all', [TokoController::class, 'index'])->name('allstore');
        Route::get('/home', [TokoController::class, 'home'])->name('homestore')->middleware('auth:sanctum');
        Route::get('/{name}', [TokoController::class, 'show'])->name('show');
        Route::post('/create', [TokoController::class, 'addStore'])->name('addstore')->middleware('auth:sanctum');
        Route::post('/edit/{name}', [TokoController::class, 'updateStore'])->name('updatestore')->middleware('auth:sanctum');
        Route::get('/delete/{name}', [TokoController::class, 'destroy'])->name('deletestore');
    });
    Route::prefix('/information')->group(function() {
        Route::get('/all', [InformationController::class, 'index']);
        Route::get('/detail/{name}', [InformationController::class, 'show']);
    });
    Route::prefix('/contact')->group(function(){
        Route::get('/all', [ContactController::class, 'index']);
        Route::post('/add-contact', [ContactController::class, 'store']);
        Route::post('/edit-contact/{name}', [ContactController::class, 'update']);
        Route::get('/delete-contact/{id}', [ContactController::class, 'destroy']);
    });
});
