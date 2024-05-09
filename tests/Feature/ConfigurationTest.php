<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testConfig()
    {
        $firstName = config("example.author.firstName");
        $middleName = config("example.author.middleName");
        $lastName = config("example.author.lastName");
        $email = config("example.email");
        $web = config("example.web");

        self::assertEquals("Muhammad", $firstName);
        self::assertEquals("Ariiq", $middleName);
        self::assertEquals("Fiezayyan", $lastName);
        self::assertEquals("fiezayyan@gmail.com", $email);
        self::assertEquals("belum ada", $web);
    }
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
