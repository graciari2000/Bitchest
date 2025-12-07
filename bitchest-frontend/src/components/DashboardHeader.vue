<template>
    <div class="flex items-center justify-between w-full h-16 px-8 bg-dark-bg border-b border-dark-border">
        <div class="flex flex-col">
            <h1 class="text-3xl font-bold text-dark-text">Dashboard</h1>
            <p class="text-sm text-dark-accent-light">Welcome, User!</p>
        </div>

        <div class="flex items-center gap-6">
            <!-- Search -->
            <button
                class="flex items-center justify-center w-8 h-8 text-dark-accent-light hover:text-dark-accent transition-smooth">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" stroke-width="2" />
                    <path stroke-width="2" d="m21 21-4.35-4.35" stroke-linecap="round" />
                </svg>
            </button>

            <!-- Menu -->
            <button
                class="flex items-center justify-center w-8 h-8 text-dark-accent-light hover:text-dark-accent transition-smooth">
                <div class="grid grid-cols-3 gap-1">
                    <div v-for="i in 9" :key="i" class="w-1 h-1 bg-dark-accent-light rounded-full" />
                </div>
            </button>

            <!-- Notifications -->
            <button
                class="relative flex items-center gap-2 px-3 py-1.5 rounded-full bg-dark-error bg-opacity-80 hover:bg-opacity-100 transition-smooth">
                <svg class="w-3 h-3 text-dark-text" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z" />
                </svg>
                <span class="text-xs font-semibold text-dark-text">15</span>
            </button>

            <!-- User Profile -->
            <div class="flex items-center gap-2">
                <img src="https://api.builder.io/api/v1/image/assets/TEMP/6878da621cc6fbc5afde884e8db308ccb609ab42?width=56"
                    alt="User" class="w-7 h-7 rounded" />
                <div class="flex flex-col text-right text-xs">
                    <span class="text-dark-accent-light font-medium">Pixelz Warrios</span>
                    <svg class="w-2.5 h-1.5 ml-auto text-dark-accent-light" fill="none" stroke="currentColor"
                        viewBox="0 0 8 6">
                        <path stroke-width="2" d="M6.609 0.703L3.66 3.703L0.714 0.703" stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
// Header component - no logic needed
</script>

<style scoped></style>