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

    // 新しいレコードが作成され、かつbreak_secondsにデータがセットされた時にtotal_break_secondsを更新
    protected static function boot()
    {
        parent::boot();

        static::created(function ($newBook) {
            if ($newBook->break_seconds !== null) {
                // 対応する TotalBreakSeconds レコードを取得または作成
                $totalBreakSeconds = TotalBreakSeconds::firstOrNew([
                    'user_id' => $newBook->user_id,
                    'name' => $newBook->name,
                    'login_date' => $newBook->login_date,
                ]);
                
                // 既存の合計値に新しいレコードのbreak_secondsを加算
                $totalBreakSeconds->total_break_seconds += $newBook->break_seconds;
                $totalBreakSeconds->save();
            }
        });
    }

    // ユーザーとのリレーションを定義
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // TotalBreakSeconds モデルとのリレーションを定義
    public function totalBreakSeconds()
    {
        return $this->hasOne(TotalBreakSeconds::class, 'user_id', 'user_id')
            ->where('name', $this->name)
            ->where('login_date', $this->login_date);
    }
}
