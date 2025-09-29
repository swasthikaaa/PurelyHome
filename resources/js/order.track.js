const trackingIdEl = document.getElementById("trackingId");
const stepsEl = document.getElementById("trackingSteps");
const productsEl = document.getElementById("productsList");
const billingEl = document.getElementById("billingDetails");
const downloadBtn = document.getElementById("downloadInvoiceBtn");

async function fetchTracking() {
    try {
        const res = await fetch("/orders/latest-tracking", {
            headers: {
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        });

        if (!res.ok) {
            throw new Error(`HTTP error! Status: ${res.status}`);
        }

        const order = await res.json();

        if (!order) {
            trackingIdEl.textContent = "No recent orders found.";
            stepsEl.innerHTML = "";
            productsEl.innerHTML = "";
            billingEl.innerHTML = "";
            return;
        }

        trackingIdEl.textContent = "Tracking Id: #" + order.tracking_id;

        // Steps
        const steps = [
            { label: "Order placed", at: order.placed_at },
            { label: "Arrived at courier warehouse", at: order.arrived_at },
            { label: "Out for delivery", at: order.out_for_delivery_at },
            { label: "Delivered", at: order.delivered_at },
        ];

        stepsEl.innerHTML = steps.map(s => `
            <li>
              <span class="flex h-9 w-9 mb-4 items-center justify-center rounded-full 
                ${s.at ? 'bg-blue-200' : 'bg-gray-200'} ring-8 ring-white">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ${s.at ? 'fill-blue-700' : 'fill-slate-900'}" viewBox="0 0 24 24">
                      <path d="M22.05 4.8c-.6-.6-1.5-.6-2.1 0L8.7 16.05 4.05 11.4c-.6-.6-1.5-.6-2.1 0s-.6 1.5 0 2.1l5.7 5.7c.3.3.6.45 1.05.45s.75-.15 1.05-.45l12.3-12.3c.6-.6.6-1.5 0-2.1z"/>
                  </svg>
              </span>
              <h4 class="mb-2 text-[15px] font-semibold text-slate-900">${s.label}</h4>
              <p class="text-sm text-slate-600">${s.at ?? 'Pending'}</p>
            </li>
        `).join("");

        // Products
        productsEl.innerHTML = order.items.map(i => `
            <div class="grid sm:grid-cols-3 items-center gap-4">
                <div class="col-span-2 flex items-center gap-4">
                    <div class="w-20 h-20 shrink-0 bg-gray-100 p-2 rounded-md">
                        <img src="${i.image}" class="w-full h-full object-contain" />
                    </div>
                    <div>
                        <h4 class="text-[15px] font-medium text-slate-900">${i.name}</h4>
                        <p class="text-xs text-slate-600 mt-1">Qty: ${i.qty}</p>
                    </div>
                </div>
                <div class="sm:ml-auto">
                    <h4 class="text-[15px] font-medium text-slate-900">Rs ${i.price}</h4>
                </div>
            </div>
            <hr class="border-gray-300"/>
        `).join("");

        // Billing
        billingEl.innerHTML = `
            <li class="flex flex-wrap gap-4 text-slate-600 text-sm">Subtotal <span class="ml-auto text-slate-900 font-semibold">Rs ${order.subtotal}</span></li>
            <li class="flex flex-wrap gap-4 text-slate-600 text-sm">Shipping <span class="ml-auto text-slate-900 font-semibold">Rs ${order.shipping}</span></li>
            <li class="flex flex-wrap gap-4 text-slate-600 text-sm">Tax <span class="ml-auto text-slate-900 font-semibold">Rs ${order.tax}</span></li>
            <hr class="border-gray-300"/>
            <li class="flex flex-wrap gap-4 text-[15px]">Total <span class="ml-auto text-slate-900 font-semibold">Rs ${order.total}</span></li>
        `;

        // Invoice download
        downloadBtn.onclick = () => {
            window.open(`/orders/${order.tracking_id}/invoice`, "_blank");
        };

    } catch (err) {
        console.error("❌ Tracking fetch failed:", err);
        trackingIdEl.textContent = "❌ Failed to load tracking info";
    }
}

// Run now + refresh every 30s
fetchTracking();
setInterval(fetchTracking, 30000);
