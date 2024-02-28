<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\NewBook;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Bookテーブルにダミーデータを作成する
        Book::factory(30)->create();
        NewBook::factory()->count(30)->create();
    }
}