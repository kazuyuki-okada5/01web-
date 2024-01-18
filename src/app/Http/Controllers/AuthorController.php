<?php

namespace App\Http\Controllers;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return view('attendees', ['authors' => $authors]);

    $authors = Author::simplePaginate(21);
    return view('stamp', ['authors' => $authors]);
    }
    public function relate(Request $request) //追記
{
    $items = Author::all();
    return view('author.index', ['items' => $items]);
}
}
