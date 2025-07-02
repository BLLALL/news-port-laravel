<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <!-- Breadcrumbs -->
                <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        Home
                    </a>
                    @foreach($categoryPath as $pathCategory)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        @if($loop->last)
                            <span class="text-gray-900 dark:text-white font-medium">{{ $pathCategory->name }}</span>
                        @else
                            <a href="{{ route('categories.show', $pathCategory) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                {{ $pathCategory->name }}
                            </a>
                        @endif
                    @endforeach
                </nav>
                
                <!-- Category Title -->
                <h2 class="font-bold text-3xl text-gray-900 dark:text-white leading-tight flex items-center">
                    <span class="w-6 h-6 rounded-full mr-3 shadow-lg" style="background-color: {{ $category->color }};"></span>
                    {{ $category->name }}
                    <span class="ml-3 text-sm font-normal text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">
                        {{ $articles->total() }} articles
                    </span>
                </h2>
                
                @if($category->description)
                    <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $category->description }}</p>
                @endif
            </div>
            
            <!-- Category Actions -->
            <div class="flex items-center space-x-3">
                <button class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-all duration-200"
                        title="Subscribe to category">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 8v8m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </button>
                
                <button class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-all duration-200"
                        title="Share category">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-blue-900/20 dark:to-indigo-900/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Subcategories Section -->
            @if($subcategories->count() > 0)
                <div class="mb-8">
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                            </svg>
                            Subcategories
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($subcategories as $subcategory)
                                <a href="{{ route('categories.show', $subcategory) }}" 
                                   class="group bg-white dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-lg transition-all duration-200">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-4 h-4 rounded-full flex-shrink-0" style="background-color: {{ $subcategory->color }};"></div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                {{ $subcategory->name }}
                                            </h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $subcategory->articles->count() }} articles directly in this category
                                            </p>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Search and Filter Section -->
            <div class="mb-8">
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 p-6">
                    <form method="GET" action="{{ route('categories.show', $category) }}" class="flex items-center space-x-4">
                        <div class="flex-1">
                            <div class="relative">
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Search articles in {{ $category->name }}..."
                                       class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent text-gray-900 dark:text-gray-100">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            Search
                        </button>
                        
                        @if(request('search'))
                            <a href="{{ route('categories.show', $category) }}" 
                               class="bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 font-semibold py-3 px-6 rounded-xl transition-all duration-200">
                                Clear
                            </a>
                        @endif
                    </form>
                    
                    <!-- Category Info Note -->
                    <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <p class="text-sm text-blue-700 dark:text-blue-300 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            Showing articles directly tagged with "{{ $category->name }}". 
                            @if($subcategories->count() > 0)
                                Visit subcategories to see more specific content.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Articles Section -->
            <div class="mb-8">
                @if(request('search'))
                    <div class="mb-6">
                        <p class="text-gray-600 dark:text-gray-400">
                            @if($articles->total() > 0)
                                Found {{ $articles->total() }} article{{ $articles->total() !== 1 ? 's' : '' }} for "<strong>{{ request('search') }}</strong>" in {{ $category->name }}
                            @else
                                No articles found for "<strong>{{ request('search') }}</strong>" in {{ $category->name }}
                            @endif
                        </p>
                    </div>
                @endif
                
                @if($articles->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($articles as $article)
                            @include('partials.news-card', ['article' => $article])
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    @if($articles->hasPages())
                        <div class="mt-12 flex justify-center">
                            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 p-4">
                                {{ $articles->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                            @if(request('search'))
                                No Articles Found
                            @else
                                No Articles Directly Tagged
                            @endif
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            @if(request('search'))
                                Try adjusting your search terms or browse other categories.
                            @elseif($subcategories->count() > 0)
                                This category doesn't have articles directly tagged to it, but check out the subcategories above for more specific content.
                            @else
                                This category doesn't have any articles tagged to it yet. Check back later for new content.
                            @endif
                        </p>
                        <div class="flex justify-center space-x-4">
                            @if(request('search'))
                                <a href="{{ route('categories.show', $category) }}" 
                                   class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    View All {{ $category->name }} Articles
                                </a>
                            @elseif($subcategories->count() > 0)
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Browse the subcategories above to find articles
                                </p>
                            @endif
                            <a href="{{ route('home') }}" 
                               class="inline-flex items-center bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 font-semibold py-2 px-4 rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Browse All Categories
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Related Categories -->
            @if($category->parent || $category->children->count() > 0)
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Related Categories
                    </h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @if($category->parent)
                            <a href="{{ route('categories.show', $category->parent) }}" 
                               class="group bg-gray-50 dark:bg-gray-700 rounded-lg p-3 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $category->parent->color }};"></div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                        {{ $category->parent->name }}
                                    </span>
                                </div>
                            </a>
                        @endif
                        
                        @foreach($category->children->take(3) as $child)
                            <a href="{{ route('categories.show', $child) }}" 
                               class="group bg-gray-50 dark:bg-gray-700 rounded-lg p-3 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $child->color }};"></div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                        {{ $child->name }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 