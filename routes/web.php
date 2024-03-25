<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
	return Inertia::render('Facts');
});

Route::get('/register', function () {
    return Inertia::render('Register');
});

Route::get('/login', function () {
	return Inertia::render('Login');
});
