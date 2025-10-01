@extends('layouts.app')

@section('content')
<div class="bg-gray-100">
    <!-- Header -->
    <div class="relative h-96">
        @if($heroPage)
            <img src="{{ asset($heroPage->image_url) }}" alt="{{ $heroPage->title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-white mb-2">{{ $heroPage->title }}</h1>
                    <p class="text-xl text-gray-200">{{ $heroPage->description }}</p>
                </div>
            </div>
        @else
            <img src="{{ asset('assets/images/destinations-header.jpg') }}" alt="Cambodia Destinations" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-white mb-2">Discover Cambodia</h1>
                    <p class="text-xl text-gray-200">Ancient temples, natural wonders, and cultural heritage</p>
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

    <!-- Search and Filter Section -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Search Box -->
            <form action="{{ route('destinations.index') }}" method="GET" class="mb-6">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search destinations..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    <button type="submit" 
                            class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 transition duration-300">
                        Search
                    </button>
                    @if(request('search') || request('category'))
                        <a href="{{ route('destinations.index') }}" 
                           class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition duration-300">
                            Clear
                        </a>
                    @endif
                </div>
            </form>

            <!-- Category Filter Buttons -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('destinations.index') }}" 
                   class="px-4 py-2 rounded-lg {{ !request('category') ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    All
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('destinations.index', ['category' => $category->id, 'search' => request('search')]) }}" 
                       class="px-4 py-2 rounded-lg {{ request('category') == $category->id ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        {{ $category->title }} ({{ $category->destinations_count }})
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Destinations Grid -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid md:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="md:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @forelse($destinations as $destination)
                        <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                            @if($destination->gallery->isNotEmpty())
                                <img src="{{ $destination->gallery->first()->image_url }}" 
                                     alt="{{ $destination->title }}" 
                                     class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">No Image Available</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-bold">{{ $destination->title }}</h3>
                                    @if($destination->category)
                                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">
                                            {{ $destination->category->title }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-gray-600 mb-4">{!! Str::limit($destination->description, 100) !!}</p>
                                <div class="space-y-2 mb-4">
                                    @if($destination->location)
                                        <div class="flex items-center text-sm text-gray-500">
                                            <span>📍 Location: {{ $destination->location }}</span>
                                        </div>
                                    @endif
                                    @if($destination->best_time_to_visit)
                                        <div class="flex items-center text-sm text-gray-500">
                                            <span>⏰ Best Time: {{ $destination->best_time_to_visit }}</span>
                                        </div>
                                    @endif
                                </div>
                                <a href="/destination/{{ $destination->id }}" 
                                   class="inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition duration-300">
                                    Learn More
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-12">
                            <p class="text-gray-500 text-lg">No destinations available at the moment.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($destinations->hasPages())
                    <div class="mt-8">
                        {{ $destinations->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Categories -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Categories</h3>
                    <ul class="space-y-3">
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('destinations.index', ['category' => $category->id, 'search' => request('search')]) }}" 
                                   class="flex items-center justify-between text-gray-600 hover:text-yellow-600 transition duration-300">
                                    <span>{{ $category->title }}</span>
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
                                        {{ $category->destinations_count }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

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

                <!-- Popular Articles -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Popular Articles</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-yellow-600 hover:text-yellow-700">Top 10 Temples in Siem Reap</a></li>
                        <li><a href="#" class="text-yellow-600 hover:text-yellow-700">Best Beaches in Cambodia</a></li>
                        <li><a href="#" class="text-yellow-600 hover:text-yellow-700">Local Food Guide</a></li>
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
@endsection 