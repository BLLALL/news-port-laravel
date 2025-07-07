<article class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 overflow-hidden hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
    <!-- Image Section -->
    <div class="relative overflow-hidden h-48 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
        @if ($article->image)
            <a href="{{ route('news.show', $article) }}" class="block h-full">
                <img src="{{ asset('storage/' . $article->image) }}" 
                     alt="{{ $article->title }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>
        @else
            <!-- Placeholder with dynamic gradient based on first category color -->
            @php
                $primaryColor = $article->categories->first()->color ?? '#000000';
                $secondaryColor = '#' . substr(md5($article->title), 0, 6);
            @endphp
            <a href="{{ route('news.show', $article) }}" class="block h-full">
                <div class="w-full h-full relative" style="background: linear-gradient(135deg, {{ $primaryColor }}30, {{ $secondaryColor }}20);">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ Str::limit($article->title, 20) }}</span>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-br from-transparent via-white/10 to-white/20 dark:via-black/10 dark:to-black/20"></div>
                </div>
            </a>
        @endif
        
        <!-- Reading time badge -->
        <div class="absolute top-3 right-3">
            <span class="bg-black/70 text-white text-xs font-medium px-2 py-1 rounded-full backdrop-blur-sm">
                {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} min read
            </span>
        </div>
        
        <!-- Featured badge for recent articles -->
        @if($article->created_at->isToday())
            <div class="absolute top-3 left-3">
                <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg animate-pulse">
                    NEW
                </span>
            </div>
        @elseif($article->created_at->diffInDays() <= 3)
            <div class="absolute top-3 left-3">
                <span class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg">
                    RECENT
                </span>
            </div>
        @endif
    </div>

    <!-- Content Section -->
    <div class="p-6">
        <!-- Category Tags -->
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach ($article->categories->take(3) as $category)
                <a href="{{ route('categories.show', $category) }}" 
                   class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-white rounded-full hover:scale-105 transition-transform duration-200 shadow-sm"
                   style="background: linear-gradient(135deg, {{ $category->color }}, {{ $category->color }}dd);">
                    <span class="w-1.5 h-1.5 rounded-full bg-white/50 mr-1.5"></span>
                    {{ $category->name }}
                </a>
            @endforeach
            
            @if($article->categories->count() > 3)
                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-full">
                    +{{ $article->categories->count() - 3 }} more
                </span>
            @endif
        </div>

        <!-- Title -->
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">
            <a href="{{ route('news.show', $article) }}" class="hover:underline decoration-2 underline-offset-2">
                {{ $article->title }}
            </a>
        </h3>

        <!-- Excerpt -->
        <div class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3 leading-relaxed">
            {!! Str::limit(strip_tags($article->content), 150) !!}
        </div>

        <!-- Author and Date -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <!-- Author Avatar -->
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-sm">
                    {{ strtoupper(substr($article->author->name, 0, 1)) }}
                </div>
                
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $article->author->name }}
                    </p>
                    <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                        <time datetime="{{ $article->created_at->toISOString() }}">
                            {{ $article->created_at->diffForHumans() }}
                        </time>
                    </div>
                </div>
            </div>
            
            <!-- Share/Bookmark Actions -->
            <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <button class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-full transition-colors duration-200" 
                        title="Bookmark">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                </button>
                <button class="p-1.5 text-gray-400 hover:text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-full transition-colors duration-200" 
                        title="Share">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Read More Button -->
        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
            <a href="{{ route('news.show', $article) }}" 
               class="inline-flex items-center text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 group/link transition-colors duration-200">
                <span>Read Full Article</span>
                <svg class="w-4 h-4 ml-2 group-hover/link:translate-x-1 transition-transform duration-200" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>

    <!-- Hover Effect Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-blue-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none rounded-2xl"></div>
</article>