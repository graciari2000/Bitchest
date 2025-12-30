<template>
    <div class="price-chart">
        <canvas ref="chartCanvas" width="800" height="400"></canvas>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'

const props = defineProps({
    symbol: {
        type: String,
        required: true
    },
    priceHistory: {
        type: Array,
        default: () => []
    }
})

const chartCanvas = ref(null)

const drawChart = () => {
    if (!chartCanvas.value || !props.priceHistory.length) return

    const canvas = chartCanvas.value
    const ctx = canvas.getContext('2d')
    const width = canvas.width
    const height = canvas.height
    const padding = 40

    // Clear canvas
    ctx.clearRect(0, 0, width, height)

    // Get price values
    const prices = props.priceHistory.map(h => parseFloat(h.price))
    const minPrice = Math.min(...prices)
    const maxPrice = Math.max(...prices)
    const priceRange = maxPrice - minPrice || 1

    // Draw grid
    ctx.strokeStyle = 'rgba(51, 167, 255, 0.1)'
    ctx.lineWidth = 1
    for (let i = 0; i <= 10; i++) {
        const y = padding + (height - 2 * padding) * (i / 10)
        ctx.beginPath()
        ctx.moveTo(padding, y)
        ctx.lineTo(width - padding, y)
        ctx.stroke()
    }

    // Draw axes
    ctx.strokeStyle = 'rgba(51, 167, 255, 0.3)'
    ctx.lineWidth = 2
    ctx.beginPath()
    ctx.moveTo(padding, padding)
    ctx.lineTo(padding, height - padding)
    ctx.lineTo(width - padding, height - padding)
    ctx.stroke()

    // Draw price line
    ctx.strokeStyle = '#00ff19'
    ctx.lineWidth = 2
    ctx.beginPath()

    props.priceHistory.forEach((history, index) => {
        const x = padding + (width - 2 * padding) * (index / (props.priceHistory.length - 1 || 1))
        const normalizedPrice = (parseFloat(history.price) - minPrice) / priceRange
        const y = height - padding - (height - 2 * padding) * normalizedPrice

        if (index === 0) {
            ctx.moveTo(x, y)
        } else {
            ctx.lineTo(x, y)
        }
    })

    ctx.stroke()

    // Draw points
    ctx.fillStyle = '#00ff19'
    props.priceHistory.forEach((history, index) => {
        const x = padding + (width - 2 * padding) * (index / (props.priceHistory.length - 1))
        const normalizedPrice = (parseFloat(history.price) - minPrice) / priceRange
        const y = height - padding - (height - 2 * padding) * normalizedPrice

        ctx.beginPath()
        ctx.arc(x, y, 4, 0, 2 * Math.PI)
        ctx.fill()
    })

    // Draw labels
    ctx.fillStyle = 'var(--text)'
    ctx.font = '12px sans-serif'
    ctx.textAlign = 'right'

    // Y-axis labels (prices)
    for (let i = 0; i <= 5; i++) {
        const price = minPrice + (priceRange * i / 5)
        const y = height - padding - (height - 2 * padding) * (i / 5)
        ctx.fillText(`€${price.toFixed(2)}`, padding - 10, y + 4)
    }

    // X-axis labels (dates)
    ctx.textAlign = 'center'
    const dateStep = Math.max(1, Math.floor(props.priceHistory.length / 10))
    props.priceHistory.forEach((history, index) => {
        if (index % dateStep === 0 || index === props.priceHistory.length - 1) {
            const x = padding + (width - 2 * padding) * (index / (props.priceHistory.length - 1))
            const date = new Date(history.date)
            ctx.fillText(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }), x, height - padding + 20)
        }
    })
}

watch(() => props.priceHistory, drawChart, { deep: true })
onMounted(drawChart)
</script>

<style scoped>
.price-chart {
    width: 100%;
    overflow-x: auto;
}

.price-chart canvas {
    max-width: 100%;
    height: auto;
}
</style>

