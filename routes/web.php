<?php
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('registrations.index'));

Route::get('/registrations',          [RegistrationController::class, 'index'])->name('registrations.index');
Route::get('/registrations/create',   [RegistrationController::class, 'create'])->name('registrations.create');
Route::post('/registrations',         [RegistrationController::class, 'store'])->name('registrations.store');
Route::put('/registrations/{id}',     [RegistrationController::class, 'update'])->name('registrations.update');
Route::delete('/registrations/{id}',  [RegistrationController::class, 'destroy'])->name('registrations.destroy');
