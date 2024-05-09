<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/detail', function () {
    return "Ini adalah halaman Detail";
});
Route::get('/login', function () {
    return "Ini adalah halaman Login";
});
Route::get('/register', function () {
    return "Ini adalah halaman Register";
});

Route::redirect('/add', '/login'); // from, to
Route::redirect('/edit', '/login'); // from, to

// url not in laravel
Route::fallback(function () {
    return "404";
});
