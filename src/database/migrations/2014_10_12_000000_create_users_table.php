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
         // 外部キーの追加
        Schema::table('lists', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    // authors テーブルに user_id カラムが存在し、その外部キーが設定されているか確認
    if (Schema::hasColumn('authors', 'user_id')) {
        // authors テーブルの外部キーを削除
        Schema::table('authors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }

    // authors テーブルを削除
    Schema::dropIfExists('authors');
}
}
