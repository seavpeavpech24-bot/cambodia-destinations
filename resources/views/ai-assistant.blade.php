@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-yellow-500 to-yellow-600 py-16">
        <div class="container mx-auto px-6">
            <div class="text-center text-white">
                <h1 class="text-4xl font-bold mb-4">Cambodia Travel AI Assistant</h1>
                <p class="text-xl mb-8">Ask me anything about traveling in Cambodia - from destinations to planning your perfect trip!</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Chat Container -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col" style="height: 600px;">
                <!-- Chat Messages -->
                <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4">
                    <!-- Welcome Message -->
                    <div class="flex items-start space-x-3">
                        <!-- AI Profile Picture -->
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-yellow-500">
                                <img src="/images/ai-avatar.png" 
                                     alt="Cambodia Travel AI" 
                                     class="w-full h-full object-cover"
                                     onerror="this.src='https://ui-avatars.com/api/?name=AI&background=FFB800&color=fff'">
                            </div>
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="font-semibold text-yellow-600">Cambodia Travel AI</span>
                                <span class="px-2 py-0.5 text-xs bg-yellow-100 text-yellow-800 rounded-full">Tour Guide</span>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <p class="text-gray-700">Hello! I'm your AI travel guide for Cambodia. I can help you with:</p>
                                <ul class="list-disc list-inside mt-2 text-gray-600">
                                    <li>Travel planning and itineraries</li>
                                    <li>Destination recommendations</li>
                                    <li>Local customs and culture</li>
                                    <li>Transportation options</li>
                                    <li>And much more!</li>
                                </ul>
                                <p class="mt-2 text-gray-700">How can I assist you today?</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Input Form -->
                <form id="chat-form" class="border-t border-gray-200 p-4 bg-white">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <input type="text" 
                                   id="message" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                                   placeholder="Ask me anything about Cambodia..."
                                   required>
                        </div>
                        <button type="submit" 
                                class="px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200 flex items-center space-x-2">
                            <span>Send</span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Features Section -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-yellow-500 text-3xl mb-4">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Destination Guide</h3>
                    <p class="text-gray-600">Get detailed information about popular destinations, hidden gems, and local attractions.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-yellow-500 text-3xl mb-4">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Travel Planning</h3>
                    <p class="text-gray-600">Plan your perfect itinerary with personalized recommendations and timing suggestions.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-yellow-500 text-3xl mb-4">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Local Insights</h3>
                    <p class="text-gray-600">Learn about local customs, transportation, accommodation, and practical travel tips.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chat Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('chat-form');
    const userInput = document.getElementById('message');
    const chatMessages = document.getElementById('chat-messages');

    let conversationContext = [];
    let languagePreference = 'en';

    function formatMessage(message) {
        if (!message) return '';
        
        // Replace markdown-style formatting with HTML
        return message
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>') // Bold
            .replace(/\*(.*?)\*/g, '<em>$1</em>') // Italic
            .replace(/- (.*?)(?:\n|$)/g, '<li>$1</li>') // List items
            .replace(/\n\n/g, '<br><br>') // Double newlines
            .replace(/\n/g, '<br>'); // Single newlines
    }

    function addMessage(message, type, destinations = []) {
        if (!message) return;
        
        const messageDiv = document.createElement('div');
        messageDiv.className = 'flex items-start space-x-4';
        
        const iconDiv = document.createElement('div');
        iconDiv.className = 'flex-shrink-0';
        
        if (type === 'user') {
            const icon = document.createElement('div');
            icon.className = 'relative w-12 h-12';
            icon.innerHTML = `
                <div class="absolute inset-0 rounded-full overflow-hidden border-2 border-gray-500">
                    <img src="https://i.pinimg.com/736x/cd/4b/d9/cd4bd9b0ea2807611ba3a67c331bff0b.jpg" 
                         alt="User" 
                         class="w-full h-full object-cover"
                         onerror="this.src='https://i.pinimg.com/736x/cd/4b/d9/cd4bd9b0ea2807611ba3a67c331bff0b.jpg'">
                </div>
                <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
            `;
            iconDiv.appendChild(icon);
        } else {
            // AI Profile Picture
            const aiAvatar = document.createElement('div');
            aiAvatar.className = 'relative w-12 h-12';
            aiAvatar.innerHTML = `
                <div class="absolute inset-0 rounded-full overflow-hidden border-2 border-yellow-500">
                    <img src="/images/ai-avatar.png" 
                         alt="Cambodia Travel AI" 
                         class="w-full h-full object-cover"
                         onerror="this.src='/images/ai-avatar-placeholder.jpg'">
                </div>
                <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
            `;
            iconDiv.appendChild(aiAvatar);
        }
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'flex-1 bg-gray-100 rounded-lg p-4';
        
        if (type === 'user') {
            contentDiv.innerHTML = `<p class="text-gray-800">${message}</p>`;
        } else {
            // Add AI profile header
            const aiHeader = document.createElement('div');
            aiHeader.className = 'flex items-center space-x-2 mb-2';
            aiHeader.innerHTML = `
                <span class="font-semibold text-yellow-600">Cambodia Travel AI</span>
                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Tour Guide</span>
            `;
            contentDiv.appendChild(aiHeader);
            
            const messageContent = document.createElement('div');
            messageContent.className = 'text-gray-800';
            messageContent.innerHTML = formatMessage(message);
            contentDiv.appendChild(messageContent);
            
            // Add destination cards if available
            if (destinations && destinations.length > 0) {
                const cardsContainer = document.createElement('div');
                cardsContainer.className = 'mt-6 grid grid-cols-1 md:grid-cols-3 gap-6';
                
                destinations.forEach(destination => {
                    const card = document.createElement('div');
                    card.className = 'bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl';
                    card.innerHTML = `
                        <div class="relative">
                            <img src="${destination.cover_url || '/images/placeholder.jpg'}" 
                                 alt="${destination.title}" 
                                 class="w-full h-56 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h3 class="text-xl font-bold text-white mb-1">${destination.title}</h3>
                                <div class="flex items-center text-white/80 text-sm">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span>${destination.location || 'Cambodia'}</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-5">
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">${destination.description}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">
                                        <i class="fas fa-star mr-1"></i>${destination.rating || '4.5'}
                                    </span>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                        <i class="fas fa-eye mr-1"></i>${destination.views || '1.2k'}
                                    </span>
                                </div>
                                <a href="/destination/${destination.id}" 
                                   class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-300 transform hover:scale-105">
                                    <span>View Details</span>
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    `;
                    cardsContainer.appendChild(card);
                });
                
                // Add a section header
                const sectionHeader = document.createElement('div');
                sectionHeader.className = 'mb-4';
                sectionHeader.innerHTML = `
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Recommended Destinations</h2>
                    <p class="text-gray-600">Here are some destinations you might be interested in:</p>
                `;
                contentDiv.appendChild(sectionHeader);
                contentDiv.appendChild(cardsContainer);
            }
        }
        
        messageDiv.appendChild(iconDiv);
        messageDiv.appendChild(contentDiv);
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Handle form submission
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const messageInput = document.getElementById('message');
        const message = messageInput.value.trim();
        
        if (!message) return;
        
        // Add user message to chat
        addMessage(message, 'user');
        
        // Add to context
        conversationContext.push('User: ' + message);
        if (conversationContext.length > 4) conversationContext.shift();
        
        // Clear input
        messageInput.value = '';
        
        try {
            // Show loading state
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'flex items-center justify-center p-4';
            loadingDiv.innerHTML = `
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-yellow-500"></div>
            `;
            chatMessages.appendChild(loadingDiv);
            
            // Send message to server with context and language
            const response = await fetch('/ai-assistant/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message, context: conversationContext, language: languagePreference })
            });
            
            // Remove loading state
            chatMessages.removeChild(loadingDiv);
            
            if (response.ok) {
                const data = await response.json();
                if (data.message) {
                    addMessage(data.message, 'assistant', data.destinations || []);
                    // Update context and language from response
                    conversationContext = data.context || [];
                    languagePreference = data.language || 'en';
                } else {
                    throw new Error('Invalid response format');
                }
            } else {
                throw new Error('Failed to get response');
            }
        } catch (error) {
            console.error('Error:', error);
            addMessage('Sorry, I encountered an error. Please try again.', 'assistant');
        }
    });

    // Clear context on page refresh
    window.addEventListener('DOMContentLoaded', function() {
        conversationContext = [];
        languagePreference = 'en';
    });
});
</script>
@endsection 