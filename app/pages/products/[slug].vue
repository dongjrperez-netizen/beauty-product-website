<template>
  <div v-if="product">

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
      <NuxtLink to="/">Home</NuxtLink>
      <span class="sep">/</span>
      <NuxtLink to="/products">Products</NuxtLink>
      <span class="sep">/</span>
      <span class="current">{{ product.name }}</span>
    </div>

    <!-- DETAIL LAYOUT -->
    <div class="detail-layout">

      <!-- LEFT: GALLERY -->
      <div class="gallery">
        <!-- MAIN IMAGE -->
        <div class="gallery-main">
          <img :src="activeImage" :alt="product.name" />
          <div class="zoom-hint">Hover to zoom</div>
        </div>

        <!-- THUMBNAILS -->
        <div class="gallery-thumbs">
          <div
            v-for="(img, i) in product.images"
            :key="i"
            class="thumb"
            :class="{ active: activeImage === img }"
            @click="activeImage = img"
          >
            <img :src="img" :alt="`View ${i + 1}`" />
          </div>
        </div>
      </div>

      <!-- RIGHT: INFO -->
      <div class="detail-info">

        <div class="detail-cat">{{ product.cat }}</div>
        <h1 class="detail-name">{{ product.name }}</h1>

        <!-- PRICE -->
        <div class="price-row">
          <span class="price">₱{{ product.price }}</span>
          <span class="orig">₱{{ product.orig }}</span>
          <span class="badge">{{ discount(product.price, product.orig) }}% OFF</span>
        </div>

        <p class="detail-desc">{{ product.desc }}</p>

        <!-- SPECS -->
        <div class="specs">
          <div
            v-for="([label, value]) in product.specs"
            :key="label"
            class="spec-row"
          >
            <span class="spec-label">{{ label }}</span>
            <span class="spec-val">{{ value }}</span>
          </div>
        </div>

        <!-- ACTIONS -->
        <div class="actions">
          <button class="btn-inquire" @click="goInquiry">
            ✉ Send Inquiry for This Product
          </button>
          <NuxtLink to="/inquiry" class="btn-general">
            General Inquiry
          </NuxtLink>
        </div>

        <div class="detail-note">
          💬 Message us on Facebook <strong>@GandaFinds</strong> or fill the inquiry form. We reply within the day!
        </div>

      </div>
    </div>

    <!-- RELATED PRODUCTS -->
    <div class="related-section">
      <div class="sec-label">You might also like</div>
      <h2 class="sec-title">Related Products</h2>
      <div class="related-grid">
        <NuxtLink
          v-for="related in relatedProducts"
          :key="related.id"
          :to="`/products/${related.slug}`"
          class="rcard"
        >
          <div class="rcard-img">
            <img
              v-if="related.images[0]"
              :src="related.images[0]"
              :alt="related.name"
            />
            <div v-else class="rcard-ph">📷</div>
          </div>
          <div class="rcard-body">
            <div class="rcard-cat">{{ related.cat }}</div>
            <div class="rcard-name">{{ related.name }}</div>
            <div class="rcard-price">₱{{ related.price }}</div>
          </div>
        </NuxtLink>
      </div>
    </div>

  </div>

  <!-- PRODUCT NOT FOUND -->
  <div v-else class="not-found">
    <h2>Product not found</h2>
    <NuxtLink to="/products" class="btn-main">Back to Products</NuxtLink>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const route = useRoute()
const router = useRouter()
const { getProduct, getRelated, discount } = useProducts()

const product = computed(() => getProduct(route.params.slug))
const relatedProducts = computed(() => getRelated(product.value?.related || []))

// Active image for gallery
const activeImage = ref('')

// Reset active image when product changes
watch(product, (p) => {
  if (p) activeImage.value = p.images[0] || ''
}, { immediate: true })

// Go to inquiry with product pre-filled
const goInquiry = () => {
  router.push({ path: '/inquiry', query: { product: product.value.name } })
}

// SEO
useHead({
  title: computed(() => product.value ? `${product.value.name} — Ganda Finds` : 'Product — Ganda Finds')
})
</script>

<style scoped>
/* BREADCRUMB */
.breadcrumb {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  padding: 1.5rem 3.5rem;
  font-size: 0.72rem;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--dust);
  border-bottom: 0.5px solid var(--line);
}
.breadcrumb a {
  color: var(--dust);
  text-decoration: none;
  transition: color 0.2s;
}
.breadcrumb a:hover { color: var(--vi); }
.sep { color: var(--line); }
.current { color: var(--vi); }

/* LAYOUT */
.detail-layout {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 5rem;
  padding: 3.5rem;
  align-items: start;
}

/* GALLERY */
.gallery {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  position: sticky;
  top: 100px;
}
.gallery-main {
  width: 100%;
  aspect-ratio: 1/1;
  overflow: hidden;
  border: 0.5px solid var(--line);
  background: #f9f0ff;
  position: relative;
}
.gallery-main img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.5s ease;
}
.gallery-main:hover img { transform: scale(1.06); }
.zoom-hint {
  position: absolute;
  bottom: 12px;
  right: 12px;
  background: rgba(70,44,125,0.7);
  color: #fff;
  font-size: 0.6rem;
  letter-spacing: 1px;
  text-transform: uppercase;
  padding: 4px 10px;
  font-family: 'Jost', sans-serif;
}
.gallery-thumbs {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0.6rem;
}
.thumb {
  aspect-ratio: 1/1;
  overflow: hidden;
  border: 1.5px solid transparent;
  cursor: pointer;
  transition: border-color 0.2s;
  background: #f5eef8;
}
.thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.3s;
}
.thumb:hover img { transform: scale(1.08); }
.thumb.active { border-color: var(--ma); }

/* PRODUCT INFO */
.detail-cat {
  font-size: 0.68rem;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: var(--pk);
  margin-bottom: 0.8rem;
}
.detail-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2.6rem;
  font-weight: 300;
  line-height: 1.1;
  color: var(--ink);
  margin-bottom: 1rem;
}

/* PRICE */
.price-row {
  display: flex;
  align-items: baseline;
  gap: 1rem;
  margin-bottom: 1.5rem;
  padding-bottom: 1.5rem;
  border-bottom: 0.5px solid var(--line);
}
.price {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2rem;
  color: var(--vi);
}
.orig {
  font-size: 1rem;
  color: var(--dust);
  text-decoration: line-through;
  font-weight: 300;
}
.badge {
  background: var(--pk);
  color: #fff;
  font-size: 0.6rem;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  padding: 3px 10px;
  font-family: 'Jost', sans-serif;
}

.detail-desc {
  font-size: 0.87rem;
  color: var(--dust);
  line-height: 1.9;
  font-weight: 300;
  margin-bottom: 2rem;
}

/* SPECS */
.specs {
  display: flex;
  flex-direction: column;
  margin-bottom: 2rem;
}
.spec-row {
  display: flex;
  padding: 0.7rem 0;
  border-bottom: 0.5px solid var(--line);
  font-size: 0.82rem;
}
.spec-label {
  width: 140px;
  color: var(--vi);
  font-weight: 500;
  font-size: 0.75rem;
  letter-spacing: 0.5px;
  flex-shrink: 0;
}
.spec-val {
  color: var(--dust);
  font-weight: 300;
  line-height: 1.5;
}

/* ACTIONS */
.actions {
  display: flex;
  flex-direction: column;
  gap: 0.8rem;
  margin-bottom: 1.5rem;
}
.btn-inquire {
  background: linear-gradient(135deg, var(--vi), var(--ma));
  color: #fff;
  border: none;
  padding: 1.1rem;
  font-family: 'Jost', sans-serif;
  font-size: 0.75rem;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  cursor: pointer;
  transition: opacity 0.2s;
  width: 100%;
}
.btn-inquire:hover { opacity: 0.88; }
.btn-general {
  display: block;
  text-align: center;
  border: 0.5px solid var(--vi);
  color: var(--vi);
  padding: 1rem;
  font-family: 'Jost', sans-serif;
  font-size: 0.72rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  text-decoration: none;
  transition: all 0.2s;
}
.btn-general:hover { background: var(--vi); color: #fff; }

.detail-note {
  font-size: 0.72rem;
  color: var(--dust);
  line-height: 1.7;
  padding: 1rem;
  background: var(--cream);
  border-left: 2px solid var(--pk);
}

/* RELATED */
.related-section {
  padding: 4rem 3.5rem;
  background: var(--cream);
}
.related-section .sec-title { margin-bottom: 2rem; }
.related-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1rem;
  margin-top: 1.5rem;
}
.rcard {
  background: #fff;
  border: 0.5px solid var(--line);
  overflow: hidden;
  text-decoration: none;
  display: block;
  transition: all 0.25s;
}
.rcard:hover {
  border-color: rgba(131,28,145,0.4);
  transform: translateY(-3px);
}
.rcard-img { height: 180px; overflow: hidden; background: #f5eef8; }
.rcard-img img {
  width: 100%; height: 100%;
  object-fit: cover;
  transition: transform 0.3s;
}
.rcard:hover .rcard-img img { transform: scale(1.05); }
.rcard-ph {
  width: 100%; height: 100%;
  display: flex; align-items: center;
  justify-content: center;
  font-size: 2rem; opacity: 0.3;
}
.rcard-body { padding: 1rem; }
.rcard-cat {
  font-size: 0.58rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--pk);
  margin-bottom: 0.2rem;
}
.rcard-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 0.95rem;
  color: var(--ink);
  margin-bottom: 0.3rem;
}
.rcard-price {
  font-size: 0.85rem;
  color: var(--vi);
  font-family: 'Cormorant Garamond', serif;
}

/* NOT FOUND */
.not-found {
  text-align: center;
  padding: 8rem 3.5rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2rem;
}
.not-found h2 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2rem;
  font-weight: 300;
  color: var(--dust);
}

@media (max-width: 1024px) {
  .detail-layout {
    grid-template-columns: 1fr;
    gap: 2.5rem;
    padding: 2.5rem 2rem;
  }
  .gallery { position: static; }
  .related-grid { grid-template-columns: repeat(2, 1fr); }
  .related-section { padding: 3rem 2rem; }
  .breadcrumb { padding: 1.2rem 2rem; }
}

@media (max-width: 768px) {
  .detail-layout { padding: 1.5rem; gap: 2rem; }
  .breadcrumb { padding: 1rem 1.5rem; }
  .detail-name { font-size: 2rem; }
  .gallery-thumbs { grid-template-columns: repeat(4, 1fr); }
  .related-grid { grid-template-columns: repeat(2, 1fr); gap: 0.8rem; }
  .related-section { padding: 2.5rem 1.5rem; }
}
</style>