<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Article
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Article Title *
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}"
                               placeholder="Enter article title..."
                               required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Article Content *
                        </label>
                        <textarea id="content" 
                                  name="content" 
                                  rows="15"
                                  placeholder="Write your article content here..."
                                  required
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Write your article content in plain text or basic HTML.
                        </p>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Featured Image
                        </label>
                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or JPEG (MAX. 2MB)</p>
                                </div>
                                <input id="image" 
                                       name="image" 
                                       type="file" 
                                       accept="image/*"
                                       class="hidden" />
                            </label>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categories -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Categories *
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-48 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-md p-3">
                            @foreach($categories as $category)
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="category_{{ $category->id }}" 
                                           name="categories[]" 
                                           value="{{ $category->id }}"
                                           {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded">
                                    <label for="category_{{ $category->id }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300 flex items-center">
                                        <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $category->color }};"></span>
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('categories')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Select at least one category for this article.
                        </p>
                    </div>

                    <!-- Newsletter Section -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" 
                                           id="send_newsletter" 
                                           name="send_newsletter" 
                                           value="1"
                                           {{ old('send_newsletter', true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                </div>
                                <div class="ml-3">
                                    <label for="send_newsletter" class="text-sm font-medium text-blue-900 dark:text-blue-200">
                                        Send Newsletter to Subscribers
                                    </label>
                                    <div class="text-sm text-blue-700 dark:text-blue-300 mt-1" id="newsletter-info">
                                        <!-- This will be populated with subscriber count -->
                                        <div class="flex items-center space-x-4">
                                            <span>📧 This article will be sent to all active newsletter subscribers</span>
                                            <span class="bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full text-xs font-medium" id="subscriber-count">
                                                Loading...
                                            </span>
                                        </div>
                                        <p class="mt-2 text-xs">
                                            Uncheck this option if you don't want to notify subscribers about this article.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.articles.index') }}" 
                           class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 font-bold py-2 px-4 rounded-lg transition-colors">
                            Cancel
                        </a>
                        
                        <div class="flex space-x-3">
                            <button type="submit" 
                                    name="action" 
                                    value="save_draft"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                                Save as Draft
                            </button>
                            <button type="submit" 
                                    name="action" 
                                    value="publish"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                                Publish Article
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Load newsletter subscriber count
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/newsletter/stats')
                .then(response => response.json())
                .then(data => {
                    const subscriberCount = document.getElementById('subscriber-count');
                    if (data.active_subscriptions) {
                        subscriberCount.textContent = `${data.active_subscriptions} subscribers`;
                    } else {
                        subscriberCount.textContent = 'No subscribers';
                    }
                })
                .catch(error => {
                    console.error('Error loading subscriber count:', error);
                    document.getElementById('subscriber-count').textContent = 'Unable to load';
                });
        });

        // Preview selected image
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // You can add image preview functionality here
                    console.log('Image selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        });

        // Auto-save functionality (optional)
        let autoSaveTimer;
        const titleInput = document.getElementById('title');
        const contentTextarea = document.getElementById('content');

        function startAutoSave() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                // Implement auto-save to localStorage or draft endpoint
                const formData = {
                    title: titleInput.value,
                    content: contentTextarea.value
                };
                localStorage.setItem('article_draft', JSON.stringify(formData));
                console.log('Draft auto-saved');
            }, 5000); // Auto-save every 5 seconds
        }

        titleInput.addEventListener('input', startAutoSave);
        contentTextarea.addEventListener('input', startAutoSave);

        // Load draft on page load
        const savedDraft = localStorage.getItem('article_draft');
        if (savedDraft && !titleInput.value && !contentTextarea.value) {
            const draft = JSON.parse(savedDraft);
            if (confirm('A draft was found. Would you like to restore it?')) {
                titleInput.value = draft.title || '';
                contentTextarea.value = draft.content || '';
            }
        }

        // Clear draft when form is submitted
        document.querySelector('form').addEventListener('submit', function() {
            localStorage.removeItem('article_draft');
        });
    </script>
    @endpush
</x-admin-layout>