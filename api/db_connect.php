<?php
/**
 * Connexion à la base de données GSB
 * Utilise PDO pour une connexion sécurisée
 */

$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'gsb_site';

try {
    $conn = new PDO(
        "mysql:host=$servername;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'status' => 0,
        'status_message' => 'Erreur de connexion à la base de données : ' . $e->getMessage()
    ]);
    exit;
}
?>
