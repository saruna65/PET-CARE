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
    });
    
// Inside your vet middleware group
Route::middleware('role:vet')->group(function () {
    Route::get('/vet/dashboard', [VetController::class, 'dashboard'])->name('vet.dashboard');
    Route::get('/vet/profile/edit', [VetController::class, 'editProfile'])->name('vet.edit.profile');
    Route::post('/vet/profile/update', [VetController::class, 'updateProfile'])->name('vet.update.profile');
    
    // Add these new routes for the vet diseases functionality
    Route::get('/vet/diseases', [VetController::class, 'allDiseases'])->name('vet.diseases');
    Route::get('/vet/disease/{id}', [VetController::class, 'getDiseaseDetails'])->name('vet.disease-details');
    Route::post('/vet/disease/{id}/review', [VetController::class, 'markDiseaseReviewed'])->name('vet.mark-reviewed');
});
    
    // Admin-only routes
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/vets/create', [VetController::class, 'create'])->name('vet.create');
        Route::post('/vets', [VetController::class, 'store'])->name('vet.store');
        Route::get('/vets/{id}/edit', [VetController::class, 'edit'])->name('vet.edit');
        Route::put('/vets/{id}', [VetController::class, 'update'])->name('vet.update');
        Route::delete('/vets/{id}', [VetController::class, 'destroy'])->name('vet.destroy');
        
        // Create new user and vet profile together (admin only)
        Route::get('/vets/create-with-user', [VetController::class, 'createWithUser'])->name('vet.create.with.user');
        Route::post('/vets/store-with-user', [VetController::class, 'storeWithUser'])->name('vet.store.with.user');

        
    });

});

require __DIR__.'/auth.php';