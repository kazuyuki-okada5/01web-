<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 'users' テーブルが存在しない場合は作成
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // 'lists' テーブルが存在しない場合は作成
        if (!Schema::hasTable('lists')) {
            Schema::create('lists', function (Blueprint $table) {
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
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 'lists' テーブルに外部キーが存在し、その外部キーを削除
        if (Schema::hasTable('lists') && Schema::hasColumn('lists', 'user_id')) {
            Schema::table('lists', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        }

        // 'lists' テーブルを削除
        Schema::dropIfExists('lists');

        // 'users' テーブルを削除
        Schema::dropIfExists('users');
    }
}
