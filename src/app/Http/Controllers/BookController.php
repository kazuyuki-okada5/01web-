<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
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
        $form['start_date'] = now()->toDateString();

        Book::create($form);

        return redirect('/book');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $this->logActivity($request, 'store');

        Book::create([
            'name' => $data['name'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->back();
    }

    public function index()
    {
        $currentDate = now()->toDateString();
        $books = DB::table('books')
            ->whereDate('start_date', $currentDate)
            ->paginate(5, ['*'], 'page', request()->query('page'));

        $prevDate = Carbon::parse($currentDate)->subDay()->toDateString();
        $nextDate = Carbon::parse($currentDate)->addDay()->toDateString();

        return view('author.attendees', compact('books', 'currentDate', 'prevDate', 'nextDate'));
    }
    public function startWork(Request $request)
    {
        $this->logActivity($request, 'startWork');

        $userName = auth()->user()->name;
        $userId = auth()->id();
        $today = now()->toDateString();

        $existingRecord = Book::where('name', $userName)->where('start_date', $today)->first();

        if ($existingRecord) {
            // すでにレコードが存在する場合、startWork メソッドを呼び出してデータベースを更新
            $existingRecord->startWork();

            // ログを追加するかどうかの判断は logActivity メソッド内で行うのでここでは何もしない
        }
        }

    public function logActivity(Request $request, $action)
    {
        $userName = auth()->user()->name;
        $userId = auth()->id();
        $today = now()->toDateString();

        $existingRecord = Book::where('name', $userName)->where('start_date', $today)->first();

        $logData = [
            'name' => $userName,
            'start_date' => $today,
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
                    }
                    break;
                case 'endWork':
                    if (!$existingRecord->end_time) {
                        $logData['end_time'] = now();
                    }
                    break;
            }

            $existingRecord->update($logData);
        } else {
            $validator = Validator::make($logData, [
                'name' => 'required|string',
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            Book::create($logData);
        }

        return redirect()->back();
    }
}