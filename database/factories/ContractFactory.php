<?php

namespace Database\Factories;

use App\Models\Enterprise;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    public function definition(): array
    {
        return [
            'enterprise_id' => Enterprise::factory(),
            'plan_name' => $this->faker->word . ' Plan',
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+1 year')->format('Y-m-d'),
            'status' => 'pending',
            'max_users' => $this->faker->numberBetween(1, 100),
            'max_queries' => $this->faker->numberBetween(100, 10000),
            'unlimited_queries' => false,
            'total_queries_used' => 0,
        ];
    }
}
