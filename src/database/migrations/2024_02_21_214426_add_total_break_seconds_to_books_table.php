<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalBreakSecondsToBooksTable extends Migration
{
    public function up()
    {
        // 既存のbooksテーブルにtotal_break_secondsカラムが存在する場合のみ追加する
        if (!Schema::hasColumn('books', 'total_break_seconds')) {
            Schema::table('books', function (Blueprint $table) {
                $table->integer('total_break_seconds')->nullable()->after('break_seconds');
            });
        }

        // 既存のレコードの total_break_seconds を計算して更新する
        $books = \App\Models\Book::all();
        foreach ($books as $book) {
            if ($book->break_start_time && $book->break_end_time) {
                $totalBreakSeconds = $book->break_seconds + $book->break_start_time->diffInSeconds($book->break_end_time);
                $book->update(['total_break_seconds' => $totalBreakSeconds]);
            }
        }
    }

    public function down()
    {
        // マイグレーションをロールバックする場合の処理をここに記述する
    }
}
