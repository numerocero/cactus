<?php

namespace Tests\Feature\Api\Customer\Interaction;

use App\Constants\RouteNames;
use App\Models\Customer;
use App\Models\Interaction;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use URL;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    protected string $routeName = RouteNames::API_CUSTOMER_INTERACTION_INDEX;

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
    public function it_displays_a_lisT_of_customer_interactions()
    {
        $customer = Customer::factory()->create();
        $interactions = Interaction::factory()->usingCustomer($customer)->count(20)->create();
        Interaction::factory()->count(4)->create();
        $route = URL::route($this->routeName, [$customer]);

        $this->login();
        $response = $this->get($route);
        $response->assertStatus(Response::HTTP_OK);

        $data = Collection::make($response->json('data'));
        $firstPAgeInteractions = $interactions->values()->take(count($data));

        $data->each(function(array $rawInteraction, int $index) use ($firstPAgeInteractions){
            $interaction = $firstPAgeInteractions->get($index);
            $this->assertSame($interaction->getRouteKey(), $rawInteraction['id']);
        });

        $totalInteractions=$response->json('meta.total');
        $this->assertSame($interactions->count(), $totalInteractions);
    }
}
