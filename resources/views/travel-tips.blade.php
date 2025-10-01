@extends('layouts.app')

@section('content')
<div class="bg-gray-100">
    <!-- Header -->
    <div class="relative h-96">
        <img src="{{ $hero ? $hero->image_url : 'https://i.pinimg.com/736x/2a/1a/54/2a1a5458dc6d52fbba16190743969400.jpg' }}" alt="Cambodia Travel Tips" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <h1 class="text-4xl font-bold text-white">{{ $hero ? $hero->title : 'Essential Travel Tips' }}</h1>
        </div>
    </div>

    <!-- Ad Space - Top -->
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

    <!-- Tips Content -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid md:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="md:col-span-3">
                <!-- Best Time to Visit -->
                <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold mb-6">Best Time to Visit</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach($bestVisitingTimes as $group => $times)
                            <div>
                                <h3 class="text-xl font-semibold mb-3">{{ ucfirst($group) }}</h3>
                                <div class="space-y-4">
                                    @foreach($times as $time)
                                        <div class="prose max-w-none"> ✓
                                            {!! $time->content !!}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Cultural Etiquette -->
                <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold mb-6">Cultural Etiquette</h2>
                    <div class="grid gap-6">
                        @foreach($cultureEtiquette as $tip)
                            <div class="flex items-start space-x-4">
                                <div class="bg-yellow-100 p-3 rounded-full">
                                    <i class="{{ $tip->icon_class }} text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold mb-2">{{ $tip->title }}</h3>
                                    <p class="text-gray-600">{{ $tip->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Transportation Tips -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold mb-6">Getting Around</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach($gettingAround as $group => $tips)
                            <div class="border-l-4 border-yellow-500 pl-4">
                                <h3 class="text-xl font-semibold mb-3">{{ ucfirst($group) }}</h3>
                                <div class="space-y-4">
                                    @foreach($tips as $tip)
                                        <div class="prose max-w-none">
                                            {!! $tip->content !!}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Ad Space -->
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

                <!-- Quick Tips -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Essential Tips</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li>💧 Drink bottled water</li>
                        <li>🌞 Use sun protection</li>
                        <li>💊 Carry basic medicines</li>
                        <li>📱 Get travel insurance</li>
                        <li>💵 Carry US dollars</li>
                    </ul>
                </div>

                <!-- Bottom Ad Space -->
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