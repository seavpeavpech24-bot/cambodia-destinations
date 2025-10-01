@extends('layouts.app')

@section('content')

  <div class="relative">
    <!-- Hero Section - Enhanced with better overlay and call-to-action -->
    <div class="relative h-screen">
        @if($heroPage = \App\Models\HeroPages::where('page', 'home')->first())
            <img src="{{ asset($heroPage->image_url) }}" alt="{{ $heroPage->title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black/70 flex items-center justify-center">
                <div class="text-center text-white max-w-4xl px-4">
                    <h1 class="text-5xl font-bold mb-4">{{ $heroPage->title }}</h1>
                    <p class="text-xl mb-8">{{ $heroPage->description }}</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="#destinations" class="bg-yellow-500 text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-yellow-600 transition duration-300">
                            Explore Destinations
                        </a>
                        <a href="#map" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-white/20 transition duration-300">
                            View Map
                        </a>
                    </div>
                </div>
            </div>
        @else
            <img src="https://i.pinimg.com/736x/92/9c/81/929c81d0c69ec2c169eb1c9858fd1bbf.jpg" alt="Cambodia" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black/70 flex items-center justify-center">
                <div class="text-center text-white max-w-4xl px-4">
                    <h1 class="text-5xl font-bold mb-4">Wonder of Cambodia</h1>
                    <p class="text-xl mb-8">Experience the magic of ancient temples, lush landscapes, and authentic Cambodian culture</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="#destinations" class="bg-yellow-500 text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-yellow-600 transition duration-300">
                            Explore Destinations
                        </a>
                        <a href="#map" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-white/20 transition duration-300">
                            View Map
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Ad Space - After Hero -->
    <div class="max-w-7xl mx-auto px-4 py-4">
        <div class="bg-gray-200 h-24 flex items-center justify-center relative">
            <!-- Ad label -->
            <div class="absolute top-2 left-2 bg-black bg-opacity-60 text-white text-xs font-semibold px-2 py-1 rounded">
                Ad
            </div>
            @if($advertisements->isNotEmpty())
                <a href="{{ $advertisements->first()->link ?? '#' }}" target="_blank" class="h-20">
                    @if($advertisements->first()->video_url)
                        <video class="h-20" autoplay muted loop playsinline>
                            <source src="{{ Storage::url($advertisements->first()->video_url) }}" type="video/mp4">
                        </video>
                    @else
                        <img src="{{ Storage::url($advertisements->first()->image_url) }}" alt="Advertisement" class="h-20">
                    @endif
                </a>
            @endif
        </div>
    </div>

    <!-- About Cambodia Section - New -->
    <div class="bg-amber-50 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Welcome to Cambodia</h2>
                <div class="w-24 h-1 bg-yellow-500 mx-auto my-4"></div>
                <p class="text-gray-600 max-w-3xl mx-auto">The heart of Cambodia with ancient temples, scenic landscapes, and authentic Cambodian culture awaiting your discovery.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($categories as $category)
                <div class="bg-white rounded-lg p-6 shadow-md text-center">
                    <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="{{ $category->icon_class ?? 'fas fa-map-marker-alt' }} h-8 w-8 text-yellow-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">{{ $category->title }}</h3>
                    <p class="text-gray-600">{{ $category->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Popular Destinations Section with anchor -->
    <div id="destinations" class="max-w-7xl mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Top Destinations in Cambodia</h2>
            <div class="w-24 h-1 bg-yellow-500 mx-auto my-4"></div>
            <p class="text-gray-600 max-w-3xl mx-auto">Explore these must-visit attractions that showcase the beauty and heritage of Cambodia.</p>
        </div>
        
        <div class="grid md:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="md:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($destinations as $destination)
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:shadow-xl hover:-translate-y-1">
                        <img src="{{ $destination->cover_url }}" alt="{{ $destination->title }}" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-bold">{{ $destination->title }}</h3>
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">{{ $destination->category->title ?? 'Featured' }}</span>
                            </div>
                            <p class="text-gray-600 mb-4">{!! Str::limit($destination->description, 150) !!}</p>
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-500">
                                    <span>📍 Location: {{ $destination->location }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <span>⏰ Best Time: {{ $destination->best_time_to_visit }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <span>💲 Entry Fee: {{ $destination->entry_fee }}</span>
                                </div>
                            </div>
                            <a href="/destination/{{ $destination->id }}" class="inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition duration-300">Learn More</a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Map Section -->
                <section class="py-16">
                    <div class="container mx-auto px-6">
                        <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">Explore Our Destinations</h2>
                        <p class="text-gray-600 text-center mb-12 max-w-2xl mx-auto">Discover the best dirt biking spots, accommodations, dining, and historical sites in Kampong Thom on the map below.</p>
                        <div id="map" class="h-96 w-full rounded-lg shadow-md"></div>
                    </div>
                </section>
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                <script>
                    // Initialize the map, centered on Kampong Thom
                    var map = L.map('map').setView([12.7110, 104.8887], 8);

                    // Add OpenStreetMap tiles
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    // Define layer groups for categories
                    var temples = L.layerGroup();
                    var naturalSites = L.layerGroup();
                    var accommodations = L.layerGroup();
                    var localDishes = L.layerGroup();
                    var historicalSites = L.layerGroup();

                    // Add markers from database
                    @foreach($mapCoordinators as $type => $coordinators)
                        @foreach($coordinators as $coordinator)
                            @php
                                $coords = explode(',', $coordinator->latitude_and_longitude);
                                $lat = trim($coords[0]);
                                $lng = trim($coords[1]);
                            @endphp
                            
                            @if(is_numeric($lat) && is_numeric($lng))
                                // Create custom icon using the icon_class from database
                                var customIcon = L.divIcon({
                                    html: '<i class="{{ $coordinator->icon_class }}" style="color: @if($type == "Temples")#D32F2F @elseif($type == "Natural Sites")#388E3C @elseif($type == "Accommodations")#0288D1 @elseif($type == "Local Dishes")#FBC02D @elseif($type == "Historical Sites")#8E24AA @endif; font-size: 24px;"></i>',
                                    iconSize: [24, 24],
                                    className: 'custom-icon'
                                });

                                var marker = L.marker([{{ $lat }}, {{ $lng }}], {
                                    icon: customIcon
                                });

                                var popupContent = `
                                    <div class="p-2">
                                        <h3 class="font-bold text-lg mb-2">{{ $coordinator->title }}</h3>
                                        @if($coordinator->cover_url)
                                            <img src="{{ $coordinator->cover_url }}" alt="{{ $coordinator->title }}" class="w-full h-32 object-cover rounded-lg mb-2">
                                        @endif
                                        <p class="text-sm mb-2">{{ $coordinator->description }}</p>
                                        <div class="flex flex-col gap-2">
                                            @if($coordinator->map_link)
                                                <a href="{{ $coordinator->map_link }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">View on Google Maps</a>
                                            @endif
                                            @if($coordinator->destination_id)
                                                <a href="/destination/{{ $coordinator->destination_id }}" class="inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition duration-300 text-center">View Destination Details</a>
                                            @endif
                                        </div>
                                    </div>
                                `;

                                marker.bindPopup(popupContent);

                                @if($type == 'Temples')
                                    temples.addLayer(marker);
                                @elseif($type == 'Natural Sites')
                                    naturalSites.addLayer(marker);
                                @elseif($type == 'Accommodations')
                                    accommodations.addLayer(marker);
                                @elseif($type == 'Local Dishes')
                                    localDishes.addLayer(marker);
                                @elseif($type == 'Historical Sites')
                                    historicalSites.addLayer(marker);
                                @endif
                            @endif
                        @endforeach
                    @endforeach

                    // Add layers to the map by default
                    temples.addTo(map);
                    naturalSites.addTo(map);
                    accommodations.addTo(map);
                    localDishes.addTo(map);
                    historicalSites.addTo(map);

                    // Add layer control to toggle categories
                    var overlayMaps = {
                        "Temples": temples,
                        "Natural Sites": naturalSites,
                        "Accommodations": accommodations,
                        "Local Dishes": localDishes,
                        "Historical Sites": historicalSites
                    };
                    L.control.layers(null, overlayMaps, { collapsed: false }).addTo(map);

                    // Fit map bounds to show all markers
                    var allMarkers = L.featureGroup([temples, naturalSites, accommodations, localDishes, historicalSites]);
                    map.fitBounds(allMarkers.getBounds().pad(0.2));
                </script>

                <style>
                    .custom-icon {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }
                    .leaflet-popup-content {
                        margin: 0;
                    }
                    .leaflet-popup-content img {
                        margin-bottom: 8px;
                    }
                    .leaflet-control-layers {
                        border: none !important;
                    }
                    .leaflet-control-layers-list {
                        padding: 0 !important;
                    }
                    .leaflet-control-layers-base label,
                    .leaflet-control-layers-overlays label {
                        margin-bottom: 5px !important;
                    }
                    .info {
                        padding: 6px 8px;
                        font: 14px/16px Arial, Helvetica, sans-serif;
                        background: white;
                        background: rgba(255,255,255,0.8);
                        box-shadow: 0 0 15px rgba(0,0,0,0.2);
                        border-radius: 5px;
                    }
                    .info h4 {
                        margin: 0 0 5px;
                        color: #777;
                    }
                </style>

            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Ad Space -->
                <div class="bg-white rounded-lg shadow-lg p-4">
                    <div class="bg-gray-200 h-96 flex items-center justify-center relative overflow-hidden rounded-md">
                        <!-- Ad label -->
                        <div class="absolute top-2 left-2 bg-black bg-opacity-60 text-white text-xs font-semibold px-2 py-1 rounded">
                            Ad
                        </div>
                        @if($advertisements->count() > 1)
                            <a href="{{ $advertisements[1]->link ?? '#' }}" target="_blank" class="w-full h-full">
                                @if($advertisements[1]->video_url)
                                    <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                        <source src="{{ Storage::url($advertisements[1]->video_url) }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ Storage::url($advertisements[1]->image_url) }}" 
                                         alt="Advertisement" 
                                         class="w-full h-full object-cover">
                                @endif
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Travel Planning Tools - New -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Travel Tools</h3>
                    
                    <!-- Weather Widget -->
                    <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-semibold mb-2">Current Weather in Cambodia</h4>
                        @if($weather)
                            <div class="flex items-center">
                                <div class="text-4xl text-blue-500 mr-3">
                                    <img src="http://openweathermap.org/img/wn/{{ $weather['icon'] }}@2x.png" 
                                         alt="{{ $weather['description'] }}" 
                                         class="w-16 h-16">
                                </div>
                                <div>
                                    <div class="text-2xl font-bold">{{ $weather['temperature'] }}°C</div>
                                    <div class="text-sm text-gray-600 capitalize">{{ $weather['description'] }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $weather['city'] }} • 
                                        Humidity: {{ $weather['humidity'] }}% | 
                                        Wind: {{ $weather['wind_speed'] }} m/s
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-gray-600">Weather data unavailable</div>
                        @endif
                    </div>
                    
                    <!-- Best Time to Visit -->
                    <div class="mb-4">
                        <h4 class="font-semibold mb-2">Best Time to Visit</h4>
                        <p class="text-sm text-gray-600">November to February marks the dry season in Cambodia, offering cooler temperatures and ideal conditions for exploring temples and outdoor attractions.</p>
                    </div>
                    
                    <!-- Getting There -->
                    <div>
                        <h4 class="font-semibold mb-2">Getting There</h4>
                        <p class="text-sm text-gray-600">Cambodia is easily accessible by international flights, with major airports in Phnom Penh and Siem Reap, and also by land from neighboring countries such as Thailand, Vietnam, and Laos.</p>
                    </div>
                </div>

                <!-- Popular Articles -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Latest Destinations</h3>
                    <ul class="space-y-3">
                        @foreach($popularDestinations as $destination)
                            <li class="pb-2 border-b border-gray-100">
                                <a href="/destination/{{ $destination->id }}" class="flex items-start">
                                    <img src="{{ $destination->cover_url }}" 
                                         alt="{{ $destination->title }}" 
                                         class="w-16 h-12 object-cover rounded mr-3">
                                    <div>
                                        <h4 class="text-yellow-600 hover:text-yellow-700 font-medium">
                                            {{ $destination->title }}
                                        </h4>
                                        <p class="text-xs text-gray-500">
                                            {{ $destination->category->title ?? 'Featured' }} • 
                                            {{ $destination->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4 text-center">
                        <a href="/destinations" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium">
                            View All Destinations →
                        </a>
                    </div>
                </div>

                <!-- Bottom Ad Space -->
                <div class="bg-white rounded-lg shadow-lg p-4">
                    <div class="bg-gray-200 h-96 flex items-center justify-center relative overflow-hidden rounded-md">
                        <!-- Ad label -->
                        <div class="absolute top-2 left-2 bg-black bg-opacity-60 text-white text-xs font-semibold px-2 py-1 rounded">
                            Ad
                        </div>
                        @if($advertisements->count() > 2)
                            <a href="{{ $advertisements[2]->link ?? '#' }}" target="_blank" class="w-full h-full">
                                @if($advertisements[2]->video_url)
                                    <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                        <source src="{{ Storage::url($advertisements[2]->video_url) }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ Storage::url($advertisements[2]->image_url) }}" 
                                         alt="Advertisement" 
                                         class="w-full h-full object-cover">
                                @endif
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">What Our Visitors Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($testimonials as $testimonial)
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="text-yellow-500">
                                @for($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= $testimonial->rating ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-500">{{ number_format($testimonial->rating, 1) }}</span>
                        </div>
                        <p class="text-gray-600 mb-6 italic">"{{ $testimonial->content }}"</p>
                        <div class="flex items-center">
                            @if($testimonial->image_url)
                                <img src="{{ Storage::url($testimonial->image_url) }}" alt="{{ $testimonial->traveller_name }}" class="w-10 h-10 rounded-full mr-4 object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                                    <span class="text-gray-500 text-sm">{{ substr($testimonial->traveller_name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-semibold">{{ $testimonial->traveller_name }}</h4>
                                <p class="text-sm text-gray-500">From {{ $testimonial->from_country }}</p>
                                @if($testimonial->destination)
                                    <p class="text-sm text-indigo-600">Visited {{ $testimonial->destination->title }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-500">
                        <p>No testimonials available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Photo Gallery Section -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Photo Gallery</h2>
            <div class="w-24 h-1 bg-yellow-500 mx-auto my-4"></div>
            <p class="text-gray-600 max-w-3xl mx-auto">Discover the charm of Cambodia through a collection of breathtaking photographs that capture its natural beauty and rich cultural heritage.</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($galleryImages as $image)
                <div class="aspect-w-1 aspect-h-1 group relative overflow-hidden rounded-lg">
                    @if($image->destination)
                        <a href="/destination/{{ $image->destination->id }}" class="block w-full h-full">
                    @endif
                        <img src="{{ $image->image_url }}" 
                             alt="{{ $image->destination->title ?? 'Gallery image' }}" 
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-end">
                            <div class="p-4 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                @if($image->destination)
                                    <h3 class="font-semibold mb-1">{{ $image->destination->title }}</h3>
                                @endif
                                @if($image->destination)
                                    <span class="inline-block mt-2 text-sm text-yellow-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        View Destination →
                                    </span>
                                @endif
                            </div>
                        </div>
                    @if($image->destination)
                        </a>
                    @endif
                </div>
            @empty
                <div class="col-span-4 text-center py-12">
                    <p class="text-gray-500">No gallery images available at the moment.</p>
                </div>
            @endforelse
        </div>
        
        <div class="text-center mt-8">
            <a href="/gallery" class="inline-block bg-yellow-500 text-white px-6 py-3 rounded-full hover:bg-yellow-600 transition duration-300">
                View Full Gallery
            </a>
        </div>
    </div>

    <!-- Newsletter Signup Section -->
    <div class="bg-yellow-500 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white rounded-lg shadow-xl p-8 md:p-12 md:flex items-center justify-between">
                <div class="mb-6 md:mb-0 md:mr-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Get Travel Updates</h3>
                    <p class="text-gray-600">Subscribe to our newsletter and receive the latest news, travel tips, and exclusive offers for Kampong Thom.</p>
                </div>
                <div class="md:w-2/5">
                    <form id="newsletterForm" class="flex flex-col md:flex-row">
                        @csrf
                        <input type="email" 
                               name="email" 
                               id="newsletterEmail"
                               placeholder="Your email address" 
                               class="flex-grow px-4 py-3 mb-2 md:mb-0 md:mr-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                               required>
                        <button type="submit" 
                                id="subscribeButton"
                                class="bg-yellow-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-yellow-600 transition duration-300">
                            Subscribe
                        </button>
                    </form>
                    <div id="newsletterMessage" class="mt-2 text-sm hidden"></div>
                    <p class="text-xs text-gray-500 mt-2">We respect your privacy. Unsubscribe at any time.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 transform translate-y-full opacity-0 transition-all duration-300 ease-in-out">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="toastMessage"></span>
        </div>
    </div>

    <script>
        document.getElementById('newsletterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const emailInput = document.getElementById('newsletterEmail');
            const submitButton = document.getElementById('subscribeButton');
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            
            // Get CSRF token from meta tag
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!token) {
                console.error('CSRF token not found');
                return;
            }
            
            // Disable submit button and show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = 'Subscribing...';
            
            // Create FormData object
            const formData = new FormData(form);
            
            // Send AJAX request
            fetch('{{ route('newsletter.subscribe') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email: emailInput.value
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Show success message in toast
                toastMessage.textContent = data.message || 'Successfully subscribed!';
                toast.classList.remove('translate-y-full', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
                
                // Reset form
                form.reset();
                
                // Hide toast after 3 seconds
                setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-full', 'opacity-0');
                }, 3000);
            })
            .catch(error => {
                console.error('Error:', error);
                // Show error message in toast
                toastMessage.textContent = 'An error occurred. Please try again.';
                toast.classList.remove('translate-y-full', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
                
                // Hide toast after 3 seconds
                setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-full', 'opacity-0');
                }, 3000);
            })
            .finally(() => {
                // Re-enable submit button
                submitButton.disabled = false;
                submitButton.innerHTML = 'Subscribe';
            });
        });
    </script>

    <!-- FAQ Section - New -->
    <div class="max-w-4xl mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Frequently Asked Questions</h2>
            <div class="w-24 h-1 bg-yellow-500 mx-auto my-4"></div>
            <p class="text-gray-600">Find answers to commonly asked questions about visiting Cambodia and make your travel planning easier and more enjoyable.</p>
        </div>
        
        <div class="space-y-4">
            <!-- FAQ Item 1 -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <button class="flex items-center justify-between w-full p-4 text-left bg-white hover:bg-gray-50" onclick="toggleFAQ(this)">
                    <span class="font-semibold">How do I get to Cambodia?</span>
                    <svg class="w-5 h-5 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="hidden p-4 pt-0 bg-white">
                    <p class="text-gray-600">You can reach Cambodia by international flights to its major airports in Phnom Penh and Siem Reap, which are well-connected to regional hubs like Bangkok, Ho Chi Minh City, and Kuala Lumpur. Overland travel is also possible from Thailand, Vietnam, and Laos, with several border crossings offering bus and taxi services. Once in the country, domestic buses and private taxis make it easy to explore different provinces and cities.</p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <button class="flex items-center justify-between w-full p-4 text-left bg-white hover:bg-gray-50" onclick="toggleFAQ(this)">
                    <span class="font-semibold">What's the best time to visit Angkor Wat?</span>
                    <svg class="w-5 h-5 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="hidden p-4 pt-0 bg-white">
                    <p class="text-gray-600">The best time to visit Angkor Wat is during the dry season from November to March. Early morning (before 10 AM) or late afternoon (after 3 PM) offer the most comfortable temperatures and the best lighting for photography, especially during sunrise and sunset.</p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <button class="flex items-center justify-between w-full p-4 text-left bg-white hover:bg-gray-50" onclick="toggleFAQ(this)">
                    <span class="font-semibold">Are there accommodation options in Cambodia?</span>
                    <svg class="w-5 h-5 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="hidden p-4 pt-0 bg-white">
                    <p class="text-gray-600">Cambodia offers a wide range of accommodation options to suit every traveler's budget, from budget guesthouses and hostels to mid-range hotels and luxury resorts. Most major cities and tourist areas, such as Phnom Penh, Siem Reap, and Sihanoukville, have plenty of choices to serve as comfortable bases for exploring the country's rich cultural and natural attractions.</p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <button class="flex items-center justify-between w-full p-4 text-left bg-white hover:bg-gray-50" onclick="toggleFAQ(this)">
                    <span class="font-semibold">How long should I spend in Cambodia?</span>
                    <svg class="w-5 h-5 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="hidden p-4 pt-0 bg-white">
                    <p class="text-gray-600">We recommend spending at least 7 to 10 days in Cambodia to fully experience its major attractions, including the temples of Angkor in Siem Reap, the vibrant capital Phnom Penh, the peaceful countryside, and cultural sites across the country. If you plan to explore Tonle Sap Lake or relax at coastal areas like Sihanoukville, consider adding a few extra days to your itinerary.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFAQ(element) {
            // Toggle the hidden content
            const content = element.nextElementSibling;
            content.classList.toggle('hidden');
            
            // Toggle the icon rotation
            const icon = element.querySelector('svg');
            icon.classList.toggle('rotate-180');
        }
    </script>

    <!-- Call to Action - New -->
    <div class="bg-yellow-500 py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Ready to Explore Cambodia?</h2>
            <p class="text-xl text-white mb-8 max-w-3xl mx-auto">Discover the hidden treasures at the heart of Cambodia — ancient temples, stunning natural beauty, and authentic cultural experiences.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="/destinations" class="bg-white text-yellow-600 px-8 py-3 rounded-full text-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Explore All Destinations
                </a>
                <a href="/gallery" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-white/20 transition duration-300">
                    View Photo Gallery
                </a>
            </div>
        </div>
    </div>
</div>

@endsection