<?php

namespace Tests\Feature\Api\Customer;

use App\Constants\RouteNames;
use App\Models\Customer;
use App\Models\Interaction;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use URL;

class ShowTest extends TestCase
{
    protected string $routeName = RouteNames::API_CUSTOMER_SHOW;

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
    public function it_shows_a_customer()
    {
        $customer = Customer::factory()->create();
        Interaction::factory()->usingCustomer($customer)->create();
        $route = URL::route($this->routeName, $customer);

        $this->login();
        $response = $this->get($route);
        $response->assertStatus(Response::HTTP_OK);

        $data = $response->json('data');
        $this->assertSame($customer->getRouteKey(), $data['id']);
        $this->assertSame($customer->name, $data['name']);
        $this->assertSame($customer->email, $data['email']);
        $this->assertEquals($customer->interactions()->latest()->first()?->created_at->toIsoString(), $data['last_interaction_date']);
    }
}
