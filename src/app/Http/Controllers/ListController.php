<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lists;  // モデル名を正しく指定

class ListController extends Controller
{
    // コントローラー全体に認証ミドルウェアを適用
    public function __construct()
    {
        $this->middleware('auth');
    }
    // スタンプ画面を表示するメソッド
    public function list()
    {
        return view('author.attendees');
    }
     public function index()
    {
        $lists = Lists::paginate(10); // 1ページに表示するアイテム数を調整する場合は適宜変更
        return view('author.attendees', compact('lists'));
    }

    public function relate(Request $request)
    {
        $lists = Lists::all();
        return view('author.attendees', ['lists' => $lists]);
    }
    public function meaningfulMethodName() 
    {
        $lists = Lists::with('user')->get();

        foreach ($lists as $list) { // 変数名の修正
            $userName = $list->user->name;
    }

        return view('author.attendees', ['lists' => $lists]);
}
}