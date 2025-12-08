@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 to-red-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8">

        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Join Us</h2>
            <p class="text-gray-600">Create your Resto Kemang account</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    autocomplete="name"
                    class="w-full bg-white text-gray-900 px-4 py-3 border-2 border-gray-300 rounded-lg
                           focus:outline-none focus:border-orange-500 transition
                           @error('name') border-red-500 @enderror"
                    placeholder="John Doe"
                    required
                >
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    class="w-full bg-white text-gray-900 px-4 py-3 border-2 border-gray-300 rounded-lg
                           focus:outline-none focus:border-orange-500 transition
                           @error('email') border-red-500 @enderror"
                    placeholder="you@example.com"
                    required
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    autocomplete="new-password"
                    class="w-full bg-white text-gray-900 px-4 py-3 border-2 border-gray-300 rounded-lg
                           focus:outline-none focus:border-orange-500 transition
                           @error('password') border-red-500 @enderror"
                    placeholder="Minimum 8 characters"
                    required
                >
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    autocomplete="new-password"
                    class="w-full bg-white text-gray-900 px-4 py-3 border-2 border-gray-300 rounded-lg
                           focus:outline-none focus:border-orange-500 transition"
                    placeholder="Confirm password"
                    required
                >
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold py-3 rounded-lg
                       hover:shadow-lg transition transform hover:scale-105 duration-200"
            >
                Create Account
            </button>
        </form>

        <!-- Divider -->
        <div class="mt-6 relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Already have an account?</span>
            </div>
        </div>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="font-medium text-orange-500 hover:text-orange-600">
                Sign in instead
            </a>
        </div>

        <!-- Restaurant Image -->
        <div class="mt-8 text-center">
            <img
                src="{{ asset('img/sushidone.jpg') }}"
                alt="Resto Kemang"
                class="rounded-lg w-full h-32 object-cover opacity-70 hover:opacity-100 transition"
            >
        </div>
    </div>
</div>
@endsection
