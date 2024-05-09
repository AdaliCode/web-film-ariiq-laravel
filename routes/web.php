<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::view('/detail', 'film.detail', ['title' => 'Exhuma']);
Route::view('/register', 'register');
Route::view('/login', 'login');
Route::get('/movie/{movie}', function ($movieTittle) {
    return " Judul Film : $movieTittle";
})->name('movie.detail');
Route::get('/tvseries/{id}', function (string $tvseriesTitle) {
    return "Judul TV Series : $tvseriesTitle";
})->where('id', '[0-9]+');
Route::get('/anime/{id?}', function (string $animeID = '404') {
    return "Anime : $animeID";
})->name('anime.detail');;
Route::get('/film/{film}', function ($filmTittle) {
    $link = route('movie.detail', [
        'movie' => $filmTittle
    ]);
    return "Link : $link";
});
Route::get('/film-redirect/{film}', function ($filmTittle) {
    return redirect()->route('movie.detail', [
        'movie' => $filmTittle
    ]);
});

Route::redirect('/add', '/login'); // from, to
Route::redirect('/edit', '/login'); // from, to

// url not in laravel
Route::fallback(function () {
    return "404";
});
