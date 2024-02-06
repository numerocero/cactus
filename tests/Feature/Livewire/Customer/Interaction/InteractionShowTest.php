<?php

namespace Livewire\Customer\Interaction;

use App\Constants\RouteParameters;
use App\Livewire\Customer\InteractionShow;
use App\Models\Interaction;
use Livewire\Livewire;
use Tests\TestCase;

class InteractionShowTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        $interaction = Interaction::factory()->create();
        Livewire::test(InteractionShow::class,
            [RouteParameters::CUSTOMER => $interaction->customer, RouteParameters::INTERACTION => $interaction])
            ->assertStatus(200);
    }

    /** @test */
    public function it_applies_verification_rules()
    {
        $this->markTestIncomplete('TODO');
    }

    /** @test */
    public function it_updates_an_interaction()
    {
        $this->markTestIncomplete('TODO');
    }
}
