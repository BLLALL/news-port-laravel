<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
    @if ($article->image)
        <a href="{{ route('news.show', $article) }}">
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
        </a>
    @endif
    <div class="p-4">
        <h4 class="text-lg font-bold mb-2 truncate">
            <a href="{{ route('news.show', $article) }}" class="hover:text-blue-600">{{ $article->title }}</a>
        </h4>
        <div class="text-sm text-gray-600 mb-4 h-20 overflow-hidden">
            {!! Str::limit(strip_tags($article->content), 120) !!}
        </div>
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach ($article->categories ?? [] as $category)
                <span class="px-2 py-1 text-xs text-white rounded-full" style="background-color: {{ $category->color }};">
                    {{ $category->name }}
                </span>
            @endforeach
        </div>
        <div class="flex justify-between items-center text-xs text-gray-500">
            <span>By {{ $article->author->name }}</span>
            <span>{{ $article->created_at->format('M j, Y') }}</span>
        </div>
        <a href="{{ route('news.show', $article) }}" class="inline-block mt-4 text-sm font-semibold text-blue-600 hover:underline">Read Full Article →</a>
    </div>
</div>