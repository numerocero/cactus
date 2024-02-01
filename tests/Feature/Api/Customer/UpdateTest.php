<?php

namespace Tests\Feature\Api\Customer;

use App\Constants\RequestKeys;
use App\Constants\RouteNames;
use App\Models\Customer;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use URL;

class UpdateTest extends TestCase
{
    protected string $routeName = RouteNames::API_CUSTOMER_UPDATE;

    /** @test */
    public function an_unauthenticated_user_cannot_proceed()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthenticationException::class);

        $customer = Customer::factory()->create();
        $route = URL::route($this->routeName, [$customer]);
        $this->getJson($route);
    }

    /** @test */
    public function it_updates_a_customer()
    {
        $customer = Customer::factory()->create();
        $route    = URL::route($this->routeName, $customer);
        $name     = 'new name';
        $email    = 'new@example.com';

        $this->login();
        $response = $this->patch($route, [
            RequestKeys::NAME  => $name,
            RequestKeys::EMAIL => $email,
        ]);
        $response->assertStatus(Response::HTTP_OK);

        $data = $response->json('data');
        $customer->refresh();
        $this->assertSame($customer->getRouteKey(), $data['id']);
        $this->assertSame($customer->name, $data['name']);
        $this->assertSame($customer->email, $data['email']);
        $this->assertNull($data['last_interaction_date']);

        $tableName = (new Customer())->getTable();
        $this->assertDatabaseHas($tableName, [
            'id'    => $customer->getRouteKey(),
            'name'  => $name,
            'email' => $email,
        ]);
    }
}
