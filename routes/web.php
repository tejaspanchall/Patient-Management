<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    
    Route::get('/patients', [PatientController::class, 'index'])->name('admin.patients.index');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('admin.patients.show');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('admin.patients.update');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('admin.patients.destroy');
});