<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'start_time',
        'end_time',
        'break_start_time',
        'break_end_time',
    ];

    protected $dates = ['start_date', 'start_time', 'end_time'];

    public $timestamps = false;

    // ユーザー名と関連データを保存するメソッド
    public static function logActivity($name, $startDate, $startTime = null, $endTime = null, $breakStartTime = null, $breakEndTime = null)
    {
        return self::create([
            'name' => $name,
            'start_date' => $startDate,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'break_start_time' => $breakStartTime,
            'break_end_time' => $breakEndTime,
        ]);
    }
    public static $rules = [
    'name' => 'required|string',
    // 他の必要なバリデーションルールを追加
];

    // その他のモデルのロジックや関連を記述することができます
}
