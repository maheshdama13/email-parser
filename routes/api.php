<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\SuccessfulEmailController;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/tokens/create', function (Request $request) {
    $token = User::first()->createToken('demo_token');
 
    return ['token' => $token->plainTextToken];
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('emails', [SuccessfulEmailController::class, 'index']);
    Route::post('emails', [SuccessfulEmailController::class, 'store']);
    Route::get('emails/{id}', [SuccessfulEmailController::class, 'show']);
    Route::put('emails/{id}', [SuccessfulEmailController::class, 'update']);
    Route::delete('emails/{id}', [SuccessfulEmailController::class, 'destroy']);
});