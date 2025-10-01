@extends('admin.layout')

@section('title', 'Import Subscribers')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Import Subscribers</h2>
            <p class="text-gray-600 mt-2 text-sm">Upload a CSV file to add multiple subscribers</p>
        </div>
        <a href="{{ route('admin.subscribers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to List
        </a>
    </div>

    <!-- Import Form -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <form method="POST" action="{{ route('admin.subscribers.store-import') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="csv_file" class="block text-sm font-medium text-gray-700">Upload CSV File</label>
                    <input type="file" name="csv_file" id="csv_file" accept=".csv" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                    <p class="mt-2 text-sm text-gray-600">The CSV file should have an 'email' column. Optionally include a 'status' column ('subscribed' or 'unsubscribed').</p>
                    @error('csv_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sample CSV Format -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Sample CSV Format:</h3>
                    <div class="bg-white p-3 rounded border border-gray-200">
                        <pre class="text-sm text-gray-600">email,status
john@example.com,subscribed
jane@example.com,unsubscribed</pre>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Import Subscribers
                    </button>
                    <a href="{{ route('admin.subscribers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection