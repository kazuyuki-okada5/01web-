<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index(){
        $items = Book::all();
        return view('book.index', ['items'=>$items]);
    
        $book = Book::simplePaginate(21);
        return view('index', ['book' => $book]);
        }
    public function add(){
        return view('book.add');
    }
    public function create(Request $request){
        $this->validate($request, Book::$rules);
        $form = $request->all();
        Book::create($form);
        return redirect('/book');
    }
    
}