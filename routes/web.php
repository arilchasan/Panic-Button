<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Middleware\AdminAuthMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Example Routes
Route::get('/', [GeneralController::class, 'index'])->middleware([AdminAuthMiddleware::class]);
Route::match(['get', 'post'], '/dashboard', function(){
    return view('dashboard');
});
Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');

Route::prefix('/dashboard')->middleware('auth:admin')->group(function () {
    Route::get('/all', [GeneralController::class, 'all']);
    Route::prefix('/permission')->group(function() {
        Route::get('/all', [PermissionController::class, 'index']);
        Route::get('/create', [PermissionController::class, 'create']);
        Route::post('/add-permissions', [PermissionController::class, 'store']);
        Route::get('/edit/{id}', [PermissionController::class, 'edit']);
        Route::post('/edit-permissions/{id}', [PermissionController::class, 'update']);
        Route::get('/delete-permissions/{id}', [PermissionController::class, 'destroy']);
    });
    Route::prefix('/role')->group(function() {
        Route::get('/all', [RoleController::class, 'index']);
        Route::get('/create', [RoleController::class, 'create']);
        Route::post('/add-role', [RoleController::class, 'store']);
        Route::get('/edit/{name}', [RoleController::class, 'edit']);
        Route::post('/edit-role/{name}', [RoleController::class, 'update']);
        Route::get('/delete-role/{id}', [RoleController::class, 'destroy']);
    });
    Route::prefix('/admin')->group(function() {
        Route::get('/all', [AdminController::class, 'index']);
        Route::get('/create', [AdminController::class, 'create']);
        Route::post('/add-admin', [AdminController::class, 'store']);
        Route::get('/edit/{id}', [AdminController::class, 'edit']);
        Route::post('/edit-admin/{id}', [AdminController::class, 'update']);
        Route::get('/delete/{id}', [AdminController::class, 'destroy']);
    });
    Route::prefix('/subscriptions')->group(function(){
        Route::get('/index', [SubscriptionsController::class, 'index']);
        Route::get('/detail/{name}', [SubscriptionsController::class, 'show']);
        Route::get('/create', [SubscriptionsController::class, 'create']);
        Route::post('/add-subscription', [SubscriptionsController::class, 'store']);
        Route::get('/edit-subscription/{name}', [SubscriptionsController::class, 'edit']);
        Route::post('/edit-subscription/{name}', [SubscriptionsController::class, 'update']);
        Route::get('/delete-subscription/{id}', [SubscriptionsController::class, 'destroy']);
    });
    Route::prefix('/information')->group(function() {
        Route::get('/all', [InformationController::class, 'index']);
        Route::get('/detail/{name}', [InformationController::class, 'show']);
        Route::get('/create', [InformationController::class, 'create']);
        Route::post('/add-information', [InformationController::class, 'store']);
        Route::get('/edit-information/{name}', [InformationController::class, 'edit']);
        Route::post('/edit-information/{name}', [InformationController::class, 'update']);
        Route::get('/delete-information/{id}', [InformationController::class, 'destroy']);
    });
    Route::prefix('/user')->group(function (){
        Route::get('/all', [UserController::class, 'index'])->name('user.all');
        Route::get('/create', [UserController::class, 'create']);
        Route::get('/detail/{name}', [UserController::class, 'show']);
        Route::post('/add-user', [UserController::class, 'store']);
        Route::get('/edit-user/{name}', [UserController::class, 'edit']);
        Route::post('/edit-user/{id}', [UserController::class, 'update']);
        Route::get('/delete-user/{id}', [UserController::class, 'destroy']);
        Route::get('/{name}/history', [UserController::class, 'history']);
        Route::get('/{name}/history/detail/{id}', [UserController::class, 'detailHistory']);
        Route::get('/daftar-toko/{name}', [UserController::class, 'daftarToko']);
        Route::get('/daftar-toko/{name}/detail/{id}', [UserController::class, 'detailToko']);
    });
    Route::prefix('/store')->group(function(){
        Route::get('/all', [TokoController::class, 'index']);
        Route::get('/detail/{name}', [TokoController::class, 'show']);
        Route::get('/create', [TokoController::class, 'create']);
        Route::post('/add-store', [TokoController::class, 'store']);
        Route::get('/edit-store/{name}', [TokoController::class, 'edit']);
        Route::post('/edit-store/{name}', [TokoController::class, 'update']);
        Route::get('/delete-store/{id}', [TokoController::class, 'destroy']);
        Route::post('/getRegencies' , [TokoController::class, 'getRegencies'])->name('getRegencies');
        Route::post('/getDistrict' , [TokoController::class, 'getDistrict'])->name('getDistrict');
        Route::post('/getVillage' , [TokoController::class, 'getVillage'])->name('getVillage');
    });
    Route::prefix('/contact')->group(function(){
        Route::get('/all', [ContactController::class, 'index']);
        Route::get('/detail/{name}', [ContactController::class, 'show']);
        Route::get('/create', [ContactController::class, 'create']);
        Route::post('/add-contact', [ContactController::class, 'store']);
        Route::get('/edit-contact/{name}', [ContactController::class, 'edit']);
        Route::post('/edit-contact/{name}', [ContactController::class, 'update']);
        Route::get('/delete-contact/{id}', [ContactController::class, 'destroy']);
    });
});

Route::prefix('/auth' )->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login-load', [AuthController::class, 'postLogin']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
