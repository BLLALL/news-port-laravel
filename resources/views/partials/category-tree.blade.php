<div class="space-y-3">
    @foreach ($categories as $category)
        <div class="group relative">
            <!-- Main Category -->
            <div class="flex items-center justify-between p-4 bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm rounded-xl border border-gray-200/50 dark:border-gray-600/50 hover:bg-white/80 dark:hover:bg-gray-700/80 hover:shadow-lg transition-all duration-300 hover:scale-[1.02]">
                <a href="{{ route('categories.show', $category['id']) }}" 
                   class="flex items-center space-x-4 flex-1 group-hover:scale-105 transition-transform duration-200">
                    
                    <!-- Category Color Indicator -->
                    <div class="relative">
                        <div class="w-5 h-5 rounded-full shadow-lg ring-2 ring-white dark:ring-gray-800 group-hover:scale-110 transition-transform duration-200" 
                             style="background: linear-gradient(135deg, {{ $category['color'] }}, {{ $category['color'] }}aa);"></div>
                        <div class="absolute inset-0 w-5 h-5 rounded-full animate-pulse opacity-30"
                             style="background-color: {{ $category['color'] }};"></div>
                    </div>
                    
                    <!-- Category Info -->
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">
                            {{ $category['name'] }}
                        </h4>
                        @if(isset($category['description']))
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $category['description'] }}</p>
                        @endif
                    </div>
                    
                    <!-- Article Count -->
                    <div class="flex items-center space-x-2">
                        <div class="bg-gradient-to-r from-blue-500/20 to-indigo-500/20 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-sm font-medium border border-blue-200 dark:border-blue-700">
                            <svg class="w-3 h-3 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $category->articles->count() ?? 0 }} articles
                        </div>
                        
                        @if (!empty($category['children']))
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200" 
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                    </div>
                </a>
            </div>
            
            <!-- Subcategories -->
            @if (!empty($category['children']))
                <div class="mt-3 ml-8 space-y-2 relative">
                    <!-- Connection Line -->
                    <div class="absolute -left-4 top-0 bottom-0 w-px bg-gradient-to-b from-blue-200 to-transparent dark:from-blue-700"></div>
                    
                    @foreach($category['children'] as $index => $child)
                        <div class="relative">
                            <!-- Horizontal Line -->
                            <div class="absolute -left-4 top-1/2 w-4 h-px bg-blue-200 dark:bg-blue-700"></div>
                            
                            <div class="bg-white/40 dark:bg-gray-800/40 backdrop-blur-sm rounded-lg p-3 border border-gray-200/30 dark:border-gray-600/30 hover:bg-white/60 dark:hover:bg-gray-800/60 hover:shadow-md transition-all duration-200 group/child">
                                <a href="{{ route('categories.show', $child['id']) }}" 
                                   class="flex items-center justify-between">
                                    
                                    <div class="flex items-center space-x-3">
                                        <div class="w-3 h-3 rounded-full shadow-sm" 
                                             style="background-color: {{ $child['color'] }};"></div>
                                        <span class="font-medium text-gray-800 dark:text-gray-200 group-hover/child:text-blue-600 dark:group-hover/child:text-blue-400 transition-colors">
                                            {{ $child['name'] }}
                                        </span>
                                    </div>
                                    
                                    <span class="text-xs text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-full">
                                        {{ $child->articles->count() ?? 0 }}
                                    </span>
                                </a>
                                
                                <!-- Nested Children -->
                                @if (!empty($child['children']))
                                    <div class="mt-2 ml-6 space-y-1">
                                        @foreach($child['children'] as $grandchild)
                                            <a href="{{ route('categories.show', $grandchild['id']) }}" 
                                               class="flex items-center space-x-2 p-2 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group/grandchild">
                                                <div class="w-2 h-2 rounded-full" 
                                                     style="background-color: {{ $grandchild['color'] }};"></div>
                                                <span class="text-sm text-gray-700 dark:text-gray-300 group-hover/grandchild:text-blue-600 dark:group-hover/grandchild:text-blue-400 transition-colors">
                                                    {{ $grandchild['name'] }}
                                                </span>
                                                <span class="text-xs text-gray-400 ml-auto">
                                                    {{ $grandchild->articles->count() ?? 0 }}
                                                </span>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>