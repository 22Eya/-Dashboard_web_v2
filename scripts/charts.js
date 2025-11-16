export let salesChart;
export let categoryChart;


export function initCharts() {
    const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'];
    const salesData = [45200, 52100, 61800, 48900, 68300, 74500];

    // Graphique des ventes
    const ctx1 = document.getElementById("salesChart").getContext("2d");
    salesChart = new Chart(ctx1, {
        type: "bar",
        data: {
            labels: months,
            datasets: [{
                label: "Ventes (€)",
                data: salesData,
                backgroundColor: "rgba(59,130,246,0.7)"
            }]
        }
    });

    // Graphique catégories
    const ctx2 = document.getElementById("categoryChart").getContext("2d");
    categoryChart = new Chart(ctx2, {
        type: "doughnut",
        data: {
            labels: ['Électronique','Vêtements','Maison','Sports','Livres'],
            datasets: [{
                data: [35, 25, 20, 12, 8],
                backgroundColor: ['#3b82f6','#06b6d4','#7c3aed','#6366f1','#8b5cf6']
            }]
        }
    });
     // Nouveau graphique - Trafic (Line Chart)
    const ctx3 = document.getElementById("trafficChart").getContext("2d");
    trafficChart = new Chart(ctx3, {
        type: "line",
        data: {
            labels: months,
            datasets: [
                {
                    label: "Visiteurs",
                    data: [12400, 15200, 18900, 16500, 21300, 24800],
                    borderColor: "#06b6d4",
                    backgroundColor: "rgba(6,182,212,0.1)",
                    tension: 0.4,
                    fill: true
                },
                {
                    label: "Pages vues",
                    data: [34500, 42100, 51200, 45800, 58900, 67200],
                    borderColor: "#7c3aed",
                    backgroundColor: "rgba(124,58,237,0.1)",
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
           
           
        }
    });
}
