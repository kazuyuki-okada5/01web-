<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;  // Book モデルも合わせて修正
use Carbon\Carbon;

class ListController extends Controller
{
    // コントローラー全体に認証ミドルウェアを適用
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showByDate($currentDate)
    {
    // ログ出力
    \Log::info('SQL Query: ' . Book::whereDate('start_date', $currentDate)->toSql());
    \Log::info('Query Builder: ' . Book::whereDate('start_date', $currentDate)->get());
    // 指定された日付に基づいてデータを取得
    $books = Book::whereDate('start_date', $currentDate)->get();


    // 他の必要な処理

    return view('author.attendees', [
        'books' => $books,
        'currentDate' => $currentDate,
        // 他のデータを必要に応じて渡す
    ]);
    
    }
    // スタンプ画面を表示するメソッド
    public function book()
    {
        return view('author.attendees');
    }

 // 任意の日付に基づいてデータを取得するメソッド
    public function getAttendeesByDate($date)
    {
        // 日付を指定してデータを取得
        $books = Book::whereDate('start_date', $date)->paginate(5);

        // ビューにデータを渡す
        return view('author.attendees', ['books' => $books, 'currentDate' => $date]);
    }

    // 前日・後日に移動するためのメソッド
    public function moveDate($direction, $currentDate)
    {
        // 前日・後日に移動するロジックを実装
        $carbonDate = Carbon::parse($currentDate);
        $newDate = ($direction == 'prev') ? $carbonDate->subDay() : $carbonDate->addDay();

        return redirect()->route('attendees.by.date', ['date' => $newDate->toDateString()]);
    }

    // ページネーションを含むデータの取得
    public function index()
    {
    // ページネーションを追加してデータを取得
        $books = Book::paginate(5);
        
        // 現在の日付を取得
        $currentDate = now()->toDateString();

        // ビューにデータを渡す
        return view('author.attendees', ['books' => $books, 'currentDate' => $currentDate]);
    }

    public function relate(Request $request)
    {
        $books = Book::all(); // Book モデルを使用するように修正
        return view('author.attendees', ['books' => $books]);
    }

    public function meaningfulMethodName() 
    {
        $books = Book::with('user')->get(); // Book モデルを使用するように修正

        foreach ($books as $book) { 
            $userName = $book->user->name;
        }

        return view('author.attendees', ['books' => $books]);
    }
}