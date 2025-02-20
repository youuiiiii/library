<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center">
                        <h2>Edit Book</h2>
                    </div>

                    <div class="mt-4" x-data="{ imageUrl: '/storage/no-image-placeholder.jpg' }">
                        <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data" class="flex gap-8 " >
                            @csrf

                            <div class="w-1/2">      
                                <img :src="imageUrl" alt="" class="rounded-md ">

                            </div>
                            
                            <div class="w-1/2 ">

                                <div >
                                    <div class="mt-4">
                                        <x-input-label   for="cover" :value="__('Title')" />
                                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required/>
                                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                    </div>
        
                                    <div class="mt-4">
                                        <x-input-label  for="author" :value="__('Author')" />
                                        <x-text-input id="author" class="block mt-1 w-full" type="text" name="author" :value="old('author')" required/>
                                        <x-input-error :messages="$errors->get('author')" class="mt-2" />
        
                                    </div>
        
                                    <div class="mt-4">
                                        <x-input-label  for="year" :value="__('Year')" />
                                        <x-text-input id="year" class="block mt-1 w-full" type="text" name="year" :value="old('year')" required/>
                                        <x-input-error :messages="$errors->get('year')" class="mt-2" />
                                    </div>
        
                                    <div class="mt-4">
                                        <x-input-label  for="description" :value="__('Description')" />
                                        <x-text-area id="description" class="block mt-1 w-full" name="description" :value="old('description')"/>
                                        <x-input-error :messages="$errors->get('description')" class="mt-2" /> 
                                    </div>

                                    <div class="mt-4">
                                        <x-input-label  for="description" :value="__('Book Cover')" />
                                        <x-text-input id="cover" class="block mt-1 w-full border p-2" type="file" accept="image/*" name="cover" :value="old('cover')" required @change="imageUrl = URL.createObjectURL($event.target.files[0])" />
                                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                    </div>
                                </div>
    
                                <x-primary-button class="justify-center w-full mt-4">
                                    {{ __('Submit') }}
                                </x-primary-button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
