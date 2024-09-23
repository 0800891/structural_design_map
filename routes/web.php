<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\ProjectLikeController;


// Route::get('/projects/openai-search', [ProjectController::class, 'openai_search'])->name('projects.openai_search');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
    
    Route::middleware('auth')->group(function () {

    Route::get('/projects/openai-search', [ProjectController::class, 'openai_search'])->name('projects.openai_search');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('companies', CompanyController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('maps',MapController::class);


    Route::post('projects', [ProjectController::class,'store'])->name('projects.store');
    // Route::post('/projects/store', [ProjectController::class,'store'])->name('projects.store');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');

    Route::post('companies', [CompanyController::class,'store'])->name('companies.store');

    Route::post('maps',[MapController::class,'index'])->name('maps.index');

    Route::get('/translation', [TranslationController::class, 'index'])->name('translation-index');
    // Route::post('/translation', [TranslationController::class, 'translation'])->name('translation-translation');
    Route::post('/translation', [TranslationController::class, 'translation'])->name('translation');

    Route::post('/projects/{project}/like', [ProjectLikeController::class, 'store'])->name('projects.like');
    Route::delete('/projects/{project}/like', [ProjectLikeController::class, 'destroy'])->name('projects.dislike');

    Route::get('/dashboard', [ProjectController::class, 'dashboard'])->name('dashboard');

   
    // Route::get('/projects/openai-search', [ProjectController::class, 'openai_search'])->name('projects.openai_search');



});


require __DIR__.'/auth.php';
