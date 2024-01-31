<?php

namespace Tests\Unit\Models;

use App\Models\Interaction;
use Tests\TestCase;

class InteractionTest extends TestCase
{
    /** @test */
    public function it_has_expected_columns()
    {
        $tableName = (new Interaction())->getTable();
        $this->assertHasExpectedColumns($tableName, [
            'id',
            'customer_id',
            'description',
            'created_at',
            'updated_at',
        ]);
    }
}
