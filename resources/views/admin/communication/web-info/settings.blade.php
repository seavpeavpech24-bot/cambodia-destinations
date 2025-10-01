@extends('admin.layout')

@section('title', 'Website Information Settings')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-lg shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Website Information Settings</h2>
            <p class="text-gray-600 mt-2 text-sm">Manage site-wide information, contact details, and branding assets</p>
        </div>
    </div>

    @if (session('success') || session('error'))
        <div id="toast-alert" 
            class="px-4 py-3 rounded relative border max-w-lg mx-auto mt-4
                {{ session('success') ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700' }}" 
            role="alert">
            <strong class="font-bold">
                {{ session('success') ? 'Success!' : 'Error!' }}
            </strong>
            <span class="block sm:inline">
                {{ session('success') ?? session('error') }}
            </span>
        </div>

        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast-alert');
                if (toast) toast.style.display = 'none';
            }, 3000);
        </script>
    @endif

    <!-- Settings Form -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <form method="POST" action="{{ route('admin.web-info.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-8">
                <!-- General Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">General Information</h3>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Website Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $webInfo->title) }}" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter website title">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            {{-- The provided schema does not have a 'tagline' column. Omitting this field. --}}
                            @error('tagline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Branding Assets -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Branding Assets</h3>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                            <input type="file" name="logo" id="logo" accept="image/*" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                            <!-- Logo Preview -->
                            <div id="logo-preview" class="mt-2">
                                @if ($webInfo->logo_url)
                                    <img src="{{ asset($webInfo->logo_url) }}" alt="Logo Preview" class="h-20 w-auto rounded border border-gray-200">
                                @else
                                    <p class="text-sm text-gray-600">No logo URL provided</p>
                                @endif
                            </div>
                            @error('logo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="favicon" class="block text-sm font-medium text-gray-700">Favicon</label>
                            <input type="file" name="favicon" id="favicon" accept="image/*" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                            <!-- Favicon Preview -->
                            <div id="favicon-preview" class="mt-2">
                                @if ($webInfo->favicon_url)
                                    <img src="{{ asset($webInfo->favicon_url) }}" alt="Favicon Preview" class="h-10 w-10 rounded border border-gray-200">
                                @else
                                    <p class="text-sm text-gray-600">No favicon URL provided</p>
                                @endif
                            </div>
                            @error('favicon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $webInfo->phone_number) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter phone number">
                            @error('phone_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $webInfo->email) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter email address">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $webInfo->location) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter location or address">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Social Media Links</h3>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="facebook_link" class="block text-sm font-medium text-gray-700">Facebook</label>
                            <input type="url" name="facebook_link" id="facebook_link" value="{{ old('facebook_link', $webInfo->facebook_link) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter Facebook URL">
                            @error('facebook_link')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="youtube_link" class="block text-sm font-medium text-gray-700">YouTube</label>
                            <input type="url" name="youtube_link" id="youtube_link" value="{{ old('youtube_link', $webInfo->youtube_link) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter YouTube URL">
                            @error('youtube_link')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="instagram_link" class="block text-sm font-medium text-gray-700">Instagram</label>
                            <input type="url" name="instagram_link" id="instagram_link" value="{{ old('instagram_link', $webInfo->instagram_link) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter Instagram URL">
                            @error('instagram_link')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            {{-- The provided schema does not have a 'twitter_url' column. Omitting this field. --}}
                            @error('twitter_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            {{-- The provided schema does not have a 'linkedin_url' column. Omitting this field. --}}
                            @error('linkedin_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            {{-- The provided schema does not have a 'google_map_link' column. Omitting this field. --}}
                            @error('google_map_link')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v6a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-6 0h6m-6 0V5a2 2 0 012-2h2a2 2 0 012 2v2"></path>
                        </svg>
                        Save Changes
                    </button>
                    <button type="reset" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                        Reset
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Inline JavaScript for Image Previews -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Logo Preview
        const logoInput = document.getElementById('logo');
        const logoPreview = document.getElementById('logo-preview');
        const faviconInput = document.getElementById('favicon');
        const faviconPreview = document.getElementById('favicon-preview');

        function previewImage(input, previewElement, defaultText) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewElement.innerHTML = `<img src="${e.target.result}" alt="Preview" class="h-20 w-auto rounded border border-gray-200">`;
                };
                reader.readAsDataURL(file);
            } else {
                previewElement.innerHTML = `<p class="text-sm text-gray-600">${defaultText}</p>`;
            }
        }

        logoInput.addEventListener('change', function () {
            previewImage(this, logoPreview, 'No logo uploaded');
        });

        faviconInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    faviconPreview.innerHTML = `<img src="${e.target.result}" alt="Favicon Preview" class="h-10 w-10 rounded border border-gray-200">`;
                };
                reader.readAsDataURL(file);
            } else {
                faviconPreview.innerHTML = `<p class="text-sm text-gray-600">No favicon uploaded</p>`;
            }
        });
    });
</script>
@endsection