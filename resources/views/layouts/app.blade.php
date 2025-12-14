<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Resto Kemang')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #26282A;
            font-family: 'Kamerik205', sans-serif;
        }

        .scroll-smooth {
            scroll-behavior: smooth;
        }
    </style>
    @yield('styles')
</head>

<body class="bg-[#26282A] text-white scroll-smooth">
    @if (!auth()->check() || auth()->user()->role === 'customer')
        @include('components.navbar')
        <main>
    @endif



    @yield('content')
    </main>

    @include('components.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>

</html>
