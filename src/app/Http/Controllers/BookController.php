<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\NewBook; // 新しいモデルを追加
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class BookController extends Controller
{
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect('/login');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() // index メソッドを追加
    {
        $userName = auth()->user()->name;

        return view('your-view', compact('userName'));
    }

    public function stamp()
    {
        // 現在のレコードを取得
        $existingRecord = $this->getExistingRecord();

        // ユーザー名を取得
    $userName = auth()->user()->name;
    $today = now()->toDateString();

        // 勤務開始ボタンの状態
$startButtonDisabled = !$existingRecord || $existingRecord->start_time !== null;

// 勤務終了ボタンの状態
$endButtonDisabled = !$existingRecord || $existingRecord->start_time === null || $existingRecord->end_time !== null;

// 休憩開始ボタンの状態
$breakStartButtonDisabled = !$existingRecord || $existingRecord->start_time === null || $existingRecord->end_time !== null;

// 休憩終了ボタンの状態
$breakEndButtonDisabled = false;


        return view('book.stamp', compact('startButtonDisabled', 'endButtonDisabled', 'breakStartButtonDisabled', 'breakEndButtonDisabled'));
    }

    // 現在のレコードを取得するメソッド
    private function getExistingRecord()
    {
        $userName = auth()->user()->name;
        $today = now()->toDateString();

        return Book::where('name', $userName)
            ->where('login_date', $today)
            ->first();
    }

    public function create(Request $request)
    {
        $this->validate($request, Book::$rules);

        $form = $request->all();
        $form['user_id'] = auth()->user()->id;
        $form['login_date'] = now()->toDateString();

        Book::create($form);

        return redirect('/book');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $this->logActivity($request, 'store');

        $book = Book::create([
            'name' => $data['name'],
            'user_id' => auth()->id(),
        ]);

        // ログイン直後にデータベースを更新
        $this->updateDatabaseOnLogin($book);

        return redirect()->back();
    }

    private function updateDatabaseOnLogin(Book $book)
    {
        if (auth()->check()) {
            $userName = auth()->user()->name;
            $userId = auth()->id();
            $today = now()->toDateString();

             // デバッグメッセージを追加
            \Log::info('Updating database on login for user: '.$userName);

            // Book モデルを使用してデータベースから検索
            $existingRecord = Book::where('name', $userName)
                ->where('login_date', $today)
                ->first();

            if (!$existingRecord) {

                // デバッグメッセージを追加
                \Log::info('No existing record found. Creating new record...');

                // レコードが存在しない場合は新しいレコードを作成
                Book::create([
                    'name' => $userName,
                    'login_date' => $today,
                    'user_id' => $userId,
                ]);
            }
        }
    }

    public function logActivity(Request $request, $action)
{
    $userName = auth()->user()->name;
    $userId = auth()->id();
    $today = now()->toDateString();

    // 勤務開始のレコードを取得または作成
    $existingRecord = Book::where('name', $userName)
        ->where('login_date', $today)
        ->first();

    if (!$existingRecord) {
        $existingRecord = new Book();
        $existingRecord->name = $userName;
        $existingRecord->login_date = $today;
        $existingRecord->user_id = $userId;
        $existingRecord->save();
    }

    // ボタンのアクションに応じてデータを更新
    switch ($action) {
        case 'startWork':
            if (!$existingRecord->start_time) {
                \Log::info('Starting work for user: ' . $userName . ' at ' . now());
                $existingRecord->start_time = now();
            }
            break;
        case 'endWork':
            if (!$existingRecord->end_time) {
                \Log::info('Ending work for user: ' . $userName . ' at ' . now());
                $existingRecord->end_time = now();
            }
            break;
        case 'startBreak':
    // 休憩開始はNewBookテーブルに追加
    $breakRecord = new NewBook();
    $breakRecord->name = $userName;
    $breakRecord->login_date = $today;
    $breakRecord->user_id = $userId;
    $breakRecord->break_start_time = now();
    $breakRecord->save();
    break;
case 'endBreak':
    // 休憩終了はNewBookテーブルに追加
    $lastBreakRecord = NewBook::where('name', $userName)
        ->where('login_date', $today)
        ->whereNotNull('break_start_time')
        ->whereNull('break_end_time')
        ->orderBy('created_at', 'desc')
        ->first();

    if ($lastBreakRecord) {
        $lastBreakRecord->break_end_time = now();
        // 休憩時間の計算
        $breakStartTime = Carbon::parse($lastBreakRecord->break_start_time);
        $breakEndTime = Carbon::parse($lastBreakRecord->break_end_time);
        $breakSeconds = $breakEndTime->diffInSeconds($breakStartTime);
        $lastBreakRecord->break_seconds = $breakSeconds;
        $lastBreakRecord->save();
    }
    break;
    }

    $existingRecord->save();

    return redirect()->back();
}
}