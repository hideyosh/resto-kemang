@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h2>
            <p class="text-gray-600">Sign in to your RyoriNosekai account</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg
                           text-gray-900
                           focus:outline-none focus:border-red-600 transition
                           @error('email') border-red-500 @enderror"
                    placeholder="you@example.com"
                    required
                    autofocus
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg
                           text-gray-900
                           focus:outline-none focus:border-red-600 transition
                           @error('password') border-red-500 @enderror"
                    placeholder="••••••••"
                    required
                >
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input
                    type="checkbox"
                    name="remember"
                    id="remember"
                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded cursor-pointer"
                >
                <label for="remember" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                    Remember me
                </label>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-gradient-to-r from-red-600 to-red-800 text-white font-semibold py-3 rounded-lg hover:shadow-lg transition transform hover:scale-105 duration-200"
            >
                Sign In
            </button>
        </form>

        <!-- Divider -->
        <div class="mt-6 relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Don't have an account?</span>
            </div>
        </div>

        <!-- Register Link -->
        <div class="mt-6 text-center">
            <a href="{{ route('register') }}" class="font-medium text-red-600 hover:text-red-700">
                Create a new account
            </a>
        </div>

        <!-- Restaurant Image -->
        <div class="mt-8 text-center">
            <img
                src="{{ asset('img/sushidone.jpg') }}"
                alt="RyoriNosekai"
                class="rounded-lg w-full h-32 object-cover opacity-70 hover:opacity-100 transition"
            >
        </div>
    </div>
</div>
@endsection
