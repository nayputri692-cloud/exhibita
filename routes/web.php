<?php

use Illuminate\Support\Facades\Route;

// Ini rute untuk halaman Landing Page (Halaman Depan)
Route::get('/', function () {
    return view('welcome');
});