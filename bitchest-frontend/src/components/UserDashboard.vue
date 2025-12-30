<template>
  <div class="min-h-screen transition-colors duration-300" :class="isDark ? 'bg-black' : 'bg-white'">
    <!-- Loading State -->
    <div v-if="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="text-white">
        <div class="w-16 h-16 border-4 border-t-transparent border-[#00FF19] rounded-full animate-spin mx-auto"></div>
        <p class="mt-4">Loading your dashboard...</p>
      </div>
    </div>

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
              <path d="M17.5 10H7.5" :stroke="isDark ? '#749DC8' : '#38618C'" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
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
                <h1 class="text-3xl font-bold" :class="isDark ? 'text-white' : 'text-slate-900'">Dashboard</h1>
                <p class="text-sm mt-1" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                  Welcome back, {{ userName }}! • Portfolio: {{ formatCurrency(portfolioValue) }}
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

                <!-- Refresh Data -->
                <button @click="fetchData" :disabled="loading" class="p-2 rounded-lg transition-colors"
                  :class="isDark ? 'hover:bg-[#1A2A3A]' : 'hover:bg-slate-100'" title="Refresh data">
                  <svg class="w-5 h-5" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
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

                <!-- Notifications Button -->
                <button @click="toggleNotifications"
                  class="px-3 py-1.5 rounded-full flex items-center gap-2 bg-[#A8000B] text-white text-xs font-medium cursor-pointer hover:bg-[#8A0009] transition-colors relative">
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor">
                    <path
                      d="M6 1C5.44772 1 5 1.44772 5 2V3H2C1.44772 3 1 3.44772 1 4V10C1 10.5523 1.44772 11 2 11H10C10.5523 11 11 10.5523 11 10V4C11 3.44772 10.5523 3 10 3H7V2C7 1.44772 6.55228 1 6 1Z" />
                  </svg>
                  {{ notifications.length }}
                  <span v-if="unreadNotifications > 0"
                    class="absolute -top-1 -right-1 w-2 h-2 rounded-full bg-[#00FF19]"></span>
                </button>

                <!-- User Profile -->
                <div class="flex items-center gap-3 cursor-pointer" @click="showProfileMenu = !showProfileMenu">
                  <div
                    class="w-8 h-8 rounded-full overflow-hidden bg-gradient-to-r from-[#0074CC] to-[#00FF19] flex items-center justify-center text-white font-bold">
                    {{ userInitials }}
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="text-sm font-medium" :class="isDark ? 'text-[#749DC8]' : 'text-slate-900'">
                      {{ userName }}
                    </span>
                    <svg width="4" height="6" viewBox="0 0 4 6" fill="none">
                      <path d="M0 0L2 3L4 0" :stroke="isDark ? '#749DC8' : '#38618C'" stroke-width="1" />
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </header>

          <!-- Profile Menu Dropdown -->
          <div v-if="showProfileMenu" class="fixed right-8 top-24 z-50">
            <div class="w-48 rounded-lg shadow-xl border m-4" :class="isDark
              ? 'bg-[#0F1A27] border-[#1A2A3A]'
              : 'bg-white border-slate-200'">
              <div class="p-3 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                <p class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">{{ userName }}</p>
                <p class="text-xs" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{ userEmail }}</p>
              </div>
              <div class="p-2">
                <button @click="router.push('/settings')"
                  class="w-full text-left px-3 py-2 text-sm rounded hover:bg-gray-100 dark:hover:bg-[#1A2A3A] transition-colors"
                  :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                  Profile Settings
                </button>
                <button @click="logout"
                  class="w-full text-left px-3 py-2 text-sm rounded hover:bg-gray-100 dark:hover:bg-[#1A2A3A] transition-colors text-[#A8000B]">
                  Logout
                </button>
              </div>
            </div>
          </div>

          <!-- Floating Notifications Panel -->
          <div v-if="showNotifications" class="fixed right-0 top-24 z-50">
            <div class="w-80 rounded-lg shadow-xl border m-4" :class="isDark
              ? 'bg-[#0F1A27] border-[#1A2A3A]'
              : 'bg-white border-slate-200'">

              <!-- Panel Header -->
              <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                <div class="flex items-center justify-between">
                  <h3 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                    Notifications ({{ notifications.length }})
                  </h3>
                  <div class="flex items-center gap-2">
                    <button @click="markAllAsRead" class="text-xs text-[#0074CC] hover:underline">
                      Mark all as read
                    </button>
                    <button @click="toggleNotifications"
                      class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>

              <!-- Notifications List -->
              <div class="max-h-96 overflow-y-auto">
                <div v-for="(notif, index) in notifications" :key="index" @click="handleNotificationClick(notif)"
                  class="p-4 border-b last:border-b-0 cursor-pointer transition-colors" :class="[
                    isDark ? 'border-[#1A2A3A] hover:bg-[#1A2A3A]' : 'border-slate-100 hover:bg-slate-50',
                    !notif.read ? (isDark ? 'bg-[#1A2A3A]' : 'bg-blue-50') : ''
                  ]">
                  <div class="flex items-start gap-3">
                    <div :class="[
                      'w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0',
                      getNotificationColor(notif.type)
                    ]">
                      {{ notif.type.charAt(0).toUpperCase() }}
                    </div>

                    <div class="flex-1 min-w-0">
                      <div class="flex justify-between items-start">
                        <h4 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                          {{ notif.title }}
                        </h4>
                        <span class="text-xs" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                          {{ formatTimeAgo(notif.created_at) }}
                        </span>
                      </div>
                      <p class="text-xs mt-1" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                        {{ notif.message }}
                      </p>
                      <div v-if="notif.amount" class="text-xs font-medium mt-1"
                        :class="notif.amount > 0 ? 'text-[#00FF19]' : 'text-[#A8000B]'">
                        {{ formatCurrency(notif.amount) }}
                      </div>
                      <div v-if="!notif.read"
                        class="inline-block mt-2 px-2 py-1 text-xs rounded bg-[#0074CC] text-white">
                        New
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Panel Footer -->
              <div class="p-4 border-t" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                <button @click="router.push('/messages')"
                  class="text-xs text-[#0074CC] hover:underline block text-center w-full">
                  View All Notifications
                </button>
              </div>
            </div>
          </div>

          <!-- Content -->
          <main class="p-8">
            <!-- Portfolio Summary -->
            <div class="mb-8">
              <h2 class="text-xs font-semibold uppercase tracking-widest mb-4"
                :class="isDark ? 'text-[#B1AFCD]' : 'text-slate-600'">
                Portfolio Summary
              </h2>

              <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Total Portfolio Value -->
                <div
                  class="rounded-xl bg-[#0074CC] text-white p-6 relative overflow-hidden group cursor-pointer hover:shadow-lg transition-shadow"
                  @click="router.push('/wallet')">
                  <div class="absolute inset-0 opacity-20 group-hover:opacity-30"
                    style="background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.1) 100%)">
                  </div>
                  <div class="relative">
                    <div class="text-2xl font-bold mb-1">{{ formatCurrency(portfolioValue) }}</div>
                    <div class="text-xs font-medium"
                      :class="portfolioChange >= 0 ? 'text-[#00FF19]' : 'text-[#FF5964]'">
                      {{ portfolioChange >= 0 ? '+' : '' }}{{ portfolioChange.toFixed(2) }}%
                    </div>
                  </div>
                  <div class="text-xs mt-2 opacity-90">Total Portfolio Value</div>
                </div>

                <!-- Available Balance -->
                <div class="rounded-xl p-6 border cursor-pointer hover:shadow-lg transition-shadow"
                  :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A] hover:border-[#0074CC]' : 'bg-white border-slate-200 hover:border-blue-500'"
                  @click="router.push('/wallet')">
                  <div class="text-xl font-semibold mb-1" :class="isDark ? 'text-white' : 'text-slate-900'">
                    {{ formatCurrency(availableBalance) }}
                  </div>
                  <div class="text-xs" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">Available EUR</div>
                  <div class="text-xs mt-2" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                    Click to deposit/withdraw
                  </div>
                </div>

                <!-- Top Performing Asset -->
                <div class="rounded-xl p-6 border cursor-pointer hover:shadow-lg transition-shadow"
                  :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A] hover:border-[#00FF19]' : 'bg-white border-slate-200 hover:border-green-500'"
                  @click="router.push('/trade')">
                  <div class="flex items-center justify-between mb-2">
                    <div class="text-sm font-medium" :class="isDark ? 'text-white' : 'text-slate-900'">
                      {{ topAsset.symbol }}
                    </div>
                    <div class="text-xs font-medium"
                      :class="topAsset.change >= 0 ? 'text-[#00FF19]' : 'text-[#A8000B]'">
                      {{ topAsset.change >= 0 ? '+' : '' }}{{ topAsset.change.toFixed(2) }}%
                    </div>
                  </div>
                  <div class="text-lg font-semibold text-[#00FF19]">{{ formatCurrency(topAsset.value) }}</div>
                  <div class="text-xs mt-2" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                    {{ topAsset.name }} • {{ topAsset.amount }} units
                  </div>
                </div>

                <!-- Quick Actions -->
                <div
                  class="rounded-xl border-2 border-dashed p-6 flex flex-col items-center justify-center cursor-pointer transition-colors hover:shadow-lg"
                  :class="isDark ? 'border-[#1A2A3A] hover:bg-[#1A2A3A] hover:border-[#0074CC]' : 'border-slate-300 hover:bg-slate-50 hover:border-blue-500'">
                  <div class="flex gap-3 mb-3">
                    <button @click="router.push('/trade')"
                      class="p-2 rounded-lg bg-[#00FF19] text-white hover:opacity-90 transition-opacity">
                      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                      </svg>
                    </button>
                    <button @click="router.push('/wallet')"
                      class="p-2 rounded-lg bg-[#0074CC] text-white hover:opacity-90 transition-opacity">
                      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                    </button>
                  </div>
                  <div class="text-xs font-bold text-center" :class="isDark ? 'text-[#5B5A99]' : 'text-slate-600'">
                    Quick Actions
                  </div>
                </div>
              </div>
            </div>

            <!-- Charts and Market Data -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
              <!-- Portfolio Chart -->
              <div class="lg:col-span-2">
                <div class="rounded-xl border transition-colors"
                  :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                  <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                    <div class="flex items-center justify-between">
                      <h3 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                        Portfolio Performance (Last 30 days)
                      </h3>
                      <div class="flex items-center gap-2">
                        <button v-for="interval in ['1d', '1w', '1m', '3m']" :key="interval"
                          @click="selectedInterval = interval" :class="[
                            'px-3 py-1 text-xs rounded transition-colors',
                            selectedInterval === interval
                              ? (isDark ? 'bg-[#0074CC] text-white' : 'bg-blue-500 text-white')
                              : (isDark ? 'text-[#749DC8] hover:bg-[#1A2A3A]' : 'text-slate-600 hover:bg-slate-100')
                          ]">
                          {{ interval }}
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="p-4 h-64">
                    <canvas ref="portfolioChart" class="w-full h-full"></canvas>
                  </div>
                </div>
              </div>

              <!-- Market Trends -->
              <div>
                <div class="rounded-xl border transition-colors"
                  :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                  <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                    <div class="flex items-center justify-between">
                      <h3 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                        Market Trends
                      </h3>
                      <button @click="fetchMarketTrends" :disabled="loading"
                        class="text-xs text-[#0074CC] hover:underline disabled:opacity-50">
                        Refresh
                      </button>
                    </div>
                  </div>
                  <div class="max-h-96 overflow-y-auto">
                    <div v-for="trend in marketTrends" :key="trend.symbol" @click="selectCrypto(trend)"
                      class="p-4 border-b last:border-b-0 cursor-pointer hover:opacity-90 transition-opacity"
                      :class="isDark ? 'border-[#1A2A3A] hover:bg-[#1A2A3A]' : 'border-slate-100 hover:bg-slate-50'">
                      <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                          <div
                            class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm"
                            :style="{ backgroundColor: getCryptoColor(trend.symbol) }">
                            {{ trend.symbol.charAt(0) }}
                          </div>
                          <div>
                            <div class="font-medium" :class="isDark ? 'text-white' : 'text-slate-900'">{{ trend.symbol
                            }}</div>
                            <div class="text-xs" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{ trend.name }}
                            </div>
                          </div>
                        </div>
                        <div class="text-right">
                          <div class="font-medium" :class="isDark ? 'text-white' : 'text-slate-900'">
                            {{ formatCurrency(trend.price) }}
                          </div>
                          <div
                            :class="['text-xs font-medium', trend.change >= 0 ? 'text-[#00FF19]' : 'text-[#A8000B]']">
                            {{ trend.change >= 0 ? '+' : '' }}{{ trend.change.toFixed(2) }}%
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Recent Transactions and Holdings -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <!-- Recent Transactions -->
              <div>
                <div class="rounded-xl border transition-colors"
                  :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                  <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                    <div class="flex items-center justify-between">
                      <h3 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                        Recent Transactions
                      </h3>
                      <button @click="router.push('/wallet')" class="text-xs text-[#0074CC] hover:underline">
                        View All
                      </button>
                    </div>
                  </div>
                  <div class="max-h-96 overflow-y-auto">
                    <div v-for="transaction in recentTransactions" :key="transaction.id"
                      @click="viewTransactionDetails(transaction)"
                      class="p-4 border-b last:border-b-0 cursor-pointer hover:opacity-90 transition-opacity"
                      :class="isDark ? 'border-[#1A2A3A] hover:bg-[#1A2A3A]' : 'border-slate-100 hover:bg-slate-50'">
                      <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                          <div :class="[
                            'w-10 h-10 rounded-full flex items-center justify-center',
                            transaction.type === 'buy' ? 'bg-green-100 dark:bg-green-900' : 'bg-red-100 dark:bg-red-900'
                          ]">
                            <svg class="w-5 h-5"
                              :class="transaction.type === 'buy' ? 'text-green-600 dark:text-green-300' : 'text-red-600 dark:text-red-300'"
                              viewBox="0 0 24 24" fill="none">
                              <path v-if="transaction.type === 'buy'" d="M12 5V19M12 5L6 11M12 5L18 11"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                              <path v-if="transaction.type === 'sell'" d="M12 5V19M12 19L6 13M12 19L18 13"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                          </div>
                          <div>
                            <div class="font-medium" :class="isDark ? 'text-white' : 'text-slate-900'">
                              {{ transaction.type === 'buy' ? 'Bought' : 'Sold' }} {{ transaction.amount }} {{
                                transaction.symbol }}
                            </div>
                            <div class="text-xs" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{
                              formatTimeAgo(transaction.date) }}</div>
                          </div>
                        </div>
                        <div class="text-right">
                          <div class="font-medium" :class="isDark ? 'text-white' : 'text-slate-900'">
                            {{ formatCurrency(transaction.value) }}
                          </div>
                          <div :class="['text-xs', transaction.type === 'buy' ? 'text-[#00FF19]' : 'text-[#A8000B]']">
                            {{ transaction.type === 'buy' ? '-' : '+' }}{{ formatCurrency(transaction.fee) }} fee
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Your Holdings -->
              <div>
                <div class="rounded-xl border transition-colors"
                  :class="isDark ? 'bg-[#0F1A27] border-[#1A2A3A]' : 'bg-white border-slate-200'">
                  <div class="p-4 border-b" :class="isDark ? 'border-[#1A2A3A]' : 'border-slate-200'">
                    <div class="flex items-center justify-between">
                      <h3 class="text-sm font-semibold" :class="isDark ? 'text-white' : 'text-slate-900'">
                        Your Holdings
                      </h3>
                      <button @click="router.push('/wallet')" class="text-xs text-[#0074CC] hover:underline">
                        Manage
                      </button>
                    </div>
                  </div>
                  <div class="max-h-96 overflow-y-auto">
                    <div v-for="holding in holdings" :key="holding.symbol"
                      @click="router.push({ path: '/trade', query: { crypto: holding.symbol } })"
                      class="p-4 border-b last:border-b-0 cursor-pointer hover:opacity-90 transition-opacity"
                      :class="isDark ? 'border-[#1A2A3A] hover:bg-[#1A2A3A]' : 'border-slate-100 hover:bg-slate-50'">
                      <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                          <div
                            class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm"
                            :style="{ backgroundColor: getCryptoColor(holding.symbol) }">
                            {{ holding.symbol.charAt(0) }}
                          </div>
                          <div>
                            <div class="font-medium" :class="isDark ? 'text-white' : 'text-slate-900'">{{ holding.symbol
                            }}</div>
                            <div class="text-xs" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">{{ holding.name
                            }}</div>
                          </div>
                        </div>
                        <div class="text-right">
                          <div class="font-medium" :class="isDark ? 'text-white' : 'text-slate-900'">
                            {{ holding.amount }}
                          </div>
                          <div class="text-xs" :class="isDark ? 'text-[#749DC8]' : 'text-slate-600'">
                            {{ formatCurrency(holding.value) }}
                          </div>
                          <div
                            :class="['text-xs font-medium', holding.change >= 0 ? 'text-[#00FF19]' : 'text-[#A8000B]']">
                            {{ holding.change >= 0 ? '+' : '' }}{{ holding.change.toFixed(2) }}%
                          </div>
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
import { ref, onMounted, watch, nextTick, computed, onUnmounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { adminAPI, marketAPI, authAPI, walletAPI } from '../services/api'
import Chart from 'chart.js/auto'

const router = useRouter()
const route = useRoute()
const isDark = ref(false)
const loading = ref(true)
const showNotifications = ref(false)
const showProfileMenu = ref(false)
const selectedInterval = ref('1m')

// Références pour les charts
const portfolioChart = ref<HTMLCanvasElement | null>(null)
let portfolioChartInstance: Chart | null = null

// Données utilisateur
const userName = ref('')
const userEmail = ref('')
const userInitials = ref('')
const portfolioValue = ref(0)
const portfolioChange = ref(0)
const availableBalance = ref(0)

// Données dynamiques
const holdings = ref<any[]>([])
const marketTrends = ref<any[]>([])
const recentTransactions = ref<any[]>([])
const notifications = ref<any[]>([])

// Calcul des valeurs dérivées
const unreadNotifications = computed(() => {
  return notifications.value.filter(n => !n.read).length
})

const unreadMessages = computed(() => {
  return notifications.value.filter(n => n.type === 'message' && !n.read).length
})

const topAsset = computed(() => {
  if (holdings.value.length === 0) {
    return { symbol: 'N/A', name: 'No assets', value: 0, change: 0, amount: 0 }
  }
  const sorted = [...holdings.value].sort((a, b) => b.change - a.change)
  return sorted[0]
})

const currentPath = computed(() => route.path)

const navItems = [
  { name: 'Dashboard', path: '/user-dashboard' },
  { name: 'Wallet', path: '/wallet' },
  { name: 'Messages', path: '/messages' },
  { name: 'Trade', path: '/trade' },
  { name: 'Account Setting', path: '/settings' },
]

// Formatters
const formatCurrency = (value: number) => {
  if (value >= 1000000) {
    return `€${(value / 1000000).toFixed(1)}M`
  } else if (value >= 1000) {
    return `€${(value / 1000).toFixed(1)}K`
  }
  return `€${value.toFixed(2)}`
}

const formatTimeAgo = (timestamp: string) => {
  const date = new Date(timestamp)
  const now = new Date()
  const diffMs = now.getTime() - date.getTime()
  const diffMins = Math.floor(diffMs / 60000)
  const diffHours = Math.floor(diffMs / 3600000)
  const diffDays = Math.floor(diffMs / 86400000)

  if (diffMins < 60) {
    return `${diffMins}m ago`
  } else if (diffHours < 24) {
    return `${diffHours}h ago`
  } else {
    return `${diffDays}d ago`
  }
}

// Helper functions
const getCryptoColor = (symbol: string) => {
  const colors: Record<string, string> = {
    BTC: '#F7931A',
    ETH: '#627EEA',
    ADA: '#0033AD',
    SOL: '#00FFA3',
    XRP: '#23292F',
    LTC: '#BFBBBB',
    DOGE: '#C2A633',
    DOT: '#E6007A',
    BCH: '#8DC451',
    XLM: '#14B6E7'
  }
  return colors[symbol] || '#0074CC'
}

const getNotificationColor = (type: string) => {
  switch (type) {
    case 'transaction': return 'bg-gradient-to-br from-[#00FF19] to-[#00CC14]'
    case 'message': return 'bg-gradient-to-br from-[#0074CC] to-[#0055AA]'
    case 'alert': return 'bg-gradient-to-br from-[#A8000B] to-[#8A0009]'
    case 'info': return 'bg-gradient-to-br from-[#FF5964] to-[#CC4752]'
    default: return 'bg-gradient-to-br from-[#38618C] to-[#2A4A6F]'
  }
}

// Navigation
const navigateTo = (path: string) => {
  router.push(path)
}

const selectCrypto = (crypto: any) => {
  router.push({
    path: '/trade',
    query: { crypto: crypto.symbol }
  })
}

const viewTransactionDetails = (transaction: any) => {
  router.push({
    path: '/wallet',
    query: { transaction: transaction.id }
  })
}

const handleNotificationClick = (notification: any) => {
  notification.read = true
  if (notification.link) {
    router.push(notification.link)
  }
}

// Data fetching
const fetchData = async () => {
  loading.value = true
  try {
    // Use Promise.allSettled to prevent one failure from stopping all requests
    await Promise.allSettled([
      fetchPortfolioData(),
      fetchMarketTrends(),
      fetchRecentTransactions(),
      fetchNotifications(),
      fetchWalletInfo()
    ])

    // Initialize chart after data is loaded
    await nextTick()
    initializeChart()
  } catch (error) {
    console.error('Error fetching data:', error)
    // Don't redirect on error - just log it
  } finally {
    loading.value = false
  }
}

const fetchPortfolioData = async () => {
  try {
    const data = await marketAPI.getWalletInfo()
    portfolioValue.value = data.total_value || 0
    portfolioChange.value = data.daily_change || 0
    availableBalance.value = data.available_balance || 0
    holdings.value = (data.holdings || []).map((holding: any) => ({
      ...holding,
      change: parseFloat(holding.change || 0),
      value: parseFloat(holding.value || 0),
      amount: parseFloat(holding.amount || 0)
    }))
  } catch (error) {
    console.error('Error fetching portfolio data:', error)
    // Keep default values on error instead of mock data
    portfolioValue.value = 0
    portfolioChange.value = 0
    availableBalance.value = 0
    holdings.value = []
  }
}

const fetchMarketTrends = async () => {
  try {
    const data = await marketAPI.getTrends()
    marketTrends.value = data.map((trend: any) => ({
      ...trend,
      price: parseFloat(trend.price),
      change: parseFloat(trend.change)
    }))
  } catch (error) {
    console.error('Error fetching market trends:', error)
    // Keep empty array on error instead of mock data
    marketTrends.value = []
  }
}

const fetchRecentTransactions = async () => {
  try {
    const data = await walletAPI.getRecentTransactions()
    recentTransactions.value = data.map((transaction: any) => ({
      ...transaction,
      value: parseFloat(transaction.value || transaction.total || 0),
      fee: parseFloat(transaction.fee || 0)
    }))
  } catch (error) {
    console.error('Error fetching recent transactions:', error)
    // Keep empty array on error instead of mock data
    recentTransactions.value = []
  }
}

const fetchNotifications = async () => {
  try {
    const data = await marketAPI.getNotifications()
    notifications.value = data
  } catch (error) {
    console.error('Error fetching notifications:', error)
    // Keep empty array on error instead of mock data
    notifications.value = []
  }
}

const fetchWalletInfo = async () => {
  try {
    const data = await marketAPI.getWalletInfo()
    availableBalance.value = data.available_balance || availableBalance.value
  } catch (error) {
    console.error('Error fetching wallet info:', error)
  }
}

// Chart functions
const initializeChart = () => {
  destroyChart()

  if (portfolioChart.value) {
    portfolioChartInstance = new Chart(portfolioChart.value, {
      type: 'line',
      data: {
        labels: Array.from({ length: 30 }, (_, i) => `Day ${i + 1}`),
        datasets: [{
          label: 'Portfolio Value (€)',
          data: Array.from({ length: 30 }, (_, i) => {
            const base = portfolioValue.value * 0.8
            const trend = Math.sin(i / 5) * 0.1 + (i * 0.02)
            return base * (1 + trend)
          }),
          borderColor: '#00FF19',
          backgroundColor: 'rgba(0, 255, 25, 0.1)',
          tension: 0.4,
          fill: true
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: false,
            grid: {
              color: isDark.value ? 'rgba(116, 157, 200, 0.1)' : 'rgba(148, 163, 184, 0.1)'
            },
            ticks: {
              color: isDark.value ? '#749DC8' : '#64748b',
              callback: function (value) {
                return '€' + value.toLocaleString()
              }
            }
          },
          x: {
            grid: {
              color: isDark.value ? 'rgba(116, 157, 200, 0.1)' : 'rgba(148, 163, 184, 0.1)'
            },
            ticks: {
              color: isDark.value ? '#749DC8' : '#64748b'
            }
          }
        }
      }
    })
  }
}

const destroyChart = () => {
  if (portfolioChartInstance) {
    portfolioChartInstance.destroy()
    portfolioChartInstance = null
  }
}

const updateChartTheme = () => {
  if (portfolioChartInstance) {
    portfolioChartInstance.options.scales!.x!.grid!.color = isDark.value ? 'rgba(116, 157, 200, 0.1)' : 'rgba(148, 163, 184, 0.1)'
    portfolioChartInstance.options.scales!.x!.ticks!.color = isDark.value ? '#749DC8' : '#64748b'
    portfolioChartInstance.options.scales!.y!.grid!.color = isDark.value ? 'rgba(116, 157, 200, 0.1)' : 'rgba(148, 163, 184, 0.1)'
    portfolioChartInstance.options.scales!.y!.ticks!.color = isDark.value ? '#749DC8' : '#64748b'
    portfolioChartInstance.update()
  }
}

// UI functions
const toggleTheme = () => {
  isDark.value = !isDark.value
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
  updateChartTheme()
}

const toggleNotifications = () => {
  showNotifications.value = !showNotifications.value
}

const markAllAsRead = () => {
  notifications.value.forEach(notification => {
    notification.read = true
  })
}

// Logout
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
  // Load theme preference
  const savedTheme = localStorage.getItem('theme')
  isDark.value = savedTheme === 'dark'

  // Load user data
  const user = JSON.parse(localStorage.getItem('user') || '{}')
  userName.value = user.name || 'User'
  userEmail.value = user.email || 'user@bitchest.com'
  userInitials.value = userName.value.split(' ').map((n: string) => n[0]).join('').toUpperCase()

  // Fetch data
  await fetchData()

  // Set up auto-refresh
  setInterval(fetchData, 60000) // Refresh every minute
})

onUnmounted(() => {
  destroyChart()
})

// Watch for theme changes
watch(isDark, () => {
  updateChartTheme()
})

// Watch for interval changes
watch(selectedInterval, async (newInterval) => {
  // Re-fetch portfolio data with new interval
  loading.value = true
  try {
    await fetchPortfolioData()
    await nextTick()
    initializeChart()
  } catch (error) {
    console.error('Error updating chart data:', error)
  } finally {
    loading.value = false
  }
})
</script>