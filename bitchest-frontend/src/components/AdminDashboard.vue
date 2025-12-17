<template>
    <div class="min-h-screen transition-colors duration-300" :class="isDark ? 'bg-black' : 'bg-white'">
        <!-- Loading State -->
        <div v-if="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="text-white">
                <div class="w-16 h-16 border-4 border-t-transparent border-[#00FF19] rounded-full animate-spin mx-auto">
                </div>
                <p class="mt-4">Loading dashboard...</p>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="fixed left-0 top-0 h-screen z-40 w-64 transition-colors border-r" :class="isDark
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
                <div v-for="item in menuItems" :key="item.path" @click="navigateTo(item.path)" :class="[
                    'flex items-center gap-4 text-sm font-medium px-4 py-3 rounded-lg transition-colors relative group cursor-pointer',
                    currentPath === item.path
                        ? (isDark ? 'text-[#0074CC] bg-[#0F1A27]' : 'text-[#0074CC] bg-blue-50')
                        : (isDark ? 'text-[#749DC8] hover:text-[#0074CC] hover:bg-[#1A2A3A]' : 'text-slate-600 hover:text-[#0074CC] hover:bg-slate-100'),
                ]">
                    <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
                    <span>{{ item.name }}</span>
                    <div v-if="item.path === '/messages' && unreadMessages > 0"
                        class="absolute right-4 w-2 h-2 rounded-full bg-[#A8000B]"></div>
                </div>
            </nav>

            <!-- Logout -->
            <div class="absolute bottom-0 left-0 right-0 p-8">
                <div @click="logout"
                    class="flex items-center gap-4 px-4 py-3 rounded-lg cursor-pointer transition-colors"
                    :class="isDark ? 'text-[#749DC8] hover:text-[#0074CC] hover:bg-[#1A2A3A]' : 'text-slate-600 hover:text-[#0074CC] hover:bg-slate-100'">
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
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="ml-64">
            <!-- Header -->
            <header class="px-8 py-6 border-b transition-colors"
                :class="isDark ? 'border-[#0F1A27] bg-[#0F1A27]' : 'border-slate-200 bg-white'">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold transition-colors"
                            :class="isDark ? 'text-white' : 'text-slate-900'">Admin Dashboard</h1>
                        <p class="text-sm mt-1 transition-colors" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                            Welcome, {{ userName }} (Administrator) • Last login: {{ lastLogin }}
                        </p>
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

                        <!-- Refresh Data -->
                        <button @click="fetchData" :disabled="loading" class="p-2 rounded-lg transition-colors"
                            :class="isDark ? 'hover:bg-[#1A2A3A]' : 'hover:bg-slate-100'" title="Refresh data">
                            <svg class="w-5 h-5" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>

                        <!-- Notifications Button -->
                        <button @click="toggleNotifications"
                            class="px-3 py-1.5 rounded-full flex items-center gap-2 bg-[#A8000B] text-white text-xs font-medium cursor-pointer hover:bg-[#8A0009] transition-colors relative">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor">
                                <path
                                    d="M6 1C5.44772 1 5 1.44772 5 2V3H2C1.44772 3 1 3.44772 1 4V10C1 10.5523 1.44772 11 2 11H10C10.5523 11 11 10.5523 11 10V4C11 3.44772 10.5523 3 10 3H7V2C7 1.44772 6.55228 1 6 1Z" />
                            </svg>
                            {{ notifications.length }}
                            <span v-if="unreadNotifications > 0"
                                class="absolute -top-1 -right-1 w-2 h-2 rounded-full bg-[#00FF19]"></span>
                        </button>

                        <!-- User Profile -->
                        <div class="flex items-center gap-3 cursor-pointer" @click="showProfileMenu = !showProfileMenu">
                            <div
                                class="w-8 h-8 rounded-full overflow-hidden bg-gradient-to-r from-[#0074CC] to-[#00FF19] flex items-center justify-center text-white font-bold">
                                {{ userInitials }}
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium transition-colors"
                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-900'">{{ userName }}</span>
                                <svg width="4" height="6" viewBox="0 0 4 6" fill="none">
                                    <path d="M0 0L2 3L4 0" :stroke="isDark ? '#749DC8' : '#64748b'" stroke-width="1" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Profile Menu Dropdown -->
            <div v-if="showProfileMenu" class="fixed right-8 top-24 z-50">
                <div class="w-48 rounded-lg shadow-xl border m-4" :class="isDark
                    ? 'bg-[#0F1A27] border-[#1A2A3A]'
                    : 'bg-white border-slate-200'">
                    <div class="p-3 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                        <p class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">{{ userName
                        }}</p>
                        <p class="text-xs" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{ userEmail }}</p>
                    </div>
                    <div class="p-2">
                        <button @click="router.push('/admin/settings')"
                            class="w-full text-left px-3 py-2 text-sm rounded hover:bg-gray-100 dark:hover:bg-[#1A2A3A] transition-colors"
                            :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                            Profile Settings
                        </button>
                        <button @click="logout"
                            class="w-full text-left px-3 py-2 text-sm rounded hover:bg-gray-100 dark:hover:bg-[#1A2A3A] transition-colors text-[#A8000B]">
                            Logout
                        </button>
                    </div>
                </div>
            </div>

            <!-- Notifications Panel -->
            <div v-if="showNotifications" class="fixed right-0 top-24 z-50">
                <div class="w-80 rounded-lg shadow-xl border m-4" :class="isDark
                    ? 'bg-[#0F1A27] border-[#1A2A3A]'
                    : 'bg-white border-slate-200'">

                    <!-- Panel Header -->
                    <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                                Notifications ({{ notifications.length }})
                            </h3>
                            <div class="flex items-center gap-2">
                                <button @click="markAllAsRead" class="text-xs text-[#0074CC] hover:underline">
                                    Mark all as read
                                </button>
                                <button @click="toggleNotifications"
                                    class="text-slate-500 hover:text-slate-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications List -->
                    <div class="max-h-96 overflow-y-auto">
                        <div v-for="(notif, index) in notifications" :key="index"
                            @click="handleNotificationClick(notif)"
                            class="p-4 border-b last:border-b-0 cursor-pointer transition-colors" :class="[
                                isDark ? 'border-[#1A2A3A] hover:bg-[#1A2A3A]' : 'border-slate-100 hover:bg-slate-50',
                                !notif.read ? (isDark ? 'bg-[#1A2A3A]' : 'bg-blue-50') : ''
                            ]">
                            <div class="flex items-start gap-3">
                                <div :class="[
                                    'w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0',
                                    getNotificationColor(notif.type)
                                ]">
                                    {{ notif.type.charAt(0).toUpperCase() }}
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <h4 class="text-sm font-semibold"
                                            :class="isDark ? 'text-white' : 'text-slate-900'">
                                            {{ notif.title }}
                                        </h4>
                                        <span class="text-xs" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                            {{ formatTimeAgo(notif.created_at) }}
                                        </span>
                                    </div>
                                    <p class="text-xs mt-1" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                        {{ notif.message }}
                                    </p>
                                    <div v-if="notif.amount" class="text-xs font-medium mt-1"
                                        :class="notif.amount > 0 ? 'text-[#00FF19]' : 'text-[#A8000B]'">
                                        {{ formatCurrency(notif.amount) }}
                                    </div>
                                    <div v-if="!notif.read"
                                        class="inline-block mt-2 px-2 py-1 text-xs rounded bg-[#0074CC] text-white">
                                        New
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Footer -->
                    <div class="p-4 border-t" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                        <button @click="router.push('/messages')"
                            class="text-xs text-[#0074CC] hover:underline block text-center w-full">
                            View All Notifications
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="p-8">
                <!-- Statistics Section -->
                <div class="mb-8">
                    <h2 class="text-xs font-semibold uppercase tracking-widest mb-4 transition-colors"
                        :class="isDark ? 'text-[#B1AFCD]' : 'text-slate-600'">
                        Platform Statistics
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Total Users Card -->
                        <div class="rounded-xl p-6 border transition-colors group cursor-pointer hover:shadow-lg"
                            :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'"
                            @click="router.push('/admin/clients')">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm mb-2 transition-colors"
                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Total Users</div>
                                    <div class="text-2xl font-bold transition-colors"
                                        :class="isDark ? 'text-white' : 'text-slate-900'">
                                        {{ formatNumber(statistics.totalUsers) }}
                                    </div>
                                </div>
                                <div class="text-xs px-2 py-1 rounded transition-colors" :class="statistics.userGrowth >= 0
                                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                                    : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'">
                                    {{ statistics.userGrowth >= 0 ? '+' : '' }}{{ statistics.userGrowth }}%
                                </div>
                            </div>
                            <div class="text-xs mt-2 transition-colors"
                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                {{ statistics.activeUsers }} active today
                            </div>
                        </div>

                        <!-- Total Transactions -->
                        <div class="rounded-xl p-6 border transition-colors"
                            :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm mb-2 transition-colors"
                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">24h Transactions</div>
                                    <div class="text-2xl font-bold transition-colors"
                                        :class="isDark ? 'text-white' : 'text-slate-900'">
                                        {{ formatNumber(statistics.dailyTransactions) }}
                                    </div>
                                </div>
                                <div class="text-xs px-2 py-1 rounded transition-colors" :class="statistics.transactionGrowth >= 0
                                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                                    : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'">
                                    {{ statistics.transactionGrowth >= 0 ? '+' : '' }}{{ statistics.transactionGrowth
                                    }}%
                                </div>
                            </div>
                            <div class="text-xs mt-2 transition-colors"
                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                Volume: {{ formatCurrency(statistics.transactionVolume) }}
                            </div>
                        </div>

                        <!-- Total Revenue -->
                        <div class="rounded-xl p-6 border transition-colors"
                            :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                            <div class="text-sm mb-2 transition-colors"
                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Total Revenue</div>
                            <div class="text-2xl font-bold text-[#00FF19]">
                                {{ formatCurrency(statistics.totalRevenue) }}
                            </div>
                            <div class="text-xs mt-2 transition-colors"
                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                {{ formatCurrency(statistics.dailyRevenue) }} today
                            </div>
                        </div>

                        <!-- System Status -->
                        <div class="rounded-xl p-6 border transition-colors"
                            :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-sm transition-colors"
                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">System Status</div>
                                <div class="flex items-center gap-1">
                                    <div class="w-2 h-2 rounded-full"
                                        :class="systemStatus.online ? 'bg-[#00FF19]' : 'bg-[#A8000B]'"></div>
                                    <span class="text-xs"
                                        :class="systemStatus.online ? 'text-[#00FF19]' : 'text-[#A8000B]'">
                                        {{ systemStatus.online ? 'Online' : 'Offline' }}
                                    </span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs"
                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">API</span>
                                    <span class="text-xs font-medium"
                                        :class="systemStatus.api ? 'text-[#00FF19]' : 'text-[#A8000B]'">
                                        {{ systemStatus.api ? '✓' : '✗' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs"
                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Database</span>
                                    <span class="text-xs font-medium"
                                        :class="systemStatus.database ? 'text-[#00FF19]' : 'text-[#A8000B]'">
                                        {{ systemStatus.database ? '✓' : '✗' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Response
                                        Time</span>
                                    <span class="text-xs font-medium" :class="isDark ? 'text-white' : 'text-slate-900'">
                                        {{ systemStatus.responseTime }}ms
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Crypto Market and Activity -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Crypto Market Overview -->
                    <div class="lg:col-span-2">
                        <div class="rounded-xl border transition-colors"
                            :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                            <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                                        Top Cryptocurrencies
                                    </h3>
                                    <div class="flex items-center gap-2">
                                        <button v-for="interval in ['1h', '24h', '7d']" :key="interval"
                                            @click="selectedInterval = interval" :class="[
                                                'px-3 py-1 text-xs rounded transition-colors',
                                                selectedInterval === interval
                                                    ? (isDark ? 'bg-[#0074CC] text-white' : 'bg-blue-500 text-white')
                                                    : (isDark ? 'text-[#749DC8] hover:bg-[#1A2A3A]' : 'text-slate-600 hover:bg-slate-100')
                                            ]">
                                            {{ interval }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead :class="isDark ? 'bg-[#0F1A27]' : 'bg-slate-50'">
                                        <tr>
                                            <th class="py-3 px-4 text-left text-xs font-semibold"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Asset</th>
                                            <th class="py-3 px-4 text-left text-xs font-semibold"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Price</th>
                                            <th class="py-3 px-4 text-left text-xs font-semibold"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">24h Change</th>
                                            <th class="py-3 px-4 text-left text-xs font-semibold"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Market Cap</th>
                                            <th class="py-3 px-4 text-left text-xs font-semibold"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Volume</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="crypto in cryptocurrencies" :key="crypto.symbol"
                                            class="border-t cursor-pointer hover:opacity-90 transition-opacity"
                                            :class="isDark ? 'border-[#1A2A3A] hover:bg-[#1A2A3A]' : 'border-slate-100 hover:bg-slate-50'"
                                            @click="selectCrypto(crypto)">
                                            <td class="py-3 px-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm"
                                                        :style="{ backgroundColor: getCryptoColor(crypto.symbol) }">
                                                        {{ crypto.symbol.charAt(0) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-medium"
                                                            :class="isDark ? 'text-white' : 'text-slate-900'">{{
                                                                crypto.name }}</div>
                                                        <div class="text-xs"
                                                            :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{
                                                                crypto.symbol }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 font-medium"
                                                :class="isDark ? 'text-white' : 'text-slate-900'">
                                                {{ formatCurrency(crypto.price) }}
                                            </td>
                                            <td class="py-3 px-4">
                                                <div :class="[
                                                    'font-medium',
                                                    crypto.change24h >= 0 ? 'text-[#00FF19]' : 'text-[#A8000B]'
                                                ]">
                                                    {{ crypto.change24h >= 0 ? '+' : '' }}{{ crypto.change24h.toFixed(2)
                                                    }}%
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 font-medium"
                                                :class="isDark ? 'text-white' : 'text-slate-900'">
                                                {{ formatMarketCap(crypto.marketCap) }}
                                            </td>
                                            <td class="py-3 px-4 font-medium"
                                                :class="isDark ? 'text-white' : 'text-slate-900'">
                                                {{ formatVolume(crypto.volume24h) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div>
                        <div class="rounded-xl border transition-colors"
                            :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                            <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                                        Recent Activity
                                    </h3>
                                    <button @click="fetchRecentActivity" :disabled="loading"
                                        class="text-xs text-[#0074CC] hover:underline disabled:opacity-50">
                                        Refresh
                                    </button>
                                </div>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <div v-for="activity in recentActivity" :key="activity.id"
                                    class="p-4 border-b last:border-b-0 cursor-pointer hover:opacity-90 transition-opacity"
                                    :class="isDark ? 'border-[#1A2A3A] hover:bg-[#1A2A3A]' : 'border-slate-100 hover:bg-slate-50'"
                                    @click="handleActivityClick(activity)">
                                    <div class="flex items-start gap-3">
                                        <div :class="[
                                            'w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0',
                                            getActivityColor(activity.type)
                                        ]">
                                            {{ getActivityIcon(activity.type) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-start">
                                                <h4 class="text-sm font-semibold"
                                                    :class="isDark ? 'text-white' : 'text-slate-900'">
                                                    {{ activity.description }}
                                                </h4>
                                                <span class="text-xs"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                                    {{ formatTimeAgo(activity.timestamp) }}
                                                </span>
                                            </div>
                                            <div class="text-xs mt-1"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                                User: {{ activity.userName }}
                                            </div>
                                            <div v-if="activity.amount" class="text-xs font-medium mt-1"
                                                :class="activity.amount > 0 ? 'text-[#00FF19]' : 'text-[#A8000B]'">
                                                {{ formatCurrency(Math.abs(activity.amount)) }}
                                                {{ activity.type.includes('buy') ? 'bought' : 'sold' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Revenue Chart -->
                    <div class="rounded-xl border transition-colors"
                        :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                        <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                            <h3 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                                Revenue Overview (Last 30 days)
                            </h3>
                        </div>
                        <div class="p-4 h-64 flex items-center justify-center">
                            <canvas ref="revenueChart" class="w-full h-full"></canvas>
                        </div>
                    </div>

                    <!-- User Growth Chart -->
                    <div class="rounded-xl border transition-colors"
                        :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                        <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                            <h3 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                                User Growth (Last 30 days)
                            </h3>
                        </div>
                        <div class="p-4 h-64 flex items-center justify-center">
                            <canvas ref="userGrowthChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watch, nextTick, computed, onUnmounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { authAPI, marketAPI } from '../services/api'
import Chart from 'chart.js/auto'

const router = useRouter()
const route = useRoute()
const isDark = ref(false)
const loading = ref(true)
const showNotifications = ref(false)
const showProfileMenu = ref(false)
const selectedInterval = ref('24h')
const selectedCrypto = ref<any>(null)

// Références pour les charts
const revenueChart = ref<HTMLCanvasElement | null>(null)
const userGrowthChart = ref<HTMLCanvasElement | null>(null)
let revenueChartInstance: Chart | null = null
let userGrowthChartInstance: Chart | null = null

// Données utilisateur
const userName = ref('')
const userEmail = ref('')
const userInitials = ref('')
const lastLogin = ref('')

// Données dynamiques
const statistics = ref({
    totalUsers: 0,
    activeUsers: 0,
    userGrowth: 0,
    dailyTransactions: 0,
    transactionGrowth: 0,
    transactionVolume: 0,
    totalRevenue: 0,
    dailyRevenue: 0
})

const systemStatus = ref({
    online: true,
    api: true,
    database: true,
    responseTime: 0
})

const cryptocurrencies = ref<any[]>([])
const recentActivity = ref<any[]>([])
const notifications = ref<any[]>([])

// Calcul des valeurs dérivées
const unreadNotifications = computed(() => {
    return notifications.value.filter(n => !n.read).length
})

const unreadMessages = computed(() => {
    return notifications.value.filter(n => n.type === 'message' && !n.read).length
})

const currentPath = computed(() => route.path)

const menuItems = [
    { name: 'Dashboard', path: '/admin/dashboard' },
    { name: 'Wallet', path: '/wallet' },
    { name: 'Messages', path: '/messages' },
    { name: 'Trade', path: '/trade' },
    { name: 'Account Setting', path: '/admin/settings' },
    { name: 'Clients', path: '/admin/clients' },
]

// Formatters
const formatCurrency = (value: number) => {
    if (value >= 1000000) {
        return `€${(value / 1000000).toFixed(1)}M`
    } else if (value >= 1000) {
        return `€${(value / 1000).toFixed(1)}K`
    }
    return `€${value.toFixed(2)}`
}

const formatMarketCap = (value: number) => {
    if (value >= 1000000000000) {
        return `$${(value / 1000000000000).toFixed(1)}T`
    } else if (value >= 1000000000) {
        return `$${(value / 1000000000).toFixed(1)}B`
    } else if (value >= 1000000) {
        return `$${(value / 1000000).toFixed(1)}M`
    }
    return `$${value.toFixed(0)}`
}

const formatVolume = (value: number) => {
    if (value >= 1000000000) {
        return `$${(value / 1000000000).toFixed(1)}B`
    } else if (value >= 1000000) {
        return `$${(value / 1000000).toFixed(1)}M`
    } else if (value >= 1000) {
        return `$${(value / 1000).toFixed(1)}K`
    }
    return `$${value.toFixed(0)}`
}

const formatNumber = (value: number) => {
    if (value >= 1000000) {
        return `${(value / 1000000).toFixed(1)}M`
    } else if (value >= 1000) {
        return `${(value / 1000).toFixed(1)}K`
    }
    return value.toString()
}

const formatTimeAgo = (timestamp: string) => {
    const date = new Date(timestamp)
    const now = new Date()
    const diffMs = now.getTime() - date.getTime()
    const diffMins = Math.floor(diffMs / 60000)
    const diffHours = Math.floor(diffMs / 3600000)
    const diffDays = Math.floor(diffMs / 86400000)

    if (diffMins < 60) {
        return `${diffMins}m ago`
    } else if (diffHours < 24) {
        return `${diffHours}h ago`
    } else {
        return `${diffDays}d ago`
    }
}

// Helper functions
const getCryptoColor = (symbol: string) => {
    const colors: Record<string, string> = {
        BTC: '#F7931A',
        ETH: '#627EEA',
        ADA: '#0033AD',
        SOL: '#00FFA3',
        XRP: '#23292F',
        LTC: '#BFBBBB',
        DOGE: '#C2A633',
        DOT: '#E6007A',
        BCH: '#8DC451',
        XLM: '#14B6E7'
    }
    return colors[symbol] || '#0074CC'
}

const getNotificationColor = (type: string) => {
    switch (type) {
        case 'transaction': return 'bg-gradient-to-br from-[#00FF19] to-[#00CC14]'
        case 'message': return 'bg-gradient-to-br from-[#0074CC] to-[#0055AA]'
        case 'alert': return 'bg-gradient-to-br from-[#A8000B] to-[#8A0009]'
        case 'info': return 'bg-gradient-to-br from-[#FF5964] to-[#CC4752]'
        default: return 'bg-gradient-to-br from-[#38618C] to-[#2A4A6F]'
    }
}

const getActivityColor = (type: string) => {
    switch (type) {
        case 'buy': return 'bg-gradient-to-br from-[#00FF19] to-[#00CC14]'
        case 'sell': return 'bg-gradient-to-br from-[#A8000B] to-[#8A0009]'
        case 'deposit': return 'bg-gradient-to-br from-[#0074CC] to-[#0055AA]'
        case 'withdrawal': return 'bg-gradient-to-br from-[#FF5964] to-[#CC4752]'
        case 'registration': return 'bg-gradient-to-br from-[#35A7FF] to-[#0088CC]'
        default: return 'bg-gradient-to-br from-[#38618C] to-[#2A4A6F]'
    }
}

const getActivityIcon = (type: string) => {
    switch (type) {
        case 'buy': return 'B'
        case 'sell': return 'S'
        case 'deposit': return 'D'
        case 'withdrawal': return 'W'
        case 'registration': return 'R'
        default: return 'A'
    }
}

// Navigation
const navigateTo = (path: string) => {
    router.push(path)
}

const selectCrypto = (crypto: any) => {
    selectedCrypto.value = crypto
    router.push({
        path: '/trade',
        query: { crypto: crypto.symbol }
    })
}

const handleActivityClick = (activity: any) => {
    if (activity.userId) {
        router.push(`/admin/clients/${activity.userId}`)
    }
}

const handleNotificationClick = (notification: any) => {
    notification.read = true
    if (notification.link) {
        router.push(notification.link)
    }
}

// Data fetching
const fetchData = async () => {
    loading.value = true
    try {
        await Promise.all([
            fetchStatistics(),
            fetchCryptocurrencies(),
            fetchRecentActivity(),
            fetchNotifications(),
            checkSystemStatus()
        ])

        // Initialize charts after data is loaded
        await nextTick()
        initializeCharts()
    } catch (error) {
        console.error('Error fetching data:', error)
    } finally {
        loading.value = false
    }
}

const fetchStatistics = async () => {
    try {
        const data = await marketAPI.getStatistics()
        statistics.value = {
            totalUsers: data.total_users || 0,
            activeUsers: data.active_users || 0,
            userGrowth: data.user_growth || 0,
            dailyTransactions: data.daily_transactions || 0,
            transactionGrowth: data.transaction_growth || 0,
            transactionVolume: data.transaction_volume || 0,
            totalRevenue: data.total_revenue || 0,
            dailyRevenue: data.daily_revenue || 0
        }
    } catch (error) {
        console.error('Error fetching statistics:', error)
    }
}

const fetchCryptocurrencies = async () => {
    try {
        const data = await marketAPI.getCryptocurrencies()
        cryptocurrencies.value = data.map((crypto: any) => ({
            ...crypto,
            price: parseFloat(crypto.price),
            change24h: parseFloat(crypto.change24h),
            marketCap: parseFloat(crypto.market_cap),
            volume24h: parseFloat(crypto.volume24h)
        }))
    } catch (error) {
        console.error('Error fetching cryptocurrencies:', error)
        // Fallback data
        cryptocurrencies.value = [
            { symbol: 'BTC', name: 'Bitcoin', price: 43250.00, change24h: 2.34, marketCap: 850000000000, volume24h: 28345000000 },
            { symbol: 'ETH', name: 'Ethereum', price: 2580.50, change24h: 1.87, marketCap: 310000000000, volume24h: 14230000000 },
            { symbol: 'ADA', name: 'Cardano', price: 0.52, change24h: 3.21, marketCap: 18500000000, volume24h: 420000000 },
            { symbol: 'SOL', name: 'Solana', price: 98.20, change24h: -0.45, marketCap: 42000000000, volume24h: 2800000000 },
            { symbol: 'XRP', name: 'Ripple', price: 0.62, change24h: 0.82, marketCap: 34000000000, volume24h: 1800000000 }
        ]
    }
}

const fetchRecentActivity = async () => {
    try {
        const data = await marketAPI.getRecentTransactions()
        recentActivity.value = data.map((activity: any) => ({
            ...activity,
            timestamp: activity.created_at || activity.timestamp
        }))
    } catch (error) {
        console.error('Error fetching recent activity:', error)
        // Fallback data
        recentActivity.value = [
            { id: 1, type: 'buy', description: 'Large BTC purchase', userName: 'John Doe', amount: 43250, timestamp: new Date(Date.now() - 1800000).toISOString() },
            { id: 2, type: 'sell', description: 'ETH sale', userName: 'Jane Smith', amount: -5161, timestamp: new Date(Date.now() - 3600000).toISOString() },
            { id: 3, type: 'registration', description: 'New user registered', userName: 'New User', timestamp: new Date(Date.now() - 7200000).toISOString() },
            { id: 4, type: 'deposit', description: 'EUR deposit', userName: 'Mike Johnson', amount: 5000, timestamp: new Date(Date.now() - 10800000).toISOString() }
        ]
    }
}

const fetchNotifications = async () => {
    try {
        const data = await marketAPI.getNotifications()
        notifications.value = data
    } catch (error) {
        console.error('Error fetching notifications:', error)
        // Fallback data
        notifications.value = [
            { id: 1, type: 'transaction', title: 'Large Transaction', message: 'User John Doe made a large BTC purchase', amount: 43250, read: false, created_at: new Date(Date.now() - 3600000).toISOString() },
            { id: 2, type: 'message', title: 'New Support Ticket', message: 'User Jane Smith opened a support ticket', read: false, created_at: new Date(Date.now() - 7200000).toISOString() },
            { id: 3, type: 'alert', title: 'System Alert', message: 'High server load detected', read: true, created_at: new Date(Date.now() - 10800000).toISOString() },
            { id: 4, type: 'info', title: 'Maintenance Notice', message: 'Scheduled maintenance in 2 hours', read: true, created_at: new Date(Date.now() - 14400000).toISOString() }
        ]
    }
}

const checkSystemStatus = async () => {
    try {
        const startTime = Date.now()
        // Simple ping to check API status
        await marketAPI.getStatistics()
        const responseTime = Date.now() - startTime

        systemStatus.value = {
            online: true,
            api: true,
            database: true,
            responseTime: responseTime
        }
    } catch (error) {
        systemStatus.value = {
            online: false,
            api: false,
            database: false,
            responseTime: 0
        }
    }
}

// Chart functions
const initializeCharts = () => {
    destroyCharts()

    if (revenueChart.value) {
        revenueChartInstance = new Chart(revenueChart.value, {
            type: 'line',
            data: {
                labels: Array.from({ length: 30 }, (_, i) => `Day ${i + 1}`),
                datasets: [{
                    label: 'Revenue (€)',
                    data: Array.from({ length: 30 }, () => Math.random() * 10000 + 5000),
                    borderColor: '#00FF19',
                    backgroundColor: 'rgba(0, 255, 25, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: isDark.value ? 'rgba(116, 157, 200, 0.1)' : 'rgba(148, 163, 184, 0.1)'
                        },
                        ticks: {
                            color: isDark.value ? '#749DC8' : '#64748b'
                        }
                    },
                    x: {
                        grid: {
                            color: isDark.value ? 'rgba(116, 157, 200, 0.1)' : 'rgba(148, 163, 184, 0.1)'
                        },
                        ticks: {
                            color: isDark.value ? '#749DC8' : '#64748b'
                        }
                    }
                }
            }
        })
    }

    if (userGrowthChart.value) {
        userGrowthChartInstance = new Chart(userGrowthChart.value, {
            type: 'bar',
            data: {
                labels: Array.from({ length: 30 }, (_, i) => `Day ${i + 1}`),
                datasets: [{
                    label: 'New Users',
                    data: Array.from({ length: 30 }, () => Math.floor(Math.random() * 50) + 10),
                    backgroundColor: '#0074CC',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: isDark.value ? 'rgba(116, 157, 200, 0.1)' : 'rgba(148, 163, 184, 0.1)'
                        },
                        ticks: {
                            color: isDark.value ? '#749DC8' : '#64748b'
                        }
                    },
                    x: {
                        grid: {
                            color: isDark.value ? 'rgba(116, 157, 200, 0.1)' : 'rgba(148, 163, 184, 0.1)'
                        },
                        ticks: {
                            color: isDark.value ? '#749DC8' : '#64748b'
                        }
                    }
                }
            }
        })
    }
}

const destroyCharts = () => {
    if (revenueChartInstance) {
        revenueChartInstance.destroy()
        revenueChartInstance = null
    }
    if (userGrowthChartInstance) {
        userGrowthChartInstance.destroy()
        userGrowthChartInstance = null
    }
}

// UI functions
const toggleTheme = () => {
    isDark.value = !isDark.value
    localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
    updateChartsTheme()
}

const toggleNotifications = () => {
    showNotifications.value = !showNotifications.value
}

const markAllAsRead = () => {
    notifications.value.forEach(notification => {
        notification.read = true
    })
}

const updateChartsTheme = () => {
    if (revenueChartInstance) {
        revenueChartInstance.options.scales!.x!.grid!.color = isDark.value ? 'rgba(116, 157, 200, 0.1)' : 'rgba(148, 163, 184, 0.1)'
        revenueChartInstance.options.scales!.x!.ticks!.color = isDark.value ? '#749DC8' : '#64748b'
        revenueChartInstance.options.scales!.y!.grid!.color = isDark.value ? 'rgba(116, 157, 200, 0.1)' : 'rgba(148, 163, 184, 0.1)'
        revenueChartInstance.options.scales!.y!.ticks!.color = isDark.value ? '#749DC8' : '#64748b'
        revenueChartInstance.update()
    }

    if (userGrowthChartInstance) {
        userGrowthChartInstance.options.scales!.x!.grid!.color = isDark.value ? 'rgba(116, 157, 200, 0.1)' : 'rgba(148, 163, 184, 0.1)'
        userGrowthChartInstance.options.scales!.x!.ticks!.color = isDark.value ? '#749DC8' : '#64748b'
        userGrowthChartInstance.options.scales!.y!.grid!.color = isDark.value ? 'rgba(116, 157, 200, 0.1)' : 'rgba(148, 163, 184, 0.1)'
        userGrowthChartInstance.options.scales!.y!.ticks!.color = isDark.value ? '#749DC8' : '#64748b'
        userGrowthChartInstance.update()
    }
}

// Logout
const logout = async () => {
    try {
        await authAPI.logout()
    } catch (error) {
        console.error('Logout error:', error)
    } finally {
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        router.push('/login')
    }
}

// Lifecycle
onMounted(async () => {
    // Load theme preference
    const savedTheme = localStorage.getItem('theme')
    isDark.value = savedTheme === 'dark'

    // Load user data
    const user = JSON.parse(localStorage.getItem('user') || '{}')
    userName.value = user.name || 'Admin'
    userEmail.value = user.email || 'admin@bitchest.com'
    userInitials.value = userName.value.split(' ').map((n: string) => n[0]).join('').toUpperCase()
    lastLogin.value = new Date().toLocaleString()

    // Fetch data
    await fetchData()

    // Set up auto-refresh
    setInterval(fetchData, 60000) // Refresh every minute
})

onUnmounted(() => {
    destroyCharts()
})

// Watch for theme changes
watch(isDark, () => {
    updateChartsTheme()
})

// Watch for interval changes
watch(selectedInterval, async (newInterval) => {
    if (selectedCrypto.value) {
        loading.value = true
        try {
            const history = await marketAPI.getPriceHistory(selectedCrypto.value.symbol, newInterval)
            // Update chart with new data
        } catch (error) {
            console.error('Error fetching price history:', error)
        } finally {
            loading.value = false
        }
    }
})
</script>