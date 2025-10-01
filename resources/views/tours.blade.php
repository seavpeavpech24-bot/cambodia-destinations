@extends('layouts.app')

@section('content')
<div class="bg-gray-100">
    <!-- Header -->
    <div class="relative h-96">
        @if($hero && $hero->image_url)
            <img src="{{ asset($hero->image_url) }}" alt="{{ $hero->title }}" class="w-full h-full object-cover">
        @else
            <img src="https://i.pinimg.com/736x/9e/99/59/9e99598e000183c79910463f1d156cf7.jpg" alt="Cambodia Tours" class="w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <h1 class="text-4xl font-bold text-white">{{ $hero->title ?? 'Explore Cambodia' }}</h1>
        </div>
    </div>

    <!-- Ad Space - After Hero -->
    <div class="max-w-7xl mx-auto px-4 py-4">
        <div class="bg-gray-200 h-24 flex items-center justify-center relative">
            <!-- Ad label -->
            <div class="absolute top-2 left-2 bg-black bg-opacity-60 text-white text-xs font-semibold px-2 py-1 rounded">
                Ad
            </div>
            @if($advertisements->isNotEmpty())
                <a href="{{ $advertisements->first()->link ?? '#' }}" target="_blank" class="h-20">
                    @if($advertisements->first()->video_url)
                        <video class="h-20" autoplay muted loop playsinline>
                            <source src="{{ Storage::url($advertisements->first()->video_url) }}" type="video/mp4">
                        </video>
                    @else
                        <img src="{{ Storage::url($advertisements->first()->image_url) }}" alt="Advertisement" class="h-20">
                    @endif
                </a>
            @endif
        </div>
    </div>

    <!-- Tours Content -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid md:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="md:col-span-3">
                <!-- Tour Package 1 -->
                <div class="bg-white rounded-lg shadow-lg mb-8 overflow-hidden">
                    <div class="md:flex">
                        <div class="md:w-1/3">
                            <img src="https://i.pinimg.com/736x/9e/99/59/9e99598e000183c79910463f1d156cf7.jpg" alt="Angkor Discovery" class="w-full h-full object-cover">
                        </div>
                        <div class="md:w-2/3 p-6">
                            <h2 class="text-2xl font-bold mb-2">Angkor Temples Guide</h2>
                            <p class="text-gray-600 mb-4">Complete guide to exploring Angkor Archaeological Park</p>
                            <ul class="mb-4 text-gray-600">
                                <li>✓ Best temples to visit</li>
                                <li>✓ Photography spots</li>
                                <li>✓ Historical insights</li>
                            </ul>
                            <a href="/guides/angkor-temples" class="inline-block bg-yellow-500 text-white px-6 py-2 rounded-full hover:bg-yellow-600">Read More</a>
                        </div>
                    </div>
                </div>

                <!-- Inline Ad -->
                <div class="bg-gray-200 h-32 mb-8 flex items-center justify-center relative">
                    <!-- Ad label -->
                    <div class="absolute top-2 left-2 bg-black bg-opacity-60 text-white text-xs font-semibold px-2 py-1 rounded">
                        Ad
                    </div>
                    @if($advertisements->count() > 1)
                        <a href="{{ $advertisements[1]->link ?? '#' }}" target="_blank" class="w-full h-full">
                            @if($advertisements[1]->video_url)
                                <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                    <source src="{{ Storage::url($advertisements[1]->video_url) }}" type="video/mp4">
                                </video>
                            @else
                                <img src="{{ Storage::url($advertisements[1]->image_url) }}" 
                                     alt="Advertisement" 
                                     class="w-full h-full object-cover">
                            @endif
                        </a>
                    @endif
                </div>

                <!-- Tour Package 2 -->
                <div class="bg-white rounded-lg shadow-lg mb-8 overflow-hidden">
                    <div class="md:flex">
                        <div class="md:w-1/3">
                            <img src="https://i.pinimg.com/736x/40/3f/2b/403f2b1fd9d5adae1365b0c2d2446fb8.jpg" alt="Beach Paradise" class="w-full h-full object-cover">
                        </div>
                        <div class="md:w-2/3 p-6">
                            <h2 class="text-2xl font-bold mb-2">Coastal Cambodia Guide</h2>
                            <p class="text-gray-600 mb-4">Discover Cambodia's beautiful beaches and islands</p>
                            <ul class="mb-4 text-gray-600">
                                <li>✓ Best beaches</li>
                                <li>✓ Island hopping tips</li>
                                <li>✓ Local food recommendations</li>
                            </ul>
                            <a href="/guides/coastal-cambodia" class="inline-block bg-yellow-500 text-white px-6 py-2 rounded-full hover:bg-yellow-600">Read More</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Sidebar Ad 1 -->
                <div class="bg-white rounded-lg shadow-lg p-4">
                    <div class="bg-gray-200 h-96 flex items-center justify-center relative overflow-hidden rounded-md">
                        <!-- Ad label -->
                        <div class="absolute top-2 left-2 bg-black bg-opacity-60 text-white text-xs font-semibold px-2 py-1 rounded">
                            Ad
                        </div>
                        @if($advertisements->count() > 2)
                            <a href="{{ $advertisements[2]->link ?? '#' }}" target="_blank" class="w-full h-full">
                                @if($advertisements[2]->video_url)
                                    <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                        <source src="{{ Storage::url($advertisements[2]->video_url) }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ Storage::url($advertisements[2]->image_url) }}" 
                                         alt="Advertisement" 
                                         class="w-full h-full object-cover">
                                @endif
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Featured Content -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Travel Resources</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li>📅 Best time to visit</li>
                        <li>🎫 Entry requirements</li>
                        <li>💰 Budget planning</li>
                    </ul>
                </div>

                <!-- Sidebar Ad 2 -->
                <div class="bg-white rounded-lg shadow-lg p-4">
                    <div class="bg-gray-200 h-64 flex items-center justify-center relative overflow-hidden rounded-md">
                        <!-- Ad label -->
                        <div class="absolute top-2 left-2 bg-black bg-opacity-60 text-white text-xs font-semibold px-2 py-1 rounded">
                            Ad
                        </div>
                        @if($advertisements->count() > 3)
                            <a href="{{ $advertisements[3]->link ?? '#' }}" target="_blank" class="w-full h-full">
                                @if($advertisements[3]->video_url)
                                    <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                        <source src="{{ Storage::url($advertisements[3]->video_url) }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ Storage::url($advertisements[3]->image_url) }}" 
                                         alt="Advertisement" 
                                         class="w-full h-full object-cover">
                                @endif
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 