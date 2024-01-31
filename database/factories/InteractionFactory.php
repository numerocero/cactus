<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interaction>
 */
class InteractionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'description' => $this->faker->text(250),
        ];
    }

    public function usingCustomer(Customer $customer): self
    {
        return $this->state(function() use ($customer) {
            return [
                'customer_id' => $customer,
            ];
        });
    }
}
