@extends('admin.layout')

@section('title', 'View Advertisement')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $advertising->title }}</h2>
            <p class="text-gray-600 mt-2 text-sm">Preview and details of the advertisement</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.advertising.edit', $advertising->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Advertisement
            </a>
            <a href="{{ route('admin.advertising.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to List
            </a>
        </div>
    </div>

    <!-- Ad Preview and Details -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="space-y-6">
            @if($advertising->image_url)
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ Storage::url($advertising->image_url) }}" alt="{{ $advertising->title }}" class="w-full h-96 object-cover rounded-lg">
                </div>
            @endif
            @if($advertising->video_url)
                <div class="aspect-w-16 aspect-h-9">
                    <video controls class="w-full h-96 rounded-lg">
                        <source src="{{ Storage::url($advertising->video_url) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            @endif
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Title</h3>
                    <p class="text-sm text-gray-600">{{ $advertising->title }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Description</h3>
                    <p class="text-sm text-gray-600">{{ $advertising->description }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Link</h3>
                    <p class="text-sm text-gray-600">
                        @if($advertising->link)
                            <a href="{{ $advertising->link }}" target="_blank" class="text-indigo-600 hover:underline">View ads</a>
                        @else
                            No link provided.
                        @endif
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Date Range</h3>
                    <p class="text-sm text-gray-600">
                        {{ $advertising->start_date->format('M d, Y') }} - {{ $advertising->expire_date->format('M d, Y') }}
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Status</h3>
                    <p class="text-sm text-gray-600">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $advertising->is_visible ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $advertising->is_visible ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Created At</h3>
                    <p class="text-sm text-gray-600">{{ $advertising->created_at->format('M d, Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection