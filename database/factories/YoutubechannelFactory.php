<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class YoutubechannelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $videos = [];
        $count = $this->faker->randomDigitNotNull;

        for ($i = 0; $i < $count; $i++) {
            $videos[] = [
                'title' => $this->faker->name,
                'videourl' => 'https://www.youtube.com/watch?v=' . $this->faker->regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}'),
                'like' => rand(0, 100),
                'dislikes' => rand(0, 100),
            ];
        }

        return [
            'name' => $this->faker->name,
            'url' => 'https://www.youtube.com/channel/' . $this->faker->regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}'),
            'videos' => $videos
        ];

    }
}
