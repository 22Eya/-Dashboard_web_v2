<?php
session_start();

echo "<h2>Page test_db.php</h2>";

echo "Vous êtes bien redirigé depuis le login.<br><br>";

echo "Session user_id : ";
echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "non défini";

echo "<br>";

echo "Session username : ";
echo isset($_SESSION['username']) ? $_SESSION['username'] : "non défini";
