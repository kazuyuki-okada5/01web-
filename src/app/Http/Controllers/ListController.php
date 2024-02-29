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
        // 指定された日付に一致するデータを取得
        $books = Book::whereDate('login_date', $currentDate)->paginate(5);

        // ビューにデータを渡す
        return view('author.attendees', ['books' => $books, 'currentDate' => $currentDate]);
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
        $books = Book::whereDate('login_date', $date)->paginate(5);

        // ビューにデータを渡す
        return view('author.attendees', ['books' => $books, 'currentDate' => $date]);
    }

    // 前日・翌日に移動するためのメソッド
    public function moveDate($direction, $currentDate)
    {
        // 前日・翌日に移動するロジックを実装
        $carbonDate = Carbon::parse($currentDate);
        $newDate = ($direction == 'prev') ? $carbonDate->subDay() : $carbonDate->addDay();

        return redirect()->route('attendees.showByDate', ['currentDate' => $newDate->toDateString()]);
    }

    
    // ページネーションを含むデータの取得
public function index(Request $request)
{
    // リクエストから検索条件を取得
    $currentDate = $request->input('currentDate', now()->toDateString());

    // 一日前の日付を計算して $prevDate に代入する
    $prevDate = Carbon::parse($currentDate)->subDay()->toDateString();

    // 指定された日付に一致するデータのみを取得
    $books = Book::whereDate('login_date', $currentDate)
                ->whereNotNull('start_time')
                ->whereNotNull('end_time')
                ->orderBy('login_date', 'asc')
                ->paginate(5);

    // 検索結果がない場合は空のコレクションを代入
    // または何も代入せずにそのままビューに渡す
    // if ($books->isEmpty()) {
    //     $books = collect(); // 空のコレクションを代入
    // }

    // 検索結果と$prevDateをビューに渡す
    return view('author.attendees', compact('books', 'currentDate', 'prevDate'));
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