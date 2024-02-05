<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class CreateBooksTable extends Migration
{
    public function up()
{
    // 'books' テーブルが存在しない場合は作成
    if (!Schema::hasTable('books')) {
    Schema::create('books', function (Blueprint $table) {
        $table->id();
        $table->bigInteger('user_id')->unsigned();
        $table->string('name');
        $table->date('login_date');
        $table->time('start_time')->nullable();
        $table->time('end_time')->nullable();
        $table->time('break_start_time')->nullable();
        $table->time('break_end_time')->nullable();
        $table->integer('break_seconds')->nullable();
        $table->integer('total_seconds')->nullable();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->timestamps();
    });
}
    }

    public function down()
{
    // 'books' テーブルが存在する場合は削除
    if (Schema::hasTable('books')) {
    Schema::dropIfExists('books');
}
        /*
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('break_hours');
            $table->dropColumn('total_hours');
        });
        */
    }
}

