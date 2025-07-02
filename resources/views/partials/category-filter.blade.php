<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach ($categories as $category)
        <div class="space-y-3">
            <!-- Parent Category -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                <label class="flex items-center space-x-3 cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" 
                               name="categories[]" 
                               value="{{ $category->id }}" 
                               {{ in_array($category->id, $selected) ? 'checked' : '' }}
                               class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 transition-all duration-200"
                               onchange="console.log('Category {{ $category->id }} toggled:', this.checked)">
                        
                        <!-- Custom checkbox overlay -->
                        <div class="absolute inset-0 w-5 h-5 rounded border-2 pointer-events-none transition-all duration-200"
                             style="border-color: {{ $category->color }}; opacity: 0;"
                             x-data="{ checked: {{ in_array($category->id, $selected) ? 'true' : 'false' }} }"
                             x-init="$watch('checked', value => $el.style.opacity = value ? '1' : '0'); $el.previousElementSibling.addEventListener('change', e => checked = e.target.checked)"
                             :style="checked ? `border-color: {{ $category->color }}; opacity: 1; background-color: {{ $category->color }}20;` : ''">
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 flex-1">
                        <div class="w-4 h-4 rounded-full shadow-sm border-2 border-white dark:border-gray-800 group-hover:scale-110 transition-transform duration-200" 
                             style="background: linear-gradient(135deg, {{ $category->color }}, {{ $category->color }}cc);"></div>
                        
                        <div class="flex-1">
                            <span class="font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">
                                {{ $category->name }}
                            </span>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ $category->articles->count() ?? 0 }} articles
                            </div>
                        </div>
                    </div>
                </label>
                
                <!-- Child Categories -->
                @if (!empty($category->children) && count($category->children) > 0)
                    <div class="mt-3 ml-8 space-y-2 border-l-2 border-gray-100 dark:border-gray-700 pl-4">
                        @foreach($category->children as $child)
                            <label class="flex items-center space-x-3 cursor-pointer group/child">
                                <div class="relative">
                                    <input type="checkbox" 
                                           name="categories[]" 
                                           value="{{ $child->id }}" 
                                           {{ in_array($child->id, $selected) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                           onchange="console.log('Child category {{ $child->id }} toggled:', this.checked)">
                                    
                                    <div class="absolute inset-0 w-4 h-4 rounded border pointer-events-none transition-all duration-200"
                                         style="border-color: {{ $child->color }}; opacity: 0;"
                                         x-data="{ checked: {{ in_array($child->id, $selected) ? 'true' : 'false' }} }"
                                         x-init="$watch('checked', value => $el.style.opacity = value ? '1' : '0'); $el.previousElementSibling.addEventListener('change', e => checked = e.target.checked)"
                                         :style="checked ? `border-color: {{ $child->color }}; opacity: 1; background-color: {{ $child->color }}15;` : ''">
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2 flex-1">
                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $child->color }};"></div>
                                    <span class="text-sm text-gray-700 dark:text-gray-300 group-hover/child:text-blue-600 dark:group-hover/child:text-blue-400 transition-colors">
                                        {{ $child->name }}
                                    </span>
                                    <span class="text-xs text-gray-400 ml-auto">
                                        ({{ $child->articles->count() ?? 0 }})
                                    </span>
                                </div>
                            </label>
                            
                            <!-- Grandchild Categories -->
                            @if (!empty($child->children) && count($child->children) > 0)
                                <div class="ml-6 space-y-1">
                                    @foreach($child->children as $grandchild)
                                        <label class="flex items-center space-x-2 cursor-pointer group/grandchild text-sm">
                                            <input type="checkbox" 
                                                   name="categories[]" 
                                                   value="{{ $grandchild->id }}" 
                                                   {{ in_array($grandchild->id, $selected) ? 'checked' : '' }}
                                                   class="w-3 h-3 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-1 dark:bg-gray-700 dark:border-gray-600"
                                                   onchange="console.log('Grandchild category {{ $grandchild->id }} toggled:', this.checked)">
                                            
                                            <div class="w-2 h-2 rounded-full" style="background-color: {{ $grandchild->color }};"></div>
                                            <span class="text-gray-600 dark:text-gray-400 group-hover/grandchild:text-blue-600 dark:group-hover/grandchild:text-blue-400 transition-colors">
                                                {{ $grandchild->name }}
                                            </span>
                                            <span class="text-xs text-gray-400 ml-auto">
                                                ({{ $grandchild->articles->count() ?? 0 }})
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

<!-- Quick Filter Actions -->
<div class="mt-4 flex flex-wrap gap-2">
    <button type="button" 
            onclick="document.querySelectorAll('input[name=\'categories[]\']').forEach(cb => { cb.checked = true; console.log('Selected all categories'); })"
            class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">
        Select All
    </button>
    <button type="button" 
            onclick="document.querySelectorAll('input[name=\'categories[]\']').forEach(cb => { cb.checked = false; console.log('Cleared all categories'); })"
            class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
        Clear All
    </button>
    <button type="button" 
            onclick="let checkboxes = document.querySelectorAll('input[name=\'categories[]\']:not(:checked)'); checkboxes.forEach((cb, index) => { if(index < 3) { cb.checked = true; console.log('Selected top 3 categories'); } })"
            class="text-xs bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 px-3 py-1 rounded-full hover:bg-green-200 dark:hover:bg-green-800 transition-colors">
        Select Top 3
    </button>
</div>

