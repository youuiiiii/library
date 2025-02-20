<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'year' => 'required|integer',
        ]);

        // ✅ Delete Old Cover If New One is Uploaded
        if ($request->file('cover')) {

            Storage::disk('local')->delete('public/', $book->cover);
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
        if($book->cover != 'no-image-placeholder.jpg') {
            Storage::disk('local')->delete('public/', $book->cover);
        }
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
