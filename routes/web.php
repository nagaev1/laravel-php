<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WorkController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Controller;

Route::redirect('/', 'anime');

// Route::get('/anime', [WorkController::class, 'index'])->name('anime');
Route::name('anime.')->group(function() {
  Route::get('/anime', [WorkController::class, 'filter'])->name('filter');
  Route::get('/anime/create', [WorkController::class, 'create'])->name('create');
  Route::get('/anime/{name}', [WorkController::class, 'show'])->name('show');
  Route::get('/anime/{name}/edit', [WorkController::class, 'edit'])->name('edit');
  Route::post('/anime', [WorkController::class, 'store'])->name('store');
  Route::patch('/anime/{name}/', [WorkController::class, 'update'])->name('update');
});

Route::name('company.')->group(function() {
  Route::get('/companies/create', [CompanyController::class, 'create'])->name('create');
  Route::get('/companies/{name}', [CompanyController::class, 'show'])->name('show');
  Route::get('/companies/{name}/edit', [CompanyController::class, 'edit'])->name('edit');
  Route::post('companies', [CompanyController::class, 'store'])->name('store');
  Route::patch('companies/{name}', [CompanyController::class, 'update'])->name('update');
});