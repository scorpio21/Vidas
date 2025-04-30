<?php
require_once __DIR__ . '/src/functions.php';
session_start();

$clases = getClasesValidas();
$errores = [];
$vida = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf_token = $_POST['csrf_token'] ?? '';
    if (!isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
        $errores[] = 'Token CSRF inválido.';
    }
    $clase = $_POST['clase'] ?? '';
    $constitucion = $_POST['constitucion'] ?? '';
    $nivel = $_POST['nivel'] ?? '';

    if (empty($clase)) {
        $errores[] = 'Selecciona una clase.';
    }
    if (empty($constitucion) || !is_numeric($constitucion) || $constitucion < 1 || $constitucion > 21) {
        $errores[] = 'Selecciona la Constitución (1-21).';
    }
    if (empty($nivel) || !is_numeric($nivel) || $nivel < 1 || $nivel > 299) {
        $errores[] = 'Nivel inválido (1-299).';
    }
    if (empty($errores)) {
        $vida = calcularVida($clase, $constitucion, $nivel);
        if ($vida === null) {
            $errores[] = 'Datos inválidos.';
        }
    }
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de Vida</title>
    <link rel="stylesheet" href="css/styles.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="text-center header-modificadores">
        <h2 id="vida-title"><i class="fas fa-heartbeat"></i> Calculadora de Vida</h2>
        <p class="lead">Calcula la vida de tu personaje según clase, constitución y nivel en AOMania.</p>
    </header>
    <main role="main" aria-labelledby="vida-title" style="max-width: 500px; margin: 40px auto 0 auto;">
        <form method="post" action="index.php?page=vida" class="needs-validation" id="form-vida">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label for="clase"><i class="fas fa-hat-wizard" style="color:#2196f3;"></i> Clase:</label>
            <select name="clase" id="clase" class="form-select" required style="width:100%;"> 
                <option value="">Selecciona</option>
                <?php foreach ($clases as $clave => $nombre): ?>
                    <option value="<?php echo $clave; ?>" <?php if (($clase ?? '') === $clave) echo 'selected'; ?>><?php echo $nombre; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="constitucion"><i class="fas fa-dumbbell" style="color:#43e97b;"></i> Constitución:</label>
            <input type="number" class="form-control" name="constitucion" id="constitucion" min="1" max="21" value="<?php echo htmlspecialchars($constitucion ?? ''); ?>" required style="width:100%;">
            <label for="nivel"><i class="fas fa-level-up-alt" style="color:#ffd900;"></i> Nivel:</label>
            <input type="number" class="form-control" name="nivel" id="nivel" min="1" max="299" value="<?php echo htmlspecialchars($nivel ?? ''); ?>" required style="width:100%;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-calculator"></i> Generar</button>
            <a href="index.php" class="btn btn-secondary" style="margin-top:8px;">Volver al menú principal</a>
        </form>
        <div class="text-center mt-3" style="opacity:0.75;font-size:0.9em;">
            <i class="fas fa-info-circle"></i> Todos los campos son obligatorios
        </div>
        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger mt-3 animated shake">
                <?php foreach ($errores as $err) echo "<div><i class='fas fa-exclamation-triangle'></i> $err</div>"; ?>
            </div>
        <?php endif; ?>
        <?php
        // Calcular el máximo absoluto posible para la clase seleccionada
        function vidaMaximaAbsoluta($clase) {
            $constitucion = 21;
            $nivel = 299;
            $vida = calcularVida($clase, $constitucion, $nivel);
            return $vida ? $vida['maximoHP'] : 1;
        }
        $maxAbsoluto = vidaMaximaAbsoluta($clase ?? 'MAGO');
        ?>
        <?php if ($vida): ?>
            <div style="margin: 1.5em 0 1em 0; display: flex; flex-direction: column; align-items: center;">
                <div style="display:flex;gap:12px;align-items:center;justify-content:center;">
                    <div class="vida-bar vida-min" style="--val:<?php echo $vida['minimoHP']; ?>;--max:<?php echo $maxAbsoluto; ?>;">
                        <span><b>Vida mínima:</b> <?php echo $vida['minimoHP']; ?> (<?php echo round(100 * $vida['minimoHP'] / $maxAbsoluto); ?>%)</span>
                    </div>
                </div>
                <div style="display:flex;gap:12px;align-items:center;justify-content:center;margin-top:6px;">
                    <div class="vida-bar vida-med" style="--val:<?php echo $vida['medioHP']; ?>;--max:<?php echo $maxAbsoluto; ?>;">
                        <span><b>Vida media:</b> <?php echo $vida['medioHP']; ?> (<?php echo round(100 * $vida['medioHP'] / $maxAbsoluto); ?>%)</span>
                    </div>
                </div>
                <div style="display:flex;gap:12px;align-items:center;justify-content:center;margin-top:6px;">
                    <div class="vida-bar vida-max" style="--val:<?php echo $vida['maximoHP']; ?>;--max:<?php echo $maxAbsoluto; ?>;">
                        <span><b>Vida máxima:</b> <?php echo $vida['maximoHP']; ?> (<?php echo round(100 * $vida['maximoHP'] / $maxAbsoluto); ?>%)</span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($vida['aumentoMaxHP'])): ?>
            <div class="alert alert-info mt-2" style="font-size:0.93em;">
                <i class="fas fa-plus-circle"></i> Incremento por nivel: <b><?php echo $vida['aumentoMinHP']; ?></b> mínimo, <b><?php echo $vida['aumentoMaxHP']; ?></b> máximo, <b><?php echo $vida['aumentoMedio']; ?></b> medio.
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
