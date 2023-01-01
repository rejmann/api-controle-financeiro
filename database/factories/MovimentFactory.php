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
            'date' => $this->dateRandom(
                $this->faker->numberBetween(1, 2),
                $this->faker->numberBetween(1, 3),
                $this->faker->numberBetween(1, 31)
            ),
            'types_id' => Type::all()->random()->id
        ];
    }

    private function dateRandom(int $rangeYear, int $rangeMonth, int $rangeDay): string
    {
        return (new DateTime())->setDate($rangeYear, $rangeMonth, $rangeDay)->format('Y-m-d');
    }
}
