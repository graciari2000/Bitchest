<template>
    <div class="w-80 h-screen bg-gradient-to-b from-black/65 to-black flex flex-col">
        <!-- Logo/Brand area -->
        <div class="h-32" />

        <!-- Navigation -->
        <nav class="flex-1 px-16 pt-12">
            <div class="space-y-16">
                <!-- Dashboard -->
                <router-link to="/"
                    class="flex items-center gap-4 text-dark-accent font-medium text-sm tracking-wide transition-smooth hover:text-dark-accent/80">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
                    </svg>
                    <span>Dashboard</span>
                </router-link>

                <!-- Wallet -->
                <router-link to="/wallet"
                    class="flex items-center gap-4 text-dark-accent-light font-normal text-sm tracking-wide transition-smooth hover:text-dark-accent">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2v-1H1v-2h2V4c0-1.1.9-2 2-2h14c1.1 0 2 .9 2 2v12h2v2h-2zm-2-2V4H5v12h14zm-6-6c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                    </svg>
                    <span>Wallet</span>
                </router-link>

                <!-- Messages -->
                <div class="flex items-center gap-4 text-dark-accent-light font-normal text-sm tracking-wide">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" />
                    </svg>
                    <span>Messages</span>
                    <div class="ml-auto w-1.5 h-1.5 rounded-full bg-dark-error" />
                </div>

                <!-- Trade -->
                <router-link to="/trade"
                    class="flex items-center gap-4 text-dark-accent-light font-normal text-sm tracking-wide transition-smooth hover:text-dark-accent">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 6l2.29 2.29-4.58 4.58 4.58 4.58L16 19.14 4.14 7.29l11.86-1.29zm0-4v4h4V2h-4z" />
                    </svg>
                    <span>Trade</span>
                </router-link>

                <!-- Account Setting -->
                <router-link to="/settings"
                    class="flex items-center gap-4 text-dark-accent-light font-normal text-sm tracking-wide transition-smooth hover:text-dark-accent">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.64l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.09-.47 0-.59.22L2.74 8.87c-.12.22-.07.49.12.64l2.03 1.58c-.05.3-.07.62-.07.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.64l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.47.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.09.47 0 .59-.22l1.92-3.32c.12-.22.07-.49-.12-.64l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z" />
                    </svg>
                    <span>Account Setting</span>
                </router-link>

                <!-- Clients -->
                <router-link to="/clients"
                    class="flex items-center gap-4 text-dark-accent-light font-normal text-sm tracking-wide transition-smooth hover:text-dark-accent">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm8 0c1.66 0 2.99-1.34 2.99-3S25.66 5 24 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.5 1.1 2.5 2.48 2.5 3.95V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                    </svg>
                    <span>Clients</span>
                </router-link>
            </div>
        </nav>

        <!-- Collapse button -->
        <div class="px-16 pb-8">
            <button class="w-12 h-10 rounded flex items-center justify-center hover:bg-dark-card transition-smooth">
                <svg class="w-6 h-6 text-dark-accent-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
// Sidebar component
</script>

<style scoped></style>