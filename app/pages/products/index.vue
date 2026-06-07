<template>
  <div>

    <!-- PAGE HEADER -->
    <div class="products-header">
      <div>
        <div class="sec-label">Our collection</div>
        <h1>All Products</h1>
        <p class="header-sub">Click any product to view full details, photos and more.</p>
      </div>
    </div>

    <!-- FILTER PILLS -->
    <div class="products-body">
      <div class="filter-bar">
        <button
          v-for="f in filters"
          :key="f.value"
          class="fpill"
          :class="{ on: activeFilter === f.value }"
          @click="activeFilter = f.value"
        >
          {{ f.label }}
        </button>
      </div>

      <!-- PRODUCT GRID -->
      <div class="prod-grid">
        <NuxtLink
          v-for="product in filteredProducts"
          :key="product.id"
          :to="`/products/${product.slug}`"
          class="pcard"
        >
          <!-- IMAGE -->
          <div class="pimg">
            <span v-if="product.tag" class="ptag">{{ product.tag }}</span>
            <img
              v-if="product.images[0]"
              :src="product.images[0]"
              :alt="product.name"
            />
            <div v-else class="pimg-ph">
              <span>📷</span>
              <p>Photo coming soon</p>
            </div>
          </div>

          <!-- INFO -->
          <div class="pbody">
            <div class="pcat">{{ product.cat }}</div>
            <div class="pname">{{ product.name }}</div>
            <div class="pdesc">{{ product.desc.slice(0, 80) }}...</div>
            <div class="pfooter">
              <div class="pprice">
                ₱{{ product.price }}
                <s>₱{{ product.orig }}</s>
              </div>
              <button
                class="inq-btn"
                @click.prevent="goInquiry(product.name)"
              >
                Inquire
              </button>
            </div>
          </div>
        </NuxtLink>
      </div>
    </div>

    <!-- HOW TO ORDER -->
    <div class="order-strip">
      <div v-for="step in steps" :key="step.num" class="step">
        <div class="step-num">{{ step.num }}</div>
        <div class="step-title">{{ step.title }}</div>
        <div class="step-text">{{ step.text }}</div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const { products } = useProducts()
const router = useRouter()

const activeFilter = ref('all')

const filters = [
  { label: 'All', value: 'all' },
  { label: 'Whitening', value: 'whitening' },
  { label: 'Lotion', value: 'lotion' },
  { label: 'Sets', value: 'set' },
  { label: 'Soap', value: 'soap' },
]

const filteredProducts = computed(() => {
  if (activeFilter.value === 'all') return products
  return products.filter(p =>
    p.cat.toLowerCase().includes(activeFilter.value)
  )
})

const goInquiry = (name) => {
  router.push({ path: '/inquiry', query: { product: name } })
}

const steps = [
  { num: '01', title: 'Browse', text: 'Find the product you like and click to view details' },
  { num: '02', title: 'Inquire', text: 'Send your name, contact and product interest' },
  { num: '03', title: 'Pay', text: 'GCash, Maya, or bank transfer' },
  { num: '04', title: 'Receive', text: 'We ship via J&T or Shopee nationwide' },
]
</script>

<style scoped>
/* HEADER */
.products-header {
  padding: 3.5rem 3.5rem 2rem;
  border-bottom: 0.5px solid var(--line);
}
.products-header h1 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 3rem;
  font-weight: 300;
  color: var(--ink);
  margin-bottom: 0.3rem;
}
.header-sub {
  font-size: 0.85rem;
  color: var(--dust);
  font-weight: 300;
  margin-top: 0.4rem;
}

/* BODY */
.products-body { padding: 2.5rem 3.5rem; }

/* FILTERS */
.filter-bar {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 2.5rem;
  flex-wrap: wrap;
}
.fpill {
  padding: 0.45rem 1.3rem;
  border: 0.5px solid var(--line);
  font-size: 0.68rem;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  background: #fff;
  color: var(--dust);
  cursor: pointer;
  font-family: 'Jost', sans-serif;
  transition: all 0.2s;
}
.fpill.on,
.fpill:hover {
  background: var(--vi);
  color: #fff;
  border-color: var(--vi);
}

/* GRID */
.prod-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
}

/* CARD */
.pcard {
  background: #fff;
  border: 0.5px solid var(--line);
  overflow: hidden;
  cursor: pointer;
  transition: all 0.25s;
  text-decoration: none;
  display: block;
}
.pcard:hover {
  border-color: rgba(131,28,145,0.4);
  transform: translateY(-4px);
  box-shadow: 0 12px 40px rgba(70,44,125,0.1);
}

/* PRODUCT IMAGE - LARGE */
.pimg {
  height: 300px;
  overflow: hidden;
  position: relative;
  background: #f9f0ff;
}
.pimg img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.4s;
}
.pcard:hover .pimg img { transform: scale(1.04); }
.pimg-ph {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 0.8rem;
}
.pimg-ph span { font-size: 3.5rem; opacity: 0.25; }
.pimg-ph p {
  font-size: 0.65rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--dust);
  opacity: 0.5;
}
.ptag {
  position: absolute;
  top: 14px;
  left: 14px;
  font-size: 0.6rem;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  background: #fff;
  color: var(--vi);
  padding: 4px 12px;
  border: 0.5px solid var(--line);
  font-family: 'Jost', sans-serif;
  z-index: 2;
}

/* CARD BODY */
.pbody { padding: 1.3rem; }
.pcat {
  font-size: 0.6rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--pk);
  margin-bottom: 0.3rem;
}
.pname {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.15rem;
  color: var(--ink);
  margin-bottom: 0.3rem;
}
.pdesc {
  font-size: 0.79rem;
  color: var(--dust);
  line-height: 1.6;
  margin-bottom: 1.1rem;
  font-weight: 300;
}
.pfooter {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.pprice {
  font-size: 1.1rem;
  font-family: 'Cormorant Garamond', serif;
  color: var(--vi);
}
.pprice s {
  font-size: 0.75rem;
  color: var(--dust);
  margin-left: 5px;
  font-family: 'Jost', sans-serif;
  font-weight: 300;
}
.inq-btn {
  font-size: 0.65rem;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  background: none;
  border: 0.5px solid var(--vi);
  color: var(--vi);
  padding: 0.5rem 1.1rem;
  cursor: pointer;
  font-family: 'Jost', sans-serif;
  transition: all 0.2s;
}
.inq-btn:hover { background: var(--vi); color: #fff; }

/* HOW TO ORDER */
.order-strip {
  background: var(--vi);
  padding: 3.5rem;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 2rem;
  text-align: center;
  margin-top: 4rem;
}
.step-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2.5rem;
  font-weight: 300;
  color: var(--bl);
  margin-bottom: 0.5rem;
}
.step-title {
  font-size: 0.75rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: #fff;
  margin-bottom: 0.4rem;
}
.step-text {
  font-size: 0.78rem;
  color: rgba(255,255,255,0.6);
  font-weight: 300;
  line-height: 1.6;
}


@media (max-width: 1024px) {
  .products-header { padding: 2.5rem 2rem 1.5rem; }
  .products-body { padding: 2rem; }
  .prod-grid { grid-template-columns: repeat(2, 1fr); }
  .order-strip {
    grid-template-columns: repeat(2, 1fr);
    padding: 2.5rem 2rem;
  }
}

@media (max-width: 768px) {
  .products-header { padding: 2rem 1.5rem 1rem; }
  .products-body { padding: 1.5rem; }
  .prod-grid { grid-template-columns: 1fr; }
  .pimg { height: 260px; }
  .order-strip {
    grid-template-columns: 1fr 1fr;
    padding: 2rem 1.5rem;
    gap: 1.5rem;
  }
}
</style>