<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    // this comment not mean for deleting
    // public function testBasicRouting()
    // {
    //     $this->get('/login')
    //         ->assertStatus(200)
    //         ->assertSeeText("Ini adalah halaman Login");
    // }

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

    public function testRouteParameter()
    {
        $this->get('/movie/exhuma')
            ->assertSeeText("Judul Film : exhuma");
    }

    public function testRouteParameterRegex()
    {
        $this->get('/tvseries/12345')->assertSeeText("Judul TV Series : 12345");
        $this->get('/tvseries/salah')->assertSeeText("404");
    }
    public function testRouteOptionalParameter()
    {
        $this->get('/anime/12345')->assertSeeText("Anime : 12345");
        $this->get('/anime/')->assertSeeText("Anime : 404");
    }

    public function testNamed()
    {
        $this->get('/film/12345')->assertSeeText("movie/12345");
        $this->get('/film-redirect/12345')->assertRedirect("movie/12345");
    }
}
