<?php

namespace Livewire\Customer\Interaction;

use App\Constants\RouteParameters;
use App\Livewire\Customer\InteractionCreate;
use App\Models\Customer;
use Livewire\Livewire;
use Tests\TestCase;

class InteractionCreateTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        $customer = Customer::factory()->create();
        Livewire::test(InteractionCreate::class, [RouteParameters::CUSTOMER => $customer])->assertStatus(200);
    }

    /** @test */
    public function it_applies_verification_rules()
    {
        $this->markTestIncomplete('TODO');
    }

    /** @test */
    public function it_stores_an_interaction()
    {
        $this->markTestIncomplete('TODO');
    }
}
