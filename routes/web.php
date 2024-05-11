<?php

use App\Exceptions\ValidationException;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SessionController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

Route::view('/', 'home');
Route::get('/register', [FormController::class, 'register']);
Route::post('/register', [FormController::class, 'submitRegister']);
Route::get('/login', [FormController::class, 'login']);
Route::post('/login', [FormController::class, 'submitLogin']);

Route::get('/url/current', function () {
    return URL::full();
});
Route::get('/url/named', function () {
    return route('redirect-hello', ['name' => 'Ariiq']);
});
Route::get('/url/action', function () {
    return action([FormController::class, 'register'], []);
});

Route::get('/session/create', [SessionController::class, 'createSession']);
Route::get('/session/get', [SessionController::class, 'getSession']);
Route::get('/error/sample', function () {
    throw new Exception("Sample Error");
});
Route::get('/error/manual', function () {
    report(new Exception('Sample Error'));
    return "OK";
});
Route::get('/error/validation', function () {
    throw new ValidationException("
    Validation Error");
});

Route::controller(InputController::class)->prefix('/input')->group(function () {
    Route::get('/hello', 'hello');
    Route::post('/hello', 'hello');
    Route::post('/hello/first', 'helloFirst');
    Route::post('/hello/input', 'helloInput');
    Route::post('/hello/array', 'arrayInput');
    Route::post('/type', 'inputType');
    Route::post('/filter/only', 'filterOnly');
    Route::post('/filter/except', 'filterExcept');
    Route::post('/filter/merge', 'filterMerge');
});
Route::post('/file/upload', [FileController::class, 'upload'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('/response/hello', [ResponseController::class, 'response']);
Route::get('/response/header', [ResponseController::class, 'header']);
Route::prefix('/response/type')->group(function () {
    Route::get('/view', [ResponseController::class, 'responseView']);
    Route::get('/json', [ResponseController::class, 'responseJson']);
    Route::get('/file', [ResponseController::class, 'responseFile']);
    Route::get('/download', [ResponseController::class, 'responseDownload']);
});
Route::controller(CookieController::class)->group(function () {
    Route::get('/cookie/set', 'createCookie');
    Route::get('/cookie/get', 'getCookie');
    Route::get('/cookie/clear', 'clearCookie');
});
Route::controller(RedirectController::class)->prefix('/redirect')->group(function () {
    Route::get('/from', 'redirectFrom');
    Route::get('/to', 'redirectTo');
    Route::get('/name', 'redirectName');
    Route::get('/name/{name}', 'redirectHello')->name('redirect-hello');
    Route::get('/action', 'redirectAction');
    Route::get('/fvc', 'redirectAway');
});
Route::middleware(['example:AFLIX,401'])->prefix('/middleware')->group(function () {
    Route::get('/api', function () {
        return "OK";
    });
});
Route::get('/middleware/group', function () {
    return "GROUP";
})->middleware(['aflix']);
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
