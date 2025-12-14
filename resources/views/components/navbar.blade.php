<header class="bg-black/30 backdrop-blur-md sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">

        <!-- Logo -->
        <a href="/" class="flex items-center gap-2">
            <h2 class="text-3xl font-bold">
                Resto<span class="text-yellow-400">Kemang</span>
            </h2>
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center gap-8 font-bold text-sm">

            <nav class="flex gap-6">
                <a href="/" class="hover:text-yellow-400 transition">HOME</a>
                <a href="/menu" class="hover:text-yellow-400 transition">MENU</a>
                <a href="/reservation" class="hover:text-yellow-400 transition">BOOKING</a>
            </nav>

            <!-- Login & Register / User Dropdown -->
            <div class="flex items-center gap-4">
                @auth
                    <!-- User Dropdown -->
                    <div class="relative">
                        <button id="user-dropdown-btn"
                            class="flex items-center gap-2 bg-yellow-400 text-black px-4 py-2 rounded-lg font-bold hover:bg-yellow-300 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                            {{ Auth::user()->name }}
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="user-dropdown-menu"
                            class="absolute right-0 mt-2 w-48 bg-black/95 rounded-lg shadow-lg hidden flex-col py-2 z-50">
                            <a href="/profile"
                                class="px-4 py-2 hover:bg-yellow-400 hover:text-black transition flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>

                            <form method="POST" action="/logout"
                                class="px-4 py-2 hover:bg-yellow-400 hover:text-black transition">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/login"
                        class="bg-white text-black px-5 py-2 rounded-lg font-bold hover:bg-gray-200 transition">
                        Login
                    </a>

                    <a href="/register"
                        class="bg-yellow-400 text-black px-5 py-2 rounded-lg font-bold hover:bg-yellow-300 hover:text-black transition">
                        Register
                    </a>
                @endauth
            </div>

        </div>

        <!-- Mobile Hamburger Button -->
        <button id="navbar-btn" class="md:hidden flex flex-col gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="absolute top-full left-0 right-0 bg-black/95 md:hidden hidden w-full">

            <nav class="flex flex-col gap-0 w-full border-b border-yellow-400/20">
                <a href="/"
                    class="block py-3 px-4 hover:bg-yellow-400 hover:text-black transition border-b border-yellow-400/20">HOME</a>
                <a href="/menu"
                    class="block py-3 px-4 hover:bg-yellow-400 hover:text-black transition border-b border-yellow-400/20">MENU</a>
                <a href="/reservation"
                    class="block py-3 px-4 hover:bg-yellow-400 hover:text-black transition">BOOKING</a>
            </nav>

            <!-- Login & Register Mobile / User Dropdown Mobile -->
            <div class="flex flex-col w-full gap-0 py-4 px-4">
                @auth
                    <!-- User Mobile Dropdown -->
                    <button id="mobile-user-dropdown-btn"
                        class="w-full flex items-center justify-between gap-2 bg-yellow-400 text-black px-4 py-3 rounded-lg font-bold hover:bg-yellow-300 transition mb-2">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                            {{ Auth::user()->name }}
                        </div>
                        <svg id="mobile-dropdown-icon" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </button>

                    <!-- Mobile User Dropdown Menu -->
                    <div id="mobile-user-dropdown-menu"
                        class="hidden flex-col gap-0 bg-black/50 rounded-lg overflow-hidden mb-2">
                        <a href="/profile"
                            class="block py-3 px-4 hover:bg-yellow-400 hover:text-black transition flex items-center gap-2 border-b border-yellow-400/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>

                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit"
                                class="w-full text-left py-3 px-4 hover:bg-yellow-400 hover:text-black transition flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="/login"
                        class="block bg-white text-black px-4 py-3 rounded-lg font-bold w-full text-center hover:bg-gray-200 transition mb-2">
                        Login
                    </a>

                    <a href="/register"
                        class="block bg-yellow-400 text-black px-4 py-3 rounded-lg font-bold w-full text-center hover:bg-yellow-300 transition">
                        Register
                    </a>
                @endauth
            </div>

        </div>

    </nav>
</header>

<script>
    // Desktop user dropdown toggle
    const userDropdownBtn = document.getElementById('user-dropdown-btn');
    const userDropdownMenu = document.getElementById('user-dropdown-menu');

    if (userDropdownBtn) {
        userDropdownBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdownMenu.classList.toggle('hidden');
            userDropdownMenu.classList.toggle('flex');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', () => {
            userDropdownMenu.classList.add('hidden');
            userDropdownMenu.classList.remove('flex');
        });
    }

    // Mobile hamburger toggle
    const navbarBtn = document.getElementById('navbar-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    navbarBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        mobileMenu.classList.toggle('hidden');
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!navbarBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
            mobileMenu.classList.add('hidden');
        }
    });

    // Mobile user dropdown toggle
    const mobileUserDropdownBtn = document.getElementById('mobile-user-dropdown-btn');
    const mobileUserDropdownMenu = document.getElementById('mobile-user-dropdown-menu');
    const mobileDropdownIcon = document.getElementById('mobile-dropdown-icon');

    if (mobileUserDropdownBtn) {
        mobileUserDropdownBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileUserDropdownMenu.classList.toggle('hidden');
            mobileUserDropdownMenu.classList.toggle('flex');
            mobileDropdownIcon.classList.toggle('rotate-180');
        });
    }
</script>
