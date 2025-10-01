@extends('admin.layout')

@section('title', 'View YouTube Video')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">YouTube Video Details</h2>
            <p class="text-gray-600 mt-2 text-sm">Details for: {{ $youtubeVideo->title ?? 'N/A' }}</p>
        </div>
        <a href="{{ route('admin.youtube-videos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300 ease-in-out transform hover:-translate-y-1">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to YouTube Videos
        </a>
    </div>

    <!-- Video Details -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-6">
        <!-- Title -->
        <div>
            <p class="text-sm font-medium text-gray-700">Title:</p>
            <p class="mt-1 text-lg text-gray-900">{{ $youtubeVideo->title ?? 'N/A' }}</p>
        </div>

        <!-- Video -->
        @if($youtubeVideo->video_id)
        <div>
            <p class="text-sm font-medium text-gray-700">Video Preview:</p>
            <div class="mt-1 w-full max-w-xl rounded-lg overflow-hidden shadow-lg aspect-video">
                <iframe src="https://www.youtube.com/embed/{{ $youtubeVideo->video_id }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        class="w-full h-full">
                </iframe>
            </div>
        </div>
        @endif

        <!-- Video ID -->
        <div>
            <p class="text-sm font-medium text-gray-700">Video ID:</p>
            <p class="mt-1 text-lg text-gray-900">{{ $youtubeVideo->video_id ?? 'N/A' }}</p>
        </div>

        <!-- Description -->
        <div>
            <p class="text-sm font-medium text-gray-700">Description:</p>
            <p class="mt-1 text-lg text-gray-900">{{ $youtubeVideo->description ?? 'N/A' }}</p>
        </div>

        <!-- Created At -->
        <div>
            <p class="text-sm font-medium text-gray-700">Created At:</p>
            <p class="mt-1 text-lg text-gray-900">{{ $youtubeVideo->created_at ? $youtubeVideo->created_at->format('m-d-Y h:i:s A') : 'N/A' }}</p>
        </div>

         <!-- Updated At -->
        <div>
            <p class="text-sm font-medium text-gray-700">Updated At:</p>
            <p class="mt-1 text-lg text-gray-900">{{ $youtubeVideo->updated_at ? $youtubeVideo->updated_at->format('m-d-Y h:i:s A') : 'N/A' }}</p>
        </div>

    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex justify-end gap-3">
        <a href="{{ route('admin.youtube-videos.edit', $youtubeVideo) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition duration-300">
             <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Video
        </a>
        <a href="{{ route('admin.youtube-videos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
            Back to List
        </a>
    </div>
</div>
@endsection