@extends('layouts.app')

@section('title', 'RyoriNosekai - Authentic Japanese Cuisine')

@section('content')
<!-- Hero Section -->
<section id="home" class="relative bg-no-repeat bg-cover bg-center min-h-screen flex items-center justify-center" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('img/sushidone.jpg') }}');">
    <div class="text-center px-4">
        <h1 class="text-6xl md:text-8xl font-bold mb-6 leading-tight">
            Ryori<br>Nosekai
        </h1>
        <p class="text-xl md:text-2xl mb-8 text-gray-300">
            Experience Authentic Japanese Cuisine
        </p>
        @if (Auth::check())
            <a href="/menu" class="inline-block bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-lg font-bold text-lg transition">
                Order Now
            </a>
        @else
            <a href="/login" class="inline-block bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-lg font-bold text-lg transition">
                Order Now
            </a>
        @endif
    </div>
</section>

<!-- About Section -->
<section class="bg-red-600 text-white py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">About Us</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="rounded-lg overflow-hidden shadow-lg">
                <img src="{{ asset('img/about 2.jpg') }}" alt="About Us" class="w-full h-48 object-cover">
            </div>
            <div class="rounded-lg overflow-hidden shadow-lg">
                <img src="{{ asset('img/about 3.jpg') }}" alt="Our Cuisine" class="w-full h-48 object-cover">
            </div>
            <div class="rounded-lg overflow-hidden shadow-lg">
                <img src="{{ asset('img/about 4.jpg') }}" alt="Our Restaurant" class="w-full h-48 object-cover">
            </div>
        </div>

        <p class="text-lg md:text-xl max-w-4xl mx-auto text-center mb-12 leading-relaxed">
            Welcome to RyoriNosekai, where the art of Japanese cuisine comes alive in every dish. Indulge in the finest sushi, made with fresh, premium ingredients, savor the comforting flavors of hearty ramen with rich, authentic broths, and experience the melt-in-your-mouth perfection of premium wagyu beef.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <p class="text-4xl md:text-5xl font-bold">1,000+</p>
                <p class="text-lg font-semibold">Satisfied Customers</p>
            </div>
            <div class="text-center">
                <p class="text-4xl md:text-5xl font-bold">20+</p>
                <p class="text-lg font-semibold">Menu Items</p>
            </div>
            <div class="text-center">
                <p class="text-4xl md:text-5xl font-bold">95%</p>
                <p class="text-lg font-semibold">Customer Satisfaction</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-4xl md:text-5xl font-bold text-center mb-12">Why Choose Us</h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="bg-gray-800 p-8 rounded-lg text-center hover:bg-gray-700 transition">
                <div class="text-5xl mb-4"></div>
                <h3 class="text-xl font-bold mb-3">Premium Quality</h3>
                <p class="text-gray-400">Only the finest ingredients from Japan</p>
            </div>

            <div class="bg-gray-800 p-8 rounded-lg text-center hover:bg-gray-700 transition">
                <div class="text-5xl mb-4"></div>
                <h3 class="text-xl font-bold mb-3">Expert Chefs</h3>
                <p class="text-gray-400">Traditional Japanese culinary masters</p>
            </div>

            <div class="bg-gray-800 p-8 rounded-lg text-center hover:bg-gray-700 transition">
                <div class="text-5xl mb-4"></div>
                <h3 class="text-xl font-bold mb-3">Fast Service</h3>
                <p class="text-gray-400">Quick delivery without compromising quality</p>
            </div>

            <div class="bg-gray-800 p-8 rounded-lg text-center hover:bg-gray-700 transition">
                <div class="text-5xl mb-4"></div>
                <h3 class="text-xl font-bold mb-3">Special Offers</h3>
                <p class="text-gray-400">Exclusive deals for loyal customers</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="relative bg-no-repeat bg-cover bg-center py-16 px-4" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('img/footer.jpg') }}');">
    <div class="text-center">
        <h2 class="text-4xl font-bold text-white mb-6">Ready to Experience?</h2>
        <p class="text-lg text-gray-200 mb-8 max-w-2xl mx-auto">
            Visit us today and discover the authentic taste of Japan in every bite.
        </p>
        <div class="flex flex-col md:flex-row gap-4 justify-center">
            @if (Auth::check())
                <a href="/menu" class="bg-black text-red-500 px-8 py-3 rounded-lg font-bold hover:bg-gray-800 transition">
                    Browse Menu
                </a>
                <a href="/reservation" class="bg-gray-900 text-white px-8 py-3 rounded-lg font-bold hover:bg-gray-700 transition">
                    Book a Table
                </a>
            @else
                <a href="/login" class="bg-black text-red-500 px-8 py-3 rounded-lg font-bold hover:bg-gray-800 transition">
                    Browse Menu
                </a>
                <a href="/login" class="bg-gray-900 text-white px-8 py-3 rounded-lg font-bold hover:bg-gray-700 transition">
                    Book a Table
                </a>
            @endif
        </div>
    </div>
</section>
@endsection
