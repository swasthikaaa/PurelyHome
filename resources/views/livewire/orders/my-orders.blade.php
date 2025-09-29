<x-app-layout>
<div>
    {{-- Navbar --}}
    @include('partials.navbar')

    <!-- Main Content -->
    <div class="pt-28 pb-16 max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Left: Order Details -->
        <div class="space-y-6">
            @forelse($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold">Order #{{ $order->_id }}</h2>
                    <p class="text-sm text-gray-500 mb-4">
                        Status: {{ ucfirst($order->status) }} <br>
                        Date: {{ $order->order_date->timezone('Asia/Colombo')->format('d M Y, h:i A') }}
                    </p>

                    @foreach($order->orderItems as $item)
                        <div class="flex items-center gap-4 border-t pt-4">
                            <div class="w-20 h-20 border rounded overflow-hidden">
                                <img src="{{ $item->product?->image 
                                            ? asset('storage/'.$item->product->image) 
                                            : 'https://via.placeholder.com/100' }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium">{{ $item->product?->name ?? 'Unknown Product' }}</h3>
                                <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right font-semibold">
                                Rs {{ $item->price * $item->quantity }}
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-4 font-bold text-right">
                        Total: Rs {{ $order->orderItems->sum(fn($i) => $i->price * $i->quantity) }}
                    </div>
                </div>
            @empty
                <p>No orders found.</p>
            @endforelse
        </div>

        <!-- Right: Payment Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Payment Details</h2>

            {{-- 🔴 Error Messages --}}
            @if($errors->any())
                <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="paymentForm" action="{{ route('payments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="amount" 
                       value="{{ $orders->last()?->orderItems->sum(fn($i) => $i->price * $i->quantity) ?? 0 }}">
                <input type="hidden" name="order_id" value="{{ $orders->last()?->_id }}">

                <!-- Payment Method -->
                <div class="mb-4">
                    <label class="block font-medium mb-2">Select Payment Method:</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="method" value="cod" required class="cursor-pointer">
                            Cash on Delivery
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="method" value="card" required class="cursor-pointer">
                            Credit/Debit Card
                        </label>
                    </div>
                </div>
<!-- COD Fields -->
<div id="codFields" class="hidden space-y-4">
    <input type="text" name="cod_name" placeholder="Full Name" class="w-full border p-2 rounded-lg" required>

    <!-- Logged in email shown, readonly -->
    <input type="email" value="{{ Auth::user()->email }}" 
           class="w-full border p-2 rounded-lg bg-gray-100 cursor-not-allowed" readonly>

    <input type="text" name="cod_address" placeholder="Delivery Address" class="w-full border p-2 rounded-lg" required>
    <input type="text" name="cod_city" placeholder="City" class="w-full border p-2 rounded-lg" required>
    <input type="text" name="cod_state" placeholder="State/Province" class="w-full border p-2 rounded-lg" required>
    <input type="text" name="cod_zip" placeholder="Postal Code (5 digits)" class="w-full border p-2 rounded-lg"
           minlength="5" maxlength="5" pattern="^[0-9]{5}$"
           oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,5)" required>
    <input type="tel" name="cod_phone" placeholder="Phone Number (07XXXXXXXX)" class="w-full border p-2 rounded-lg"
           pattern="^07[0-9]{8}$"
           oninput="this.value=this.value.replace(/[^0-9]/g,''); if(!this.value.startsWith('07')) this.value='07'; this.value=this.value.slice(0,10)" required>
    <textarea name="cod_notes" placeholder="Additional Notes (optional)" class="w-full border p-2 rounded-lg"></textarea>
</div>

<!-- Card Fields -->
<div id="cardFields" class="hidden space-y-4">
    <input type="text" name="card_number" placeholder="Card Number (16 digits)" 
           class="w-full border p-2 rounded-lg" minlength="16" maxlength="16"
           pattern="^[0-9]{16}$"
           oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,16)" required>

    <input type="text" id="expiry" name="expiry" placeholder="Expiry Date (MM/YY e.g., 09/28)" 
           class="w-full border p-2 rounded-lg" minlength="5" maxlength="5"
           pattern="^(0[1-9]|1[0-2])/[0-9]{2}$"
           oninput="this.value=this.value.replace(/[^0-9/]/g,'').slice(0,5)" required>

    <input type="text" name="cvv" placeholder="CVV (3 digits)" 
           class="w-full border p-2 rounded-lg" minlength="3" maxlength="3"
           pattern="^[0-9]{3}$"
           oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,3)" required>

    <input type="text" name="card_address" placeholder="Billing Address" class="w-full border p-2 rounded-lg" required>

    <input type="tel" name="card_phone" placeholder="Phone Number (07XXXXXXXX)" 
           class="w-full border p-2 rounded-lg"
           pattern="^07[0-9]{8}$"
           oninput="this.value=this.value.replace(/[^0-9]/g,''); if(!this.value.startsWith('07')) this.value='07'; this.value=this.value.slice(0,10)" required>

    <!-- Logged in email shown, readonly -->
    <input type="email" value="{{ Auth::user()->email }}" 
           class="w-full border p-2 rounded-lg bg-gray-100 cursor-not-allowed" readonly>
</div>


                <!-- Pay Now Button -->
                <button type="submit"
                        class="w-full block text-center py-3 bg-black text-white rounded-lg font-medium hover:bg-gray-900 transition mt-4">
                    Pay Now
                </button>
            </form>

            <div class="mt-6">
                <p class="text-sm text-gray-600 mb-2">We accept:</p>
                <div class="flex items-center space-x-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="MasterCard" class="h-8">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa" class="h-8">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" class="h-8">
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="mt-auto">
        @include('partials.footer')
    </footer>
</div>
</x-app-layout>
