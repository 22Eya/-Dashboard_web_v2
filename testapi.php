<?php
session_start();
require_once 'config/database.php';

// Simuler une session pour tester
$_SESSION['user_id'] = 5;
$_SESSION['username'] = 'admin';

echo "<h1>🔍 Test des APIs</h1>";
echo "<style>body { font-family: system-ui; padding: 20px; } pre { background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto; }</style>";

// Test 1: Connexion à la base de données
echo "<h2>1️⃣ Test de connexion à la base de données</h2>";
try {
    $conn = getConnection();
    echo "✅ <strong>Connexion réussie</strong><br><br>";
} catch (Exception $e) {
    echo "❌ <strong>Erreur:</strong> " . $e->getMessage() . "<br><br>";
    exit;
}

// Test 2: Comptage des produits
echo "<h2>2️⃣ Test de la table 'products'</h2>";
try {
    $stmt = $conn->query("SELECT COUNT(*) as count FROM products");
    $count = $stmt->fetch()['count'];
    echo "✅ Nombre de produits: <strong>$count</strong><br>";
    
    if ($count > 0) {
        $stmt = $conn->query("SELECT * FROM products LIMIT 3");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<details><summary>Afficher les 3 premiers produits</summary><pre>";
        print_r($products);
        echo "</pre></details>";
    } else {
        echo "⚠️ Aucun produit dans la base de données<br>";
    }
    echo "<br>";
} catch (Exception $e) {
    echo "❌ <strong>Erreur:</strong> " . $e->getMessage() . "<br><br>";
}

// Test 3: Comptage des ventes
echo "<h2>3️⃣ Test de la table 'sales'</h2>";
try {
    $stmt = $conn->query("SELECT COUNT(*) as count FROM monthly_sales");
    $count = $stmt->fetch()['count'];
    echo "✅ Nombre de ventes: <strong>$count</strong><br>";
    
    if ($count > 0) {
        $stmt = $conn->query("SELECT * FROM monthly_sales LIMIT 3");
        $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<details><summary>Afficher les 3 premières ventes</summary><pre>";
        print_r($sales);
        echo "</pre></details>";
    } else {
        echo "⚠️ Aucune vente dans la base de données<br>";
    }
    echo "<br>";
} catch (Exception $e) {
    echo "❌ <strong>Erreur:</strong> " . $e->getMessage() . "<br><br>";
}

// Test 4: API get_products.php
echo "<h2>4️⃣ Test de l'API get_products.php</h2>";
$productsApiUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/api/get_products.php';
echo "URL: <code>$productsApiUrl</code><br>";

// Test 5: API get_sales.php
echo "<h2>5️⃣ Test de l'API get_sales.php</h2>";
$salesApiUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/api/get_sales.php';
echo "URL: <code>$salesApiUrl</code><br><br>";

echo "<div style='background: #e0f2fe; padding: 15px; border-radius: 5px; margin-top: 20px;'>";
echo "<h3>📝 Instructions:</h3>";
echo "<ol>";
echo "<li>Ouvrez la console du navigateur (F12)</li>";
echo "<li>Allez sur <a href='dashboard.php'>dashboard.php</a></li>";
echo "<li>Vérifiez les requêtes dans l'onglet Network</li>";
echo "<li>Vérifiez les logs dans l'onglet Console</li>";
echo "</ol>";
echo "</div>";
?>