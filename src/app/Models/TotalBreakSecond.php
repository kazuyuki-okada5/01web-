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
    }
}