<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelloControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function testController()
    // {
    //     // $this->get('/controller/register')
    //     //     ->assertSeeText("Hello World");
    //     $this->get('/controller/register/Ariiq')
    //         ->assertSeeText("HalO Ariiq");
    // }

    // public function testRequest()
    // {
    //     $this->get('/controller/register/request', [
    //         'Accept' => 'plain/text'
    //     ])->assertSeeText("/controller/register/request")->assertSeeText('http://localhost/controller/register/request')->assertSeeText('GET')->assertSeeText('plain/text');
    // }

    public function testInput()
    {
        $this->get('input/hello?name=Ariiq')->assertSeeText("Hello Ariiq");
        $this->post('input/hello', ['name' => 'Ariiq'])->assertSeeText("Hello Ariiq");
    }

    public function testNestedInput()
    {
        $this->post('input/hello/first', ['name' => ['first' => 'Ariiq']])->assertSeeText('Hello Ariiq');
    }

    public function testInputAll()
    {
        $this->post('input/hello/input', ['name' => [
            'first' => 'Ariiq',
            'last' => 'Fiezayyan',
        ]])->assertSeeText('name')->assertSeeText('first')->assertSeeText('Ariiq')->assertSeeText('last')->assertSeeText('Fiezayyan');
    }

    public function testArrayInput()
    {
        $this->post('input/hello/array', [
            'films' => [
                ['title' => 'Exhuma'],
                ['title' => 'Abigail'],
            ]
        ])->assertSeeText('Exhuma')->assertSeeText('Abigail');
    }

    public function testInputType()
    {
        $this->post('input/type', [
            'name' => 'Ariiq',
            'married' => 'false',
            'birth_Date' => '2000-07-19'
        ])->assertSeeText('Ariiq')->assertSeeText('false')->assertSeeText('2000-07-19');
    }
    public function testFilterOnly()
    {
        $this->post('input/filter/only', [
            'name' => [
                'first' => "Muhammad",
                'middle' => 'Ariiq',
                'last' => 'Fiezayyan'
            ]
        ])->assertSeeText('Muhammad')->assertSeeText('Fiezayyan')
            ->assertDontSeeText('Ariiq');
    }
    public function testFilterExcept()
    {
        $this->post('input/filter/except', [
            'username' => "Ariiq",
            'admin' => 'true',
            'password' => 'Fiezayyan'

        ])->assertSeeText('Ariiq')->assertSeeText('Fiezayyan')
            ->assertDontSeeText('admin');
    }
    public function testFilterMerge()
    {
        $this->post('input/filter/merge', [
            'username' => "Ariiq",
            'admin' => 'true',
            'password' => 'Fiezayyan'

        ])->assertSeeText('Ariiq')->assertSeeText('Fiezayyan')
            ->assertSeeText('admin')->assertSeeText('false');
    }
}
