<ul class="space-y-2">
    @foreach ($categories as $category)
        <li>
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                    {{ in_array($category->id, $selected) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                <span class="w-3 h-3 rounded-full" style="background-color: {{ $category->color }};"></span>
                <span>{{ $category->name }}</span>
            </label>
            @if (!empty($category->children))
                <div class="pl-8 mt-2">
                    @include('partials.category-filter', ['categories' => $category->children, 'selected' => $selected])
                </div>
            @endif
        </li>
    @endforeach
</ul>