<?php

namespace Tests\Feature\Api\Customer\Interaction;

use App\Constants\RouteNames;
use App\Models\Interaction;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use URL;

class DeleteTest extends TestCase
{
    protected string $routeName = RouteNames::API_CUSTOMER_INTERACTION_DELETE;

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
    public function it_deletes_an_interaction()
    {
        $interaction = Interaction::factory()->create();
        $route = URL::route($this->routeName, [$interaction->customer, $interaction]);

        $this->login();
        $response = $this->delete($route);
        $response->assertNoContent();

        $this->assertModelMissing($interaction);
    }
}
