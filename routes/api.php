<?php

use App\Http\Controllers\V1\AlertController;
use App\Http\Controllers\V1\AlertUserController;
use App\Http\Controllers\V1\AssociationController;
use App\Http\Controllers\V1\MemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\RegisterController;
use App\Http\Controllers\V1\TitheController;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\Off;
use App\Http\Controllers\V1\OfferController;
use App\Http\Controllers\V1\WereHouseController;
use App\Http\Controllers\V1\WereHouseOutController;
use App\Http\Middleware\Members;
use App\Models\Association;

Route::prefix('v1')->group(function () {

    Route::get('/test', function(){

        return ['test' => 'test'];

    });

    Route::prefix('auth')->group(function () {
        Route::post('/register', [RegisterController::class, 'register']);
        Route::post('/login', [RegisterController::class, 'login']);
        Route::get('/logout', [RegisterController::class, 'logout'])->middleware(['auth:sanctum']);
    });

    // Rotas dos membros protegidas pelo middleware 'admin'

    Route::middleware(['auth:sanctum','admin'])->prefix('members')->group(function(){
        Route::get('/all', [MemberController::class,  'index']);
        Route::get('/show/{id}', [MemberController::class, 'show']);
        Route::post('/store', [MemberController::class, 'store']);
        Route::put('/update',[MemberController::class, 'update']);
        Route::delete('/destroy/{id}', [MemberController::class, 'destroy']);
    });

    Route::middleware(['auth:sanctum','admin'])->prefix('tithe')->group(function(){
        Route::get('/all', [TitheController::class,  'index']);
        Route::get('/show/{id}', [TitheController::class, 'show']);
        Route::post('/store', [TitheController::class, 'store']);
        Route::put('/update',[TitheController::class, 'update']);
        Route::delete('/destroy/{id}', [TitheController::class, 'destroy']);
    });

    Route::middleware(['auth:sanctum','admin'])->prefix('offer')->group(function(){
        Route::get('/all', [OfferController::class,  'index']);
        Route::get('/show/{id}', [OfferController::class, 'show']);
        Route::post('/store', [OfferController::class, 'store']);
        Route::put('/update',[OfferController::class, 'update']);
        Route::delete('/destroy/{id}', [OfferController::class, 'destroy']);
    });

    Route::middleware(['auth:sanctum','admin'])->prefix('were-house')->group(function(){
        Route::get('/all', [WereHouseController::class,  'index']);
        Route::get('/show/{id}', [WereHouseController::class, 'show']);
        Route::post('/store', [WereHouseController::class, 'store']);
        Route::put('/update',[WereHouseController::class, 'update']);
        Route::delete('/destroy/{id}', [WereHouseController::class, 'destroy']);
    });

    Route::middleware(['auth:sanctum','admin'])->prefix('were-house-out')->group(function(){
        Route::get('/all', [WereHouseOutController::class,  'index']);
        Route::get('/show/{id}', [WereHouseOutController::class, 'show']);
        Route::post('/store', [WereHouseOutController::class, 'store']);
        Route::put('/update',[WereHouseOutController::class, 'update']);
        Route::delete('/destroy/{id}', [WereHouseOutController::class, 'destroy']);
    });

    Route::middleware(['auth:sanctum','admin'])->prefix('alert')->group(function(){
        Route::get('/all', [AlertController::class,  'index']);
        Route::get('/show/{id}', [AlertController::class, 'show']);
        Route::post('/store', [AlertController::class, 'store']);
        Route::put('/update',[AlertController::class, 'update']);
        Route::delete('/destroy/{id}', [AlertController::class, 'destroy']);
    });

    Route::middleware(['auth:sanctum'])->prefix('alert-user')->group(function(){

        Route::get('/show',[AlertUserController::class, 'show'])->middleware(Members::class);
    });

    Route::middleware(['auth:sanctum','admin'])->prefix('association')->group(function(){
        Route::get('/all', [AlertController::class,  'index']);
        Route::get('/show/{id}', [AlertController::class, 'show']);
        Route::post('/store', [AssociationController::class, 'store']);
        Route::put('/update',[AssociationController::class, 'update']);
        Route::delete('/destroy/{id}', [AssociationController::class, 'destroy']);
    });

});
