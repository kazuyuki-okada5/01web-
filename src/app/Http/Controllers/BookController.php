<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    // コントローラー全体に認証ミドルウェアを適用
    public function __construct()
    {
        $this->middleware('auth');
    }
    // スタンプ画面を表示するメソッド
    public function stamp()
    {
        return view('book.stamp');
    }

    // ブックを作成するメソッド
    public function create(Request $request)
    {
        // バリデーションルールに従ってリクエストデータを検証
        $this->validate($request, Book::$rules);

        // リクエストデータを取得
        $form = $request->all();

        // Bookモデルを使用して新しいレコードを作成
        Book::create($form);

        // 一覧画面にリダイレクト
        return redirect('/book');
    }

    // ブックを保存するメソッド
    public function store(Request $request)
    {
        // バリデーションルールに従ってリクエストデータを検証
        $data = $request->validate([
            'name' => 'required|string',
            // 他のフィールドも必要に応じてバリデーションを追加
        ]);

        // Bookモデルを使用して新しいレコードを作成
        Book::create($data);
    }

    // アクションに応じてログを記録するメソッド
    public function logActivity(Request $request, $action)
    {
        // 認証ユーザーの名前を取得
        $userName = auth()->user()->name;

        // 今日の日付で既存のデータがあるか確認
        $existingRecord = Book::where('name', $userName)
            ->where('start_date', now()->toDateString())
            ->first();

        // カラムに関するデータを設定
        $data = [
            'name' => $userName,
            'start_date' => now()->toDateString(),
            'start_time' => $existingRecord ? $existingRecord->start_time : null,
            'end_time' => $existingRecord ? $existingRecord->end_time : null,
            'break_start_time' => $existingRecord ? $existingRecord->break_start_time : null,
            'break_end_time' => $existingRecord ? $existingRecord->break_end_time : null,
        ];

        //\Log::info('Action: ' . $action);
        //\Log::info('Existing Record: ' . json_encode($existingRecord));
        //\Log::info('Data before update: ' . json_encode($data));

        // 勤務開始前のアクションに対する処理
        if (!$existingRecord && $action !== 'startWork') {
        // 勤務開始前でかつ勤務開始アクションでない場合は何もせずリダイレクト
            return redirect()->back();
        }

        // 勤務開始アクションの場合
        if ($action === 'startWork') {
        // 既に勤務が開始されている場合は何もしない
            if ($existingRecord && $existingRecord->start_time) {
            //\Log::info('Work already started. Redirecting back...');
            return redirect()->back();
            }

        // 勤務が開始されていない場合は勤務開始時間を記録
            $data['start_time'] = now();
        //\Log::info('Work started. Updating start_time...');
        }

        // 休憩開始アクションの場合
        if ($action === 'startBreak') {
        // 既に休憩が開始されている場合は何もしない
            if ($existingRecord && $existingRecord->break_start_time) {
            //\Log::info('Break already started. Redirecting back...');
                return redirect()->back();
            }

        // 休憩が開始されていない場合は休憩開始時間を記録
            $data['break_start_time'] = now();
        //\Log::info('Break started. Updating break_start_time...');
        }

        // 休憩終了アクションの場合
        if ($action === 'endBreak') {
        // 既に休憩が終了されている場合は何もしない
            if ($existingRecord && $existingRecord->break_end_time) {
            //\Log::info('Break already ended. Redirecting back...');
                return redirect()->back();
            }

        // 休憩が終了されていない場合は休憩終了時間を記録
            $data['break_end_time'] = now();
        //\Log::info('Break ended. Updating break_end_time...');
        }

        // 勤務終了アクションの場合
        if ($action === 'endWork') {
        // 既に勤務が終了されている場合は何もしない
            if ($existingRecord && $existingRecord->end_time) {
            //\Log::info('Work already ended. Redirecting back...');
                return redirect()->back();
            }

        // 勤務が終了されていない場合は勤務終了時間を記録
            $data['end_time'] = now();
        //\Log::info('Work ended. Updating end_time...');
        }

        // ここで $data を使用してデータベースを更新
        if ($existingRecord) {
        // 既存のレコードがある場合は更新
            $existingRecord->update($data);
        //\Log::info('Record updated successfully.');
        } else {
        // 既存のレコードがない場合は新規作成
            Book::create($data);
        //\Log::info('Record created successfully.');
        }

        // リダイレクトなどの適切な処理を追加
        return redirect()->back();
    }
}