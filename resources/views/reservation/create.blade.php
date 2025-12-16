@extends('layouts.app')

@section('title', 'Book a Table - Resto Kemang')

@section('content')
<section class="py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold mb-4">Book a Table</h1>
            <p class="text-gray-400">Reserve your table at Resto Kemang</p>
            <div class="mt-6 rounded-lg overflow-hidden">
                <img src="{{ asset('img/IMG_93841.webp') }}" alt="Restaurant Ambiance" class="w-full h-64 object-cover rounded-lg">
            </div>
        </div>

        <div class="bg-gray-800 p-8 rounded-lg">
            <form id="reservationForm" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <p class="text-gray-400">Booking will use your account information. Ensure your profile is up to date.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Phone Number *</label>
                        <input type="tel" disabled value="{{ $user->customer->phone }}" required class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Number of Guests *</label>
                        <input type="number" name="number_of_guests" min="1" max="20" required class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Reservation Date & Time *</label>
                    <input type="datetime-local" name="reservation_date" required class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Special Requests</label>
                    <textarea name="notes" rows="4" placeholder="Any special requests or dietary restrictions?" class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
                </div>

                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 rounded-lg transition text-lg">
                    Book Table
                </button>
            </form>
        </div>

        <!-- Info Section -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-800 p-6 rounded-lg text-center">
                <div class="text-3xl mb-2">🕐</div>
                <h3 class="font-bold mb-2">Operating Hours</h3>
                <p class="text-gray-400 text-sm">11:00 AM - 11:00 PM</p>
            </div>

            <div class="bg-gray-800 p-6 rounded-lg text-center">
                <div class="text-3xl mb-2">📞</div>
                <h3 class="font-bold mb-2">Contact Us</h3>
                <p class="text-gray-400 text-sm">+62 (0)21 2850 3950</p>
            </div>

            <div class="bg-gray-800 p-6 rounded-lg text-center">
                <div class="text-3xl mb-2">📍</div>
                <h3 class="font-bold mb-2">Location</h3>
                <p class="text-gray-400 text-sm">Kemang, Jakarta Selatan</p>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
{{-- ada pada reservations js --}}
@endsection
