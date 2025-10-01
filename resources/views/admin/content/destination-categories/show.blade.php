@extends('admin.layout')

@section('title', 'View Destination Category: ' . $destinationCategory->title)

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $destinationCategory->title }}</h2>
            <p class="text-gray-600 mt-2 text-sm">Detailed view of the category</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.destination-categories.edit', $destinationCategory) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-300 ease-in-out transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Category
            </a>
            <a href="{{ route('admin.destination-categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300 ease-in-out transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Categories
            </a>
        </div>
    </div>

    <!-- Category Details -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="grid grid-cols-1 gap-6">
            <div class="flex items-center space-x-4">
                @if($destinationCategory->icon_class)
                    <div class="h-12 w-12 bg-gray-100 rounded-full flex items-center justify-center">
                         <i class="{{ $destinationCategory->icon_class }} text-gray-600 text-2xl"></i>
                    </div>
                @else
                    <div class="h-12 w-12 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Details</h3>
                    <p><strong>Title:</strong> {{ $destinationCategory->title }}</p>
                    <p><strong>Destinations Count:</strong> {{ $destinationCategory->destinations->count() }}</p>
                    <p><strong>Created:</strong> {{ $destinationCategory->created_at->format('m-d-Y h:i:s A') }}</p>
                    <p><strong>Updated:</strong> {{ $destinationCategory->updated_at->format('m-d-Y h:i:s A') }}</p>
                </div>
            </div>
            <div>
                <strong>Description:</strong>
                <p class="text-gray-600">{{ $destinationCategory->description ?? 'No description provided' }}</p>
            </div>
        </div>
    </div>

    <!-- Associated Destinations -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Associated Destinations</h3>
        @if($destinationCategory->destinations->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($destinationCategory->destinations as $destination)
                    <div class="p-4 bg-gray-50 rounded-lg hover:bg-indigo-50 transition duration-200">
                        <h4 class="text-sm font-medium text-gray-900">{{ $destination->title }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $destination->location ?? 'No location specified' }}</p>
                        <a href="{{ route('admin.destinations.show', $destination) }}" class="text-indigo-600 hover:text-indigo-800 text-sm mt-2 inline-block">View Details</a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">No destinations are currently associated with this category.</p>
        @endif
    </div>

    <!-- Font Awesome for Icon Preview -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</div>
@endsection