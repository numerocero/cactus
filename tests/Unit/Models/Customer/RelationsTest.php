<?php

namespace Tests\Unit\Models\Customer;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class RelationsTest extends TestCase
{
    /** @test */
    public function it_has_many_interactions()
    {
        $this->assertRelationExists(Customer::class, 'interactions', HasMany::class);
    }
}
