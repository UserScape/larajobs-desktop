<?php

namespace Database\Factories;

use App\Enums\FilterField;
use App\Enums\FilterOperation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Filter>
 */
class FilterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'field' => $this->faker->randomElement(FilterField::cases()),
            'operation' => $this->faker->randomElement(FilterOperation::cases()),
            'query' => $this->faker->word,
        ];
    }
}
