<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewBook extends Model
{
    use HasFactory;

    protected $table = 'new_books'; // 新しいテーブル名を指定

    protected $fillable = [
        'name',
        'login_date',
        'user_id',
        'break_start_time',
        'break_end_time',
        'break_seconds',
    ];

    // ユーザーとのリレーションを定義
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}