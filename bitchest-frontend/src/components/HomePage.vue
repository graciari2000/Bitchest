<template>
    <div class="min-h-screen bg-background text-text">
        <!-- Navbar -->
        <header class="sticky top-0 z-50 var(--background) backdrop-blur-md border-b border-primary/30">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl md:text-3xl font-heading font-bold text"><span class="colored-text">Bit</span>Chest
                </h1>

                <nav class="hidden md:flex gap-8 font-body items-center">
                    <a href="#">Dashboard</a>
                    <a href="#">Market</a>
                    <a href="#">Portfolio</a>
                    <a href="#">Transactions</a>
                </nav>

                <div class="flex items-center gap-4">
                    <button @click="toggleDarkMode"
                        class="p-2 rounded-full border border-primary hover:bg-primary hover:text-background">
                        <span v-if="isDark">🌙</span>
                        <span v-else>☀️</span>
                    </button>
                    <button @click="goToLogin"
                        class="bg-accent text-background px-4 py-2 rounded-lg hover:accent/90 login-button">
                        Sign Up
                    </button>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative pt-20 pb-32">


            <div class="relative z-10 container mx-auto px-6">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="text-5xl md:text-6xl font-heading font-bold mb-6)">
                        Secure & Intuitive
                        <span class="">Crypto Trading</span>
                    </h1>
                    <p class="text-xl mb-8 text-text/80">
                        Start trading Bitcoin, Ethereum and other cryptocurrencies using our advanced trading tools
                    </p>
                    <div class="flex gap-4 justify-center">
                        <button class="bg-accent text-background px-6 py-3 rounded-lg font-bold hero-button-one">
                            Get Started
                        </button>
                        <button class="border border-primary text-text px-6 py-3 rounded-lg font-bold hero-button-two">
                            Start Trading
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="buy-sell container mx-auto my-10 p-8 rounded-2xl bg-[#38618c1b] shadow-md">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">

                <!-- Tabs -->
                <div class="flex gap-8 text-xl font-semibold mb-6 md:mb-0">
                    <button class="text-green-500 border-b-2 border-green-500 pb-1 transition hover:text-green-600">
                        Buy
                    </button>
                    <button class="text-gray-600 dark:text-gray-300 hover:text-green-400 transition">
                        Sell
                    </button>
                </div>

                <!-- Exchange Inputs -->
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <div
                        class="input-box flex items-center justify-between bg-[#38618c1a] rounded-lg px-5 py-3 min-w-[220px]">
                        <span>I Will Spend</span>
                        <span class="flex items-center gap-1 text-green-500 font-medium">₹ Rupee</span>
                    </div>

                    <span class="text-2xl [#00cc14]">⇄</span>

                    <div
                        class="input-box flex items-center justify-between bg-[#38618c1a] rounded-lg px-5 py-3 min-w-[220px]">
                        <span>I Will Receive</span>
                        <span class="flex items-center gap-1 text-yellow-500 font-medium">₿ BTC</span>
                    </div>

                    <!-- Button -->
                    <button
                        class="bg-[#00ff19] hover:bg-green-600 font-semibold text-[#ffffff] px-6 py-3 rounded-lg transition">
                        Buy Crypto
                    </button>
                </div>
            </div>
        </section>

        <section class="py-20">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-heading font-bold text-center mb-12 text-primary dark:text-white">
                    Crypto Market Trade And Metrics
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-separate border-spacing-y-4">
                        <thead>
                            <tr class="">
                                <th class="py-2 px-4">Name</th>
                                <th class="py-2 px-4">Change</th>
                                <th class="py-2 px-4">Price</th>
                                <th class="py-2 px-4">Chart</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="crypto in topCryptos" :key="crypto.symbol"
                                class="rounded-xl shadow-sm hover:shadow-md transition-all">
                                <!-- Coin -->
                                <td class="flex items-center gap-4 py-4 px-4">
                                    <img :src="crypto.icon" :alt="crypto.name" class="w-10 h-10 rounded-full" />
                                    <div>
                                        <h3 class="font-bold">{{ crypto.name }}</h3>
                                        <p class="text-sm">INR</p>
                                    </div>
                                </td>

                                <!-- Change -->
                                <td :class="[
                                    'font-semibold text-sm',
                                    crypto.change >= 0 ? 'text-green-500' : 'text-red-500'
                                ]">
                                    {{ crypto.change >= 0 ? '+' : '' }}{{ crypto.change }}%
                                </td>

                                <!-- Price -->
                                <td class="font-medium">
                                    {{ crypto.price.toLocaleString() }} INR
                                </td>

                                <!-- Trade Button -->
                                <td class="text-right">
                                    <button
                                        class="--bg-green-100 text-[] font-semibold py-2 px-6 rounded-full hover: --bg-green-200">
                                        Trade
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-center mt-10">
                    <button
                        class="border border-green-400 bg-green-100 text-[#00ff19] px-10 py-3 rounded-full font-semibold hover:bg-green-200 transition">
                        View Other Crypto
                    </button>
                </div>
            </div>
        </section>
        <section class="faq">
            <div class="container mx-auto px-6 py-20">
                <h2 class="text-3xl font-heading text-center mb-12">
                    Frequently Asked Questions
                </h2>

                <div class="grid md:grid-cols-2 gap-8">
                    <div v-for="feature in features" :key="feature.title"
                        class="p-6 rounded-lg shadow-md hover:shadow-lg transition">
                        <div class="text-4xl mb-4">{{ feature.icon }}</div>
                        <h3 class="text-xl font-semibold mb-2">{{ feature.title }}</h3>
                        <p class="text-text/80">{{ feature.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer CTA -->
        <footer id="faq">
            <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Side: Text + Socials -->
                <div>
                    <h2 class="text-3xl font-heading font-bold text-primary dark:text-white mb-4">
                        Get In On The Crypto Action
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
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
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Email
                            Address</label>
                        <input type="email" placeholder="Enter Email Address"
                            class="email-input w-full px-4 py-3 rounded-lg bg-[#38618c1a] border border-transparent focus:border-accent focus:ring-0" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Your
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
            <div class="border-t border-gray-200 dark:border-gray-700 my-10"></div>

            <!-- Footer Links -->
            <div class="container mx-auto px-6 grid md:grid-cols-4 gap-8 text-gray-600 dark:text-gray-400">
                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-primary dark:text-white mb-3">Quick Link</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-accent">About Us</a></li>
                        <li><a href="#" class="hover:text-accent">Feature</a></li>
                        <li><a href="#" class="hover:text-accent">Career</a></li>
                        <li><a href="#" class="hover:text-accent">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Help -->
                <div>
                    <h4 class="font-bold text-primary dark:text-white mb-3">Help</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-accent">Customer Support</a></li>
                        <li><a href="#" class="hover:text-accent">Terms</a></li>
                        <li><a href="#" class="hover:text-accent">Privacy</a></li>
                        <li><a href="#faq" class="hover:text-accent">FAQs</a></li>
                    </ul>
                </div>

                <!-- Others -->
                <div>
                    <h4 class="font-bold text-primary dark:text-white mb-3">Others</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-accent">Start Trading</a></li>
                        <li><a href="#" class="hover:text-accent">Earn Free Crypto</a></li>
                        <li><a href="#" class="hover:text-accent">Crypto Wallet</a></li>
                        <li><a href="#" class="hover:text-accent">Payment Option</a></li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="text-center text-sm text-gray-500 dark:text-gray-500 mt-10">
                © Copyright 2024, all rights reserved by <span class="text-primary dark:text-white"></span>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import HeroPattern from './HeroPattern.vue'
import { useRouter } from 'vue-router';

const router = useRouter();

const isDark = ref(false)

const topCryptos = [
    { name: 'Bitcoin', symbol: 'BTC', price: '43,250.00', change: 2.34 },
    { name: 'Ethereum', symbol: 'ETH', price: '2,580.50', change: 1.87 },
    { name: 'Solana', symbol: 'SOL', price: '98.20', change: -0.45 },
    { name: 'Cardano', symbol: 'ADA', price: '0.52', change: 3.21 }
]

const features = [
    {
        title: 'What is Cryptocurrency?',
        description: 'Stay ahead of the market with real-time cryptocurrency price updates and advanced charting tools.'
    },
    {
        title: 'Secure Portfolio',
        description: 'Track your holdings and profits securely with encrypted APIs and enterprise-grade security.'
    },
    {
        title: 'Modern Interface',
        description: 'Enjoy a seamless, responsive dashboard that adapts to your theme and works on any device.'
    },
    {
        title: '24/7 Support',
        description: 'Get assistance whenever you need it with our dedicated support team available around the clock.'
    },
    {
        title: 'Advanced Tools',
        description: 'Utilize cutting-edge trading tools and analytics to make informed investment decisions.'
    },
    {
        title: 'Easy Onboarding',
        description: 'Get started quickly with our user-friendly registration process and intuitive platform design.'
    }
]

onMounted(() => {
    isDark.value = document.documentElement.classList.contains('dark')
})

function toggleDarkMode() {
    isDark.value = !isDark.value
    if (isDark.value) {
        document.documentElement.classList.add('dark')
    } else {
        document.documentElement.classList.remove('dark')
    }
}

function goToLogin() {
    // guard against undefined router to avoid runtime exception
    if (!router || typeof router.push !== 'function') {
        console.warn('Router unavailable — cannot navigate to /login')
        return
    }
    router.push('/login')
}
console.log('router', router)
</script>

<style scoped>
h1 {
    color: var(--accent);
    padding-bottom: 1.2rem;
}

.login-button, .hero-button-one {
    background-color: var(--accent);
    color: var(--background);
    border: none;
    border-radius: 50px;
}

.crypto {
    color: var(--paragraph);
}

nav {
    color: var(--paragraph);
}

.colored-text {
    color: var(--paragraph);
}

.hero-button-two {
    border-color: var(--accent);
    color: var(--accent);
    background-color: transparent;
    border-radius: 50px;
}

.buy-sell {
    max-width: 800px;
}
</style>