<?php

namespace Database\Factories;

use App\Models\TotalBreakSeconds;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class TotalBreakSecondsFactory extends Factory
{
    protected $model = TotalBreakSeconds::class;

    public function definition()
    {
        return [
            'book_id' => Book::factory()->create()->id,
            'total_break_seconds' => $this->faker->numberBetween(0, 3600),
        ];
    }
}