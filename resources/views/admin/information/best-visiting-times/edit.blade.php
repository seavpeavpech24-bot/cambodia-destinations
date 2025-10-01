@extends('admin.layout')

@section('title', 'Edit Best Visiting Time')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Best Visiting Time</h2>
            <p class="text-gray-600 mt-2 text-sm">Update the recommendation details</p>
        </div>
        <a href="{{ route('admin.best-visiting-times.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.best-visiting-times.update', $bestVisitingTime) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Content Field -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="4" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('content') border-red-500 @enderror"
                    placeholder="Enter the recommendation content..."
                >{{ old('content', $bestVisitingTime->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Season Field -->
            <div>
                <label for="group_by" class="block text-sm font-medium text-gray-700 mb-2">Season</label>
                <select 
                    name="group_by" 
                    id="group_by" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 @error('group_by') border-red-500 @enderror"
                >
                    <option value="">Select a season</option>
                    @foreach(App\Models\BestVisitingTime::GROUP_BY_OPTIONS as $key => $value)
                        <option value="{{ $key }}" {{ old('group_by', $bestVisitingTime->group_by) == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
                @error('group_by')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-300 ease-in-out transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Recommendation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection