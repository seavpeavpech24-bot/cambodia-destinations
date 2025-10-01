@extends('admin.layout')

@section('title', 'Add New Testimonial')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Add New Testimonial</h2>
            <p class="text-gray-600 mt-2 text-sm">Enter details for a new testimonial</p>
        </div>
        <a href="{{ route('admin.testimonials.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to List
        </a>
    </div>

    <!-- Create Form -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data" id="testimonialForm">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="traveller_name" class="block text-sm font-medium text-gray-700">Traveller Name</label>
                    <input type="text" name="traveller_name" id="traveller_name" value="{{ old('traveller_name') }}" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter traveller name...">
                    @error('traveller_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" id="content" rows="4" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter testimonial content...">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                    <select name="rating" id="rating" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                        <option value="" disabled {{ old('rating') ? '' : 'selected' }}>Select rating...</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                {{ str_repeat('★', $i) }}{{ str_repeat('☆', 5-$i) }}
                            </option>
                        @endfor
                    </select>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Image (Optional)</label>
                    <div class="mt-1 space-y-4">
                        <!-- File Input -->
                        <div class="relative">
                            <input type="file" name="image" id="imageInput" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-lg cursor-pointer">
                        </div>
                        
                        <!-- Preview Container -->
                        <div id="previewContainer" style="display: none;">
                            <div class="relative inline-block">
                                <img id="imagePreviewImg" src="" alt="Image Preview" class="h-32 w-32 object-cover rounded-lg border-2 border-gray-200 shadow-sm">
                                <button type="button" id="removeImageBtn" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition duration-200 text-xs font-bold">
                                    ×
                                </button>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">
                                <span class="font-medium">File:</span> <span id="fileName"></span>
                            </p>
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="destination_id" class="block text-sm font-medium text-gray-700">Destination (Optional)</label>
                    <select name="destination_id" id="destination_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                        <option value="">Select destination...</option>
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" {{ old('destination_id') == $destination->id ? 'selected' : '' }}>
                                {{ $destination->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('destination_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="from_country" class="block text-sm font-medium text-gray-700">From Country (Optional)</label>
                    <input type="text" name="from_country" id="from_country" value="{{ old('from_country') }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter country...">
                    @error('from_country')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Visibility</label>
                    <div class="mt-1 flex gap-4">
                        <input type="hidden" name="is_visible" value="0">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', 1) ? 'checked' : '' }} class="form-checkbox text-indigo-600">
                            <span class="ml-2 text-sm text-gray-600">Visible</span>
                        </label>
                    </div>
                    @error('is_visible')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v6a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-6 0h6m-6 0V5a2 2 0 012-2h2a2 2 0 012 2v2"></path>
                        </svg>
                        Save Testimonial
                    </button>
                    <a href="{{ route('admin.testimonials.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('previewContainer');
    const previewImg = document.getElementById('imagePreviewImg');
    const fileName = document.getElementById('fileName');
    const removeBtn = document.getElementById('removeImageBtn');

    // Image upload handler
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validate file type
            if (!file.type.match('image.*')) {
                alert('Please select an image file.');
                imageInput.value = '';
                return;
            }

            // Validate file size (5MB limit)
            if (file.size > 5 * 1024 * 1024) {
                alert('Image size should be less than 5MB.');
                imageInput.value = '';
                return;
            }

            // Create FileReader
            const reader = new FileReader();
            
            reader.onload = function(event) {
                previewImg.src = event.target.result;
                fileName.textContent = file.name;
                previewContainer.style.display = 'block';
            };

            reader.onerror = function() {
                alert('Error reading file. Please try again.');
                imageInput.value = '';
            };

            // Read the file
            reader.readAsDataURL(file);
        } else {
            // No file selected, hide preview
            hidePreview();
        }
    });

    // Remove image handler
    removeBtn.addEventListener('click', function() {
        hidePreview();
        imageInput.value = '';
    });

    function hidePreview() {
        previewContainer.style.display = 'none';
        previewImg.src = '';
        fileName.textContent = '';
    }

    // Form validation
    const form = document.getElementById('testimonialForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const travellerName = document.getElementById('traveller_name').value.trim();
            const content = document.getElementById('content').value.trim();
            const rating = document.getElementById('rating').value;

            if (!travellerName || !content || !rating) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return false;
            }
        });
    }
});
</script>
@endpush
@endsection