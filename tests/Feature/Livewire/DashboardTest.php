<?php

namespace Livewire;

use App\Livewire\Dashboard;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Dashboard::class)
            ->assertStatus(200);
    }

    /** @test */
    public function it_applies_verification_rules()
    {
        $this->markTestIncomplete('TODO');
    }

    /** @test */
    public function it_deletes_a_customer()
    {
        $this->markTestIncomplete('TODO');
    }

    /** @test */
    public function it_stores_a_customer()
    {
        $this->markTestIncomplete('TODO');
    }
}
