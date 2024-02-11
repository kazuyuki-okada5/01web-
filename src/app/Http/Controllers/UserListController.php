<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class UserListController extends Controller
{
    public function index(Request $request)
    {
        // リクエストから検索キーワードを取得
        $keyword = $request->input('keyword');

        // ページネーションのリクエストかどうかをチェック
        if ($request->has('page')) {
            // ページネーションのリクエストの場合はログインユーザーのデータのみを取得
            $userId = Auth::id();
            $books = Book::where('user_id', $userId)->paginate(5); // ログインユーザーのデータのみを取得してページネーション
        } else {
            // ページネーション以外のリクエストの場合は、ユーザー名で絞り込み
            $query = Book::query();
            if ($keyword) {
                $query->whereHas('user', function($q) use ($keyword) {
                    $q->where('name', $keyword);
                });
            } else {
                // 検索キーワードがない場合はログインユーザーのデータのみを取得
                $userId = Auth::id();
                $query->where('user_id', $userId);
            }
            $books = $query->paginate(5); // 検索結果をページネーション
        }

        // 取得したデータをビューに渡す
        return view('users.userslist', compact('books', 'keyword'));
    }
}