<?php

namespace Tests\Unit\Http\Resources\Models;

use App\Http\Resources\Models\UserResource;
use App\Models\User;
use Mockery;
use Request;
use Tests\TestCase;

class UserResourcetest extends TestCase
{
    /** @test */
    public function it_has_correct_fields()
    {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('getRouteKey')->withNoArgs()->once()->andReturn($id = 'id');
        $user->shouldReceive('getAttribute')->with('name')->once()->andReturn($name = 'name');
        $user->shouldReceive('getAttribute')->with('email')->once()->andReturn($email = 'email@example.com');

        $resource = new UserResource($user);
        $response = $resource->toArray(Request::instance());

        $data = [
            'id'    => $id,
            'name'  => $name,
            'email' => $email,
        ];

        $this->assertEquals($data, $response);
    }
}
