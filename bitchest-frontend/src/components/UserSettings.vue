<!-- UserSettings.vue -->
<template>
    <div class="min-h-screen transition-colors duration-300" :class="isDark ? 'bg-black' : 'bg-white'">
        <!-- Loading State -->
        <div v-if="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="text-white">
                <div class="w-16 h-16 border-4 border-t-transparent border-[#00FF19] rounded-full animate-spin mx-auto">
                </div>
                <p class="mt-4">Loading settings...</p>
            </div>
        </div>

        <!-- Radial gradient background -->
        <div class="fixed inset-0 pointer-events-none" :style="isDark
            ? 'background: radial-gradient(123.22% 129.67% at 100.89% -5.6%, #000 0%, #000 100%)'
            : 'background: radial-gradient(123.22% 129.67% at 100.89% -5.6%, #FFF 100%)'">
        </div>

        <div class="relative z-10 flex">
            <!-- Sidebar (same as dashboard) -->
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
                    <div v-for="item in navItems" :key="item.path" @click="navigateTo(item.path)" :class="[
                        'flex items-center gap-4 px-4 py-3 rounded-lg cursor-pointer transition-colors relative group',
                        currentPath === item.path
                            ? (isDark ? 'text-[#0074CC] bg-[#0F1A27]' : 'text-[#0074CC] bg-blue-50')
                            : (isDark ? 'text-[#749DC8] hover:text-[#0074CC] hover:bg-[#1A2A3A]' : 'text-slate-600 hover:text-[#0074CC] hover:bg-slate-100'),
                    ]">
                        <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
                        <span class="text-sm font-medium">{{ item.name }}</span>
                        <div v-if="item.path === '/messages' && unreadMessages > 0"
                            class="absolute right-4 w-2 h-2 rounded-full bg-[#A8000B]"></div>
                    </div>
                </nav>

                <!-- Footer -->
                <div class="absolute bottom-0 left-0 right-0 p-8">
                    <button @click="logout"
                        class="flex items-center gap-4 px-4 py-3 rounded-lg cursor-pointer transition-colors w-full"
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
                                <h1 class="text-3xl font-bold" :class="isDark ? 'text-white' : 'text-slate-900'">Account
                                    Settings</h1>
                                <p class="text-sm mt-1" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                    Manage your account preferences and security
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

                                <!-- Save Button -->
                                <button @click="saveSettings" :disabled="saving"
                                    class="px-4 py-2 rounded-lg bg-[#00FF19] text-white font-medium hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span v-if="saving">Saving...</span>
                                    <span v-else>Save Changes</span>
                                </button>
                            </div>
                        </div>
                    </header>

                    <!-- Main Settings Content -->
                    <main class="p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Left Column - Profile -->
                            <div class="lg:col-span-2 space-y-8">
                                <!-- Personal Information -->
                                <div class="rounded-xl border transition-colors"
                                    :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                    <div class="p-6 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                        <h3 class="text-lg font-semibold"
                                            :class="isDark ? 'text-white' : 'text-slate-900'">
                                            Personal Information
                                        </h3>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <!-- Profile Picture -->
                                        <div class="flex items-center gap-6">
                                            <div class="relative">
                                                <div
                                                    class="w-24 h-24 rounded-full overflow-hidden bg-gradient-to-r from-[#0074CC] to-[#00FF19] flex items-center justify-center text-white text-2xl font-bold">
                                                    {{ userInitials }}
                                                </div>
                                                <button @click="changeProfilePicture"
                                                    class="absolute bottom-0 right-0 p-2 bg-white dark:bg-[#1A2A3A] rounded-full border shadow-sm hover:scale-105 transition-transform">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div>
                                                <h4 class="font-medium"
                                                    :class="isDark ? 'text-white' : 'text-slate-900'">Profile Picture
                                                </h4>
                                                <p class="text-sm mt-1"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                                    JPG, GIF or PNG. Max size of 5MB.
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Form Fields -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-sm font-medium mb-2"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">First
                                                    Name</label>
                                                <input v-model="form.firstName" type="text"
                                                    class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                    :class="isDark
                                                        ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                        : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-2"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">Last
                                                    Name</label>
                                                <input v-model="form.lastName" type="text"
                                                    class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                    :class="isDark
                                                        ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                        : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="block text-sm font-medium mb-2"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">Email
                                                    Address</label>
                                                <input v-model="form.email" type="email"
                                                    class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                    :class="isDark
                                                        ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                        : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                                <p class="text-xs mt-2"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                                    We'll never share your email with anyone else.
                                                </p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-2"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">Phone
                                                    Number</label>
                                                <input v-model="form.phone" type="tel"
                                                    class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                    :class="isDark
                                                        ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                        : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-2"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">Country</label>
                                                <select v-model="form.country"
                                                    class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                    :class="isDark
                                                        ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                        : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                                    <option value="US">United States</option>
                                                    <option value="GB">United Kingdom</option>
                                                    <option value="DE">Germany</option>
                                                    <option value="FR">France</option>
                                                    <option value="ES">Spain</option>
                                                    <option value="IT">Italy</option>
                                                    <option value="AU">Australia</option>
                                                    <option value="CA">Canada</option>
                                                    <option value="JP">Japan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Security Settings -->
                                <div class="rounded-xl border transition-colors"
                                    :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                    <div class="p-6 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                        <h3 class="text-lg font-semibold"
                                            :class="isDark ? 'text-white' : 'text-slate-900'">
                                            Security Settings
                                        </h3>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <!-- Change Password -->
                                        <div>
                                            <h4 class="font-medium mb-4"
                                                :class="isDark ? 'text-white' : 'text-slate-900'">Change Password</h4>
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium mb-2"
                                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">Current
                                                        Password</label>
                                                    <div class="relative">
                                                        <input v-model="password.current"
                                                            :type="showCurrentPassword ? 'text' : 'password'"
                                                            class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                            :class="isDark
                                                                ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                                : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                                        <button @click="showCurrentPassword = !showCurrentPassword"
                                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-500 hover:text-slate-700">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path v-if="showCurrentPassword" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                                <path v-else stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium mb-2"
                                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">New
                                                        Password</label>
                                                    <div class="relative">
                                                        <input v-model="password.new"
                                                            :type="showNewPassword ? 'text' : 'password'"
                                                            class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                            :class="isDark
                                                                ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                                : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                                        <button @click="showNewPassword = !showNewPassword"
                                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-500 hover:text-slate-700">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path v-if="showNewPassword" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                                <path v-else stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium mb-2"
                                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">Confirm
                                                        New Password</label>
                                                    <div class="relative">
                                                        <input v-model="password.confirm"
                                                            :type="showConfirmPassword ? 'text' : 'password'"
                                                            class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                            :class="isDark
                                                                ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                                : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                                        <button @click="showConfirmPassword = !showConfirmPassword"
                                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-slate-500 hover:text-slate-700">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path v-if="showConfirmPassword" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                                <path v-else stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Two-Factor Authentication -->
                                        <div>
                                            <div class="flex items-center justify-between mb-4">
                                                <div>
                                                    <h4 class="font-medium"
                                                        :class="isDark ? 'text-white' : 'text-slate-900'">Two-Factor
                                                        Authentication</h4>
                                                    <p class="text-sm mt-1"
                                                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                                        Add an extra layer of security to your account
                                                    </p>
                                                </div>
                                                <button @click="toggle2FA"
                                                    class="px-4 py-2 rounded-lg border font-medium transition-colors"
                                                    :class="twoFactorEnabled
                                                        ? (isDark ? 'bg-[#00FF19] text-black hover:bg-opacity-90' : 'bg-[#00FF19] text-white hover:bg-opacity-90')
                                                        : (isDark ? 'border-[#749DC8] text-[#749DC8] hover:bg-[#1A2A3A]' : 'border-slate-300 text-slate-700 hover:bg-slate-50')">
                                                    {{ twoFactorEnabled ? 'Disable 2FA' : 'Enable 2FA' }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notification Preferences -->
                                <div class="rounded-xl border transition-colors"
                                    :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                    <div class="p-6 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                        <h3 class="text-lg font-semibold"
                                            :class="isDark ? 'text-white' : 'text-slate-900'">
                                            Notification Preferences
                                        </h3>
                                    </div>
                                    <div class="p-6 space-y-4">
                                        <div v-for="pref in notificationPreferences" :key="pref.id"
                                            class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium"
                                                    :class="isDark ? 'text-white' : 'text-slate-900'">{{ pref.title }}
                                                </h4>
                                                <p class="text-sm mt-1"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                                    {{ pref.description }}
                                                </p>
                                            </div>
                                            <button @click="toggleNotificationPreference(pref.id)"
                                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors"
                                                :class="pref.enabled
                                                    ? (isDark ? 'bg-[#00FF19]' : 'bg-[#00FF19]')
                                                    : (isDark ? 'bg-[#2A3A4A]' : 'bg-slate-300')">
                                                <span
                                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                                                    :class="pref.enabled ? 'translate-x-6' : 'translate-x-1'"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Preferences & Danger Zone -->
                            <div class="space-y-8">
                                <!-- Theme Preferences -->
                                <div class="rounded-xl border transition-colors"
                                    :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                                    <div class="p-6 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                        <h3 class="text-lg font-semibold"
                                            :class="isDark ? 'text-white' : 'text-slate-900'">
                                            Theme Preferences
                                        </h3>
                                    </div>
                                    <div class="p-6 space-y-4">
                                        <div v-for="theme in themes" :key="theme.id" @click="selectTheme(theme.id)"
                                            class="flex items-center gap-4 p-4 rounded-lg cursor-pointer transition-colors"
                                            :class="[
                                                selectedTheme === theme.id
                                                    ? (isDark ? 'bg-[#1A2A3A] border-[#0074CC]' : 'bg-blue-50 border-blue-500')
                                                    : (isDark ? 'hover:bg-[#1A2A3A] border-transparent' : 'hover:bg-slate-50 border-transparent'),
                                                'border'
                                            ]">
                                            <div class="flex items-center justify-center w-10 h-10 rounded-lg"
                                                :class="theme.id === 'dark' ? 'bg-[#0F1A27]' : theme.id === 'light' ? 'bg-white' : 'bg-gradient-to-r from-[#0074CC] to-[#00FF19]'">
                                                <svg v-if="theme.id === 'dark'" class="w-5 h-5 text-white"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                                                </svg>
                                                <svg v-if="theme.id === 'light'" class="w-5 h-5 text-yellow-500"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z" />
                                                </svg>
                                                <svg v-if="theme.id === 'auto'" class="w-5 h-5 text-white"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                        d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-medium"
                                                    :class="isDark ? 'text-white' : 'text-slate-900'">{{ theme.name }}
                                                </div>
                                                <div class="text-sm"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{
                                                    theme.description
                                                    }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Danger Zone -->
                                <div class="rounded-xl border border-[#A8000B] bg-[#A8000B]/5">
                                    <div class="p-6 border-b border-[#A8000B]/20">
                                        <h3 class="text-lg font-semibold text-[#A8000B]">Danger Zone</h3>
                                    </div>
                                    <div class="p-6 space-y-4">
                                        <div>
                                            <h4 class="font-medium text-[#A8000B] mb-2">Delete Account</h4>
                                            <p class="text-sm text-[#A8000B]/80 mb-4">
                                                Once you delete your account, there is no going back. Please be certain.
                                            </p>
                                            <button @click="confirmDeleteAccount"
                                                class="px-4 py-2 rounded-lg border border-[#A8000B] text-[#A8000B] font-medium hover:bg-[#A8000B] hover:text-white transition-colors">
                                                Delete Account
                                            </button>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-[#A8000B] mb-2">Export Data</h4>
                                            <p class="text-sm text-[#A8000B]/80 mb-4">
                                                Download all your personal data and transaction history.
                                            </p>
                                            <button @click="exportData"
                                                class="px-4 py-2 rounded-lg border border-[#A8000B] text-[#A8000B] font-medium hover:bg-[#A8000B] hover:text-white transition-colors">
                                                Export Data
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { authAPI, userAPI } from '../services/api'
import { ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()
const isDark = ref(false)
const loading = ref(false)
const saving = ref(false)

// User data
const userName = ref('')
const userEmail = ref('')
const userInitials = ref('')

// Form data
const form = ref({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    country: 'US'
})

// Password change
const password = ref({
    current: '',
    new: '',
    confirm: ''
})
const showCurrentPassword = ref(false)
const showNewPassword = ref(false)
const showConfirmPassword = ref(false)

// Two-factor authentication
const twoFactorEnabled = ref(false)

// Theme preferences
const selectedTheme = ref('auto')
const themes = [
    { id: 'light', name: 'Light', description: 'Light theme' },
    { id: 'dark', name: 'Dark', description: 'Dark theme' },
    { id: 'auto', name: 'Auto', description: 'Follow system' }
]

// Notification preferences
const notificationPreferences = ref([
    { id: 'email', title: 'Email Notifications', description: 'Receive notifications via email', enabled: true },
    { id: 'push', title: 'Push Notifications', description: 'Receive browser push notifications', enabled: true },
    { id: 'sms', title: 'SMS Notifications', description: 'Receive SMS alerts', enabled: false },
    { id: 'price_alerts', title: 'Price Alerts', description: 'Get notified about price changes', enabled: true },
    { id: 'security', title: 'Security Alerts', description: 'Important security notifications', enabled: true }
])

// Navigation
const navItems = [
    { name: 'Dashboard', path: '/user-dashboard' },
    { name: 'Wallet', path: '/wallet' },
    { name: 'Messages', path: '/messages' },
    { name: 'Trade', path: '/trade' },
    { name: 'Account Setting', path: '/settings' },
]

const currentPath = computed(() => route.path)
const unreadMessages = computed(() => 0) // You would implement this based on your data

// Navigation
const navigateTo = (path: string) => {
    router.push(path)
}

// Theme functions
const toggleTheme = () => {
    isDark.value = !isDark.value
    localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
}

const selectTheme = (themeId: string) => {
    selectedTheme.value = themeId
    if (themeId === 'auto') {
        // Check system preference
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
        isDark.value = prefersDark
    } else {
        isDark.value = themeId === 'dark'
    }
    localStorage.setItem('theme', themeId === 'auto' ? 'auto' : isDark.value ? 'dark' : 'light')
}

// Settings functions
const changeProfilePicture = () => {
    // Implement profile picture change logic
    const input = document.createElement('input')
    input.type = 'file'
    input.accept = 'image/*'
    input.onchange = (e) => {
        const file = (e.target as HTMLInputElement).files?.[0]
        if (file) {
            // Upload file logic here
            console.log('Selected file:', file)
        }
    }
    input.click()
}

const toggle2FA = async () => {
    try {
        const response = await userAPI.toggleTwoFactor(!twoFactorEnabled.value)
        twoFactorEnabled.value = response.enabled
        alert(twoFactorEnabled.value ? 'Two-factor authentication enabled' : 'Two-factor authentication disabled')
    } catch (error) {
        console.error('Error toggling 2FA:', error)
        alert('Failed to update two-factor authentication')
    }
}

const toggleNotificationPreference = (id: string) => {
    const pref = notificationPreferences.value.find(p => p.id === id)
    if (pref) {
        pref.enabled = !pref.enabled
    }
}

const saveSettings = async () => {
    saving.value = true
    try {
        // Save personal information
        await userAPI.updateProfile(form.value)

        // Save password if changed
        if (password.value.new && password.value.confirm) {
            if (password.value.new !== password.value.confirm) {
                alert('New passwords do not match')
                return
            }
            await userAPI.changePassword({
                current: password.value.current,
                new: password.value.new
            })
        }

        // Save notification preferences
        await userAPI.updateNotificationPreferences(
            notificationPreferences.value.reduce((acc, pref) => {
                acc[pref.id] = pref.enabled
                return acc
            }, {} as Record<string, boolean>)
        )

        alert('Settings saved successfully')
    } catch (error) {
        console.error('Error saving settings:', error)
        alert('Failed to save settings')
    } finally {
        saving.value = false
    }
}

const confirmDeleteAccount = () => {
    if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
        deleteAccount()
    }
}

const deleteAccount = async () => {
    try {
        await userAPI.deleteAccount()
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        router.push('/login')
    } catch (error) {
        console.error('Error deleting account:', error)
        alert('Failed to delete account')
    }
}

const exportData = async () => {
    try {
        const data = await userAPI.exportData()
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' })
        const url = window.URL.createObjectURL(blob)
        const a = document.createElement('a')
        a.href = url
        a.download = `bitchest-data-${new Date().toISOString().split('T')[0]}.json`
        document.body.appendChild(a)
        a.click()
        document.body.removeChild(a)
        window.URL.revokeObjectURL(url)
    } catch (error) {
        console.error('Error exporting data:', error)
        alert('Failed to export data')
    }
}

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
    loading.value = true
    try {
        // Load theme preference
        const savedTheme = localStorage.getItem('theme') || 'auto'
        selectedTheme.value = savedTheme
        if (savedTheme === 'auto') {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
            isDark.value = prefersDark
        } else {
            isDark.value = savedTheme === 'dark'
        }

        // Load user data
        const user = JSON.parse(localStorage.getItem('user') || '{}')
        userName.value = user.name || 'User'
        userEmail.value = user.email || 'user@bitchest.com'
        userInitials.value = userName.value.split(' ').map((n: string) => n[0]).join('').toUpperCase()

        // Split full name into first and last name
        const nameParts = userName.value.split(' ')
        form.value.firstName = nameParts[0] || ''
        form.value.lastName = nameParts.slice(1).join(' ') || ''
        form.value.email = userEmail.value

        // Load user settings
        const settings = await userAPI.getSettings()
        form.value.phone = settings.phone || ''
        form.value.country = settings.country || 'US'
        twoFactorEnabled.value = settings.twoFactorEnabled || false

        // Load notification preferences
        const prefs = await userAPI.getNotificationPreferences()
        notificationPreferences.value.forEach(pref => {
            if (prefs[pref.id] !== undefined) {
                pref.enabled = prefs[pref.id]
            }
        })
    } catch (error) {
        console.error('Error loading settings:', error)
    } finally {
        loading.value = false
    }
})
</script>