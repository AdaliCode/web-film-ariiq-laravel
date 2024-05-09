<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Film;
use App\Data\Foo;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function testCreateDependency()
    // {
    //     $foo = $this->app->make(Foo::class);
    //     $foo2 = $this->app->make(Foo::class);

    //     self::assertEquals("Foo", $foo->foo());
    //     self::assertEquals("Foo", $foo2->foo());
    //     self::assertNotSame($foo, $foo2);
    // }
    public function testBind()
    {
        $this->app->bind(Film::class, function ($app) {
            return new Film("Pamyo", "Exhuma");
        });
        $film1 = $this->app->make(Film::class);
        $film2 = $this->app->make(Film::class);

        self::assertEquals("Pamyo", $film1->oriTitle);
        self::assertEquals("Pamyo", $film2->oriTitle);
        self::assertNotSame($film1, $film2);
    }
    public function testSingleton()
    {
        $this->app->singleton(Film::class, function ($app) {
            return new Film("Pamyo", "Exhuma");
        });
        $film1 = $this->app->make(Film::class);
        $film2 = $this->app->make(Film::class);

        self::assertEquals("Pamyo", $film1->oriTitle);
        self::assertEquals("Pamyo", $film2->oriTitle);
        self::assertSame($film1, $film2);
    }
    public function testInstance()
    {
        $film = new Film("Pamyo", "Exhuma");
        $this->app->instance(Film::class, $film);
        $film1 = $this->app->make(Film::class);
        $film2 = $this->app->make(Film::class);

        self::assertEquals("Pamyo", $film1->oriTitle);
        self::assertEquals("Pamyo", $film2->oriTitle);
        self::assertSame($film, $film1);
        self::assertSame($film1, $film2);
    }

    public function testDependencyInjection()
    {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });
        $foo = $this->app->make(Foo::class);
        $bar = $this->app->make(Bar::class);

        self::assertEquals("Foo and Bar", $bar->bar());
        self::assertSame($foo, $bar->foo);
    }

    public function testDependencyInjectionInClosure()
    {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });
        $this->app->singleton(Bar::class, function ($app) {
            return new Bar($app->make(Foo::class));
        });
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);
        self::assertSame($bar1, $bar2);
    }

    public function testHelloService()
    {
        $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

        $helloService = $this->app->make(HelloService::class);
        self::assertEquals("HalO Ariiq", $helloService->hello("Ariiq"));
    }
}
