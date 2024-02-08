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
        $login_date = $this->faker->date; // 仮の日付生成

        return [
            'name' => $this->faker->sentence,
            'user_id' => User::factory(),
            'login_date' => $login_date,
            'start_time' => $this->faker->time,
            'end_time' => $this->faker->time,
            'break_start_time' => $this->faker->time,
            'break_end_time' => $this->faker->time,
            'break_seconds' => $this->faker->randomFloat(2, 0, 8),
            'total_seconds' => $this->faker->randomFloat(2, 0, 8),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}