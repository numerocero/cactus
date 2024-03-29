<?php

namespace Tests;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;
use JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function assertHasExpectedColumns(string $tableName, array $expectedColumns): void
    {
        $missing = array_diff($expectedColumns, Schema::getColumnListing($tableName));

        $this->assertTrue(Schema::hasColumns($tableName, $expectedColumns),
            "Columns missing in table $tableName: " . implode(', ', $missing));

        $diff = array_diff(Schema::getColumnListing($tableName), $expectedColumns);

        $this->assertCount(0, $diff, "Columns mismatch in table $tableName: " . implode(', ', $diff));
    }

    public function assertRelationExists(string $class, string $method, string $relationType): void
    {
        $constraint = static::callback(function($class) use ($method, $relationType) {
            try {
                $relation = new \ReflectionMethod($class, $method);
            } catch (\ReflectionException $exception) {
                static::fail("{$class} does not have relation method `{$method}`");
            }

            return $relation->getReturnType()->getName() === $relationType;
        });

        static::assertThat($class, $constraint,
            "{$class} does not have relation `{$method}` of type `{$relationType}`");
    }

    protected function login(?Authenticatable $authenticatable = null): Authenticatable
    {
        $authenticatable ??= User::factory()->create();

        $token = JWTAuth::fromUser($authenticatable);
        $this->token = $token;
        $this->withHeaders(['Authorization' => 'Bearer ' . $token]);
        $this->actingAs($authenticatable);

        return $authenticatable;
    }

}
