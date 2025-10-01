@extends('admin.layout')

@section('title', 'Hero Page Demo')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Hero Page Demo</h2>
            <p class="text-gray-600 mt-2 text-sm">Live demo and details for hero section: {{ $heroPage->title ?? 'N/A' }}</p>
        </div>
        <a href="{{ route('admin.hero-pages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300 ease-in-out transform hover:-translate-y-1">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Hero Pages
        </a>
    </div>

    <!-- Live Demo Section -->
    <div class="relative h-96 rounded-xl overflow-hidden shadow-lg border border-gray-100">
        @if($heroPage->image_url)
            <img src="{{ asset($heroPage->image_url) }}" alt="Hero Image" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-600 font-semibold">No Image Available</div>
        @endif
        
        {{-- Demo Live Label --}}
        <span class="absolute top-4 left-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full z-10">Demo Live</span>

        <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black/70 flex items-center justify-center">
            <div class="text-center text-white max-w-2xl px-4">
                <h1 class="text-4xl font-bold mb-3">{{ $heroPage->title ?? '' }}</h1>
                <p class="text-lg">{{ $heroPage->description ?? '' }}</p>
                 {{-- Add placeholder buttons if you want to simulate CTA, e.g.: --}}
                 {{--
                 <div class="flex flex-wrap justify-center gap-4 mt-6">
                    <button class="bg-yellow-500 text-white px-6 py-2 rounded-full text-md font-semibold opacity-70 cursor-not-allowed">Placeholder Button 1</button>
                    <button class="bg-transparent border-2 border-white text-white px-6 py-2 rounded-full text-md font-semibold opacity-70 cursor-not-allowed">Placeholder Button 2</button>
                 </div>
                 --}}
            </div>
        </div>
    </div>

    <!-- Related Data / Details Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-6">
        <h3 class="text-xl font-bold text-gray-900">Hero Page Details</h3>
        
        <!-- ID -->
        <div>
            <p class="text-sm font-medium text-gray-700">ID:</p>
            <p class="mt-1 text-lg text-gray-900">{{ $heroPage->id ?? 'N/A' }}</p>
        </div>

        <!-- Title -->
        <div>
            <p class="text-sm font-medium text-gray-700">Title:</p>
            <p class="mt-1 text-lg text-gray-900">{{ $heroPage->title ?? 'N/A' }}</p>
        </div>

        <!-- Description -->
        <div>
            <p class="text-sm font-medium text-gray-700">Description:</p>
            <p class="mt-1 text-lg text-gray-900">{{ $heroPage->description ?? 'N/A' }}</p>
        </div>

        <!-- Image URL -->
        <div>
            <p class="text-sm font-medium text-gray-700">Image URL:</p>
            <p class="mt-1 text-lg text-gray-900 break-all">{{ $heroPage->image_url ?? 'N/A' }}</p>
        </div>

        <!-- Page -->
        <div>
            <p class="text-sm font-medium text-gray-700">Page:</p>
            <p class="mt-1 text-lg text-gray-900">{{ $heroPage->page ?? 'N/A' }}</p>
        </div>

        <!-- Created At -->
        <div>
            <p class="text-sm font-medium text-gray-700">Created At:</p>
            <p class="mt-1 text-lg text-gray-900">{{ $heroPage->created_at ? $heroPage->created_at->format('m-d-Y h:i:s A') : 'N/A' }}</p>
        </div>

         <!-- Updated At -->
        <div>
            <p class="text-sm font-medium text-gray-700">Updated At:</p>
            <p class="mt-1 text-lg text-gray-900">{{ $heroPage->updated_at ? $heroPage->updated_at->format('m-d-Y h:i:s A') : 'N/A' }}</p>
        </div>

    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex justify-end gap-3">
        <a href="{{ route('admin.hero-pages.edit', $heroPage) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition duration-300">
             <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Hero Page
        </a>
        <a href="{{ route('admin.hero-pages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
            Back to List
        </a>
    </div>
</div>
@endsection