// assets/data.js
// Mock "DB" data. Later you can replace this with PHP+MySQL output.
window.PROPERTIES = [
  {
    id: 1,
    type: "house",
    badge: "For Sale",
    title: "Modern Family House",
    location: "Green Valley, Suburbia",
    description:
      "Stunning modern house with open floor plan, premium finishes, and beautiful backyard.",
    price: 750000,
    price_note: "negotiable",
    image:
      "https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-bed", value: "4", label: "Bedrooms" },
      { icon: "fa-bath", value: "3", label: "Bathrooms" },
      { icon: "fa-expand-arrows-alt", value: "2,850", label: "m sq" },
      { icon: "fa-car", value: "2", label: "Garage" },
    ],
  },
  {
    id: 2,
    type: "apartment",
    badge: "Just Listed",
    title: "Luxury Downtown Apartment",
    location: "City Center, Metropolis",
    description:
      "High-end apartment in the heart of the city with panoramic views, modern amenities and concierge service.",
    price: 425000,
    price_note: "firm",
    image:
      "https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-bed", value: "2", label: "Bedrooms" },
      { icon: "fa-bath", value: "2", label: "Bathrooms" },
      { icon: "fa-expand-arrows-alt", value: "1,450", label: "m sq" },
      { icon: "fa-swimming-pool", value: "Yes", label: "Pool" },
    ],
  },
  {
    id: 3,
    type: "land",
    badge: "Investment Opportunity",
    title: "Prime Development Land",
    location: "North Hills, Countryside",
    description:
      "Vast plot of land with development potential. Utilities available at the border.",
    price: 320000,
    price_note: "negotiable",
    image:
      "https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-vector-square", value: "5.2", label: "Acres" },
      { icon: "fa-tint", value: "Yes", label: "Water" },
      { icon: "fa-bolt", value: "Yes", label: "Electricity" },
      { icon: "fa-road", value: "Paved", label: "Access" },
    ],
  },

  {
    id: 4,
    type: "house",
    badge: "Featured",
    title: "Cozy Suburban House",
    location: "Lakeview, Suburbia",
    description: "Quiet neighborhood, renovated kitchen, large garden.",
    price: 590000,
    price_note: "negotiable",
    image:
      "https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-bed", value: "3", label: "Bedrooms" },
      { icon: "fa-bath", value: "2", label: "Bathrooms" },
      { icon: "fa-expand-arrows-alt", value: "2,100", label: "m sq" },
      { icon: "fa-car", value: "1", label: "Garage" },
    ],
  },
  {
    id: 5,
    type: "apartment",
    badge: "For Rent",
    title: "Minimal Studio Apartment",
    location: "Old Town, Metropolis",
    description: "Perfect for singles, close to transport, fully furnished.",
    price: 900,
    price_note: "per month",
    image:
      "https://images.unsplash.com/photo-1501183638710-841dd1904471?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-bed", value: "1", label: "Bedroom" },
      { icon: "fa-bath", value: "1", label: "Bathroom" },
      { icon: "fa-expand-arrows-alt", value: "520", label: "m sq" },
      { icon: "fa-wifi", value: "Yes", label: "Wi-Fi" },
    ],
  },
];
