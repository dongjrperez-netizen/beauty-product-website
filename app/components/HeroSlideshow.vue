<template>
  <div class="hero-slideshow">
    <div class="hero-slides" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
      <img
        v-for="(img, i) in images"
        :key="i"
        :src="img"
        alt="Ganda Finds Products"
        class="slide-img"
      />
    </div>

    <div class="hero-img-label">
      <span class="label-cat">Our Products</span>
      <span class="label-sub">Whitening Sets · Serums · Soaps · Sunblock</span>
    </div>

    <div class="slide-dots">
      <span
        v-for="(img, i) in images"
        :key="i"
        class="dot-btn"
        :class="{ active: currentSlide === i }"
        @click="currentSlide = i"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  images: {
    type: Array,
    default: () => ['/images/collection1.jpg', '/images/collection2.jpg']
  },
  interval: {
    type: Number,
    default: 3500
  }
})

const currentSlide = ref(0)
let timer = null

onMounted(() => {
  timer = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % props.images.length
  }, props.interval)
})

onUnmounted(() => clearInterval(timer))
</script>

<style scoped>
.hero-slideshow {
  position: relative;
  height: 100%;
  min-height: 520px;
  overflow: hidden;
  border: 0.5px solid var(--line);
}
.hero-slides {
  display: flex;
  height: 100%;
  min-height: 520px;
  transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}
.slide-img {
  min-width: 100%;
  width: 100%;
  height: 100%;
  min-height: 520px;
  object-fit: cover;
  flex-shrink: 0;
}
.hero-img-label {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  background: linear-gradient(transparent, rgba(70,44,125,0.72));
  padding: 1.5rem 1.2rem;
  display: flex;
  flex-direction: column;
  gap: 0.3rem;
}
.label-cat {
  font-size: 0.62rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--bl);
  font-family: 'Jost', sans-serif;
}
.label-sub {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.1rem;
  color: #fff;
  font-weight: 300;
}
.slide-dots {
  position: absolute;
  bottom: 55px;
  right: 14px;
  display: flex;
  gap: 6px;
  z-index: 2;
}
.dot-btn {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: rgba(255,255,255,0.5);
  cursor: pointer;
  transition: all 0.3s;
}
.dot-btn.active {
  background: var(--bl);
  width: 20px;
  border-radius: 4px;
}
</style>