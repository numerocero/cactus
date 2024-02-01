<?php

namespace Tests\Feature\Api\Customer\Interaction;

use App\Constants\RouteNames;
use App\Models\Interaction;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use URL;

class ShowTest extends TestCase
{
    protected string $routeName = RouteNames::API_CUSTOMER_INTERACTION_SHOW;

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
    public function it_shows_an_interaction()
    {
        $interaction = Interaction::factory()->create();
        $route = URL::route($this->routeName, [$interaction->customer, $interaction]);

        $this->login();
        $response = $this->get($route);
        $response->assertStatus(Response::HTTP_OK);

        $data = $response->json('data');
        $this->assertSame($interaction->getRouteKey(), $data['id']);
        $this->assertSame($interaction->description, $data['description']);
        $this->assertSame($interaction->created_at->toIsoString(), $data['created_at']);
    }
}
