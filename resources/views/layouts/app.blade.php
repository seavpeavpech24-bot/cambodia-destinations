<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @php
    $webInfo = \App\Models\WebInfo::first();
  @endphp
  <link rel="icon" type="image/png" href="{{ $webInfo->favicon_url ?? '/assets/images/logo.png' }}">
  <title>{{ $webInfo->title ?? 'Cambodia Wonderland' }} - @yield('title', 'Home')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <style>
    html{
            scroll-behavior: smooth;
        }
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
        }
        .popup-content {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;            border-radius: 10px;
            max-width: 90%;
            width: 500px;
            z-index: 1001;
        }
        .close-button {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #ff4444;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: bold;
        }
        .countdown {
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
  </style>
</head>
<body class="bg-gray-100">
    <div id="app">
        @include('layouts.navigation')

        <main>
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>
</body>
</html> 