@extends('layouts.app')

@section('title', 'Checkout - Resto Kemang')

@section('content')
<section class="py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold mb-8 text-center">Checkout</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Order Summary -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h2 class="text-2xl font-bold mb-6">Order Summary</h2>
                <div id="orderSummary" class="space-y-4 mb-6">
                    <!-- Items will be populated by JavaScript -->
                </div>
                <div class="border-t border-gray-700 pt-4">
                    <div class="flex justify-between text-xl font-bold">
                        <span>Total:</span>
                        <span id="totalPrice">Rp 0</span>
                    </div>
                </div>
            </div>

            <!-- Order Form -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h2 class="text-2xl font-bold mb-6">Delivery Details</h2>
                <form id="orderForm" class="space-y-4">
                    @csrf
                    <p class="text-gray-400">You are placing an order using your account details. Make sure your profile has correct contact information.</p>

                    <div>
                        <label class="block text-sm font-medium mb-2">Special Notes</label>
                        <textarea name="notes" rows="4" class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-lg transition">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
let cart = JSON.parse(localStorage.getItem('cart')) || [];

function loadOrderSummary() {
    const summaryDiv = document.getElementById('orderSummary');
    const totalPriceSpan = document.getElementById('totalPrice');
    summaryDiv.innerHTML = '';
    let total = 0;

    if (cart.length === 0) {
        summaryDiv.innerHTML = '<p class="text-gray-400">No items in cart</p>';
    } else {
        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            summaryDiv.innerHTML += `
                <div class="flex justify-between items-center pb-4 border-b border-gray-700">
                    <div>
                        <p class="font-bold">${item.name}</p>
                        <p class="text-gray-400 text-sm">Qty: ${item.quantity}</p>
                    </div>
                    <p class="font-bold">Rp ${itemTotal.toLocaleString('id-ID')}</p>
                </div>
            `;
        });
    }

    totalPriceSpan.textContent = 'Rp ' + total.toLocaleString('id-ID');
}

document.getElementById('orderForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const data = {
        items: cart,
        total_amount: cart.reduce((sum, item) => sum + (item.price * item.quantity), 0),
        notes: formData.get('notes'),
        _token: document.querySelector('[name="_token"]').value
    };

    try {
        const response = await fetch('/api/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
            localStorage.removeItem('cart');
            Swal.fire({
                icon: 'success',
                title: 'Order Placed Successfully!',
                text: 'Your order has been received. Order ID: ' + result.order.id,
                confirmButtonColor: '#FBBF24'
            }).then(() => {
                window.location.href = '/menu';
            });
        } else {
            Swal.fire('Error', result.message || 'Failed to place order', 'error');
        }
    } catch (error) {
        Swal.fire('Error', 'Something went wrong', 'error');
    }
});

loadOrderSummary();
</script>
@endsection
