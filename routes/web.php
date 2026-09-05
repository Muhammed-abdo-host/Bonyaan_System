<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstimatorController;
use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\CareerController;



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

Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog');
Route::get('/blog/{post:slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

Route::get('/careers', function () {
    return view('careers');
})->name('careers');


Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/adminbanal', fn() => view('adminbanal'))
        ->name('admin.dashboard')
        ->middleware('can:access-admin');

    Route::get('/client', [ClientPortalController::class, 'index'])
        ->name('client.portal')
        ->middleware('can:access-client');
    Route::prefix('admin')->middleware('can:access-admin')->group(function () {
        Route::get('/leads', [\App\Http\Controllers\Admin\LeadAdminController::class, 'index'])->name('admin.leads.index');
        Route::patch('/leads/{lead}', [\App\Http\Controllers\Admin\LeadAdminController::class, 'update'])->name('admin.leads.update');
        Route::get('/projects', [\App\Http\Controllers\Admin\ProjectController::class, 'index'])->name('admin.projects.index');
        Route::get('/clients', [\App\Http\Controllers\Admin\ProjectController::class, 'clients'])->name('admin.clients.index');
        Route::post('/projects', [\App\Http\Controllers\Admin\ProjectController::class, 'store'])->name('admin.projects.store');
        Route::patch('/projects/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'update'])->name('admin.projects.update');

        Route::delete('/projects/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'destroy'])->name('admin.projects.destroy');
        Route::get(
            '/attachments/{attachment}/download',
            [\App\Http\Controllers\Admin\LeadAdminController::class, 'downloadAttachment']
        )->name('admin.attachments.download');
        Route::get('/hr/applicants', [\App\Http\Controllers\Admin\HrAdminController::class, 'index'])
            ->name('admin.hr.index');

        Route::patch('/hr/applicants/{applicant}', [\App\Http\Controllers\Admin\HrAdminController::class, 'update'])
            ->name('admin.hr.update');

        Route::get('/hr/applicants/{applicant}/cv', [\App\Http\Controllers\Admin\HrAdminController::class, 'downloadCv'])
            ->name('admin.hr.cv.download');

        Route::get('/site-updates', [\App\Http\Controllers\Admin\SiteUpdateController::class, 'index'])
            ->name('admin.site-updates.index');

        Route::post('/site-updates', [\App\Http\Controllers\Admin\SiteUpdateController::class, 'store'])
            ->name('admin.site-updates.store');

        Route::delete('/site-updates/{siteUpdate}', [\App\Http\Controllers\Admin\SiteUpdateController::class, 'destroy'])
            ->name('admin.site-updates.destroy');

        Route::get('/messages', [\App\Http\Controllers\Admin\ContactMessageAdminController::class, 'index'])
            ->name('admin.messages.index');

        Route::patch('/messages/{message}', [\App\Http\Controllers\Admin\ContactMessageAdminController::class, 'update'])
            ->name('admin.messages.update');
        Route::get('/blog', [\App\Http\Controllers\Admin\BlogController::class, 'index'])->name('admin.blog.index');
        Route::post('/blog', [\App\Http\Controllers\Admin\BlogController::class, 'store'])->name('admin.blog.store');
        Route::patch('/blog/{post}', [\App\Http\Controllers\Admin\BlogController::class, 'update'])->name('admin.blog.update');
        Route::delete('/blog/{post}', [\App\Http\Controllers\Admin\BlogController::class, 'destroy'])->name('admin.blog.destroy');
    });
});

Route::post('/estimator/calculate', [EstimatorController::class, 'calculate'])->name('estimator.calculate');
Route::post('/quote/submit', [EstimatorController::class, 'store'])->name('quote.store');
Route::post('/contact/submit', [\App\Http\Controllers\ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.submit');
Route::post('/careers/apply', [CareerController::class, 'store'])
    ->middleware('throttle:3,1')
    ->name('careers.apply');
