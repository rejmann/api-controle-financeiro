<?php

namespace Database\Factories;

use App\Models\Type;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovimentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'description' => $this->faker->text(20),
            'value' => $this->faker->numberBetween(1, 999),
            'date' => $this->dateRandom(),
            'types_id' => Type::all()->random()->id
        ];
    }

    private function dateRandom(): string
    {
        $date = new DateTime();
        $date->setDate(
            $this->faker->numberBetween((int)$date->format('Y'), (int)$date->format('Y') + 1),
            $this->faker->numberBetween(1, 12),
            $this->faker->numberBetween(1, (int)$date->format('t'))
        );
        return $date->format('Y-m-d');
    }
}
