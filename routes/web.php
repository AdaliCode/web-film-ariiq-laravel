<?php

use App\Http\Controllers\CookieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResponseController;
use App\Http\Middleware\ExampleMiddleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::view('/register', 'register');
// Route::get('/controller/register', [RegisterController::class, 'hello']);
Route::get('/controller/register/request', [RegisterController::class, 'request']);
Route::get('/controller/register/{name}', [RegisterController::class, 'hello']);
Route::get('/input/hello', [InputController::class, 'hello']);
Route::post('/input/hello', [InputController::class, 'hello']);
Route::post('/input/hello/first', [InputController::class, 'helloFirst']);
Route::post('/input/hello/input', [InputController::class, 'helloInput']);
Route::post('/input/hello/array', [InputController::class, 'arrayInput']);
Route::post('/input/type', [InputController::class, 'inputType']);
Route::post('/input/filter/only', [InputController::class, 'filterOnly']);
Route::post('/input/filter/except', [InputController::class, 'filterExcept']);
Route::post('/input/filter/merge', [InputController::class, 'filterMerge']);
Route::post('/file/upload', [FileController::class, 'upload'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('/response/hello', [ResponseController::class, 'response']);
Route::get('/response/header', [ResponseController::class, 'header']);
Route::get('/response/type/view', [ResponseController::class, 'responseView']);
Route::get('/response/type/json', [ResponseController::class, 'responseJson']);
Route::get('/response/type/file', [ResponseController::class, 'responseFile']);
Route::get('/response/type/download', [ResponseController::class, 'responseDownload']);
Route::get('/cookie/set', [CookieController::class, 'createCookie']);
Route::get('/cookie/get', [CookieController::class, 'getCookie']);
Route::get('/cookie/clear', [CookieController::class, 'clearCookie']);
Route::get('/redirect/from', [RedirectController::class, 'redirectFrom']);
Route::get('/redirect/to', [RedirectController::class, 'redirectTo']);
Route::get('/redirect/name', [RedirectController::class, 'redirectName']);
Route::get('/redirect/name/{name}', [RedirectController::class, 'redirectHello'])->name('redirect-hello');
Route::get('/redirect/action', [RedirectController::class, 'redirectAction']);
Route::get('/redirect/fvc', [RedirectController::class, 'redirectAway']);
Route::get('/middleware/api', function () {
    return "OK";
})->middleware(['example:AFLIX,401']); // parameter:string $key, int $status
Route::get('/middleware/group', function () {
    return "GROUP";
})->middleware(['aflix']);
Route::view('/login', 'login');
Route::view('/detail', 'film.detail', ['title' => 'Exhuma']);
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
