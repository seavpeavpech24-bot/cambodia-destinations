@extends('admin.layout')

@section('title', 'Gallery Item Details')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Gallery Item Details</h2>
            <p class="text-gray-600 mt-2 text-sm">Details of gallery item #{{ $gallery->id }}</p>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('admin.gallery.edit', $gallery) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition duration-300 ease-in-out transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300 ease-in-out transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Gallery
            </a>
        </div>
    </div>

    <!-- Gallery Item Details -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Image -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Image</h3>
            @if($gallery->image_url)
                <img src="{{ asset($gallery->image_url) }}" alt="Gallery Image" class="w-full h-auto object-cover rounded-lg">
            @else
                <p class="text-gray-600">No image available.</p>
            @endif
        </div>

        <!-- Details -->
        <div class="space-y-4">
            <div>
                <p class="text-sm font-medium text-gray-700">ID:</p>
                <p class="mt-1 text-gray-900">{{ $gallery->id }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700">Destination:</p>
                <p class="mt-1 text-gray-900">{{ $gallery->destination->title ?? 'N/A' }}</p>
            </div>
             <div>
                <p class="text-sm font-medium text-gray-700">Display on Main Page:</p>
                <p class="mt-1 text-gray-900">{{ $gallery->main_page_display ? 'Yes' : 'No' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700">Created At:</p>
                <p class="mt-1 text-gray-900">{{ $gallery->created_at->format('m-d-Y H:i:s') }}</p>
            </div>
             <div>
                <p class="text-sm font-medium text-gray-700">Updated At:</p>
                <p class="mt-1 text-gray-900">{{ $gallery->updated_at->format('m-d-Y H:i:s') }}</p>
            </div>
        </div>

    </div>
</div>
@endsection