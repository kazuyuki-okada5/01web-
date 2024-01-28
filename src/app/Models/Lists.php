<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    use HasFactory;
    protected $table = 'lists';
    
    public function book()
    {
        return $this->hasOne(Book::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class); // 修正: モデル名を正しく指定
    }

     public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); // 修正: User モデルが存在する場合は正しいモデル名に修正
    }
}
