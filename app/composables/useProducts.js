export const useProducts = () => {
  const products = [
    {
      id: 0,
      slug: 'a-bonne-miracle-spa-milk',
      cat: 'Whitening Lotion',
      name: "A Bonne' Miracle Spa Milk",
      tag: 'Bestseller',
      price: 350,
      orig: 600,
      desc: 'A Bonne Miracle Spa Milk gives you soft, smooth, and glowing skin with its powerful White Glutathione and Lycopene Tomato Extract formula. Firming and whitening all in one bottle.',
      specs: [
        ['Brand', 'A Bonne'],
        ['Volume', '500 ml'],
        ['SPF', 'UV Protection'],
        ['Key Ingredients', 'White Glutathione, Lycopene, Tomato Extract'],
        ['Benefits', '3X Whitening, Firming, Plumping & Glowing'],
        ['Skin Type', 'All skin types'],
        ['Usage', 'Daily, after shower'],
        ['Condition', 'Brand new, sealed'],
      ],
      images: ['/images/products/lotion.jpg', '/images/products/lotion1.jpg', '/images/products/lotion2.jpg'],
      related: [1, 2, 3]
    },
    {
      id: 1,
      slug: 'sy-glow-lotion-set',
      cat: 'Whitening Lotion',
      name: 'SY Glow Whitening Lotion Set',
      tag: 'Popular',
      price: 388,
      orig: 650,
      desc: 'SY Glow Whitening Lotion with powerful brightening formula. Gives you smooth, radiant, and glowing skin with regular use.',
      specs: [
        ['Brand', 'SY Glow'],
        ['Volume', '250 ml'],
        ['Key Ingredients', 'Niacinamide, Alpha Arbutin, Vitamin E'],
        ['Benefits', 'Brightening, Whitening, Moisturizing'],
        ['Skin Type', 'All skin types'],
        ['Usage', 'Daily moisturizer'],
        ['Condition', 'Brand new, sealed'],
      ],
      images: ['/images/products/lotionsy1.jpg', '/images/products/lotionsy2.jpg', '/images/products/lotionsy3.jpg', '/images/products/lotionsy4.jpg'],
      related: [0, 2, 3]
    },
    {
      id: 2,
      slug: 'whitening-set',
      cat: 'Whitening Set',
      name: 'Complete Whitening Set',
      tag: 'New',
      price: 550,
      orig: 950,
      desc: 'Complete whitening set with everything you need for brighter, smoother skin. Includes soap, lotion, and serum for best results.',
      specs: [
        ['Contents', 'Soap, Lotion, Serum'],
        ['Key Ingredients', 'Kojic Acid, Glutathione, Collagen'],
        ['Benefits', 'Whitening, Brightening, Even Skin Tone'],
        ['Skin Type', 'All skin types'],
        ['Usage', 'Morning and night'],
        ['Condition', 'Brand new, sealed'],
      ],
      images: ['/images/products/set.jpg', '/images/products/set1.jpg', '/images/products/set2.jpg', '/images/products/set3.jpg'],
      related: [0, 1, 3]
    },
    {
      id: 3,
      slug: 'kojic-whitening-soap',
      cat: 'Whitening Soap',
      name: 'Kojic Whitening Soap',
      tag: 'Must-Have',
      price: 85,
      orig: 150,
      desc: 'Classic kojic acid whitening soap that fades dark spots and evens out skin tone. Safe for daily use on face and body.',
      specs: [
        ['Type', 'Whitening Soap'],
        ['Key Ingredients', 'Kojic Acid, Glutathione'],
        ['Benefits', 'Dark Spot Fading, Even Skin Tone, Whitening'],
        ['Skin Type', 'All skin types'],
        ['Usage', 'Daily face and body wash'],
        ['Condition', 'Brand new, sealed'],
      ],
      images: ['/images/products/soap.jpg', '/images/products/soap1.jpg'],
      related: [0, 1, 2]
    },
    {
      id: 4,
      slug: 'sy-glow-lotion-extra',
      cat: 'Whitening Lotion',
      name: 'SY Glow Extra Whitening Lotion',
      tag: 'Hot',
      price: 320,
      orig: 550,
      desc: 'Extra strength whitening lotion from SY Glow. With advanced brightening formula for faster and more visible results.',
      specs: [
        ['Brand', 'SY Glow'],
        ['Volume', '250 ml'],
        ['Key Ingredients', 'Niacinamide, Tomato Extract, Hyaluronic Acid'],
        ['Benefits', 'Whitening, Brightening, Hydrating'],
        ['Skin Type', 'All skin types'],
        ['Usage', 'Daily moisturizer'],
        ['Condition', 'Brand new, sealed'],
      ],
      images: ['/images/products/lotionsy4.jpg', '/images/products/lotionsy3.jpg'],
      related: [0, 1, 2]
    },
  ]

  const getProduct = (slug) => products.find(p => p.slug === slug)
  const getRelated = (ids) => ids.map(id => products[id]).filter(Boolean)
  const discount = (price, orig) => Math.round((1 - price / orig) * 100)

  return { products, getProduct, getRelated, discount }
}