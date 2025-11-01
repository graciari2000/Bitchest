<template>
    <div class="hero-pattern" aria-hidden="true" :style="rootStyle">
        <svg viewBox="0 0 1440 560" preserveAspectRatio="xMidYMid slice" role="img">
            <defs>
                <!-- background gradient -->
                <linearGradient id="cp-grad" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" :stop-color="bgPrimary" stop-opacity="1" />
                    <stop offset="100%" :stop-color="bgSecondary" stop-opacity="1" />
                </linearGradient>

                <!-- hexagon tile path -->
                <symbol id="hex" viewBox="-10 -11 20 22" preserveAspectRatio="xMidYMid meet">
                    <path d="M0 -10 L8 -5 L8 5 L0 10 L-8 5 L-8 -5 Z" :fill="hexFill" :stroke="hexStroke"
                        stroke-width="0.5" />
                </symbol>

                <!-- connection line style -->
                <g id="conn">
                    <line x1="0" y1="0" x2="1" y2="1" :stroke="lineColor" stroke-opacity="0.14" stroke-width="1"
                        stroke-linecap="round" />
                </g>

                <!-- simple coin symbol -->
                <symbol id="coin" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" :fill="coinFill" :stroke="coinStroke" stroke-width="0.8" />
                    <!-- stylized "chain" bars -->
                    <rect x="9.2" y="6" width="1.6" height="12" rx="0.6" :fill="coinAccent" />
                    <rect x="13.2" y="6" width="1.6" height="12" rx="0.6" :fill="coinAccent" />
                </symbol>

                <!-- pattern composed of hexagons -->
                <pattern id="hexPattern" width="96" height="83" patternUnits="userSpaceOnUse">
                    <!-- two hex columns offset to tile -->
                    <use href="#hex" x="0" y="0" />
                    <use href="#hex" x="48" y="41.5" />
                </pattern>

                <!-- small node glow filter -->
                <filter id="glow" x="-50%" y="-50%" width="200%" height="200%">
                    <feGaussianBlur stdDeviation="6" result="blur" />
                    <feMerge>
                        <feMergeNode in="blur" />
                        <feMergeNode in="SourceGraphic" />
                    </feMerge>
                </filter>
            </defs>

            <!-- base -->
            <rect width="100%" height="100%" fill="url(#cp-grad)" />

            <!-- hex grid faint -->
            <rect width="100%" height="100%" fill="url(#hexPattern)" opacity="0.08" />

            <!-- network connections & nodes -->
            <g transform="translate(60,40)" stroke-linecap="round">
                <!-- example network cluster 1 -->
                <g>
                    <line :x1="80" :y1="40" :x2="200" :y2="20" :stroke="lineColor" stroke-opacity="0.18"
                        stroke-width="1.6" />
                    <line :x1="80" :y1="40" :x2="160" :y2="100" :stroke="lineColor" stroke-opacity="0.12"
                        stroke-width="1.2" />
                    <circle :cx="80" :cy="40" r="6" :fill="nodeColor" :stroke="nodeStroke" stroke-width="1"
                        filter="url(#glow)">
                        <animate attributeName="r" values="5;8;5" dur="3.4s" repeatCount="indefinite" />
                        <animate attributeName="opacity" values="0.9;0.6;0.9" dur="3.4s" repeatCount="indefinite" />
                    </circle>
                    <use href="#coin" :x="200" :y="12" width="26" height="26" opacity="0.95" />
                </g>

                <!-- cluster 2 -->
                <g>
                    <line :x1="420" :y1="80" :x2="560" :y2="30" :stroke="lineColor" stroke-opacity="0.14"
                        stroke-width="1.4" />
                    <line :x1="560" :y1="30" :x2="680" :y2="110" :stroke="lineColor" stroke-opacity="0.12"
                        stroke-width="1.1" />
                    <circle :cx="560" :cy="30" r="5.5" :fill="nodeColor" :stroke="nodeStroke" stroke-width="0.9"
                        filter="url(#glow)">
                        <animate attributeName="r" values="4;7;4" dur="4.2s" repeatCount="indefinite" />
                    </circle>
                    <use href="#coin" :x="420" :y="52" width="20" height="20" opacity="0.9" />
                </g>

                <!-- chain of small nodes across -->
                <g stroke-linecap="round" :stroke="lineColor" stroke-opacity="0.10" stroke-width="1">
                    <polyline points="40,260 140,220 260,260 380,210 520,240 660,200" fill="none" />
                    <g fill="none">
                        <circle v-for="(p, i) in smallNodes" :key="i" :cx="p[0]" :cy="p[1]" r="3.2" :fill="nodeColor"
                            :stroke="nodeStroke" stroke-width="0.7" filter="url(#glow)">
                            <animate attributeName="r" :dur="(2.8 + (i % 3) * 0.6) + 's'" values="2.8;5;2.8"
                                repeatCount="indefinite" />
                        </circle>
                    </g>
                </g>

                <!-- floating coins (parallax subtle motion) -->
                <g opacity="0.9">
                    <use href="#coin" x="820" y="20" width="36" height="36">
                        <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="9s"
                            values="0 0; 6 -8; 0 0" repeatCount="indefinite" />
                    </use>
                    <use href="#coin" x="1100" y="120" width="30" height="30" opacity="0.92">
                        <animateTransform attributeName="transform" attributeType="XML" type="translate" dur="11s"
                            values="0 0; -8 6; 0 0" repeatCount="indefinite" />
                    </use>
                </g>
            </g>

            <!-- top-right subtle node grid -->
            <g transform="translate(980,20)" opacity="0.12">
                <rect width="420" height="240" fill="url(#hexPattern)" />
            </g>
        </svg>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    inset: { type: Boolean, default: true },
    bgPrimary: { type: String, default: '#0f172a' }, // dark navy
    bgSecondary: { type: String, default: '#071029' }, // deep blue
    hexFill: { type: String, default: 'rgba(255,255,255,0.01)' },
    hexStroke: { type: String, default: 'rgba(255,255,255,0.03)' },
    nodeColor: { type: String, default: '#60a5fa' },
    nodeStroke: { type: String, default: 'rgba(96,165,250,0.9)' },
    lineColor: { type: String, default: '#9ae6b4' },
    coinFill: { type: String, default: '#ffd166' },
    coinStroke: { type: String, default: 'rgba(0,0,0,0.12)' },
    coinAccent: { type: String, default: '#f59e0b' }
})

const rootStyle = props.inset
    ? { position: 'absolute', inset: '0', zIndex: -1, pointerEvents: 'none' }
    : { width: '100%', pointerEvents: 'none' }

// small node positions for the chain (relative to group transform)
const smallNodes = [
    [40, 260], [140, 220], [260, 260], [380, 210], [520, 240], [660, 200]
]
</script>

<style scoped>
.hero-pattern {
    display: block;
    overflow: hidden;
    pointer-events: none;
    will-change: transform, opacity;
}

/* make svg fill container */
.hero-pattern>svg {
    display: block;
    width: 100%;
    height: 100%;
    min-height: 160px;
}
</style>