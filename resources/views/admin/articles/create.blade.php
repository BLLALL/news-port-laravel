<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Article
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="article-form">
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

                    <!-- Content with TinyMCE -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Article Content *
                        </label>
                        <textarea id="content" 
                                  name="content" 
                                  rows="20"
                                  placeholder="Write your article content here..."
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Use the rich text editor to format your content with headings, lists, links, and more.
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
                                    <div class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                        <span>📧 This article will be sent to all active newsletter subscribers</span>
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
                        
                        <button type="submit" 
                                id="submit-btn"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                            Publish Article
                        </button>
                    </div>
                </form>
            </div>
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

            // Auto-save functionality
            let autoSaveTimer;
            const titleInput = document.getElementById('title');

            function startAutoSave() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(() => {
                    if (editorInitialized && tinymce.get('content')) {
                        const formData = {
                            title: titleInput.value,
                            content: tinymce.get('content').getContent()
                        };
                        localStorage.setItem('article_draft', JSON.stringify(formData));
                        console.log('Draft auto-saved');
                    }
                }, 5000);
            }

            titleInput.addEventListener('input', startAutoSave);

            // Form submission handling
            document.getElementById('article-form').addEventListener('submit', function(e) {
                // Ensure TinyMCE content is synced before submission
                if (editorInitialized && tinymce.get('content')) {
                    tinymce.get('content').save();
                    
                    // Remove required attribute temporarily to prevent validation error
                    const contentTextarea = document.getElementById('content');
                    const content = tinymce.get('content').getContent();
                    
                    if (!content.trim()) {
                        e.preventDefault();
                        alert('Please enter article content before submitting.');
                        return false;
                    }
                    
                    // Clear draft on successful submission
                    localStorage.removeItem('article_draft');
                }
            });

            // Load draft on page load
            const savedDraft = localStorage.getItem('article_draft');
            if (savedDraft && !titleInput.value) {
                const draft = JSON.parse(savedDraft);
                if (confirm('A draft was found. Would you like to restore it?')) {
                    titleInput.value = draft.title || '';
                    
                    // Wait for TinyMCE to be ready before setting content
                    function setTinyMCEContent() {
                        if (editorInitialized && tinymce.get('content')) {
                            tinymce.get('content').setContent(draft.content || '');
                        } else {
                            setTimeout(setTinyMCEContent, 500);
                        }
                    }
                    setTinyMCEContent();
                }
            }
        });
    </script>
    @endpush
</x-admin-layout>