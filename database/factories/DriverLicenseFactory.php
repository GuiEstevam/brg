<?php

namespace Database\Factories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverLicenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'driver_id' => Driver::factory(),
            'renach_number' => $this->faker->optional()->numerify('##########'),
            'register_number' => $this->faker->optional()->numerify('##########'),
            'category' => $this->faker->optional()->randomElement(['A', 'B', 'C', 'D', 'E', 'AB', 'AC']),
            'issuance_date' => $this->faker->optional()->date(),
            'expiry_date' => $this->faker->optional()->date(),
            'performs_paid_activity' => $this->faker->optional()->randomElement(['Sim', 'Não']),
            'moop_course' => $this->faker->optional()->word,
            'local_issuance' => $this->faker->optional()->city,
            'security_number' => $this->faker->optional()->numerify('##########'),
            'ordinance' => $this->faker->optional()->word,
            'restriction' => $this->faker->optional()->word,
            'mirror_number' => $this->faker->optional()->numerify('######'),
            'total_points' => $this->faker->numberBetween(0, 40),
            'status_cnh_image' => $this->faker->optional()->word,
            'status_message_cnh_image' => $this->faker->optional()->sentence,
            'validation_status_document_image' => $this->faker->optional()->numberBetween(0, 1),
            'validation_status_cnh' => $this->faker->optional()->numberBetween(0, 1),
            'validation_status_security_number' => $this->faker->optional()->numberBetween(0, 1),
            'validation_status_uf' => $this->faker->optional()->numberBetween(0, 1),
            'validation_image_message' => $this->faker->optional()->sentence,
        ];
    }
}
