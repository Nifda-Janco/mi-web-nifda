<?php
$host = 'db';
$dbname = 'mi_sitio';
$user = 'usuario';
$pass = 'password123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Agregar tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo'])) {
    $stmt = $pdo->prepare("INSERT INTO tareas (titulo, descripcion) VALUES (?, ?)");
    $stmt->execute([$_POST['titulo'], $_POST['descripcion']]);
    header("Location: index.php");
    exit;
}

// Eliminar tarea
if (isset($_GET['eliminar'])) {
    $stmt = $pdo->prepare("DELETE FROM tareas WHERE id = ?");
    $stmt->execute([$_GET['eliminar']]);
    header("Location: index.php");
    exit;
}

// Completar tarea
if (isset($_GET['completar'])) {
    $stmt = $pdo->prepare("UPDATE tareas SET completada = 1 WHERE id = ?");
    $stmt->execute([$_GET['completar']]);
    header("Location: index.php");
    exit;
}

$tareas = $pdo->query("SELECT * FROM tareas ORDER BY fecha_creacion DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tareas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>📋 Gestión de Tareas</h1>

        <div class="form-card">
            <h2>Nueva Tarea</h2>
            <form method="POST">
                <input type="text" name="titulo" placeholder="Título de la tarea" required>
                <textarea name="descripcion" placeholder="Descripción (opcional)"></textarea>
                <button type="submit">➕ Agregar Tarea</button>
            </form>
        </div>

        <div class="tareas-lista">
            <?php foreach ($tareas as $tarea): ?>
            <div class="tarea <?= $tarea['completada'] ? 'completada' : '' ?>">
                <div class="tarea-info">
                    <h3><?= htmlspecialchars($tarea['titulo']) ?></h3>
                    <p><?= htmlspecialchars($tarea['descripcion']) ?></p>
                    <small>🕒 <?= $tarea['fecha_creacion'] ?></small>
                </div>
                <div class="tarea-acciones">
                    <?php if (!$tarea['completada']): ?>
                    <a href="?completar=<?= $tarea['id'] ?>" class="btn-completar">✅</a>
                    <?php endif; ?>
                    <a href="?eliminar=<?= $tarea['id'] ?>" class="btn-eliminar" onclick="return confirm('¿Eliminar?')">🗑️</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="js/main.js"></script>
</body>
</html>