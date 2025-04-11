<?php

namespace Database\Factories;

use App\Infrastructure\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        return [
            'user_name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'body' => $this->faker->paragraph,
            'status' => 'new',
            'result' => null,
        ];
    }
}
