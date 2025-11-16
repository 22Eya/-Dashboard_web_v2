import { renderTable } from "./table.js";
import { initCharts } from "./charts.js";
import { simulateDataUpdate } from "./autoUpdate.js";
import { currentSort, currentFilter } from "./data.js";

document.addEventListener("DOMContentLoaded", () => {
    renderTable();
    initCharts();

    // clic colonne (tri)
    document.querySelectorAll("th[data-sort]").forEach(th => {
        th.addEventListener("click", () => {
            const key = th.dataset.sort;
            currentSort.order = currentSort.key === key && currentSort.order === "asc" ? "desc" : "asc";
            currentSort.key = key;
            renderTable();
        });
    });

    // filtre
    document.getElementById("category-filter").addEventListener("change", e => {
        currentFilter = e.target.value;
        renderTable();
    });

    // auto-update
    setInterval(simulateDataUpdate, 30000);
});
