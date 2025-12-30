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
                    <router-link to="/user-dashboard" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors"
                        :class="isDark ? 'text-[#749DC8] hover:text-[#0074CC]' : 'text-slate-600 hover:text-[#0074CC]'">
                        <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
                        <span class="text-sm font-medium">Dashboard</span>
                    </router-link>

                    <router-link to="/wallet" class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors"
                        :class="isDark ? 'text-[#749DC8] hover:text-[#0074CC]' : 'text-slate-600 hover:text-[#0074CC]'">
                        <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
                        <span class="text-sm font-medium">Wallet</span>
                    </router-link>

                    <router-link to="/messages"
                        class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors relative group"
                        :class="isDark ? 'text-[#749DC8] hover:text-[#0074CC]' : 'text-slate-600 hover:text-[#0074CC]'">
                        <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
                        <span class="text-sm font-medium">Messages</span>
                        <div class="absolute right-4 w-2 h-2 rounded-full bg-[#A8000B]"></div>
                    </router-link>

                    <div class="flex items-center gap-4 px-4 py-3 rounded-lg cursor-pointer"
                        :class="isDark ? 'text-[#0074CC] bg-[#0F1A27]' : 'text-[#0074CC] bg-blue-50'">
                        <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
                        <span class="text-sm font-medium">Trade</span>
                    </div>
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
                                <h1 class="text-3xl font-bold" :class="isDark ? 'text-white' : 'text-slate-900'">Trade
                                </h1>
                                <p class="text-sm mt-1" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Buy and
                                    sell cryptocurrencies</p>
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

                    <!-- Trade Content -->
                    <main class="p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Left Column: Market Data -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Trading Pair Selector -->
                                <div class="rounded-xl p-4 border"
                                    :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                    <div class="flex items-center justify-between mb-4">
                                        <h2 class="text-sm font-semibold"
                                            :class="isDark ? 'text-white' : 'text-slate-900'">Trading Pair</h2>
                                        <div class="flex items-center gap-2">
                                            <button v-for="interval in timeIntervals" :key="interval"
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
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                        <button v-for="pair in tradingPairs" :key="pair.symbol"
                                            @click="selectTradingPair(pair)" :class="[
                                                'p-3 rounded-lg border transition-colors',
                                                selectedPair?.symbol === pair.symbol
                                                    ? (isDark ? 'border-[#00FF19] bg-[#0F2A17]' : 'border-green-500 bg-green-50')
                                                    : (isDark ? 'border-[#1A2A3A] hover:bg-[#1A2A3A]' : 'border-slate-200 hover:bg-slate-50')
                                            ]">
                                            <div class="flex items-center justify-between">
                                                <div class="text-left">
                                                    <div class="font-bold"
                                                        :class="isDark ? 'text-white' : 'text-slate-900'">{{ pair.symbol
                                                        }}</div>
                                                    <div class="text-xs"
                                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{
                                                        pair.name }}</div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="font-bold"
                                                        :class="isDark ? 'text-white' : 'text-slate-900'">{{
                                                        formatCurrency(pair.price) }}</div>
                                                    <div
                                                        :class="['text-xs', pair.change24h >= 0 ? 'text-[#00FF19]' : 'text-[#A8000B]']">
                                                        {{ pair.change24h >= 0 ? '+' : '' }}{{ pair.change24h.toFixed(2)
                                                        }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <!-- Trading Chart -->
                                <div class="rounded-xl p-6 border"
                                    :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                    <div class="flex items-center justify-between mb-6">
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <div class="text-xl font-bold"
                                                    :class="isDark ? 'text-white' : 'text-slate-900'">
                                                    {{ selectedPair ? `${selectedPair.symbol}/EUR` : 'Select a pair' }}
                                                </div>
                                                <div v-if="selectedPair"
                                                    :class="['text-sm font-medium', selectedPair.change24h >= 0 ? 'text-[#00FF19]' : 'text-[#A8000B]']">
                                                    {{ selectedPair.change24h >= 0 ? '+' : '' }}{{
                                                    selectedPair.change24h.toFixed(2) }}%
                                                </div>
                                            </div>
                                            <div v-if="selectedPair" class="text-2xl font-bold"
                                                :class="isDark ? 'text-white' : 'text-slate-900'">
                                                {{ formatCurrency(selectedPair.price) }}
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div class="text-right">
                                                <div class="text-xs"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">24h High</div>
                                                <div class="font-medium"
                                                    :class="isDark ? 'text-white' : 'text-slate-900'">{{
                                                    formatCurrency(selectedPair?.high24h || 0) }}</div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-xs"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">24h Low</div>
                                                <div class="font-medium"
                                                    :class="isDark ? 'text-white' : 'text-slate-900'">{{
                                                    formatCurrency(selectedPair?.low24h || 0) }}</div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-xs"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">24h Volume
                                                </div>
                                                <div class="font-medium"
                                                    :class="isDark ? 'text-white' : 'text-slate-900'">{{
                                                    formatVolume(selectedPair?.volume24h || 0) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-64 rounded-lg overflow-hidden"
                                        :class="isDark ? 'bg-[#1A2A3A]' : 'bg-slate-100'">
                                        <div v-if="isLoadingChart" class="h-full flex items-center justify-center">
                                            <div class="text-sm" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                                Loading chart...
                                            </div>
                                        </div>
                                        <PriceChart v-else-if="selectedPair && priceHistory.length > 0"
                                            :symbol="selectedPair.symbol"
                                            :priceHistory="priceHistory" />
                                        <div v-else class="h-full flex items-center justify-center">
                                            <div class="text-center">
                                                <div class="w-12 h-12 rounded-full mx-auto mb-3 flex items-center justify-center"
                                                    :class="isDark ? 'bg-[#0F1A27]' : 'bg-white'">
                                                    <svg class="w-6 h-6"
                                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path d="M3 3V21H21" stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M7 16L9.5 11.5L12.5 14.5L17 8" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </div>
                                                <p class="text-sm" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                                    {{ selectedPair ? `Select a time interval to view ${selectedPair.symbol} chart` : 'Select a trading pair to view chart' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Book -->
                                <div class="rounded-xl border"
                                    :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                    <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                        <h3 class="text-sm font-semibold"
                                            :class="isDark ? 'text-white' : 'text-slate-900'">Order Book</h3>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="w-full">
                                            <thead :class="isDark ? 'bg-[#0F1A27]' : 'bg-slate-50'">
                                                <tr>
                                                    <th class="py-3 px-4 text-left text-xs font-semibold"
                                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Price
                                                        (EUR)</th>
                                                    <th class="py-3 px-4 text-left text-xs font-semibold"
                                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Amount
                                                    </th>
                                                    <th class="py-3 px-4 text-left text-xs font-semibold"
                                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(bid, index) in orderBook.bids.slice(0, 8)"
                                                    :key="'bid-' + index" class="border-t"
                                                    :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-100'">
                                                    <td class="py-2 px-4 text-xs text-[#00FF19]">{{
                                                        formatCurrency(bid.price) }}</td>
                                                    <td class="py-2 px-4 text-xs"
                                                        :class="isDark ? 'text-white' : 'text-slate-900'">{{
                                                        bid.amount.toFixed(6) }}</td>
                                                    <td class="py-2 px-4 text-xs"
                                                        :class="isDark ? 'text-white' : 'text-slate-900'">{{
                                                        formatCurrency(bid.total) }}</td>
                                                </tr>
                                                <tr class="border-t border-b"
                                                    :class="isDark ? 'border-[#0074CC] bg-[#0F2A3A]' : 'border-blue-200 bg-blue-50'">
                                                    <td class="py-3 px-4 text-center text-sm font-bold"
                                                        :class="isDark ? 'text-white' : 'text-slate-900'" colspan="3">
                                                        {{ formatCurrency(orderBook.spread) }} Spread
                                                    </td>
                                                </tr>
                                                <tr v-for="(ask, index) in orderBook.asks.slice(0, 8)"
                                                    :key="'ask-' + index" class="border-t"
                                                    :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-100'">
                                                    <td class="py-2 px-4 text-xs text-[#A8000B]">{{
                                                        formatCurrency(ask.price) }}</td>
                                                    <td class="py-2 px-4 text-xs"
                                                        :class="isDark ? 'text-white' : 'text-slate-900'">{{
                                                        ask.amount.toFixed(6) }}</td>
                                                    <td class="py-2 px-4 text-xs"
                                                        :class="isDark ? 'text-white' : 'text-slate-900'">{{
                                                        formatCurrency(ask.total) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Trade Panel -->
                            <div class="space-y-6">
                                <!-- Buy/Sell Panel -->
                                <div class="rounded-xl border"
                                    :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                    <div class="flex border-b"
                                        :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                        <button @click="tradeType = 'buy'" :class="[
                                            'flex-1 py-3 text-sm font-semibold transition-colors',
                                            tradeType === 'buy'
                                                ? (isDark ? 'bg-[#0F2A17] text-[#00FF19] border-b-2 border-[#00FF19]' : 'bg-green-50 text-green-600 border-b-2 border-green-500')
                                                : (isDark ? 'text-[#749DC8] hover:bg-[#1A2A3A]' : 'text-slate-600 hover:bg-slate-50')
                                        ]">
                                            Buy
                                        </button>
                                        <button @click="tradeType = 'sell'" :class="[
                                            'flex-1 py-3 text-sm font-semibold transition-colors',
                                            tradeType === 'sell'
                                                ? (isDark ? 'bg-[#2A0F17] text-[#A8000B] border-b-2 border-[#A8000B]' : 'bg-red-50 text-red-600 border-b-2 border-red-500')
                                                : (isDark ? 'text-[#749DC8] hover:bg-[#1A2A3A]' : 'text-slate-600 hover:bg-slate-50')
                                        ]">
                                            Sell
                                        </button>
                                    </div>
                                    <div class="p-4">
                                        <div class="space-y-4">
                                            <div>
                                                <div class="flex justify-between text-xs mb-2"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                                    <span>Available: {{ formatCurrency(availableBalance) }} EUR</span>
                                                    <button @click="useMaxBalance"
                                                        class="text-[#0074CC] hover:underline">Use Max</button>
                                                </div>
                                                <div class="relative">
                                                    <input v-model="amount" type="number" step="0.000001"
                                                        class="w-full px-4 py-3 rounded-lg border dark:bg-[#1A2A3A] dark:border-[#2A3A4A] dark:text-white"
                                                        placeholder="0.00" />
                                                    <div class="absolute right-3 top-3 text-sm font-medium"
                                                        :class="isDark ? 'text-white' : 'text-slate-900'">
                                                        {{ tradeType === 'buy' ? (selectedPair?.symbol || 'BTC') : 'EUR'
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-xs mb-2"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Price per unit
                                                </div>
                                                <div class="relative">
                                                    <input v-model="price" type="number" step="0.01"
                                                        class="w-full px-4 py-3 rounded-lg border dark:bg-[#1A2A3A] dark:border-[#2A3A4A] dark:text-white"
                                                        :placeholder="selectedPair ? formatCurrency(selectedPair.price) : '0.00'" />
                                                    <div class="absolute right-3 top-3 text-sm font-medium"
                                                        :class="isDark ? 'text-white' : 'text-slate-900'">EUR</div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-xs mb-2"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Total</div>
                                                <div class="p-3 rounded-lg"
                                                    :class="isDark ? 'bg-[#1A2A3A] text-white' : 'bg-slate-100 text-slate-900'">
                                                    {{ formatCurrency(totalValue) }}
                                                </div>
                                            </div>
                                            <div class="pt-4">
                                                <button @click="executeTrade" :disabled="!canTrade" :class="[
                                                    'w-full py-3 rounded-lg font-semibold transition-opacity',
                                                    tradeType === 'buy'
                                                        ? 'bg-[#00FF19] text-white hover:opacity-90'
                                                        : 'bg-[#A8000B] text-white hover:opacity-90',
                                                    canTrade ? '' : 'opacity-50 cursor-not-allowed'
                                                ]">
                                                    {{ tradeType === 'buy' ? 'Buy' : 'Sell' }} {{ selectedPair?.symbol
                                                    || 'Crypto' }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Trades -->
                                <div class="rounded-xl border"
                                    :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                    <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                        <h3 class="text-sm font-semibold"
                                            :class="isDark ? 'text-white' : 'text-slate-900'">Recent Trades</h3>
                                    </div>
                                    <div class="overflow-y-auto max-h-64">
                                        <div v-for="trade in recentTrades" :key="trade.id" class="p-3 border-b"
                                            :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-100'">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <div class="text-xs"
                                                        :class="trade.type === 'buy' ? 'text-[#00FF19]' : 'text-[#A8000B]'">
                                                        {{ trade.type.toUpperCase() }}
                                                    </div>
                                                    <div class="text-xs"
                                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{
                                                        formatTime(trade.time) }}</div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm font-medium"
                                                        :class="isDark ? 'text-white' : 'text-slate-900'">{{
                                                        formatCurrency(trade.price) }}</div>
                                                    <div class="text-xs"
                                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{
                                                        trade.amount }} {{ trade.symbol }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Open Orders -->
                                <div class="rounded-xl border"
                                    :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                    <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                        <div class="flex justify-between items-center">
                                            <h3 class="text-sm font-semibold"
                                                :class="isDark ? 'text-white' : 'text-slate-900'">Open Orders</h3>
                                            <button @click="cancelAllOrders"
                                                class="text-xs text-[#A8000B] hover:underline">Cancel All</button>
                                        </div>
                                    </div>
                                    <div class="overflow-y-auto max-h-64">
                                        <div v-for="order in openOrders" :key="order.id" class="p-3 border-b"
                                            :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-100'">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <div class="flex items-center gap-2">
                                                        <div
                                                            :class="['text-xs font-medium', order.type === 'buy' ? 'text-[#00FF19]' : 'text-[#A8000B]']">
                                                            {{ order.type.toUpperCase() }}
                                                        </div>
                                                        <div class="text-xs px-2 py-0.5 rounded"
                                                            :class="isDark ? 'bg-[#1A2A3A] text-[#749DC8]' : 'bg-slate-100 text-slate-600'">
                                                            {{ order.symbol }}
                                                        </div>
                                                    </div>
                                                    <div class="text-xs mt-1"
                                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Limit @ {{
                                                        formatCurrency(order.price) }}</div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm font-medium"
                                                        :class="isDark ? 'text-white' : 'text-slate-900'">{{
                                                        order.amount }}</div>
                                                    <button @click="cancelOrder(order.id)"
                                                        class="text-xs text-[#A8000B] hover:underline mt-1">Cancel</button>
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

            <!-- Trade Confirmation Modal -->
            <div v-if="showConfirmationModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white dark:bg-[#0F1A27] rounded-xl p-6 w-full max-w-md">
                    <h3 class="text-lg font-bold mb-4 dark:text-white">Confirm {{ tradeType === 'buy' ? 'Buy' : 'Sell'
                        }} Order</h3>
                    <div class="space-y-4">
                        <div class="p-4 rounded-lg" :class="isDark ? 'bg-[#1A2A3A]' : 'bg-slate-100'">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Type
                                    </div>
                                    <div class="font-medium"
                                        :class="tradeType === 'buy' ? 'text-[#00FF19]' : 'text-[#A8000B]'">{{
                                        tradeType.toUpperCase() }}</div>
                                </div>
                                <div>
                                    <div class="text-sm" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Pair
                                    </div>
                                    <div class="font-medium dark:text-white">{{ selectedPair?.symbol }}/EUR</div>
                                </div>
                                <div>
                                    <div class="text-sm" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Amount
                                    </div>
                                    <div class="font-medium dark:text-white">{{ parseFloat(amount).toFixed(6) }} {{
                                        selectedPair?.symbol }}</div>
                                </div>
                                <div>
                                    <div class="text-sm" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Price
                                    </div>
                                    <div class="font-medium dark:text-white">{{ formatCurrency(parseFloat(price)) }}
                                    </div>
                                </div>
                                <div class="col-span-2">
                                    <div class="text-sm" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Total
                                    </div>
                                    <div class="text-xl font-bold dark:text-white">{{ formatCurrency(totalValue) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-3 justify-end">
                            <button @click="showConfirmationModal = false"
                                class="px-4 py-2 text-sm rounded-lg border hover:bg-gray-100 dark:hover:bg-[#1A2A3A] dark:text-[#749DC8]">
                                Cancel
                            </button>
                            <button @click="confirmTrade" class="px-4 py-2 text-sm rounded-lg"
                                :class="tradeType === 'buy' ? 'bg-[#00FF19] text-white hover:opacity-90' : 'bg-[#A8000B] text-white hover:opacity-90'">
                                Confirm {{ tradeType === 'buy' ? 'Buy' : 'Sell' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import { transactionAPI, walletAPI, marketAPI, priceHistoryAPI } from '../services/api'
import PriceChart from './PriceChart.vue'

const router = useRouter()
const isDark = ref(false)
const tradeType = ref<'buy' | 'sell'>('buy')
const amount = ref('')
const price = ref('')
const selectedInterval = ref('1D')
const selectedPair = ref<any>(null)
const showConfirmationModal = ref(false)

const userName = ref('')
const availableBalance = ref(0)
const isLoading = ref(false)
const errorMessage = ref('')
const priceHistory = ref<any[]>([])
const isLoadingChart = ref(false)

const timeIntervals = ['1H', '4H', '1D', '1W', '1M']

const tradingPairs = ref([
    { symbol: 'BTC', name: 'Bitcoin', price: 43250.00, change24h: 2.34, high24h: 43800.00, low24h: 42800.00, volume24h: 28345000000 },
    { symbol: 'ETH', name: 'Ethereum', price: 2580.50, change24h: 1.87, high24h: 2620.00, low24h: 2550.00, volume24h: 14230000000 },
    { symbol: 'ADA', name: 'Cardano', price: 0.52, change24h: 3.21, high24h: 0.53, low24h: 0.50, volume24h: 420000000 },
    { symbol: 'SOL', name: 'Solana', price: 98.20, change24h: -0.45, high24h: 101.50, low24h: 96.80, volume24h: 2800000000 },
    { symbol: 'XRP', name: 'Ripple', price: 0.62, change24h: 0.82, high24h: 0.63, low24h: 0.61, volume24h: 1800000000 },
    { symbol: 'LTC', name: 'Litecoin', price: 71.25, change24h: -1.23, high24h: 73.00, low24h: 70.50, volume24h: 450000000 },
    { symbol: 'DOGE', name: 'Dogecoin', price: 0.085, change24h: 5.67, high24h: 0.088, low24h: 0.082, volume24h: 620000000 },
    { symbol: 'DOT', name: 'Polkadot', price: 7.89, change24h: -2.34, high24h: 8.10, low24h: 7.75, volume24h: 320000000 },
])

const orderBook = ref({
    bids: [
        { price: 43248.50, amount: 1.245, total: 53844.38 },
        { price: 43247.25, amount: 0.875, total: 37841.34 },
        { price: 43246.00, amount: 2.125, total: 91897.75 },
        { price: 43245.50, amount: 0.750, total: 32434.13 },
        { price: 43244.75, amount: 1.500, total: 64867.13 },
        { price: 43243.25, amount: 0.625, total: 27027.03 },
        { price: 43242.00, amount: 3.250, total: 140536.50 },
        { price: 43240.50, amount: 1.125, total: 48645.56 },
    ],
    asks: [
        { price: 43251.25, amount: 0.875, total: 37844.84 },
        { price: 43252.50, amount: 1.500, total: 64878.75 },
        { price: 43253.75, amount: 0.625, total: 27033.59 },
        { price: 43255.00, amount: 2.250, total: 97323.75 },
        { price: 43256.25, amount: 1.125, total: 48663.28 },
        { price: 43257.50, amount: 0.750, total: 32443.13 },
        { price: 43258.75, amount: 1.875, total: 81110.16 },
        { price: 43260.00, amount: 0.500, total: 21630.00 },
    ],
    spread: 2.75
})

const recentTrades = ref([
    { id: '1', type: 'buy', symbol: 'BTC', amount: 0.125, price: 43249.75, time: '2024-01-15T14:30:15' },
    { id: '2', type: 'sell', symbol: 'BTC', amount: 0.250, price: 43250.25, time: '2024-01-15T14:29:45' },
    { id: '3', type: 'buy', symbol: 'BTC', amount: 0.500, price: 43248.50, time: '2024-01-15T14:29:20' },
    { id: '4', type: 'buy', symbol: 'BTC', amount: 0.375, price: 43251.00, time: '2024-01-15T14:28:55' },
    { id: '5', type: 'sell', symbol: 'BTC', amount: 0.625, price: 43247.75, time: '2024-01-15T14:28:30' },
    { id: '6', type: 'buy', symbol: 'BTC', amount: 0.250, price: 43252.25, time: '2024-01-15T14:28:05' },
    { id: '7', type: 'sell', symbol: 'BTC', amount: 0.125, price: 43249.50, time: '2024-01-15T14:27:40' },
    { id: '8', type: 'buy', symbol: 'BTC', amount: 0.750, price: 43250.75, time: '2024-01-15T14:27:15' },
])

const openOrders = ref([
    { id: '1', type: 'buy', symbol: 'BTC', amount: 0.5, price: 43000.00 },
    { id: '2', type: 'sell', symbol: 'ETH', amount: 2.0, price: 2600.00 },
    { id: '3', type: 'buy', symbol: 'ADA', amount: 1000, price: 0.51 },
])

const totalValue = computed(() => {
    const amt = parseFloat(amount.value) || 0
    const prc = parseFloat(price.value) || (selectedPair.value?.price || 0)
    return amt * prc
})

const canTrade = computed(() => {
    const amt = parseFloat(amount.value)
    const prc = parseFloat(price.value)
    if (!amt || !prc || amt <= 0 || prc <= 0 || !selectedPair.value) return false

    if (tradeType.value === 'buy') {
        return totalValue.value <= availableBalance.value
    } else {
        // For sell, need to check if user has enough crypto
        // This would require checking the user's wallet balance
        return true
    }
})

const toggleTheme = () => {
    isDark.value = !isDark.value
}

const logout = () => {
    router.push('/login')
}

const selectTradingPair = async (pair: any) => {
    selectedPair.value = pair
    price.value = pair.price.toString()
    await loadPriceHistory(pair.symbol)
}

const loadPriceHistory = async (symbol: string) => {
    if (!symbol) return
    
    isLoadingChart.value = true
    try {
        const data = await priceHistoryAPI.getBySymbol(symbol, '30d')
        priceHistory.value = data.price_history || []
    } catch (error) {
        console.error('Error loading price history:', error)
        priceHistory.value = []
    } finally {
        isLoadingChart.value = false
    }
}

// Watch for interval changes to reload chart
watch(selectedInterval, async () => {
    if (selectedPair.value) {
        await loadPriceHistory(selectedPair.value.symbol)
    }
})

const useMaxBalance = () => {
    if (tradeType.value === 'buy' && selectedPair.value) {
        const maxAmount = availableBalance.value / (parseFloat(price.value) || selectedPair.value.price)
        amount.value = maxAmount.toFixed(6)
    }
}

const executeTrade = () => {
    if (canTrade.value) {
        showConfirmationModal.value = true
    }
}

const confirmTrade = async () => {
    if (!selectedPair.value || !amount.value) return
    
    isLoading.value = true
    errorMessage.value = ''
    
    try {
        const tradeAmount = parseFloat(amount.value)
        
        if (tradeType.value === 'buy') {
            // Buy cryptocurrency
            await transactionAPI.create('buy', selectedPair.value.symbol, tradeAmount)
        } else {
            // Sell cryptocurrency
            await walletAPI.sell(selectedPair.value.symbol, tradeAmount)
        }
        
        // Refresh balance and data
        await loadBalance()
        await loadTradingPairs()
        
        showConfirmationModal.value = false
        amount.value = ''
        price.value = selectedPair.value ? selectedPair.value.price.toString() : ''
        
        // Show success message
        alert(`Successfully ${tradeType.value === 'buy' ? 'bought' : 'sold'} ${tradeAmount} ${selectedPair.value.symbol}`)
    } catch (error: any) {
        errorMessage.value = error.message || `Failed to ${tradeType.value} cryptocurrency`
        alert(errorMessage.value)
    } finally {
        isLoading.value = false
    }
}

const loadBalance = async () => {
    try {
        const data = await walletAPI.getBalance()
        availableBalance.value = parseFloat(data.balance || 0)
    } catch (error) {
        console.error('Error loading balance:', error)
    }
}

const loadTradingPairs = async () => {
    try {
        const data = await marketAPI.getAll()
        const cryptos = data.cryptos || []
        tradingPairs.value = cryptos.map((crypto: any) => ({
            symbol: crypto.symbol,
            name: crypto.name,
            price: parseFloat(crypto.current_price || 0),
            change24h: parseFloat(crypto.price_change_percentage_24h || 0),
            high24h: parseFloat(crypto.current_price || 0) * 1.05,
            low24h: parseFloat(crypto.current_price || 0) * 0.95,
            volume24h: parseFloat(crypto.volume_24h || 0)
        }))
        
        // If a crypto is selected from query, select it
        const urlParams = new URLSearchParams(window.location.search)
        const cryptoParam = urlParams.get('crypto')
        if (cryptoParam) {
            const found = tradingPairs.value.find(p => p.symbol === cryptoParam.toUpperCase())
            if (found) {
                await selectTradingPair(found)
            }
        } else if (tradingPairs.value.length > 0) {
            // Load chart for first pair by default
            await selectTradingPair(tradingPairs.value[0])
        }
    } catch (error) {
        console.error('Error loading trading pairs:', error)
    }
}

const cancelOrder = (orderId: string) => {
    const index = openOrders.value.findIndex(order => order.id === orderId)
    if (index !== -1) {
        openOrders.value.splice(index, 1)
    }
}

const cancelAllOrders = () => {
    openOrders.value = []
}

const formatCurrency = (value: number) => {
    if (value >= 1000) {
        return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'EUR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value)
    } else {
        return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'EUR', minimumFractionDigits: 2, maximumFractionDigits: 8 }).format(value)
    }
}

const formatVolume = (value: number) => {
    if (value >= 1000000000) {
        return `${(value / 1000000000).toFixed(2)}B`
    } else if (value >= 1000000) {
        return `${(value / 1000000).toFixed(2)}M`
    } else if (value >= 1000) {
        return `${(value / 1000).toFixed(2)}K`
    }
    return value.toFixed(2)
}

const formatTime = (isoString: string) => {
    const date = new Date(isoString)
    return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' })
}

onMounted(async () => {
    // Load user data
    const user = JSON.parse(localStorage.getItem('user') || '{}')
    userName.value = user.name || 'User'
    
    // Load balance and trading pairs
    await loadBalance()
    await loadTradingPairs()
    
    // Select BTC by default or from query param
    if (tradingPairs.value.length > 0) {
        const urlParams = new URLSearchParams(window.location.search)
        const cryptoParam = urlParams.get('crypto')
        const typeParam = urlParams.get('type')
        
        if (cryptoParam) {
            const found = tradingPairs.value.find(p => p.symbol === cryptoParam.toUpperCase())
            if (found) {
                await selectTradingPair(found)
            }
        } else {
            await selectTradingPair(tradingPairs.value[0])
        }
        
        if (typeParam === 'sell') {
            tradeType.value = 'sell'
        }
    }
})
</script>