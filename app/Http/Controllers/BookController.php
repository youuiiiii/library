<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); // Ensure user is authenticated
        $this->middleware('role:editor,admin')->only(['store', 'update']);
        $this->middleware('role:admin')->only(['destroy']);
    }

    public function index()
    {
        $books = Book::latest()->paginate(6);
        return new BookResource(true, 'Data retrieved successfully.', $books);
    }


    public function store(Request $request)
    {

        if (!in_array(Auth::user()->role, ['admin', 'editor'])) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'year' => 'required|integer',
            'description' => 'nullable',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $cover = $request->file('cover');
        $cover->storeAs('public/cover', $cover->hashName());

        $book = Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'year' => $validated['year'],
            'description' => $validated['description'] ?? null,
            'cover' => $cover->hashName(),
        ]);

        return new BookResource(true, 'Book created successfully.', $book);
    }

    
    public function show($id)
    {
        $book = Book::find($id);
        return new BookResource(true, 'Data retrieved successfully.', $book);
    }


    public function update(Request $request, $id)
{
    // Log the request data
    Log::info('Update Request Data:', $request->all());

    // Find the book
    $book = Book::find($id);

    // Log the book before update
    Log::info('Book Before Update:', $book ? $book->toArray() : ['error' => 'Book not found']);

    if (!$book) {
        return response()->json(['message' => 'Book not found'], 404);
    }

    // Validate input
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'year' => 'required|integer|min:1000|max:' . date('Y'),
        'description' => 'nullable|string',
        'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
    ]);

    // Handle file upload
    if ($request->hasFile('cover')) {
        // Delete old cover
        Storage::disk('public')->delete('cover/' . $book->cover);

        // Store new cover
        $coverPath = $request->file('cover')->store('public/cover');
        $validated['cover'] = basename($coverPath);
    }

    // Update book with validated data
    $book->update($validated);

    return response()->json(['success' => true, 'message' => 'Book updated successfully.', 'data' => $book]);
}

    

    public function destroy($id)
    {
        
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        //find book by id
        $book = Book::find($id);

        Storage::delete('public/cover/' . $book->cover);


        // if($book->cover != 'no-image-placeholder.jpg') {
        //     Storage::disk('local')->delete('public/'. $book->cover);
        // }
        
        $book->delete();

        return new BookResource(true, 'Book deleted successfully.', $book);

    }
}
