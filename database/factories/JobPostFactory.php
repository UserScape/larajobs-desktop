<?php

namespace Database\Factories;

use App\Models\JobCreator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPost>
 */
class JobPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle,
            'job_creator_id' => JobCreator::factory(),
            'link' => $this->faker->url,
            'category' => $this->faker->jobTitle,
            'location' => $this->faker->city,
            'type' => $this->faker->randomElement(['Full Time', 'Part Time', 'Contract']),
            'salary' => $this->faker->randomElement(['£60,000', '£70,000', '£80,000']),
            'company' => $this->faker->company,
            'company_logo' => $this->faker->imageUrl(),
            'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
