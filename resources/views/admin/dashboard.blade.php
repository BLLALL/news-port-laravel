{{-- resources/views/admin/dashboard.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['total_articles'] }}</div>
                    <div class="text-gray-600 dark:text-gray-400">Total Articles</div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-2xl font-bold text-green-600">{{ $stats['total_categories'] }}</div>
                    <div class="text-gray-600 dark:text-gray-400">Categories</div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['total_users'] }}</div>
                    <div class="text-gray-600 dark:text-gray-400">Users</div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-2xl font-bold text-orange-600">{{ $stats['recent_articles'] }}</div>
                    <div class="text-gray-600 dark:text-gray-400">This Week</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Quick Actions</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('admin.articles.create') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create Article
                        </a>
                        <a href="{{ route('admin.categories.create') }}" 
                           class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Create Category
                        </a>
                        <a href="{{ route('admin.articles.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Manage Articles
                        </a>
                        <a href="{{ route('admin.categories.index') }}" 
                           class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Manage Categories
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Articles & Popular Categories -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Articles -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Recent Articles</h3>
                        <div class="space-y-3">
                            @foreach($recentArticles as $article)
                                <div class="flex justify-between items-center border-b pb-2">
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ Str::limit($article->title, 50) }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $article->created_at->diffForHumans() }}</div>
                                    </div>
                                    <a href="{{ route('admin.articles.edit', $article) }}" 
                                       class="text-blue-600 hover:text-blue-900">Edit</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Popular Categories -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Popular Categories</h3>
                        <div class="space-y-3">
                            @foreach($popularCategories as $category)
                                <div class="flex justify-between items-center border-b pb-2">
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-gray-100">{{ $category->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $category->articles_count }} articles</div>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.categories.edit', $category) }}" 
                                       class="text-blue-600 hover:text-blue-900">Edit</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>