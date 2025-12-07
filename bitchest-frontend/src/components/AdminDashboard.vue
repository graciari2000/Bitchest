<script setup lang="ts">
import { ref } from 'vue'

const isDark = ref(false)
const sidebarCollapsed = ref(false)
const showNotifications = ref(false)

const toggleTheme = () => {
    isDark.value = !isDark.value
}

const toggleNotifications = () => {
    showNotifications.value = !showNotifications.value
}

const menuItems = [
    { name: 'Dashboard', active: true },
    { name: 'Wallet', active: false },
    { name: 'Messages', active: false, badge: true },
    { name: 'Trade', active: false },
    { name: 'Account Setting', active: false },
    { name: 'Clients', active: false },
]

const statistics = [
    { value: '19678', symbol: 'BTC', change: '+12.5%' },
    { value: '23.234', label: 'ETH', sublabel: 'Transactions' },
    { value: '380.234', label: 'LTC', sublabel: 'Funds', positive: true },
]

const notifications = [
    {
        name: 'Clifford Hale',
        message: 'Hello! I have a problem with my payment methods..',
        time: '2 hours ago',
        type: 'message',
    },
    {
        name: 'Lottie Marsh',
        message: 'New transaction',
        amount: '+380.234 LTC',
        time: '3 hours ago',
        type: 'transaction',
        positive: true,
        initial: 'L',
    },
    {
        name: 'BTC',
        message: 'Bitcoin is up by 5 points today.',
        change: '+39.69%',
        time: '3 hours ago',
        type: 'news',
        initial: 'B',
    },
    {
        name: 'Danny Jacobs',
        message: "Let's talk when we have time.",
        time: '2 hours ago',
        type: 'message',
    },
]

const history = [
    { name: 'Danny Jacobs atau Joko Boyer Utomo', amount: '+0.025', date: '08/26/2018', positive: true },
    { name: 'Clifford hale', amount: '-5.23%', date: '08/26/2018', positive: false },
    { name: 'Buat beli susu anak', amount: '-5.23%', date: '08/26/2018', positive: false, highlighted: true },
    { name: 'Langganan odobe CC', amount: '-5.23%', date: '08/26/2018', positive: false },
    { name: 'Hasil mining 3 mingguu', amount: '+0.025', date: '08/26/2018', positive: true },
]

const trends = [
    { symbol: 'BTC', value: '7.356,67', change: '-5.23%', positive: false },
    { symbol: 'ETH', value: '465,22', change: '+132%', positive: true },
    { symbol: 'LTC', value: '104,23', change: '+75.69%', positive: true },
]
</script>

<template>
    <div class="min-h-screen transition-colors duration-300" :class="isDark ? 'bg-black' : 'bg-white'">
        <!-- Sidebar -->
        <aside class="fixed left-0 top-0 h-screen z-40 w-64 transition-colors border-r" :class="isDark
            ? 'bg-gradient-to-b from-black via-[#0F1A27] to-black border-[#0F1A27]'
            : 'bg-slate-50 border-slate-200'">
            <nav class="pt-16 px-8 space-y-8">
                <a v-for="(item, index) in menuItems" :key="index" href="#" :class="[
                    'flex items-center gap-4 text-sm font-medium px-4 py-3 rounded-lg transition-colors relative group',
                    item.active
                        ? (isDark ? 'text-[#0074CC] bg-[#0F1A27]' : 'text-[#0074CC] bg-blue-50')
                        : (isDark ? 'text-[#749DC8] hover:text-[#0074CC]' : 'text-slate-600 hover:text-[#0074CC]'),
                ]">
                    <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
                    <span>{{ item.name }}</span>
                    <div v-if="item.badge" class="absolute right-4 w-2 h-2 rounded-full bg-[#A8000B]"></div>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="ml-64">
            <!-- Header -->
            <header class="px-8 py-6 border-b transition-colors"
                :class="isDark ? 'border-[#0F1A27] bg-[#0F1A27]' : 'border-slate-200 bg-white'">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold transition-colors"
                            :class="isDark ? 'text-white' : 'text-slate-900'">Dashboard</h1>
                        <p class="text-sm mt-1 transition-colors" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                            Welcome, Admin!</p>
                    </div>

                    <div class="flex items-center gap-6">
                        <!-- Theme Toggle Button -->
                        <button @click="toggleTheme" class="p-2 rounded-lg transition-colors"
                            :class="isDark ? 'hover:bg-[#1A2A3A]' : 'hover:bg-slate-100'">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="5" fill="currentColor" />
                                <path v-if="isDark"
                                    d="M12 1v2m0 18v2M21 12h-2M5 12H3m15.36-7.36l-1.41 1.41M7.05 16.95l-1.41 1.41m12.72 0l-1.41-1.41M7.05 7.05L5.64 5.64"
                                    stroke="currentColor" stroke-width="2" />
                            </svg>
                        </button>

                        <button class="p-2 rounded-lg transition-colors"
                            :class="isDark ? 'hover:bg-[#1A2A3A]' : 'hover:bg-slate-100'">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <circle cx="9" cy="9" r="7" :stroke="isDark ? '#749DC8' : '#64748b'"
                                    stroke-width="1.5" />
                                <path d="M13 13L16 16" :stroke="isDark ? '#749DC8' : '#64748b'" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>
                        </button>

                        <button class="p-2 rounded-lg transition-colors"
                            :class="isDark ? 'hover:bg-[#1A2A3A]' : 'hover:bg-slate-100'">
                            <div class="grid grid-cols-3 gap-1 w-5 h-5">
                                <div v-for="i in 9" :key="i" class="w-1 h-1 rounded-full"
                                    :class="isDark ? 'bg-[#749DC8]' : 'bg-slate-600'"></div>
                            </div>
                        </button>

                        <!-- Notifications Button -->
                        <button @click="toggleNotifications"
                            class="px-3 py-1.5 rounded-full flex items-center gap-2 bg-[#A8000B] text-white text-xs font-medium cursor-pointer hover:bg-[#8A0009] transition-colors">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor">
                                <path
                                    d="M6 1C5.44772 1 5 1.44772 5 2V3H2C1.44772 3 1 3.44772 1 4V10C1 10.5523 1.44772 11 2 11H10C10.5523 11 11 10.5523 11 10V4C11 3.44772 10.5523 3 10 3H7V2C7 1.44772 6.55228 1 6 1Z" />
                            </svg>
                            15
                        </button>

                        <div class="flex items-center gap-3">
                            <img src="https://api.builder.io/api/v1/image/assets/TEMP/6878da621cc6fbc5afde884e8db308ccb609ab42"
                                alt="User" class="w-8 h-8 rounded" />
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium transition-colors"
                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-900'">Pixelz
                                    Warrios</span>
                                <svg width="4" height="6" viewBox="0 0 4 6" fill="none">
                                    <path d="M0 0L2 3L4 0" :stroke="isDark ? '#749DC8' : '#64748b'" stroke-width="1" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Notifications Panel -->
            <div v-if="showNotifications" class="fixed right-0 top-24 z-50">
                <div class="w-80 rounded-lg shadow-xl border m-4" :class="isDark
                    ? 'bg-[#0F1A27] border-[#1A2A3A]'
                    : 'bg-white border-slate-200'">

                    <!-- Panel Header -->
                    <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                                Notifications
                            </h3>
                            <button @click="toggleNotifications"
                                class="text-slate-500 hover:text-slate-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Notifications List -->
                    <div class="max-h-96 overflow-y-auto">
                        <div v-for="(notif, index) in notifications" :key="index" class="p-4 border-b last:border-b-0"
                            :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-100'">
                            <div class="flex items-start gap-3">
                                <div v-if="notif.initial" :class="[
                                    'w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0',
                                    notif.type === 'transaction'
                                        ? 'bg-gradient-to-br from-[#00FF19] to-[#00CC14]'
                                        : 'bg-gradient-to-br from-[#A8000B] to-[#8A0009]',
                                ]">
                                    {{ notif.initial }}
                                </div>
                                <div v-else class="w-8 h-8 rounded-full flex-shrink-0"
                                    :class="isDark ? 'bg-[#1A2A3A]' : 'bg-slate-200'">
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                                        {{ notif.name }}</h4>
                                    <p class="text-xs mt-1" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{
                                        notif.message }}</p>
                                    <div v-if="notif.amount" class="text-xs text-[#00FF19] mt-1 font-medium">{{
                                        notif.amount }}</div>
                                    <div v-if="notif.change" class="text-xs text-[#00FF19] mt-1 font-medium">{{
                                        notif.change }}</div>
                                    <div class="text-xs mt-2" :class="isDark ? 'text-slate-500' : 'text-slate-500'">{{
                                        notif.time }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Footer -->
                    <div class="p-4 border-t" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                        <a href="#" class="text-xs text-[#0074CC] hover:underline block text-center">See All
                            Notifications</a>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <main class="p-8">
                <!-- Statistics Section -->
                <div class="mb-8">
                    <h2 class="text-xs font-semibold uppercase tracking-widest mb-4 transition-colors"
                        :class="isDark ? 'text-[#B1AFCD]' : 'text-slate-600'">
                        Statistics
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Primary Card -->
                        <div
                            class="rounded-xl bg-[#0074CC] text-white p-6 relative overflow-hidden group cursor-pointer hover:shadow-lg transition-shadow">
                            <div class="absolute inset-0 opacity-20 group-hover:opacity-30"
                                style="background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.1) 100%)">
                            </div>
                            <div class="relative">
                                <div class="text-2xl font-bold mb-1">19678</div>
                                <div class="text-xs font-medium">+12.5%</div>
                            </div>
                        </div>

                        <!-- Stat Card 2 -->
                        <div class="rounded-xl p-6 border transition-colors"
                            :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                            <div class="text-xl font-semibold mb-1 transition-colors"
                                :class="isDark ? 'text-white' : 'text-slate-900'">23.234</div>
                            <div class="text-xs transition-colors"
                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Transactions</div>
                        </div>

                        <!-- Stat Card 3 -->
                        <div class="rounded-xl p-6 border transition-colors"
                            :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                            <div class="text-xl font-semibold text-[#00FF19] mb-1">380.234</div>
                            <div class="text-xs transition-colors"
                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Funds</div>
                        </div>

                        <!-- Add Currency -->
                        <div class="rounded-xl border-2 border-dashed p-6 flex items-center justify-center cursor-pointer transition-colors"
                            :class="isDark ? 'border-[#1A2A3A] hover:bg-[#1A2A3A]' : 'border-slate-300 hover:bg-slate-50'">
                            <div class="text-xs font-bold transition-colors"
                                :class="isDark ? 'text-[#5B5A99]' : 'text-slate-400'">+ Add Currency</div>
                        </div>
                    </div>
                </div>

                <!-- Graph and Layout -->
                <div class="grid grid-cols-1 xl:grid-cols-1 gap-6">
                    <!-- Left Column: Graph, Trends and History -->
                    <div class="space-y-6">
                        <!-- Chart Card -->
                        <div class="rounded-xl p-6 h-96 flex items-center justify-center border transition-colors"
                            :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                            <div class="text-center transition-colors"
                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                <div class="text-sm mb-2">📈 Chart Area</div>
                                <div class="text-xs">Your trading chart will appear here</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-15">
                            <!-- Trends -->
                            <div>
                                <h3 class="text-xs font-semibold uppercase tracking-widest mb-4 transition-colors"
                                    :class="isDark ? 'text-[#B1AFCD]' : 'text-slate-600'">
                                    Trend
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div v-for="trend in trends" :key="trend.symbol"
                                        class="rounded-xl p-4 border transition-colors"
                                        :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="text-sm font-bold transition-colors"
                                                :class="isDark ? 'text-white' : 'text-slate-900'">
                                                {{ trend.symbol }}
                                            </div>
                                            <div
                                                :class="['text-xs font-medium', trend.positive ? 'text-[#00FF19]' : 'text-[#A8000B]']">
                                                {{ trend.change }}
                                            </div>
                                        </div>
                                        <div class="text-lg font-semibold transition-colors"
                                            :class="isDark ? 'text-white' : 'text-slate-900'">
                                            {{ trend.value }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- History -->
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-xs font-semibold uppercase tracking-widest transition-colors"
                                        :class="isDark ? 'text-[#B1AFCD]' : 'text-slate-600'">
                                        History
                                    </h3>
                                    <a href="#" class="text-xs text-[#0074CC] hover:underline">See All</a>
                                </div>

                                <div class="space-y-2">
                                    <div v-for="(item, index) in history" :key="index" :class="[
                                        'flex items-center justify-between p-4 rounded-lg transition-colors',
                                        item.highlighted
                                            ? (isDark ? 'bg-[#0F1A27] border border-[#1A2A3A]' : 'bg-blue-50 border border-blue-200')
                                            : (isDark ? 'hover:bg-[#1A2A3A]' : 'hover:bg-slate-50'),
                                    ]">
                                        <div>
                                            <div class="text-sm font-medium transition-colors"
                                                :class="isDark ? 'text-white' : 'text-slate-900'">
                                                {{ item.name }}
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-6">
                                            <div
                                                :class="['text-xs font-medium', item.positive ? 'text-[#00FF19]' : 'text-[#A8000B]']">
                                                {{ item.amount }}
                                            </div>
                                            <div class="text-xs w-20 text-right transition-colors"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                                {{ item.date }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>