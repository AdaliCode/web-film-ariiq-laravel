<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormController extends Controller
{
    //
    public function register(): Response
    {
        return response()->view('register');
    }
    public function login(): Response
    {
        return response()->view('login');
    }

    public function submitRegister(Request $request): Response
    {
        $name = $request->input('username');
        return response("Hello $name, baru selesai buat ya!");
        // return response()->view('hello', ['name' => "Ariiq"]);
    }
    public function submitLogin(Request $request): Response
    {
        $name = $request->input('username');
        return response("Hello $name, Kamu mulu perasaan!");
        // return response()->view('hello', ['name' => "Ariiq"]);
    }
}
