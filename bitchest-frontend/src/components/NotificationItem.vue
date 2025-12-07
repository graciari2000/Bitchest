<template>
    <div
        class="w-full p-4 border-b border-dark-border/30 last:border-b-0 hover:bg-dark-card/20 transition-smooth cursor-pointer">
        <div class="flex items-start gap-3">
            <!-- Avatar -->
            <div v-if="avatar" class="w-10 h-10 rounded-full flex-shrink-0 overflow-hidden"
                :style="{ background: avatarGradient }">
                <img v-if="typeof avatar === 'string' && avatar.startsWith('http')" :src="avatar" :alt="name"
                    class="w-full h-full object-cover" />
                <div v-else class="w-full h-full flex items-center justify-center text-white font-bold text-lg">
                    {{ typeof avatar === 'string' ? avatar : name.charAt(0) }}
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2 mb-1">
                    <p class="text-sm font-semibold text-dark-text-secondary">{{ name }}</p>
                    <p class="text-xs text-dark-accent-light whitespace-nowrap">{{ time }}</p>
                </div>
                <p class="text-xs text-dark-accent-light leading-relaxed">{{ message }}</p>
                <div v-if="cta" class="mt-2 flex items-center gap-2">
                    <p class="text-xs text-dark-accent cursor-pointer hover:underline">{{ cta }}</p>
                    <div v-if="amount" class="flex items-center gap-1">
                        <span class="text-xs font-semibold text-dark-success">{{ amount }}</span>
                    </div>
                </div>
            </div>

            <!-- Menu -->
            <button v-if="showMenu" class="flex-shrink-0 p-1 hover:bg-dark-card rounded transition-smooth">
                <svg class="w-4 h-4 text-dark-accent-light" fill="currentColor" viewBox="0 0 4 18">
                    <path
                        d="M4 2C4 3.10457 3.10457 4 2 4C0.89543 4 0 3.10457 0 2C0 0.89543 0.895431 0 2 0C3.10457 0 4 0.895431 4 2ZM4 9C4 10.1046 3.10457 11 2 11C0.89543 11 0 10.1046 0 9C0 7.89543 0.895431 7 2 7C3.10457 7 4 7.89543 4 9ZM4 16C4 17.1046 3.10457 18 2 18C0.89543 18 0 17.1046 0 16C0 14.8954 0.895431 14 2 14C3.10457 14 4 14.8954 4 16Z" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

interface Props {
    name: string
    message: string
    time: string
    avatar?: string
    cta?: string
    amount?: string
    showMenu?: boolean
    type?: 'default' | 'success' | 'error' | 'warning'
}

const props = withDefaults(defineProps<Props>(), {
    showMenu: false,
    type: 'default',
})

const avatarGradient = computed(() => {
    const gradients: Record<string, string> = {
        'Clifford Hale': 'linear-gradient(135deg, #749DC8 0%, #749DC8 100%)',
        'Lottie Marsh': 'linear-gradient(135deg, #00FF19 0%, #23E73C 100%)',
        'Danny Jacobs': 'linear-gradient(135deg, #FF409A 0%, #C438EF 100%)',
        BTC: 'linear-gradient(135deg, #FF409A 0%, #C438EF 100%)',
    }
    return gradients[props.name] || 'linear-gradient(135deg, #749DC8 0%, #749DC8 100%)'
})
</script>

<style scoped></style>