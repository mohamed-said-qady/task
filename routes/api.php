<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginController;
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

Route::post('login',[UserLoginController::class,'login'])->name('login');
Route::post('/forgot-password', [UserLoginController::class, 'forgetPassword']);
Route::post('/reset-password', [UserLoginController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
