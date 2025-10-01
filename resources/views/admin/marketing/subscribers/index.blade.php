@extends('admin.layout')

@section('title', 'Subscribers Management')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Subscribers</h2>
            <p class="text-gray-600 mt-2 text-sm">Manage subscriber list and status</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.subscribers.import') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-300 ease-in-out transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                Import Subscribers
            </a>
            <a href="{{ route('admin.subscribers.export') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition duration-300 ease-in-out transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Export to CSV
            </a>
        </div>
    </div>

    <!-- Search Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <form method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search subscribers by email..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </button>
                <a href="{{ route('admin.subscribers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Subscribers List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Subscribed At</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Unsubscribed At</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($subscribers as $subscriber)
                        <tr class="hover:bg-indigo-50 transition duration-200">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $subscriber->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-1 text-sm font-medium rounded {{ $subscriber->status === 'subscribed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($subscriber->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <div class="text-sm text-gray-600">{{ $subscriber->subscribed_at?->format('m-d-Y H:i') ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <div class="text-sm text-gray-600">{{ $subscriber->unsubscribed_at?->format('m-d-Y H:i') ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.subscribers.show', $subscriber) }}" class="text-blue-600 hover:text-blue-800 transition duration-200" title="View">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    @if($subscriber->status === 'subscribed')
                                        <button onclick="confirmUnsubscribe({{ $subscriber->id }}, '{{ $subscriber->email }}')" class="text-red-600 hover:text-red-800 transition duration-200" title="Unsubscribe">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a1 1 0 011 1v1H9V4a1 1 0 011-1zm-7 4h18"></path>
                                            </svg>
                                        </button>
                                    @else
                                        <form action="{{ route('admin.subscribers.resubscribe', $subscriber) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 hover:text-green-800 transition duration-200" title="Resubscribe">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No subscribers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6">
            {{ $subscribers->links() }}
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