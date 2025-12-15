/**
 * Order Checkout Page Functionality
 */

const CART_STORAGE_KEY = 'resto_cart';

export function initOrder() {
    loadOrderSummary();
    setupOrderForm();
}

/**
 * Load order summary from cart
 */
function loadOrderSummary() {
    const cart = getCartFromStorage();
    const orderSummary = document.getElementById('orderSummary');
    const totalPrice = document.getElementById('totalPrice');

    if (!orderSummary) return;

    orderSummary.innerHTML = '';
    let total = 0;

    cart.forEach((item) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;

        const summaryItem = document.createElement('div');
        summaryItem.className = 'flex justify-between text-gray-300';
        summaryItem.innerHTML = `
            <span>${item.quantity}x ${item.name}</span>
            <span>Rp ${itemTotal.toLocaleString('id-ID')}</span>
        `;
        orderSummary.appendChild(summaryItem);
    });

    if (totalPrice) {
        totalPrice.textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }
}

/**
 * Setup order form submission
 */
function setupOrderForm() {
    const form = document.getElementById('orderForm');
    if (form) {
        form.addEventListener('submit', handleOrderSubmit);
    }
}

/**
 * Handle order form submission
 */
async function handleOrderSubmit(e) {
    e.preventDefault();

    // prevent double submit via flag and disable submit button
    const submitBtn = e.target.querySelector('button[type="submit"]');
    if (submitBtn?.dataset.submitting === '1') return;
    if (submitBtn) {
        submitBtn.dataset.submitting = '1';
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }

    const cart = getCartFromStorage();
    if (cart.length === 0) {
        showToast('Please add items to your cart first.', 'warning');
        if (submitBtn) {
            submitBtn.dataset.submitting = '0';
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        return;
    }

    // Form should use authenticated user's profile; build payload
    const form = e.target;
    const formData = new FormData(form);
    const orderData = {
        notes: formData.get('notes') || null,
        items: cart,
        total_amount: calculateTotal(cart),
    };

    try {
        const response = await fetch('/api/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value,
                'Accept': 'application/json',
            },
            body: JSON.stringify(orderData),
        });

        const responseText = await response.text();
        console.log('Response status:', response.status);
        console.log('Response text:', responseText);

        let data;
        try {
            data = JSON.parse(responseText);
        } catch (parseError) {
            console.error('Failed to parse response:', parseError);
            console.error('Raw response:', responseText);

            if (responseText.includes('<!DOCTYPE')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Server returned an error page. Please check the server logs.',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Response Parse Error',
                    text: 'Invalid server response format.',
                });
            }
            return;
        }

        if (!response.ok) {
            console.error('Response status:', response.status);
            console.error('Error data:', data);

            let errorMessage = 'An error occurred while placing your order.';

            if (data.message) {
                errorMessage = data.message;
            } else if (data.errors) {
                // Format validation errors
                const errors = Object.entries(data.errors)
                    .map(([field, messages]) => {
                        const fieldLabel = field
                            .replace(/_/g, ' ')
                            .replace(/^\w/, c => c.toUpperCase());
                        return `${fieldLabel}: ${Array.isArray(messages) ? messages[0] : messages}`;
                    })
                    .join('\n');
                errorMessage = errors;
            }

            showToast(errorMessage, 'error');
            return;
        }

        if (response.status === 201 || response.status === 200) {
            localStorage.removeItem('resto_cart');
            showToast('Your order has been placed successfully.', 'success');
            window.location.href = '/menu';
        }
    } catch (error) {
        console.error('Network error:', error);
        showToast(error.message || 'Failed to connect to the server. Please try again.', 'error');
    } finally {
        if (submitBtn) {
            submitBtn.dataset.submitting = '0';
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
}

/**
 * Get cart from localStorage
 */
function getCartFromStorage() {
    const cart = localStorage.getItem(CART_STORAGE_KEY);
    return cart ? JSON.parse(cart) : [];
}

/**
 * Calculate total from cart
 */
function calculateTotal(cart) {
    return cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
}

function showToast(message, type = 'info') {
    if (window.Swal && Swal.fire) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: type,
            title: message,
            showConfirmButton: false,
            timer: 2000,
        });
        return;
    }

    const notification = document.createElement('div');
    notification.className = `fixed top-20 right-6 px-6 py-3 rounded-lg shadow-lg ${type === 'success' ? 'bg-green-500 text-white' : type === 'warning' ? 'bg-yellow-400 text-black' : 'bg-red-500 text-white'}`;
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 2500);
}
