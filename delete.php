<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = $_POST['id'] ?? null;

if ($id === null || !ctype_digit((string)$id)) {
    die('ID de comando no válido.');
}

$stmt = $pdo->prepare("DELETE FROM comandos WHERE id = :id");
$stmt->execute(['id' => $id]);

header('Location: index.php?eliminado=1');
exit;