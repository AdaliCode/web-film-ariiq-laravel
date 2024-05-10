<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseTest extends TestCase
{
    public function testResponse()
    {
        $this->get('/response/hello')
            ->assertStatus(200)
            ->assertSeeText("Hello Response");
    }

    public function testHeader()
    {
        $this->get('/response/header')
            ->assertStatus(200)
            ->assertSeeText("Ariiq")->assertSeeText("Fiezayyan")
            ->assertHeader('Content-Type', 'application/json')
            ->assertHeader('Author', 'Ariiq')
            ->assertHeader('App', 'Aflix');
    }

    public function testView()
    {
        $this->get('/response/type/view')
            ->assertSeeText('Hello Ariiq');
    }
    public function testJson()
    {
        $this->get('/response/type/json')
            ->assertJson(['firstName' => 'Ariiq', 'lastName' => "Fiezayyan"]);
    }
    public function testFile()
    {
        $this->get('/response/type/file')
            ->assertHeader('Content-Type', "image/png");
    }
    public function testDownload()
    {
        $this->get('/response/type/download')
            ->assertDownload("ariiq.png");
    }
}
