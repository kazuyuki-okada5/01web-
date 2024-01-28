<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use DateTime;  // 追加

class CreateListTable extends Migration
{
    public function up()
    {
        Schema::create('lists', function (Blueprint $table) {
            // テーブルの定義をここに追加
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->date('start_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->time('break_start_time')->nullable();
            $table->time('break_end_time')->nullable();
            $table->decimal('break_hours', 5, 2)->default(0);
            $table->decimal('total_hours', 5, 2)->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // 以下にBooksテーブルからデータを取得し、Listテーブルに挿入する処理を追加
        $booksData = DB::table('books')->select('name', 'start_date', 'start_time', 'end_time', 'break_start_time', 'break_end_time', 'created_at', 'updated_at')->get();

        foreach ($booksData as $data) {
            $breakStartTime = new DateTime($data->break_start_time);
            $breakEndTime = new DateTime($data->break_end_time);
            $breakHours = $breakEndTime->diff($breakStartTime)->h + ($breakEndTime->diff($breakStartTime)->i / 60);

            $startTime = new DateTime($data->start_time);
            $endTime = new DateTime($data->end_time);
            $totalHours = $endTime->diff($startTime)->h + ($endTime->diff($startTime)->i / 60) - $breakHours;

            DB::table('lists')->insert([
                'name' => $data->name,
                'start_date' => $data->start_date,
                'start_time' => $data->start_time,
                'end_time' => $data->end_time,
                'break_start_time' => $data->break_start_time,
                'break_end_time' => $data->break_end_time,
                'break_hours' => $breakHours,
                'total_hours' => $totalHours,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ]);
        }

        // booksテーブルが存在するか確認
        if (Schema::hasTable('books')) {
            // booksテーブルからデータを取得
            $booksData = DB::table('books')->select('name', 'start_date', 'start_time', 'end_time', 'break_start_time', 'break_end_time', 'created_at', 'updated_at')->get();

            foreach ($booksData as $data) {
                // データの処理
                // ...
            }
        }
    }

    public function down()
    {
        // ロールバックの処理
        Schema::dropIfExists('lists');
    }
}