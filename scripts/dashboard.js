// dashboard.js
import { loadProducts, loadSales, exportToCSV, productsData, salesData } from './data.js';

let allProducts = [];
let allSales = [];

document.addEventListener('DOMContentLoaded', async () => {
    await loadAllData();
    setInterval(loadAllData, 30000);
});

async function loadAllData() {
    try {
        allProducts = await loadProducts();
        allSales = await loadSales();
        updateKPIs();
        updateProductsTable();
        initCharts();
    } catch(e) { console.error(e); }
}

function updateKPIs() {
    const totalProducts = allProducts.length;
    const totalSales = allSales.reduce((sum,s)=>sum+parseFloat(s.amount||0),0);
    const totalOrders = allSales.length;
    const avgSale = totalOrders ? totalSales/totalOrders : 0;

    document.getElementById('total-products').textContent = totalProducts;
    document.getElementById('total-sales').textContent = totalSales.toFixed(2)+' DT';
    document.getElementById('total-orders').textContent = totalOrders;
    document.getElementById('avg-sale').textContent = avgSale.toFixed(2)+' DT';
}

// Tableau produits
function updateProductsTable() {
    const tbody = document.querySelector('#productsTable tbody');
    tbody.innerHTML = allProducts.map(p=>`
        <tr>
            <td>${p.id}</td>
            <td>${p.name}</td>
            <td>${p.category}</td>
            <td>${parseFloat(p.price||0).toFixed(2)} DT</td>
            <td>${p.stock}</td>
            <td>--</td>
        </tr>
    `).join('');
}

// Graphiques
function initCharts() {
    const months = salesData.map(s=>s.month);
    const amounts = salesData.map(s=>parseFloat(s.amount));

    // Ventes mensuelles
    const ctx1 = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx1, {
        type:'bar',
        data:{ labels:months, datasets:[{ label:'Ventes', data:amounts, backgroundColor:'rgba(59,130,246,0.7)'}] },
        options:{ responsive:true, maintainAspectRatio:false }
    });

    // Catégories
    const ctx2 = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctx2, {
        type:'doughnut',
        data:{ labels:['Électronique','Vêtements','Maison','Sports','Livres'], datasets:[{ data:[35,25,20,12,8], backgroundColor:['#3b82f6','#06b6d4','#7c3aed','#6366f1','#8b5cf6'] }] },
        options:{ responsive:true, maintainAspectRatio:false }
    });

    // Top produits (simple mock)
    const ctx3 = document.getElementById('productsChart').getContext('2d');
    new Chart(ctx3, {
        type:'bar',
        data:{ labels:allProducts.slice(0,5).map(p=>p.name), datasets:[{ label:'Ventes', data:allProducts.slice(0,5).map(_=>Math.floor(Math.random()*100)), backgroundColor:'#3b82f6'}] },
        options:{ responsive:true, maintainAspectRatio:false }
    });

    // Trafic (mock)
    const ctx4 = document.getElementById('trafficChart').getContext('2d');
    new Chart(ctx4, {
        type:'line',
        data:{ labels:months, datasets:[{ label:'Visiteurs', data:[12400,15200,18900,16500,21300,24800], borderColor:'#06b6d4', fill:true, backgroundColor:'rgba(6,182,212,0.1)' }] },
        options:{ responsive:true, maintainAspectRatio:false }
    });
}
