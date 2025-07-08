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
            'renach_number' => $this->faker->numerify('##########'),
            'register_number' => $this->faker->numerify('##########'),
            'category' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E', 'AB', 'AC']),
            'issuance_date' => $this->faker->date(),
            'expiry_date' => $this->faker->date(),
            'performs_paid_activity' => $this->faker->randomElement(['Sim', 'Não']),
            'moop_course' => $this->faker->word,
            'local_issuance' => $this->faker->city,
            'security_number' => $this->faker->numerify('##########'),
            'ordinance' => $this->faker->word,
            'restriction' => $this->faker->word,
            'mirror_number' => $this->faker->numerify('######'),
            'total_points' => $this->faker->numberBetween(0, 40),
            'status_cnh_image' => $this->faker->word,
            'status_message_cnh_image' => $this->faker->sentence,
            'validation_status_document_image' => $this->faker->numberBetween(0, 1),
            'validation_status_cnh' => $this->faker->numberBetween(0, 1),
            'validation_status_security_number' => $this->faker->numberBetween(0, 1),
            'validation_status_uf' => $this->faker->numberBetween(0, 1),
            'validation_image_message' => $this->faker->sentence,
        ];
    }
}
