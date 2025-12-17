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

                    <div class="flex items-center gap-4 px-4 py-3 rounded-lg cursor-pointer relative group"
                        :class="isDark ? 'text-[#0074CC] bg-[#0F1A27]' : 'text-[#0074CC] bg-blue-50'">
                        <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
                        <span class="text-sm font-medium">Wallet</span>
                    </div>

                    <router-link to="/messages"
                        class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors relative group"
                        :class="isDark ? 'text-[#749DC8] hover:text-[#0074CC]' : 'text-slate-600 hover:text-[#0074CC]'">
                        <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
                        <span class="text-sm font-medium">Messages</span>
                        <div class="absolute right-4 w-2 h-2 rounded-full bg-[#A8000B]"></div>
                    </router-link>

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
                                <h1 class="text-3xl font-bold" :class="isDark ? 'text-white' : 'text-slate-900'">Wallet
                                </h1>
                                <p class="text-sm mt-1" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Manage
                                    your cryptocurrency portfolio</p>
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

                    <!-- Wallet Content -->
                    <main class="p-8">
                        <!-- Balance Summary -->
                        <div class="mb-8">
                            <h2 class="text-xs font-semibold uppercase tracking-widest mb-4"
                                :class="isDark ? 'text-[#B1AFCD]' : 'text-slate-600'">
                                Balance Summary
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="rounded-xl p-6 border"
                                    :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                    <div class="text-sm mb-2" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                        Total Balance</div>
                                    <div class="text-2xl font-bold" :class="isDark ? 'text-white' : 'text-slate-900'">{{
                                        formatCurrency(totalBalance) }}</div>
                                </div>
                                <div class="rounded-xl p-6 border"
                                    :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                    <div class="text-sm mb-2" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">24h
                                        Change</div>
                                    <div
                                        :class="['text-xl font-bold', dailyChange >= 0 ? 'text-[#00FF19]' : 'text-[#A8000B]']">
                                        {{ dailyChange >= 0 ? '+' : '' }}{{ dailyChange.toFixed(2) }}%
                                    </div>
                                </div>
                                <div class="rounded-xl p-6 border"
                                    :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                    <div class="text-sm mb-2" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                        Available EUR</div>
                                    <div class="text-2xl font-bold text-[#00FF19]">{{ formatCurrency(availableEUR) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cryptocurrency Holdings -->
                        <div class="mb-8">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xs font-semibold uppercase tracking-widest"
                                    :class="isDark ? 'text-[#B1AFCD]' : 'text-slate-600'">
                                    Cryptocurrency Holdings
                                </h2>
                                <button @click="showAddCryptoModal = true"
                                    class="text-xs text-[#0074CC] hover:underline">Add Cryptocurrency</button>
                            </div>

                            <div class="overflow-x-auto rounded-xl border"
                                :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                <table class="w-full">
                                    <thead :class="isDark ? 'bg-[#0F1A27]' : 'bg-slate-50'">
                                        <tr>
                                            <th class="py-4 px-6 text-left text-xs font-semibold"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Asset</th>
                                            <th class="py-4 px-6 text-left text-xs font-semibold"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Balance</th>
                                            <th class="py-4 px-6 text-left text-xs font-semibold"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Price</th>
                                            <th class="py-4 px-6 text-left text-xs font-semibold"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Value</th>
                                            <th class="py-4 px-6 text-left text-xs font-semibold"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">24h Change</th>
                                            <th class="py-4 px-6 text-left text-xs font-semibold"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="crypto in cryptocurrencyHoldings" :key="crypto.symbol"
                                            class="border-t" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                            <td class="py-4 px-6">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold"
                                                        :style="{ backgroundColor: crypto.color }">
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
                                            <td class="py-4 px-6">
                                                <div class="font-medium"
                                                    :class="isDark ? 'text-white' : 'text-slate-900'">{{ crypto.balance
                                                    }}</div>
                                                <div class="text-xs"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{
                                                    formatCurrency(crypto.balance * crypto.price) }}</div>
                                            </td>
                                            <td class="py-4 px-6 font-medium"
                                                :class="isDark ? 'text-white' : 'text-slate-900'">
                                                {{ formatCurrency(crypto.price) }}
                                            </td>
                                            <td class="py-4 px-6 font-medium"
                                                :class="isDark ? 'text-white' : 'text-slate-900'">
                                                {{ formatCurrency(crypto.value) }}
                                            </td>
                                            <td class="py-4 px-6">
                                                <div
                                                    :class="['font-medium', crypto.change24h >= 0 ? 'text-[#00FF19]' : 'text-[#A8000B]']">
                                                    {{ crypto.change24h >= 0 ? '+' : '' }}{{ crypto.change24h }}%
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">
                                                <div class="flex gap-2">
                                                    <button @click="tradeCrypto(crypto, 'buy')"
                                                        class="px-3 py-1 text-xs rounded bg-[#00FF19] text-white hover:opacity-90 transition-opacity">
                                                        Buy
                                                    </button>
                                                    <button @click="tradeCrypto(crypto, 'sell')"
                                                        class="px-3 py-1 text-xs rounded bg-[#A8000B] text-white hover:opacity-90 transition-opacity">
                                                        Sell
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Recent Transactions -->
                        <div>
                            <h2 class="text-xs font-semibold uppercase tracking-widest mb-4"
                                :class="isDark ? 'text-[#B1AFCD]' : 'text-slate-600'">
                                Recent Transactions
                            </h2>
                            <div class="space-y-3">
                                <div v-for="transaction in recentTransactions" :key="transaction.id"
                                    class="p-4 rounded-xl border"
                                    :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div :class="[
                                                'w-10 h-10 rounded-full flex items-center justify-center',
                                                transaction.type === 'buy' ? 'bg-green-100 dark:bg-green-900' : 'bg-red-100 dark:bg-red-900'
                                            ]">
                                                <svg class="w-5 h-5"
                                                    :class="transaction.type === 'buy' ? 'text-green-600 dark:text-green-300' : 'text-red-600 dark:text-red-300'"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path v-if="transaction.type === 'buy'"
                                                        d="M12 5V19M12 5L6 11M12 5L18 11" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path v-if="transaction.type === 'sell'"
                                                        d="M12 5V19M12 19L6 13M12 19L18 13" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-medium"
                                                    :class="isDark ? 'text-white' : 'text-slate-900'">
                                                    {{ transaction.type === 'buy' ? 'Bought' : 'Sold' }} {{
                                                    transaction.amount }} {{ transaction.symbol }}
                                                </div>
                                                <div class="text-xs"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{
                                                    formatDate(transaction.date) }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-medium" :class="isDark ? 'text-white' : 'text-slate-900'">
                                                {{ formatCurrency(transaction.value) }}
                                            </div>
                                            <div
                                                :class="['text-xs', transaction.type === 'buy' ? 'text-[#00FF19]' : 'text-[#A8000B]']">
                                                {{ transaction.type === 'buy' ? '-' : '+' }}{{
                                                formatCurrency(transaction.fee) }} fee
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>

            <!-- Add Cryptocurrency Modal -->
            <div v-if="showAddCryptoModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white dark:bg-[#0F1A27] rounded-xl p-6 w-full max-w-md">
                    <h3 class="text-lg font-bold mb-4 dark:text-white">Add Cryptocurrency</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm mb-2 dark:text-[#749DC8]">Select Cryptocurrency</label>
                            <select v-model="selectedCrypto"
                                class="w-full px-4 py-2 rounded-lg border dark:bg-[#1A2A3A] dark:border-[#2A3A4A] dark:text-white">
                                <option v-for="crypto in availableCryptos" :key="crypto.symbol" :value="crypto">
                                    {{ crypto.name }} ({{ crypto.symbol }})
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm mb-2 dark:text-[#749DC8]">Amount</label>
                            <input v-model="addAmount" type="number" step="0.000001"
                                class="w-full px-4 py-2 rounded-lg border dark:bg-[#1A2A3A] dark:border-[#2A3A4A] dark:text-white" />
                        </div>
                        <div class="flex gap-3 justify-end">
                            <button @click="showAddCryptoModal = false"
                                class="px-4 py-2 text-sm rounded-lg border hover:bg-gray-100 dark:hover:bg-[#1A2A3A] dark:text-[#749DC8]">
                                Cancel
                            </button>
                            <button @click="addCryptocurrency"
                                class="px-4 py-2 text-sm rounded-lg bg-[#00FF19] text-white hover:opacity-90">
                                Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const isDark = ref(false)
const showAddCryptoModal = ref(false)
const selectedCrypto = ref<any>(null)
const addAmount = ref('')

const userName = ref('John Doe')
const totalBalance = ref(45678.90)
const dailyChange = ref(2.34)
const availableEUR = ref(2500.00)

const cryptocurrencyHoldings = ref([
    { symbol: 'BTC', name: 'Bitcoin', balance: 1.5, price: 43250, value: 64875, change24h: 2.34, color: '#F7931A' },
    { symbol: 'ETH', name: 'Ethereum', balance: 8.2, price: 2580.5, value: 21160.1, change24h: 1.87, color: '#627EEA' },
    { symbol: 'ADA', name: 'Cardano', balance: 1500, price: 0.52, value: 780, change24h: 3.21, color: '#0033AD' },
    { symbol: 'SOL', name: 'Solana', balance: 25, price: 98.2, value: 2455, change24h: -0.45, color: '#00FFA3' },
])

const recentTransactions = ref([
    { id: 1, type: 'buy', symbol: 'BTC', amount: 0.1, value: 4325, fee: 21.63, date: '2024-01-15T10:30:00' },
    { id: 2, type: 'sell', symbol: 'ETH', amount: 2, value: 5161, fee: 25.81, date: '2024-01-14T14:20:00' },
    { id: 3, type: 'buy', symbol: 'ADA', amount: 500, value: 260, fee: 1.3, date: '2024-01-13T09:15:00' },
    { id: 4, type: 'buy', symbol: 'SOL', amount: 10, value: 982, fee: 4.91, date: '2024-01-12T16:45:00' },
])

const availableCryptos = ref([
    { symbol: 'XRP', name: 'Ripple', price: 0.62 },
    { symbol: 'LTC', name: 'Litecoin', price: 71.25 },
    { symbol: 'DOGE', name: 'Dogecoin', price: 0.085 },
    { symbol: 'DOT', name: 'Polkadot', price: 7.89 },
])

const toggleTheme = () => {
    isDark.value = !isDark.value
}

const logout = () => {
    router.push('/login')
}

const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'EUR' }).format(value)
}

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

const tradeCrypto = (crypto: any, type: 'buy' | 'sell') => {
    router.push({
        path: '/trade',
        query: { crypto: crypto.symbol, type }
    })
}

const addCryptocurrency = () => {
    if (selectedCrypto.value && parseFloat(addAmount.value) > 0) {
        const amount = parseFloat(addAmount.value)
        const crypto = selectedCrypto.value
        const existing = cryptocurrencyHoldings.value.find(c => c.symbol === crypto.symbol)

        if (existing) {
            existing.balance += amount
            existing.value = existing.balance * existing.price
        } else {
            cryptocurrencyHoldings.value.push({
                symbol: crypto.symbol,
                name: crypto.name,
                balance: amount,
                price: crypto.price,
                value: amount * crypto.price,
                change24h: 0,
                color: getCryptoColor(crypto.symbol)
            })
        }

        showAddCryptoModal.value = false
        selectedCrypto.value = null
        addAmount.value = ''
    }
}

const getCryptoColor = (symbol: string) => {
    const colors: Record<string, string> = {
        BTC: '#F7931A',
        ETH: '#627EEA',
        ADA: '#0033AD',
        SOL: '#00FFA3',
        XRP: '#23292F',
        LTC: '#BFBBBB',
        DOGE: '#C2A633',
        DOT: '#E6007A'
    }
    return colors[symbol] || '#0074CC'
}
</script>