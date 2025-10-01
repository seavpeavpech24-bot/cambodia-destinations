@extends('admin.layout')

@section('content')
<div class="min-h-screen flex items-center justify-center relative">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('assets/images/404.png') }}" alt="404 Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 text-center text-white px-4">
        <h1 class="text-9xl font-bold mb-4">404</h1>
        <h2 class="text-4xl font-semibold mb-6">Page Not Found</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ url()->previous() }}" class="bg-indigo-600 text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-indigo-700 transition duration-300">
                Go Back
            </a>
            <a href="{{ route('admin.dashboard') }}" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-white/20 transition duration-300">
                Go to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection 