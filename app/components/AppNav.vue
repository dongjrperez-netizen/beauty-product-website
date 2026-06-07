<template>
  <nav class="nav">
    <NuxtLink to="/" class="logo"><em>Ganda</em> Finds</NuxtLink>

    <!-- DESKTOP LINKS -->
    <ul class="nav-links" :class="{ open: menuOpen }">
      <li><NuxtLink to="/" @click="menuOpen = false">Home</NuxtLink></li>
      <li><NuxtLink to="/products" @click="menuOpen = false">Products</NuxtLink></li>
      <li><NuxtLink to="/about" @click="menuOpen = false">About</NuxtLink></li>
      <li><NuxtLink to="/inquiry" class="nav-cta" @click="menuOpen = false">Inquire</NuxtLink></li>
    </ul>

    <!-- HAMBURGER -->
    <button class="hamburger" @click="menuOpen = !menuOpen" :class="{ open: menuOpen }">
      <span /><span /><span />
    </button>
  </nav>
</template>

<script setup>
import { ref } from 'vue'
const menuOpen = ref(false)
</script>

<style scoped>
.nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.2rem 3.5rem;
  border-bottom: 0.5px solid var(--line);
  background: #fff;
  position: sticky;
  top: 0;
  z-index: 200;
}
.logo {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.6rem;
  font-weight: 300;
  letter-spacing: 2px;
  color: var(--vi);
  text-decoration: none;
}
.logo em { font-style: italic; color: var(--ma); }
.nav-links {
  display: flex;
  gap: 2.5rem;
  list-style: none;
}
.nav-links a {
  text-decoration: none;
  font-size: 0.72rem;
  letter-spacing: 2px;
  text-transform: uppercase;
  font-weight: 400;
  color: var(--dust);
  transition: color 0.2s;
  padding-bottom: 2px;
}
.nav-links a:hover,
.nav-links a.router-link-exact-active {
  color: var(--vi);
  border-bottom: 0.5px solid var(--vi);
}
.nav-cta {
  color: var(--vi) !important;
  border-bottom: 0.5px solid var(--vi) !important;
}

/* HAMBURGER */
.hamburger {
  display: none;
  flex-direction: column;
  gap: 5px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  z-index: 300;
}
.hamburger span {
  display: block;
  width: 24px;
  height: 1.5px;
  background: var(--vi);
  transition: all 0.3s;
  transform-origin: center;
}
.hamburger.open span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
.hamburger.open span:nth-child(2) { opacity: 0; }
.hamburger.open span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }

/* TABLET */
@media (max-width: 1024px) {
  .nav { padding: 1.2rem 2rem; }
  .nav-links { gap: 1.5rem; }
}

/* MOBILE */
@media (max-width: 768px) {
  .nav { padding: 1rem 1.5rem; }
  .hamburger { display: flex; }
  .nav-links {
    display: none;
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: #fff;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 2.5rem;
    z-index: 200;
  }
  .nav-links.open { display: flex; }
  .nav-links a {
    font-size: 1.2rem;
    letter-spacing: 3px;
  }
}
</style>