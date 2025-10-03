import './bootstrap'; // ensures axios config is loaded
import { getAuthHeaders, showFlashMessage } from './bootstrap';

let productToDelete = null;

// ---------------- Fetch Products ----------------
async function fetchProducts() {
    try {
        const res = await axios.get('/admin-products', { headers: getAuthHeaders() });
        const table = document.getElementById('productsTable');
        table.innerHTML = '';

        const products = res.data?.data || [];
        if (products.length === 0) {
            table.innerHTML = '<tr><td colspan="11" class="p-4 text-center text-gray-500">No products found</td></tr>';
        } else {
            products.forEach(p => table.innerHTML += renderRow(p));
        }
    } catch (err) {
        console.error("❌ Fetch products failed:", err.response?.data || err.message);
        showFlashMessage('❌ Failed to load products.', 'error');
    }
}

// ---------------- Render Row  ----------------
function renderRow(p) {
    return `
        <tr class="hover:bg-gray-50 transition">
            <td class="p-3 text-center">
                <input type="checkbox" class="rowCheckbox" value="${p.id}" />
            </td>
            <td class="p-3">${p.id}</td>
            <td class="p-3">
                ${p.image ? `<img src="${p.image}" class="w-16 h-16 object-cover rounded" />` : '—'}
            </td>
            <td class="p-3">${p.name ?? '—'}</td>
            <td class="p-3">${p.category?.name ?? '—'}</td>
            <td class="p-3">Rs ${p.price ?? '—'}</td>
            <td class="p-3">${p.offer_price ?? '—'}</td>
            <td class="p-3">${p.quantity ?? '—'}</td>
            <td class="p-3">${p.is_active ? 'Yes' : 'No'}</td>
            <td class="p-3">${p.description ?? '—'}</td>
            <td class="p-3 text-center"></td>
        </tr>
    `;
}

// ---------------- Modal Open / Close ----------------
function openProductForm(p = null) {
    const modal = document.getElementById('productModal');
    modal.classList.remove('hidden');
    document.getElementById('formTitle').innerText = p ? 'Edit Product' : 'Add Product';
    const form = document.getElementById('productForm');

    if (p) {
        document.getElementById('productId').value = p.id;
        document.getElementById('name').value = p.name || '';
        document.getElementById('category_id').value = p.category_id ?? '';
        document.getElementById('price').value = p.price ?? '';
        document.getElementById('offer_price').value = p.offer_price ?? '';
        document.getElementById('quantity').value = p.quantity ?? '';
        document.getElementById('is_active').value = p.is_active ? 1 : 0;
        document.getElementById('description').value = p.description ?? '';

        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        const changeBtn = document.getElementById('changeImageBtn');

        if (p.image) {
            preview.src = p.image;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            changeBtn.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            changeBtn.classList.add('hidden');
        }
    } else {
        form.reset();
        document.getElementById('productId').value = '';

        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        const changeBtn = document.getElementById('changeImageBtn');

        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        changeBtn.classList.add('hidden');
    }
}

function closeProductForm() {
    const modal = document.getElementById('productModal');
    modal.classList.add('hidden');
    document.getElementById('productForm').reset();

    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    const changeBtn = document.getElementById('changeImageBtn');

    preview.classList.add('hidden');
    placeholder.classList.remove('hidden');
    changeBtn.classList.add('hidden');
}

// ---------------- Save / Edit / Delete ----------------
async function saveProduct(e) {
    e.preventDefault();
    const id = document.getElementById('productId').value;
    const form = document.getElementById('productForm');
    const fd = new FormData(form);

    try {
        if (id) {
            await axios.post(`/admin-products/${id}`, fd, {
                headers: { ...getAuthHeaders(), 'X-HTTP-Method-Override': 'PATCH' }
            });
            showFlashMessage('✅ Product updated.');
        } else {
            await axios.post('/admin-products', fd, { headers: getAuthHeaders() });
            showFlashMessage('✅ Product created.');
        }
        closeProductForm();
        fetchProducts();
    } catch (err) {
        console.error("❌ Save failed:", err.response?.data || err.message);
        showFlashMessage('❌ Failed to save product.', 'error');
    }
}

// ---------------- Bulk Edit (top button) ----------------
async function editSelected() {
    const checked = document.querySelectorAll('.rowCheckbox:checked');
    if (checked.length !== 1) {
        showFlashMessage('❌ Please select exactly 1 product to edit.', 'error');
        return;
    }
    const id = checked[0].value;
    await editSelectedSingle(id);
}

async function editSelectedSingle(id) {
    try {
        const res = await axios.get(`/admin-products/${id}`, { headers: getAuthHeaders() });
        openProductForm(res.data.data);
    } catch (err) {
        console.error("❌ Edit failed:", err.response?.data || err.message);
        showFlashMessage('❌ Failed to fetch product.', 'error');
    }
}

// ---------------- Bulk Delete (top button) ----------------
function deleteSelected() {
    const checked = document.querySelectorAll('.rowCheckbox:checked');
    if (checked.length !== 1) {
        showFlashMessage('❌ Please select one product to delete.', 'error');
        return;
    }
    productToDelete = checked[0].value;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    productToDelete = null;
    document.getElementById('deleteModal').classList.add('hidden');
}

async function confirmDeleteProduct() {
    if (!productToDelete) return;
    try {
        await axios.delete(`/admin-products/${productToDelete}`, { headers: getAuthHeaders() });
        showFlashMessage('✅ Product deleted.');
        fetchProducts();
    } catch (err) {
        console.error("❌ Delete failed:", err.response?.data || err.message);
        showFlashMessage('❌ Failed to delete product.', 'error');
    }
    closeDeleteModal();
}

// ---------------- Image Preview ----------------
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    const changeBtn = document.getElementById('changeImageBtn');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            changeBtn.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// ---------------- Init ----------------
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('productForm').addEventListener('submit', saveProduct);
    document.getElementById('bulkEditBtn').addEventListener('click', editSelected); // top button edit
    document.getElementById('bulkDeleteBtn').addEventListener('click', deleteSelected); // top button delete
    document.querySelector('[data-action="addProduct"]').addEventListener('click', () => openProductForm());
    document.querySelector('[data-action="cancelProduct"]').addEventListener('click', closeProductForm);
    document.querySelector('[data-action="cancelDelete"]').addEventListener('click', closeDeleteModal);
    document.querySelector('[data-action="confirmDelete"]').addEventListener('click', confirmDeleteProduct);
    document.getElementById('image').addEventListener('change', (e) => previewImage(e.target));

    fetchProducts();
});

// ---------------- Expose to global scope ----------------
window.openProductForm = openProductForm;
window.closeProductForm = closeProductForm;
window.editSelected = editSelected;
window.deleteSelected = deleteSelected;
window.closeDeleteModal = closeDeleteModal;
window.confirmDeleteProduct = confirmDeleteProduct;
