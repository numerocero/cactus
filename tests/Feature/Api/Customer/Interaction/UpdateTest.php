<?php

namespace Tests\Feature\Api\Customer\Interaction;

use App\Constants\RequestKeys;
use App\Constants\RouteNames;
use App\Models\Interaction;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use URL;

class UpdateTest extends TestCase
{
    protected string $routeName = RouteNames::API_CUSTOMER_INTERACTION_UPDATE;

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
    public function it_updates_an_interaction()
    {
        $interaction = Interaction::factory()->create();
        $route       = URL::route($this->routeName, [$interaction->customer, $interaction]);

        $this->login();
        $response = $this->patch($route, [
            RequestKeys::DESCRIPTION => 'description',
        ]);
        $response->assertStatus(Response::HTTP_OK);

        $data = $response->json('data');
        $interaction->refresh();
        $this->assertSame($interaction->getRouteKey(), $data['id']);
        $this->assertSame($interaction->description, $data['description']);
        $this->assertSame($interaction->created_at->toIsoString(), $data['created_at']);

        $tableName = (new Interaction())->getTable();
        $this->assertDatabaseHas($tableName, [
            'id'          => $data['id'],
            'description' => $data['description'],
            'created_at'  => $data['created_at'],
        ]);
    }
}
