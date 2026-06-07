<template>
  <div>

    <!-- HEADER -->
    <div class="inq-header">
      <div class="sec-label">Contact us</div>
      <h1>Let's talk <em>beauty.</em></h1>
      <p class="header-sub">Interested in a product? Send us a message and we'll get back to you with details and payment options.</p>
    </div>

    <!-- MAIN LAYOUT -->
    <div class="inq-layout">

      <!-- LEFT: CONTACT INFO -->
      <div class="inq-left">

        <div class="contact-list">
          <div class="citem">
            <div class="cicon">✉</div>
            <div class="cdetail">
              <div class="citem-label">Email</div>
              <div class="citem-val">youremail@gmail.com</div>
            </div>
          </div>
          <div class="citem">
            <div class="cicon">💬</div>
            <div class="cdetail">
              <div class="citem-label">Facebook</div>
              <div class="citem-val">@GandaFinds</div>
            </div>
          </div>
          <div class="citem">
            <div class="cicon">📱</div>
            <div class="cdetail">
              <div class="citem-label">Instagram</div>
              <div class="citem-val">@gandafindsph</div>
            </div>
          </div>
          <div class="citem">
            <div class="cicon">📦</div>
            <div class="cdetail">
              <div class="citem-label">Shipping</div>
              <div class="citem-val">Nationwide via J&T / Shopee</div>
            </div>
          </div>
        </div>

        <!-- RESPONSE HOURS -->
        <div class="hours-box">
          <div class="hours-title">Response Hours</div>
          <div class="hours-row">
            <span>Monday – Friday</span>
            <span>9:00 AM – 8:00 PM</span>
          </div>
          <div class="hours-row">
            <span>Saturday</span>
            <span>10:00 AM – 6:00 PM</span>
          </div>
          <div class="hours-row">
            <span>Sunday</span>
            <span>12:00 PM – 5:00 PM</span>
          </div>
        </div>

        <!-- NOTE -->
        <div class="inq-note">
          💜 We personally handle every inquiry. Expect a warm, friendly response within the day!
        </div>

      </div>

      <!-- RIGHT: FORM -->
      <div class="inq-right">

        <!-- SUCCESS STATE -->
        <div v-if="submitted" class="success-box">
          <div class="success-icon">✉️</div>
          <h3>Inquiry sent!</h3>
          <p>Thank you for reaching out! We'll get back to you within the day with product details and next steps.</p>
          <button class="btn-main" @click="resetForm">Send Another</button>
          <NuxtLink to="/products" class="btn-outline">Browse More Products</NuxtLink>
        </div>

        <!-- FORM -->
        <form v-else class="form" @submit.prevent="submitForm">

          <div class="frow">
            <div class="fg">
              <label>Name <span class="req">*</span></label>
              <input
                v-model="form.name"
                type="text"
                placeholder="Your full name"
                :class="{ error: errors.name }"
              />
              <span v-if="errors.name" class="err-msg">Name is required</span>
            </div>
            <div class="fg">
              <label>Contact <span class="req">*</span></label>
              <input
                v-model="form.contact"
                type="text"
                placeholder="FB / IG / phone number"
                :class="{ error: errors.contact }"
              />
              <span v-if="errors.contact" class="err-msg">Contact is required</span>
            </div>
          </div>

          <div class="fg">
            <label>Product you're interested in <span class="req">*</span></label>
            <input
              v-model="form.product"
              type="text"
              placeholder="e.g. A Bonne Miracle Spa Milk"
              :class="{ error: errors.product }"
            />
            <span v-if="errors.product" class="err-msg">Please enter a product name</span>
          </div>

          <div class="frow">
            <div class="fg">
              <label>Category</label>
              <select v-model="form.category">
                <option value="">Select a category</option>
                <option>Whitening Set</option>
                <option>Whitening Lotion</option>
                <option>Serum</option>
                <option>Soap</option>
                <option>Sunblock</option>
                <option>Supplement</option>
                <option>Other</option>
              </select>
            </div>
            <div class="fg">
              <label>Payment preference</label>
              <select v-model="form.payment">
                <option value="">Select method</option>
                <option>GCash</option>
                <option>Maya</option>
                <option>Bank Transfer</option>
                <option>COD (if available)</option>
                <option>Open to discuss</option>
              </select>
            </div>
          </div>

          <div class="fg">
            <label>Message</label>
            <textarea
              v-model="form.message"
              placeholder="Ask about availability, bulk orders, bundle deals, price negotiation..."
            />
          </div>

          <button type="submit" class="btn-submit" :disabled="loading">
            <span v-if="loading">Sending...</span>
            <span v-else>Send Inquiry →</span>
          </button>

          <p class="form-note">
            We typically respond within a few hours. All transactions are handled personally with care.
          </p>

        </form>
      </div>
    </div>

    <!-- BOTTOM FAQ -->
    <div class="faq-section">
      <div class="sec-label">Common questions</div>
      <h2 class="sec-title">FAQs</h2>
      <div class="faq-grid">
        <div v-for="faq in faqs" :key="faq.q" class="faq-card">
          <div class="faq-q">{{ faq.q }}</div>
          <div class="faq-a">{{ faq.a }}</div>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'

const route = useRoute()

const submitted = ref(false)
const loading = ref(false)

const form = reactive({
  name: '',
  contact: '',
  product: route.query.product || '',
  category: '',
  payment: '',
  message: '',
})

const errors = reactive({
  name: false,
  contact: false,
  product: false,
})

const validate = () => {
  errors.name = !form.name.trim()
  errors.contact = !form.contact.trim()
  errors.product = !form.product.trim()
  return !errors.name && !errors.contact && !errors.product
}

const submitForm = async () => {
  if (!validate()) return
  loading.value = true
  // Simulate sending
  await new Promise(resolve => setTimeout(resolve, 1200))
  loading.value = false
  submitted.value = true
}

const resetForm = () => {
  submitted.value = false
  form.name = ''
  form.contact = ''
  form.product = ''
  form.category = ''
  form.payment = ''
  form.message = ''
}

const faqs = [
  {
    q: 'Are all products authentic?',
    a: 'Yes! Every product we sell is 100% authentic. We personally source and verify each item before listing.'
  },
  {
    q: 'How do I pay?',
    a: 'We accept GCash, Maya, and bank transfer. COD may be available depending on your location.'
  },
  {
    q: 'How long does shipping take?',
    a: 'Usually 2-5 business days via J&T Express or Shopee Xpress. We ship nationwide across the Philippines.'
  },
  {
    q: 'Can I buy in bulk?',
    a: 'Absolutely! We welcome bulk orders and offer special pricing for returning buyers. Just mention it in your inquiry.'
  },
  {
    q: 'What if my order arrives damaged?',
    a: 'We pack every order carefully but if something arrives damaged, message us right away with a photo and we\'ll sort it out.'
  },
  {
    q: 'How fast do you reply?',
    a: 'We reply within the day, usually within a few hours. Check our response hours on the left for guidance.'
  },
]

useHead({ title: 'Inquire — Ganda Finds' })
</script>

<style scoped>
/* HEADER */
.inq-header {
  padding: 4rem 3.5rem 3rem;
  border-bottom: 0.5px solid var(--line);
  background: var(--cream);
}
.inq-header h1 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 3.5rem;
  font-weight: 300;
  color: var(--ink);
  margin-bottom: 0.8rem;
  line-height: 1.1;
}
.inq-header h1 em { font-style: italic; color: var(--ma); }
.header-sub {
  font-size: 0.87rem;
  color: var(--dust);
  font-weight: 300;
  line-height: 1.8;
  max-width: 520px;
}

/* LAYOUT */
.inq-layout {
  display: grid;
  grid-template-columns: 1fr 1.4fr;
  gap: 5rem;
  padding: 4rem 3.5rem;
  align-items: start;
}

/* LEFT */
.contact-list {
  display: flex;
  flex-direction: column;
  gap: 1.2rem;
  margin-bottom: 2.5rem;
}
.citem {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
}
.cicon {
  width: 38px;
  height: 38px;
  border: 0.5px solid var(--line);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  flex-shrink: 0;
  background: var(--cream);
}
.citem-label {
  font-size: 0.62rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--pk);
  margin-bottom: 0.2rem;
}
.citem-val {
  font-size: 0.85rem;
  color: var(--dust);
  font-weight: 300;
}

/* HOURS */
.hours-box {
  padding: 1.5rem;
  border: 0.5px solid var(--line);
  background: var(--cream);
  margin-bottom: 1.5rem;
}
.hours-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1rem;
  color: var(--vi);
  margin-bottom: 1rem;
}
.hours-row {
  display: flex;
  justify-content: space-between;
  font-size: 0.78rem;
  color: var(--dust);
  padding: 0.4rem 0;
  border-bottom: 0.5px solid var(--line);
  font-weight: 300;
}
.hours-row:last-child { border-bottom: none; }
.inq-note {
  font-size: 0.78rem;
  color: var(--dust);
  line-height: 1.7;
  padding: 1rem;
  background: var(--cream);
  border-left: 2px solid var(--pk);
  font-weight: 300;
}

/* FORM */
.form {
  display: flex;
  flex-direction: column;
  gap: 1.1rem;
}
.frow {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}
.fg {
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
}
.fg label {
  font-size: 0.62rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--vi);
  font-weight: 400;
}
.req { color: var(--pk); }
.fg input,
.fg textarea,
.fg select {
  padding: 0.85rem 1rem;
  border: 0.5px solid var(--line);
  background: #fff;
  font-family: 'Jost', sans-serif;
  font-size: 0.85rem;
  color: var(--ink);
  outline: none;
  transition: border-color 0.2s;
  font-weight: 300;
  width: 100%;
  appearance: none;
}
.fg input:focus,
.fg textarea:focus,
.fg select:focus { border-color: var(--ma); }
.fg input.error,
.fg textarea.error { border-color: #e53e3e; }
.fg textarea { resize: none; height: 120px; }
.err-msg {
  font-size: 0.68rem;
  color: #e53e3e;
  letter-spacing: 0.5px;
}
.btn-submit {
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
  margin-top: 0.4rem;
}
.btn-submit:hover { opacity: 0.88; }
.btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
.form-note {
  font-size: 0.72rem;
  color: var(--dust);
  font-weight: 300;
  line-height: 1.6;
  text-align: center;
}

/* SUCCESS */
.success-box {
  text-align: center;
  padding: 3rem 2rem;
  border: 0.5px solid var(--line);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}
.success-icon { font-size: 3rem; }
.success-box h3 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.8rem;
  font-weight: 300;
  color: var(--vi);
}
.success-box p {
  font-size: 0.85rem;
  color: var(--dust);
  line-height: 1.7;
  font-weight: 300;
  max-width: 360px;
}

/* FAQ */
.faq-section {
  padding: 5rem 3.5rem;
  background: var(--cream);
}
.faq-section .sec-title { margin-bottom: 2rem; }
.faq-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.2rem;
  margin-top: 1.5rem;
}
.faq-card {
  padding: 1.8rem;
  background: #fff;
  border: 0.5px solid var(--line);
}
.faq-q {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.05rem;
  color: var(--vi);
  margin-bottom: 0.6rem;
  font-weight: 400;
}
.faq-a {
  font-size: 0.82rem;
  color: var(--dust);
  line-height: 1.8;
  font-weight: 300;
}

/* RESPONSIVE */
@media (max-width: 1024px) {
  .inq-header { padding: 3rem 2rem 2rem; }
  .inq-layout {
    grid-template-columns: 1fr;
    gap: 3rem;
    padding: 3rem 2rem;
  }
  .faq-section { padding: 3.5rem 2rem; }
}

@media (max-width: 768px) {
  .inq-header { padding: 2.5rem 1.5rem 1.5rem; }
  .inq-header h1 { font-size: 2.5rem; }
  .inq-layout { padding: 2rem 1.5rem; gap: 2rem; }
  .frow { grid-template-columns: 1fr; }
  .faq-grid { grid-template-columns: 1fr; }
  .faq-section { padding: 2.5rem 1.5rem; }
}
</style>