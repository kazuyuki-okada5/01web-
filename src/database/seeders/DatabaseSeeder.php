<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Bookテーブルにダミーデータを作成する
        Book::factory(30)->create();
    }
}