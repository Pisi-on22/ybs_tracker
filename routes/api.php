<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSignUpController;

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

Route::get('/userSignUp', [UserSignUpController::class, 'index']);
Route::post('/userSignUp', [UserSignUpController::class, 'create']);
Route::put('/userSignUp/{id}', [UserSignUpController::class, 'update']);
Route::delete('/userSignUp/{id}', [UserSignUpController::class, 'destroy']);