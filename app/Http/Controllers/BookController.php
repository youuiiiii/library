<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(6); 

        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'year' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $cover = $request->file('cover');
        $cover->storeAs('public', $cover->hashName());

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'year' => $request->year,
            'description' => $request->description,
            'cover' => $cover->hashName(),
        ]);

        // Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function edit (Book $book)
    {
        return view('books.edit', compact('book'));
    }
}
