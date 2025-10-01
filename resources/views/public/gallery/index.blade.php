@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Photo Gallery</h1>
            <div class="w-24 h-1 bg-yellow-500 mx-auto mb-6"></div>
            <p class="text-gray-600 max-w-3xl mx-auto">Explore our collection of stunning photographs showcasing the beauty and culture of Cambodia's most remarkable destinations.</p>
        </div>

        <!-- Search Box -->
        <div class="max-w-2xl mx-auto mb-12">
            <form action="{{ route('gallery.index') }}" method="GET" class="relative">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search destinations..." 
                           class="w-full px-6 py-3 rounded-full border-2 border-gray-200 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition duration-200"
                    >
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-2">
                        @if(request('search'))
                            <a href="{{ route('gallery.index') }}" 
                               class="text-gray-400 hover:text-red-500 transition-colors duration-200"
                               title="Clear search">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        @endif
                        <button type="submit" class="text-gray-400 hover:text-yellow-500 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Category Filter Buttons -->
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <a href="{{ request()->fullUrlWithQuery(['category' => 'all', 'search' => request('search')]) }}" 
               class="px-6 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ !request('category') || request('category') == 'all' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                All Categories
            </a>
            @foreach($categories as $category)
                <a href="{{ request()->fullUrlWithQuery(['category' => $category->id, 'search' => request('search')]) }}" 
                   class="px-6 py-2 rounded-full text-sm font-medium transition-colors duration-200 {{ request('category') == $category->id ? 'bg-yellow-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    {{ $category->title }}
                </a>
            @endforeach
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($galleryImages as $image)
                <div class="group relative overflow-hidden rounded-lg shadow-lg aspect-w-4 aspect-h-3">
                    <img src="{{ $image->image_url }}" 
                         alt="{{ $image->destination->title ?? 'Gallery image' }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    
                    @if($image->destination)
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                <h3 class="text-xl font-semibold text-white mb-2">{{ $image->destination->title }}</h3>
                                <a href="/destination/{{ $image->destination->id }}" 
                                   class="inline-flex items-center text-yellow-400 hover:text-yellow-300 transition-colors duration-300">
                                    View Destination
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No gallery images available at the moment.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $galleryImages->links() }}
        </div>
    </div>
</div>
@endsection 