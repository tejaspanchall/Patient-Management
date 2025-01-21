<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::get('/patients', [PatientController::class, 'getAllPatients']);
    Route::post('/patients', [PatientController::class, 'store']);
});