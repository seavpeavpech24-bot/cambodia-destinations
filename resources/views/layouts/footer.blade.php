<!-- Footer -->
<footer class="bg-gray-800 text-white">
    @php
        $webInfo = \App\Models\WebInfo::first();
    @endphp
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">About Us</h3>
                <p class="text-gray-300">Discover the beauty of Cambodia with our expertly curated tours and travel experiences.</p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="/destinations" class="text-gray-300 hover:text-white">Popular Destinations</a></li>
                    <li><a href="/tours" class="text-gray-300 hover:text-white">Featured Tours</a></li>
                    <li><a href="/booking" class="text-gray-300 hover:text-white">Book Now</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Contact</h3>
                <ul class="space-y-2 text-gray-300">
                    @if($webInfo->phone_number)
                        <li><i class="fas fa-phone mr-2"></i> {{ $webInfo->phone_number }}</li>
                    @endif
                    @if($webInfo->email)
                        <li><i class="fas fa-envelope mr-2"></i> {{ $webInfo->email }}</li>
                    @endif
                    @if($webInfo->location)
                        <li><i class="fas fa-map-marker-alt mr-2"></i> {{ $webInfo->location }}</li>
                    @endif
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Follow Us</h3>
                <div class="flex space-x-4">
                    @if($webInfo->facebook_link)
                        <a href="{{ $webInfo->facebook_link }}" target="_blank" class="text-gray-300 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                    @if($webInfo->youtube_link)
                        <a href="{{ $webInfo->youtube_link }}" target="_blank" class="text-gray-300 hover:text-white">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif
                    @if($webInfo->instagram_link)
                        <a href="{{ $webInfo->instagram_link }}" target="_blank" class="text-gray-300 hover:text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} {{ $webInfo->title ?? 'Cambodia Wonderland' }}. All rights reserved.</p>
        </div>
    </div>
</footer>