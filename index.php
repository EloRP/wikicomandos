<?php
require_once 'config/db.php';

$busqueda = $_GET['q'] ?? '';
$lenguajeFiltro = $_GET['lenguaje'] ?? '';

$sql = "SELECT * FROM comandos WHERE 1=1";
$params = [];

if (!empty($busqueda)) {
    $sql .= " AND (comando LIKE :busqueda OR descripcion LIKE :busqueda2)";
    $params[':busqueda'] = '%' . $busqueda . '%';
    $params[':busqueda2'] = '%' . $busqueda . '%';
}

if ($lenguajeFiltro != '') {
    $sql .= " AND lenguaje = :lenguaje";
    $params[':lenguaje'] = $lenguajeFiltro;
}

$sql .= " ORDER BY fecha_creacion DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$comandos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$lenguajes = $pdo->query("SELECT DISTINCT lenguaje FROM comandos ORDER BY lenguaje ASC")
    ->fetchAll(PDO::FETCH_COLUMN);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WikiComandos</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<header>
    <h1>&gt; wiki_comandos</h1>
    <a href="add.php" class="btn">Nuevo comando</a>
</header>

<body>
    <form method="GET" class="filtros">
        <input type="text" name="q" placeholder="Busca un comando o descripción..." value="<?= htmlspecialchars($busqueda) ?>">
        <select name="lenguaje">
            <option value="">Todos los lenguajes</option>
            <?php foreach ($lenguajes as $lenguaje): ?>
                <option value="<?= htmlspecialchars($lenguaje) ?>" <?= $lenguajeFiltro === $lenguaje ? 'selected' : '' ?>>
                    <?= htmlspecialchars($lenguaje) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrar</button>
    </form>

    <main>
        <?php if (empty($comandos)): ?>
            <p class="vacio">No se encontraron comandos guardados.</p>
        <?php else: ?>
            <div class="lista-comandos"></div>
            <?php foreach ($comandos as $c): ?>
                <article class="tarjeta">
                    <div class="tarjeta-header">
                        <code><?= htmlspecialchars($c['comando']) ?></code>
                        <span class="etiqueta"><?= htmlspecialchars($c['lenguaje']) ?></span>
                    </div>
                    <p class="descripcion"><?= htmlspecialchars($c['descripcion']) ?></p>
                    <?php if (!empty($c['caso_uso'])): ?>
                        <p class="caso-uso"><strong>Ejemplo:</strong> <?= htmlspecialchars($c['caso_uso']) ?></p>
                    <?php endif; ?>
                    <div class="acciones">
                        <a href="edit.php?id=<?= $c['id'] ?>">Editar</a>
                        <form method="POST" action="delete.php" class="form-eliminar"
                            onsubmit="return confirm('¿Eliminar este comando?')">
                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
                            <button type="submit" class="btn-eliminar">Eliminar</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>