<?php

namespace Database\Factories;

use App\Models\NewBook;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewBookFactory extends Factory
{
    protected $model = NewBook::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'user_id' => User::factory(),
            'login_date' => $this->faker->date,
            'break_start_time' => $this->faker->time,
            'break_end_time' => $this->faker->time,
            'break_seconds' => $this->faker->numberBetween($min = 1, $max = 3600),
        ];
    }
}