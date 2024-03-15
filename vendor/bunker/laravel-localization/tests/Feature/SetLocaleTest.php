<?php

namespace Bunker\LaravelLocalization\Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Orchestra\Testbench\TestCase;
use Bunker\LaravelLocalization\Middleware\SetLocale;

class SetLocaleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Reset any cookies before each test
        Cookie::queue('language', null);
    }

    /** @test */
    public function it_sets_locale_from_request_input()
    {
        $middleware = new SetLocale();

        $request = Request::create('/', 'GET', ['lang' => 'bd']);
        $middleware->handle($request, function ($req) {
            $this->assertEquals('bd', App::getLocale());
            return new Response();
        });
    }

    /** @test */
    public function it_sets_locale_from_cookie()
    {
        // Set the cookie value to 'bd'
        Cookie::queue('language', 'en');

        $middleware = new SetLocale();

        // Create a request with the '/' URI and GET method
        $request = Request::create('/', 'GET');

        // Handle the request with the middleware
        $response = $middleware->handle($request, function ($req) {
            // Return a new response
            return new Response();
        });

        // Assert that the response status code is 200 (OK)
        $this->assertEquals(200, $response->status());

        // Assert that the application locale is set to 'bd'
        $this->assertEquals('en', App::getLocale());
    }



    /** @test */
    public function it_sets_default_locale_if_no_input_or_cookie()
    {
        config(['app.locale' => 'en']);

        $middleware = new SetLocale();

        $request = Request::create('/');
        $middleware->handle($request, function ($req) {
            $this->assertEquals('en', App::getLocale());
            return new Response();
        });
    }
}
