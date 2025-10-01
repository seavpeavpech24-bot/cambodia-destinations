@extends('admin.layout')

@section('title', $destination->title)

@section('content')
<br>
<!-- Header Section -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Demo Destination</h2>
            <p class="text-gray-600 mt-2 text-sm">Details for {{ $destination->title }}</p>
        </div>
        <a href="{{ route('admin.destinations.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300 ease-in-out transform hover:-translate-y-1">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Destinations
        </a>
    </div>
<br>

<div class="bg-gray-100">
    <!-- Hero Section -->
    <div class="relative h-96">
        @if($destination->cover_url)
            <img src="{{ $destination->cover_url }}" alt="{{ $destination->title }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white mb-2">{{ $destination->title }}</h1>
                @if($destination->category)
                    <span class="bg-indigo-100 text-indigo-800 text-sm px-3 py-1 rounded-full">
                        {{ $destination->category->title }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold mb-6">About {{ $destination->title }}</h2>
                    <div class="prose max-w-none text-gray-600 mb-8">{{ $destination->description }}</div>

                    <!-- Key Information -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <div class="border rounded-lg p-4">
                            <h3 class="font-bold mb-2">📍 Location</h3>
                            <a href="{{ $destination->map_link ?? 'https://www.google.com/maps' }}" target="_blank"><p class="text-blue-600">{{ $destination->location ?? 'N/A' }}</p></a>
                        </div>
                        <div class="border rounded-lg p-4">
                            <h3 class="font-bold mb-2">⏰ Best Time to Visit</h3>
                            <p class="text-gray-600">{{ $destination->best_time_to_visit ?? 'N/A' }}</p>
                        </div>
                        <div class="border rounded-lg p-4">
                            <h3 class="font-bold mb-2">💰 Entry Fee</h3>
                            <p class="text-gray-600">{{ $destination->entry_fee ?? 'N/A' }}</p>
                        </div>
                         @if($destination->category)
                         <div class="border rounded-lg p-4">
                            <h3 class="font-bold mb-2">Category</h3>
                            <p class="text-gray-600">
                                <a href="{{ route('admin.destination-categories.show', $destination->category) }}" class="text-indigo-600 hover:text-indigo-800">
                                    {{ $destination->category->title }}
                                </a>
                            </p>
                        </div>
                         @endif
                    </div>

                    {{-- Activities --}}
                    <h3 class="text-xl font-bold mb-4">Activities</h3>
                    @if($destination->activities->count() > 0)
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                            @foreach($destination->activities as $activity)
                                <li class="flex items-center space-x-2">
                                    <span class="text-green-500">✓</span>
                                    <span>{{ $activity->content }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600 mb-8">No activities available for this destination.</p>
                    @endif

                    {{-- Travel Tips --}}
                    <div class="mt-8">
                        <h3 class="text-xl font-bold mb-4">Travel Tips</h3>
                        @if($destination->travelTips->count() > 0)
                        <div class="space-y-4">
                            @foreach($destination->travelTips->groupBy('group_by') as $group => $tips)
                                <div class="border rounded-lg">
                                    <button class="w-full text-left p-4 bg-gray-50 hover:bg-gray-100 font-bold flex justify-between items-center" onclick="this.nextElementSibling.classList.toggle('hidden')">
                                        {{ $group ?? 'General Tips' }}
                                        <span class="text-yellow-500">▼</span>
                                    </button>
                                    <div class="p-4 hidden">
                                        <ul class="list-disc list-inside space-y-2 text-gray-600">
                                            @foreach($tips as $tip)
                                                <li>
                                                    @if($tip->title)
                                                        <strong>{{ $tip->title }}:</strong>
                                                    @endif
                                                    {{ $tip->description }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @else
                            <p class="text-gray-600">No travel tips available for this destination.</p>
                        @endif
                    </div>

                    {{-- Gallery --}}
                    <div class="mt-8">
                        <h3 class="text-2xl font-bold mb-6">Gallery</h3>
                        @if($destination->gallery->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($destination->gallery as $galleryItem)
                                <div class="rounded-lg overflow-hidden relative">
                                    <img src="{{ $galleryItem->image_url }}" alt="{{ $destination->title }} - Gallery Image" class="w-full h-48 object-cover">
                                    @if($galleryItem->main_page_display)
                                        <span class="absolute top-2 right-2 bg-indigo-600 text-white text-xs px-2 py-1 rounded">Main</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        @else
                            <p class="text-gray-600">No gallery images available for this destination.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Related Destinations -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Nearby Attractions</h3>
                        {{-- Placeholder for related destinations --}}
                        <p class="text-gray-600">No nearby attractions available.</p>
                        {{--
                        <ul class="space-y-3">
                                <li>
                                    <a href="{{ route('admin.destinations.show', 2) }}" class="text-yellow-600 hover:text-yellow-700">{{ 'title' }}</a>
                                </li>
                        </ul>
                        --}}
                </div>
            </div>
        </div>
    </div>
    {{-- Remove Destination Not Found Block --}}
    {{--
    <div class="h-96 flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Destination Not Found</h1>
            <a href="{{ route('admin.destinations.index') }}" class="text-yellow-600 hover:text-yellow-700">← Back to Destinations</a>
        </div>
    </div>
    --}}
</div>
@endsection