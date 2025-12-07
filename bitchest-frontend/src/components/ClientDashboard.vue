<template>
    <div class="min-h-screen bg-background text-text">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-background/95 backdrop-blur-md border-b border-primary/30">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl md:text-3xl font-bold">
                    <span class="text-accent">Bit</span><span class="text-primary">Chest</span>
                </h1>
                <div class="flex items-center gap-4">
                    <div class="text-sm font-semibold text-text">
                        Balance: <span class="text-accent">€{{ euroBalance.toFixed(2) }}</span>
                    </div>
                    <button @click="toggleDarkMode"
                        class="p-2 rounded-full border border-primary hover:bg-primary hover:text-background transition-colors">
                        <!-- Replace the emoji with SVGs -->
                        <img v-if="isDark" src="../assets/light_mode.svg" alt="Light Mode" class="w-5 h-5" />
                        <img v-else src="../assets/dark_mode.svg" alt="Dark Mode" class="w-5 h-5" />
                    </button>
                    <div
                        class="w-10 h-10 bg-accent rounded-full flex items-center justify-center text-background font-bold">
                        {{ userInitials }}
                    </div>
                </div>
            </div>
        </header>

        <div class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Left Sidebar - Navigation -->
                <div class="lg:col-span-1 space-y-6">
                    <nav class="bg-background border border-primary/30 rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-text mb-4">NAVIGATION</h3>
                        <div class="space-y-2">
                            <button v-for="item in navigation" :key="item.name" @click="activeSection = item.id" :class="[
                                    'w-full flex items-center gap-3 p-3 rounded-lg transition-colors text-left',
                                    activeSection === item.id 
                                        ? 'bg-accent text-background' 
                                        : 'text-text hover:bg-primary/10'
                                ]">
                                <span>{{ item.icon }}</span>
                                <span>{{ item.name }}</span>
                            </button>
                        </div>
                    </nav>

                    <!-- Profile Section -->
                    <div class="bg-background border border-primary/30 rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-text mb-4">PROFILE</h3>
                        <button @click="showProfileModal = true"
                            class="w-full text-left p-3 rounded-lg hover:bg-primary/10 transition-colors text-text">
                            Edit Personal Information
                        </button>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- Wallet Section -->
                    <div v-if="activeSection === 'wallet'" class="space-y-6">
                        <div class="bg-background border border-primary/30 rounded-2xl shadow-lg p-6">
                            <h2 class="text-2xl font-bold text-text mb-6">My Wallet</h2>

                            <!-- Euro Balance (Always Visible) -->
                            <div class="mb-6 p-4 bg-accent/10 rounded-lg border border-accent/30">
                                <p class="text-sm text-text/70 mb-1">Current Euro Balance</p>
                                <p class="text-3xl font-bold text-accent">€{{ euroBalance.toFixed(2) }}</p>
                            </div>

                            <!-- Cryptocurrency Holdings -->
                            <div v-if="wallets.length > 0" class="space-y-4">
                                <h3 class="text-lg font-semibold text-text mb-4">Cryptocurrency Holdings</h3>
                                <div v-for="wallet in wallets" :key="wallet.id"
                                    class="p-4 border border-primary/30 rounded-lg hover:border-accent/50 transition-colors">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="font-bold text-lg text-text">{{ wallet.crypto_name }} ({{
                                                wallet.crypto_symbol }})</h4>
                                            <p class="text-sm text-text/70">Amount: {{ wallet.amount }}</p>
                                            <p class="text-sm text-text/70">Average Purchase Price: €{{
                                                wallet.average_purchase_price }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-text">€{{ wallet.total_value.toFixed(2) }}</p>
                                            <p :class="[
                                                'text-sm font-semibold',
                                                wallet.profit_loss >= 0 ? 'text-accent' : 'text-secondary'
                                            ]">
                                                {{ wallet.profit_loss >= 0 ? '+' : '' }}{{ wallet.profit_loss.toFixed(2)
                                                }}
                                                ({{ wallet.profit_loss >= 0 ? '+' : '' }}{{
                                                wallet.profit_loss_percentage.toFixed(2) }}%)
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Purchase History -->
                                    <div class="mt-4 pt-4 border-t border-primary/20">
                                        <h5 class="text-sm font-semibold text-text mb-2">Purchase History</h5>
                                        <div class="space-y-2">
                                            <div v-for="(purchase, idx) in wallet.purchase_history" :key="idx"
                                                class="flex justify-between text-xs text-text/70">
                                                <span>{{ purchase.date }}</span>
                                                <span>{{ purchase.quantity }} @ €{{ purchase.purchase_price }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sell Button -->
                                    <button @click="openSellModal(wallet)"
                                        class="mt-4 w-full bg-secondary text-background font-semibold py-2 px-4 rounded-lg hover:bg-secondary/90 transition-colors">
                                        Sell {{ wallet.crypto_symbol }}
                                    </button>
                                </div>
                            </div>
                            <div v-else class="text-center py-8 text-text/70">
                                <p>No cryptocurrency holdings yet. Start by buying some crypto!</p>
                            </div>
                        </div>
                    </div>

                    <!-- Market Section -->
                    <div v-if="activeSection === 'market'" class="space-y-6">
                        <div class="bg-background border border-primary/30 rounded-2xl shadow-lg p-6">
                            <h2 class="text-2xl font-bold text-text mb-6">Cryptocurrency Market</h2>

                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="border-b border-primary/30">
                                            <th class="text-left py-3 px-4 text-text font-semibold">Name</th>
                                            <th class="text-left py-3 px-4 text-text font-semibold">Symbol</th>
                                            <th class="text-left py-3 px-4 text-text font-semibold">Price</th>
                                            <th class="text-left py-3 px-4 text-text font-semibold">24h Change</th>
                                            <th class="text-right py-3 px-4 text-text font-semibold">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="crypto in cryptocurrencies" :key="crypto.symbol"
                                            class="border-b border-primary/10 hover:bg-primary/5 transition-colors">
                                            <td class="py-3 px-4">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-accent flex items-center justify-center text-background font-bold">
                                                        {{ crypto.symbol.charAt(0) }}
                                                    </div>
                                                    <span class="font-semibold text-text">{{ crypto.name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 text-text/70">{{ crypto.symbol }}</td>
                                            <td class="py-3 px-4 font-semibold text-text">€{{ crypto.current_price }}
                                            </td>
                                            <td :class="[
                                                'py-3 px-4 font-semibold',
                                                crypto.price_change_percentage_24h >= 0 ? 'text-accent' : 'text-secondary'
                                            ]">
                                                {{ crypto.price_change_percentage_24h >= 0 ? '+' : '' }}{{
                                                crypto.price_change_percentage_24h }}%
                                            </td>
                                            <td class="py-3 px-4 text-right">
                                                <button @click="openBuyModal(crypto)"
                                                    class="bg-accent text-background font-semibold py-2 px-4 rounded-lg hover:bg-accent/90 transition-colors mr-2">
                                                    Buy
                                                </button>
                                                <button @click="viewChart(crypto.symbol)"
                                                    class="bg-primary text-background font-semibold py-2 px-4 rounded-lg hover:bg-primary/90 transition-colors">
                                                    Chart
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Transactions Section -->
                    <div v-if="activeSection === 'transactions'" class="space-y-6">
                        <div class="bg-background border border-primary/30 rounded-2xl shadow-lg p-6">
                            <h2 class="text-2xl font-bold text-text mb-6">Transaction History</h2>
                            <div class="space-y-3">
                                <div v-for="transaction in transactions" :key="transaction.id"
                                    class="flex items-center justify-between p-4 border border-primary/20 rounded-lg hover:bg-primary/5 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div :class="[
                                            'w-10 h-10 rounded-full flex items-center justify-center font-bold',
                                            transaction.type === 'buy' ? 'bg-accent/20 text-accent' : 'bg-secondary/20 text-secondary'
                                        ]">
                                            {{ transaction.type === 'buy' ? '↗' : '↘' }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-text">
                                                {{ transaction.type === 'buy' ? 'Bought' : 'Sold' }} {{
                                                transaction.crypto_name }}
                                            </h4>
                                            <p class="text-sm text-text/70">{{ new
                                                Date(transaction.created_at).toLocaleString() }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-text">{{ transaction.amount }} {{
                                            transaction.crypto_symbol }}</p>
                                        <p class="text-sm text-text/70">€{{ transaction.total }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buy Modal -->
        <div v-if="showBuyModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
            @click.self="showBuyModal = false">
            <div class="bg-background border border-primary/30 rounded-2xl shadow-xl p-6 max-w-md w-full mx-4">
                <h3 class="text-xl font-bold text-text mb-4">Buy {{ selectedCrypto?.name }}</h3>
                <form @submit.prevent="handleBuy" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-text mb-2">Amount</label>
                        <input v-model.number="buyAmount" type="number" step="0.00000001" min="0.00000001" required
                            class="w-full rounded-lg border border-primary/30 px-4 py-2 bg-background text-text focus:border-accent focus:outline-none"
                            placeholder="Enter amount" />
                        <p class="text-xs text-text/70 mt-1">
                            Price: €{{ selectedCrypto?.current_price }} per {{ selectedCrypto?.symbol }}
                        </p>
                        <p class="text-sm text-text mt-2">
                            Total: €{{ buyTotal.toFixed(2) }}
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" :disabled="isLoading || buyTotal > euroBalance"
                            class="flex-1 bg-accent text-background font-semibold py-2 px-4 rounded-lg hover:bg-accent/90 transition-colors disabled:opacity-50">
                            {{ isLoading ? 'Processing...' : 'Buy' }}
                        </button>
                        <button type="button" @click="showBuyModal = false"
                            class="flex-1 bg-primary/20 text-text font-semibold py-2 px-4 rounded-lg hover:bg-primary/30 transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sell Modal -->
        <div v-if="showSellModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
            @click.self="showSellModal = false">
            <div class="bg-background border border-primary/30 rounded-2xl shadow-xl p-6 max-w-md w-full mx-4">
                <h3 class="text-xl font-bold text-text mb-4">Sell {{ selectedWallet?.crypto_symbol }}</h3>
                <form @submit.prevent="handleSell" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-text mb-2">Amount (Max: {{ selectedWallet?.amount
                            }})</label>
                        <input v-model.number="sellAmount" type="number" step="0.00000001" :max="selectedWallet?.amount"
                            min="0.00000001" required
                            class="w-full rounded-lg border border-primary/30 px-4 py-2 bg-background text-text focus:border-accent focus:outline-none"
                            placeholder="Enter amount" />
                        <p class="text-xs text-text/70 mt-1">
                            Current Price: €{{ selectedWallet?.current_price }} per {{ selectedWallet?.crypto_symbol }}
                        </p>
                        <p class="text-sm text-text mt-2">
                            Total: €{{ sellTotal.toFixed(2) }}
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" :disabled="isLoading || sellAmount > selectedWallet?.amount"
                            class="flex-1 bg-secondary text-background font-semibold py-2 px-4 rounded-lg hover:bg-secondary/90 transition-colors disabled:opacity-50">
                            {{ isLoading ? 'Processing...' : 'Sell' }}
                        </button>
                        <button type="button" @click="showSellModal = false"
                            class="flex-1 bg-primary/20 text-text font-semibold py-2 px-4 rounded-lg hover:bg-primary/30 transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Profile Modal -->
        <div v-if="showProfileModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
            @click.self="showProfileModal = false">
            <div class="bg-background border border-primary/30 rounded-2xl shadow-xl p-6 max-w-md w-full mx-4">
                <h3 class="text-xl font-bold text-text mb-4">Edit Personal Information</h3>
                <form @submit.prevent="handleProfileUpdate" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-text mb-2">Name</label>
                        <input v-model="profileData.name" type="text" required
                            class="w-full rounded-lg border border-primary/30 px-4 py-2 bg-background text-text focus:border-accent focus:outline-none" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text mb-2">Email</label>
                        <input v-model="profileData.email" type="email" required
                            class="w-full rounded-lg border border-primary/30 px-4 py-2 bg-background text-text focus:border-accent focus:outline-none" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text mb-2">Phone</label>
                        <input v-model="profileData.phone" type="tel"
                            class="w-full rounded-lg border border-primary/30 px-4 py-2 bg-background text-text focus:border-accent focus:outline-none" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text mb-2">Address</label>
                        <textarea v-model="profileData.address" rows="3"
                            class="w-full rounded-lg border border-primary/30 px-4 py-2 bg-background text-text focus:border-accent focus:outline-none"></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" :disabled="isLoading"
                            class="flex-1 bg-accent text-background font-semibold py-2 px-4 rounded-lg hover:bg-accent/90 transition-colors disabled:opacity-50">
                            {{ isLoading ? 'Saving...' : 'Save' }}
                        </button>
                        <button type="button" @click="showProfileModal = false"
                            class="flex-1 bg-primary/20 text-text font-semibold py-2 px-4 rounded-lg hover:bg-primary/30 transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Price Chart Modal -->
        <div v-if="showChartModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
            @click.self="showChartModal = false">
            <div
                class="bg-background border border-primary/30 rounded-2xl shadow-xl p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-text">Price Chart - {{ chartCrypto?.name }}</h3>
                    <button @click="showChartModal = false" class="text-text/70 hover:text-text">✕</button>
                </div>
                <PriceChart :symbol="chartSymbol" :priceHistory="chartPriceHistory" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { walletAPI, marketAPI, transactionAPI, profileAPI, priceHistoryAPI, authAPI } from '../services/api'
import PriceChart from './PriceChart.vue'

const router = useRouter()
const isDark = ref(false)
const activeSection = ref('wallet')
const isLoading = ref(false)

// User data
const user = ref(null)
const euroBalance = ref(0)
const userInitials = computed(() => {
    if (!user.value?.name) return 'U'
    return user.value.name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
})

// Wallet data
const wallets = ref([])

// Market data
const cryptocurrencies = ref([])

// Transactions
const transactions = ref([])

// Modals
const showBuyModal = ref(false)
const showSellModal = ref(false)
const showProfileModal = ref(false)
const showChartModal = ref(false)
const selectedCrypto = ref(null)
const selectedWallet = ref(null)
const buyAmount = ref(0)
const sellAmount = ref(0)
const chartSymbol = ref('')
const chartCrypto = ref(null)
const chartPriceHistory = ref([])

// Profile data
const profileData = ref({
    name: '',
    email: '',
    phone: '',
    address: '',
})

// Navigation
const navigation = [
    { id: 'wallet', name: 'Wallet', icon: '💰' },
    { id: 'market', name: 'Market', icon: '📊' },
    { id: 'transactions', name: 'Transactions', icon: '📝' },
]

// Computed
const buyTotal = computed(() => {
    if (!selectedCrypto.value || !buyAmount.value) return 0
    return buyAmount.value * selectedCrypto.value.current_price
})

const sellTotal = computed(() => {
    if (!selectedWallet.value || !sellAmount.value) return 0
    return sellAmount.value * selectedWallet.value.current_price
})

// Methods
const loadUserData = async () => {
    try {
        const userData = await authAPI.me()
        user.value = userData.user
        profileData.value = {
            name: userData.user.name || '',
            email: userData.user.email || '',
            phone: userData.user.phone || '',
            address: userData.user.address || '',
        }
        euroBalance.value = parseFloat(userData.user.balance || 0)
    } catch (error) {
        console.error('Failed to load user data:', error)
    }
}

const loadWallet = async () => {
    try {
        const data = await walletAPI.getWallet()
        wallets.value = data.wallets || []
        euroBalance.value = parseFloat(data.euro_balance || 0)
    } catch (error) {
        console.error('Failed to load wallet:', error)
    }
}

const loadMarket = async () => {
    try {
        const data = await marketAPI.getAll()
        cryptocurrencies.value = data.cryptos || []
    } catch (error) {
        console.error('Failed to load market data:', error)
    }
}

const loadTransactions = async () => {
    try {
        const data = await transactionAPI.getAll()
        transactions.value = data.data || []
    } catch (error) {
        console.error('Failed to load transactions:', error)
    }
}

const openBuyModal = (crypto) => {
    selectedCrypto.value = crypto
    buyAmount.value = 0
    showBuyModal.value = true
}

const openSellModal = (wallet) => {
    selectedWallet.value = wallet
    sellAmount.value = 0
    showSellModal.value = true
}

const handleBuy = async () => {
    if (!selectedCrypto.value || buyTotal.value > euroBalance.value) return
    
    isLoading.value = true
    try {
        await transactionAPI.create('buy', selectedCrypto.value.symbol, buyAmount.value)
        showBuyModal.value = false
        await loadWallet()
        await loadTransactions()
        await loadUserData()
    } catch (error) {
        alert(error.message || 'Failed to complete purchase')
    } finally {
        isLoading.value = false
    }
}

const handleSell = async () => {
    if (!selectedWallet.value || sellAmount.value > selectedWallet.value.amount) return
    
    isLoading.value = true
    try {
        await walletAPI.sell(selectedWallet.value.crypto_symbol, sellAmount.value)
        showSellModal.value = false
        await loadWallet()
        await loadTransactions()
        await loadUserData()
    } catch (error) {
        alert(error.message || 'Failed to complete sale')
    } finally {
        isLoading.value = false
    }
}

const handleProfileUpdate = async () => {
    isLoading.value = true
    try {
        await profileAPI.update(profileData.value)
        showProfileModal.value = false
        await loadUserData()
    } catch (error) {
        alert(error.message || 'Failed to update profile')
    } finally {
        isLoading.value = false
    }
}

const viewChart = async (symbol) => {
    chartSymbol.value = symbol
    try {
        const data = await priceHistoryAPI.getBySymbol(symbol)
        chartCrypto.value = data.crypto
        chartPriceHistory.value = data.price_history || []
        showChartModal.value = true
    } catch (error) {
        console.error('Failed to load price history:', error)
    }
}

const toggleDarkMode = () => {
    isDark.value = !isDark.value
    document.documentElement.classList.toggle('dark', isDark.value)
}

onMounted(async () => {
    isDark.value = document.documentElement.classList.contains('dark')
    await loadUserData()
    await loadWallet()
    await loadMarket()
    await loadTransactions()
})
</script>

<style scoped>
/* Additional styles */
</style>

