<ul class="space-y-2 pl-4">
    @foreach ($categories as $category)
        {{-- Display each category with a link and its color --}}
        <li class="relative">
            <span class="absolute -left-4 top-0 h-full border-l-2 border-gray-200 dark:border-gray-700"></span>
            <span class="absolute -left-4 top-4 h-px w-4 border-t-2 border-gray-200 dark:border-gray-700"></span>

            <a href="{{ route('categories.show', $category['id']) }}" class="flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                <span class="flex-shrink-0 w-3 h-3 rounded-full" style="background-color: {{ $category['color'] }};"></span>
                <span class="font-medium">{{ $category['name'] }}</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">({{ $category['news_count'] ?? 0 }})</span>
            </a>
            
            {{-- Recursively include children if they exist --}}
            @if (!empty($category['children']))
                <div class="mt-2">
                    @include('partials.category-tree', ['categories' => $category['children']])
                </div>
            @endif
        </li>
    @endforeach
</ul>