<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class FacadesTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testConfig()
    {
        $firstName1 = config("example.author.firstName");
        $firstName2 = Config::get("example.author.firstName");

        self::assertEquals($firstName1, $firstName2);
        var_dump(Config::all());
    }

    public function testConfigDependency()
    {
        $config = $this->app->make("config");
        $firstName1 = $config->get("example.author.firstName");
        $firstName2 = Config::get("example.author.firstName");

        self::assertEquals($firstName1, $firstName2);
        var_dump(Config::all());
    }

    public function testConfigMock()
    {
        Config::shouldReceive('get')
            ->with('example.author.firstName')
            ->andReturn("Ariiq Moissoso");
        $firstName = Config::get('example.author.firstName');

        self::assertEquals("Ariiq Moissoso", $firstName);
    }
}
