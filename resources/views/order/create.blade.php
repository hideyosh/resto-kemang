@extends('layouts.app')

@section('title', 'Checkout - Resto Kemang')

@section('content')
<section class="py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold mb-8 text-center">
            Checkout
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Order Summary -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h2 class="text-2xl font-bold mb-6">
                    Order Summary
                </h2>

                <div id="orderSummary" class="space-y-4 mb-6">
                    <!-- Items populated by JavaScript -->
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
                <h2 class="text-2xl font-bold mb-6">
                    Delivery Details
                </h2>

                <form id="orderForm" class="space-y-4">
                    @csrf

                    <p class="text-gray-400">
                        You are placing an order using your account details.
                        Make sure your profile has correct contact information.
                    </p>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Special Notes
                        </label>
                        <textarea
                            name="notes"
                            rows="4"
                            class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg
                                   focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-yellow-500 hover:bg-yellow-600
                               text-black font-bold py-3 rounded-lg transition"
                    >
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
@endsection
