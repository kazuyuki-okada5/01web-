<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalBreakSeconds extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'login_date',
        'user_id',
        'break_seconds',
    ];

    // ユーザーとのリレーションを定義
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function book()
    {
        return $this->belongsTo(Book::class, 'user_id', 'user_id')->where('login_date', $this->login_date);
    }
}