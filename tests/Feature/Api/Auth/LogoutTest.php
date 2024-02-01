<?php

namespace Api\Auth;

use App\Constants\RouteNames;
use App\Models\User;
use Auth;
use Illuminate\Auth\AuthenticationException;
use JWTAuth;
use Tests\TestCase;
use URL;

class LogoutTest extends TestCase
{
    protected string $routeName = RouteNames::API_AUTH_LOGOUT;

    /** @test */
    public function an_unauthenticated_user_cannot_proceed()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthenticationException::class);

        $route = URL::route($this->routeName);
        $this->getJson($route);
    }

    /** @test */
    public function it_logs_out_a_tutor()
    {
        $route = URL::route($this->routeName);
        $tutor = User::factory()->create();

        $this->login($tutor);
        $this->getJson($route);

        $this->assertNull(Auth::user());
    }

    /** @test */
    public function it_invalidates_the_token()
    {
        $route = URL::route($this->routeName);
        $tutor = User::factory()->create();

        $this->login($tutor);
        Auth::setToken($this->token);
        $payload = Auth::payload();
        $this->getJson($route);

        $this->assertNull(Auth::user());
        $this->assertTrue(JWTAuth::blacklist()->has($payload));
    }

    /** @test */
    public function it_returns_no_content()
    {
        $route = URL::route($this->routeName);
        $tutor = User::factory()->create();

        $this->login($tutor);
        $response = $this->getJson($route);

        $response->assertNoContent();
    }
}
