<?php

$dbPath = __DIR__ . '/../database/CommandWikiDB.db';

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE TABLE IF NOT EXISTS comandos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        comando TEXT NOT NULL,
        descripcion TEXT NOT NULL,
        caso_uso TEXT,
        lenguaje TEXT NOT NULL,
        fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
    )
    ");
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

?>