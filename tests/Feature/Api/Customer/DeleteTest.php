<?php

namespace Tests\Feature\Api\Customer;

use App\Constants\RouteNames;
use App\Models\Customer;
use App\Models\Interaction;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use URL;

class DeleteTest extends TestCase
{
    protected string $routeName = RouteNames::API_CUSTOMER_DELETE;

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
    public function it_deletes_a_customer()
    {
        $customer = Customer::factory()->create();
        $interaction = Interaction::factory()->usingCustomer($customer)->create();
        $route = URL::route($this->routeName, $customer);

        $this->login();
        $response = $this->delete($route);
        $response->assertNoContent();

        $this->assertModelMissing($customer);
        $this->assertModelMissing($interaction);
    }
}
