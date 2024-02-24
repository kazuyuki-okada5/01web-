<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewBook;
use App\Models\TotalBreakSeconds;

class TotalBreakSecondController extends Controller
{
    public function calculateAndSaveTotalBreakSeconds()
{
    try {
        // NewBookテーブルからデータを取得し、リレーションを使って合計値を取得
        $newBooks = NewBook::all();
        dd($newBooks); // デバッグ: 変数 $newBooks の値を確認する
        foreach ($newBooks as $newBook) {
            $totalBreakSeconds = $newBook->totalBreakSeconds ? $newBook->totalBreakSeconds->total_break_seconds : 0;

            // TotalBreakSecondsテーブルにデータを保存
            TotalBreakSeconds::create([
                'user_id' => $newBook->user_id,
                'name' => $newBook->name,
                'login_date' => $newBook->login_date,
                'total_break_seconds' => $totalBreakSeconds
            ]);
        }
    } catch (\Exception $e) {
        // エラーハンドリング: エラーが発生した場合の処理
        \Log::error('Error in calculateAndSaveTotalBreakSeconds: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while calculating and saving total break seconds.'], 500);
    }
}
}
