export let productsData = [
  { id: 1, name: "iPhone 15 Pro", category: "Électronique", sales: 127, revenue: 152400, stock: 23, icon: "📱" },
  { id: 2, name: "T-shirt", category: "Vêtements", sales: 89, revenue: 2670, stock: 245, icon: "👕" },
  { id: 3, name: "MacBook Air M3", category: "Électronique", sales: 56, revenue: 78400, stock: 45, icon: "💻" },
  { id: 4, name: "Canapé Nordique", category: "Maison", sales: 34, revenue: 27200, stock: 12, icon: "🏠" },
  { id: 5, name: "Ballon", category: "Sports", sales: 78, revenue: 3120, stock: 156, icon: "⚽" },
];

export let currentSort = { key: 'sales', order: 'desc' };
export let currentFilter = 'all';
