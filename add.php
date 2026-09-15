<?php
require_once 'config/db.php';

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comando = trim($_POST['comando'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $caso_uso = trim($_POST['caso_uso'] ?? '');
    $lenguaje = trim($_POST['lenguaje'] ?? '');

    if (empty($comando)) {
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
                "INSERT INTO comandos (comando, descripcion, caso_uso, lenguaje) 
                 VALUES (:comando, :descripcion, :caso_uso, :lenguaje)"
            );
            $stmt->execute([
                'comando' => $comando,
                'descripcion' => $descripcion,
                'caso_uso' => $caso_uso,
                'lenguaje' => $lenguaje
            ]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            die("Error al insertar el comando: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo comando - WikiComandos</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <header>
        <h1>&gt; nuevo_comando</h1>
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
            <label for="comando">Comando</label>
            <input type="text" id="comando" name="comando"
                value="<?= htmlspecialchars($_POST['comando'] ?? '') ?>"
                placeholder="ej. git rebase -i HEAD~3" required>

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3" required><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>

            <label for="caso_uso">Caso de uso (opcional)</label>
            <textarea id="caso_uso" name="caso_uso" rows="2"><?= htmlspecialchars($_POST['caso_uso'] ?? '') ?></textarea>

            <label for="lenguaje">Lenguaje / Sistema</label>
            <input type="text" id="lenguaje" name="lenguaje"
                value="<?= htmlspecialchars($_POST['lenguaje'] ?? '') ?>"
                placeholder="ej. Git, Linux, Docker, Python..." required>

            <button type="submit">Guardar comando</button>
        </form>
    </main>
</body>

</html>

</html>