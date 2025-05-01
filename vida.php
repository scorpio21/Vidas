<?php
// =============================================
// Calculadora de Vida para AOMania
// Permite calcular la vida máxima y mínima según nivel, clase y modificadores
// =============================================
require_once __DIR__ . '/src/functions.php';
session_start();

// Lista de clases válidas
$clases = getClasesValidas();

// Inicializar variables del formulario para evitar warnings y errores
$clase = $_POST['clase'] ?? '';
$constitucion = $_POST['constitucion'] ?? '';
$nivel = $_POST['nivel'] ?? '';

// Errores de validación
$errores = [];

// Resultado del cálculo de vida
$vida = null;

// Procesamiento del formulario y cálculo de vida
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Token CSRF
    $csrf_token = $_POST['csrf_token'] ?? '';
    if (!isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
        $errores[] = 'Token CSRF inválido.';
    }

    // Recoger datos del formulario
    // (ya inicializados arriba)

    // Validación de datos
    if (empty($clase)) {
        $errores[] = 'Selecciona una clase.';
    }
    if (empty($constitucion) || !is_numeric($constitucion) || $constitucion < 1 || $constitucion > 21) {
        $errores[] = 'Selecciona la Constitución (1-21).';
    }
    if (empty($nivel) || !is_numeric($nivel) || $nivel < 1 || $nivel > 299) {
        $errores[] = 'Nivel inválido (1-299).';
    }

    // Cálculo de vida si no hay errores
    if (empty($errores)) {
        $vida = calcularVida($clase, $constitucion, $nivel);
        if ($vida === null) {
            $errores[] = 'Datos inválidos.';
        }
    }
}

// Generar token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Metadatos y estilos -->
    <meta charset="UTF-8">
    <title>Calculadora de Vida</title>
    <link rel="stylesheet" href="css/styles.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Encabezado principal de la página de vida -->
    <header class="text-center header-modificadores">
        <h2 id="vida-title"><i class="fas fa-heartbeat"></i> Calculadora de Vida</h2>
        <p class="lead">Calcula la vida de tu personaje según clase, constitución y nivel en AOMania.</p>
    </header>
    <main role="main" aria-labelledby="vida-title" class="main-vida">
        <!-- Formulario para introducir los datos de cálculo de vida -->
        <form method="post" action="index.php?page=vida" class="needs-validation" id="form-vida">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <!-- Selector de clase -->
            <label for="clase"><i class="fas fa-hat-wizard icon-clase"></i> Clase:</label>
            <select name="clase" id="clase" class="form-select select-clase" required>
                <option value="">Selecciona</option>
                <?php foreach ($clases as $clave => $nombre): ?>
                    <option value="<?php echo $clave; ?>" <?php if ($clase === $clave) echo 'selected'; ?>><?php echo $nombre; ?></option>
                <?php endforeach; ?>
            </select>
            <!-- Selector de constitución -->
            <label for="constitucion"><i class="fas fa-dumbbell icon-constitucion"></i> Constitución:</label>
            <input type="number" class="form-control" name="constitucion" id="constitucion" min="1" max="21" value="<?php echo htmlspecialchars($constitucion); ?>" required>
            <!-- Selector de nivel -->
            <label for="nivel"><i class="fas fa-level-up-alt icon-nivel"></i> Nivel:</label>
            <input type="number" class="form-control" name="nivel" id="nivel" min="1" max="299" value="<?php echo htmlspecialchars($nivel); ?>" required>
            <button type="submit" class="btn btn-primary"><i class="fas fa-calculator"></i> Generar</button>
            <a href="index.php" class="btn btn-secondary" id="volver-menu">Volver al menú principal</a>
        </form>
        <div class="text-center mt-3 texto-opaco">
            <i class="fas fa-info-circle"></i> Todos los campos son obligatorios
        </div>
        <?php if (!empty($errores)): ?>
            <!-- Mostrar errores de validación -->
            <div class="alert alert-danger mt-3 animated shake">
                <?php foreach ($errores as $err) echo "<div><i class='fas fa-exclamation-triangle'></i> $err</div>"; ?>
            </div>
        <?php endif; ?>
        <?php
        // Calcular el máximo absoluto posible para la clase seleccionada
        $maxAbsoluto = vidaMaximaAbsoluta($clase ?: 'MAGO');
        ?>
        <?php if ($vida): ?>
            <!-- Mostrar resultados del cálculo de vida -->
            <div class="vida-flex-col">
                <div class="vida-flex">
                    <div class="vida-bar vida-min" style="--val:<?php echo $vida['minimoHP']; ?>;--max:<?php echo $maxAbsoluto; ?>;">
                        <span><b>Vida mínima:</b> <?php echo $vida['minimoHP']; ?> (<?php echo round(100 * $vida['minimoHP'] / $maxAbsoluto); ?>%)</span>
                    </div>
                </div>
                <div class="vida-flex mt-vida">
                    <div class="vida-bar vida-med" style="--val:<?php echo $vida['medioHP']; ?>;--max:<?php echo $maxAbsoluto; ?>;">
                        <span><b>Vida media:</b> <?php echo $vida['medioHP']; ?> (<?php echo round(100 * $vida['medioHP'] / $maxAbsoluto); ?>%)</span>
                    </div>
                </div>
                <div class="vida-flex mt-vida">
                    <div class="vida-bar vida-max" style="--val:<?php echo $vida['maximoHP']; ?>;--max:<?php echo $maxAbsoluto; ?>;">
                        <span><b>Vida máxima:</b> <?php echo $vida['maximoHP']; ?> (<?php echo round(100 * $vida['maximoHP'] / $maxAbsoluto); ?>%)</span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($vida['aumentoMaxHP'])): ?>
            <!-- Mostrar incremento por nivel -->
            <div class="alert alert-info mt-2 texto-pequeño">
                <i class="fas fa-plus-circle"></i> Incremento por nivel: <b><?php echo $vida['aumentoMinHP']; ?></b> mínimo, <b><?php echo $vida['aumentoMaxHP']; ?></b> máximo, <b><?php echo $vida['aumentoMedio']; ?></b> medio.
            </div>
        <?php endif; ?>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
