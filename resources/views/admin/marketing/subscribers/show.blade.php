@extends('admin.layout')

@section('title', 'Subscriber Details')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Subscriber Details</h2>
            <p class="text-gray-600 mt-2 text-sm">View and manage subscriber information</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.subscribers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to List
            </a>
            @if($subscriber->status === 'subscribed')
                <button onclick="confirmUnsubscribe({{ $subscriber->id }}, '{{ $subscriber->email }}')" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a1 1 0 011 1v1H9V4a1 1 0 011-1zm-7 4h18"></path>
                    </svg>
                    Unsubscribe
                </button>
            @else
                <form action="{{ route('admin.subscribers.resubscribe', $subscriber) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Resubscribe
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Subscriber Details -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 space-y-6">
            <!-- Email -->
            <div>
                <h3 class="text-sm font-medium text-gray-500">Email Address</h3>
                <p class="mt-1 text-lg text-gray-900">{{ $subscriber->email }}</p>
            </div>

            <!-- Status -->
            <div>
                <h3 class="text-sm font-medium text-gray-500">Status</h3>
                <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium {{ $subscriber->status === 'subscribed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($subscriber->status) }}
                </span>
            </div>

            <!-- Subscription Dates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Subscribed At</h3>
                    <p class="mt-1 text-gray-900">{{ $subscriber->subscribed_at?->format('F j, Y g:i A') ?? 'N/A' }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Unsubscribed At</h3>
                    <p class="mt-1 text-gray-900">{{ $subscriber->unsubscribed_at?->format('F j, Y g:i A') ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Additional Information -->
            <div>
                <h3 class="text-sm font-medium text-gray-500">Additional Information</h3>
                <div class="mt-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Created At</p>
                        <p class="mt-1 text-gray-900">{{ $subscriber->created_at?->format('F j, Y g:i A') ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Last Updated</p>
                        <p class="mt-1 text-gray-900">{{ $subscriber->updated_at?->format('F j, Y g:i A') ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Unsubscribe Confirmation Modal -->
    <div id="unsubscribeModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-6 w-full max-w-md transform transition-all duration-300 scale-95">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mt-4">Unsubscribe Subscriber</h3>
                <div class="mt-2 px-4 py-3">
                    <p class="text-sm text-gray-600">
                        Are you sure you want to unsubscribe "<span id="unsubscribeItemName" class="font-medium"></span>"? 
                        This action will mark the subscriber as unsubscribed.
                    </p>
                </div>
                <div class="mt-4 flex justify-center gap-3">
                    <form id="unsubscribeForm" method="POST" action="" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="unsubscribed">
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a1 1 0 011 1v1H9V4a1 1 0 011-1zm-7 4h18"></path>
                            </svg>
                            Unsubscribe
                        </button>
                    </form>
                    <button onclick="closeUnsubscribeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Inline JavaScript for Unsubscribe Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.confirmUnsubscribe = function (id, email) {
                document.getElementById('unsubscribeItemName').textContent = email;
                document.getElementById('unsubscribeForm').action = `/admin/subscribers/${id}/unsubscribe`;
                document.getElementById('unsubscribeModal').classList.remove('hidden');
                document.getElementById('unsubscribeModal').querySelector('.scale-95').classList.add('scale-100');
            };

            window.closeUnsubscribeModal = function () {
                const modal = document.getElementById('unsubscribeModal');
                modal.querySelector('.scale-100').classList.add('scale-95');
                setTimeout(() => modal.classList.add('hidden'), 200);
            };

            document.getElementById('unsubscribeModal').addEventListener('click', function (e) {
                if (e.target === this) {
                    closeUnsubscribeModal();
                }
            });
        });
    </script>
</div>
@endsection