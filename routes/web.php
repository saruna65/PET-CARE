<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\VetController;
use App\Http\Controllers\DashboardController;

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

    Route::get('/pets/detail/{pet}', [DashboardController::class, 'details'])->name('pet.details');
    Route::get('/pets/list', [DashboardController::class, 'index'])->name('pets.index');
    
    // Vet routes
    Route::prefix('vets')->group(function () {
        // Public vet routes (accessible to all authenticated users)
        Route::get('/', [VetController::class, 'index'])->name('vet.index');
        Route::get('/{id}', [VetController::class, 'show'])->name('vet.show');
        
        // Routes for regular users to register as vets
        Route::get('/register/form', [VetController::class, 'registerForm'])->name('become.vet.form');
        Route::post('/register/submit', [VetController::class, 'registerSubmit'])->name('become.vet.submit');
        
        // Vet-only routes (accessible only to users with the 'vet' role)
        Route::middleware('role:vet')->group(function () {
            Route::get('/dashboard', [VetController::class, 'dashboard'])->name('vet.dashboard');
            Route::get('/profile/edit', [VetController::class, 'editProfile'])->name('vet.edit.profile');
            Route::post('/profile/update', [VetController::class, 'updateProfile'])->name('vet.update.profile');
        });
        
        // Admin-only routes (accessible only to users with the 'admin' role)
        Route::middleware('role:admin')->group(function () {
            Route::get('/create', [VetController::class, 'create'])->name('vet.create');
            Route::post('/', [VetController::class, 'store'])->name('vet.store');
            Route::get('/{id}/edit', [VetController::class, 'edit'])->name('vet.edit');
            Route::put('/{id}', [VetController::class, 'update'])->name('vet.update');
            Route::delete('/{id}', [VetController::class, 'destroy'])->name('vet.destroy');
            
            // Create new user and vet profile together (admin only)
            Route::get('/create-with-user', [VetController::class, 'createWithUser'])->name('vet.create.with.user');
            Route::post('/store-with-user', [VetController::class, 'storeWithUser'])->name('vet.store.with.user');
        });
    });
});

require __DIR__.'/auth.php';