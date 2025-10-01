@extends('admin.layout')

@section('title', 'Create Destination')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Create Destination</h2>
            <p class="text-gray-600 mt-2 text-sm">Add a new destination with activities, travel tips, and images</p>
        </div>
        <a href="{{ route('admin.destinations.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300 ease-in-out transform hover:-translate-y-1">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Destinations
        </a>
    </div>

    <!-- Create Form -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <form method="POST" action="{{ route('admin.destinations.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <!-- Destination Fields -->
                <div class="border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Destination Details</h3>
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Google Map Link -->
                <div>
                    <label for="map_link" class="block text-sm font-medium text-gray-700">Google Map Link</label>
                    <input type="text" name="map_link" id="map_link" value="{{ old('map_link') }}" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                    @error('map_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="category_id" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Best Time to Visit -->
                <div>
                    <label for="best_time_to_visit" class="block text-sm font-medium text-gray-700">Best Time to Visit</label>
                    <input type="text" name="best_time_to_visit" id="best_time_to_visit" value="{{ old('best_time_to_visit') }}" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                    @error('best_time_to_visit')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Entry Fee -->
                <div>
                    <label for="entry_fee" class="block text-sm font-medium text-gray-700">Entry Fee</label>
                    <input type="text" name="entry_fee" id="entry_fee" value="{{ old('entry_fee') }}" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                    @error('entry_fee')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cover Image -->
                <div>
                    <label for="cover_url" class="block text-sm font-medium text-gray-700">Cover Image</label>
                    <input type="file" name="cover_url" id="cover_url" accept="image/*" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                    <div id="cover-image-preview" class="mt-2 hidden">
                        <img src="#" alt="Cover Image Preview" class="h-32 w-auto rounded-lg object-cover">
                    </div>
                    @error('cover_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Activities Section --}}
                <div class="border-b pb-4 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900">Activities</h3>
                    <p class="text-sm text-gray-600">Add activities available at this destination</p>
                </div>

                <div id="activities-container" class="space-y-4">
                    <div class="activity-group grid grid-cols-1 gap-4">
                        <div>
                            <label for="activities[0][content]" class="block text-sm font-medium text-gray-700">Activity</label>
                            <input type="text" name="activities[0][content]" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                            @error('activities.0.content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="button" class="remove-activity inline-flex items-center px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 text-sm">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-activity" class="mt-2 inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                    Add Another Activity
                </button>

                {{-- Travel Tips Section --}}
                <div class="border-b pb-4 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900">Travel Tips</h3>
                    <p class="text-sm text-gray-600">Add travel tips for this destination</p>
                </div>

                <div id="tips-container" class="space-y-4">
                    <div class="tip-group grid grid-cols-1 gap-4">
                        <div>
                            <label for="travel_tips[0][title]" class="block text-sm font-medium text-gray-700">Tip Title</label>
                            <input type="text" name="travel_tips[0][title]" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                            @error('travel_tips.0.title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="travel_tips[0][description]" class="block text-sm font-medium text-gray-700">Tip Description</label>
                            <textarea name="travel_tips[0][description]" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"></textarea>
                            @error('travel_tips.0.description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="travel_tips[0][group_by]" class="block text-sm font-medium text-gray-700">Group By</label>
                            <input type="text" name="travel_tips[0][group_by]" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                            @error('travel_tips.0.group_by')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="button" class="remove-tip inline-flex items-center px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 text-sm">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-tip" class="mt-2 inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                    Add Another Tip
                </button>

                {{-- Gallery Section --}}
                <div class="border-b pb-4 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900">Gallery Images</h3>
                    <p class="text-sm text-gray-600">Upload images for this destination</p>
                </div>

                <div id="gallery-container" class="space-y-4">
                    <div class="gallery-group grid grid-cols-1 gap-4">
                        <div>
                            <label for="gallery[0][image]" class="block text-sm font-medium text-gray-700">Image</label>
                            <input type="file" name="gallery[0][image]" accept="image/*" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 image-input">
                            <input type="hidden" name="gallery[0][exists]" value="1">
                            <div class="image-preview mt-2 hidden">
                                <img src="#" alt="Image Preview" class="h-32 w-auto rounded-lg object-cover preview-img">
                            </div>
                            @error('gallery.0.image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="gallery[0][main_page_display]" class="block text-sm font-medium text-gray-700">Display on Main Page</label>
                            <input type="checkbox" name="gallery[0][main_page_display]" value="1" class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            @error('gallery.0.main_page_display')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="button" class="remove-image inline-flex items-center px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 text-sm">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-image" class="mt-2 inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                    Add Another Image
                </button>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 flex justify-end gap-3">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Save Destination
                </button>
                <a href="{{ route('admin.destinations.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- CKEditor Script -->
    <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
    <script>
        // Image preview for cover image
        const coverImageInput = document.getElementById('cover_url');
        const coverImagePreview = document.getElementById('cover-image-preview');
        const coverImagePreviewImg = coverImagePreview.querySelector('img');

        coverImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    coverImagePreviewImg.src = e.target.result;
                    coverImagePreview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                coverImagePreviewImg.src = '#';
                coverImagePreview.classList.add('hidden');
            }
        });

        // Initialize CKEditor for description
        CKEDITOR.replace('description', {
            height: 200,
            toolbar: [
                { name: 'basic', items: ['Bold', 'Italic', 'Underline', 'Link', 'Unlink', 'NumberedList', 'BulletedList'] },
                { name: 'paragraph', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight'] }
            ],
            allowedContent: true,
            entities: false,
            basicEntities: false,
            entities_greek: false,
            entities_latin: false,
            entities_additional: ''
        });

        // Dynamic Activities
        let activityIndex = 1;
        document.getElementById('add-activity').addEventListener('click', function () {
            const container = document.getElementById('activities-container');
            const newActivity = document.createElement('div');
            newActivity.classList.add('activity-group', 'grid', 'grid-cols-1', 'gap-4', 'items-center');
            newActivity.innerHTML = `
                <div>
                    <label for="activities[${activityIndex}][content]" class="block text-sm font-medium text-gray-700">Activity</label>
                    <input type="text" name="activities[${activityIndex}][content]" id="activities[${activityIndex}][content]" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                </div>
                <button type="button" class="remove-activity inline-flex items-center px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 text-sm">Remove</button>
            `;
            container.appendChild(newActivity);
            activityIndex++;
        });

        // Dynamic Travel Tips
        let tipIndex = 1;
        document.getElementById('add-tip').addEventListener('click', function () {
            const container = document.getElementById('tips-container');
            const newTip = document.createElement('div');
            newTip.classList.add('tip-group', 'grid', 'grid-cols-1', 'gap-4', 'items-center');
            newTip.innerHTML = `
                <div>
                    <label for="travel_tips[${tipIndex}][title]" class="block text-sm font-medium text-gray-700">Tip Title</label>
                    <input type="text" name="travel_tips[${tipIndex}][title]" id="travel_tips[${tipIndex}][title]" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                </div>
                <div>
                    <label for="travel_tips[${tipIndex}][description]" class="block text-sm font-medium text-gray-700">Tip Description</label>
                    <textarea name="travel_tips[${tipIndex}][description]" id="travel_tips[${tipIndex}][description]" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"></textarea>
                </div>
                <div>
                    <label for="travel_tips[${tipIndex}][group_by]" class="block text-sm font-medium text-gray-700">Group By</label>
                    <input type="text" name="travel_tips[${tipIndex}][group_by]" id="travel_tips[${tipIndex}][group_by]" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                </div>
                <button type="button" class="remove-tip inline-flex items-center px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 text-sm">Remove</button>
            `;
            container.appendChild(newTip);
            tipIndex++;
        });

        // Dynamic Gallery Images
        let galleryIndex = 1;
        document.getElementById('add-image').addEventListener('click', function () {
            const container = document.getElementById('gallery-container');
            const newImage = document.createElement('div');
            newImage.classList.add('gallery-group', 'grid', 'grid-cols-1', 'gap-4', 'items-center');
            newImage.innerHTML = `
                <div>
                    <label for="gallery[${galleryIndex}][image]" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="gallery[${galleryIndex}][image]" id="gallery[${galleryIndex}][image]" accept="image/*" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 image-input">
                    <input type="hidden" name="gallery[${galleryIndex}][exists]" value="1">
                    <div class="image-preview mt-2 hidden">
                        <img src="#" alt="Image Preview" class="h-32 w-auto rounded-lg object-cover preview-img">
                    </div>
                </div>
                <div>
                    <label for="gallery[${galleryIndex}][main_page_display]" class="block text-sm font-medium text-gray-700">Display on Main Page</label>
                    <input type="checkbox" name="gallery[${galleryIndex}][main_page_display]" id="gallery[${galleryIndex}][main_page_display]" value="1" class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                </div>
                <button type="button" class="remove-image inline-flex items-center px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 text-sm">Remove</button>
            `;
            container.appendChild(newImage);

            // Add image preview listener
            const input = document.getElementById(`gallery[${galleryIndex}][image]`);
            const previewDiv = newImage.querySelector('.image-preview');
            const previewImg = newImage.querySelector('.preview-img');

            input.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    previewDiv.classList.remove('hidden');
                    previewImg.src = URL.createObjectURL(file);
                } else {
                    previewDiv.classList.add('hidden');
                    previewImg.src = '#';
                }
            });

            galleryIndex++;
        });

        // Remove Handlers and Reindexing
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-activity')) {
                e.target.closest('.activity-group').remove();
            }
            if (e.target.classList.contains('remove-tip')) {
                e.target.closest('.tip-group').remove();
            }
            if (e.target.classList.contains('remove-image')) {
                e.target.closest('.gallery-group').remove();
                // Reindex gallery items
                const galleryGroups = document.querySelectorAll('.gallery-group');
                galleryGroups.forEach((group, index) => {
                    group.querySelector('input[type="file"]').name = `gallery[${index}][image]`;
                    group.querySelector('input[type="hidden"]').name = `gallery[${index}][exists]`;
                    group.querySelector('input[type="checkbox"]').name = `gallery[${index}][main_page_display]`;
                    group.querySelector('input[type="file"]').id = `gallery[${index}][image]`;
                    group.querySelector('input[type="checkbox"]').id = `gallery[${index}][main_page_display]`;
                    group.querySelector('label[for="gallery[${index}][image]"]').setAttribute('for', `gallery[${index}][image]`);
                    group.querySelector('label[for="gallery[${index}][main_page_display]"]').setAttribute('for', `gallery[${index}][main_page_display]`);
                });
                galleryIndex = galleryGroups.length;
            }
        });

        // Image Preview for initial gallery images
        document.querySelectorAll('.gallery-group .image-input').forEach(input => {
            input.addEventListener('change', function (e) {
                const previewDiv = input.parentElement.querySelector('.image-preview');
                const previewImg = input.parentElement.querySelector('.preview-img');
                const file = e.target.files[0];
                if (file) {
                    previewDiv.classList.remove('hidden');
                    previewImg.src = URL.createObjectURL(file);
                } else {
                    previewDiv.classList.add('hidden');
                    previewImg.src = '#';
                }
            });
        });

        // Log form data on submit for debugging
        document.querySelector('form').addEventListener('submit', function(e) {
            console.log('Form data:', new FormData(this));
        });
    </script>
</div>
@endsection