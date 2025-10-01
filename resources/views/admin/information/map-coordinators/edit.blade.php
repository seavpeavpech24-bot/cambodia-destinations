@extends('admin.layout')

@section('title', 'Edit Map Location')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Map Location</h2>
            <p class="text-gray-600 mt-2 text-sm">Update location details and coordinates</p>
        </div>
        <a href="{{ route('admin.map-coordinators.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.map-coordinators.update', $mapCoordinator) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title Field -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $mapCoordinator->title) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('title') border-red-500 @enderror"
                           placeholder="Enter location title">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type Field -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="type" 
                            id="type" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('type') border-red-500 @enderror">
                        <option value="">Select a type</option>
                        @foreach(App\Models\MapCoordinator::TYPE_OPTIONS as $value => $label)
                            <option value="{{ $value }}" {{ old('type', $mapCoordinator->type) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Destination Field -->
                <div>
                    <label for="destination_id" class="block text-sm font-medium text-gray-700 mb-2">Destination (Optional)</label>
                    <select name="destination_id" 
                            id="destination_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('destination_id') border-red-500 @enderror">
                        <option value="">Select a destination</option>
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" {{ old('destination_id', $mapCoordinator->destination_id) == $destination->id ? 'selected' : '' }}>
                                {{ $destination->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('destination_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon Class Field -->
                <div>
                    <label for="icon_class" class="block text-sm font-medium text-gray-700 mb-2">Icon Class</label>
                    <input type="text" 
                           name="icon_class" 
                           id="icon_class" 
                           value="{{ old('icon_class', $mapCoordinator->icon_class) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('icon_class') border-red-500 @enderror"
                           placeholder="Enter Font Awesome icon class">
                    @error('icon_class')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Latitude and Longitude Field -->
                <div>
                    <label for="latitude_and_longitude" class="block text-sm font-medium text-gray-700 mb-2">Coordinates</label>
                    <input type="text" 
                           name="latitude_and_longitude" 
                           id="latitude_and_longitude" 
                           value="{{ old('latitude_and_longitude', $mapCoordinator->latitude_and_longitude) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('latitude_and_longitude') border-red-500 @enderror"
                           placeholder="Enter latitude and longitude">
                    @error('latitude_and_longitude')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Map Link Field -->
                <div>
                    <label for="map_link" class="block text-sm font-medium text-gray-700 mb-2">Map Link</label>
                    <input type="url" 
                           name="map_link" 
                           id="map_link" 
                           value="{{ old('map_link', $mapCoordinator->map_link) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('map_link') border-red-500 @enderror"
                           placeholder="Enter Google Maps link">
                    @error('map_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cover Image Field -->
                <div class="md:col-span-2">
                    <label for="cover_url" class="block text-sm font-medium text-gray-700 mb-2">Cover Image</label>
                    @if($mapCoordinator->cover_url)
                        <div class="mb-4">
                            <img src="{{ $mapCoordinator->cover_url }}" alt="Current cover image" class="w-32 h-32 object-cover rounded-lg">
                            <p class="mt-2 text-sm text-gray-500">Current cover image</p>
                        </div>
                    @endif
                    <input type="file" 
                           name="cover_url" 
                           id="cover_url" 
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('cover_url') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">Upload a new image (max 2MB, jpeg, png, jpg, gif)</p>
                    @error('cover_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description Field -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" 
                              id="description" 
                              rows="4" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('description') border-red-500 @enderror"
                              placeholder="Enter location description">{{ old('description', $mapCoordinator->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-300 ease-in-out transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Location
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 