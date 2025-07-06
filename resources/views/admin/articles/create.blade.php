{{-- resources/views/admin/articles/create.blade.php --}}

<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.articles.index') }}" 
                   class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Articles
                </a>
                <div class="h-6 w-px bg-gray-300 dark:bg-gray-600"></div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    Create New Article
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Create New Article
                </h3>
                <p class="text-blue-100 text-sm mt-1">Fill in the details below to create a new article</p>
            </div>

            <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Article Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           required
                           placeholder="Enter a compelling article title..."
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition-colors @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Article Content <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" 
                              name="content" 
                              rows="20"
                              required
                              placeholder="Write your article content here..."
                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition-colors @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Write engaging content that provides value to your readers. You can use line breaks to organize your content.
                    </p>
                </div>

                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Featured Image
                    </label>
                    
                    <!-- Image Preview Container -->
                    <div id="image-preview-container" class="hidden mb-4">
                        <div class="relative inline-block">
                            <img id="image-preview" class="w-64 h-48 object-cover rounded-lg border border-gray-300 dark:border-gray-600 shadow-lg" src="" alt="Preview">
                            <button type="button" id="remove-image" class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold transition-colors">
                                ×
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Click the × to remove or select a different image</p>
                    </div>
                    
                    <!-- Upload Area -->
                    <div id="upload-area" class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-blue-400 dark:hover:border-blue-500 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="image" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload a file</span>
                                    <input id="image" name="image" type="file" accept="image/*" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Categories -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Categories <span class="text-red-500">*</span>
                    </label>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-60 overflow-y-auto">
                            @foreach($categories as $category)
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="checkbox" 
                                           name="categories[]" 
                                           value="{{ $category->id }}"
                                           {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    
                                    <div class="flex items-center space-x-2 flex-1">
                                        <div class="w-4 h-4 rounded-full shadow-sm" style="background-color: {{ $category->color }}"></div>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
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
                    </div>
                    @error('categories')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Select at least one category to help readers find your article.
                    </p>
                </div>

                <!-- Article Preview -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Article Preview
                    </h4>
                    <div class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <strong>Author:</strong> {{ auth()->user()->name }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m6-10v10m-6 0h6"></path>
                            </svg>
                            <strong>Publication Date:</strong> {{ now()->format('F j, Y \a\t g:i A') }}
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.articles.index') }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 shadow-sm text-base font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                        
                        <button type="button" 
                                onclick="document.getElementById('content').value = 'This is a sample article content that demonstrates how your article will look. You can replace this with your actual content. This sample includes multiple paragraphs and shows how the content will be formatted.\n\nThis is the second paragraph of the sample content. You can write as much as you need to fully express your ideas and provide value to your readers.\n\nRemember to structure your content with clear paragraphs and logical flow.'; document.getElementById('title').value = 'Sample Article Title - Replace with Your Own';"
                                class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 shadow-sm text-base font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-600 hover:bg-gray-100 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Sample Data
                        </button>
                    </div>
                    
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Article
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Image preview functionality
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const imagePreviewContainer = document.getElementById('image-preview-container');
        const uploadArea = document.getElementById('upload-area');
        const removeImageBtn = document.getElementById('remove-image');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    imageInput.value = '';
                    return;
                }
                
                // Validate file size (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB.');
                    imageInput.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.classList.remove('hidden');
                    uploadArea.classList.add('hidden');
                    console.log('Image selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove image functionality
        removeImageBtn.addEventListener('click', function() {
            imageInput.value = '';
            imagePreview.src = '';
            imagePreviewContainer.classList.add('hidden');
            uploadArea.classList.remove('hidden');
        });

        // Drag and drop functionality
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('border-blue-400', 'bg-blue-50');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                imageInput.files = files;
                imageInput.dispatchEvent(new Event('change'));
            }
        });

        // Auto-save functionality (optional)
        let autoSaveTimer;
        const titleInput = document.getElementById('title');
        const contentInput = document.getElementById('content');
        
        function autoSave() {
            // Save to localStorage as backup
            localStorage.setItem('draft_title', titleInput.value);
            localStorage.setItem('draft_content', contentInput.value);
            console.log('Draft auto-saved');
        }
        
        [titleInput, contentInput].forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(autoSave, 2000); // Auto-save after 2 seconds of inactivity
            });
        });

        // Load draft on page load
        window.addEventListener('load', function() {
            const draftTitle = localStorage.getItem('draft_title');
            const draftContent = localStorage.getItem('draft_content');
            
            if (draftTitle && !titleInput.value) {
                titleInput.value = draftTitle;
            }
            
            if (draftContent && !contentInput.value) {
                contentInput.value = draftContent;
            }
        });

        // Clear draft on successful form submission
        document.querySelector('form').addEventListener('submit', function() {
            localStorage.removeItem('draft_title');
            localStorage.removeItem('draft_content');
        });
    </script>
    @endpush
</x-admin-layout>