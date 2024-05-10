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
    public function testController()
    {
        // $this->get('/controller/register')
        //     ->assertSeeText("Hello World");
        $this->get('/controller/register/Ariiq')
            ->assertSeeText("HalO Ariiq");
    }
}
