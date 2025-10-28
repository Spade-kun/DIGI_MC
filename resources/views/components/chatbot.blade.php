<!-- Dialogflow Chatbot Widget -->
<div id="chatbot-container" class="chatbot-widget">
    <!-- Chatbot Toggle Button -->
    <div id="chatbot-button" class="chatbot-toggle-btn">
        <i class="fas fa-comments"></i>
        <span class="chatbot-badge" id="unread-badge" style="display: none;">1</span>
    </div>

    <!-- Chatbot Window -->
    <div id="chatbot-window" class="chatbot-window" style="display: none;">
        <div class="chatbot-header">
            <div class="chatbot-header-content">
                <div class="chatbot-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="chatbot-title">
                    <h6 class="mb-0">DIGI MC Chatbot Assistant</h6>
                    <small class="text-white-50">Online</small>
                </div>
            </div>
            <button id="chatbot-close" class="chatbot-close-btn">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div id="chatbot-messages" class="chatbot-messages">
            <div class="message bot-message">
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-content">
                    <p>Hello! 👋 How can I help you today?</p>
                    <span class="message-time">Just now</span>
                </div>
            </div>
        </div>

        <div class="chatbot-input-area">
            <input type="text" 
                   id="chatbot-input" 
                   class="chatbot-input" 
                   placeholder="Type your message..."
                   autocomplete="off">
            <button id="chatbot-send" class="chatbot-send-btn">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<style>
/* Chatbot Widget Styles */
.chatbot-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    font-family: 'Open Sans', sans-serif;
}

/* Toggle Button */
.chatbot-toggle-btn {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(310deg, #7928CA 0%, #FF0080 100%);
    box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(121, 40, 202, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.chatbot-toggle-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 25px 0 rgba(0, 0, 0, 0.2), 0 10px 15px -5px rgba(121, 40, 202, 0.5);
}

.chatbot-toggle-btn i {
    font-size: 28px;
    color: white;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

.chatbot-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: bold;
    border: 2px solid white;
}

/* Chatbot Window */
.chatbot-window {
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 380px;
    height: 550px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    animation: slideUp 0.3s ease;
    overflow: hidden;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Header */
.chatbot-header {
    background: linear-gradient(310deg, #7928CA 0%, #FF0080 100%);
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 15px 15px 0 0;
}

.chatbot-header-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.chatbot-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.chatbot-avatar i {
    font-size: 20px;
    color: white;
}

.chatbot-title h6 {
    color: white;
    font-weight: 600;
    margin: 0;
}

.chatbot-close-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.chatbot-close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
}

/* Messages Area */
.chatbot-messages {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: #f8f9fa;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.chatbot-messages::-webkit-scrollbar {
    width: 6px;
}

.chatbot-messages::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.chatbot-messages::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 3px;
}

.chatbot-messages::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}

/* Message Bubbles */
.message {
    display: flex;
    gap: 10px;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.message-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(310deg, #7928CA 0%, #FF0080 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.message-avatar i {
    font-size: 14px;
    color: white;
}

.message-content {
    flex: 1;
}

.message-content p {
    background: white;
    padding: 12px 16px;
    border-radius: 12px;
    margin: 0 0 5px 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    line-height: 1.5;
    color: #344767;
}

.message-time {
    font-size: 11px;
    color: #8392ab;
    margin-left: 5px;
}

.user-message {
    flex-direction: row-reverse;
}

.user-message .message-content p {
    background: linear-gradient(310deg, #7928CA 0%, #FF0080 100%);
    color: white;
    border-radius: 12px 12px 0 12px;
}

.user-message .message-time {
    text-align: right;
    margin-right: 5px;
}

.user-message .message-avatar {
    background: #e9ecef;
}

.user-message .message-avatar i {
    color: #7928CA;
}

/* Typing Indicator */
.typing-indicator {
    display: flex;
    gap: 10px;
}

.typing-indicator .message-content p {
    display: flex;
    gap: 4px;
    padding: 12px 16px;
}

.typing-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #cbd5e0;
    animation: typing 1.4s infinite;
}

.typing-dot:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 60%, 100% {
        transform: translateY(0);
        opacity: 0.7;
    }
    30% {
        transform: translateY(-10px);
        opacity: 1;
    }
}

/* Input Area */
.chatbot-input-area {
    padding: 15px;
    background: white;
    border-top: 1px solid #e9ecef;
    display: flex;
    gap: 10px;
}

.chatbot-input {
    flex: 1;
    border: 1px solid #e9ecef;
    border-radius: 25px;
    padding: 12px 20px;
    font-size: 14px;
    outline: none;
    transition: all 0.3s;
}

.chatbot-input:focus {
    border-color: #7928CA;
    box-shadow: 0 0 0 2px rgba(121, 40, 202, 0.1);
}

.chatbot-send-btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: none;
    background: linear-gradient(310deg, #7928CA 0%, #FF0080 100%);
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    flex-shrink: 0;
}

.chatbot-send-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(121, 40, 202, 0.4);
}

.chatbot-send-btn:active {
    transform: scale(0.95);
}

/* Responsive Design */
@media (max-width: 480px) {
    .chatbot-window {
        width: calc(100vw - 40px);
        height: calc(100vh - 140px);
        bottom: 80px;
        right: -10px;
    }

    .chatbot-widget {
        right: 10px;
        bottom: 10px;
    }
}
</style>

<script>
// Dialogflow Configuration
const DIALOGFLOW_CONFIG = {
    projectId: 'YOUR_PROJECT_ID', // Replace with your Dialogflow project ID
    sessionId: 'user-{{ Auth::id() ?? 'guest' }}-' + Date.now(),
    languageCode: 'en-US'
};

// Chatbot Elements
const chatbotButton = document.getElementById('chatbot-button');
const chatbotWindow = document.getElementById('chatbot-window');
const chatbotClose = document.getElementById('chatbot-close');
const chatbotInput = document.getElementById('chatbot-input');
const chatbotSend = document.getElementById('chatbot-send');
const chatbotMessages = document.getElementById('chatbot-messages');
const unreadBadge = document.getElementById('unread-badge');

let isOpen = false;
let unreadCount = 0;

// Toggle chatbot window
function toggleChatbot() {
    isOpen = !isOpen;
    chatbotWindow.style.display = isOpen ? 'flex' : 'none';
    
    if (isOpen) {
        chatbotInput.focus();
        unreadCount = 0;
        unreadBadge.style.display = 'none';
    }
}

// Event Listeners
chatbotButton.addEventListener('click', toggleChatbot);
chatbotClose.addEventListener('click', toggleChatbot);

// Send message on button click
chatbotSend.addEventListener('click', sendMessage);

// Send message on Enter key
chatbotInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

// Send message function
function sendMessage() {
    const message = chatbotInput.value.trim();
    
    if (message === '') return;
    
    // Add user message to chat
    addMessage(message, 'user');
    
    // Clear input
    chatbotInput.value = '';
    
    // Show typing indicator
    showTypingIndicator();
    
    // Send to Dialogflow
    sendToDialogflow(message);
}

// Add message to chat
function addMessage(text, sender = 'bot') {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${sender}-message`;
    
    const currentTime = new Date().toLocaleTimeString('en-US', { 
        hour: 'numeric', 
        minute: '2-digit',
        hour12: true 
    });
    
    if (sender === 'bot') {
        messageDiv.innerHTML = `
            <div class="message-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="message-content">
                <p>${text}</p>
                <span class="message-time">${currentTime}</span>
            </div>
        `;
    } else {
        messageDiv.innerHTML = `
            <div class="message-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="message-content">
                <p>${text}</p>
                <span class="message-time">${currentTime}</span>
            </div>
        `;
    }
    
    chatbotMessages.appendChild(messageDiv);
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    
    // Show notification if chat is closed
    if (!isOpen && sender === 'bot') {
        unreadCount++;
        unreadBadge.textContent = unreadCount;
        unreadBadge.style.display = 'flex';
    }
}

// Show typing indicator
function showTypingIndicator() {
    const typingDiv = document.createElement('div');
    typingDiv.className = 'message typing-indicator';
    typingDiv.id = 'typing-indicator';
    typingDiv.innerHTML = `
        <div class="message-avatar">
            <i class="fas fa-robot"></i>
        </div>
        <div class="message-content">
            <p>
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
            </p>
        </div>
    `;
    
    chatbotMessages.appendChild(typingDiv);
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
}

// Remove typing indicator
function removeTypingIndicator() {
    const typingIndicator = document.getElementById('typing-indicator');
    if (typingIndicator) {
        typingIndicator.remove();
    }
}

// Send message to Dialogflow
async function sendToDialogflow(message) {
    try {
        // This is a placeholder - you'll need to implement the actual Dialogflow API call
        // You can either use Dialogflow REST API or Dialogflow Messenger integration
        
        const response = await fetch('/api/dialogflow', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                message: message,
                sessionId: DIALOGFLOW_CONFIG.sessionId
            })
        });
        
        const data = await response.json();
        
        // Remove typing indicator
        setTimeout(() => {
            removeTypingIndicator();
            
            // Add bot response
            if (data.response) {
                addMessage(data.response, 'bot');
            } else {
                addMessage("I'm sorry, I didn't understand that. Could you please rephrase?", 'bot');
            }
        }, 1000); // Simulate delay
        
    } catch (error) {
        console.error('Error sending message to Dialogflow:', error);
        
        // Remove typing indicator and show error
        setTimeout(() => {
            removeTypingIndicator();
            addMessage("Sorry, I'm having trouble connecting. Please try again later.", 'bot');
        }, 1000);
    }
}

// Quick test responses (remove this when Dialogflow is integrated)
// This simulates bot responses for testing
function simulateResponse(userMessage) {
    setTimeout(() => {
        removeTypingIndicator();
        
        let response = "I'm here to help! You can ask me about documents, gazettes, or any other assistance you need.";
        
        // Simple keyword matching for demo
        const lowerMessage = userMessage.toLowerCase();
        if (lowerMessage.includes('document')) {
            response = "You can find all your documents in the Documents section. Would you like me to guide you there?";
        } else if (lowerMessage.includes('gazette')) {
            response = "The Gazette section contains all official publications. You can browse and download them anytime!";
        } else if (lowerMessage.includes('help')) {
            response = "I can help you with:\n• Navigating documents\n• Finding gazettes\n• Understanding the system\n\nWhat would you like to know?";
        } else if (lowerMessage.includes('hello') || lowerMessage.includes('hi')) {
            response = "Hello! 👋 How can I assist you today?";
        }
        
        addMessage(response, 'bot');
    }, 1500);
}

// For testing without Dialogflow API - remove when ready
if (typeof sendToDialogflow === 'undefined' || window.location.hostname === 'localhost') {
    window.sendToDialogflow = function(message) {
        simulateResponse(message);
    };
}
</script>
