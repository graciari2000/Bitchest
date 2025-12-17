<!-- AdminSettings.vue -->
<template>
    <div class="min-h-screen transition-colors duration-300" :class="isDark ? 'bg-black' : 'bg-white'">
        <!-- Loading State -->
        <div v-if="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="text-white">
                <div class="w-16 h-16 border-4 border-t-transparent border-[#00FF19] rounded-full animate-spin mx-auto">
                </div>
                <p class="mt-4">Loading admin settings...</p>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="fixed left-0 top-0 h-screen z-40 w-64 transition-colors border-r" :class="isDark
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
                <div v-for="item in menuItems" :key="item.path" @click="navigateTo(item.path)" :class="[
                    'flex items-center gap-4 text-sm font-medium px-4 py-3 rounded-lg transition-colors relative group cursor-pointer',
                    currentPath === item.path
                        ? (isDark ? 'text-[#0074CC] bg-[#0F1A27]' : 'text-[#0074CC] bg-blue-50')
                        : (isDark ? 'text-[#749DC8] hover:text-[#0074CC] hover:bg-[#1A2A3A]' : 'text-slate-600 hover:text-[#0074CC] hover:bg-slate-100'),
                ]">
                    <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
                    <span>{{ item.name }}</span>
                </div>
            </nav>

            <!-- Logout -->
            <div class="absolute bottom-0 left-0 right-0 p-8">
                <div @click="logout"
                    class="flex items-center gap-4 px-4 py-3 rounded-lg cursor-pointer transition-colors"
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
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="ml-64">
            <!-- Header -->
            <header class="px-8 py-6 border-b transition-colors"
                :class="isDark ? 'border-[#0F1A27] bg-[#0F1A27]' : 'border-slate-200 bg-white'">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold transition-colors"
                            :class="isDark ? 'text-white' : 'text-slate-900'">
                            Admin Settings
                        </h1>
                        <p class="text-sm mt-1 transition-colors" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                            System configuration and administrator preferences
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
                            <span v-else>Save Settings</span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Settings Content -->
            <main class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - System Settings -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- System Configuration -->
                        <div class="rounded-xl border transition-colors"
                            :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                            <div class="p-6 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                <h3 class="text-lg font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                                    System Configuration
                                </h3>
                            </div>
                            <div class="p-6 space-y-6">
                                <!-- API Settings -->
                                <div>
                                    <h4 class="font-medium mb-4" :class="isDark ? 'text-white' : 'text-slate-900'">API
                                        Settings</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium mb-2"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">API Base
                                                URL</label>
                                            <input v-model="systemSettings.apiBaseUrl" type="text"
                                                class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                :class="isDark
                                                    ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                    : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-2"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">API Rate Limit
                                                (req/min)</label>
                                            <input v-model="systemSettings.apiRateLimit" type="number"
                                                class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                :class="isDark
                                                    ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                    : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Settings -->
                                <div>
                                    <h4 class="font-medium mb-4" :class="isDark ? 'text-white' : 'text-slate-900'">Email
                                        Settings</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium mb-2"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">SMTP
                                                Server</label>
                                            <input v-model="emailSettings.smtpServer" type="text"
                                                class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                :class="isDark
                                                    ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                    : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-2"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">SMTP Port</label>
                                            <input v-model="emailSettings.smtpPort" type="number"
                                                class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                :class="isDark
                                                    ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                    : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium mb-2"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">From Email</label>
                                            <input v-model="emailSettings.fromEmail" type="email"
                                                class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                :class="isDark
                                                    ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                    : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                        </div>
                                    </div>
                                </div>

                                <!-- Security Settings -->
                                <div>
                                    <h4 class="font-medium mb-4" :class="isDark ? 'text-white' : 'text-slate-900'">
                                        Security Settings</h4>
                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h5 class="font-medium"
                                                    :class="isDark ? 'text-white' : 'text-slate-900'">Require 2FA for
                                                    Admins
                                                </h5>
                                                <p class="text-sm"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                                    All administrators must enable two-factor authentication
                                                </p>
                                            </div>
                                            <button
                                                @click="securitySettings.require2FAForAdmins = !securitySettings.require2FAForAdmins"
                                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors"
                                                :class="securitySettings.require2FAForAdmins
                                                    ? (isDark ? 'bg-[#00FF19]' : 'bg-[#00FF19]')
                                                    : (isDark ? 'bg-[#2A3A4A]' : 'bg-slate-300')">
                                                <span
                                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                                                    :class="securitySettings.require2FAForAdmins ? 'translate-x-6' : 'translate-x-1'"></span>
                                            </button>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h5 class="font-medium"
                                                    :class="isDark ? 'text-white' : 'text-slate-900'">Session Timeout
                                                </h5>
                                                <p class="text-sm"
                                                    :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                                                    Automatically log out inactive users
                                                </p>
                                            </div>
                                            <select v-model="securitySettings.sessionTimeout"
                                                class="px-3 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                :class="isDark
                                                    ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                    : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                                <option value="15">15 minutes</option>
                                                <option value="30">30 minutes</option>
                                                <option value="60">1 hour</option>
                                                <option value="120">2 hours</option>
                                                <option value="240">4 hours</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Admin Personal Settings -->
                        <div class="rounded-xl border transition-colors"
                            :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                            <div class="p-6 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                <h3 class="text-lg font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                                    Personal Settings
                                </h3>
                            </div>
                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium mb-2"
                                            :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">First Name</label>
                                        <input v-model="adminProfile.firstName" type="text"
                                            class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                            :class="isDark
                                                ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-2"
                                            :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">Last Name</label>
                                        <input v-model="adminProfile.lastName" type="text"
                                            class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                            :class="isDark
                                                ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium mb-2"
                                            :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">Email Address</label>
                                        <input v-model="adminProfile.email" type="email"
                                            class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                            :class="isDark
                                                ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                    </div>
                                </div>

                                <!-- Change Password -->
                                <div>
                                    <h4 class="font-medium mb-4" :class="isDark ? 'text-white' : 'text-slate-900'">
                                        Change Password</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-2"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">Current
                                                Password</label>
                                            <input v-model="adminPassword.current" type="password"
                                                class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                :class="isDark
                                                    ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                    : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-2"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">New
                                                Password</label>
                                            <input v-model="adminPassword.new" type="password"
                                                class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                :class="isDark
                                                    ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                    : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-2"
                                                :class="isDark ? 'text-[#749DC8]' : 'text-slate-700'">Confirm New
                                                Password</label>
                                            <input v-model="adminPassword.confirm" type="password"
                                                class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-[#0074CC] transition-colors"
                                                :class="isDark
                                                    ? 'bg-[#1A2A3A] border-[#2A3A4A] text-white focus:border-[#0074CC]'
                                                    : 'bg-white border-slate-300 text-slate-900 focus:border-[#0074CC]'">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Quick Actions & System Status -->
                    <div class="space-y-8">
                        <!-- Quick Actions -->
                        <div class="rounded-xl border transition-colors"
                            :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                            <div class="p-6 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                <h3 class="text-lg font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                                    Quick Actions
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <button @click="clearSystemCache"
                                    class="w-full flex items-center justify-between p-4 rounded-lg border hover:bg-slate-50 dark:hover:bg-[#1A2A3A] transition-colors"
                                    :class="isDark ? 'border-[#2A3A4A]' : 'border-slate-200'">
                                    <span class="font-medium" :class="isDark ? 'text-white' : 'text-slate-900'">Clear
                                        System Cache</span>
                                    <svg class="w-5 h-5" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                <button @click="runDatabaseBackup"
                                    class="w-full flex items-center justify-between p-4 rounded-lg border hover:bg-slate-50 dark:hover:bg-[#1A2A3A] transition-colors"
                                    :class="isDark ? 'border-[#2A3A4A]' : 'border-slate-200'">
                                    <span class="font-medium" :class="isDark ? 'text-white' : 'text-slate-900'">Backup
                                        Database</span>
                                    <svg class="w-5 h-5" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                </button>
                                <button @click="viewSystemLogs"
                                    class="w-full flex items-center justify-between p-4 rounded-lg border hover:bg-slate-50 dark:hover:bg-[#1A2A3A] transition-colors"
                                    :class="isDark ? 'border-[#2A3A4A]' : 'border-slate-200'">
                                    <span class="font-medium" :class="isDark ? 'text-white' : 'text-slate-900'">View
                                        System Logs</span>
                                    <svg class="w-5 h-5" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- System Status -->
                        <div class="rounded-xl border transition-colors"
                            :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                            <div class="p-6 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                                <h3 class="text-lg font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                                    System Status
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <div v-for="status in systemStatus" :key="status.id"
                                    class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-3 h-3 rounded-full"
                                            :class="status.online ? 'bg-[#00FF19]' : 'bg-[#A8000B]'"></div>
                                        <span class="text-sm" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{
                                            status.name }}</span>
                                    </div>
                                    <span class="text-sm font-medium"
                                        :class="status.online ? 'text-[#00FF19]' : 'text-[#A8000B]'">{{ status.status
                                        }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Danger Zone -->
                        <div class="rounded-xl border border-[#A8000B] bg-[#A8000B]/5">
                            <div class="p-6 border-b border-[#A8000B]/20">
                                <h3 class="text-lg font-semibold text-[#A8000B]">Danger Zone</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <button @click="restartServer"
                                    class="w-full px-4 py-2 rounded-lg border border-[#A8000B] text-[#A8000B] font-medium hover:bg-[#A8000B] hover:text-white transition-colors">
                                    Restart Server
                                </button>
                                <button @click="clearAllLogs"
                                    class="w-full px-4 py-2 rounded-lg border border-[#A8000B] text-[#A8000B] font-medium hover:bg-[#A8000B] hover:text-white transition-colors">
                                    Clear All Logs
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { authAPI, adminAPI } from '../services/api'

const router = useRouter()
const route = useRoute()
const isDark = ref(false)
const loading = ref(false)
const saving = ref(false)

// Admin profile
const adminProfile = ref({
    firstName: '',
    lastName: '',
    email: ''
})

// Admin password
const adminPassword = ref({
    current: '',
    new: '',
    confirm: ''
})

// System settings
const systemSettings = ref({
    apiBaseUrl: 'https://api.bitchest.com',
    apiRateLimit: 1000
})

// Email settings
const emailSettings = ref({
    smtpServer: 'smtp.bitchest.com',
    smtpPort: 587,
    fromEmail: 'noreply@bitchest.com'
})

// Security settings
const securitySettings = ref({
    require2FAForAdmins: true,
    sessionTimeout: '30'
})

// System status
const systemStatus = ref([
    { id: 'api', name: 'API Server', online: true, status: 'Online' },
    { id: 'database', name: 'Database', online: true, status: 'Connected' },
    { id: 'cache', name: 'Cache Server', online: true, status: 'Running' },
    { id: 'email', name: 'Email Service', online: true, status: 'Active' }
])

// Navigation
const menuItems = [
    { name: 'Dashboard', path: '/admin/dashboard' },
    { name: 'Wallet', path: '/wallet' },
    { name: 'Messages', path: '/messages' },
    { name: 'Trade', path: '/trade' },
    { name: 'Account Setting', path: '/admin/settings' },
    { name: 'Clients', path: '/admin/clients' },
]

const currentPath = computed(() => route.path)

// Navigation
const navigateTo = (path: string) => {
    router.push(path)
}

// Theme functions
const toggleTheme = () => {
    isDark.value = !isDark.value
    localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
}

// Settings functions
const saveSettings = async () => {
    saving.value = true
    try {
        // Save system settings
        await adminAPI.updateSystemSettings(systemSettings.value)

        // Save email settings
        await adminAPI.updateEmailSettings(emailSettings.value)

        // Save security settings
        await adminAPI.updateSecuritySettings(securitySettings.value)

        // Save admin profile
        await adminAPI.updateAdminProfile(adminProfile.value)

        // Change password if provided
        if (adminPassword.value.new && adminPassword.value.confirm) {
            if (adminPassword.value.new !== adminPassword.value.confirm) {
                alert('New passwords do not match')
                return
            }
            await adminAPI.changeAdminPassword({
                current: adminPassword.value.current,
                new: adminPassword.value.new
            })
        }

        alert('Settings saved successfully')
    } catch (error) {
        console.error('Error saving settings:', error)
        alert('Failed to save settings')
    } finally {
        saving.value = false
    }
}

// Quick actions
const clearSystemCache = async () => {
    if (confirm('Are you sure you want to clear the system cache?')) {
        try {
            await adminAPI.clearCache()
            alert('System cache cleared successfully')
        } catch (error) {
            console.error('Error clearing cache:', error)
            alert('Failed to clear cache')
        }
    }
}

const runDatabaseBackup = async () => {
    try {
        const response = await adminAPI.backupDatabase()
        const blob = new Blob([JSON.stringify(response, null, 2)], { type: 'application/json' })
        const url = window.URL.createObjectURL(blob)
        const a = document.createElement('a')
        a.href = url
        a.download = `bitchest-backup-${new Date().toISOString().split('T')[0]}.json`
        document.body.appendChild(a)
        a.click()
        document.body.removeChild(a)
        window.URL.revokeObjectURL(url)
        alert('Database backup completed and downloaded')
    } catch (error) {
        console.error('Error backing up database:', error)
        alert('Failed to backup database')
    }
}

const viewSystemLogs = () => {
    router.push('/admin/logs')
}

const restartServer = () => {
    if (confirm('Are you sure you want to restart the server? This will cause temporary downtime.')) {
        adminAPI.restartServer()
            .then(() => {
                alert('Server restart initiated. Please wait a few minutes.')
            })
            .catch(error => {
                console.error('Error restarting server:', error)
                alert('Failed to restart server')
            })
    }
}

const clearAllLogs = () => {
    if (confirm('Are you sure you want to clear all system logs? This action cannot be undone.')) {
        adminAPI.clearLogs()
            .then(() => {
                alert('All logs cleared successfully')
            })
            .catch(error => {
                console.error('Error clearing logs:', error)
                alert('Failed to clear logs')
            })
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
        const savedTheme = localStorage.getItem('theme')
        isDark.value = savedTheme === 'dark'

        // Load admin data
        const user = JSON.parse(localStorage.getItem('user') || '{}')
        const nameParts = user.name?.split(' ') || []
        adminProfile.value.firstName = nameParts[0] || 'Admin'
        adminProfile.value.lastName = nameParts.slice(1).join(' ') || ''
        adminProfile.value.email = user.email || 'admin@bitchest.com'

        // Load system settings
        const settings = await adminAPI.getSystemSettings()
        systemSettings.value = { ...systemSettings.value, ...settings.system }
        emailSettings.value = { ...emailSettings.value, ...settings.email }
        securitySettings.value = { ...securitySettings.value, ...settings.security }

        // Check system status
        const status = await adminAPI.getSystemStatus()
        systemStatus.value = systemStatus.value.map(item => ({
            ...item,
            online: status[item.id]?.online || false,
            status: status[item.id]?.status || 'Unknown'
        }))
    } catch (error) {
        console.error('Error loading admin settings:', error)
    } finally {
        loading.value = false
    }
})
</script>