@extends('admin.layout')

@section('title', 'View Contact Inquiry')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-lg shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $contactInquiry->subject }}</h2>
            <p class="text-gray-600 mt-2 text-sm">Inquiry details and response management</p>
        </div>
        <div class="flex gap-3">
            @if ($contactInquiry->status != 'Closed')
                <button onclick="confirmClose({{ $contactInquiry->id }}, '{{ $contactInquiry->subject }}')" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg shadow hover:bg-yellow-700 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Close Inquiry
                </button>
            @endif
            <a href="{{ route('admin.contact-inquiries.index', 2) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export to PDF
            </a>
            <a href="{{ route('admin.contact-inquiries.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to List
            </a>
        </div>
    </div>

    <!-- Inquiry Details - Modern Style -->
    <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-200 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Subject</h3>
                <p class="mt-1 text-base text-gray-800">{{ $contactInquiry->subject }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Name</h3>
                <p class="mt-1 text-base text-gray-800">{{ $contactInquiry->name }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Email</h3>
                <p class="mt-1 text-base text-gray-800">{{ $contactInquiry->email }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Status</h3>
                <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                    {{ $contactInquiry->status === 'open' ? 'bg-yellow-100 text-yellow-800' :
                    ($contactInquiry->status === 'closed' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800') }}">
                    {{ $contactInquiry->status }}
                </span>
            </div>
            <div class="md:col-span-2">
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Message</h3>
                <p class="mt-1 text-base text-gray-800 whitespace-pre-line">{{ $contactInquiry->message }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Created At</h3>
                <p class="mt-1 text-base text-gray-800">{{ $contactInquiry->created_at->format('m-d-Y H:i') }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Responded At</h3>
                <p class="mt-1 text-base text-gray-800">{{ $contactInquiry->updated_at->format('m-d-Y H:i') }}</p>
            </div>
        </div>
    </div>


    <!-- Reply Form -->
    @if ($contactInquiry->status != 'Closed')
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Reply to Inquiry</h3>
            <form method="POST" action="{{ route('admin.contact-inquiries.respond', $contactInquiry) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject', 'RE: ' . $contactInquiry->subject) }}" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter reply subject">
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="reply_message" class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea name="reply_message" id="reply_message" rows="6" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" placeholder="Enter your response...">{{ old('reply_message') }}</textarea>
                        @error('reply_message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700">Attachment (Optional)</label>
                        <input type="file" name="file" id="file" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                        <p class="mt-1 text-sm text-gray-500">Maximum file size: 10MB</p>
                        @error('file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Send Reply
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <!-- Replies History -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Reply History</h3>
        <div class="space-y-4">
            @forelse ($contactInquiry->replies as $reply)
                <div class="border-l-4 border-indigo-500 pl-4 py-2 cursor-pointer hover:bg-gray-50 transition duration-200" onclick="showReplyDetails({{ $reply->id }}, '{{ $reply->subject }}', '{{ $reply->content }}', '{{ $reply->file_path }}', '{{ $reply->replied_by }}', '{{ $reply->created_at->format('m-d-Y H:i') }}')">
                    <div class="text-sm font-medium text-gray-900">{{ $reply->subject }}</div>
                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $reply->content }}</p>
                    @if ($reply->file_path)
                        <p class="text-sm text-gray-600 mt-1">
                            <span class="text-indigo-600">Has Attachment</span>
                        </p>
                    @endif
                    <p class="text-xs text-gray-500 mt-1">Replied by {{ $reply->replied_by }} on {{ $reply->created_at->format('m-d-Y H:i') }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-600">No replies yet for this inquiry.</p>
            @endforelse
        </div>
    </div>

    <!-- Reply Details Modal -->
    <div id="replyDetailsModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl transform transition-all duration-300 scale-95">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-bold text-gray-900" id="modalSubject"></h3>
                <button onclick="closeReplyDetailsModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-700">Content</h4>
                    <p class="mt-1 text-sm text-gray-600 whitespace-pre-line" id="modalContent"></p>
                </div>
                <div id="modalAttachment" class="hidden">
                    <h4 class="text-sm font-medium text-gray-700">Attachment</h4>
                    <a href="#" id="modalAttachmentLink" class="mt-1 text-sm text-indigo-600 hover:underline" target="_blank">View Attachment</a>
                </div>
                <div class="flex justify-between items-center text-sm text-gray-500">
                    <span id="modalRepliedBy"></span>
                    <span id="modalDate"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Close Confirmation Modal -->
    <div id="closeModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md transform transition-all duration-300 scale-95">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mt-4">Close Inquiry</h3>
                <div class="mt-2 px-4 py-3">
                    <p class="text-sm text-gray-600">
                        Are you sure you want to close "<span id="closeItemName" class="font-medium"></span>"? 
                        This action will mark the inquiry as resolved.
                    </p>
                </div>
                <div class="mt-4 flex justify-center gap-3">
                    <form id="closeForm" method="POST" action="#" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition duration-300">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Close
                        </button>
                    </form>
                    <button onclick="closeCloseModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Inline JavaScript for Close Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.confirmClose = function (id, subject) {
                document.getElementById('closeItemName').textContent = subject;
                document.getElementById('closeForm').action = '{{ url('admin/contact-inquiries') }}' + '/' + id + '/close';
                document.getElementById('closeModal').classList.remove('hidden');
                document.getElementById('closeModal').querySelector('.scale-95').classList.add('scale-100');
            };

            window.closeCloseModal = function () {
                const modal = document.getElementById('closeModal');
                modal.querySelector('.scale-100').classList.add('scale-95');
                setTimeout(() => modal.classList.add('hidden'), 200);
            };

            document.getElementById('closeModal').addEventListener('click', function (e) {
                if (e.target === this) {
                    closeCloseModal();
                }
            });
        });
    </script>

    <!-- Inline JavaScript for Reply Details Modal -->
    <script>
        function showReplyDetails(id, subject, content, filePath, repliedBy, date) {
            document.getElementById('modalSubject').textContent = subject;
            document.getElementById('modalContent').textContent = content;
            document.getElementById('modalRepliedBy').textContent = 'Replied by ' + repliedBy;
            document.getElementById('modalDate').textContent = date;

            const attachmentDiv = document.getElementById('modalAttachment');
            const attachmentLink = document.getElementById('modalAttachmentLink');
            
            if (filePath) {
                attachmentDiv.classList.remove('hidden');
                attachmentLink.href = '/storage/' + filePath;
            } else {
                attachmentDiv.classList.add('hidden');
            }

            const modal = document.getElementById('replyDetailsModal');
            modal.classList.remove('hidden');
            modal.querySelector('.scale-95').classList.add('scale-100');
        }

        function closeReplyDetailsModal() {
            const modal = document.getElementById('replyDetailsModal');
            modal.querySelector('.scale-100').classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 200);
        }

        // Close modal when clicking outside
        document.getElementById('replyDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReplyDetailsModal();
            }
        });
    </script>
</div>
@endsection