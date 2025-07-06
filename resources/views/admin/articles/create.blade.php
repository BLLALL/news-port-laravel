{{-- resources/views/admin/articles/create.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create Article') }}
            </h2>
            <a href="{{ route('admin.articles.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Articles
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Article Title
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-300"
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Article Content
                            </label>
                            <textarea id="content" 
                                      name="content" 
                                      rows="15"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-300"
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Featured Image (Optional)
                            </label>
                            <input type="file" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-300">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Maximum file size: 2MB. Supported formats: JPG, PNG, GIF</p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Categories -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Categories (Select at least one)
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-60 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-md p-3">
                                @foreach($categories as $category)
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox" 
                                               name="categories[]" 
                                               value="{{ $category->id }}"
                                               {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $category->color }}"></div>
                                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                                @if($category->parent)
                                                    {{ $category->parent->name }} > {{ $category->name }}
                                                @else
                                                    {{ $category->name }}
                                                @endif
                                            </span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('categories')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.articles.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Article
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>