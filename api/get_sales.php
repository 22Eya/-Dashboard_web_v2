<?php
header('Content-Type: application/json');
session_start();

// Vérifier la session
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Non authentifié']);
    exit;
}

require_once '../config/database.php';

try {
    $conn = getConnection();
    
    // Préparer la requête
    $stmt = $conn->prepare("SELECT id, month, amount, year FROM monthly_sales ORDER BY year DESC, id DESC");
    
    // Exécuter la requête
    $stmt->execute();

    // Récupérer toutes les ventes
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'data' => $sales
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
