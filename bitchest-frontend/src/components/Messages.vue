<template>
    <div class="min-h-screen transition-colors duration-300" :class="isDark ? 'bg-black' : 'bg-white'">
        <!-- Radial gradient background -->
        <div class="fixed inset-0 pointer-events-none" :style="isDark
            ? 'background: radial-gradient(123.22% 129.67% at 100.89% -5.6%, #000 0%, #000 100%)'
            : 'background: radial-gradient(123.22% 129.67% at 100.89% -5.6%, #FFF 100%)'">
        </div>

        <div class="relative z-10 flex">
            <!-- Sidebar -->
            <aside class="fixed left-0 top-0 bottom-0 w-64 transition-colors border-r" :class="isDark
                ? 'bg-gradient-to-b from-black via-[#0F1A27] to-black border-[#0F1A27]'
                : 'bg-slate-50 border-slate-200'">
                <!-- Logo -->
                <div class="p-8">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg" :class="isDark ? 'bg-[#00FF19]' : 'bg-green-500'"></div>
                        <h1 class="text-xl font-bold" :class="isDark ? 'text-white' : 'text-slate-900'">
                            <span class="text-[#00FF19]">Bit</span>Chest
                        </h1>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="px-8 space-y-8">
                    <router-link to="/dashboard" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors"
                        :class="isDark ? 'text-[#749DC8] hover:text-[#0074CC]' : 'text-slate-600 hover:text-[#0074CC]'">
                        <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
                        <span class="text-sm font-medium">Dashboard</span>
                    </router-link>

                    <router-link to="/wallet" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors"
                        :class="isDark ? 'text-[#749DC8] hover:text-[#0074CC]' : 'text-slate-600 hover:text-[#0074CC]'">
                        <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
                        <span class="text-sm font-medium">Wallet</span>
                    </router-link>

                    <div class="flex items-center gap-4 px-4 py-3 rounded-lg cursor-pointer relative group"
                        :class="isDark ? 'text-[#0074CC] bg-[#0F1A27]' : 'text-[#0074CC] bg-blue-50'">
                        <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
                        <span class="text-sm font-medium">Messages</span>
                        <div class="absolute right-4 w-2 h-2 rounded-full bg-[#A8000B]"></div>
                    </div>

                    <router-link to="/trade" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors"
                        :class="isDark ? 'text-[#749DC8] hover:text-[#0074CC]' : 'text-slate-600 hover:text-[#0074CC]'">
                        <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
                        <span class="text-sm font-medium">Trade</span>
                    </router-link>
                </nav>

                <!-- Footer -->
                <div class="absolute bottom-0 left-0 right-0 p-8">
                    <button @click="logout"
                        class="flex items-center gap-4 px-4 py-3 rounded-lg cursor-pointer transition-colors w-full"
                        :class="isDark ? 'text-[#749DC8] hover:text-[#0074CC]' : 'text-slate-600 hover:text-[#0074CC]'">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M7.5 17.5H4.16667C3.72464 17.5 3.30072 17.3244 2.98816 17.0118C2.67559 16.6993 2.5 16.2754 2.5 15.8333V4.16667C2.5 3.72464 2.67559 3.30072 2.98816 2.98816C3.30072 2.67559 3.72464 2.5 4.16667 2.5H7.5"
                                :stroke="isDark ? '#749DC8' : '#38618C'" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M13.333 14.1667L17.4997 10L13.333 5.83337" :stroke="isDark ? '#749DC8' : '#38618C'"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M17.5 10H7.5" :stroke="isDark ? '#749DC8' : '#38618C'" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="text-sm font-medium">Logout</span>
                    </button>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 ml-64">
                <div class="container mx-auto px-8 py-6">
                    <!-- Header -->
                    <header class="px-8 py-6 border-b"
                        :class="isDark ? 'border-[#0F1A27] bg-[#0F1A27]' : 'border-slate-200 bg-white'">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-3xl font-bold" :class="isDark ? 'text-white' : 'text-slate-900'">
                                    Messages</h1>
                                <p class="text-sm mt-1" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                    Communicate with support and other users</p>
                            </div>

                            <div class="flex items-center gap-6">
                                <!-- Theme Toggle -->
                                <button @click="toggleTheme" class="p-2 rounded-lg transition-colors"
                                    :class="isDark ? 'hover:bg-[#1A2A3A]' : 'hover:bg-slate-100'">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="5" fill="currentColor" />
                                        <path v-if="isDark"
                                            d="M12 1v2m0 18v2M21 12h-2M5 12H3m15.36-7.36l-1.41 1.41M7.05 16.95l-1.41 1.41m12.72 0l-1.41-1.41M7.05 7.05L5.64 5.64"
                                            stroke="currentColor" stroke-width="2" />
                                    </svg>
                                </button>

                                <!-- New Message Button -->
                                <button @click="startNewConversation"
                                    class="px-4 py-2 rounded-lg bg-[#00FF19] text-white text-sm font-medium hover:opacity-90 transition-opacity">
                                    New Message
                                </button>

                                <!-- User Profile -->
                                <div class="flex items-center gap-3 cursor-pointer">
                                    <img src="https://api.builder.io/api/v1/image/assets/TEMP/6878da621cc6fbc5afde884e8db308ccb609ab42?width=56"
                                        alt="User" class="w-8 h-8 rounded object-cover" />
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium"
                                            :class="isDark ? 'text-[#749DC8]' : 'text-slate-900'">
                                            {{ userName }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>

                    <!-- Messages Content -->
                    <main class="p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-[calc(100vh-200px)]">
                            <!-- Conversations List -->
                            <div class="lg:col-span-1 rounded-xl border overflow-hidden"
                                :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                    <input v-model="searchQuery" type="text" placeholder="Search conversations..."
                                        class="w-full px-4 py-2 rounded-lg border dark:bg-[#1A2A3A] dark:border-[#2A3A4A] dark:text-white dark:placeholder-[#749DC8]" />
                                </div>
                                <div class="overflow-y-auto h-[calc(100%-80px)]">
                                    <div v-for="conversation in filteredConversations" :key="conversation.id"
                                        @click="selectConversation(conversation.id)" :class="[
                                            'p-4 border-b cursor-pointer transition-colors',
                                            isDark ? 'border-[#1A2A3A] hover:bg-[#1A2A3A]' : 'border-slate-100 hover:bg-slate-50',
                                            selectedConversationId === conversation.id ? (isDark ? 'bg-[#1A2A3A]' : 'bg-slate-100') : ''
                                        ]">
                                        <div class="flex items-start gap-3">
                                            <div class="relative">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm"
                                                    :style="{ backgroundColor: conversation.avatarColor }">
                                                    {{ conversation.contact.charAt(0) }}
                                                </div>
                                                <div v-if="conversation.unreadCount > 0"
                                                    class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-[#A8000B] text-white text-xs flex items-center justify-center">
                                                    {{ conversation.unreadCount }}
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex justify-between items-start">
                                                    <div class="font-medium"
                                                        :class="isDark ? 'text-white' : 'text-slate-900'">{{
                                                        conversation.contact }}</div>
                                                    <div class="text-xs"
                                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{
                                                        formatTime(conversation.lastMessageTime) }}</div>
                                                </div>
                                                <div class="text-sm truncate mt-1" :class="[
                                                    conversation.unreadCount > 0 ? (isDark ? 'text-white' : 'text-slate-900 font-medium') : (isDark ? 'text-[#749DC8]' : 'text-slate-600')
                                                ]">
                                                    {{ conversation.lastMessage }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Chat Area -->
                            <div class="lg:col-span-2 flex flex-col rounded-xl border overflow-hidden"
                                :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                <!-- Chat Header -->
                                <div v-if="selectedConversation" class="p-4 border-b"
                                    :class="isDark ? 'border-[#1A2A3A] bg-[#0F1A27]' : 'border-slate-200 bg-white'">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm"
                                                :style="{ backgroundColor: getAvatarColor(selectedConversation.contact) }">
                                                {{ selectedConversation.contact.charAt(0) }}
                                            </div>
                                            <div>
                                                <div class="font-bold"
                                                    :class="isDark ? 'text-white' : 'text-slate-900'">{{
                                                    selectedConversation.contact }}</div>
                                                <div class="text-xs"
                                                    :class="isDark ? 'text-[#00FF19]' : 'text-green-600'">
                                                    {{ selectedConversation.isSupport ? 'BitChest Support' : 'Online' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#1A2A3A]">
                                                <svg class="w-5 h-5"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path d="M18 10L12 16L6 10" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Messages Container -->
                                <div v-if="selectedConversation" ref="messagesContainer"
                                    class="flex-1 overflow-y-auto p-4 space-y-4">
                                    <div v-for="message in selectedConversation.messages" :key="message.id"
                                        :class="['flex', message.sender === 'me' ? 'justify-end' : 'justify-start']">
                                        <div :class="[
                                            'max-w-[70%] rounded-lg p-3',
                                            message.sender === 'me'
                                                ? (isDark ? 'bg-[#0074CC] text-white' : 'bg-blue-500 text-white')
                                                : (isDark ? 'bg-[#1A2A3A] text-[#749DC8]' : 'bg-slate-100 text-slate-900')
                                        ]">
                                            <div class="text-sm">{{ message.content }}</div>
                                            <div class="text-xs mt-1 opacity-75 text-right">{{
                                                formatMessageTime(message.timestamp) }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- No Conversation Selected -->
                                <div v-else class="flex-1 flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center"
                                            :class="isDark ? 'bg-[#1A2A3A]' : 'bg-slate-100'">
                                            <svg class="w-8 h-8" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium mb-2"
                                            :class="isDark ? 'text-white' : 'text-slate-900'">No conversation selected
                                        </h3>
                                        <p class="text-sm" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Select
                                            a conversation or start a new one</p>
                                    </div>
                                </div>

                                <!-- Message Input -->
                                <div v-if="selectedConversation" class="p-4 border-t"
                                    :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                    <div class="flex gap-2">
                                        <input v-model="newMessage" @keyup.enter="sendMessage" type="text"
                                            placeholder="Type your message..."
                                            class="flex-1 px-4 py-2 rounded-lg border dark:bg-[#1A2A3A] dark:border-[#2A3A4A] dark:text-white dark:placeholder-[#749DC8]" />
                                        <button @click="sendMessage" :disabled="!newMessage.trim()"
                                            class="px-4 py-2 rounded-lg bg-[#00FF19] text-white font-medium hover:opacity-90 transition-opacity disabled:opacity-50">
                                            Send
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>

            <!-- New Conversation Modal -->
            <div v-if="showNewConversationModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white dark:bg-[#0F1A27] rounded-xl p-6 w-full max-w-md">
                    <h3 class="text-lg font-bold mb-4 dark:text-white">New Conversation</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm mb-2 dark:text-[#749DC8]">Recipient</label>
                            <select v-model="newConversationRecipient"
                                class="w-full px-4 py-2 rounded-lg border dark:bg-[#1A2A3A] dark:border-[#2A3A4A] dark:text-white">
                                <option value="support">BitChest Support</option>
                                <option v-for="user in otherUsers" :key="user.id" :value="user.id">{{ user.name }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm mb-2 dark:text-[#749DC8]">Message</label>
                            <textarea v-model="newConversationMessage" rows="4"
                                class="w-full px-4 py-2 rounded-lg border dark:bg-[#1A2A3A] dark:border-[#2A3A4A] dark:text-white"></textarea>
                        </div>
                        <div class="flex gap-3 justify-end">
                            <button @click="showNewConversationModal = false"
                                class="px-4 py-2 text-sm rounded-lg border hover:bg-gray-100 dark:hover:bg-[#1A2A3A] dark:text-[#749DC8]">
                                Cancel
                            </button>
                            <button @click="createNewConversation"
                                class="px-4 py-2 text-sm rounded-lg bg-[#00FF19] text-white hover:opacity-90">
                                Start Conversation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, nextTick } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const isDark = ref(false)
const searchQuery = ref('')
const selectedConversationId = ref<string | null>(null)
const newMessage = ref('')
const showNewConversationModal = ref(false)
const newConversationRecipient = ref('support')
const newConversationMessage = ref('')
const messagesContainer = ref<HTMLElement | null>(null)

const userName = ref('John Doe')

const conversations = ref([
    {
        id: '1',
        contact: 'BitChest Support',
        lastMessage: 'We have resolved your withdrawal issue.',
        lastMessageTime: '2024-01-15T14:30:00',
        unreadCount: 0,
        isSupport: true,
        avatarColor: '#0074CC',
        messages: [
            { id: '1', sender: 'support', content: 'Hello! How can I help you today?', timestamp: '2024-01-15T10:00:00' },
            { id: '2', sender: 'me', content: 'Hi, I\'m having trouble with a withdrawal.', timestamp: '2024-01-15T10:05:00' },
            { id: '3', sender: 'support', content: 'I see. Can you provide the transaction ID?', timestamp: '2024-01-15T10:10:00' },
            { id: '4', sender: 'me', content: 'Yes, it\'s TXN-123456789.', timestamp: '2024-01-15T10:15:00' },
            { id: '5', sender: 'support', content: 'Thank you. We have resolved your withdrawal issue.', timestamp: '2024-01-15T14:30:00' },
        ]
    },
    {
        id: '2',
        contact: 'Sarah Johnson',
        lastMessage: 'Thanks for the trading tips!',
        lastMessageTime: '2024-01-14T16:45:00',
        unreadCount: 2,
        isSupport: false,
        avatarColor: '#00FF19',
        messages: [
            { id: '1', sender: 'me', content: 'Hey Sarah, have you seen the BTC movement?', timestamp: '2024-01-14T14:00:00' },
            { id: '2', sender: 'other', content: 'Yes! It\'s been crazy today.', timestamp: '2024-01-14T14:05:00' },
            { id: '3', sender: 'me', content: 'I think it might dip further before recovery.', timestamp: '2024-01-14T14:10:00' },
            { id: '4', sender: 'other', content: 'Thanks for the trading tips!', timestamp: '2024-01-14T16:45:00' },
        ]
    },
    {
        id: '3',
        contact: 'Michael Chen',
        lastMessage: 'Let\'s sync up about the portfolio strategy.',
        lastMessageTime: '2024-01-13T11:20:00',
        unreadCount: 0,
        isSupport: false,
        avatarColor: '#A8000B',
        messages: []
    },
    {
        id: '4',
        contact: 'Emma Wilson',
        lastMessage: 'The ADA staking rewards are live now.',
        lastMessageTime: '2024-01-12T09:15:00',
        unreadCount: 1,
        isSupport: false,
        avatarColor: '#FF5964',
        messages: []
    },
    {
        id: '5',
        contact: 'Technical Support',
        lastMessage: 'Your KYC verification has been approved.',
        lastMessageTime: '2024-01-11T13:40:00',
        unreadCount: 0,
        isSupport: true,
        avatarColor: '#38618C',
        messages: []
    }
])

const otherUsers = ref([
    { id: 'user1', name: 'Alex Turner' },
    { id: 'user2', name: 'Maria Garcia' },
    { id: 'user3', name: 'David Lee' },
    { id: 'user4', name: 'Lisa Wong' },
])

const selectedConversation = computed(() => {
    return conversations.value.find(c => c.id === selectedConversationId.value) || null
})

const filteredConversations = computed(() => {
    if (!searchQuery.value.trim()) return conversations.value
    return conversations.value.filter(conversation =>
        conversation.contact.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        conversation.lastMessage.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
})

const toggleTheme = () => {
    isDark.value = !isDark.value
}

const logout = () => {
    router.push('/login')
}

const selectConversation = (id: string) => {
    selectedConversationId.value = id
    // Mark as read
    const conversation = conversations.value.find(c => c.id === id)
    if (conversation) {
        conversation.unreadCount = 0
    }
    scrollToBottom()
}

const sendMessage = () => {
    if (!newMessage.value.trim() || !selectedConversation.value) return

    const message = {
        id: Date.now().toString(),
        sender: 'me' as const,
        content: newMessage.value,
        timestamp: new Date().toISOString()
    }

    selectedConversation.value.messages.push(message)
    selectedConversation.value.lastMessage = newMessage.value
    selectedConversation.value.lastMessageTime = new Date().toISOString()

    // Simulate reply after 2 seconds
    setTimeout(() => {
        if (selectedConversation.value) {
            const reply = {
                id: (Date.now() + 1).toString(),
                sender: selectedConversation.value.isSupport ? 'support' : 'other',
                content: getAutoReply(newMessage.value),
                timestamp: new Date().toISOString()
            }
            selectedConversation.value.messages.push(reply)
            selectedConversation.value.lastMessage = reply.content
            selectedConversation.value.lastMessageTime = new Date().toISOString()
            if (!selectedConversation.value.isSupport) {
                selectedConversation.value.unreadCount++
            }
            scrollToBottom()
        }
    }, 2000)

    newMessage.value = ''
    scrollToBottom()
}

const getAutoReply = (message: string) => {
    const lower = message.toLowerCase()
    if (lower.includes('help') || lower.includes('support')) {
        return "I'll help you with that right away!"
    } else if (lower.includes('price') || lower.includes('value')) {
        return "Current market prices are available in the Trade section."
    } else if (lower.includes('withdraw') || lower.includes('deposit')) {
        return "Transaction details can be found in your Wallet history."
    } else {
        return "Thanks for your message. I'll get back to you shortly."
    }
}

const startNewConversation = () => {
    showNewConversationModal.value = true
}

const createNewConversation = () => {
    if (!newConversationMessage.value.trim()) return

    const newId = (conversations.value.length + 1).toString()
    const isSupport = newConversationRecipient.value === 'support'
    const contactName = isSupport ? 'BitChest Support' :
        otherUsers.value.find(u => u.id === newConversationRecipient.value)?.name || 'New Contact'

    const newConv = {
        id: newId,
        contact: contactName,
        lastMessage: newConversationMessage.value,
        lastMessageTime: new Date().toISOString(),
        unreadCount: 0,
        isSupport,
        avatarColor: getAvatarColor(contactName),
        messages: [
            {
                id: '1',
                sender: 'me' as const,
                content: newConversationMessage.value,
                timestamp: new Date().toISOString()
            }
        ]
    }

    conversations.value.unshift(newConv)
    selectedConversationId.value = newId
    showNewConversationModal.value = false
    newConversationRecipient.value = 'support'
    newConversationMessage.value = ''
    scrollToBottom()
}

const getAvatarColor = (name: string) => {
    const colors = ['#0074CC', '#00FF19', '#A8000B', '#FF5964', '#38618C', '#35A7FF', '#9181F4']
    const index = name.split('').reduce((acc, char) => acc + char.charCodeAt(0), 0)
    return colors[index % colors.length]
}

const formatTime = (isoString: string) => {
    const date = new Date(isoString)
    const now = new Date()
    const diffMs = now.getTime() - date.getTime()
    const diffHours = diffMs / (1000 * 60 * 60)

    if (diffHours < 24) {
        return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
    } else if (diffHours < 48) {
        return 'Yesterday'
    } else {
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })
    }
}

const formatMessageTime = (isoString: string) => {
    return new Date(isoString).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
}

const scrollToBottom = () => {
    nextTick(() => {
        if (messagesContainer.value) {
            messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
        }
    })
}

onMounted(() => {
    // Select first conversation by default
    if (conversations.value.length > 0) {
        selectedConversationId.value = conversations.value[0].id
    }
})
</script>