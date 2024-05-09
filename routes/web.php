<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::view('/detail', 'film.detail', ['title' => 'Exhuma']);
Route::view('/register', 'register');
Route::get('/login', function () {
    return "Ini adalah halaman Login";
});

Route::redirect('/add', '/login'); // from, to
Route::redirect('/edit', '/login'); // from, to

// url not in laravel
Route::fallback(function () {
    return "404";
});
