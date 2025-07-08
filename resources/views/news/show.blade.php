<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" 
                   class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to News
                </a>
                <div class="h-6 w-px bg-gray-300 dark:bg-gray-600"></div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    Article Details
                </h2>
            </div>
            
            <!-- Article Actions -->
            <div class="flex items-center space-x-3">
                <button class="p-2 rounded-lg bg-white/50 dark:bg-gray-800/50 hover:bg-white/70 dark:hover:bg-gray-800/70 text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-all duration-200 group"
                        title="Like this article">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
                
                <button class="p-2 rounded-lg bg-white/50 dark:bg-gray-800/50 hover:bg-white/70 dark:hover:bg-gray-800/70 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200 group"
                        title="Share this article"
                        onclick="navigator.share ? navigator.share({title: '{{ $article->title }}', url: window.location.href}) : null">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                </button>
                
                <button class="p-2 rounded-lg bg-white/50 dark:bg-gray-800/50 hover:bg-white/70 dark:hover:bg-gray-800/70 text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-all duration-200 group"
                        title="Save for later">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-blue-900/20 dark:to-indigo-900/20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Article Header -->
            <article class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50 overflow-hidden mb-8">

                <!-- Featured Image -->
                @if($article->image)
                    <div class="relative h-96 overflow-hidden">
                        <img src="{{ asset('storage/' . $article->image) }}" 
                             alt="{{ $article->title }}" 
                             class="w-full h-full object-cover">
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        
                        <!-- Article Categories (overlaid on image) -->
                        <div class="absolute bottom-6 left-6 flex flex-wrap gap-2">
                            @foreach($article->categories as $category)
                                <span class="px-3 py-1 text-sm font-medium text-white rounded-full shadow-lg backdrop-blur-sm border border-white/20"
                                      style="background: linear-gradient(135deg, {{ $category->color }}ee, {{ $category->color }}aa);">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                        
                        <!-- Reading Time -->
                        <div class="absolute top-6 right-6 bg-black/50 backdrop-blur-sm text-white text-sm px-3 py-1 rounded-full border border-white/20">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} min read
                        </div>
                    </div>
                @endif
                
                <!-- Article Content -->
                <div class="p-8">
                    <!-- Title -->
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white leading-tight mb-6">
                        {{ $article->title }}
                    </h1>
                    
                    <!-- Article Meta -->
                    <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-4">
                            <!-- Author Avatar -->
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-lg font-semibold shadow-lg">
                                {{ substr($article->author->name, 0, 1) }}
                            </div>
                            
                            <div>
                                <div class="font-semibold text-gray-900 dark:text-white">
                                    {{ $article->author->name }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    Published {{ $article->created_at->format('F j, Y') }} at {{ $article->created_at->format('g:i A') }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Article Stats -->
                        <div class="flex items-center space-x-6 text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ rand(500, 2000) }} views</span>
                            </div>
                            
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ rand(20, 200) }} likes</span>
                            </div>
                            
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ rand(5, 50) }} comments</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Article Content -->
                    <div class="prose prose-lg dark:prose-invert max-w-none">
                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed text-lg">
                            <div class="prose prose-lg dark:prose-invert max-w-none">
                                <div class="text-gray-700 dark:text-gray-300 leading-relaxed text-lg article-content">
                                    {!! $article->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Article Footer -->
                    <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <!-- Tags -->
                            <div class="flex flex-wrap gap-2">
                                @foreach($article->categories as $category)
                                    <a href="{{ route('categories.show', $category) }}" 
                                       class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full border transition-all duration-200 hover:scale-105"
                                       style="color: {{ $category->color }}; border-color: {{ $category->color }}20; background-color: {{ $category->color }}10;">
                                        <span class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $category->color }};"></span>
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                            
                            <!-- Share Buttons -->
                            <div class="flex items-center space-x-3">
                                <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">Share:</span>
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->fullUrl()) }}" 
                                   target="_blank"
                                   class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </a>
                                
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                                   target="_blank"
                                   class="p-2 bg-blue-800 hover:bg-blue-900 text-white rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" 
                                   target="_blank"
                                   class="p-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            
            <!-- Related Articles Section -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50 p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    Related Articles
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- You would fetch related articles here based on categories or tags -->
                    <!-- For now, showing placeholder content -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 hover:bg-gray-100 dark:hover:bg-gray-700/70 transition-colors">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Related Article Title</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">Brief excerpt of the related article content...</p>
                        <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">Read more →</a>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 hover:bg-gray-100 dark:hover:bg-gray-700/70 transition-colors">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Another Related Article</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">Brief excerpt of another related article...</p>
                        <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">Read more →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>