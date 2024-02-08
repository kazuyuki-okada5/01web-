<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function stamp()
    {
        return view('book.stamp');
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

            // Book モデルを使用してデータベースから検索
            $existingRecord = Book::where('name', $userName)
                ->where('login_date', $today)
                ->first();

            if (!$existingRecord) {
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

        $existingRecord = Book::where('name', $userName)
            ->where('login_date', $today)
            ->first();

        $logData = [
            'name' => $userName,
            'login_date' => $today,
            'user_id' => $userId,
            'start_time' => optional($existingRecord)->start_time,
            'end_time' => optional($existingRecord)->end_time,
            'break_start_time' => optional($existingRecord)->break_start_time,
            'break_end_time' => optional($existingRecord)->break_end_time,
        ];

        if (!$existingRecord && $action !== 'startWork') {
            return redirect()->back();
        }

        if ($existingRecord) {
            switch ($action) {
                case 'startWork':
                    if (!$existingRecord->start_time) {
                        $logData['start_time'] = now();
                    }
                    break;
                case 'startBreak':
                    if (!$existingRecord->break_start_time) {
                        $logData['break_start_time'] = now();
                    }
                    break;
                case 'endBreak':
                    if (!$existingRecord->break_end_time) {
                        $logData['break_end_time'] = now();

                        // 休憩時間を計算してsecondsに保存
                        $breakStartTime = Carbon::parse($existingRecord->break_start_time);
                        $breakEndTime = Carbon::parse($logData['break_end_time']);
                        $logData['break_seconds'] = $breakEndTime->diffInSeconds($breakStartTime);
                    }
                    break;
                case 'endWork':
                    if (!$existingRecord->end_time) {
                        $logData['end_time'] = now();
                        // ここではまだcalculateTotalHoursを呼び出さない
                    }
                    break;
            }

            $existingRecord->update($logData);

            // endWorkの場合、ここでcalculateTotalHoursを呼び出す
            if ($action === 'endWork') {
                $existingRecord->calculateTotalHours();

            }
        } else {
            $validator = Validator::make($logData, [
                'name' => 'required|string',
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // 休憩時間と合計時間を計算
            $breakStartTime = Carbon::parse($logData['break_start_time']);
            $breakEndTime = Carbon::parse($logData['break_end_time']);
            $logData['break_seconds'] = $breakEndTime->diffInSeconds($breakStartTime);

            $existingRecord = Book::create($logData);

            // 休憩時間と合計時間を計算
            $existingRecord->calculateTotalHours();
        }

        return redirect()->back();
    }
    
}