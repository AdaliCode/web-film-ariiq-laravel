<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputController extends Controller
{
    //
    public function hello(Request $request): string
    {
        $name = $request->input('name');
        return "Hello " . $name;
    }

    public function helloFirst(Request $request): string
    {
        $firstName = $request->input('name.first');
        return "Hello " . $firstName;
    }

    // take all input
    public function helloInput(Request $request): string
    {
        $input = $request->input();
        return json_decode($input);
    }

    // array input
    public function arrayInput(Request $request): string
    {
        $names = $request->input('films.*.title');
        return json_encode($names);
    }
}
