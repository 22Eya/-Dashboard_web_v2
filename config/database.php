<?php
// Configuration MySQL
define('DB_HOST', 'localhost');
define('DB_NAME', 'ecommerce_dashboard');
define('DB_USER', 'root');
define('DB_PASS', ''); // mot de passe MySQL (laisser vide si pas de mot de passe)

function getConnection() {
    try {
        $conn = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
        return $conn;
    } catch(PDOException $e) {
        die("❌ Erreur de connexion : " . $e->getMessage());
    }
}
?>