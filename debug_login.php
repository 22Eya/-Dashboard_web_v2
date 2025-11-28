<?php
require_once 'config/database.php';

echo "<h2>🔍 Diagnostic de connexion</h2>";

// Test 1: Connexion base de données
try {
    $conn = getConnection();
    echo "✅ Connexion à la base de données OK<br><br>";
} catch (Exception $e) {
    echo "❌ Erreur connexion BD: " . $e->getMessage() . "<br>";
    exit;
}

// Test 2: Récupération de l'utilisateur
$username = 'admin';
$password = 'admin123';

$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

echo "<h3>Résultat de la requête:</h3>";
echo "<pre>";
print_r($user);
echo "</pre>";

if (!$user) {
    echo "❌ Aucun utilisateur trouvé avec le nom 'admin'<br>";
    echo "<br><h3>Utilisateurs dans la base:</h3>";
    $all = $conn->query("SELECT id, username FROM users")->fetchAll();
    print_r($all);
    exit;
}

echo "✅ Utilisateur trouvé: " . $user['username'] . "<br>";
echo "📝 Hash dans la BD: " . substr($user['password'], 0, 30) . "...<br><br>";

// Test 3: Vérification du mot de passe
echo "<h3>Test de vérification du mot de passe:</h3>";
$verify_result = password_verify($password, $user['password']);
echo "Mot de passe testé: '$password'<br>";
echo "Résultat: " . ($verify_result ? "✅ CORRECT" : "❌ INCORRECT") . "<br><br>";

// Test 4: Type de hash
$hash_info = password_get_info($user['password']);
echo "<h3>Informations sur le hash:</h3>";
echo "<pre>";
print_r($hash_info);
echo "</pre>";

// Test 5: Créer un nouveau hash pour comparaison
$new_hash = password_hash($password, PASSWORD_DEFAULT);
echo "<h3>Test avec un nouveau hash:</h3>";
echo "Nouveau hash: " . substr($new_hash, 0, 30) . "...<br>";
echo "Vérification: " . (password_verify($password, $new_hash) ? "✅ OK" : "❌ FAIL") . "<br><br>";

// Test 6: Comparaison directe (dangereux, juste pour debug)
echo "<h3>⚠️ Tests supplémentaires:</h3>";
echo "Hash commence par \$2y\$ ? " . (strpos($user['password'], '$2y$') === 0 ? "✅ Oui" : "❌ Non") . "<br>";
echo "Longueur du hash: " . strlen($user['password']) . " (devrait être 60)<br>";
?>