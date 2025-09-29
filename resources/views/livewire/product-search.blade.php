<div class="relative w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg">
    <!-- Search Input -->
    <input type="text"
           wire:model.live.debounce.500ms="q"
           placeholder="Search products..."
           class="w-full h-10 px-4 rounded-full border border-gray-300 
                  focus:outline-none focus:ring-2 focus:ring-black text-sm sm:text-base" />

    <!-- Dropdown Results -->
    @if(!empty($results))
        <div class="absolute mt-2 w-full bg-white border rounded-lg shadow z-50 max-h-64 overflow-y-auto">
            @foreach($results as $item)
                <!-- ✅ now links to /products?q=ProductName -->
                <a href="{{ url('/products?q='.$item->name) }}"
                   class="block px-4 py-2 text-sm sm:text-base text-gray-700 hover:bg-gray-100 truncate">
                    {{ $item->name }}
                </a>
            @endforeach
        </div>
    @endif
</div>
