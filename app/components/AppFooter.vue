<template>
  <footer class="footer">
    <NuxtLink to="/" class="logo"><em>Ganda</em> Finds</NuxtLink>
    <div class="footer-links">
      <NuxtLink to="/">Home</NuxtLink>
      <NuxtLink to="/products">Products</NuxtLink>
      <NuxtLink to="/about">About</NuxtLink>
      <NuxtLink to="/inquiry">Inquire</NuxtLink>
    </div>
    <p>© 2026 Ganda Finds · Made with care 🇵🇭</p>
  </footer>
</template>

<style scoped>
.footer {
  border-top: 0.5px solid var(--line);
  padding: 2rem 3.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #fff;
}

.logo {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.1rem;
  font-weight: 300;
  letter-spacing: 2px;
  color: var(--vi);
  text-decoration: none;
}

.logo em {
  font-style: italic;
  color: var(--ma);
}

.footer-links {
  display: flex;
  gap: 2rem;
}

.footer-links a {
  font-size: 0.7rem;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--dust);
  text-decoration: none;
  transition: color 0.2s;
}

.footer-links a:hover { color: var(--vi); }

p {
  font-size: 0.7rem;
  letter-spacing: 1px;
  color: var(--dust);
}

@media (max-width: 768px) {
  .footer {
    flex-direction: column;
    gap: 1.2rem;
    text-align: center;
    padding: 2rem 1.5rem;
  }
  .footer-links { flex-wrap: wrap; justify-content: center; gap: 1rem; }
}
</style>