<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testBasicRouting()
    {
        $this->get('/login')
            ->assertStatus(200)
            ->assertSeeText("Ini adalah halaman Login");
    }

    public function testRedirect()
    {
        $this->get("/add")
            ->assertRedirect("/login");
    }
    public function testFallback()
    {
        $this->get("/404")
            ->assertSeeText("404");
    }

    public function testViewOrViewNested()
    {
        $this->get("/detail")
            ->assertSeeText("Exhuma");
    }

    public function testViewWithoutRoute()
    {
        $this->view('film.detail', ['title' => 'Exhuma'])
            ->assertSeeText('Exhuma');
    }
}
