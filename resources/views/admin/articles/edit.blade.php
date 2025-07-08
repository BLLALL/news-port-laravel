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

            <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data" class="p-6 space-y-6" id="article-edit-form">
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

                <!-- Content with TinyMCE -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Article Content <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" 
                              name="content" 
                              rows="20"
                              placeholder="Write your article content here..."
                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-gray-100 transition-colors @error('content') border-red-500 @enderror">{{ old('content', $article->content) }}</textarea>
                    @error('content')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Use the rich text editor to format your content with headings, lists, links, and more.
                    </p>
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
                            id="update-btn"
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
    <!-- TinyMCE CDN -->
    <script src="https://cdn.tiny.cloud/1/w0g30oweh2lt67fldc8svyzok04ltenzoby5l77pv10bk6oh/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let editorInitialized = false;
            
            // Initialize TinyMCE with FIXED configuration
            tinymce.init({
                selector: '#content',
                height: 500,
                menubar: true,
                // REMOVED 'template' plugin (deprecated in TinyMCE 7)
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons',
                    'codesample'
                ],
                toolbar: 'undo redo | blocks | bold italic underline strikethrough | ' +
                        'alignleft aligncenter alignright alignjustify | ' +
                        'bullist numlist outdent indent | removeformat | help | ' +
                        'link image media | table | code codesample | emoticons | fullscreen',
                content_style: `
                    body { 
                        font-family: Inter, -apple-system, BlinkMacSystemFont, sans-serif; 
                        font-size: 14px; 
                        line-height: 1.6;
                        color: #374151;
                    }
                    h1, h2, h3, h4, h5, h6 { 
                        color: #111827; 
                        margin-top: 1rem; 
                        margin-bottom: 0.5rem; 
                    }
                    p { margin-bottom: 1rem; }
                    ul, ol { margin: 1rem 0; padding-left: 2rem; }
                    blockquote { 
                        border-left: 4px solid #3B82F6; 
                        padding-left: 1rem; 
                        margin: 1rem 0; 
                        font-style: italic;
                        background: #F3F4F6;
                        padding: 1rem;
                        border-radius: 0.375rem;
                    }
                `,
                // Image upload configuration
                images_upload_url: '/admin/upload-image',
                automatic_uploads: true,
                images_upload_base_path: '/storage/',
                file_picker_types: 'image',
                file_picker_callback: function(cb, value, meta) {
                    if (meta.filetype === 'image') {
                        let input = document.createElement('input');
                        input.setAttribute('type', 'file');
                        input.setAttribute('accept', 'image/*');
                        
                        input.addEventListener('change', function(e) {
                            let file = e.target.files[0];
                            
                            let reader = new FileReader();
                            reader.addEventListener('load', function () {
                                let id = 'blobid' + (new Date()).getTime();
                                let blobCache = tinymce.activeEditor.editorUpload.blobCache;
                                let base64 = reader.result.split(',')[1];
                                let blobInfo = blobCache.create(id, file, base64);
                                blobCache.add(blobInfo);
                                
                                cb(blobInfo.blobUri(), { title: file.name });
                            });
                            reader.readAsDataURL(file);
                        });
                        
                        input.click();
                    }
                },
                setup: function(editor) {
                    editor.on('init', function() {
                        editorInitialized = true;
                        console.log('TinyMCE initialized successfully');
                    });
                    
                    editor.on('change', function() {
                        if (editorInitialized) {
                            startAutoSave();
                        }
                    });
                },
                // Disable analytics to prevent ad-blocker issues
                analytics: {
                    enabled: false
                },
                // Error handling
                init_instance_callback: function(editor) {
                    console.log('TinyMCE editor instance created:', editor.id);
                }
            }).catch(function(error) {
                console.error('TinyMCE initialization failed:', error);
                // Fallback: show textarea if TinyMCE fails
                document.getElementById('content').style.display = 'block';
            });

            // Image preview functionality
            const imageInput = document.getElementById('image');
            const currentImageSection = document.getElementById('current-image-section');
            const uploadArea = document.getElementById('upload-area');
            const removeCurrentImageBtn = document.getElementById('remove-current-image');

            // Handle new image selection
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (!file.type.startsWith('image/')) {
                        alert('Please select a valid image file.');
                        imageInput.value = '';
                        return;
                    }
                    
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File size must be less than 2MB.');
                        imageInput.value = '';
                        return;
                    }

                    console.log('New image selected:', file.name);
                }
            });

            // Remove current image functionality
            if (removeCurrentImageBtn) {
                removeCurrentImageBtn.addEventListener('click', function() {
                    if (confirm('Are you sure you want to remove the current image? This cannot be undone.')) {
                        currentImageSection.classList.add('hidden');
                    }
                });
            }

            // Auto-save functionality with TinyMCE
            let autoSaveTimer;
            const titleInput = document.getElementById('title');
            
            function startAutoSave() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(() => {
                    if (editorInitialized && tinymce.get('content')) {
                        localStorage.setItem('edit_draft_title_' + {{ $article->id }}, titleInput.value);
                        localStorage.setItem('edit_draft_content_' + {{ $article->id }}, tinymce.get('content').getContent());
                        console.log('Changes auto-saved');
                    }
                }, 2000);
            }
            
            titleInput.addEventListener('input', startAutoSave);

            // Form submission handling
            document.getElementById('article-edit-form').addEventListener('submit', function(e) {
                // Ensure TinyMCE content is synced before submission
                if (editorInitialized && tinymce.get('content')) {
                    tinymce.get('content').save();
                    
                    const content = tinymce.get('content').getContent();
                    
                    if (!content.trim()) {
                        e.preventDefault();
                        alert('Please enter article content before submitting.');
                        return false;
                    }
                    
                    // Clear auto-save on successful submission
                    localStorage.removeItem('edit_draft_title_' + {{ $article->id }});
                    localStorage.removeItem('edit_draft_content_' + {{ $article->id }});
                }
            });

            // Warn about unsaved changes
            let hasUnsavedChanges = false;
            [titleInput, imageInput].forEach(input => {
                input.addEventListener('input', function() {
                    hasUnsavedChanges = true;
                });
            });

            // Track TinyMCE changes for unsaved warning
            function setupUnsavedChangesTracking() {
                if (editorInitialized && tinymce.get('content')) {
                    tinymce.get('content').on('change', function() {
                        hasUnsavedChanges = true;
                    });
                } else {
                    setTimeout(setupUnsavedChangesTracking, 500);
                }
            }
            setupUnsavedChangesTracking();

            window.addEventListener('beforeunload', function(e) {
                if (hasUnsavedChanges) {
                    e.preventDefault();
                    e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                }
            });

            document.querySelector('form').addEventListener('submit', function() {
                hasUnsavedChanges = false;
            });
        });
    </script>
    @endpush
</x-admin-layout>