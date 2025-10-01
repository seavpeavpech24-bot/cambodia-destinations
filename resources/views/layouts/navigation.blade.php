    <!-- Navigation -->
    <nav class="bg-yellow-500 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        @php
                            $webInfo = \App\Models\WebInfo::first();
                        @endphp
                        <img src="{{ $webInfo->logo_url ?? 'https://th.bing.com/th/id/R.4441959edeb870f1583845a64155ae84?rik=11XrEgXX4K%2b0Ug&pid=ImgRaw&r=0' }}" alt="{{ $webInfo->title ?? 'Cambodia' }}" class="h-24 w-auto">
                        <span class="ml-2 text-xl font-bold">{{ $webInfo->title ?? 'Wonder Of Cambodia' }}</span>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" onclick="toggleMenu()" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>

                <!-- Desktop menu -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="/" class="hover:text-gray-500 px-3 py-2 rounded-md text-sm font-medium font-bold">Home</a>
                    <a href="/destinations" class="hover:text-gray-500 px-3 py-2 rounded-md text-sm font-medium">Destinations</a>
                    <a href="/tours" class="hover:text-gray-500 px-3 py-2 rounded-md text-sm font-medium">Tours</a>
                    <a href="/travel-tips" class="hover:text-gray-500 px-3 py-2 rounded-md text-sm font-medium">Travel Tips</a>
                    <a href="/ai-assistant" class="hover:text-gray-500 px-3 py-2 rounded-md text-sm font-medium">AI Assistant</a>
                    <a href="/about" class="hover:text-gray-500 px-3 py-2 rounded-md text-sm font-medium">About</a>
                    <a href="/contact" class="hover:text-gray-500 px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="/" class="block px-3 py-2 rounded-md hover:text-gray-500 hover:bg-gray-100 text-sm font-medium">Home</a>
                    <a href="/destinations" class="block px-3 py-2 rounded-md hover:text-gray-500 hover:bg-gray-100 text-sm font-medium">Destinations</a>
                    <a href="/tours" class="block px-3 py-2 rounded-md hover:text-gray-500 hover:bg-gray-100 text-sm font-medium">Tours</a>
                    <a href="/travel-tips" class="block px-3 py-2 rounded-md hover:text-gray-500 hover:bg-gray-100 text-sm font-medium">Travel Tips</a>
                    <a href="/ai-assistant" class="block px-3 py-2 rounded-md hover:text-gray-500 hover:bg-gray-100 text-sm font-medium">AI Assistant</a>
                    <a href="/about" class="block px-3 py-2 rounded-md hover:text-gray-500 hover:bg-gray-100 text-sm font-medium">About</a>
                    <a href="/contact" class="block px-3 py-2 rounded-md hover:text-gray-500 hover:bg-gray-100 text-sm font-medium">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <script>
        function toggleMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }
    </script>