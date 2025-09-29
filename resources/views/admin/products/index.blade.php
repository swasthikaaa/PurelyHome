<x-app-layout>
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
        <!-- Header/Navbar -->
        <header class="h-16 bg-white border-b flex items-center justify-between px-6 shadow-sm">
            <h1 class="text-lg font-semibold">Products</h1>
            <div class="flex items-center gap-2">
                <button data-action="addProduct"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                    Add Product
                </button>
                <button id="bulkEditBtn"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                    Edit Selected
                </button>
                <button id="bulkDeleteBtn"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                    Delete Selected
                </button>
            </div>
        </header>

        <!-- Flash Message -->
        <div id="flashMessage" class="hidden px-6 py-3"></div>

        <!-- Table Section -->
        <main class="flex-1 p-6 space-y-6">
            <div class="bg-white rounded-xl shadow p-5">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="p-3">Select</th>
                                <th class="p-3">ID</th>
                                <th class="p-3">Image</th>
                                <th class="p-3">Name</th>
                                <th class="p-3">Category</th>
                                <th class="p-3">Price</th>
                                <th class="p-3">Offer Price</th>
                                <th class="p-3">Qty</th>
                                <th class="p-3">Active</th>
                                <th class="p-3">Description</th>
                            </tr>
                        </thead>
                        <tbody id="productsTable" class="divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="productModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-4xl p-6 rounded-xl shadow-lg">
        <h2 id="formTitle" class="text-xl font-bold mb-4">Add Product</h2>

        <form id="productForm" enctype="multipart/form-data">
            <input type="hidden" id="productId" name="id">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Image Upload -->
                <div class="flex flex-col">
                    <label class="font-semibold mb-2 text-center">Product Image</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-3 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer relative w-full h-48"
                         onclick="document.getElementById('image').click()">
                        <input type="file" name="image" id="image" class="hidden" accept="image/*">
                        <div id="uploadPlaceholder" class="flex flex-col items-center justify-center text-gray-500">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <p class="text-sm font-medium">Click to upload</p>
                            <p class="text-xs">PNG, JPG, JPEG</p>
                        </div>
                        <img id="imagePreview" class="hidden w-full h-full object-cover rounded" />
                        <div id="changeImageBtn" class="hidden absolute top-2 right-2">
                            <button type="button" class="px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                                Change
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Fields -->
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold block mb-1">Name</label>
                        <input type="text" name="name" id="name" class="w-full border border-gray-300 p-2 rounded" required>
                    </div>
                    <div>
                        <label class="font-semibold block mb-1">Category</label>
                        <select name="category_id" id="category_id" class="w-full border border-gray-300 p-2 rounded">
                            @foreach(\App\Models\Category::all() as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="font-semibold block mb-1">Price</label>
                            <input type="number" step="0.01" name="price" id="price" class="w-full border border-gray-300 p-2 rounded" required>
                        </div>
                        <div>
                            <label class="font-semibold block mb-1">Offer Price</label>
                            <input type="number" step="0.01" name="offer_price" id="offer_price" class="w-full border border-gray-300 p-2 rounded">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="font-semibold block mb-1">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="w-full border border-gray-300 p-2 rounded" required>
                        </div>
                        <div>
                            <label class="font-semibold block mb-1">Active</label>
                            <select name="is_active" id="is_active" class="w-full border border-gray-300 p-2 rounded">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="font-semibold block mb-1">Description</label>
                        <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 p-2 rounded"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-6 pt-4 border-t">
                <button type="button" data-action="cancelProduct"
                        class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Save Product
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 flex items-center justify-center bg-black/50 z-50">
    <div class="flex flex-col items-center bg-white shadow-md rounded-xl py-6 px-5 md:w-[460px] w-[370px] border border-gray-300">
        <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path d="M2.875 5.75h1.917m0 0h15.333m-15.333 0v13.417a1.917 1.917 0 0 0 1.916 1.916h9.584a1.917 1.917 0 0 0 1.916-1.916V5.75m-10.541 0V3.833a1.917 1.917 0 0 1 1.916-1.916h3.834a1.917 1.917 0 0 1 1.916 1.916V5.75m-5.75 4.792v5.75m3.834-5.75v5.75" stroke="#DC2626" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
        <h2 class="text-gray-900 font-semibold mt-4 text-xl">Are you sure?</h2>
        <p class="text-sm text-gray-600 mt-2 text-center">
            You are about to delete this product. This action cannot be undone.
        </p>
        <div class="flex items-center justify-center gap-4 mt-5 w-full">
            <button type="button" data-action="cancelDelete"
                    class="w-full md:w-36 h-10 rounded-md border border-gray-300 bg-white text-black hover:bg-gray-100">
                Cancel
            </button>
            <button type="button" data-action="confirmDelete"
                    class="w-full md:w-36 h-10 rounded-md text-white bg-red-600 hover:bg-red-700">
                Confirm
            </button>
        </div>
    </div>
</div>

<!-- Load compiled products.js -->
@vite(['resources/js/products.js'])
</x-app-layout>
