<?php

use App\Http\Controllers\Admin\ContactMessageAdminController;
use App\Http\Controllers\Admin\HrAdminController;
use App\Http\Controllers\Admin\LeadAdminController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SiteUpdateController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EstimatorController;
use Illuminate\Support\Facades\Route;

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

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/careers', function () {
    return view('careers');
})->name('careers');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit')
    ->middleware(['guest', 'throttle:5,1']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/adminbanal', fn () => view('adminbanal'))
        ->name('admin.dashboard')
        ->middleware('can:access-admin');

    Route::get('/client', [ClientPortalController::class, 'index'])
        ->name('client.portal')
        ->middleware('can:access-client');

    Route::post('/client/projects', [ClientPortalController::class, 'storeProjectRequest'])
        ->name('client.projects.store')
        ->middleware('can:access-client');

    Route::prefix('admin')->middleware('can:access-admin')->group(function () {
        Route::get('/leads', [LeadAdminController::class, 'index'])->name('admin.leads.index');
        Route::patch('/leads/{lead}', [LeadAdminController::class, 'update'])->name('admin.leads.update');
        Route::get('/projects', [ProjectController::class, 'index'])->name('admin.projects.index');
        Route::patch('/projects/{project}', [ProjectController::class, 'update'])->name('admin.projects.update');

        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('admin.projects.destroy');
        Route::get(
            '/attachments/{attachment}/download',
            [LeadAdminController::class, 'downloadAttachment']
        )->name('admin.attachments.download');
        Route::get('/hr/applicants', [HrAdminController::class, 'index'])
            ->name('admin.hr.index');

        Route::patch('/hr/applicants/{applicant}', [HrAdminController::class, 'update'])
            ->name('admin.hr.update');

        Route::get('/hr/applicants/{applicant}/cv', [HrAdminController::class, 'downloadCv'])
            ->name('admin.hr.cv.download');

        Route::get('/site-updates', [SiteUpdateController::class, 'index'])
            ->name('admin.site-updates.index');

        Route::post('/site-updates', [SiteUpdateController::class, 'store'])
            ->name('admin.site-updates.store');

        Route::delete('/site-updates/{siteUpdate}', [SiteUpdateController::class, 'destroy'])
            ->name('admin.site-updates.destroy');

        Route::get('/messages', [ContactMessageAdminController::class, 'index'])
            ->name('admin.messages.index');

        Route::patch('/messages/{message}', [ContactMessageAdminController::class, 'update'])
            ->name('admin.messages.update');
        Route::get('/blog', [App\Http\Controllers\Admin\BlogController::class, 'index'])->name('admin.blog.index');
        Route::post('/blog', [App\Http\Controllers\Admin\BlogController::class, 'store'])->name('admin.blog.store');
        Route::patch('/blog/{post}', [App\Http\Controllers\Admin\BlogController::class, 'update'])->name('admin.blog.update');
        Route::delete('/blog/{post}', [App\Http\Controllers\Admin\BlogController::class, 'destroy'])->name('admin.blog.destroy');
    });
});

Route::post('/estimator/calculate', [EstimatorController::class, 'calculate'])->name('estimator.calculate');
Route::post('/quote/submit', [EstimatorController::class, 'store'])->name('quote.store');
Route::post('/contact/submit', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.submit');
Route::post('/careers/apply', [CareerController::class, 'store'])
    ->middleware('throttle:3,1')
    ->name('careers.apply');
