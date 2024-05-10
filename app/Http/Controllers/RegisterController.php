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

    public function request(Request $request): string
    {
        return $request->path() . "<br>" . // controller/register/request
            $request->url() . "<br>" . // http://127.0.0.1:8000/controller/register/request
            $request->fullUrl() . "<br>" . // http://127.0.0.1:8000/controller/register/request
            $request->method() . "<br>" . // GET
            $request->header('Accept') . "<br>"; // text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7
    }
}
