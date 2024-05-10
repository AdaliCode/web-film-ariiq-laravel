<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testEnv()
    {
        $appName = env("WEB");
        self::assertEquals("Aflix", $appName);
    }
    public function testDefaultValue()
    {
        $author = env("AUTHOR", "Ariiq");
        self::assertEquals("Ariiq", $author);
    }
    public function testEnvironment()
    {
        if (App::environment("testing")) {
            echo "LOGIC IN TESTING ENV\n";
            self::assertTrue(true);
        }
    }
}
