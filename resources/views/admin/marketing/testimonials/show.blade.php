@extends('admin.layout')

@section('title', 'View Testimonial')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $testimonial->traveller_name }}</h2>
            <p class="text-gray-600 mt-2 text-sm">Preview and details of the testimonial</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Testimonial
            </a>
            <a href="{{ route('admin.testimonials.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to List
            </a>
        </div>
    </div>

    <!-- Testimonial Preview and Details -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="space-y-6">
            @if($testimonial->image_url)
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ Storage::url($testimonial->image_url) }}" alt="{{ $testimonial->traveller_name }}" class="w-full h-96 object-cover rounded-lg">
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Traveller Name</h3>
                        <p class="text-sm text-gray-600">{{ $testimonial->traveller_name }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Content</h3>
                        <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $testimonial->content }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Rating</h3>
                        <p class="text-sm text-gray-600">
                            {{ str_repeat('★', $testimonial->rating) }}{{ str_repeat('☆', 5-$testimonial->rating) }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Destination</h3>
                        <p class="text-sm text-gray-600">{{ $testimonial->destination->title ?? 'No Destination' }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">From Country</h3>
                        <p class="text-sm text-gray-600">{{ $testimonial->from_country ?? 'Not specified' }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Status</h3>
                        <p class="text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $testimonial->is_visible ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $testimonial->is_visible ? 'Visible' : 'Hidden' }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Created At</h3>
                        <p class="text-sm text-gray-600">{{ $testimonial->created_at->format('M d, Y H:i') }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Last Updated</h3>
                        <p class="text-sm text-gray-600">{{ $testimonial->updated_at->format('M d, Y H:i') }}</p>
                    </div>

                    @if($testimonial->updatedBy)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Last Updated By</h3>
                            <p class="text-sm text-gray-600">{{ $testimonial->updatedBy->name }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection