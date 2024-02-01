<?php

namespace Tests\Feature\Api\Customer;

use App\Constants\RequestKeys;
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

    private string $routeName = RouteNames::API_CUSTOMER_INDEX;

    /** @test */
    public function an_unauthenticated_user_cannot_proceed()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthenticationException::class);

        $route = URL::route($this->routeName);
        $this->getJson($route);
    }

    /** @test */
    public function it_displays_a_list_of_customers()
    {
        $customers = Customer::factory()->count(20)->create();
        $customers->each(function(Customer $customer) {
            Interaction::factory()->usingCustomer($customer)->count(2)->create();
        });

        $route = URL::route($this->routeName);

        $this->login();
        $response = $this->get($route);
        $response->assertStatus(Response::HTTP_OK);

        $data               = Collection::make($response->json('data'));
        $firstPageCustomers = $customers->values()->take(count($data));

        $data->each(function(array $rawCustomer, int $index) use ($firstPageCustomers) {
            $customer = $firstPageCustomers->get($index);
            $this->assertSame($customer->getRouteKey(), $rawCustomer['id']);
        });

        $totalCustomers     = $response->json('meta.total');
        $this->assertSame($customers->count(),$totalCustomers);
    }

    /** @test */
    public function it_can_filter_for_customers_by_name()
    {
        $specials = Collection::make();
        $specials->add(Customer::factory()->create(['name' => 'special']));
        $specials->add(Customer::factory()->create(['name' => 'other special']));
        Customer::factory()->count(4)->create();

        $route = URL::route($this->routeName, [
            RequestKeys::NAME => 'special',
        ]);

        $this->login();
        $response = $this->get($route);
        $response->assertStatus(Response::HTTP_OK);

        $data      = Collection::make($response->json('data'));
        $customers = $specials->values();

        $this->assertEqualsCanonicalizing($data->pluck('id'), $customers->pluck('id'));
    }

    /** @test */
    public function it_can_filter_for_customers_by_last_interaction_date()
    {
        $special = Interaction::factory()->create(['created_at' => '1974-08-21'])->customer;
        Customer::factory()->count(4)->create();

        $route = URL::route($this->routeName, [
            RequestKeys::DATE => '1974-08-21',
        ]);

        $this->login();
        $response = $this->get($route);
        $response->assertStatus(Response::HTTP_OK);

        $data = Collection::make($response->json('data'));

        $this->assertCount(1, $data);
        $this->assertEquals($special->getRouteKey(), $data->first()['id']);
    }

    /** @test */
    public function it_includes_validated_parameters_in_pagination_links()
    {
        $route = URL::route($this->routeName, [
            RequestKeys::NAME => $name = 'foo',
            RequestKeys::DATE => $date = '2022-02-22',
            'invalid'         => 'invalid',
        ]);

        $this->login();
        $response = $this->get($route);
        $response->assertStatus(Response::HTTP_OK);

        $parsedUrl = parse_url($response->json('links.first'));
        parse_str($parsedUrl['query'], $queryString);

        $this->assertArrayHasKey(RequestKeys::NAME, $queryString);
        $this->assertEquals($name, $queryString[RequestKeys::NAME]);
        $this->assertArrayHasKey(RequestKeys::DATE, $queryString);
        $this->assertEquals($date, $queryString[RequestKeys::DATE]);
        $this->assertArrayNotHasKey('invalid', $queryString);
    }
}
