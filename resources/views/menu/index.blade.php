@extends('layouts.app')

@section('title', 'Menu - Resto Kemang')

@section('content')
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Menu</h1>
            <p class="text-gray-400">Experience authentic Japanese cuisine</p>
        </div>

        <!-- Filter Buttons -->
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <button class="filter-button bg-yellow-500 text-black px-6 py-2 rounded-lg font-bold" data-filter="all">
                All
            </button>
            <button class="filter-button bg-gray-700 text-white px-6 py-2 rounded-lg font-bold" data-filter="sushi">
                Sushi
            </button>
            <button class="filter-button bg-gray-700 text-white px-6 py-2 rounded-lg font-bold" data-filter="ramen">
                Ramen
            </button>
            <button class="filter-button bg-gray-700 text-white px-6 py-2 rounded-lg font-bold" data-filter="wagyu">
                Wagyu
            </button>
            <button class="filter-button bg-gray-700 text-white px-6 py-2 rounded-lg font-bold" data-filter="drinks">
                Drinks
            </button>
        </div>

        <!-- Menu Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($menus as $menu)
            <div class="menu-item bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition" data-category="{{ $menu->category }}">
                @if($menu->image)
                <div class="h-48 bg-gray-700 overflow-hidden">
                    <img src="{{ asset('img/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                </div>
                @else
                <div class="h-48 bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center">
                    <span class="text-3xl">🍜</span>
                </div>
                @endif

                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">{{ $menu->name }}</h3>
                    <p class="text-gray-400 text-sm mb-4">{{ $menu->description ?? 'Premium Japanese cuisine' }}</p>

                    <div class="flex justify-between items-center mb-4">
                        <span class="text-2xl font-bold text-yellow-400">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        <span class="text-xs bg-yellow-500 text-black px-3 py-1 rounded-full">{{ ucfirst($menu->category) }}</span>
                    </div>

                    @auth
                        <button
                            class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 rounded-lg transition"
                            data-name="{{ $menu->name }}"
                            data-price="{{ $menu->price }}"
                            data-image="{{ $menu->image }}"
                            onclick="addToCart(this)"
                        >
                            Add to Cart
                        </button>
                    @else
                        <button
                            class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 rounded-lg transition"
                            onclick="window.location.href='{{ route('login') }}'"
                        >
                            Order
                        </button>
                    @endauth
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-400 text-xl">No menu items available</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@auth
<!-- Cart Sidebar -->
<div id="cartSidebar" class="fixed right-0 top-0 h-full w-80 bg-gray-900 shadow-lg transform translate-x-full transition-transform duration-300 z-50 overflow-y-auto">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Your Cart</h2>
            <button id="closeCartButton" class="text-xl">✕</button>
        </div>

        <div id="cartItems" class="mb-6">
            <!-- Cart items will be rendered here -->
        </div>

        <div class="border-t border-gray-700 pt-4">
            <div class="flex justify-between text-xl font-bold mb-4">
                <span>Total:</span>
                <span id="cartTotal">Rp 0</span>
            </div>
            <button id="checkoutButton" class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-lg">
                Checkout
            </button>
        </div>
    </div>
</div>

<!-- Cart Toggle Button -->
<button id="toggleCartButton" class="fixed bottom-6 right-6 bg-yellow-500 hover:bg-yellow-600 text-black w-16 h-16 rounded-full flex items-center justify-center text-2xl shadow-lg">
    🛒
</button>
@endauth
@endsection

@section('scripts')
<script>
const CART_STORAGE_KEY = 'resto_cart';
let cart = JSON.parse(localStorage.getItem(CART_STORAGE_KEY)) || [];

function addToCart(button) {
    const name = button.getAttribute('data-name');
    const price = parseInt(button.getAttribute('data-price'), 10);
    const image = button.getAttribute('data-image');

    const existingItem = cart.find(item => item.name === name);

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({ name, price, image, quantity: 1 });
    }

    localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
    renderCartItems();

    Swal.fire({
        position: 'center',
        icon: 'success',
        title: `${name} added to cart!`,
        showConfirmButton: false,
        timer: 2000
    });
}

function renderCartItems() {
    const cartItemsDiv = document.getElementById('cartItems');
    const cartTotalEl = document.getElementById('cartTotal');
    if (!cartItemsDiv || !cartTotalEl) return; // nothing to render for guests

    // Always read current cart from storage to avoid stale state
    const currentCart = JSON.parse(localStorage.getItem(CART_STORAGE_KEY)) || [];

    cartItemsDiv.innerHTML = '';
    let total = 0;

    if (currentCart.length === 0) {
        cartItemsDiv.innerHTML = '<p class="text-gray-400">Your cart is empty</p>';
    } else {
        currentCart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            cartItemsDiv.innerHTML += `
                <div class="bg-gray-800 p-4 rounded-lg mb-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold">${item.name}</h3>
                        <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-700">✕</button>
                    </div>
                    <p class="text-gray-400 text-sm mb-2">Rp ${item.price.toLocaleString('id-ID')}</p>
                    <div class="flex items-center gap-2">
                        <button onclick="decrementQuantity(${index})" class="bg-gray-700 px-2 py-1 rounded">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="incrementQuantity(${index})" class="bg-gray-700 px-2 py-1 rounded">+</button>
                    </div>
                </div>
            `;
        });
    }

    cartTotalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
}

function removeFromCart(index) {
    const currentCart = JSON.parse(localStorage.getItem(CART_STORAGE_KEY)) || [];
    currentCart.splice(index, 1);
    localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(currentCart));
    renderCartItems();
}

function incrementQuantity(index) {
    const currentCart = JSON.parse(localStorage.getItem(CART_STORAGE_KEY)) || [];
    if (currentCart[index]) {
        currentCart[index].quantity += 1;
        localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(currentCart));
        renderCartItems();
    }
}

function decrementQuantity(index) {
    const currentCart = JSON.parse(localStorage.getItem(CART_STORAGE_KEY)) || [];
    if (currentCart[index]) {
        if (currentCart[index].quantity > 1) {
            currentCart[index].quantity -= 1;
        } else {
            currentCart.splice(index, 1);
        }
        localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(currentCart));
        renderCartItems();
    }
}

const filterButtons = document.querySelectorAll('.filter-button');
const menuItems = document.querySelectorAll('.menu-item');

function applyFilter(filter) {
    filterButtons.forEach(btn => {
        btn.classList.remove('bg-yellow-500');
        btn.classList.add('bg-gray-700');
    });

    const activeButton = document.querySelector(`.filter-button[data-filter="${filter}"]`);
    if (activeButton) {
        activeButton.classList.add('bg-yellow-500');
        activeButton.classList.remove('bg-gray-700');
    }

    menuItems.forEach(item => {
        if (filter === 'all' || item.getAttribute('data-category') === filter) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

filterButtons.forEach(button => {
    button.addEventListener('click', () => {
        const filter = button.getAttribute('data-filter');
        applyFilter(filter);
    });
});

// Cart element references (may be null for guests)
const toggleCartButton = document.getElementById('toggleCartButton');
const closeCartButton = document.getElementById('closeCartButton');
const cartSidebar = document.getElementById('cartSidebar');
const checkoutButton = document.getElementById('checkoutButton');

if (toggleCartButton && cartSidebar) {
    toggleCartButton.addEventListener('click', () => {
        cartSidebar.classList.remove('translate-x-full');
        toggleCartButton.classList.add('hidden');
        renderCartItems();
    });
}

if (closeCartButton && toggleCartButton && cartSidebar) {
    closeCartButton.addEventListener('click', () => {
        cartSidebar.classList.add('translate-x-full');
        toggleCartButton.classList.remove('hidden');
    });
}

// Checkout handled in modules/menu.js to ensure single canonical handler

// Initial render only if cart UI exists
if (document.getElementById('cartItems')) {
    renderCartItems();
}
applyFilter('all');
</script>
@endsection
