<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewBooksTable extends Migration
{
    public function up()
    {
        // 'new_books' テーブルが存在しない場合は作成
        if (!Schema::hasTable('new_books')) {
            Schema::create('new_books', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('user_id')->unsigned();
                $table->string('name');
                $table->date('login_date');
                $table->time('break_start_time')->nullable();
                $table->time('break_end_time')->nullable();
                $table->integer('break_seconds')->nullable();
                $table->integer('total_break_seconds')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        // 'new_books' テーブルが存在する場合は削除
        if (Schema::hasTable('new_books')) {
            Schema::dropIfExists('new_books');
        }
    }
}
