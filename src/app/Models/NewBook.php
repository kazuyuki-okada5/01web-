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

    // TotalBreakSecondsモデルとのリレーションを定義
    public function totalBreakSeconds()
    {
        return $this->hasOne(TotalBreakSeconds::class, 'user_id', 'user_id')
            ->where('name', $this->name) // nameカラムが一致する条件を追加
            ->where('login_date', $this->login_date) // login_dateカラムが一致する条件を追加
            ->selectRaw('SUM(total_break_seconds) as total_break_seconds') // total_break_secondsカラムの合計を取得
            ->groupBy('user_id', 'name', 'login_date'); // グループ化して集計
    }
}