<?php include 'csrf_token.php'; ?>
<header class="main-header text-center mb-4">
    <h1 id="mana-title"><i class="fas fa-bolt"></i> Mana de los personajes en AOMania</h1>
</header>
<!-- Eliminada la barra de navegación duplicada -->
<main role="main" aria-labelledby="mana-title">
    <?php include_once 'src/functions.php'; $clasesValidas = getClasesValidas(); ?>
    <?php
    $errores = [];
    $resultado = '';
    $valores = [
        'clase' => isset($_POST['clase']) ? $_POST['clase'] : '',
        'inteligencia' => isset($_POST['inteligencia']) ? $_POST['inteligencia'] : '',
        'nivel' => isset($_POST['nivel']) ? $_POST['nivel'] : '',
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generar'])) {
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die('Token CSRF inválido.');
        }
        $clase = strtoupper(htmlspecialchars($valores['clase']));
        $inteligencia = intval($valores['inteligencia']);
        $nivel = intval($valores['nivel']);
        if ($clase == '' || !isset($clasesValidas[$clase])) {
            $errores[] = 'Selecciona una clase válida.';
        }
        if ($inteligencia < 1) {
            $errores[] = 'La inteligencia debe ser mayor a 0.';
        }
        if ($nivel < 1 || $nivel > 100) {
            $errores[] = 'El nivel debe estar entre 1 y 100.';
        }
        if (empty($errores)) {
            $mana = calcularMana($clase, $inteligencia, $nivel);
            $nombreClase = $clasesValidas[$clase];
            $resultado = "<div class='alert alert-info mt-3 animated fadeIn'><i class='fas fa-bolt'></i> El mana de su Pj <b>$nombreClase</b> con <b>$inteligencia</b> de Inteligencia al Nivel <b>$nivel</b> será de <b>{$mana['minMana']}/{$mana['maxMana']}</b></div>";
        }
    }
    ?>
    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger mt-3 animated shake">
            <?php foreach ($errores as $err) echo "<div><i class='fas fa-exclamation-triangle'></i> $err</div>"; ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($resultado)) echo $resultado; ?>
    <?php if (isset($mana['incrementoMana']) && $mana['incrementoMana'] > 0): ?>
        <div class="alert alert-info mt-2" style="font-size:0.93em;">
            <i class="fas fa-plus-circle"></i> El incremento de mana por nivel es de: <b><?php echo $mana['incrementoMana']; ?></b>
        </div>
    <?php endif; ?>
    <form method="post" action="index.php?page=mana" class="needs-validation" id="form-mana">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
            <label for="clase" class="form-label mb-0"><i class="fas fa-hat-wizard" style="color:#2196f3;"></i> Clase</label>
            <select name="clase" id="clase" class="form-control" required style="max-width:180px;">
                <option value="">--Selecciona--</option>
                <?php foreach ($clasesValidas as $key => $label): ?>
                    <option value="<?php echo $key; ?>" <?php if($valores['clase'] === $key) echo 'selected'; ?>><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="max-width:340px;margin:18px auto 0 auto;">
            <div class="mb-2 row align-items-center">
                <label for="inteligencia" class="col-7 col-form-label" style="font-weight:500;"><i class="fas fa-brain" style="color:#43e97b;"></i> Inteligencia</label>
                <input type="number" name="inteligencia" id="inteligencia" class="form-control col-5" min="1" max="999" value="<?php echo htmlspecialchars($valores['inteligencia']); ?>" required aria-required="true">
            </div>
            <div class="mb-2 row align-items-center">
                <label for="nivel" class="col-7 col-form-label" style="font-weight:500;"><i class="fas fa-level-up-alt" style="color:#ffd900;"></i> Nivel</label>
                <input type="number" name="nivel" id="nivel" class="form-control col-5" min="1" max="100" value="<?php echo htmlspecialchars($valores['nivel']); ?>" required aria-required="true">
            </div>
            <button type="submit" name="generar" class="btn btn-primary btn-sm w-100 mt-2"><i class="fas fa-calculator"></i> Generar</button>
            <a href="index.php" class="btn btn-secondary btn-sm w-100 mt-2" style="white-space:nowrap;"><i class="fas fa-arrow-left"></i> Volver al menú principal</a>
        </div>
        <div class="text-center mt-3" style="opacity:0.75;font-size:0.9em;">
            <i class="fas fa-info-circle"></i> Todos los campos son obligatorios
        </div>
    </form>
</main>
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