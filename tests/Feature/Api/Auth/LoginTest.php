<?php

namespace Api\Auth;

use App\Constants\RouteNames;
use App\Models\User;
use Lang;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use URL;

class LoginTest extends TestCase
{
    protected string $routeName = RouteNames::API_AUTH_LOGIN;

    /** @test */
    public function it_logs_in_a_user()
    {
        $user  = User::factory()->create();
        $route = URL::route($this->routeName);

        $response = $this->postJson($route, [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_returns_a_valid_jwt_token()
    {
        $user  = User::factory()->create();
        $route = URL::route($this->routeName);

        $response = $this->postJson($route, [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);

        JWTAuth::setToken($response->json('data.token'));
        $this->assertTrue(JWTAuth::check());
    }

    /** @test */
    public function it_sets_a_refresh_token_cookie()
    {
        $user  = User::factory()->create();
        $route = URL::route($this->routeName);

        $response = $this->postJson($route, [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertPlainCookie('jwt');

        JWTAuth::setToken($response->getCookie('jwt', false)->getValue());
        $this->assertTrue(JWTAuth::check());
    }

    /** @test */
    public function it_fails_if_login_data_is_invalid()
    {
        $user  = User::factory()->create();
        $route = URL::route($this->routeName);

        $response = $this->postJson($route, [
            'email'    => $user->email,
            'password' => 'invalid password',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertInvalid(['password' => Lang::get('auth.failed')]);
    }
}
