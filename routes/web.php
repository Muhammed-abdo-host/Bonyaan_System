<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstimatorController;


Route::get('/', function () {
    return view('home');
});


Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/services', function () {
    return view('services');
});

Route::get('/projects', function () {
    return view('projects');
});

Route::get('/estimator', function () {
    return view('estimator');
});

Route::get('/quote', function () {
    return view('quote');
});

Route::get('/blog', function () {
    return view('blog');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/adminbanal', fn() => view('adminbanal'))
        ->name('admin.dashboard')
        ->middleware('can:access-admin');

    Route::get('/client', fn() => view('client'))
        ->name('client.portal')
        ->middleware('can:access-client');

    Route::prefix('admin')->middleware('can:access-admin')->group(function () {
        Route::get('/leads', [\App\Http\Controllers\Admin\LeadAdminController::class, 'index'])->name('admin.leads.index');
        Route::patch('/leads/{lead}', [\App\Http\Controllers\Admin\LeadAdminController::class, 'update'])->name('admin.leads.update');
    });
    Route::get('/projects', [\App\Http\Controllers\Admin\ProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('/clients', [\App\Http\Controllers\Admin\ProjectController::class, 'clients'])->name('admin.clients.index');
    Route::post('/projects', [\App\Http\Controllers\Admin\ProjectController::class, 'store'])->name('admin.projects.store');
    Route::patch('/projects/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/projects/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'destroy'])->name('admin.projects.destroy');
});

Route::post('/estimator/calculate', [EstimatorController::class, 'calculate'])->name('estimator.calculate');
Route::post('/quote/submit', [EstimatorController::class, 'store'])->name('quote.store');
