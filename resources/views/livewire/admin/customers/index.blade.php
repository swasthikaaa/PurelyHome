<div class="min-h-screen flex bg-gray-50 text-gray-900">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col shadow-sm">
        <div class="h-16 flex items-center justify-center border-b">
            <img src="{{ asset('images/purelyhomelogo.png') }}" alt="PurelyHome Logo" class="h-12 w-auto object-contain">
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.products.*') ? 'bg-gray-200 font-semibold' : '' }}">
                Products
            </a>
            <a href="{{ route('admin.customers.index') }}" 
               class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.customers.*') ? 'bg-gray-200 font-semibold' : '' }}">
                Customers
            </a>
            <a href="{{ route('admin.orders.index') }}" 
               class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-200 font-semibold' : '' }}">
                Orders
            </a>
        </nav>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="h-16 bg-white border-b flex items-center justify-between px-6 shadow-sm">
            <h1 class="text-lg font-semibold">Customers</h1>
        </header>

        <!-- ✅ Global Flash Message Container -->
        <div id="flashMessage"
             class="hidden fixed top-4 right-4 max-w-sm px-4 py-3 rounded-lg shadow-lg z-[9999]
                    text-sm font-medium flex items-center gap-2 text-white">
        </div>

        <!-- Table Section -->
        <main class="flex-1 p-6 space-y-6">
            <div class="bg-white rounded-xl shadow p-5">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="p-3"></th>
                                <th class="p-3">ID</th>
                                <th class="p-3">Name</th>
                                <th class="p-3">Email</th>
                                <th class="p-3">Status</th>
                                <th class="p-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                                <tr class="hover:bg-gray-50 border-b">
                                    <td class="p-3 text-center">
                                        <input type="checkbox" wire:model="selected" class="customerCheckbox" value="{{ $customer->id }}">
                                    </td>
                                    <td class="p-3">{{ $customer->id }}</td>
                                    <td class="p-3">{{ $customer->name }}</td>
                                    <td class="p-3">{{ $customer->email }}</td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $customer->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ ucfirst($customer->status) }}
                                        </span>
                                    </td>
                                    <td class="p-3 flex gap-2 justify-center">
                                        <button wire:click="toggleStatus({{ $customer->id }})"
                                                class="px-3 py-1 text-xs rounded bg-gray-700 text-white hover:bg-gray-700 transition">
                                            {{ $customer->status === 'active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                        <button wire:click="confirmDelete({{ $customer->id }})"
                                                class="px-3 py-1 text-xs rounded bg-red-500 text-white hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-4 text-gray-500">No customers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $customers->links() }}</div>
            </div>
        </main>
    </div>

    <!-- Delete Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md text-center">
                <div class="w-12 h-12 mx-auto flex items-center justify-center bg-red-100 rounded-full mb-4">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path d="M2.875 5.75h1.917m0 0h15.333m-15.333 0v13.417a1.917 1.917 0 0 0 1.916 1.916h9.584a1.917 1.917 0 0 0 1.916-1.916V5.75m-10.541 0V3.833a1.917 1.917 0 0 1 1.916-1.916h3.834a1.917 1.917 0 0 1 1.916 1.916V5.75m-5.75 4.792v5.75m3.834-5.75v5.75"
                              stroke="#DC2626" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold">Are you sure?</h2>
                <p class="text-sm text-gray-600 mt-2">
                    You are about to delete {{ count($selected) }} customer(s) and their related orders.<br>
                    This action cannot be undone.
                </p>
                <div class="flex justify-center gap-4 mt-6">
                    <button type="button" wire:click="$set('showDeleteModal', false)"
                            class="px-4 py-2 rounded border border-gray-300 bg-white hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="button" wire:click="deleteSelected"
                            class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
