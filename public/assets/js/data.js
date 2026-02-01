// data.js


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
    id: 6,
    type: "house",
    badge: "For Sale",
    title: "Elegant Garden House",
    location: "Sunny Hills, Suburbia",
    description:
      "Spacious house with modern interior, big garden and private parking.",
    price: 680000,
    price_note: "negotiable",
    image:
      "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-bed", value: "4", label: "Bedrooms" },
      { icon: "fa-bath", value: "3", label: "Bathrooms" },
      { icon: "fa-expand-arrows-alt", value: "2,400", label: "m sq" },
      { icon: "fa-car", value: "2", label: "Garage" },
    ],
  },
  {
    id: 7,
    type: "house",
    badge: "Featured",
    title: "Mountain View Villa",
    location: "Highlands, Countryside",
    description:
      "Luxury villa with amazing view, large rooms and premium finishes.",
    price: 980000,
    price_note: "negotiable",
    image:
      "https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-bed", value: "5", label: "Bedrooms" },
      { icon: "fa-bath", value: "4", label: "Bathrooms" },
      { icon: "fa-expand-arrows-alt", value: "3,600", label: "m sq" },
      { icon: "fa-car", value: "2", label: "Garage" },
    ],
  },
  {
    id: 8,
    type: "house",
    badge: "Just Listed",
    title: "Modern Minimal House",
    location: "West Side, Metropolis",
    description:
      "Clean modern design, open floor plan, and bright natural light.",
    price: 540000,
    price_note: "firm",
    image:
      "https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-bed", value: "3", label: "Bedrooms" },
      { icon: "fa-bath", value: "2", label: "Bathrooms" },
      { icon: "fa-expand-arrows-alt", value: "1,980", label: "m sq" },
      { icon: "fa-car", value: "1", label: "Garage" },
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
  {
    id: 11,
    type: "apartment",
    badge: "Featured",
    title: "Penthouse Apartment",
    location: "Skyline District, Metropolis",
    description:
      "Penthouse with huge balcony, modern kitchen and city view.",
    price: 670000,
    price_note: "negotiable",
    image:
      "https://images.unsplash.com/photo-1560448204-603b3fc33ddc?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-bed", value: "3", label: "Bedrooms" },
      { icon: "fa-bath", value: "2", label: "Bathrooms" },
      { icon: "fa-expand-arrows-alt", value: "1,850", label: "m sq" },
      { icon: "fa-car", value: "1", label: "Parking" },
    ],
  },
  {
    id: 12,
    type: "apartment",
    badge: "Just Listed",
    title: "Modern Family Apartment",
    location: "Central Park, Suburbia",
    description:
      "Bright apartment for families, next to schools and markets.",
    price: 310000,
    price_note: "firm",
    image:
      "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-bed", value: "3", label: "Bedrooms" },
      { icon: "fa-bath", value: "2", label: "Bathrooms" },
      { icon: "fa-expand-arrows-alt", value: "1,250", label: "m sq" },
      { icon: "fa-elevator", value: "Yes", label: "Elevator" },
    ],
  },
  {
    id: 13,
    type: "apartment",
    badge: "For Rent",
    title: "Cozy City Apartment",
    location: "Downtown, Metropolis",
    description:
      "Stylish apartment close to restaurants, shops and nightlife.",
    price: 1200,
    price_note: "per month",
    image:
      "https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-bed", value: "2", label: "Bedrooms" },
      { icon: "fa-bath", value: "1", label: "Bathroom" },
      { icon: "fa-expand-arrows-alt", value: "860", label: "m sq" },
      { icon: "fa-wifi", value: "Yes", label: "Wi-Fi" },
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
    id: 14,
    type: "land",
    badge: "For Sale",
    title: "Residential Land Plot",
    location: "Green Village, Suburbia",
    description:
      "Perfect land for residential construction. Great location and access.",
    price: 150000,
    price_note: "negotiable",
    image:
      "https://images.unsplash.com/photo-1628624747186-a941c476b7ef?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-vector-square", value: "1.2", label: "Acres" },
      { icon: "fa-tint", value: "Yes", label: "Water" },
      { icon: "fa-bolt", value: "Yes", label: "Electricity" },
      { icon: "fa-road", value: "Good", label: "Road" },
    ],
  },
  {
    id: 15,
    type: "land",
    badge: "Featured",
    title: "Farm Land Opportunity",
    location: "Sunny Fields, Countryside",
    description:
      "Large agricultural land, suitable for farming and long term investment.",
    price: 210000,
    price_note: "negotiable",
    image:
      "https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-vector-square", value: "8.0", label: "Acres" },
      { icon: "fa-seedling", value: "Yes", label: "Fertile" },
      { icon: "fa-road", value: "Paved", label: "Access" },
      { icon: "fa-tractor", value: "Yes", label: "Farm Ready" },
    ],
  },
  {
    id: 16,
    type: "land",
    badge: "Hot Deal",
    title: "Mountain Land",
    location: "High Peaks, Countryside",
    description:
      "Beautiful land in mountain area. Perfect for villas or eco-tourism.",
    price: 175000,
    price_note: "negotiable",
    image:
      "https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-vector-square", value: "3.6", label: "Acres" },
      { icon: "fa-bolt", value: "Nearby", label: "Electricity" },
      { icon: "fa-tint", value: "Nearby", label: "Water" },
      { icon: "fa-road", value: "Good", label: "Access" },
    ],
  },
    // ✅ NEW APARTMENT
  {
    id: 17,
    type: "apartment",
    badge: "For Sale",
    title: "Sunny Modern Apartment",
    location: "New District, Metropolis",
    description:
      "Modern apartment with balcony, natural light, and great neighborhood.",
    price: 285000,
    price_note: "negotiable",
    image:
      "https://images.unsplash.com/photo-1560185127-6ed189bf02b7?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-bed", value: "2", label: "Bedrooms" },
      { icon: "fa-bath", value: "1", label: "Bathroom" },
      { icon: "fa-expand-arrows-alt", value: "980", label: "m sq" },
      { icon: "fa-elevator", value: "Yes", label: "Elevator" },
    ],
  },

  // ✅ NEW LAND 1
  {
    id: 18,
    type: "land",
    badge: "For Sale",
    title: "Land Near Main Road",
    location: "East Side, Countryside",
    description:
      "Land with direct access from the main road. Perfect for construction or business.",
    price: 130000,
    price_note: "negotiable",
    image:
      "https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-vector-square", value: "1.8", label: "Acres" },
      { icon: "fa-road", value: "Main Road", label: "Access" },
      { icon: "fa-bolt", value: "Yes", label: "Electricity" },
      { icon: "fa-tint", value: "Yes", label: "Water" },
    ],
  },

  // ✅ NEW LAND 2
  {
    id: 19,
    type: "land",
    badge: "Featured",
    title: "Lake View Land Plot",
    location: "Lake Area, Countryside",
    description:
      "Beautiful land with lake view, ideal for villas and eco-tourism projects.",
    price: 240000,
    price_note: "negotiable",
    image:
      "https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=2070&q=80",
    features: [
      { icon: "fa-vector-square", value: "4.1", label: "Acres" },
      { icon: "fa-mountain", value: "View", label: "Lake View" },
      { icon: "fa-road", value: "Good", label: "Access" },
      { icon: "fa-seedling", value: "Yes", label: "Nature" },
    ],
  },

];
