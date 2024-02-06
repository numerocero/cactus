<?php

namespace Livewire\Customer\Interaction;

use App\Constants\RouteParameters;
use App\Livewire\Customer\InteractionIndex;
use App\Models\Customer;
use Livewire\Livewire;
use Tests\TestCase;

class InteractionIndexTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        $customer = Customer::factory()->create();
        Livewire::test(InteractionIndex::class, [RouteParameters::CUSTOMER => $customer])->assertStatus(200);
    }

    /** @test */
    public function it_deletex_an_interaction()
    {
        $this->markTestIncomplete('TODO');
    }
}
