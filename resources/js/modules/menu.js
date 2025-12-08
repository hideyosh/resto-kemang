/**
 * Menu Page Functionality
 */

// Cart data stored in localStorage
const CART_STORAGE_KEY = 'resto_cart';

/**
 * Initialize menu page
 */
export function initMenu() {
    setupFilterButtons();
    setupCartToggle();
    loadCartFromStorage();
}

/**
 * Setup filter buttons for menu categories
 */
function setupFilterButtons() {
    const filterButtons = document.querySelectorAll('.filter-button');
    const menuItems = document.querySelectorAll('.menu-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;

            // Update active button
            filterButtons.forEach(btn => {
                btn.classList.remove('bg-yellow-500', 'text-black');
                btn.classList.add('bg-gray-700', 'text-white');
            });
            button.classList.add('bg-yellow-500', 'text-black');
            button.classList.remove('bg-gray-700', 'text-white');

            // Filter menu items
            menuItems.forEach(item => {
                if (filter === 'all' || item.dataset.category === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
}

/**
 * Add item to cart
 */
window.addToCart = function(button) {
    const name = button.dataset.name;
    const price = parseInt(button.dataset.price);
    const image = button.dataset.image;

    const cart = getCart();
    const existingItem = cart.find(item => item.name === name);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({ name, price, image, quantity: 1 });
    }

    saveCart(cart);
    renderCart();
    showNotification(`${name} added to cart!`);
};

/**
 * Setup cart sidebar toggle
 */
function setupCartToggle() {
    const cartButton = document.querySelector('[data-cart-toggle]');
    const closeCartButton = document.getElementById('closeCartButton');
    const cartSidebar = document.getElementById('cartSidebar');

    if (closeCartButton && cartSidebar) {
        closeCartButton.addEventListener('click', () => {
            cartSidebar.classList.add('translate-x-full');
        });
    }

    // Checkout button
    const checkoutButton = document.getElementById('checkoutButton');
    if (checkoutButton) {
        checkoutButton.addEventListener('click', () => {
            window.location.href = '/order/create';
        });
    }
}

/**
 * Get cart from localStorage
 */
function getCart() {
    const cart = localStorage.getItem(CART_STORAGE_KEY);
    return cart ? JSON.parse(cart) : [];
}

/**
 * Save cart to localStorage
 */
function saveCart(cart) {
    localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
}

/**
 * Load cart from storage and render
 */
function loadCartFromStorage() {
    renderCart();
}

/**
 * Render cart items
 */
function renderCart() {
    const cart = getCart();
    const cartItems = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');

    if (!cartItems || !cartTotal) return;

    cartItems.innerHTML = '';
    let total = 0;

    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;

        const cartItem = document.createElement('div');
        cartItem.className = 'bg-gray-800 p-4 rounded-lg mb-3 flex justify-between items-start';
        cartItem.innerHTML = `
            <div class="flex-1">
                <h4 class="font-bold">${item.name}</h4>
                <p class="text-yellow-400">Rp ${item.price.toLocaleString('id-ID')}</p>
                <div class="flex items-center gap-2 mt-2">
                    <button onclick="decrementQuantity(${index})" class="bg-gray-700 px-2 py-1 rounded">−</button>
                    <span class="text-sm">${item.quantity}x</span>
                    <button onclick="incrementQuantity(${index})" class="bg-gray-700 px-2 py-1 rounded">+</button>
                </div>
            </div>
            <button onclick="removeFromCart(${index})" class="text-red-400 hover:text-red-600">✕</button>
        `;
        cartItems.appendChild(cartItem);
    });

    cartTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;
}

/**
 * Remove item from cart
 */
window.removeFromCart = function(index) {
    const cart = getCart();
    cart.splice(index, 1);
    saveCart(cart);
    renderCart();
};

/**
 * Increment item quantity
 */
window.incrementQuantity = function(index) {
    const cart = getCart();
    if (cart[index]) {
        cart[index].quantity++;
        saveCart(cart);
        renderCart();
    }
};

/**
 * Decrement item quantity
 */
window.decrementQuantity = function(index) {
    const cart = getCart();
    if (cart[index] && cart[index].quantity > 1) {
        cart[index].quantity--;
        saveCart(cart);
        renderCart();
    }
};

/**
 * Show notification
 */
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-20 right-6 bg-yellow-400 text-black px-6 py-3 rounded-lg shadow-lg animate-pulse';
    notification.textContent = message;

    document.body.appendChild(notification);
    setTimeout(() => {
        notification.remove();
    }, 2000);
}
