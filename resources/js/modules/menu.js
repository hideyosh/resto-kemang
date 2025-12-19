/**
 * Menu Page Functionality
 */

// Cart data stored in localStorage
var CART_STORAGE_KEY = 'resto_cart';

/**
 * Initialize menu page
 */
export function initMenu() {
    // initialize page
    setupFilterButtons();
    setupCartToggle();
    loadCartFromStorage();
}

/**
 * Setup filter buttons for menu categories
 */
function setupFilterButtons() {
    var filterButtons = document.querySelectorAll('.filter-button');
    var menuItems = document.querySelectorAll('.menu-item');

    for (var i = 0; i < filterButtons.length; i++) {
        (function (button) {
            button.addEventListener('click', function () {
                var filter = button.getAttribute('data-filter');

                // Update active button - simple loop
                for (var j = 0; j < filterButtons.length; j++) {
                    filterButtons[j].classList.remove('bg-red-600');
                    filterButtons[j].classList.add('bg-gray-700');
                }
                button.classList.add('bg-red-600');
                button.classList.remove('bg-gray-700');

                // Show/hide menu items
                for (var k = 0; k < menuItems.length; k++) {
                    var item = menuItems[k];
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        })(filterButtons[i]);
    }
}

/**
 * Add item to cart
 */
window.addToCart = function (button) {
    var name = button.getAttribute('data-name');
    var price = parseInt(button.getAttribute('data-price'), 10);
    var image = button.getAttribute('data-image');

    var cart = getCart();
    var found = false;
    for (var i = 0; i < cart.length; i++) {
        if (cart[i].name === name) {
            cart[i].quantity = cart[i].quantity + 1;
            found = true;
            break;
        }
    }
    if (!found) {
        cart.push({ name: name, price: price, image: image, quantity: 1 });
    }

    saveCart(cart);
    renderCart();
    toast(name + ' added to cart!', 'success');
};

/**
 * Setup cart sidebar toggle
 */
function setupCartToggle() {
    var cartButton = document.querySelector('[data-cart-toggle]');
    var closeCartButton = document.getElementById('closeCartButton');
    var cartSidebar = document.getElementById('cartSidebar');

    if (closeCartButton && cartSidebar) {
        closeCartButton.addEventListener('click', function () {
            cartSidebar.classList.add('translate-x-full');
        });
    }

    var checkoutButton = document.getElementById('checkoutButton');
    if (checkoutButton) {
        checkoutButton.addEventListener('click', function (e) {
            var cart = getCart();
            if (!cart || cart.length === 0) {
                toast('Please add items to cart', 'warning');
                e.preventDefault();
                e.stopImmediatePropagation();
                return;
            }
            window.location.href = '/order/create';
        });
    }
}

/**
 * Get cart from localStorage
 */
function getCart() {
    var cart = localStorage.getItem(CART_STORAGE_KEY);
    if (cart) {
        return JSON.parse(cart);
    }
    return [];
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
    var cart = getCart();
    var cartItems = document.getElementById('cartItems');
    var cartTotal = document.getElementById('cartTotal');
    if (!cartItems || !cartTotal) return;

    cartItems.innerHTML = '';
    var total = 0;

    for (var i = 0; i < cart.length; i++) {
        var item = cart[i];
        var itemTotal = item.price * item.quantity;
        total += itemTotal;

        var cartItem = document.createElement('div');
        cartItem.className = 'bg-gray-800 p-4 rounded-lg mb-3 flex justify-between items-start';
        cartItem.innerHTML = '<div class="flex-1"><h4 class="font-bold">' + item.name + '</h4>' +
            '<p class="text-red-500">Rp ' + item.price.toLocaleString('id-ID') + '</p>' +
            '<div class="flex items-center gap-2 mt-2">' +
            '<button onclick="decrementQuantity(' + i + ')" class="bg-gray-700 px-2 py-1 rounded">−</button>' +
            '<span class="text-sm">' + item.quantity + 'x</span>' +
            '<button onclick="incrementQuantity(' + i + ')" class="bg-gray-700 px-2 py-1 rounded">+</button>' +
            '</div></div>' +
            '<button onclick="removeFromCart(' + i + ')" class="text-red-400 hover:text-red-600">✕</button>';
        cartItems.appendChild(cartItem);
    }

    cartTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
}

/**
 * Remove item from cart
 */
window.removeFromCart = function (index) {
    const cart = getCart();
    cart.splice(index, 1);
    saveCart(cart);
    renderCart();
};

/**
 * Increment item quantity
 */
window.incrementQuantity = function (index) {
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
window.decrementQuantity = function (index) {
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
function toast(message, type) {
    // simple toast: type can be 'success','warning','error'
    var notification = document.createElement('div');
    var cls = 'bg-gray-200 text-black';
    if (type === 'success') cls = 'bg-green-500 text-white';
    if (type === 'warning') cls = 'bg-red-400 text-white';
    if (type === 'error') cls = 'bg-red-500 text-white';
    notification.className = 'fixed top-20 right-6 px-6 py-3 rounded-lg shadow-lg ' + cls;
    notification.textContent = message;
    document.body.appendChild(notification);
    window.setTimeout(function () { notification.remove(); }, 2000);
}
