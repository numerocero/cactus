<?php

namespace Tests\Feature\Api\Customer\Interaction;

use App\Constants\RequestKeys;
use App\Constants\RouteNames;
use App\Models\Customer;
use App\Models\Interaction;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use URL;

class StoreTest extends TestCase
{
    protected string $routeName = RouteNames::API_CUSTOMER_INTERACTION_STORE;

    /** @test */
    public function an_unauthenticated_user_cannot_proceed()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthenticationException::class);

        $interaction = Interaction::factory()->create();
        $route = URL::route($this->routeName, [$interaction->customer, $interaction]);
        $this->getJson($route);
    }

    /** @test */
    public function it_stores_an_interaction()
    {
        $customer = Customer::factory()->create();
        $route    = URL::route($this->routeName, [$customer]);

        $this->login();
        $response = $this->post($route, [
            RequestKeys::DESCRIPTION => $description = 'description',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $data = $response->json('data');
        $this->assertSame($description, $data['description']);

        $tableName = (new Interaction())->getTable();
        $this->assertDatabaseHas($tableName, [
            'id'          => $data['id'],
            'description' => $data['description'],
            'created_at'  => $data['created_at'],
        ]);
    }
}
