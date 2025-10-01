<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $webInfo = \App\Models\WebInfo::first();
    @endphp
    <link rel="icon" type="image/png" href="{{ $webInfo->favicon_url ?? '/assets/images/logo.png' }}">
    <title>@yield('title', 'Home')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
    <div class="flex flex-col min-h-screen">
        <!-- Top Navbar -->
        <header class="bg-gradient-to-b from-indigo-900 to-indigo-700 text-white shadow-sm fixed top-0 left-0 right-0 z-20">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <button id="sidebar-toggle" class="lg:hidden text-white hover:text-gray-200 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <img src="{{ $webInfo->logo_url ?? 'https://th.bing.com/th/id/R.4441959edeb870f1583845a64155ae84?rik=11XrEgXX4K%2b0Ug&pid=ImgRaw&r=0' }}" alt="{{ $webInfo->title ?? 'Cambodia' }}" class="h-8 w-auto ml-4 lg:ml-0">
                        <span class="ml-2 text-lg font-bold text-white hidden sm:inline">{{ $webInfo->title ?? 'Wonder Of Cambodia' }}</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-white">{{ Auth::user()->name }}</span>
                        <a href="{{ route('admin.users.index') }}" class="text-white hover:text-gray-200">
                            <i class="fas fa-user-circle"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" class="text-white hover:text-gray-200" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex flex-1 pt-16">
            <!-- Desktop Sidebar -->
            <aside id="sidebar" class="bg-gradient-to-b from-indigo-900 to-indigo-700 text-white w-64 flex-shrink-0 hidden lg:flex flex-col fixed top-0 bottom-0 pt-16 shadow-lg">
                <nav class="mt-6 px-3 overflow-y-auto scrollbar-hide">
                    <div class="mb-6">
                        <h3 class="text-xs font-bold text-indigo-200 uppercase tracking-wider px-4 py-2">Main</h3>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-tachometer-alt w-6 text-indigo-300"></i>
                            Dashboard
                        </a>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-xs font-bold text-indigo-200 uppercase tracking-wider px-4 py-2">Content Management</h3>
                        <a href="{{ route('admin.hero-pages.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.hero-pages.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-image w-6 text-indigo-300"></i>
                            Hero Pages
                        </a>
                        <a href="{{ route('admin.destinations.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.destinations.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-map-marker-alt w-6 text-indigo-300"></i>
                            Destinations
                        </a>
                        <a href="{{ route('admin.destination-categories.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.destination-categories.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-folder w-6 text-indigo-300"></i>
                            Destination Categories
                        </a>
                        <a href="{{ route('admin.travel-tips.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.travel-tips.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-lightbulb w-6 text-indigo-300"></i>
                            Travel Tips
                        </a>
                        <a href="{{ route('admin.gallery.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.gallery.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-images w-6 text-indigo-300"></i>
                            Gallery
                        </a>
                        <a href="{{ route('admin.youtube-videos.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.youtube-videos.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fab fa-youtube w-6 text-indigo-300"></i>
                            YouTube Videos
                        </a>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-xs font-bold text-indigo-200 uppercase tracking-wider px-4 py-2">Marketing</h3>
                        <a href="{{ route('admin.advertising.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.advertising.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-bullhorn w-6 text-indigo-300"></i>
                            Advertising
                        </a>
                        <a href="{{ route('admin.testimonials.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.testimonials.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-star w-6 text-indigo-300"></i>
                            Testimonials
                        </a>
                        <a href="{{ route('admin.subscribers.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.subscribers.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-envelope w-6 text-indigo-300"></i>
                            Subscribers
                        </a>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-xs font-bold text-indigo-200 uppercase tracking-wider px-4 py-2">Information</h3>
                        <a href="{{ route('admin.best-visiting-times.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.best-visiting-times.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-clock w-6 text-indigo-300"></i>
                            Best Visiting Times
                        </a>
                        <a href="{{ route('admin.culture-etiquette.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.culture-etiquette.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-book w-6 text-indigo-300"></i>
                            Culture & Etiquette
                        </a>
                        <a href="{{ route('admin.getting-around.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.getting-around.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-bus w-6 text-indigo-300"></i>
                            Getting Around
                        </a>
                        <a href="{{ route('admin.map-coordinators.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.map-coordinators.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-map w-6 text-indigo-300"></i>
                            Map Coordinates
                        </a>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-xs font-bold text-indigo-200 uppercase tracking-wider px-4 py-2">Communication</h3>
                        <a href="{{ route('admin.contact-inquiries.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.contact-inquiries.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-inbox w-6 text-indigo-300"></i>
                            Contact Inquiries
                        </a>
                        <a href="{{ route('admin.web-info.settings') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.web-info.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-cog w-6 text-indigo-300"></i>
                            Website Information
                        </a>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-xs font-bold text-indigo-200 uppercase tracking-wider px-4 py-2">User Management</h3>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-users w-6 text-indigo-300"></i>
                            Users
                        </a>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-xs font-bold text-indigo-200 uppercase tracking-wider px-4 py-2">System</h3>
                        <a href="{{ route('admin.data-management.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.data-management.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-trash-restore w-6 text-indigo-300"></i>
                            Data Management
                        </a>
                        <a href="{{ route('admin.database-backup.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.database-backup.*') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-database w-6 text-indigo-300"></i>
                            Database Backup
                        </a>
                    </div>
                    <div class="border-t border-indigo-500 my-4"></div>
                    <a href="/" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('home') ? 'bg-indigo-600 text-white' : '' }}">
                        <i class="fas fa-globe w-6 text-indigo-300"></i>
                        View Website
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt w-6 text-indigo-300"></i>
                        Logout
                    </a>
                </nav>
            </aside>

            <!-- Mobile Sidebar -->
            <div id="mobile-sidebar" class="fixed inset-0 z-30 hidden">
                <div class="absolute inset-0 bg-gray-900 opacity-75" onclick="toggleSidebar()"></div>
                <aside class="absolute inset-y-0 left-0 w-64 bg-gradient-to-b from-indigo-900 to-indigo-700 text-white shadow-xl flex flex-col pt-16 transform transition-transform duration-300 ease-in-out">
                    <nav class="mt-6 px-3 overflow-y-auto scrollbar-hide">
                        <div class="mb-6">
                            <h3 class="text-xs font-bold text-indigo-200 uppercase tracking-wider px-4 py-2">Main</h3>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-tachometer-alt w-6 text-indigo-300"></i>
                                Dashboard
                            </a>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-xs font-bold text-indigo-200 uppercase tracking-wider px-4 py-2">Content Management</h3>
                            <a href="{{ route('admin.hero-pages.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.hero-pages.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-image w-6 text-indigo-300"></i>
                                Hero Pages
                            </a>
                            <a href="{{ route('admin.destinations.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.destinations.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-map-marker-alt w-6 text-indigo-300"></i>
                                Destinations
                            </a>
                            <a href="{{ route('admin.destination-categories.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.destination-categories.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-folder w-6 text-indigo-300"></i>
                                Destination Categories
                            </a>
                            <a href="{{ route('admin.travel-tips.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.travel-tips.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-lightbulb w-6 text-indigo-300"></i>
                                Travel Tips
                            </a>
                            <a href="{{ route('admin.gallery.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.gallery.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-images w-6 text-indigo-300"></i>
                                Gallery
                            </a>
                            <a href="{{ route('admin.youtube-videos.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.youtube-videos.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fab fa-youtube w-6 text-indigo-300"></i>
                                YouTube Videos
                            </a>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-xs font-bold text-indigo-200 uppercase tracking-wider px-4 py-2">Marketing</h3>
                            <a href="{{ route('admin.advertising.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.advertising.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-bullhorn w-6 text-indigo-300"></i>
                                Advertising
                            </a>
                            <a href="{{ route('admin.testimonials.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.testimonials.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-star w-6 text-indigo-300"></i>
                                Testimonials
                            </a>
                            <a href="{{ route('admin.subscribers.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.subscribers.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-envelope w-6 text-indigo-300"></i>
                                Subscribers
                            </a>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-xs font-bold text-indigo-200 uppercase tracking-wider px-4 py-2">Information</h3>
                            <a href="{{ route('admin.best-visiting-times.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.best-visiting-times.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-clock w-6 text-indigo-300"></i>
                                Best Visiting Times
                            </a>
                            <a href="{{ route('admin.culture-etiquette.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.culture-etiquette.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-book w-6 text-indigo-300"></i>
                                Culture & Etiquette
                            </a>
                            <a href="{{ route('admin.getting-around.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.getting-around.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-bus w-6 text-indigo-300"></i>
                                Getting Around
                            </a>
                            <a href="{{ route('admin.map-coordinators.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.map-coordinators.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-map w-6 text-indigo-300"></i>
                                Map Coordinates
                            </a>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-xs font-bold text-indigo-200 uppercase tracking-wider px-4 py-2">Communication</h3>
                            <a href="{{ route('admin.contact-inquiries.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.contact-inquiries.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-inbox w-6 text-indigo-300"></i>
                                Contact Inquiries
                            </a>
                            <a href="{{ route('admin.web-info.settings') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.web-info.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-cog w-6 text-indigo-300"></i>
                                Website Information
                            </a>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-xs font-bold text-indigo-200 uppercase tracking-wider px-4 py-2">User Management</h3>
                            <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-users w-6 text-indigo-300"></i>
                                Users
                            </a>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-xs font-bold text-indigo-200 uppercase tracking-wider px-4 py-2">System</h3>
                            <a href="{{ route('admin.data-management.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.data-management.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-trash-restore w-6 text-indigo-300"></i>
                                Data Management
                            </a>
                            <a href="{{ route('admin.database-backup.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.database-backup.*') ? 'bg-indigo-600 text-white' : '' }}">
                                <i class="fas fa-database w-6 text-indigo-300"></i>
                                Database Backup
                            </a>
                        </div>
                        <div class="border-t border-indigo-500 my-4"></div>
                        <a href="/" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200 {{ request()->routeIs('home') ? 'bg-indigo-600 text-white' : '' }}">
                            <i class="fas fa-globe w-6 text-indigo-300"></i>
                            View Website
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-sm hover:bg-indigo-600 hover:text-white rounded-lg transition-colors duration-200" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt w-6 text-indigo-300"></i>
                            Logout
                        </a>
                    </nav>
                </aside>
            </div>

            <!-- Main Content -->
            <main class="flex-1 lg:ml-64 p-4 sm:p-6 lg:p-8">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const mobileSidebar = document.getElementById('mobile-sidebar');
            mobileSidebar.classList.toggle('hidden');
        }

        document.getElementById('sidebar-toggle').addEventListener('click', toggleSidebar);

        // Close sidebar when clicking outside on mobile
        document.getElementById('mobile-sidebar').addEventListener('click', function(e) {
            if (e.target === this) {
                toggleSidebar();
            }
        });
    </script>
</body>
</html>