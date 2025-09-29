import './bootstrap';
import Chart from 'chart.js/auto';
import axios from 'axios';

// ---------------------------
// ✅ Flash Message Utility
// ---------------------------
window.showFlashMessage = function (message = 'Action completed.', type = 'success') {
    let div = document.getElementById('flashMessage');
    if (!div) {
        div = document.createElement('div');
        div.id = 'flashMessage';
        div.style.display = 'none';
        document.body.appendChild(div);
    }

    // Colors + icons
    const styles = {
        success: { bg: 'bg-green-600', icon: '✅' },
        error:   { bg: 'bg-red-600', icon: '❌' },
        warning: { bg: 'bg-yellow-500', icon: '⚠️' },
        info:    { bg: 'bg-blue-600', icon: 'ℹ️' },
    };

    const style = styles[type] || styles.success;

    div.className = `fixed top-4 right-4 max-w-sm px-4 py-3 rounded-lg shadow-lg z-[9999]
                     text-sm font-medium flex items-center gap-2 text-white ${style.bg}`;
    div.innerHTML = `<span class="text-lg">${style.icon}</span> <span>${message}</span>`;

    div.style.display = 'flex';
    div.style.opacity = '1';

    clearTimeout(div._timeout);
    div._timeout = setTimeout(() => {
        div.style.display = 'none';
    }, 4000);
};

// ---------------------------
// ✅ Sidebar Toggle
// ---------------------------
function toggleSidebar(show) {
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    if (!sidebar || !overlay) return;
    if (show) {
        sidebar.classList.remove('hidden');
        overlay.classList.remove('hidden');
    } else {
        sidebar.classList.add('hidden');
        overlay.classList.add('hidden');
    }
}

// ---------------------------
// ✅ DOM Ready
// ---------------------------
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM Ready: app.js loaded');

    // Sidebar toggle
    const sidebarToggleBtn = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    if (sidebarToggleBtn) sidebarToggleBtn.addEventListener('click', () => toggleSidebar(true));
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', () => toggleSidebar(false));

    // Carousel logic
    const carousel = document.getElementById('carousel');
    const nextBtn = document.getElementById('next');
    const prevBtn = document.getElementById('prev');
    if (carousel && nextBtn && prevBtn) {
        const slides = carousel.children;
        let index = 0;
        const updateCarousel = () => {
            carousel.style.transform = `translateX(-${index * 100}%)`;
        };
        nextBtn.addEventListener('click', () => {
            index = (index + 1) % slides.length;
            updateCarousel();
        });
        prevBtn.addEventListener('click', () => {
            index = (index - 1 + slides.length) % slides.length;
            updateCarousel();
        });
    }


    // Sales chart
    const chartCanvas = document.getElementById('salesForecastChart');
    if (chartCanvas) {
        new Chart(chartCanvas.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul'],
                datasets: [
                    {
                        label: 'Actual Sales',
                        data: [1200,1900,3000,2500,3200,4000,3800],
                        borderColor: 'rgba(75,192,192,1)',
                        backgroundColor: 'rgba(75,192,192,0.2)',
                        tension: 0.4,
                        fill: true,
                    },
                    {
                        label: 'Forecast',
                        data: [1300,2000,3100,2800,3500,4200,4500],
                        borderColor: 'rgba(255,99,132,1)',
                        backgroundColor: 'rgba(255,99,132,0.2)',
                        borderDash: [5,5],
                        tension: 0.4,
                        fill: true,
                    }
                ]
            },
            options: { responsive: true, plugins: { legend: { position: 'top' } } }
        });
    }

    // Monthly Target Chart
    const targetCanvas = document.getElementById('monthlyTargetChart');
    if (targetCanvas) {
        const targetCtx = targetCanvas.getContext('2d');
        new Chart(targetCtx, {
            type: 'doughnut',
            data: {
                labels: ['Achieved', 'Remaining'],
                datasets: [{
                    data: [75.5, 24.5],
                    backgroundColor: ['#6366F1', '#E5E7EB'],
                    borderWidth: 0
                }]
            },
            options: { cutout: '75%', plugins: { legend: { display: false } } }
        });
    }
    // ---------------------------
    // ✅ Payment Form Logic
    // ---------------------------
    const codFields = document.getElementById('codFields');
    const cardFields = document.getElementById('cardFields');
    const paymentMethods = document.querySelectorAll('input[name="method"]');
    const paymentForm = document.getElementById('paymentForm');

    // helper: set required dynamically
    function setRequired(fields, required) {
        if (!fields) return;
        fields.querySelectorAll('input,textarea').forEach(el => {
            if (required) {
                el.setAttribute('required', 'required');
            } else {
                el.removeAttribute('required');
            }
        });
    }

    function toggleFields() {
        const selected = document.querySelector('input[name="method"]:checked')?.value;

        if (selected === 'cod') {
            codFields?.classList.remove('hidden');
            cardFields?.classList.add('hidden');
            setRequired(codFields, true);
            setRequired(cardFields, false);
        } else if (selected === 'card') {
            cardFields?.classList.remove('hidden');
            codFields?.classList.add('hidden');
            setRequired(cardFields, true);
            setRequired(codFields, false);
        } else {
            codFields?.classList.add('hidden');
            cardFields?.classList.add('hidden');
            setRequired(codFields, false);
            setRequired(cardFields, false);
        }
    }

    paymentMethods.forEach(m => m.addEventListener('change', toggleFields));
    toggleFields();

    if (paymentForm) {
        paymentForm.addEventListener('submit', function (e) {
            const selected = document.querySelector('input[name="method"]:checked')?.value;

            if (!selected) {
                e.preventDefault();
                return window.showFlashMessage('Please select a payment method.', 'warning');
            }

            if (selected === 'card') {
                const cardNumber = document.querySelector('input[name="card_number"]')?.value.trim();
                const expiry = document.querySelector('input[name="expiry"]')?.value.trim();
                const cvv = document.querySelector('input[name="cvv"]')?.value.trim();

                if (!cardNumber || cardNumber.length !== 16) {
                    e.preventDefault();
                    return window.showFlashMessage('Invalid card number (16 digits required).', 'error');
                }
                if (!cvv || cvv.length !== 3) {
                    e.preventDefault();
                    return window.showFlashMessage('Invalid CVV (3 digits required).', 'error');
                }
                if (expiry) {
                    const [month, year] = expiry.split('/');
                    const expMonth = parseInt(month, 10);
                    const expYear = 2000 + parseInt(year, 10);
                    const now = new Date();
                    if (
                        isNaN(expMonth) || isNaN(expYear) ||
                        expMonth < 1 || expMonth > 12 ||
                        expYear < now.getFullYear() ||
                        (expYear === now.getFullYear() && expMonth < now.getMonth() + 1)
                    ) {
                        e.preventDefault();
                        return window.showFlashMessage('Invalid expiry date.', 'error');
                    }
                }
            }

            // ✅ If validation passes, let the form submit normally
        });
    }

    // ---------------------------
    // ✅ Bulk customers delete trigger
    // ---------------------------
    const bulkDeleteCustomerBtn = document.getElementById('bulkDeleteCustomerBtn');
    if (bulkDeleteCustomerBtn) {
        bulkDeleteCustomerBtn.addEventListener('click', () => {
            const selected = Array.from(document.querySelectorAll('.customerCheckbox:checked')).map(cb => cb.value);
            if (!selected.length) {
                window.showFlashMessage('Select at least one customer.', 'warning');
            } else {
                window.Livewire?.emit?.('confirmBulkDelete');
            }
        });
    }
});


// ---------------------------
// ✅ Livewire v3 Flash Message Handler
// ---------------------------
document.addEventListener("livewire:init", () => {
    if (window.Livewire && window.Livewire.on) {
        Livewire.on("customFlash", (data) => {
            const message = data?.message || "Action completed.";
            const type = data?.type || "success";
            window.showFlashMessage(message, type);
        });
    }
});

// For manual testing in console
window.testFlashMessage = function(message = 'Test message', type = 'success') {
    window.showFlashMessage(message, type);
};
