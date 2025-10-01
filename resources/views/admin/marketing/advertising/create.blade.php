@extends('admin.layout')

@section('title', 'Add New Advertisement')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Add New Advertisement</h2>
            <p class="text-gray-600 mt-2 text-sm">Enter details for a new advertisement</p>
        </div>
        <a href="{{ route('admin.advertising.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to List
        </a>
    </div>

    <!-- Create Form -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <!-- Ad Preview -->
        <div id="ad_preview" class="hidden space-y-6">
            <div id="image_ad_preview" class="hidden aspect-w-16 aspect-h-9">
                <img id="ad_preview_img" src="" alt="Ad Preview" class="w-full h-96 object-cover rounded-lg">
            </div>
            <div id="video_ad_preview" class="hidden aspect-w-16 aspect-h-9">
                <video id="ad_preview_video" controls class="w-full h-96 rounded-lg">
                    <source id="ad_preview_video_source" src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.advertising.store') }}" enctype="multipart/form-data" id="advertisementForm">
            @csrf
            <div class="space-y-6 mt-6">
                <!-- Media Type Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Media Type</label>
                    <div class="mt-1 flex gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="media_type" value="image" checked class="form-radio text-indigo-600" onchange="toggleMediaInputs()">
                            <span class="ml-2 text-sm text-gray-600">Image</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="media_type" value="video" class="form-radio text-indigo-600" onchange="toggleMediaInputs()">
                            <span class="ml-2 text-sm text-gray-600">Video</span>
                        </label>
                    </div>
                </div>

                <!-- Image Upload -->
                <div id="image_input" class="block">
                    <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                    <div class="mt-1">
                        <input type="file" name="image" id="image" accept="image/*" class="hidden" onchange="handleImageUpload(this)">
                        <label for="image" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Choose Image
                        </label>
                        <progress id="image_progress" value="0" max="100" class="w-full mt-2 hidden h-2 rounded-lg"></progress>
                        <span id="image_progress_text" class="text-sm text-gray-600 hidden mt-1">0%</span>
                        <button type="button" onclick="removeImage()" class="mt-2 text-sm text-red-600 hover:text-red-800 hidden" id="image_remove_button">Remove</button>
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Video Upload -->
                <div id="video_input" class="hidden">
                    <label for="video" class="block text-sm font-medium text-gray-700">Upload Video</label>
                    <div class="mt-1">
                        <input type="file" name="video" id="video" accept="video/mp4,video/mov,video/avi" class="hidden" onchange="handleVideoUpload(this)">
                        <label for="video" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Choose Video
                        </label>
                        <p class="mt-1 text-sm text-gray-500">Supported formats: MP4, MOV, AVI. Max size: 50MB</p>
                        <progress id="video_progress" value="0" max="100" class="w-full mt-2 hidden h-2 rounded-lg"></progress>
                        <span id="video_progress_text" class="text-sm text-gray-600 hidden mt-1">0%</span>
                        <button type="button" onclick="removeVideo()" class="mt-2 text-sm text-red-600 hover:text-red-800 hidden" id="video_remove_button">Remove</button>
                        <div id="video_error" class="mt-1 text-sm text-red-600 hidden"></div>
                    </div>
                    @error('video')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Other Form Fields -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter ad title...">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter ad description...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="link" class="block text-sm font-medium text-gray-700">Link (Optional)</label>
                    <input type="url" name="link" id="link" value="{{ old('link') }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter ad link (e.g., https://example.com)">
                    @error('link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="expire_date" class="block text-sm font-medium text-gray-700">Expire Date</label>
                    <input type="date" name="expire_date" id="expire_date" value="{{ old('expire_date') }}" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                    @error('expire_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Visibility</label>
                    <div class="mt-1 flex gap-4">
                        <input type="hidden" name="is_visible" value="0">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_visible" value="1" 
                                @if(old('is_visible', 1)) checked @endif
                                class="form-checkbox text-indigo-600">
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
                        Save Advertisement
                    </button>
                    <a href="{{ route('admin.advertising.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Inline JavaScript for Media Handling -->
    <script>
        let uploadTimeout;
        const UPLOAD_DELAY = 500; // 500ms debounce delay

        function toggleMediaInputs() {
            const imageInput = document.getElementById('image_input');
            const videoInput = document.getElementById('video_input');
            const imageAdPreview = document.getElementById('image_ad_preview');
            const videoAdPreview = document.getElementById('video_ad_preview');
            const adPreview = document.getElementById('ad_preview');
            const mediaType = document.querySelector('input[name="media_type"]:checked').value;

            if (mediaType === 'image') {
                imageInput.classList.remove('hidden');
                videoInput.classList.add('hidden');
                videoAdPreview.classList.add('hidden');
                document.getElementById('video').value = '';
                document.getElementById('video_progress').classList.add('hidden');
                document.getElementById('video_progress_text').classList.add('hidden');
                document.getElementById('video_remove_button').classList.add('hidden');
            } else {
                videoInput.classList.remove('hidden');
                imageInput.classList.add('hidden');
                imageAdPreview.classList.add('hidden');
                document.getElementById('image').value = '';
                document.getElementById('image_progress').classList.add('hidden');
                document.getElementById('image_progress_text').classList.add('hidden');
                document.getElementById('image_remove_button').classList.add('hidden');
            }
            // Hide ad preview if no file is selected
            if (!document.getElementById('image').files[0] && !document.getElementById('video').files[0]) {
                adPreview.classList.add('hidden');
            }
        }

        function handleImageUpload(input) {
            clearTimeout(uploadTimeout);
            uploadTimeout = setTimeout(() => {
                const file = input.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const adPreview = document.getElementById('ad_preview');
                        const adPreviewImg = document.getElementById('ad_preview_img');
                        adPreviewImg.src = e.target.result;
                        document.getElementById('image_ad_preview').classList.remove('hidden');
                        document.getElementById('video_ad_preview').classList.add('hidden');
                        adPreview.classList.remove('hidden');
                        document.getElementById('image_progress').classList.add('hidden');
                        document.getElementById('image_progress_text').classList.add('hidden');
                        document.getElementById('image_remove_button').classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);

                    // Simulate progress
                    const progressBar = document.getElementById('image_progress');
                    const progressText = document.getElementById('image_progress_text');
                    progressBar.classList.remove('hidden');
                    progressText.classList.remove('hidden');
                    let progress = 0;
                    const interval = setInterval(() => {
                        progress += 10;
                        progressBar.value = progress;
                        progressText.textContent = `${progress}%`;
                        if (progress >= 100) {
                            clearInterval(interval);
                            progressBar.classList.add('hidden');
                            progressText.classList.add('hidden');
                        }
                    }, 100);
                }
            }, UPLOAD_DELAY);
        }

        function handleVideoUpload(input) {
            clearTimeout(uploadTimeout);
            uploadTimeout = setTimeout(() => {
                const file = input.files[0];
                const videoError = document.getElementById('video_error');
                videoError.classList.add('hidden');
                
                if (file) {
                    // Validate file size (50MB)
                    if (file.size > 51200000) {
                        videoError.textContent = 'Video file size must be less than 50MB';
                        videoError.classList.remove('hidden');
                        input.value = '';
                        return;
                    }

                    // Validate file type
                    const validTypes = ['video/mp4', 'video/mov', 'video/avi'];
                    if (!validTypes.includes(file.type)) {
                        videoError.textContent = 'Invalid video format. Please use MP4, MOV, or AVI';
                        videoError.classList.remove('hidden');
                        input.value = '';
                        return;
                    }

                    const adPreview = document.getElementById('ad_preview');
                    const adPreviewVideoSource = document.getElementById('ad_preview_video_source');
                    const adPreviewVideo = document.getElementById('ad_preview_video');
                    const url = URL.createObjectURL(file);
                    adPreviewVideoSource.src = url;
                    adPreviewVideo.load();
                    document.getElementById('video_ad_preview').classList.remove('hidden');
                    document.getElementById('image_ad_preview').classList.add('hidden');
                    adPreview.classList.remove('hidden');
                    document.getElementById('video_progress').classList.add('hidden');
                    document.getElementById('video_progress_text').classList.add('hidden');
                    document.getElementById('video_remove_button').classList.remove('hidden');
                }
            }, UPLOAD_DELAY);
        }

        function removeImage() {
            const input = document.getElementById('image');
            const adPreview = document.getElementById('ad_preview');
            const progressBar = document.getElementById('image_progress');
            const progressText = document.getElementById('image_progress_text');
            const removeButton = document.getElementById('image_remove_button');
            input.value = '';
            adPreview.classList.add('hidden');
            progressBar.classList.add('hidden');
            progressText.classList.add('hidden');
            progressBar.value = 0;
            progressText.textContent = '0%';
            removeButton.classList.add('hidden');
        }

        function removeVideo() {
            const videoInput = document.getElementById('video');
            const videoPreview = document.getElementById('video_ad_preview');
            const adPreview = document.getElementById('ad_preview');
            const videoError = document.getElementById('video_error');
            
            videoInput.value = '';
            videoPreview.classList.add('hidden');
            adPreview.classList.add('hidden');
            document.getElementById('video_progress').classList.add('hidden');
            document.getElementById('video_progress_text').classList.add('hidden');
            document.getElementById('video_remove_button').classList.add('hidden');
            videoError.classList.add('hidden');
        }

        // Form submission with progress tracking
        document.getElementById('advertisementForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const mediaType = document.querySelector('input[name="media_type"]:checked').value;
            const imageInput = document.getElementById('image');
            const videoInput = document.getElementById('video');

            if (mediaType === 'image' && !imageInput.files[0]) {
                alert('Please select an image file');
                return;
            } else if (mediaType === 'video' && !videoInput.files[0]) {
                alert('Please select a video file');
                return;
            }

            const form = this;
            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();
            const progressBar = mediaType === 'image' ? document.getElementById('image_progress') : document.getElementById('video_progress');
            const progressText = mediaType === 'image' ? document.getElementById('image_progress_text') : document.getElementById('video_progress_text');

            progressBar.classList.remove('hidden');
            progressText.classList.remove('hidden');

            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = Math.round((e.loaded / e.total) * 100);
                    progressBar.value = percentComplete;
                    progressText.textContent = `${percentComplete}%`;
                }
            });

            xhr.addEventListener('load', function() {
                progressBar.classList.add('hidden');
                progressText.classList.add('hidden');
                if (xhr.status === 200) {
                    window.location.href = '{{ route('admin.advertising.index') }}';
                } else {
                    alert('An error occurred during upload. Please try again.');
                }
            });

            xhr.addEventListener('error', function() {
                progressBar.classList.add('hidden');
                progressText.classList.add('hidden');
                alert('An error occurred during upload. Please try again.');
            });

            xhr.open('POST', form.action);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('input[name="_token"]').value);
            xhr.send(formData);
        });
    </script>
</div>
@endsection