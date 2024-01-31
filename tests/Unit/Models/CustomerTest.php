<?php

namespace Tests\Unit\Models;

use App\Models\Customer;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    /** @test */
    public function it_has_expected_column()
    {
        $tableName = (new Customer())->getTable();
        $this->assertHasExpectedColumns($tableName, [
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ]);
    }
}
