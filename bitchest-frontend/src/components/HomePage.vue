<template>
    <div class="min-h-screen bg-background text-text">
        <!-- Navbar -->
        <header
            class="sticky top-0 z-50 bg-background/95 backdrop-blur-md border-b border-gray-200 dark:border-gray-800">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl md:text-3xl font-bold">
                    <span class="text-accent">Bit</span><span class="text-primary dark:text-white">Chest</span>
                </h1>

                <nav class="hidden md:flex gap-8 items-center">
                    <a href="#" class="hover:text-accent transition-colors">Dashboard</a>
                    <a href="#" class="hover:text-accent transition-colors">Market</a>
                    <a href="#" class="hover:text-accent transition-colors">Portfolio</a>
                    <a href="#" class="hover:text-accent transition-colors">Transactions</a>
                </nav>

                <div class="flex items-center gap-4">
                    <button @click="toggleDarkMode"
                        class="p-2 rounded-full border border-gray-300 dark:border-gray-600 hover:bg-primary hover:text-background transition-colors">
                        <span v-if="isDark">🌙</span>
                        <span v-else>☀️</span>
                    </button>
                    <button @click="goToLogin"
                        class="bg-accent text-white px-6 py-2 rounded-full hover:bg-accent/90 transition-colors font-semibold">
                        Sign Up
                    </button>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="pt-20 pb-16">
            <div class="container mx-auto px-6">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-gray-900 dark:text-white">
                        Secure & Intuitive<br>
                        <span class="text-accent">Crypto Trading</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                        Learn how your clients, customers deploying the user for Android from their Android. Create a
                        client with you back.
                    </p>
                    <div class="flex gap-4 justify-center flex-wrap">
                        <button
                            class="bg-accent text-white px-8 py-3 rounded-lg font-semibold hover:bg-accent/90 transition-colors flex items-center gap-2">
                            <span>Start Trading</span>
                        </button>
                        <button
                            class="border-2 border-accent text-accent px-8 py-3 rounded-lg font-semibold hover:bg-accent/10 transition-colors">
                            Learn More
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Buy/Sell Section -->
        <section class="py-12">
            <div class="container mx-auto px-6">
                <div class="max-w-4xl mx-auto buy-sell-bg rounded-2xl shadow-lg p-8">
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                        <!-- Tabs -->
                        <div class="flex gap-8 text-lg font-semibold">
                            <button class="text-green-500 border-b-2 border-green-500 pb-2 transition-colors">
                                Buy
                            </button>
                            <button
                                class="text-gray-500 dark:text-gray-400 hover:text-green-500 transition-colors pb-2">
                                Sell
                            </button>
                        </div>

                        <!-- Exchange Inputs -->
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            <div
                                class="input-box flex items-center justify-between bg-[#38618c1A] rounded-lg px-5 py-4 min-w-[200px]">
                                <span class="text-[#33a7ff]">I Will Spend</span>
                                <span class="flex items-center gap-1 text-green-500 font-medium">₹ INR</span>
                            </div>

                            <span class="text-2xl text-[#33a7ff] transform rotate-90 md:rotate-0">⇄</span>

                            <div
                                class="input-box flex items-center justify-between bg-[#38618c1a] rounded-lg px-5 py-4 min-w-[200px]">
                                <span class="text-[#33a7ff]">I Will Receive</span>
                                <span class="flex items-center gap-1 text-yellow-500 font-medium">₿ BTC</span>
                            </div>

                            <button
                                class="bg-green-500 text-white font-semibold px-8 py-4 rounded-lg hover:bg-green-600 transition-colors whitespace-nowrap">
                                Buy Crypto
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Crypto Market Section -->
        <section class="py-20">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-900 dark:text-white">
                    Crypto Market Trade And Metrics
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[600px]">
                        <thead class="text-[#33a7ff]">
                            <tr>
                                <th class="py-4 px-6 text-left font-semibold">Name</th>
                                <th class="py-4 px-6 text-left font-semibold">Change
                                </th>
                                <th class="py-4 px-6 text-left font-semibold">Price
                                </th>
                                <th class="py-4 px-6 text-right font-semibold">Trade
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="crypto in topCryptos" :key="crypto.symbol" class="border-b">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 from-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ crypto.symbol.charAt(0) }}
                                        </div>
                                        <div>
                                            <h3 class="font-semibold">{{ crypto.name }}
                                            </h3>
                                            <p class="text-sm">{{ crypto.symbol }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td :class="[
                                    'py-4 px-6 font-semibold',
                                    crypto.change >= 0 ? 'text-accent-500' : 'text-secondary-500'
                                ]">
                                    {{ crypto.change >= 0 ? '+' : '' }}{{ crypto.change }}%
                                </td>
                                <td class="py-4 px-6 font-semibold">
                                    ${{ crypto.price.toLocaleString() }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <button
                                        class="text-accent bg-[#] font-semibold py-2 px-6 rounded-full hover:text-accent-600 transition-colors">
                                        Trade
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-center mt-12">
                    <button
                        class="border-2 border-green-500 text-green-500 px-8 py-3 rounded-full font-semibold hover:bg-green-500 hover:text-white transition-colors">
                        View Other Crypto
                    </button>
                </div>
            </div>
        </section>

        <!-- Test Section - Add this temporarily -->
        <div class="p-4 m-4">
            <div class="text-accent-500 bg-accent-500 p-2">Accent 500 Text & BG</div>
            <div class="text-secondary-500 bg-secondary-500 p-2">Secondary 500 Text & BG</div>
            <div class="text-primary-500 bg-primary-500 p-2">Primary 500 Text & BG</div>
        </div>

        <!-- FAQ Section -->
        <section class="py-20">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-4">
                    Frequently Asked Questions
                </h2>
                <p class="text-lg text-center mb-12 max-w-2xl mx-auto">
                    Follow using messages that will be posted on calls by users and customers.
                </p>

                <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
                    <div v-for="(faq, index) in faqs" :key="index" class="p-6">
                        <h3 class="text-lg font-semibold mb-3">{{ faq.question }}</h3>
                        <p class="text-sm">{{ faq.answer }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer CTA -->
        <footer class="bg-[#38618c1a] text-white py-12">
            <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Side: Text + Socials -->
                <div>
                    <h2 class="text-3xl font-heading font-bold text-primary mb-4">
                        Get In On The Crypto Action
                    </h2>
                    <p class="mb-6">
                        Provide easy access to customer support through chatbots or live chat features.
                    </p>

                    <div class="flex gap-4 mt-4">
                        <a href="#"
                            class="w-10 h-10 flex items-center justify-center rounded-full transition bg-[#38618c1a]">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 flex items-center justify-center rounded-full transition bg-[#38618c1a]">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 flex items-center justify-center rounded-full transition bg-[#38618c1a]">
                            <i class="fas fa-paper-plane"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Side: Contact Form -->
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[#33a7ff] mb-2">Email
                            Address</label>
                        <input type="email" placeholder="Enter Email Address"
                            class="email-input w-full px-4 py-3 rounded-lg bg-[#38618c1a] border border-transparent focus:border-accent focus:ring-0" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#33a7ff] mb-2">Your
                            Topic</label>
                        <input type="text" placeholder="Enter Your Topic"
                            class="w-full px-4 py-3 rounded-lg bg-[#38618c1a] border border-transparent focus:border-accent focus:ring-0" />
                    </div>
                    <button type="submit"
                        class="bg-[#00FF19] text-black font-semibold py-3 px-8 rounded-full hover:opacity-90 transition">
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200 dark:border-gray-900 my-10"></div>

            <div class="container mx-auto px-6">
                <div class="grid md:grid-cols-4 gap-8">
                    <!-- Quick Links -->
                    <div>
                        <h4 class="font-bold text-lg mb-4 text-accent">Quick Links</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text">About Us</a></li>
                            <li><a href="#" class="">Features</a></li>
                            <li><a href="#" class="hover:text-accent transition-colors">Career</a></li>
                            <li><a href="#" class="hover:text-accent transition-colors">Contact Us</a></li>
                        </ul>
                    </div>

                    <!-- Help -->
                    <div>
                        <h4 class="font-bold text-lg mb-4 text-accent">Help</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="">Customer Support</a></li>
                            <li><a href="#" class="hover:text-accent transition-colors">Terms & Conditions</a></li>
                            <li><a href="#" class="hover:text-accent transition-colors">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-accent transition-colors">FAQs</a></li>
                        </ul>
                    </div>

                    <!-- Others -->
                    <div>
                        <h4 class="font-bold text-lg mb-4 text-accent">Others</h4>
                        <ul class="space-y-2">
                            <li><a href="#">Start Trading</a></li>
                            <li><a href="#" class="hover:text-accent transition-colors">Earn Free Crypto</a></li>
                            <li><a href="#" class="hover:text-accent transition-colors">Crypto Wallet</a></li>
                            <li><a href="#" class="hover:text-accent transition-colors">Payment Options</a></li>
                        </ul>
                    </div>

                    <!-- Download App -->
                    <div>
                        <h4 class="font-bold text-lg mb-4 text-accent">Download App</h4>
                        <div class="space-y-3">
                            <button
                                class="w-full bg-gray-800 hover:bg-gray-700 text-white py-3 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                <span>App Store</span>
                            </button>
                            <button
                                class="w-full bg-gray-800 hover:bg-gray-700 text-white py-3 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                <span>Google Play</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-700 mt-12 pt-8 text-center text-gray-400">
                    <p>© Copyright 2024, all rights reserved by <span class="text-accent">BitChest</span></p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import '../style.css'

const router = useRouter()
const isDark = ref(false)

const topCryptos = [
    { name: 'Bitcoin', symbol: 'BTC', price: 43250.00, change: 2.34 },
    { name: 'Ethereum', symbol: 'ETH', price: 2580.50, change: 1.87 },
    { name: 'Solana', symbol: 'SOL', price: 98.20, change: -0.45 },
    { name: 'Cardano', symbol: 'ADA', price: 0.52, change: 3.21 }
]

const faqs = [
    {
        question: 'What is cryptocurrency?',
        answer: 'The company has a dedicated account for consumption and efficiency in all cryptocurrencies.'
    },
    {
        question: 'What is a blockchain?',
        answer: 'A secret chain of cryptography and services is available in a blockchain system.'
    },
    {
        question: 'What is a cryptocurrency wallet?',
        answer: 'A cryptocurrency wallet has been running, selling, and executing transactions.'
    },
    {
        question: 'How do I start investing in cryptocurrency?',
        answer: 'The company has a dedicated account for consumption and efficiency in all cryptocurrencies.'
    },
    {
        question: 'How do I keep my cryptocurrency secure?',
        answer: 'The company has a dedicated account for consumption and efficiency in all cryptocurrencies.'
    },
    {
        question: 'What are the main public cryptocurrencies?',
        answer: 'The company has a dedicated account for revenues from our Bitcoin network.'
    }
]

onMounted(() => {
    isDark.value = document.documentElement.classList.contains('dark')
})

function toggleDarkMode() {
    isDark.value = !isDark.value
    document.documentElement.classList.toggle('dark', isDark.value)
}

function goToLogin() {
    if (router && typeof router.push === 'function') {
        router.push('/login')
    }
}
</script>

<style scoped>
/* Custom styles to match the design */
.font-heading {
    font-family: 'Celias', sans-serif;
}

.bg-background {
    background-color: var(--background);
}

.text-text {
    color: var(--text);
}

.text-primary {
    color: var(--primary);
}

.bg-accent {
    background-color: var(--accent);
}

.text-accent {
    color: var(--accent);
}

.buy-sell-bg {
    background-color: var(--buy-sell-bg);
}

/* Smooth transitions for dark mode */
* {
    transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
}
</style>