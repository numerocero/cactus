<?php

namespace Tests\Unit\Http\Resources\Api\Auth;

use App\Http\Resources\Api\Auth\BaseResource;
use App\Models\User;
use Mockery;
use Request;
use Tests\TestCase;

class BaseResourceTest extends TestCase
{
    /** @test */
    public function it_has_correct_fields()
    {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('getRouteKey')->withNoArgs()->once()->andReturn($id = 'id');
        $user->shouldReceive('getAttribute')->with('name')->once()->andReturn($name = 'name');
        $user->shouldReceive('getAttribute')->with('email')->once()->andReturn($email = 'email@example.com');
        $token = 'token';

        $resource = new BaseResource($user, $token);
        $response = $resource->toArray(Request::instance());

        $data = [
            'id'    => $id,
            'name'  => $name,
            'email' => $email,
            'token' => $token,
        ];

        $this->assertEquals($data, $response);
    }
}
