<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session()->has('success'))
                        <x-alert message="{{ session('success') }}"></x-alert>
                    @endif
                    
                    <div class="flex justify-between items-center">
                        <h2>Book List</h2>
                        <a href="{{ route('books.create') }}">
                            <button class="bg-blue-400 px-10 py-2 rounded-md font-semibold">Add Book</button>
                        </a>
                    </div>

                    <div class="grid md:grid-cols-3 grid-cols-2 gap-4">
                        @foreach ($books as $book)
                            <div class="border-b border-gray-200 p-4">
                                
                                <img src="{{ url('storage/'. $book->cover) }}" alt="" class="">
                                <div class="my-4">
                                    <h3 class="text-xl font-bold">{{ $book->title }}</h3>
                                    <p class="text-sm">{{ $book->author }}</p>
                                    <p class="text-sm">{{ $book->year }}</p>
                                    <p class="text-sm">{{ $book->description }}</p>
                                </div>

                                <button class="bg-blue-400 px-10 py-2 w-full rounded-md font-semibold">Edit</button>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
