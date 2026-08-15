<?php

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

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/adminbanal', function () {
    return view('adminbanal');
});
Route::get('/client', function () {
    return view('client');
});
