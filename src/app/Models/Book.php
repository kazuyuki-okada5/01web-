<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'login_date',
        'start_time',
        'end_time',
        'break_start_time',
        'break_end_time',
        'user_id',
        'break_seconds',
        'total_seconds',
    ];


public function getEndTimeAttribute($value)
{
    // 時刻をそのまま取得する
    return $value;
}

public function getBreakStartTimeAttribute($value)
{
    // 時刻をそのまま取得する
    return $value;
}

public function getBreakEndTimeAttribute($value)
{
    // 時刻をそのまま取得する
    return $value;
}

    public $timestamps = true;

    public static $rules = [
        'name' => 'required|string',
        // 他の必要なバリデーションルールを追加
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function boot()
{
    parent::boot();

    static::saving(function ($book) {
        $book->calculateTotalHours();
    });
}

    


    public function calculateTotalHours()
{
    if ($this->start_time && $this->end_time && $this->break_start_time && $this->break_end_time) {
        $start = strtotime($this->start_time);
        $end = strtotime($this->end_time);
        $breakStart = strtotime($this->break_start_time);
        $breakEnd = strtotime($this->break_end_time);

        // break_hours および total_hours を break_seconds および total_seconds に修正
        $breakSeconds = $breakEnd - $breakStart;
        $totalSeconds = $end - $start - $breakSeconds;

        // 修正: total_seconds の値を更新
        $this->setAttribute('total_seconds', $totalSeconds);
    }
}
    // アクセサ: 休憩時間を「h:m:s」のフォーマットに変換
public function getBreakHoursFormattedAttribute()
{
    return $this->formatTime($this->break_seconds);
}

// アクセサ: 合計時間を「H:M:S」のフォーマットに変換
public function getTotalHoursFormattedAttribute()
{
    return $this->formatTime($this->total_seconds);
}

// 秒を「H:M:S」のフォーマットに変換するヘルパー関数
private function formatTime($seconds)
{
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;

    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}
}