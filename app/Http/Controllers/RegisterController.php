<?php

namespace App\Http\Controllers;

use App\Services\HelloService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private HelloService $helloService;

    public function __construct(HelloService $helloService)
    {
        $this->helloService = $helloService;
    }
    // public function hello(): string
    // {
    //     // return "Hello World";
    // }
    public function hello(string $name): string
    {
        // return "Hello World";
        return $this->helloService->hello($name);
    }
}
