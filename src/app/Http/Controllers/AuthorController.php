<?php

namespace App\Http\Controllers;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        // 正しいデータを取得するように修正
        $authors = Author::simplePaginate(21);
        return view('attendees', ['authors' => $authors]);
    }

    public function relate(Request $request)
    {
        // 適切なメソッドを使用してデータを取得
        $items = Author::all();
        return view('author.attendees', ['items' => $items]);
    }
    public function someMethod()
{
    $authors = Author::with('user')->get();

    foreach ($authors as $author) {
        $userName = $author->user->name;
        // 他のユーザー関連の情報にもアクセスできる
    }
}
}