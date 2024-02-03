<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        $startDate = $this->faker->date;
        $startTime = $this->faker->time;
        $endTime = $this->faker->time;
        $breakStartTime = "{$startDate} {$this->faker->time}";
        $breakEndTime = "{$startDate} {$this->faker->time}";

        return [
            'name' => $this->faker->sentence,
            'user_id' => User::factory(),
            'start_date' => $startDate,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'break_start_time' => $breakStartTime,
            'break_end_time' => $breakEndTime,
            'break_seconds' => $this->faker->randomFloat(2, 0, 8),
            'total_seconds' => $this->faker->randomFloat(2, 0, 8),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}