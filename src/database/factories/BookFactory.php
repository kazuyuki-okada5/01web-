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
        // 直近の2〜3日の範囲で日付を生成
        $login_date = $this->faker->dateTimeBetween('-2 days', '-1 days')->format('Y-m-d');

        return [
            'name' => $this->faker->sentence,
            'user_id' => User::factory(),
            'login_date' => $login_date,
            'start_time' => $this->faker->time,
            'end_time' => $this->faker->time,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}