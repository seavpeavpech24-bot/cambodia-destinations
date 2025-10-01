@extends('layouts.app')

@section('content')
<div class="bg-gray-100">
    @if($destination)
    <!-- Hero Section -->
    <div class="relative h-96">
        @if($destination->gallery->isNotEmpty())
            <img src="{{ $destination->gallery->first()->image_url }}" alt="{{ $destination->title }}" class="w-full h-full object-cover">
        @else
            <img src="{{ asset('assets/images/default-destination.jpg') }}" alt="{{ $destination->title }}" class="w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white mb-2">{{ $destination->title }}</h1>
                @if($destination->category)
                    <span class="bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full">
                        {{ $destination->category->title }}
                    </span>
                @endif
            </div>
        </div>
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

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold mb-6">About {{ $destination->title }}</h2>
                    <div class="prose max-w-none text-gray-600 mb-8">{!! $destination->description !!}</div>

                    <!-- Key Information -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="border rounded-lg p-4">
                            <h3 class="font-bold mb-2">📍 Location</h3>
                            @if($destination->map_link)
                                <a href="{{ $destination->map_link }}" target="_blank" rel="noopener noreferrer">
                                    <p class="text-gray-600">{{ $destination->location }}</p>
                                </a>
                            @else
                                <p class="text-gray-600">{{ $destination->location }}</p>
                            @endif
                        </div>
                        <div class="border rounded-lg p-4">
                            <h3 class="font-bold mb-2">⏰ Best Time to Visit</h3>
                            <p class="text-gray-600">{{ $destination->best_time_to_visit }}</p>
                        </div>
                        @if($destination->entry_fee)
                        <div class="border rounded-lg p-4">
                            <h3 class="font-bold mb-2">💰 Entry Fee</h3>
                            <p class="text-gray-600">{{ $destination->entry_fee }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Activities -->
                    @if($destination->activities->isNotEmpty())
                    <h3 class="text-xl font-bold mb-4">Activities</h3>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($destination->activities as $activity)
                        <li class="flex items-center space-x-2">
                            <span class="text-yellow-500">✓</span>
                            <span>{{ $activity->content }}</span>
                        </li>
                        @endforeach
                    </ul>
                    @endif

                    <!-- Travel Tips -->
                    @if($destination->travelTips->isNotEmpty())
                    <div class="mt-8">
                        <h3 class="text-xl font-bold mb-4">Travel Tips</h3>
                        <div class="space-y-4">
                            @foreach($destination->travelTips->groupBy('group_by') as $group => $tips)
                            <div class="border rounded-lg">
                                <button class="w-full text-left p-4 bg-gray-50 hover:bg-gray-100 font-bold flex justify-between items-center" onclick="this.nextElementSibling.classList.toggle('hidden')">
                                    {{ $group ?: 'General Tips' }}
                                    <span class="text-yellow-500">▼</span>
                                </button>
                                <div class="p-4 hidden">
                                    <ul class="list-disc list-inside space-y-2 text-gray-600">
                                        @foreach($tips as $tip)
                                        <li>
                                            <strong>{{ $tip->title }}:</strong> 
                                            {{ $tip->description }}
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Gallery -->
                    @if($destination->gallery->count() > 1)
                    <div class="mt-8">
                        <h3 class="text-xl font-bold mb-4">Gallery</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($destination->gallery->skip(1) as $image)
                            <div class="relative aspect-square">
                                <img src="{{ $image->image_url }}" 
                                     alt="{{ $destination->title }}" 
                                     class="absolute inset-0 w-full h-full object-cover rounded-lg">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Map -->
                <!-- <div class="bg-white rounded-lg shadow-lg p-4">
                    <div class="bg-gray-200 h-64 flex items-center justify-center relative overflow-hidden rounded-md">
                        @if($destination->map_link)
                            <iframe 
                                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDHQ3Jyi5l966vpyNcoTzXwBvPEOOicPUQ&q={{ urlencode($destination->location) }}" 
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        @else
                            <span class="text-gray-500">Map Coming Soon</span>
                        @endif
                    </div>
                </div> -->

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

                <!-- Related Destinations -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Nearby Attractions</h3>
                    <ul class="space-y-3">
                        @if($destination->category)
                            @foreach($destination->category->destinations()->where('id', '!=', $destination->id)->take(3)->get() as $relatedDestination)
                                <li>
                                    <a href="{{ route('destinations.show', $relatedDestination->id) }}" 
                                       class="text-yellow-600 hover:text-yellow-700">
                                        {{ $relatedDestination->title }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li class="text-gray-500">No related destinations found</li>
                        @endif
                    </ul>
                </div>

                <!-- Bottom Ad Space -->
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <h2 class="text-2xl font-bold mb-4">Destination Not Found</h2>
            <p class="text-gray-600 mb-6">The destination you're looking for doesn't exist or has been removed.</p>
            <a href="{{ route('destinations.index') }}" class="inline-block bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 transition duration-300">
                Back to Destinations
            </a>
        </div>
    </div>
@endif
@endsection