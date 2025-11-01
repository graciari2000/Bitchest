<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const email = ref('')
const password = ref('')
const isLoading = ref(false)

const handleSubmit = async () => {
    isLoading.value = true
    try {
        // TODO: Implement actual login logic here
        await new Promise(resolve => setTimeout(resolve, 1000)) // Simulated delay
        router.push('/dashboard')
    } catch (error) {
        console.error('Login failed:', error)
    } finally {
        isLoading.value = false
    }
}

const forgotPassword = () => {
    // TODO: Implement forgot password logic
    console.log('Forgot password clicked')
}

const noAccount = () => {
    router.push('/register')
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center px-4 py-12 bg-background">
        <div class="w-full max-w-md space-y-8">
            <div class="text-center">
                <img class="mx-auto h-12 w-auto" src="" alt="BitChest" />
                <h2 class="mt-6 text font-bold tracking-tight text-text">
                    Sign in to your account
                </h2>
            </div>

            <form @submit.prevent="handleSubmit" class="mt-8 space-y-6">
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium">
                            Email address
                        </label>
                        <div class="mt-1">
                            <input v-model="email" id="email" name="email" type="email" required
                                class="block w-full appearance-none rounded-lg border border-primary/30 px-3 py-2 placeholder-text/50 shadow-sm bg-background text-text focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20"
                                placeholder="Enter your email" />
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium text-text">
                                Password
                            </label>
                        </div>
                        <div class="mt-1">
                            <input v-model="password" id="password" name="password" type="password" required
                                class="block w-full appearance-none rounded-lg border border-primary/30 px-3 py-2 placeholder-text/50 shadow-sm bg-background text-text focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20"
                                placeholder="Enter your password" />
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium text-text">
                                Password
                            </label>
                        </div>
                        <div class="mt-1">
                            <input v-model="password" id="password" name="password" type="password" required
                                class="block w-full appearance-none rounded-lg border border-primary/30 px-3 py-2 placeholder-text/50 shadow-sm bg-background text-text focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20"
                                placeholder="Enter your password" />
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" :disabled="isLoading"
                        class="flex w-full justify-center rounded-lg bg-accent px-3 py-2 text-sm font-semibold text-background shadow-sm hover:bg-accent/90 focus:outline-none focus:ring-2 focus:ring-accent/20 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ isLoading ? 'Signing in...' : 'Register' }}
                    </button>
                </div>
            </form>

            <p class="mt-8 text-center text-sm text-text/70">
                Already a member?
                <button @click="noAccount" class="font-medium text-accent hover:text-accent/80 transition-colors ml-1">
                    Login here
                </button>
            </p>
        </div>
    </div>
</template>