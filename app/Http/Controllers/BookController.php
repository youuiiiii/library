<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(6);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        if (!in_array(Auth::user()->role, ['admin', 'editor'])) {
            abort(403, 'Unauthorized action.');
        }
        return view('books.create');
    }

    public function store(Request $request)
    {

        if (!in_array(Auth::user()->role, ['admin', 'editor'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'year' => 'required|integer',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
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

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {

        if (!in_array(Auth::user()->role, ['admin', 'editor'])) {
            abort(403, 'Unauthorized action.');
        }

        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {

        if (!in_array(Auth::user()->role, ['admin', 'editor'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'year' => 'required|integer',
        ]);

        if ($request->file('cover')) {

            Storage::disk('local')->delete('public/'. $book->cover);
            $cover = $request->file('cover');
            $cover->storeAs('public', $cover->hashName());
            $book->cover = $cover->hashName();

        }

        $book->update();
        // $book->update([
        //     'title' => $request->title,
        //     'author' => $request->author,
        //     'year' => $request->year,
        //     'description' => $request->description,
        //     'cover' => $book->cover,
        // ]);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if($book->cover != 'no-image-placeholder.jpg') {
            Storage::disk('local')->delete('public/'. $book->cover);
        }
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
