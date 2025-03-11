<?php

namespace Database\Factories\Arena;

use Domain\Arena\Models\Arena;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArenaFactory extends Factory
{
    protected $model = Arena::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
