<?php

namespace Tests\Unit\Http\Resources\Models;

use App\Http\Resources\Models\CustomerResource;
use App\Models\Customer;
use App\Models\Interaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Mockery;
use Request;
use Tests\TestCase;

class CustomerResourceTest extends TestCase
{
    /** @test */
    public function it_has_correct_fields()
    {
        $interaction = Mockery::mock(Interaction::class);
        $interaction->shouldReceive('getAttribute')->with('created_at')->once()->andReturn($date = Carbon::now());

        $interactions = Collection::make([$interaction]);

        $customer = Mockery::mock(Customer::class);
        $customer->shouldReceive('getRouteKey')->withNoArgs()->once()->andReturn($id = 'uuid');
        $customer->shouldReceive('getAttribute')->with('name')->once()->andReturn($name = 'name');
        $customer->shouldReceive('getAttribute')->with('email')->once()->andReturn($email = 'test@example.com');
        $customer->shouldReceive('getAttribute')->with('interactions')->once()->andReturn($interactions);

        $resource = new CustomerResource($customer);
        $response = $resource->toArray(Request::instance());

        $data = [
            'id'    => $id,
            'name'  => $name,
            'email' => $email,
            'last_interaction_date' => $date,
        ];

        $this->assertEquals($data, $response);
    }

    /** @test */
    public function it_has_correct_fields_with_null_values()
    {
        $interactions = Collection::make();

        $customer = Mockery::mock(Customer::class);
        $customer->shouldReceive('getRouteKey')->withNoArgs()->once()->andReturn($id = 'uuid');
        $customer->shouldReceive('getAttribute')->with('name')->once()->andReturn($name = 'name');
        $customer->shouldReceive('getAttribute')->with('email')->once()->andReturn($email = 'test@example.com');
        $customer->shouldReceive('getAttribute')->with('interactions')->once()->andReturn($interactions);

        $resource = new CustomerResource($customer);
        $response = $resource->toArray(Request::instance());

        $data = [
            'id'    => $id,
            'name'  => $name,
            'email' => $email,
            'last_interaction_date' => null,
        ];

        $this->assertEquals($data, $response);
    }
}
