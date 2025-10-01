@extends('admin.layout')

@section('title', 'Add Gallery Item')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Add Gallery Item</h2>
            <p class="text-gray-600 mt-2 text-sm">Upload a new image to the gallery</p>
        </div>
        <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300 ease-in-out transform hover:-translate-y-1">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Gallery
        </a>
    </div>

    <!-- Create Form -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-6">

                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200" required>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Destination -->
                <div>
                    <label for="destination_id" class="block text-sm font-medium text-gray-700">Destination</label>
                    <select name="destination_id" id="destination_id" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                        <option value="">Select a destination (optional)</option>
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" {{ old('destination_id') == $destination->id ? 'selected' : '' }}>{{ $destination->title }}</option>
                        @endforeach
                    </select>
                    @error('destination_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Main Page Display Checkbox -->
                 <div class="flex items-center">
                    <input type="checkbox" name="main_page_display" id="main_page_display" value="1" {{ old('main_page_display') ? 'checked' : '' }} class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <label for="main_page_display" class="ml-2 block text-sm text-gray-900">Display on Main Page</label>
                    @error('main_page_display')
                         <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                     @enderror
                </div>

            </div>

            <!-- Submit Button -->
            <div class="mt-6 flex justify-end gap-3">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Upload Image
                </button>
                <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection