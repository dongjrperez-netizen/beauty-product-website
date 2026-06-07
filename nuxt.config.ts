export default defineNuxtConfig({
  devtools: { enabled: true },

  future: { compatibilityVersion: 4 },

  css: ['~/assets/css/main.css'],

  app: {
    head: {
      title: 'Ganda Finds',
      link: [
        {
          rel: 'stylesheet',
          href: 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500&display=swap'
        }
      ],
      meta: [
        { name: 'description', content: 'Premium beauty products reseller in the Philippines' }
      ]
    }
  }
})