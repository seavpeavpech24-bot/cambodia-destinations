@extends('layouts.app')

@section('content')
<div class="bg-gray-100">
    <!-- Header -->
    <div class="relative h-96">
        @if($hero && $hero->image_url)
            <img src="{{ asset($hero->image_url) }}" alt="{{ $hero->title }}" class="w-full h-full object-cover">
        @else
            <img src="https://i.pinimg.com/736x/40/3f/2b/403f2b1fd9d5adae1365b0c2d2446fb8.jpg" alt="About Us" class="w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <h1 class="text-4xl font-bold text-white">{{ $hero->title ?? 'About This Platform' }}</h1>
        </div>
    </div>

    <!-- Ad Space - Top Banner -->
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
            @else
                <span class="text-gray-500">Advertisement Space</span>
            @endif
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="md:col-span-2 bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-3xl font-bold mb-6">Discover Cambodia's Beauty</h2>
                <p class="text-gray-600 mb-6">
                    Welcome to our platform dedicated to showcasing the incredible beauty, rich culture, and amazing destinations of Cambodia. As a passionate content creator, I aim to provide authentic insights and valuable information about my beloved country.
                </p>
                
                <h3 class="text-2xl font-bold mb-4">Our Mission</h3>
                <p class="text-gray-600 mb-6">
                    To promote Cambodia's tourism by providing accurate, up-to-date information about destinations, cultural experiences, and travel tips. We collaborate with local communities to bring you genuine stories and authentic perspectives.
                </p>

                <h3 class="text-2xl font-bold mb-4">What We Offer</h3>
                <ul class="list-disc list-inside text-gray-600 space-y-2 mb-6">
                    <li>Detailed guides to Cambodia's top destinations</li>
                    <li>Cultural insights and local perspectives</li>
                    <li>Travel tips and recommendations</li>
                    <li>Updated information about events and festivals</li>
                    <li>Photo galleries and travel stories</li>
                </ul>
            </div>

            <!-- Sidebar with Ad Space -->
            <div class="space-y-8">
                <!-- Ad Space - Sidebar Top -->
                <div class="bg-white rounded-lg shadow-lg p-4">
                    <div class="bg-gray-200 h-64 flex items-center justify-center relative overflow-hidden rounded-md">
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
                        @else
                            <span class="text-gray-500">Advertisement Space</span>
                        @endif
                    </div>
                </div>

                <!-- Newsletter Signup -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Stay Updated</h3>
                    <p class="text-gray-600 mb-4">Subscribe to our newsletter for the latest updates about Cambodia tourism.</p>
                    <form id="newsletterForm" class="space-y-4">
                        @csrf
                        <input type="email" 
                               name="email" 
                               id="newsletterEmail"
                               placeholder="Your email address" 
                               class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-yellow-500"
                               required>
                        <button type="submit" 
                                id="subscribeButton"
                                class="w-full bg-yellow-500 text-white py-2 rounded font-semibold hover:bg-yellow-600 transition duration-300">
                            Subscribe
                        </button>
                    </form>
                    <div id="newsletterMessage" class="mt-2 text-sm hidden"></div>
                    <p class="text-xs text-gray-500 mt-2">We respect your privacy. Unsubscribe at any time.</p>
                </div>

                <!-- Ad Space - Sidebar Bottom -->
                <div class="bg-white rounded-lg shadow-lg p-4">
                    <div class="bg-gray-200 h-64 flex items-center justify-center relative overflow-hidden rounded-md">
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
                        @else
                            <span class="text-gray-500">Advertisement Space</span>
                        @endif
                    </div>
                </div>
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
@endsection 