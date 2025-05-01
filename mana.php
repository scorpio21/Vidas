<?php
// =============================================
// Calculadora de Maná para AOMania
// Permite calcular el maná máximo y mínimo según nivel, clase y modificadores
// =============================================
require_once __DIR__ . '/src/functions.php';
$clasesValidas = getClasesValidas();
?>

<?php include 'csrf_token.php'; ?>
<!--
=============================================
Encabezado principal de la página de maná
=============================================
-->
<header class="main-header text-center mb-4">
    <h1 id="mana-title"><i class="fas fa-bolt"></i> Mana de los personajes en AOMania</h1>
</header>

<!--
=============================================
Contenido principal de la página de maná
=============================================
-->
<main role="main" aria-labelledby="mana-title">
    <?php
    // Procesamiento del formulario y cálculo de maná
    $errores = [];
    $resultado = '';
    $valores = [
        'clase' => isset($_POST['clase']) ? $_POST['clase'] : '',
        'inteligencia' => isset($_POST['inteligencia']) ? $_POST['inteligencia'] : '',
        'nivel' => isset($_POST['nivel']) ? $_POST['nivel'] : '',
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generar'])) {
        // Verificar token CSRF
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die('Token CSRF inválido.');
        }
        // Recoger datos del formulario
        $clase = strtoupper(htmlspecialchars($valores['clase']));
        $inteligencia = intval($valores['inteligencia']);
        $nivel = intval($valores['nivel']);
        // Validar datos
        if ($clase == '' || !isset($clasesValidas[$clase])) {
            $errores[] = 'Selecciona una clase válida.';
        }
        if ($inteligencia < 1) {
            $errores[] = 'La inteligencia debe ser mayor a 0.';
        }
        if ($nivel < 1 || $nivel > 100) {
            $errores[] = 'El nivel debe estar entre 1 y 100.';
        }
        // Calcular maná mínimo y máximo
        if (empty($errores)) {
            $mana = calcularMana($clase, $inteligencia, $nivel);
            $nombreClase = $clasesValidas[$clase];
            $resultado = "<div class='alert alert-info mt-3 animated fadeIn'><i class='fas fa-bolt'></i> El mana de su Pj <b>$nombreClase</b> con <b>$inteligencia</b> de Inteligencia al Nivel <b>$nivel</b> será de <b>{$mana['minMana']}/{$mana['maxMana']}</b></div>";
        }
    }
    ?>
    <?php
    // Mostrar errores
    if (!empty($errores)): ?>
        <div class="alert alert-danger mt-3 animated shake">
            <?php foreach ($errores as $err) echo "<div><i class='fas fa-exclamation-triangle'></i> $err</div>"; ?>
        </div>
    <?php endif; ?>
    <?php
    // Mostrar resultado
    if (!empty($resultado)) echo $resultado; ?>
    <?php if (!empty($mana) && isset($mana['minMana'], $mana['maxMana'])): ?>
        <?php 
            // Calcular el maná máximo absoluto para la clase seleccionada
            if (!function_exists('manaMaximaAbsoluta')) {
                function manaMaximaAbsoluta($clase) {
                    // Inteligencia máxima 999, nivel máximo 100 según el formulario
                    $resultado = calcularMana($clase, 999, 100);
                    return $resultado ? $resultado['maxMana'] : 0;
                }
            }
            $maxAbsolutoMana = manaMaximaAbsoluta($valores['clase'] ?: 'MAGO');
        ?>
        <div class="mana-flex-col">
            <div class="mana-flex">
                <div class="mana-bar mana-min" style="--val:<?php echo $mana['minMana']; ?>;--max:<?php echo $maxAbsolutoMana; ?>;">
                    <span><b>Maná mínimo:</b> <?php echo $mana['minMana']; ?></span>
                </div>
            </div>
            <div class="mana-flex mt-mana">
                <div class="mana-bar mana-max" style="--val:<?php echo $mana['maxMana']; ?>;--max:<?php echo $maxAbsolutoMana; ?>;">
                    <span><b>Maná máximo:</b> <?php echo $mana['maxMana']; ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php
    // Mostrar incremento de maná
    if (isset($mana['incrementoMana']) && $mana['incrementoMana'] > 0): ?>
        <div class="alert alert-info mt-2 texto-pequeño">
            <i class="fas fa-plus-circle"></i> El incremento de mana por nivel es de: <b><?php echo $mana['incrementoMana']; ?></b>
        </div>
    <?php endif; ?>
    <!-- Formulario para introducir los datos de cálculo de maná -->
    <form method="post" action="index.php?page=mana" class="needs-validation" id="form-mana">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <!-- Selector de clase -->
        <div class="flex-clase mb-3">
            <label for="clase" class="form-label mb-0 label-clase"><i class="fas fa-hat-wizard icon-clase"></i> Clase</label>
            <select name="clase" id="clase" class="form-control select-clase" required>
                <option value="">--Selecciona--</option>
                <?php foreach ($clasesValidas as $key => $label): ?>
                    <option value="<?php echo $key; ?>" <?php if($valores['clase'] === $key) echo 'selected'; ?>><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Selector de inteligencia -->
        <div class="form-mana-container">
            <div class="mb-2 row align-items-center">
                <label for="inteligencia" class="col-7 col-form-label label-inteligencia"><i class="fas fa-brain icon-inteligencia"></i> Inteligencia</label>
                <input type="number" name="inteligencia" id="inteligencia" class="form-control col-5" min="1" max="999" value="<?php echo htmlspecialchars($valores['inteligencia']); ?>" required aria-required="true">
            </div>
            <!-- Selector de nivel -->
            <div class="mb-2 row align-items-center">
                <label for="nivel" class="col-7 col-form-label label-nivel"><i class="fas fa-level-up-alt icon-nivel"></i> Nivel</label>
                <input type="number" name="nivel" id="nivel" class="form-control col-5" min="1" max="100" value="<?php echo htmlspecialchars($valores['nivel']); ?>" required aria-required="true">
            </div>
            <button type="submit" name="generar" class="btn btn-primary btn-sm w-100 mt-2"><i class="fas fa-calculator"></i> Generar</button>
            <a href="index.php" class="btn btn-secondary btn-sm w-100 mt-2 enlace-nowrap"><i class="fas fa-arrow-left"></i> Volver al menú principal</a>
        </div>
        <div class="text-center mt-3 texto-opaco">
            <i class="fas fa-info-circle"></i> Todos los campos son obligatorios
        </div>
    </form>
</main>
<!--
=============================================
Script para mostrar resultados animados y resetear el formulario
=============================================
-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var error = document.querySelector('.alert-danger');
    if(error) {
        var input = document.querySelector('.is-invalid, .alert-danger ~ form input, .alert-danger ~ form select');
        if(input) input.focus();
    }
});
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('form-mana');
    if(form) {
        form.addEventListener('submit', function(e) {
            if (form.checkValidity()) {
                setTimeout(function(){
                    form.querySelector('button[type=submit]').disabled = true;
                }, 50);
            } else {
                form.classList.add('was-validated');
                e.preventDefault();
                e.stopPropagation();
            }
        });
    }
});
</script>