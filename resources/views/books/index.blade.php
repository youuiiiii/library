<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div>
                        <h2>Book List</h2>
                    </div>

                    <div>
                        @foreach ($books as $book)
                            <div class="border-b border-gray-200 p-4">
                                <h3 class="text-lg font-bold">{{ $book->title }}</h3>
                                <img src="" alt="">
                                <p class="text-sm">{{ $book->author }}</p>
                                <p class="text-sm">{{ $book->year }}</p>
                                <p class="text-sm">{{ $book->description }}</p>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
