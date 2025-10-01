@extends('admin.layout')

@section('title', 'View Map Location')

@section('content')
<div class="py-16">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Map Location Details</h2>
            <a href="{{ route('admin.map-coordinators.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Back to List
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">Cover Image</h3>
                    @if($mapCoordinator->cover_url)
                        <img src="{{ $mapCoordinator->cover_url }}" alt="{{ $mapCoordinator->title }}" class="w-full h-64 object-cover rounded-lg">
                    @else
                        <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-500">No image available</span>
                        </div>
                    @endif
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Location Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Title</label>
                            <p class="mt-1 text-gray-900">{{ $mapCoordinator->title }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Type</label>
                            <p class="mt-1 text-gray-900">{{ $mapCoordinator->type }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Destination</label>
                            <p class="mt-1 text-gray-900">{{ $mapCoordinator->destination ? $mapCoordinator->destination->title : 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Icon Class</label>
                            <p class="mt-1 text-gray-900">{{ $mapCoordinator->icon_class }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Coordinates</label>
                            <p class="mt-1 text-gray-900">{{ $mapCoordinator->latitude_and_longitude }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Map Link</label>
                            <a href="{{ $mapCoordinator->map_link }}" target="_blank" class="mt-1 text-blue-600 hover:text-blue-800">
                                {{ $mapCoordinator->map_link }}
                            </a>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Description</label>
                            <p class="mt-1 text-gray-900">{{ $mapCoordinator->description }}</p>
                        </div>
                    </div>
                </div>                
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-4">Location on Map</h3>
            <div id="map" class="h-96 w-full rounded-lg"></div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Parse coordinates from the string
    const coordinates = "{{ $mapCoordinator->latitude_and_longitude }}".split(',').map(coord => parseFloat(coord.trim()));
    
    // Initialize the map
    const map = L.map('map').setView(coordinates, 13);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Create custom icon
    const customIcon = L.divIcon({
        html: `<i class="{{ $mapCoordinator->icon_class }}" style="color: #D32F2F; font-size: 24px;"></i>`,
        iconSize: [24, 24],
        className: 'custom-icon'
    });

    // Add marker with popup
    const marker = L.marker(coordinates, { icon: customIcon }).addTo(map);
    
    // Create popup content
    let popupContent = `
        <div class="p-2">
            <h3 class="font-bold text-lg mb-2">{{ $mapCoordinator->title }}</h3>
            @if($mapCoordinator->cover_url)
                <img src="{{ $mapCoordinator->cover_url }}" alt="{{ $mapCoordinator->title }}" class="w-full h-32 object-cover rounded-lg mb-2">
            @endif
            <p class="text-sm mb-2">{{ $mapCoordinator->description }}</p>
            @if($mapCoordinator->map_link)
                <a href="{{ $mapCoordinator->map_link }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">View on Google Maps</a>
            @endif
        </div>
    `;
    
    marker.bindPopup(popupContent);
});
</script>

<style>
    .custom-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .leaflet-popup-content {
        margin: 0;
    }
    .leaflet-popup-content img {
        margin-bottom: 8px;
    }
</style>
@endsection 