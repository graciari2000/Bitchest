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


          </div>
        </div>

        <!-- Navigation -->
        <nav class="px-8 space-y-8">
          <div v-for="item in navItems" :key="item.name"
            class="flex items-center gap-4 px-4 py-3 rounded-lg cursor-pointer transition-colors relative group" :class="item.active
              ? (isDark ? 'text-[#0074CC] bg-[#0F1A27]' : 'text-[#0074CC] bg-blue-50')
              : (isDark ? 'text-[#749DC8] hover:text-[#0074CC]' : 'text-slate-600 hover:text-[#0074CC]')">
            <div class="w-5 h-5 rounded" :class="isDark ? 'bg-blue-900' : 'bg-blue-200'"></div>
            <span class="text-sm font-medium">{{ item.name }}</span>
            <div v-if="item.badge" class="absolute right-4 w-2 h-2 rounded-full bg-[#A8000B]"></div>
          </div>
        </nav>

        <!-- Footer -->
        <div class="absolute bottom-0 left-0 right-0 p-8">
          <div class="flex items-center gap-4 px-4 py-3 rounded-lg cursor-pointer transition-colors"
            :class="isDark ? 'text-[#749DC8] hover:text-[#0074CC]' : 'text-slate-600 hover:text-[#0074CC]'">
            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none">
              <path
                d="M7.5 17.5H4.16667C3.72464 17.5 3.30072 17.3244 2.98816 17.0118C2.67559 16.6993 2.5 16.2754 2.5 15.8333V4.16667C2.5 3.72464 2.67559 3.30072 2.98816 2.98816C3.30072 2.67559 3.72464 2.5 4.16667 2.5H7.5"
                :stroke="isDark ? '#749DC8' : '#38618C'" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
              <path d="M13.333 14.1667L17.4997 10L13.333 5.83337" :stroke="isDark ? '#749DC8' : '#38618C'"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M17.5 10H7.5" :stroke="isDark ? '#749DC8' : '#38618C'" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
            <span class="text-sm font-medium">Logout</span>
          </div>
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
                <h1 class="text-3xl font-bold" :class="isDark ? 'text-white' : 'text-slate-900'">Dashboard</h1>
                <p class="text-sm mt-1" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Welcome, User!</p>
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

                <!-- Search -->
                <button class="p-2 rounded-lg transition-colors"
                  :class="isDark ? 'hover:bg-[#1A2A3A]' : 'hover:bg-slate-100'">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <circle cx="9" cy="9" r="7" :stroke="isDark ? '#749DC8' : '#38618C'" stroke-width="1.5" />
                    <path d="M13 13L16 16" :stroke="isDark ? '#749DC8' : '#38618C'" stroke-width="1.5"
                      stroke-linecap="round" />
                  </svg>
                </button>

                <!-- Menu Grid -->
                <button class="p-2 rounded-lg transition-colors"
                  :class="isDark ? 'hover:bg-[#1A2A3A]' : 'hover:bg-slate-100'">
                  <div class="grid grid-cols-3 gap-1 w-5 h-5">
                    <div v-for="i in 9" :key="i" class="w-1 h-1 rounded-full"
                      :class="isDark ? 'bg-[#749DC8]' : 'bg-slate-600'"></div>
                  </div>
                </button>

                <!-- Notifications Button -->
                <button @click="toggleNotifications"
                  class="px-3 py-1.5 rounded-full flex items-center gap-2 bg-[#A8000B] text-white text-xs font-medium cursor-pointer hover:bg-[#8A0009] transition-colors">
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor">
                    <path
                      d="M6 1C5.44772 1 5 1.44772 5 2V3H2C1.44772 3 1 3.44772 1 4V10C1 10.5523 1.44772 11 2 11H10C10.5523 11 11 10.5523 11 10V4C11 3.44772 10.5523 3 10 3H7V2C7 1.44772 6.55228 1 6 1Z" />
                  </svg>
                  15
                </button>

                <!-- User Profile -->
                <div class="flex items-center gap-3 cursor-pointer">
                  <img
                    src="https://api.builder.io/api/v1/image/assets/TEMP/6878da621cc6fbc5afde884e8db308ccb609ab42?width=56"
                    alt="User" class="w-8 h-8 rounded object-cover" />
                  <div class="flex items-center gap-2">
                    <span class="text-sm font-medium" :class="isDark ? 'text-[#749DC8]' : 'text-slate-900'">
                      Pixelz Warrios
                    </span>
                    <svg width="4" height="6" viewBox="0 0 4 6" fill="none">
                      <path d="M0 0L2 3L4 0" :stroke="isDark ? '#749DC8' : '#38618C'" stroke-width="1" />
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </header>

          <!-- Floating Notifications Panel -->
          <div v-if="showNotifications" class="fixed right-0 top-24 z-50">
            <div class="w-80 rounded-lg shadow-xl border m-4" :class="isDark
              ? 'bg-[#0F1A27] border-[#1A2A3A]'
              : 'bg-white border-slate-200'">

              <!-- Panel Header -->
              <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                <div class="flex items-center justify-between">
                  <h3 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                    Notifications
                  </h3>
                  <button @click="toggleNotifications"
                    class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Notifications List -->
              <div class="max-h-96 overflow-y-auto">
                <div v-for="(notif, index) in notifications" :key="index" class="p-4 border-b last:border-b-0"
                  :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-100'">
                  <div class="flex items-start gap-3">
                    <div v-if="notif.initial" :class="[
                      'w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0',
                      notif.type === 'transaction'
                        ? 'bg-gradient-to-br from-[#00FF19] to-[#00CC14]'
                        : 'bg-gradient-to-br from-[#A8000B] to-[#8A0009]',
                    ]">
                      {{ notif.initial }}
                    </div>
                    <div v-else class="w-8 h-8 rounded-full flex-shrink-0"
                      :class="isDark ? 'bg-[#1A2A3A]' : 'bg-slate-200'">
                    </div>

                    <div class="flex-1 min-w-0">
                      <h4 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">{{ notif.name
                        }}</h4>
                      <p class="text-xs mt-1" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{ notif.message }}
                      </p>
                      <div v-if="notif.amount" class="text-xs text-[#00FF19] mt-1 font-medium">{{ notif.amount }}</div>
                      <div v-if="notif.change" class="text-xs text-[#00FF19] mt-1 font-medium">{{ notif.change }}</div>
                      <div class="text-xs mt-2" :class="isDark ? 'text-slate-500' : 'text-slate-500'">{{ notif.time }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Panel Footer -->
              <div class="p-4 border-t" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                <a href="#" class="text-xs text-[#0074CC] hover:underline block text-center">See All Notifications</a>
              </div>
            </div>
          </div>

          <!-- Content -->
          <main class="p-8">
            <!-- Statistics Section -->
            <div class="mb-8">
              <h2 class="text-xs font-semibold uppercase tracking-widest mb-4"
                :class="isDark ? 'text-[#B1AFCD]' : 'text-slate-600'">
                Statistics
              </h2>

              <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Primary Card -->
                <div
                  class="rounded-xl bg-[#0074CC] text-white p-6 relative overflow-hidden group cursor-pointer hover:shadow-lg transition-shadow">
                  <div class="absolute inset-0 opacity-20 group-hover:opacity-30"
                    style="background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.1) 100%)">
                  </div>
                  <div class="relative">
                    <div class="text-2xl font-bold mb-1">1.9678</div>
                    <div class="text-xs font-medium">+12.5%</div>
                  </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="rounded-xl p-6 border"
                  :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                  <div class="text-xl font-semibold mb-1" :class="isDark ? 'text-white' : 'text-slate-900'">23.234</div>
                  <div class="text-xs" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">ETH</div>
                </div>

                <!-- Stat Card 3 -->
                <div class="rounded-xl p-6 border"
                  :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                  <div class="text-xl font-semibold text-[#00FF19] mb-1">380.234</div>
                  <div class="text-xs" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">LTC</div>
                </div>

                <!-- Add Currency -->
                <div
                  class="rounded-xl border-2 border-dashed p-6 flex items-center justify-center cursor-pointer transition-colors"
                  :class="isDark ? 'border-[#1A2A3A] hover:bg-[#1A2A3A]' : 'border-slate-300 hover:bg-slate-50'">
                  <div class="text-xs font-bold" :class="isDark ? 'text-[#5B5A99]' : 'text-slate-400'">+ Add Currency
                  </div>
                </div>
              </div>
            </div>

            <!-- Graph and Layout -->
            <div class="grid grid-cols-1 xl:grid-cols-1 gap-6">
              <!-- Left Column: Graph and Trends -->
              <div class="space-y-6">
                <!-- Chart Card -->
                <div class="rounded-xl p-6 h-96 flex items-center justify-center border"
                  :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                  <!-- Graph Section -->
                  <section class="relative w-full h-full">
                    <!-- Legend -->
                    <div class="absolute top-0 left-0 z-10">
                      <div class="flex items-center gap-2 px-4 py-2 rounded-full backdrop-blur-sm">
                        <div class="w-2 h-2 rounded-full bg-[#00FF19]"></div>
                        <span class="text-xs font-medium tracking-wide"
                          :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                          BTC
                        </span>
                      </div>
                    </div>

                    <!-- Users Online Label -->
                    <div class="absolute top-64 left-0 z-10">
                      <span class="text-xs font-medium tracking-wide"
                        :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                        USERS ONLINE
                      </span>
                    </div>

                    <!-- Graph Container -->
                    <div class="relative h-full mt-2">
                      <!-- Grid Background -->
                      <div class="absolute inset-0 rounded-[10px] opacity-90"
                        :style="isDark
                          ? 'background: radial-gradient(23.87% 48.48% at 39.69% 80.76%, rgba(15, 26, 39, 0.90) 0%, rgba(15, 26, 39, 0.00) 100%)'
                          : 'background: radial-gradient(23.87% 48.48% at 39.69% 80.76%, rgba(237, 242, 247, 0.90) 0%, rgba(237, 242, 247, 0.00) 100%)'">
                      </div>

                      <!-- Y-axis labels -->
                      <div class="absolute left-0 top-2 flex flex-col justify-between h-[375px] text-right pr-2">
                        <span v-for="label in yLabels" :key="label" class="text-xs tracking-wide"
                          :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                          {{ label }}
                        </span>
                      </div>

                      <!-- X-axis labels -->
                      <div class="absolute bottom-0 left-16 right-0 flex justify-between px-1">
                        <span v-for="label in timeLabels" :key="label" class="text-xs tracking-wide text-center"
                          :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                          {{ label }}
                        </span>
                      </div>

                      <!-- Main Chart SVG -->
                      <svg class="absolute left-[51px] top-[104px] w-[899px] h-[206px]" viewBox="0 0 903 210"
                        fill="none">
                        <!-- Glow Effect -->
                        <defs>
                          <filter id="glow">
                            <feGaussianBlur stdDeviation="52" result="coloredBlur" />
                            <feMerge>
                              <feMergeNode in="coloredBlur" />
                              <feMergeNode in="SourceGraphic" />
                            </feMerge>
                          </filter>
                        </defs>

                        <!-- Gradient Fill (subtle) -->
                        <path opacity="0.1" filter="url(#glow)"
                          d="M2 198.967L33.871 206.72C37.1906 207.527 40.6863 207.177 43.78 205.728L81.9759 187.833C83.9676 186.9 86.1401 186.416 88.3396 186.416H118.431C122.024 186.416 125.497 185.127 128.22 182.782L158.016 157.121C161.762 153.895 166.856 152.722 171.635 153.984L192.87 159.593C196.789 160.628 200.96 160.033 204.433 157.944L232.107 141.297C236.412 138.707 241.728 138.444 246.268 140.598L269.406 151.574C275.631 154.527 283.066 152.86 287.434 147.532L308.821 121.45C312.05 117.512 317.056 115.481 322.115 116.057L373.473 121.896C376.734 122.267 380.027 121.558 382.846 119.878L433.701 89.5769C435.222 88.6707 436.891 88.0409 438.631 87.7167L545.401 67.8242C548.396 67.2662 551.49 67.6334 554.271 68.8771L587.051 83.5347C593.221 86.2938 600.475 84.5853 604.765 79.3624L634.436 43.2415C637.873 39.0565 643.3 37.0496 648.633 37.9908L708.475 48.5512C713.48 49.4343 718.591 47.7236 722.056 44.0059L743.431 21.0689C747.433 16.7747 753.572 15.2093 759.142 17.0631L781.197 24.4041C784.917 25.6423 788.974 25.3748 792.499 23.6591L820.782 9.89333C823.528 8.55647 826.618 8.09007 829.637 8.55651L861.407 13.4652C863.768 13.83 866.182 13.6256 868.448 12.869L901 2"
                          :stroke="isDark ? '#00FF19' : '#01FF19'" stroke-width="4" stroke-linecap="round"
                          stroke-linejoin="round" />

                        <!-- Main Line -->
                        <path
                          d="M2 198.967L33.871 206.72C37.1906 207.527 40.6863 207.177 43.78 205.728L81.9759 187.833C83.9676 186.9 86.1401 186.416 88.3396 186.416H118.431C122.024 186.416 125.497 185.127 128.22 182.782L158.016 157.121C161.762 153.895 166.856 152.722 171.635 153.984L192.87 159.593C196.789 160.628 200.96 160.033 204.433 157.944L232.107 141.297C236.412 138.707 241.728 138.444 246.268 140.598L269.406 151.574C275.631 154.527 283.066 152.86 287.434 147.532L308.821 121.45C312.05 117.512 317.056 115.481 322.115 116.057L373.473 121.896C376.734 122.267 380.027 121.558 382.846 119.878L433.701 89.5769C435.222 88.6707 436.891 88.0409 438.631 87.7167L545.401 67.8242C548.396 67.2662 551.49 67.6334 554.271 68.8771L587.051 83.5347C593.221 86.2938 600.475 84.5853 604.765 79.3624L634.436 43.2415C637.873 39.0565 643.3 37.0496 648.633 37.9908L708.475 48.5512C713.48 49.4343 718.591 47.7236 722.056 44.0059L743.431 21.0689C747.433 16.7747 753.572 15.2093 759.142 17.0631L781.197 24.4041C784.917 25.6423 788.974 25.3748 792.499 23.6591L820.782 9.89333C823.528 8.55647 826.618 8.09007 829.637 8.55651L861.407 13.4652C863.768 13.83 866.182 13.6256 868.448 12.869L901 2"
                          :stroke="isDark ? '#00FF19' : '#01FF19'" stroke-width="4" stroke-linecap="round"
                          stroke-linejoin="round" />
                      </svg>
                    </div>
                  </section>
                </div>

                <!-- Trends and History -->
                <div class="grid grid-cols-2 gap-15">
                  <!-- Trends -->
                  <div>
                    <h3 class="text-xs font-semibold text-slate-600 dark:text-[#B1AFCD] uppercase tracking-widest mb-4">
                      Trend</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                      <div v-for="trend in trends" :key="trend.symbol"
                        class="rounded-xl bg-white dark:bg-[#0F1A27] border border-slate-200 dark:border-[#1A2A3A] p-4">
                        <div class="flex items-center justify-between mb-3">
                          <div class="text-sm font-bold text-slate-900 dark:text-white">{{
                            trend.symbol }}
                          </div>
                          <div :class="['text-xs font-medium', trend.positive ? 'text-[#00FF19]' : 'text-[#A8000B]']">
                            {{ trend.change }}
                          </div>
                        </div>
                        <div class="text-lg font-semibold text-slate-900 dark:text-white">{{ trend.value
                        }}
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- History -->
                  <div>
                    <div class="flex items-center justify-between mb-4">
                      <h3 class="text-xs font-semibold uppercase tracking-widest"
                        :class="isDark ? 'text-[#B1AFCD]' : 'text-slate-600'">
                        History
                      </h3>
                      <a href="#" class="text-xs text-[#0074CC] hover:underline">See All</a>
                    </div>

                    <div class="space-y-2">
                      <div v-for="(item, index) in history" :key="index" :class="[
                        'flex items-center justify-between p-4 rounded-lg transition-colors',
                        item.highlighted
                          ? (isDark ? 'bg-[#0F1A27] border border-[#1A2A3A]' : 'bg-blue-50 border border-blue-200')
                          : (isDark ? 'hover:bg-[#1A2A3A]' : 'hover:bg-slate-50'),
                      ]">
                        <div class="text-sm font-medium" :class="isDark ? 'text-white' : 'text-slate-900'">{{ item.name
                          }}</div>
                        <div class="flex items-center gap-6">
                          <div class="text-xs font-medium" :class="item.positive ? 'text-[#00FF19]' : 'text-[#A8000B]'">
                            {{ item.amount }}
                          </div>
                          <div class="text-xs w-20 text-right" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{
                            item.date }}</div>
                        </div>
                      </div>
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
import { ref } from 'vue'

// Add theme state management
const isDark = ref(false)
const showNotifications = ref(false)

const toggleTheme = () => {
  isDark.value = !isDark.value
}

const toggleNotifications = () => {
  showNotifications.value = !showNotifications.value
}

// Navigation items
const navItems = [
  { name: 'Dashboard', active: true },
  { name: 'Wallet', active: false },
  { name: 'Messages', active: false, badge: true },
  { name: 'Trade', active: false },
  { name: 'Account Setting', active: false },
  { name: 'Clients', active: false },
]

// Trend data
const trends = [
  { symbol: 'BTC', value: '7.356,67', change: '-5.23%', positive: false },
  { symbol: 'ETH', value: '465,22', change: '+132%', positive: true },
  { symbol: 'LTC', value: '104,23', change: '+75.69%', positive: true },
]

// Transaction history
const history = [
  { name: 'Akhirnya Joko bayar Utang', amount: '+0.025', date: '08/26/2018', positive: true },
  { name: 'Cicilan mobil', amount: '-5.23%', date: '08/26/2018', positive: false },
  { name: 'Buat beli susu anak', amount: '-5.23%', date: '08/26/2018', positive: false, highlighted: true },
  { name: 'Langganan odobe CC', amount: '-5.23%', date: '08/26/2018', positive: false },
  { name: 'Hasil mining 3 mingguu', amount: '+0.025', date: '08/26/2018', positive: true },
]

// Notifications
const notifications = [
  {
    name: 'Clifford Hale',
    message: 'Hello! I have a problem with my payment methods..',
    time: '2 hours ago',
    type: 'message',
  },
  {
    name: 'Lottie Marsh',
    message: 'New transaction',
    amount: '+380.234 LTC',
    time: '3 hours ago',
    type: 'transaction',
    positive: true,
    initial: 'L',
  },
  {
    name: 'BTC',
    message: 'Bitcoin is up by 5 points today.',
    change: '+39.69%',
    time: '3 hours ago',
    type: 'news',
    initial: 'B',
  },
  {
    name: 'Danny Jacobs',
    message: "Let's talk when we have time.",
    time: '2 hours ago',
    type: 'message',
  },
]

// Graph labels
const timeLabels = ['10:59PM', '11:59PM', '12:59AM', '1:59AM', '2:59AM', '3:59AM', '4:59AM', '5:59AM', '6:59AM', '7:59AM']
const yLabels = ['6.500', '6.000', '5.500', '5.000', '4500', '4000', '3500', '3000', '2500', '2000']
</script>