<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Book;

class UpdateDatabaseOnLogin
{
    public function handle($request, Closure $next)
    {
        // ユーザーがログインした直後にデータベースを更新する処理
        if (auth()->check() && !$request->session()->has('startWorkFlag')) {
        // ユーザーがログインしており、セッションにフラグが存在しない場合のみ処理を行う
        $this->updateDatabaseOnLogin();

        // ログイン直後にセッションにフラグを保存
        $request->session()->put('startWorkFlag', true);
    }
        return $next($request);
    }

    private function updateDatabaseOnLogin()
    {
        $user = auth()->user();

        if ($user) {
            $today = now()->toDateString();

            $existingRecord = Book::where('name', $user->name)->where('login_date', $today)->first();

            if (!$existingRecord) {
                // レコードが存在しない場合、新しいレコードを作成
                Book::create([
                    'name' => $user->name,
                    'login_date' => $today,
                    'user_id' => $user->id,
                ]);
            } else {
                // 既存の処理に変更が必要
                // ここで新しいデータを設定してデータベースを更新
                // $existingRecord->startWork();
                $existingRecord->login_date = now()->toDateString();
                $existingRecord->start_time = now()->toTimeString();
                $existingRecord->save();
                
                // ログを追加するかどうかの判断は logActivity メソッド内で行うのでここでは何もしない
            }
        }
    }
}