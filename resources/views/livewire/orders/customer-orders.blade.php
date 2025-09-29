<div class="min-h-screen flex flex-col">
    {{-- Navbar --}}
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="flex-grow pt-28 pb-16 max-w-7xl mx-auto px-6 w-full">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">My Orders</h1>

            <!-- Sort Button -->
            <button wire:click="toggleSort"
                class="flex items-center gap-2 px-4 py-2 bg-black text-white text-sm rounded hover:bg-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 13.414V20a1 1 0 01-1.447.894l-4-2A1 1 0 019 18v-4.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
                Sort by: {{ $sortDirection === 'asc' ? 'Oldest First' : 'Newest First' }}
            </button>
        </div>

        <!-- Orders Table -->
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            @if($orders->isNotEmpty())
                <table class="min-w-full border border-gray-200 text-sm text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="px-4 py-3 border">Order #</th>
                            <th class="px-4 py-3 border">Date</th>
                            <th class="px-4 py-3 border">Items</th>
                            <th class="px-4 py-3 border">Status</th>
                            <th class="px-4 py-3 border text-right">Total (Rs)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <!-- Order ID -->
                                <td class="px-4 py-3 border font-semibold text-gray-800">
                                    #{{ substr($order->_id, -6) }}
                                </td>

                                <!-- Date -->
                                <td class="px-4 py-3 border">
                                    {{ $order->order_date->timezone(config('app.timezone'))->format('d M Y, h:i A') }}
                                </td>

                                <!-- Items -->
                                <td class="px-4 py-3 border">
                                    <ul class="space-y-2">
                                        @foreach($order->orderItems as $item)
                                            <li class="flex items-center gap-2">
                                                <div class="w-8 h-8 border rounded overflow-hidden">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset('storage/'.$item->product->image) }}"
                                                             alt="{{ $item->product->name }}"
                                                             class="w-full h-full object-cover">
                                                    @else
                                                        <img src="https://via.placeholder.com/40"
                                                             alt="No Image"
                                                             class="w-full h-full object-cover">
                                                    @endif
                                                </div>
                                                <span class="text-gray-800">
                                                    {{ $item->product?->name ?? 'Unknown Product' }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    (x{{ $item->quantity }})
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>

                                <!-- Status -->
                                <td class="px-4 py-3 border text-center">
                                    <span class="px-2 py-1 text-xs font-semibold rounded
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>

                                <!-- Total -->
                                <td class="px-4 py-3 border text-right font-bold text-gray-800">
                                    {{ $order->orderItems->sum(fn($i) => $i->price * $i->quantity) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 p-6">You have no orders yet.</p>
            @endif
        </div>
    </main>

    {{-- Footer always at bottom --}}
    <footer class="mt-auto">
        @include('partials.footer')
    </footer>
</div>
