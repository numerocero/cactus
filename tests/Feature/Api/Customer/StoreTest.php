<?php

namespace Tests\Feature\Api\Customer;

use App\Constants\RequestKeys;
use App\Constants\RouteNames;
use App\Models\Customer;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use URL;

class StoreTest extends TestCase
{
    protected string $routeName = RouteNames::API_CUSTOMER_STORE;

    /** @test */
    public function an_unauthenticated_user_cannot_proceed()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthenticationException::class);

        $route = URL::route($this->routeName);
        $this->getJson($route);
    }

    /** @test */
    public function it_stores_a_customer()
    {
        $name  = 'name';
        $email = 'test@example.com';
        $route = URL::route($this->routeName);

        $this->login();
        $response = $this->post($route, [
            RequestKeys::NAME  => $name,
            RequestKeys::EMAIL => $email,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $data = $response->json('data');
        $this->assertSame($data['name'], $name);
        $this->assertSame($data['email'], $email);

        $tableName = (new Customer())->getTable();
        $this->assertDatabaseHas($tableName, [
            'name'  => $name,
            'email' => $email,
        ]);
    }
}
