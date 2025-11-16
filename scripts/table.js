import { productsData, currentSort, currentFilter } from './data.js';

export function renderTable() {
    const tableBody = document.getElementById('products-table-body');

    // Filtrer
    let filtered = currentFilter === 'all' 
        ? productsData 
        : productsData.filter(p => p.category === currentFilter);

    // Trier
    filtered.sort((a, b) => {
        const aVal = a[currentSort.key];
        const bVal = b[currentSort.key];
        if (typeof aVal === 'string')
            return currentSort.order === 'asc' ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
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
            <td><span class="category-tag">${p.category}</span></td>
            <td>${p.sales}</td>
            <td>€${p.revenue.toLocaleString()}</td>
            <td>${p.stock}</td>
        </tr>
    `).join('');
}
