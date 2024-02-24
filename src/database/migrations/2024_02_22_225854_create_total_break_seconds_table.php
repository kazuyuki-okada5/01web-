<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTotalBreakSecondsTable extends Migration
{
    public function up()
    {
        Schema::create('total_break_seconds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('name');
            $table->date('login_date');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('total_break_seconds', function (Blueprint $table) {
            // テーブルが存在し、外部キー制約がある場合のみ削除する
            if (Schema::hasTable('total_break_seconds') && Schema::hasColumn('total_break_seconds', 'user_id')) {
                $table->dropForeign(['user_id']);
            }
        });

        Schema::dropIfExists('total_break_seconds');
    }
}
