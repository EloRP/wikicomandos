<?php
require_once 'config/db.php';
$errores = [];

$id = $_GET['id'] ?? null; $_POST['id'] ?? null;

if ($id === null || !ctype_digit((string)$id)) {
    die("ID de comando no válido.");
}

$stmt = $pdo->prepare("SELECT * FROM comandos WHERE id = :id");
$stmt->execute(['id' => $id]);
$comando = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$comando) {
    die("Comando no encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comandoTexto = trim($_POST['comando'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $casoUso = trim($_POST['caso_uso'] ?? '');
    $lenguaje = trim($_POST['lenguaje'] ?? '');

    if (empty($comandoTexto)) {
        $errores[] = "El comando es obligatorio.";
    }
    if (empty($descripcion)) {
        $errores[] = "La descripción es obligatoria.";
    }
    if (empty($lenguaje)) {
        $errores[] = "El lenguaje o sistema es obligatorio.";
    }

    if (empty($errores)) {
        try {
            $stmt = $pdo->prepare(
                "UPDATE comandos SET comando = :comando, descripcion = :descripcion, caso_uso = :caso_uso, lenguaje = :lenguaje WHERE id = :id"
            );
            $stmt->execute([
                'comando' => $comandoTexto,
                'descripcion' => $descripcion,
                'caso_uso' => $casoUso,
                'lenguaje' => $lenguaje,
                'id' => $id
            ]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            die("Error al actualizar el comando: " . $e->getMessage());
        }
    }

    $comando = [
        'id' => $id,
        'comando' => $comandoTexto,
        'descripcion' => $descripcion,
        'caso_uso' => $casoUso,
        'lenguaje' => $lenguaje
    ];
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar comando - WikiComandos</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <h1>&gt; editar_comando</h1>
        <a href="index.php" class="btn">&larr; Volver</a>
    </header>

    <main>
        <?php if (!empty($errores)): ?>
            <div class="errores">
                <ul>
                    <?php foreach ($errores as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" class="form-comando">
            <input type="hidden" name="id" value="<?= (int)$comando['id'] ?>">

            <label for="comando">Comando</label>
            <input type="text" id="comando" name="comando"
                   value="<?= htmlspecialchars($comando['comando']) ?>" required>

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3" required><?= htmlspecialchars($comando['descripcion']) ?></textarea>

            <label for="caso_uso">Caso de uso (opcional)</label>
            <textarea id="caso_uso" name="caso_uso" rows="2"><?= htmlspecialchars($comando['caso_uso'] ?? '') ?></textarea>

            <label for="lenguaje">Lenguaje / Sistema</label>
            <input type="text" id="lenguaje" name="lenguaje"
                   value="<?= htmlspecialchars($comando['lenguaje']) ?>" required>

            <button type="submit">Guardar cambios</button>
        </form>
    </main>
</body>
</html>