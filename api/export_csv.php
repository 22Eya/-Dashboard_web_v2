<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die('Non authentifié');
}

require_once '../config/database.php';

try {
    $conn = getConnection();
    $stmt = $conn->query("SELECT * FROM products ORDER BY sales DESC");
    $products = $stmt->fetchAll();
    
    // Headers pour téléchargement CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=produits_' . date('Y-m-d_H-i-s') . '.csv');
    
    $output = fopen('php://output', 'w');
    
    // BOM UTF-8 pour Excel
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // En-têtes
    fputcsv($output, ['ID', 'Produit', 'Catégorie', 'Ventes', 'Revenue (€)', 'Stock', 'Icône'], ';');
    
    // Données
    foreach ($products as $product) {
        fputcsv($output, [
            $product['id'],
            $product['name'],
            $product['category'],
            $product['sales'],
            number_format($product['revenue'], 2, ',', ' '),
            $product['stock'],
            $product['icon']
        ], ';');
    }
    
    fclose($output);
    exit;
    
} catch(PDOException $e) {
    http_response_code(500);
    die('Erreur : ' . $e->getMessage());
}
?>