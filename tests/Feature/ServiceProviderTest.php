<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Services\HelloService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testServiceProvider()
    {
        $foo = $this->app->make(Foo::class);
        $bar = $this->app->make(Bar::class);
        self::assertSame($foo, $bar->foo);
    }

    public function testProperty()
    {
        $helloService = $this->app->make(HelloService::class);
        self::assertEquals("HalO Ariiq", $helloService->hello("Ariiq"));
    }
}
