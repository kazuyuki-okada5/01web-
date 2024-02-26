<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NewBook;

class TotalBreakSeconds extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'login_date',
        
    ];

    // ユーザーとのリレーションを定義
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function newBook()
    {
        return $this->belongsTo(NewBook::class, 'user_id', 'user_id')->where('login_date', $this->login_date)->where('name', $this->name);
    
        return $this->hasOne(TotalBreakSeconds::class, 'user_id', 'user_id')
            ->where('name', $this->name) // nameカラムが一致する条件を追加
            ->where('login_date', $this->login_date) // login_dateカラムが一致する条件を追加
            ->selectRaw('SUM(total_break_seconds) as total_break_seconds') // total_break_secondsカラムの合計を取得
            ->groupBy('user_id', 'name', 'login_date'); // グループ化して集計
    }
}