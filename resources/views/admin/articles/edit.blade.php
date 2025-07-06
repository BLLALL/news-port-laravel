{{-- resources/views/admin/articles/edit.blade.php --}}

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
                    Edit Article
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit "{{ Str::limit($article->title, 50) }}"
                </h3>
                <p class="text-green-100 text-sm mt-1">Update article information and content</p>
            </div>

            <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Article Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $article->title) }}"
                           required
                           placeholder="Enter a compelling article title..."
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-gray-100 transition-colors @error('title') border-red-500 @enderror">
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
                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-gray-100 transition-colors @error('content') border-red-500 @enderror">{{ old('content', $article->content) }}</textarea>
                    @error('content')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Image Display -->
                @if($article->image)
                    <div id="current-image-section">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Current Featured Image
                        </label>
                        <div class="flex items-start space-x-4">
                            <div class="relative">
                                <img id="current-image" src="{{ asset('storage/' . $article->image) }}" 
                                     alt="Current image" 
                                     class="w-32 h-24 object-cover rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm">
                                <button type="button" 
                                        id="remove-current-image"
                                        class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold transition-colors">
                                    ×
                                </button>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Current image will be replaced if you upload a new one.</p>
                                <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">Click the × to remove the current image</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- New Image Preview (Hidden by default) -->
                <div id="new-image-preview-container" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        New Image Preview
                    </label>
                    <div class="relative inline-block mb-4">
                        <img id="new-image-preview" class="w-64 h-48 object-cover rounded-lg border border-gray-300 dark:border-gray-600 shadow-lg" src="" alt="New image preview">
                        <button type="button" id="remove-new-image" class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold transition-colors">
                            ×
                        </button>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">This will replace the current image when you save</p>
                </div>

                <!-- New Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ $article->image ? 'Replace Featured Image' : 'Featured Image' }}
                    </label>
                    <div id="upload-area" class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-green-400 dark:hover:border-green-500 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="image" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-green-600 dark:text-green-400 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                    <span>{{ $article->image ? 'Upload new file' : 'Upload a file' }}</span>
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
                                           {{ in_array($category->id, old('categories', $article->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                                           class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    
                                    <div class="flex items-center space-x-2 flex-1">
                                        <div class="w-4 h-4 rounded-full shadow-sm" style="background-color: {{ $category->color }}"></div>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
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
                </div>

                <!-- Article Metadata -->
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-amber-800 dark:text-amber-200 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Article Information
                    </h4>
                    <div class="text-sm text-amber-700 dark:text-amber-300 space-y-1">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <strong>Author:</strong> {{ $article->author->name }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m6-10v10m-6 0h6"></path>
                            </svg>
                            <strong>Created:</strong> {{ $article->created_at->format('F j, Y \a\t g:i A') }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <strong>Last Updated:</strong> {{ $article->updated_at->format('F j, Y \a\t g:i A') }}
                        </div>
                    </div>
                </div>

                <!-- Live Preview -->
                <div id="preview-section" class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Live Preview
                    </h4>
                    <div id="article-preview" class="bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500 p-4">
                        <h5 id="preview-title" class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2">{{ $article->title }}</h5>
                        <div id="preview-content" class="text-gray-700 dark:text-gray-300 text-sm">
                            {{ Str::limit($article->content, 200) }}...
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.articles.index') }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 shadow-sm text-base font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                        
                        <a href="{{ route('news.show', $article) }}" 
                           target="_blank"
                           class="inline-flex items-center px-6 py-3 border border-blue-300 dark:border-blue-600 shadow-sm text-base font-medium rounded-lg text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Preview Article
                        </a>
                    </div>
                    
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Article
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Image preview functionality
        const imageInput = document.getElementById('image');
        const newImagePreview = document.getElementById('new-image-preview');
        const newImagePreviewContainer = document.getElementById('new-image-preview-container');
        const currentImageSection = document.getElementById('current-image-section');
        const uploadArea = document.getElementById('upload-area');
        const removeNewImageBtn = document.getElementById('remove-new-image');
        const removeCurrentImageBtn = document.getElementById('remove-current-image');

        // Handle new image selection
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
                    newImagePreview.src = e.target.result;
                    newImagePreviewContainer.classList.remove('hidden');
                    console.log('New image selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove new image functionality
        if (removeNewImageBtn) {
            removeNewImageBtn.addEventListener('click', function() {
                imageInput.value = '';
                newImagePreview.src = '';
                newImagePreviewContainer.classList.add('hidden');
            });
        }

        // Remove current image functionality
        if (removeCurrentImageBtn) {
            removeCurrentImageBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to remove the current image? This cannot be undone.')) {
                    currentImageSection.classList.add('hidden');
                    // You could add a hidden input here to mark the image for deletion
                    // For now, we'll just hide it visually
                }
            });
        }

        // Drag and drop functionality
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('border-green-400', 'bg-green-50');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('border-green-400', 'bg-green-50');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('border-green-400', 'bg-green-50');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                imageInput.files = files;
                imageInput.dispatchEvent(new Event('change'));
            }
        });

        // Live preview functionality
        const titleInput = document.getElementById('title');
        const contentInput = document.getElementById('content');
        const previewTitle = document.getElementById('preview-title');
        const previewContent = document.getElementById('preview-content');

        function updatePreview() {
            previewTitle.textContent = titleInput.value || 'Article Title';
            const content = contentInput.value;
            previewContent.textContent = content ? (content.length > 200 ? content.substring(0, 200) + '...' : content) : 'Article content will appear here...';
        }

        titleInput.addEventListener('input', updatePreview);
        contentInput.addEventListener('input', updatePreview);

        // Auto-save functionality
        let autoSaveTimer;
        
        function autoSave() {
            localStorage.setItem('edit_draft_title_' + {{ $article->id }}, titleInput.value);
            localStorage.setItem('edit_draft_content_' + {{ $article->id }}, contentInput.value);
            console.log('Changes auto-saved');
        }
        
        [titleInput, contentInput].forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(autoSave, 2000);
            });
        });

        // Clear auto-save on form submission
        document.querySelector('form').addEventListener('submit', function() {
            localStorage.removeItem('edit_draft_title_' + {{ $article->id }});
            localStorage.removeItem('edit_draft_content_' + {{ $article->id }});
        });

        // Warn about unsaved changes
        let hasUnsavedChanges = false;
        [titleInput, contentInput, imageInput].forEach(input => {
            input.addEventListener('input', function() {
                hasUnsavedChanges = true;
            });
        });

        window.addEventListener('beforeunload', function(e) {
            if (hasUnsavedChanges) {
                e.preventDefault();
                e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
            }
        });

        document.querySelector('form').addEventListener('submit', function() {
            hasUnsavedChanges = false;
        });
    </script>
    @endpush
</x-admin-layout>