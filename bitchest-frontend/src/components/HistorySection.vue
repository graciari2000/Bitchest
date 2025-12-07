<script setup lang="ts">
defineProps<{
    isDark: boolean
}>()

const transactions = [
    { name: 'Akhirnya Joko bayar Utang', date: '08/26/2018', amount: '+0.025', type: 'positive', icon: 'btc' },
    { name: 'Cicilan mobil', date: '08/26/2018', amount: '-5.23%', type: 'negative', icon: 'eth' },
    { name: 'Buat beli susu anak', date: '08/26/2018', amount: '-5.23%', type: 'negative', icon: 'eth', featured: true },
    { name: 'Langganan odobe CC', date: '08/26/2018', amount: '-5.23%', type: 'negative', icon: 'ltc' },
    { name: 'Hasil mining 3 mingguu', date: '08/26/2018', amount: '+0.025', type: 'positive', icon: 'btc' },
]
</script>

<template>
    <section>
        <div class="flex items-center justify-between mb-9">
            <h2 class="text-xs font-medium uppercase tracking-wide text-muted-light">
                History
            </h2>
            <button class="text-xs" :class="isDark ? 'text-muted' : 'text-muted-dark'">
                See All
            </button>
        </div>

        <div class="space-y-5">
            <div v-for="(tx, i) in transactions" :key="i" class="flex items-start gap-3 transition-all" :class="[
                tx.featured
                    ? 'p-4 -mx-4 rounded-[10px] backdrop-blur-sm shadow-card'
                    : '',
                tx.featured && isDark
                    ? 'bg-gradient-to-r from-black/54 via-background-card/87 to-black/50'
                    : tx.featured
                        ? 'bg-gradient-to-r from-background-card-light/87 to-white/50'
                        : ''
            ]">

                <!-- Icon -->
                <div class="flex-shrink-0 w-5 h-5 rounded-full flex items-center justify-center border" :class="[
                    isDark ? 'border-background-card' : 'border-background-card-light',
                    tx.featured ? 'w-[26px] h-[26px]' : ''
                ]">
                    <!-- BTC Icon -->
                    <svg v-if="tx.icon === 'btc'" class="w-2 h-2.5" viewBox="0 0 7 10" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M2.21035 2.47813L2.21811 4.19381H4.50409C4.91009 4.19381 5.23912 3.83833 5.23708 3.40114L5.23651 3.2708C5.23454 2.83354 4.90233 2.47813 4.49627 2.47813H2.52329H2.21035ZM5.52719 6.80173L5.52655 6.664C5.52439 6.17633 5.15427 5.78037 4.70146 5.78037H4.51122H2.2253L2.23395 7.68543H4.71005C5.16286 7.68543 5.52941 7.28879 5.52719 6.80173ZM6.25274 4.85421C6.70764 5.30558 6.99609 5.94886 6.99934 6.664L6.99997 6.80173C7.00614 8.16323 5.98209 9.27131 4.71724 9.27131H4.66126L4.66451 10H3.19179L3.18848 9.27131H2.58486L2.58817 10H1.11545L1.11214 9.27131H0.768354H0.0379725L0.030785 7.68543H0.761167L0.75258 5.78037L0.745329 4.19381L0.737569 2.47813H0.00718742L0 0.891638H1.07417L1.07016 0H2.54288L2.54689 0.891638H3.15057L3.1465 0H4.61928L4.62329 0.899103C5.77951 0.974651 6.70357 2.00779 6.7093 3.2708L6.70987 3.40114C6.71235 3.94847 6.54042 4.45148 6.25274 4.85421Z"
                            :fill="isDark ? '#749DC8' : '#38618C'" />
                    </svg>
                    <!-- ETH Icon -->
                    <svg v-else-if="tx.icon === 'eth'" class="w-2.5 h-3" viewBox="0 0 21 21" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M10.4955 9.0625L7 10.5971L10.4955 12.5907L13.9896 10.5971L10.4955 9.0625Z"
                            :fill="tx.featured ? '#0074CC' : (isDark ? '#0F1A27' : '#EDF2F7')"
                            :fill-opacity="tx.featured ? '1' : '0.6'" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 10.5987L10.4955 12.5922V5L7 10.5987Z"
                            :fill="tx.featured ? 'white' : (isDark ? '#749DC8' : '#38618C')" />
                    </svg>
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="text-xs tracking-wide truncate" :class="isDark ? 'text-muted' : 'text-muted-dark'">
                        {{ tx.name }}
                    </div>
                    <div class="text-[11px] tracking-wide mt-1" :class="isDark ? 'text-muted' : 'text-muted-dark'">
                        {{ tx.date }}
                    </div>
                </div>

                <!-- Amount -->
                <div class="text-[11px] text-right" :class="tx.type === 'positive'
                    ? (isDark ? 'text-success' : 'text-success')
                    : (isDark ? 'text-danger' : 'text-danger-light')">
                    {{ tx.amount }}
                </div>
            </div>
        </div>
    </section>
</template>
