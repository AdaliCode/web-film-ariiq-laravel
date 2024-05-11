<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // Middleware
    public function testInvalid()
    {
        $this->get('/middleware/api')
            ->assertStatus(401)
            ->assertSeeText("Access Denied");
    }
    public function testValid()
    {
        $this->withHeader('X-API-KEY', 'AFLIX')
            ->get('/middleware/api')
            ->assertStatus(200)
            ->assertSeeText("OK");
    }
    public function testInvalidGroup()
    {
        $this->get('/middleware/group')
            ->assertStatus(401)
            ->assertSeeText("Access Denied");
    }
    public function testValidGroup()
    {
        $this->withHeader('X-API-KEY', 'AFLIX')
            ->get('/middleware/group')
            ->assertStatus(200)
            ->assertSeeText("GROUP");
    }
}
