<?php
session_start();

// Redirection si non connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'] ?? 'Utilisateur';
$user_initial = strtoupper(substr($username, 0, 1));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    
    <!-- Votre CSS existant -->
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <!-- Header -->
    <header class="Dashboard-header">
        <h1>📊 Dashboard Admin</h1>
        <div class="header-info">
            <span class="date" id="current-date"></span>
            <div class="user-info">
                <div class="avatar"><?php echo $user_initial; ?></div>
                <span><?php echo htmlspecialchars($username); ?></span>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="Dashboard-sidebar">
        <div class="logo">📊</div>
        <nav class="sidebar-nav">
            <ul>
                <li class="nav-item active"><a href="#dashboard"><span>📈</span><span>Dashboard</span></a></li>
                <li class="nav-item"><a href="#products"><span>📦</span><span>Produits</span></a></li>
                <li class="nav-item"><a href="#sales"><span>💰</span><span>Ventes</span></a></li>
                <li class="nav-item"><a href="#analytics"><span>📊</span><span>Analytics</span></a></li>
                <li class="nav-item"><a href="api/logout.php"><span>🚪</span><span>Déconnexion</span></a></li>
            </ul>
        </nav>
        <button class="sidebar-toggle">☰</button>
    </aside>

    <!-- Main Content -->
    <main class="Dashboard-main">
        <!-- KPI Cards -->
        <div class="card kpi-card">
            <div class="kpi-header"><span>Produits Totaux</span><span class="kpi-icon">📦</span></div>
            <div class="kpi-value" id="total-products">0</div>
            <div class="kpi-change positive" id="products-change">--</div>
        </div>

        <div class="card kpi-card">
            <div class="kpi-header"><span>Ventes Totales</span><span class="kpi-icon">💰</span></div>
            <div class="kpi-value" id="total-sales">0 DT</div>
            <div class="kpi-change positive" id="sales-change">--</div>
        </div>

        <div class="card kpi-card">
            <div class="kpi-header"><span>Commandes</span><span class="kpi-icon">📈</span></div>
            <div class="kpi-value" id="total-orders">0</div>
            <div class="kpi-change positive" id="orders-change">--</div>
        </div>

        <div class="card kpi-card">
            <div class="kpi-header"><span>Vente Moyenne</span><span class="kpi-icon">📊</span></div>
            <div class="kpi-value" id="avg-sale">0 DT</div>
            <div class="kpi-change negative" id="avg-change">--</div>
        </div>

        <!-- Table -->
        <div class="card table-card">
            <h2>📦 Liste des Produits</h2>
            <div class="table-controls">
                <div>
                    <label for="rows-per-page">Lignes par page:</label>
                    <select id="rows-per-page">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <button class="btn-export" onclick="exportToCSV()">📥 Exporter CSV</button>
            </div>

            <div class="table-container">
                <table class="data-table" id="productsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produit</th>
                            <th>Catégorie</th>
                            <th>Revenu (€)</th>
                            <th>Stock</th>
                            <th>Ventes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Données dynamiques -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="Dashboard-footer">
        <div class="footer-content">
            <span>© 2024 Dashboard Admin</span>
            <span class="footer-links"><span>Développé avec ❤️</span></span>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Afficher la date actuelle
        const dateEl = document.getElementById('current-date');
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        dateEl.textContent = now.toLocaleDateString('fr-FR', options);

        // Charger les produits et mettre à jour les KPI
        document.addEventListener("DOMContentLoaded", () => {
            fetch("http://localhost/-Dashboard_web_v2/api/get_products.php")
                .then(res => res.json())
                .then(json => {
                    if (!json.success) return;
                    const products = json.data;
                    fillProductsTable(products);
                    updateKPIs(products);
                })
                .catch(err => console.error("Erreur API:", err));
        });

        function fillProductsTable(products) {
            const tbody = document.querySelector("#productsTable tbody");
            tbody.innerHTML = "";
            products.forEach(p => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${p.id}</td>
                    <td>${p.icon} ${p.name}</td>
                    <td>${p.category}</td>
                    <td>${parseFloat(p.revenue).toLocaleString("fr-FR")} DT</td>
                    <td>${p.stock}</td>
                    <td>${p.sales}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        function updateKPIs(products) {
            const totalProducts = products.length;
            document.getElementById("total-products").textContent = totalProducts;

            const totalRevenue = products.reduce((sum, p) => sum + parseFloat(p.revenue), 0);
            document.getElementById("total-sales").textContent = totalRevenue.toLocaleString("fr-FR") + " DT";

            const totalOrders = products.reduce((sum, p) => sum + parseInt(p.sales), 0);
            document.getElementById("total-orders").textContent = totalOrders;

            const avgSale = totalOrders > 0 ? totalRevenue / totalOrders : 0;
            document.getElementById("avg-sale").textContent = avgSale.toFixed(2) + " DT";

            document.getElementById("products-change").textContent = "↑ En hausse";
            document.getElementById("sales-change").textContent = "↑ En hausse";
        }
    </script>
</body>
</html>
