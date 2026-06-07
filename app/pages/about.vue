<template>
  <div>

    <!-- HERO -->
    <section class="about-hero">
      <div class="about-left">
        <div class="sec-label">Our story</div>
        <h1>Born from a love of <em>beauty</em> done right.</h1>
        <p>Hi! I'm the person behind Ganda Finds — a passionate beauty lover based in the Philippines who started reselling to share premium finds at prices that actually make sense.</p>
        <p>What began as sharing my own favorites grew into something I truly love: curating authentic, quality beauty products and connecting them with people who deserve them.</p>
        <p>Every item I list has been personally checked, photographed honestly, and priced fairly. No surprises — just genuine products and genuine service.</p>
        <NuxtLink to="/inquiry" class="btn-main about-cta">Get in Touch</NuxtLink>
      </div>
      <div class="about-mosaic">
        <div class="mbox m1">
          <img src="/images/products/set.jpg" alt="Products" />
        </div>
        <div class="mbox m2">
          <img src="/images/products/lotion.jpg" alt="Lotion" />
        </div>
        <div class="mbox m3">
          <img src="/images/products/soap.jpg" alt="Soap" />
        </div>
        <div class="mbox m4">
          <img src="/images/products/lotionsy1.jpg" alt="SY Glow" />
        </div>
      </div>
    </section>

    <!-- STATS BAND -->
    <div class="stats-band">
      <div v-for="stat in stats" :key="stat.num" class="stat">
        <div class="stat-num">{{ stat.num }}</div>
        <div class="stat-label">{{ stat.label }}</div>
      </div>
    </div>

    <!-- VALUES -->
    <section class="values-section">
      <div class="values-header">
        <div class="sec-label">What we stand for</div>
        <h2 class="sec-title">Our values</h2>
      </div>
      <div class="values-grid">
        <div v-for="value in values" :key="value.num" class="vcard">
          <div class="vcard-num">{{ value.num }}</div>
          <div class="vcard-title">{{ value.title }}</div>
          <div class="vcard-text">{{ value.text }}</div>
        </div>
      </div>
    </section>

    <!-- PROMISE -->
    <section class="promise-section">
      <div class="promise-left">
        <div class="sec-label">Our promise</div>
        <h2>Shopping with us should feel <em>easy & safe.</em></h2>
        <p class="promise-sub">Every transaction smooth and trustworthy — from first inquiry to delivery at your door.</p>
      </div>
      <ul class="promise-list">
        <li v-for="item in promises" :key="item">{{ item }}</li>
      </ul>
    </section>

    <!-- CTA BAND -->
    <div class="cta-band">
      <div class="cta-band-left">
        <h2>Ready to find your next <em>beauty favorite?</em></h2>
        <p>Browse our full collection or send us a message anytime.</p>
      </div>
      <div class="cta-band-right">
        <NuxtLink to="/products" class="btn-main">Browse Products</NuxtLink>
        <NuxtLink to="/inquiry" class="btn-outline-light">Send Inquiry</NuxtLink>
      </div>
    </div>

  </div>
</template>

<script setup>
const stats = [
  { num: '500+', label: 'Products Sold' },
  { num: '98%', label: 'Happy Buyers' },
  { num: '3 Days', label: 'Avg. Delivery' },
  { num: '100%', label: 'Authentic Products' },
]

const values = [
  {
    num: '01',
    title: 'Authenticity First',
    text: 'We never list anything we cannot verify. Every product is sourced carefully from trusted suppliers only. No fakes, ever.'
  },
  {
    num: '02',
    title: 'Honest Descriptions',
    text: 'We describe each item exactly as it is. What you see is what you get. No sugarcoating, no misleading photos.'
  },
  {
    num: '03',
    title: 'Buyer-First Service',
    text: 'Your satisfaction matters most. We respond quickly, pack carefully, and make every transaction comfortable for you.'
  },
]

const promises = [
  'All items personally inspected and honestly described before listing',
  'Secure packaging to protect your order during shipping',
  'Ships nationwide via J&T Express and Shopee Xpress',
  'Fast response to all inquiries — usually within the same day',
  'Open to negotiation for bulk orders or returning buyers',
  'No hidden charges — listed price plus shipping only',
]

useHead({ title: 'About Us — Ganda Finds' })
</script>

<style scoped>
/* HERO */
.about-hero {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 6rem;
  padding: 5rem 3.5rem;
  align-items: center;
  border-bottom: 0.5px solid var(--line);
}
.about-left h1 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 3.5rem;
  font-weight: 300;
  line-height: 1.15;
  color: var(--ink);
  margin-bottom: 1.5rem;
}
.about-left h1 em { font-style: italic; color: var(--ma); }
.about-left p {
  font-size: 0.87rem;
  color: var(--dust);
  line-height: 1.9;
  font-weight: 300;
  margin-bottom: 1rem;
}
.about-cta { margin-top: 1.5rem; display: inline-block; }

/* MOSAIC */
.about-mosaic {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.8rem;
}
.mbox {
  overflow: hidden;
  border: 0.5px solid var(--line);
  background: #f5eef8;
}
.mbox img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.4s;
}
.mbox:hover img { transform: scale(1.05); }
.m1 { height: 230px; }
.m2 { height: 170px; margin-top: 3rem; background: #fce8f5; }
.m3 { height: 170px; margin-top: -2rem; background: #fff0fa; }
.m4 { height: 230px; background: #f8eeff; }

/* STATS BAND */
.stats-band {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  background: var(--vi);
  padding: 3rem 3.5rem;
  text-align: center;
  gap: 1rem;
}
.stat-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2.5rem;
  font-weight: 300;
  color: var(--bl);
  margin-bottom: 0.3rem;
}
.stat-label {
  font-size: 0.72rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: rgba(255,255,255,0.65);
}

/* VALUES */
.values-section {
  padding: 5rem 3.5rem;
}
.values-header { margin-bottom: 2.5rem; }
.values-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
}
.vcard {
  padding: 2.2rem 1.8rem;
  border: 0.5px solid var(--line);
}
.vcard-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2.5rem;
  font-weight: 300;
  color: var(--line);
  margin-bottom: 0.8rem;
}
.vcard-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.15rem;
  color: var(--vi);
  margin-bottom: 0.6rem;
}
.vcard-text {
  font-size: 0.82rem;
  color: var(--dust);
  line-height: 1.8;
  font-weight: 300;
}

/* PROMISE */
.promise-section {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4rem;
  padding: 5rem 3.5rem;
  background: var(--cream);
  align-items: center;
}
.promise-left h2 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2.2rem;
  font-weight: 300;
  color: var(--ink);
  line-height: 1.2;
  margin-bottom: 1rem;
}
.promise-left h2 em { font-style: italic; color: var(--ma); }
.promise-sub {
  font-size: 0.87rem;
  color: var(--dust);
  line-height: 1.8;
  font-weight: 300;
}
.promise-list {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 0.9rem;
}
.promise-list li {
  display: flex;
  align-items: flex-start;
  gap: 0.8rem;
  font-size: 0.85rem;
  color: var(--dust);
  font-weight: 300;
  line-height: 1.6;
}
.promise-list li::before {
  content: '✦';
  color: var(--pk);
  font-size: 0.7rem;
  margin-top: 3px;
  flex-shrink: 0;
}

/* CTA BAND */
.cta-band {
  background: var(--ink);
  padding: 4rem 3.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 3rem;
}
.cta-band-left h2 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2rem;
  font-weight: 300;
  color: #fff;
  line-height: 1.2;
  margin-bottom: 0.5rem;
}
.cta-band-left h2 em { font-style: italic; color: var(--bl); }
.cta-band-left p {
  font-size: 0.85rem;
  color: rgba(255,255,255,0.5);
  font-weight: 300;
}
.cta-band-right {
  display: flex;
  gap: 1rem;
  flex-shrink: 0;
}
.btn-outline-light {
  display: inline-block;
  border: 0.5px solid rgba(255,255,255,0.4);
  color: #fff;
  padding: 0.85rem 2.2rem;
  font-family: 'Jost', sans-serif;
  font-size: 0.72rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  text-decoration: none;
  transition: all 0.2s;
}
.btn-outline-light:hover {
  background: rgba(255,255,255,0.1);
  border-color: #fff;
}

@media (max-width: 1024px) {
  .about-hero {
    grid-template-columns: 1fr;
    gap: 3rem;
    padding: 3.5rem 2rem;
  }
  .stats-band {
    grid-template-columns: repeat(2, 1fr);
    padding: 2.5rem 2rem;
  }
  .values-section { padding: 3.5rem 2rem; }
  .values-grid { grid-template-columns: 1fr; gap: 1.2rem; }
  .promise-section {
    grid-template-columns: 1fr;
    gap: 2rem;
    padding: 3.5rem 2rem;
  }
  .cta-band {
    flex-direction: column;
    text-align: center;
    padding: 3rem 2rem;
    gap: 2rem;
  }
}

@media (max-width: 768px) {
  .about-hero { padding: 2.5rem 1.5rem; }
  .about-left h1 { font-size: 2.5rem; }
  .about-mosaic { grid-template-columns: 1fr 1fr; }
  .m2 { margin-top: 1.5rem; }
  .m3 { margin-top: -1rem; }
  .stats-band {
    grid-template-columns: repeat(2, 1fr);
    padding: 2rem 1.5rem;
    gap: 1.5rem;
  }
  .values-section { padding: 2.5rem 1.5rem; }
  .promise-section { padding: 2.5rem 1.5rem; }
  .cta-band { padding: 2.5rem 1.5rem; }
  .cta-band-right { flex-direction: column; width: 100%; }
  .cta-band-right a { text-align: center; }
}
</style>