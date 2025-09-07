<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// Add this line to import your PetController
use App\Http\Controllers\PetController;
use App\Http\Controllers\VetController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pet routes
    Route::get('/pet/profile', [PetController::class, 'index'])->name('pet.profile');
    Route::get('/pet/create', [PetController::class, 'create'])->name('pet.create');
    Route::post('/pet/store', [PetController::class, 'store'])->name('pet.store');
    Route::get('/pet/edit/{id}', [PetController::class, 'edit'])->name('pet.edit');
    Route::put('/pet/update/{id}', [PetController::class, 'update'])->name('pet.update');
    Route::delete('/pet/delete/{id}', [PetController::class, 'destroy'])->name('pet.delete');
    Route::get('/pet/show/{id}', [PetController::class, 'show'])->name('pet.show');
    Route::post('/pet/{id}/disease/analyze', [PetController::class, 'analyzeDisease'])->name('disease.analyze');
    Route::get('/pet/{petId}/disease/{detectionId}/details', [PetController::class, 'getDetectionDetails'])->name('disease.details');
    
    Route::prefix('vets')->group(function () {
    Route::get('/', [VetController::class, 'index'])->name('vet.index');
    Route::get('/create', [VetController::class, 'create'])->name('vet.create')->middleware('auth');
    Route::post('/', [VetController::class, 'store'])->name('vet.store')->middleware('auth');
    Route::get('/{id}', [VetController::class, 'show'])->name('vet.show');
    Route::get('/{id}/edit', [VetController::class, 'edit'])->name('vet.edit')->middleware('auth');
    Route::put('/{id}', [VetController::class, 'update'])->name('vet.update')->middleware('auth');
    Route::delete('/{id}', [VetController::class, 'destroy'])->name('vet.destroy')->middleware('auth');
    // Vet registration routes
        Route::get('/register/form', [VetController::class, 'registerForm'])->name('become.vet.form');
        Route::post('/register/submit', [VetController::class, 'registerSubmit'])->name('become.vet.submit');
    });
    

    Route::middleware('role:vet')->group(function() {
        
    });
});

require __DIR__.'/auth.php';