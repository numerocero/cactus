<?php

namespace Livewire\Auth;

use App\Livewire\Auth\Login;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Login::class)
            ->assertStatus(200);
    }

    /** @test */
    public function it_log_in_a_user()
    {
        $this->markTestIncomplete('TODO');
    }

    /** @test */
    public function it_redirects_to_dashboard_on_successful_login()
    {
        $this->markTestIncomplete('TODO');
    }

    /** @test */
    public function it_flashes_an_error_on_failed_login()
    {
        $this->markTestIncomplete('TODO');
    }
}
