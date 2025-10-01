@extends('admin.layout')

@section('title', 'View Getting Around Information')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Getting Around Details</h2>
            <p class="text-gray-600 mt-2 text-sm">View local transport or travel tip details</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.getting-around.edit', $gettingAround) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Item
            </a>
            <a href="{{ route('admin.getting-around.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>
    </div>

    <!-- Details Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 space-y-6">
            <!-- Category -->
            <div>
                <h4 class="text-sm font-medium text-gray-700 mb-2">Category</h4>
                <p class="text-gray-900">{{ $gettingAround->group_by }}</p>
            </div>

            <!-- Content -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Content</h4>
                <div class="prose max-w-none text-gray-600">
                    {{ $gettingAround->content }}
                </div>
            </div>

            <!-- Metadata -->
            <div class="border-t border-gray-100 pt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Created At</h4>
                        <p class="text-gray-600">{{ $gettingAround->created_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Last Updated</h4>
                        <p class="text-gray-600">{{ $gettingAround->updated_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection