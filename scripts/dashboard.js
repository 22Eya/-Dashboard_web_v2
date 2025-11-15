// Données fictives initiales (simule une API)
let productsData = [
  { id: 1, name: "iPhone 15 Pro", category: "Électronique", sales: 127, revenue: 152400, stock: 23, icon: "📱" },
  { id: 2, name: "T-shirt", category: "Vêtements", sales: 89, revenue: 2670, stock: 245, icon: "👕" },
  { id: 3, name: "MacBook Air M3", category: "Électronique", sales: 56, revenue: 78400, stock: 45, icon: "💻" },
  { id: 4, name: "Canapé Nordique", category: "Maison", sales: 34, revenue: 27200, stock: 12, icon: "🏠" },
  { id: 5, name: "Ballon", category: "Sports", sales: 78, revenue: 3120, stock: 156, icon: "⚽" },
];

let currentSort = { key: 'sales', order: 'desc' };
let currentFilter = 'all';

// Mise à jour du tableau
function renderTable() {
  const tableBody = document.getElementById('products-table-body');
  let filtered = productsData;

  // Filtrage
  if (currentFilter !== 'all') {
    filtered = productsData.filter(p => p.category === currentFilter);
  }

  // Tri
  filtered.sort((a, b) => {
    const aVal = a[currentSort.key];
    const bVal = b[currentSort.key];
    if (typeof aVal === 'string') {
      return currentSort.order === 'asc' 
        ? aVal.localeCompare(bVal) 
        : bVal.localeCompare(aVal);
    }
    return currentSort.order === 'asc' ? aVal - bVal : bVal - aVal;
  });

  tableBody.innerHTML = filtered.map(p => `
    <tr>
      <td>
        <div class="product-cell">
          <div class="product-avatar">${p.icon}</div>
          <span>${p.name}</span>
        </div>
      </td>
      <td><span class="category-tag ${p.category.toLowerCase().replace(' ', '')}">${p.category}</span></td>
      <td>${p.sales}</td>
      <td>€${p.revenue.toLocaleString()}</td>
      <td><span class="stock-status ${p.stock > 100 ? 'high' : p.stock > 20 ? 'medium' : 'low'}">${p.stock}</span></td>
    </tr>
  `).join('');
}

// Initialiser le tri sur les en-têtes
document.querySelectorAll('th[data-sort]').forEach(th => {
  th.addEventListener('click', () => {
    const key = th.dataset.sort;
    if (currentSort.key === key) {
      currentSort.order = currentSort.order === 'asc' ? 'desc' : 'asc';
    } else {
      currentSort.key = key;
      currentSort.order = 'desc';
    }
    renderTable();
  });
});

// Filtrage par catégorie
document.getElementById('category-filter').addEventListener('change', (e) => {
  currentFilter = e.target.value;
  renderTable();
});

// Initialisation des graphiques
let salesChart, categoryChart;

function initCharts() {
  const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'];
  const salesData = [45200, 52100, 61800, 48900, 68300, 74500];

  // Chart 1: Ventes mensuelles
  const salesCtx = document.getElementById('salesChart').getContext('2d');
  salesChart = new Chart(salesCtx, {
    type: 'bar',
    data: {
      labels: months,
      datasets: [{
        label: 'Ventes (€)',
        data: salesData,
        backgroundColor: 'rgba(59, 130, 246, 0.7)',
        borderColor: 'rgba(59, 130, 246, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, ticks: { callback: v => '€' + (v/1000) + 'k' } }
      }
    }
  });

  // Chart 2: Catégories
  const categoryCtx = document.getElementById('categoryChart').getContext('2d');
  categoryChart = new Chart(categoryCtx, {
    type: 'doughnut',
    data: {
      labels: ['Électronique', 'Vêtements', 'Maison & Jardin', 'Sports', 'Livres'],
      datasets: [{
        data: [35, 25, 20, 12, 8],
        backgroundColor: ['#3b82f6', '#06b6d4', '#7c3aed', '#6366f1', '#8b5cf6'],
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { position: 'bottom' } }
    }
  });
}

// Simuler mise à jour automatique des données
function simulateDataUpdate() {
  // Met à jour KPI aléatoirement (±5%)
  document.getElementById('revenue-value').textContent = 
    '€' + (127450 * (1 + (Math.random() - 0.5) * 0.1)).toLocaleString(undefined, { maximumFractionDigits: 0 });
  
  document.getElementById('orders-value').textContent = 
    Math.floor(1247 * (1 + (Math.random() - 0.5) * 0.1)).toLocaleString();
  
  document.getElementById('clients-value').textContent = 
    Math.floor(324 * (1 + (Math.random() - 0.5) * 0.15)).toLocaleString();
  
  document.getElementById('conversion-value').textContent = 
    (3.4 + (Math.random() - 0.5) * 0.8).toFixed(1) + '%';

  // Met à jour le tableau (simule nouveaux stocks ou ventes)
  productsData.forEach(p => {
    p.sales += Math.floor(Math.random() * 3);
    p.stock = Math.max(0, p.stock - Math.floor(Math.random() * 2));
  });
  renderTable();
}

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
  renderTable();
  initCharts();
  
  // Actualisation automatique toutes les 30 secondes
  setInterval(simulateDataUpdate, 30000);
  
  // Toggle sidebar (optionnel)
  document.querySelector('.sidebar-toggle')?.addEventListener('click', () => {
    document.querySelector('.Dashboard-sidebar')?.classList.toggle('sidebar-collapsed');
  });
});
