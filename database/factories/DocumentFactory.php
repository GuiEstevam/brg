<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'file_path' => $this->faker->filePath(),
            'document_type' => $this->faker->randomElement(['cnh', 'crlv', 'photocheck', 'rg', 'proof_of_residence']),
            'original_name' => $this->faker->word . '.pdf',
            'mime_type' => 'application/pdf',
            'size' => $this->faker->numberBetween(10000, 5000000),
            'expiration_date' => $this->faker->optional()->date(),
            'status' => 'pending_validation',
            'owner_id' => 1, // Ajuste conforme uso real
            'owner_type' => 'App\\Models\\Driver',
            'uploaded_by_user_id' => User::factory(),
            'validated_by_user_id' => User::factory(),
        ];
    }
}
