// data.js
export let productsData = [];
export let salesData = [];

// Charger produits
export async function loadProducts() {
    try {
        const res = await fetch('./api/get_products.php');
        const data = await res.json();
        if (data.success) productsData = data.data;
        else productsData = [];
        return productsData;
    } catch (e) {
        console.error(e);
        productsData = [];
        return [];
    }
}

// Charger ventes
export async function loadSales() {
    try {
        const res = await fetch('./api/get_sales.php');
        const data = await res.json();
        if (data.success) salesData = data.data;
        else salesData = [];
        return salesData;
    } catch (e) {
        console.error(e);
        salesData = [];
        return [];
    }
}

// Export CSV
export function exportToCSV() {
    if (!productsData.length) return alert('Aucune donnée à exporter');
    const headers = ['ID','Nom','Catégorie','Prix','Stock','Ventes'];
    const rows = productsData.map(p => [p.id,p.name,p.category,p.price,p.stock,'--']);
    const csv = [headers.join(','), ...rows.map(r => r.join(','))].join('\n');
    const blob = new Blob([csv], {type:'text/csv;charset=utf-8;'});
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `produits_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
}
