<template>
    <div class="min-h-screen flex items-center justify-center bg-white dark:bg-black p-4">
        <div
            class="w-full max-w-6xl flex flex-col lg:flex-row rounded-3xl overflow-hidden shadow-2xl bg-white dark:bg-black">
            <!-- Left side - Form -->
            <div class="w-full lg:w-1/2 p-8 lg:p-16 flex items-center justify-center">
                <div class="w-full max-w-sm">
                    <h1 class="text-3xl font-bold uppercase text-center mb-2 text-black dark:text-white">
                        Login
                    </h1>
                    <button @click="toggleDarkMode"
                        class="p-2 rounded-full border border-primary hover:bg-primary hover:text-background transition-colors">
                        <!-- Replace the emoji with SVGs -->
                        <img v-if="isDark" src="../assets/light_mode.svg" alt="Light Mode" class="w-5 h-5" />
                        <img v-else src="../assets/dark_mode.svg" alt="Dark Mode" class="w-5 h-5" />
                    </button>
                    <p class="text-center text-[#525252] dark:text-white mb-12 text-base">
                        How to i get started lorem ipsum dolor at?
                    </p>

                    <form @submit.prevent="handleSubmit" class="space-y-5">
                        <!-- Email Input -->
                        <div class="relative">
                            <div
                                class="flex items-center gap-3 bg-[rgba(240,237,255,0.8)] dark:bg-[rgba(255,255,255,0.8)] rounded-2xl px-4 py-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0">
                                    <path
                                        d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"
                                        fill="#1C1C1C" />
                                </svg>
                                <input v-model="email" type="email" placeholder="Email" autocomplete="email"
                                    class="bg-transparent border-none outline-none text-[#1C1C1C] text-xs flex-1 placeholder:text-[#1C1C1C]" />
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="relative">
                            <div
                                class="flex items-center gap-3 bg-[rgba(240,237,255,0.8)] dark:bg-[rgba(255,255,255,0.8)] rounded-2xl px-4 py-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0">
                                    <path
                                        d="M6 8V7C6 3.68629 8.68629 1 12 1C15.3137 1 18 3.68629 18 7V8H20C20.5523 8 21 8.44772 21 9V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V9C3 8.44772 3.44772 8 4 8H6ZM19 10H5V20H19V10ZM11 15.7324C10.4022 15.3866 10 14.7403 10 14C10 12.8954 10.8954 12 12 12C13.1046 12 14 12.8954 14 14C14 14.7403 13.5978 15.3866 13 15.7324V18H11V15.7324ZM8 8H16V7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7V8Z"
                                        fill="#1C1C1C" />
                                </svg>
                                <input v-model="password" type="password" placeholder="Password" autocomplete="current-password"
                                    class="bg-transparent border-none outline-none text-[#1C1C1C] text-xs flex-1 placeholder:text-[#1C1C1C]" />
                            </div>
                        </div>

                        <!-- Error Message -->
                        <div v-if="errorMessage" class="text-red-500 text-sm text-center">
                            {{ errorMessage }}
                        </div>

                        <!-- Login Button -->
                        <div class="flex justify-center pt-4">
                            <button type="submit" :disabled="isLoading"
                                class="bg-gradient-to-r from-[#00FF19] to-[rgba(0,255,25,0.75)] text-white font-bold text-xs px-8 py-4 rounded-2xl shadow-[0_8px_21px_0_rgba(0,0,0,0.16)] hover:opacity-90 transition-opacity disabled:opacity-50">
                                {{ isLoading ? 'Logging in...' : 'Login Now' }}
                            </button>
                        </div>
                    </form>

                    <p class="text-center text-[#525252] dark:text-white mt-6 text-base">
                        Don't have an account?
                        <RouterLink to="/register" class="hover:underline">
                            Register here!
                        </RouterLink>
                    </p>

                    <!-- Social Login -->
                    <div class="flex justify-center gap-10 mt-8">
                        <button
                            class="w-32 h-14 border border-[#F0EDFF] dark:border-[rgba(255,255,255,0.2)] rounded-2xl flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
                            <img src="https://api.builder.io/api/v1/image/assets/TEMP/28311758150911b2a55116fa75efb86d256911b4?width=60"
                                alt="Google" class="w-8 h-8" />
                        </button>
                        <button
                            class="w-32 h-14 border border-[#F0EDFF] dark:border-[rgba(255,255,255,0.2)] rounded-2xl flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
                            <img src="https://api.builder.io/api/v1/image/assets/TEMP/799fc55d1a860f47a45d4b4d82bba53f87e24486?width=60"
                                alt="Facebook" class="w-8 h-8" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right side - Gradient Image -->
            <div class="hidden lg:block lg:w-1/2 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-[#9181F4] via-[#7268E8] to-[#5038ED]" />
                <img src="https://api.builder.io/api/v1/image/assets/TEMP/319cfd5832cb5f87e2ee48e4537bb005f1d304fc?width=1366"
                    alt="" class="absolute inset-0 w-full h-full object-cover" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { authAPI } from '../services/api'

const router = useRouter()
const email = ref('')
const password = ref('')
const isLoading = ref(false)
const errorMessage = ref('')
const isDark = ref(false)

const toggleDarkMode = () => {
    isDark.value = !isDark.value
    document.documentElement.classList.toggle('dark', isDark.value)
}

const handleSubmit = async () => {
    isLoading.value = true
    errorMessage.value = ''

    try {
        const response = await authAPI.login(email.value, password.value)

        // Stocker les informations utilisateur dans le localStorage
        localStorage.setItem('user', JSON.stringify(response.user))
        localStorage.setItem('token', response.token)

        // Redirection basée sur le rôle
        if (response.user.role === 'admin') {
            router.push('/admin/dashboard')
        } else {
            router.push('/user-dashboard')
        }

    } catch (error) {
        errorMessage.value = error.message || 'Login failed. Please check your credentials.'
    } finally {
        isLoading.value = false
    }
}

const goToRegister = () => {
    router.push('/register')
}
</script>