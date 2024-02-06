<?php

namespace Livewire\Customer;

use App\Constants\RouteParameters;
use App\Livewire\CustomerShow;
use App\Models\Customer;
use App\Models\Interaction;
use Livewire\Livewire;
use Tests\TestCase;

class CustomerShowTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        $customer = Customer::factory()->create();
        Livewire::test(CustomerShow::class, [RouteParameters::CUSTOMER=>$customer])
            ->assertStatus(200);
    }

    /** @test */
    public function it_renders_successfully_with_interactions()
    {
        $customer = Customer::factory()->create();
        Interaction::factory()->usingCUstomer($customer)->count(10)->create();
        Livewire::test(CustomerShow::class, [RouteParameters::CUSTOMER=>$customer])
            ->assertStatus(200);
    }

    /** @test */
    public function it_applies_verification_rules()
    {
        $this->markTestIncomplete('TODO');
    }

    /** @test */
    public function it_updates_a_customer()
    {
        $this->markTestIncomplete('TODO');
    }
}
