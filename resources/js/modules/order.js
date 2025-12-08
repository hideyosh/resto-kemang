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

    const cart = getCartFromStorage();
    if (cart.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Empty Cart',
            text: 'Please add items to your cart first.',
        });
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

            Swal.fire({
                icon: 'error',
                title: 'Order Failed',
                text: errorMessage,
            });
            return;
        }

        if (response.status === 201 || response.status === 200) {
            localStorage.removeItem('resto_cart');
            Swal.fire({
                icon: 'success',
                title: 'Order Confirmed!',
                text: 'Your order has been placed successfully.',
            }).then(() => {
                window.location.href = '/menu';
            });
        }
    } catch (error) {
        console.error('Network error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Connection Error',
            text: error.message || 'Failed to connect to the server. Please try again.',
        });
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
