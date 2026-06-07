<template>
  <div class="page-wrapper">

    <!-- HERO -->
    <section class="hero">
      <div class="hero-left">
        <div class="sec-label">Curated beauty · Philippines 🇵🇭</div>
        <h1>Beauty,<br><em>thoughtfully</em><br>resold.</h1>
        <p class="hero-sub">Premium whitening sets, serums, soaps & skincare — authentic, carefully selected, priced for you.</p>
        <div class="cta-row">
          <NuxtLink to="/products" class="btn-main">Browse Collection</NuxtLink>
          <NuxtLink to="/inquiry" class="btn-ghost">Send Inquiry</NuxtLink>
        </div>
      </div>
      <div class="hero-right">
        <HeroSlideshow :images="['/images/collection.jpg', '/images/collection2.jpg', '/images/collection3.jpg']" />
      </div>
    </section>

    <!-- MARQUEE -->
    <div class="marquee-wrap">
      <div class="marquee-track">
        <span v-for="i in 2" :key="i">
          <span>Authentic Products</span><span class="dot">✦</span>
          <span>Nationwide Shipping</span><span class="dot">✦</span>
          <span>Trusted Reseller</span><span class="dot">✦</span>
          <span>Premium Beauty Finds</span><span class="dot">✦</span>
          <span>Fast Response</span><span class="dot">✦</span>
          <span>Carefully Curated</span><span class="dot">✦</span>
        </span>
      </div>
    </div>

    <!-- WHY US -->
    <section class="why-section">
      <div class="why-left">
        <div class="sec-label">Why choose us</div>
        <h2 class="sec-title">You deserve the <em>best</em></h2>
        <p class="sec-sub">Every item is personally vetted for quality, authenticity, and condition.</p>
        <NuxtLink to="/about" class="btn-outline" style="margin-top:1.5rem;display:inline-block">Our Story</NuxtLink>
      </div>
      <div class="why-grid">
        <div class="why-card" v-for="item in whyItems" :key="item.title">
          <div class="why-icon">{{ item.icon }}</div>
          <div class="why-title">{{ item.title }}</div>
          <div class="why-text">{{ item.text }}</div>
        </div>
      </div>
    </section>

    <!-- FEATURED -->
    <section class="featured-strip">
      <div class="strip-header">
        <div>
          <div class="sec-label">Handpicked for you</div>
          <h2 class="sec-title">Featured products</h2>
        </div>
        <NuxtLink to="/products" class="btn-outline">View All</NuxtLink>
      </div>
      <div class="strip-grid">
        <NuxtLink
          v-for="product in featuredProducts"
          :key="product.id"
          :to="`/products/${product.slug}`"
          class="scard"
        >
          <div class="scard-img">
            <img v-if="product.images[0]" :src="product.images[0]" :alt="product.name" />
            <div v-else class="scard-img-ph">📷</div>
          </div>
          <div class="scard-body">
            <div class="scard-cat">{{ product.cat }}</div>
            <div class="scard-name">{{ product.name }}</div>
            <div class="scard-price">₱{{ product.price }}</div>
          </div>
        </NuxtLink>
      </div>
    </section>

  </div>
</template>

<script setup>
const { products } = useProducts()
const featuredProducts = products.slice(0, 4)

const whyItems = [
  { icon: '🔍', title: 'Carefully Vetted', text: 'Every product inspected before listing. We only sell what we\'d use ourselves.' },
  { icon: '✅', title: '100% Authentic', text: 'No fakes. All items are genuine products from trusted suppliers.' },
  { icon: '💌', title: 'Fast Replies', text: 'We respond to inquiries within the day — quick and friendly always.' },
  { icon: '📦', title: 'Safe Shipping', text: 'Packed securely and shipped via J&T or Shopee nationwide.' },
]
</script>

<style scoped>
/* HERO */
.hero {
  display: grid;
  grid-template-columns: 1.1fr 1fr;
  min-height: 88vh;
  align-items: center;
  padding: 0 3.5rem;
  gap: 4rem;
  background: var(--cream);
}
.hero h1 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 4.5rem;
  font-weight: 300;
  line-height: 1.08;
  color: var(--ink);
  margin-bottom: 1.5rem;
}
.hero h1 em { font-style: italic; color: var(--ma); }
.hero-sub {
  font-size: 0.88rem;
  color: var(--dust);
  line-height: 1.9;
  max-width: 380px;
  margin-bottom: 2.5rem;
  font-weight: 300;
}
.cta-row { display: flex; align-items: center; gap: 2rem; }
.btn-ghost {
  font-size: 0.72rem;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--dust);
  border-bottom: 0.5px solid var(--dust);
  padding-bottom: 2px;
}
.hero-right {
  position: relative;
  height: 100%;
  min-height: 520px;
  border: 0.5px solid var(--line);
  overflow: hidden;
}
.hero-img {
  width: 100%;
  height: 100%;
  min-height: 520px;
  object-fit: cover;
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

/* MARQUEE */
.marquee-wrap {
  padding: 1.8rem 0;
  border-top: 0.5px solid var(--line);
  border-bottom: 0.5px solid var(--line);
  overflow: hidden;
  white-space: nowrap;
}
.marquee-track {
  display: inline-block;
  animation: marquee 20s linear infinite;
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.1rem;
  font-style: italic;
  color: var(--dust);
  letter-spacing: 2px;
}
.marquee-track span { margin: 0 2.5rem; }
.dot { color: var(--pk); font-style: normal; }
@keyframes marquee {
  from { transform: translateX(0); }
  to { transform: translateX(-50%); }
}

/* WHY */
.why-section {
  padding: 5rem 3.5rem;
  display: grid;
  grid-template-columns: 1fr 2fr;
  gap: 5rem;
  align-items: start;
}
.why-left .sec-sub {
  font-size: 0.87rem;
  color: var(--dust);
  font-weight: 300;
  line-height: 1.8;
  margin-top: 0.8rem;
}
.why-left h2 em { font-style: italic; color: var(--ma); }
.why-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
.why-card { padding: 1.8rem; border: 0.5px solid var(--line); }
.why-icon { font-size: 1.4rem; margin-bottom: 0.8rem; }
.why-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.1rem;
  color: var(--ink);
  margin-bottom: 0.4rem;
}
.why-text { font-size: 0.8rem; color: var(--dust); line-height: 1.7; font-weight: 300; }

/* FEATURED */
.featured-strip { padding: 5rem 3.5rem; background: var(--cream); }
.strip-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 2.5rem;
}
.strip-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; }
.scard {
  background: #fff;
  border: 0.5px solid var(--line);
  cursor: pointer;
  transition: all 0.25s;
  overflow: hidden;
  text-decoration: none;
  display: block;
}
.scard:hover { border-color: rgba(131,28,145,0.4); transform: translateY(-3px); }
.scard-img { height: 220px; overflow: hidden; background: #f5eef8; }
.scard-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s; }
.scard:hover .scard-img img { transform: scale(1.05); }
.scard-img-ph {
  width: 100%; height: 100%;
  display: flex; align-items: center; justify-content: center;
  font-size: 2.5rem; opacity: 0.3;
}
.scard-body { padding: 1rem; }
.scard-cat { font-size: 0.58rem; letter-spacing: 2px; text-transform: uppercase; color: var(--pk); margin-bottom: 0.2rem; }
.scard-name { font-family: 'Cormorant Garamond', serif; font-size: 0.98rem; color: var(--ink); margin-bottom: 0.4rem; }
.scard-price { font-size: 0.85rem; color: var(--vi); font-family: 'Cormorant Garamond', serif; }


/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
  .hero {
    grid-template-columns: 1fr;
    min-height: auto;
    padding: 3rem 2rem;
    gap: 2.5rem;
  }
  .hero-right { min-height: 380px; }
  .hero h1 { font-size: 3.5rem; }
  .why-section {
    grid-template-columns: 1fr;
    padding: 3rem 2rem;
    gap: 2rem;
  }
  .strip-grid { grid-template-columns: repeat(2, 1fr); }
  .featured-strip { padding: 3rem 2rem; }
}

@media (max-width: 768px) {
  .hero { padding: 2.5rem 1.5rem; gap: 2rem; }
  .hero h1 { font-size: 2.8rem; }
  .hero-sub { max-width: 100%; }
  .hero-right { min-height: 300px; }
  .cta-row { flex-direction: column; align-items: flex-start; gap: 1rem; }
  .marquee-track { font-size: 0.9rem; }
  .why-grid { grid-template-columns: 1fr; }
  .why-section { padding: 2.5rem 1.5rem; }
  .strip-grid { grid-template-columns: 1fr 1fr; gap: 0.8rem; }
  .featured-strip { padding: 2.5rem 1.5rem; }
  .strip-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
}
</style>