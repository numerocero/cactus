<?php

namespace Tests\Unit\Http\Resources\Models;

use App\Http\Resources\Models\InteractionResource;
use App\Models\Interaction;
use Mockery;
use Request;
use Tests\TestCase;

class InteractionResourceTest extends TestCase
{
    /** @test */
    public function it_has_correct_fields()
    {
        $interaction = Mockery::mock(Interaction::class);
        $interaction->shouldReceive('getRouteKey')->withNoArgs()->once()->andReturn($id = 'uuid');
        $interaction->shouldReceive('getAttribute')->with('description')->once()->andReturn($description = 'description');
        $interaction->shouldReceive('getAttribute')->with('created_at')->once()->andReturn($date = '2022-02-22');

        $resource = new InteractionResource($interaction);
        $response = $resource->toArray(Request::instance());

        $data = [
            'id'          => $id,
            'description' => $description,
            'created_at'  => $date,
        ];

        $this->assertEquals($data, $response);
    }
}
