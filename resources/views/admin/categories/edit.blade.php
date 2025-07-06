<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Categories
                </a>
                <div class="h-6 w-px bg-gray-300 dark:bg-gray-600"></div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    Edit Category
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit "{{ $category->name }}"
                </h3>
                <p class="text-green-100 text-sm mt-1">Update category information and hierarchy</p>
            </div>

            <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Category Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $category->name) }}"
                           required
                           placeholder="Enter category name..."
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-gray-100 transition-colors @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parent Category -->
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Parent Category
                    </label>
                    <select id="parent_id" 
                            name="parent_id" 
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-gray-100 transition-colors @error('parent_id') border-red-500 @enderror">
                        <option value="">Root Category (No Parent)</option>
                        @foreach($parentCategories as $parentCategory)
                            <option value="{{ $parentCategory->id }}" 
                                    {{ old('parent_id', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}
                                    style="color: {{ $parentCategory->color }};">
                                @if($parentCategory->parent_id)
                                    &nbsp;&nbsp;&nbsp;&nbsp;└─ {{ $parentCategory->name }}
                                @else
                                    {{ $parentCategory->name }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Choose a parent category or leave empty for a root category. You can create unlimited nesting levels.
                    </p>
                </div>

                <!-- Category Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Category Color <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-3">
                        <input type="color" 
                               id="color" 
                               name="color" 
                               value="{{ old('color', $category->color) }}"
                               required
                               class="w-16 h-12 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('color') border-red-500 @enderror">
                        <div class="flex-1">
                            <input type="text" 
                                   id="color_hex" 
                                   value="{{ old('color', $category->color) }}"
                                   placeholder="#3B82F6"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-gray-100 transition-colors font-mono">
                        </div>
                    </div>
                    @error('color')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    
                    <!-- Color Presets -->
                    <div class="mt-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Quick Colors:</p>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $presetColors = [
                                    '#3B82F6' => 'Blue',
                                    '#10B981' => 'Green', 
                                    '#8B5CF6' => 'Purple',
                                    '#EF4444' => 'Red',
                                    '#F59E0B' => 'Orange',
                                    '#EC4899' => 'Pink',
                                    '#06B6D4' => 'Cyan',
                                    '#84CC16' => 'Lime',
                                    '#F97316' => 'Orange',
                                    '#6366F1' => 'Indigo',
                                    '#14B8A6' => 'Teal',
                                    '#A855F7' => 'Violet'
                                ];
                            @endphp
                            @foreach($presetColors as $colorCode => $colorName)
                                <button type="button" 
                                        onclick="setColor('{{ $colorCode }}')"
                                        class="w-8 h-8 rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 transition-colors shadow-sm hover:shadow-md transform hover:scale-110 {{ $category->color === $colorCode ? 'ring-2 ring-green-500' : '' }}"
                                        style="background-color: {{ $colorCode }};"
                                        title="{{ $colorName }}">
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Current Category Info -->
                @if($category->children->count() > 0 || $category->articles->count() > 0)
                    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-amber-800 dark:text-amber-200 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Category Usage
                        </h4>
                        <div class="text-sm text-amber-700 dark:text-amber-300 space-y-1">
                            @if($category->children->count() > 0)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <strong>{{ $category->children->count() }}</strong> subcategories will be affected by parent changes
                                </div>
                            @endif
                            @if($category->articles->count() > 0)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <strong>{{ $category->articles->count() }}</strong> articles are tagged with this category
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Preview -->
                <div id="preview-section" class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Live Preview
                    </h4>
                    <div id="category-preview" class="flex items-center space-x-3 p-3 bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500">
                        <div id="preview-color" class="w-6 h-6 rounded-full shadow-sm" style="background-color: {{ $category->color }};"></div>
                        <div class="flex-1">
                            <div id="preview-name" class="font-medium text-gray-900 dark:text-gray-100">{{ $category->name }}</div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.categories.index') }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 shadow-sm text-base font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                        
                        <a href="{{ route('categories.show', $category) }}" 
                           target="_blank"
                           class="inline-flex items-center px-6 py-3 border border-blue-300 dark:border-blue-600 shadow-sm text-base font-medium rounded-lg text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Preview
                        </a>
                    </div>
                    
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Color picker synchronization
        const colorPicker = document.getElementById('color');
        const colorHex = document.getElementById('color_hex');
        const previewColor = document.getElementById('preview-color');

        function updateColor(color) {
            colorPicker.value = color;
            colorHex.value = color;
            previewColor.style.backgroundColor = color;
            
            // Update preset button rings
            document.querySelectorAll('[onclick^="setColor"]').forEach(btn => {
                btn.classList.remove('ring-2', 'ring-green-500');
            });
            
            const matchingPreset = document.querySelector(`[onclick="setColor('${color}')"]`);
            if (matchingPreset) {
                matchingPreset.classList.add('ring-2', 'ring-green-500');
            }
        }

        colorPicker.addEventListener('input', function() {
            updateColor(this.value);
        });

        colorHex.addEventListener('input', function() {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                updateColor(this.value);
            }
        });

        function setColor(color) {
            updateColor(color);
        }

        // Live preview updates
        const nameInput = document.getElementById('name');
        const previewName = document.getElementById('preview-name');

        nameInput.addEventListener('input', function() {
            previewName.textContent = this.value || 'Category Name';
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const name = nameInput.value.trim();
            const color = colorPicker.value;
            
            if (!name) {
                e.preventDefault();
                nameInput.focus();
                alert('Please enter a category name.');
                return;
            }
            
            if (!/^#[0-9A-F]{6}$/i.test(color)) {
                e.preventDefault();
                colorHex.focus();
                alert('Please enter a valid hex color code.');
                return;
            }
        });

        // Auto-focus first field
        document.addEventListener('DOMContentLoaded', function() {
            nameInput.focus();
            nameInput.select(); // Select existing text for easy editing
        });
    </script>
    @endpush
</x-admin-layout>