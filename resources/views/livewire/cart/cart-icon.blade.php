<a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-black">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9h14l-2-9M16 16a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>
    @if($count > 0)
        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full 
                     w-5 h-5 flex items-center justify-center">
            {{ $count }}
        </span>
    @endif
</a>
