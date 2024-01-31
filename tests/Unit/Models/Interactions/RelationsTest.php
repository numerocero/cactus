<?php

namespace Tests\Unit\Models\Interactions;

use App\Models\Interaction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class RelationsTest extends TestCase
{
    /** @test */
    public function it_belongs_to_a_customer()
    {
        $this->assertRelationExists(Interaction::class, 'customer', BelongsTo::class);
    }
}
