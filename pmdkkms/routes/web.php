<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function() {
    return view('auth.login');
})->name('login');

Route::get('/register', function() {
    return view('auth.register');
})->name('register');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/member', function () {
    return view('member');
})->name('member');
