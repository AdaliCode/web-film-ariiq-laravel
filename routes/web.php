<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::view('/detail', 'film.detail', ['title' => 'Exhuma']);
Route::get('/movie/{movie}', function ($movieTittle) {
    return " Judul Film : $movieTittle";
});
Route::get('/tvseries/{id}', function (string $tvseriesTitle) {
    return "Judul TV Series : $tvseriesTitle";
})->where('id', '[0-9]+');

Route::get('/anime/{id?}', function (string $animeID = '404') {
    return "Anime : $animeID";
});
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
