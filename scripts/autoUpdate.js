import { productsData } from "./data.js";
import { renderTable } from "./table.js";

export function simulateDataUpdate() {
    // KPI
    document.getElementById('revenue-value').textContent =
        '€' + (127450 * (1 + (Math.random() - 0.5) * 0.1)).toLocaleString();

    document.getElementById('orders-value').textContent =
        Math.floor(1247 * (1 + (Math.random() - 0.5) * 0.1));

    // Mise à jour produits
    productsData.forEach(p => {
        p.sales += Math.floor(Math.random() * 3);
        p.stock = Math.max(0, p.stock - Math.floor(Math.random() * 2));
    });

    renderTable();
}
