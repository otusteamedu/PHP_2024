<?php

namespace Database\Factories;

use App\Models\Court;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Court>
 */
class CourtFactory extends Factory
{

    protected $model = Court::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'address' => 'required|string',
            'region_id' => 'string',
            'cass_region' => 'required|string',
            'general_type_id' => 'required|string',
            'phone' => 'required',
            'email' => 'required|email',
            'site' => 'required|url',
        ];
    }
}
