<?php
// ===============================
// Calculadora de Experiencia por Criatura
// Permite calcular cuántas criaturas (NPCs) hay que derrotar para subir de nivel en AOMania
// ===============================
// Página: Calculadora de Experiencia por Criatura (AOMania style, datos reales)
include 'csrf_token.php';
?>
<!-- Encabezado principal de la página de experiencia por criatura -->
<header class="text-center header-modificadores">
    <h2 id="criatura-title"><i class="fas fa-dragon"></i> Calculadora de Experiencia por Criatura</h2>
    <p class="lead">Calcula cuántas criaturas (NPCs) necesitas derrotar para subir al siguiente nivel en AOMania.</p>
</header>
<!-- Contenido principal de la página -->
<main role="main" aria-labelledby="criatura-title" class="main-500">
    <?php
    // --- TABLA DE EXPERIENCIA INCREMENTAL POR NIVEL SEGÚN SCRIPT DE LA WEB ---
    // Se carga desde tabla_exp_incremental.php para facilitar mantenimiento y reutilización
    $tabla_exp_incremental = require __DIR__ . '/tabla_exp_incremental.php';
    
    // Función para obtener la experiencia incremental para un nivel determinado
    function expIncrementalAOMania($nivel) {
        global $tabla_exp_incremental;
        return $tabla_exp_incremental[$nivel] ?? 0;
    }
    
    // Procesamiento del formulario y cálculo de experiencia
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nivel_actual'], $_POST['criatura'], $_POST['exp_actual'])) {
        // Recoger datos del formulario
        $nivel_actual = max(1, min(56, (int)$_POST['nivel_actual']));
        $nivel_siguiente = $nivel_actual + 1;
        $criatura = $_POST['criatura'];
        $exp_criatura = $criaturas[$criatura] ?? 1;
        $exp_necesaria = expIncrementalAOMania($nivel_actual);
        $cantidad = $exp_criatura > 0 ? ceil($exp_necesaria / $exp_criatura) : 0;
        $exp_total = $cantidad * $exp_criatura;
        // Experiencia acumulada hasta el nivel actual y siguiente
        $exp_acumulada = 0;
        for ($i = 1; $i < $nivel_actual; $i++) {
            $exp_acumulada += expIncrementalAOMania($i);
        }
        $exp_acumulada_siguiente = $exp_acumulada + $exp_necesaria;
        $exp_actual_usuario = isset($_POST['exp_actual']) ? max(0, (int)$_POST['exp_actual']) : 0;
        $progreso = 0;
        if ($exp_necesaria > 0) {
            $progreso = min(100, round(($exp_actual_usuario / $exp_necesaria) * 100));
        }
        // Bloque visual de resultados
        echo '<div id="resultado-criatura" class="boxresult_vida text-center mt-4 resultado-oculto">';
        echo '<div class="result_vida-title"><i class="fas fa-dragon"></i> Resultado de la Calculadora</div>';
        echo '<div class="result_vida-item min"><span><i class="fas fa-skull-crossbones"></i> Debes matar:</span> <span class="res-destacado">'. $cantidad .' <span class="res-verde">'. htmlspecialchars($criatura) . ($cantidad == 1 ? '' : 's') .'</span></span></div>';
        echo '<div class="result_vida-item average"><span><i class="fas fa-bolt"></i> EXP obtenida:</span> <span class="res-grande">'. number_format($exp_total) .'</span></div>';
        echo '<div class="result_vida-item max"><span><i class="fas fa-level-up-alt"></i> EXP necesaria:</span> <span class="res-grande">'. number_format($exp_necesaria) .'</span></div>';
        echo '<div class="result_vida-item fondo-oscuro">';
        echo '<span><i class="fas fa-star"></i> Subirás al nivel:</span> <span class="res-amplio"><b>'. $nivel_siguiente .'</b></span>';
        echo '</div>';
        echo '<div class="result_vida-item fondo-oscuro">';
        echo '<span><i class="fas fa-chart-bar"></i> Experiencia acumulada hasta el nivel '. $nivel_siguiente .':</span> <span class="res-mediano">'. number_format($exp_acumulada_siguiente) .'</span>';
        echo '</div>';
        // Barra de progreso real
        echo '<div class="barra-progreso-wrap">';
        echo '<div class="barra-progreso-fondo">';
        echo '<div id="barra-progreso-exp" class="barra-progreso-real" data-width="'.$progreso.'"></div>';
        echo '</div>';
        echo '<span class="progreso-texto">Progreso hacia el siguiente nivel: <span id="progreso-texto">'.number_format(min($exp_actual_usuario, $exp_necesaria)).'</span> / '.number_format($exp_necesaria).' EXP</span>';
        echo '</div>';
        echo '<button id="limpiar-criatura" class="btn btn-secondary btn-sm mt-2" type="button"><i class="fas fa-eraser"></i> Limpiar</button>';
        echo '</div>';
    }
    ?>
    <!-- Formulario para introducir los datos de cálculo de experiencia -->
    <div class="form-criatura-container">
        <form method="post" class="needs-validation" id="form-criatura">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <!-- Selector de criatura -->
            <div class="mb-2 row align-items-center">
                <label for="criatura" class="col-7 col-form-label label-bold"><i class="fas fa-paw icon-exp"></i> Criatura (NPC)</label>
                <select name="criatura" id="criatura" class="form-control col-5" required style="min-width:110px; max-width:180px;">
                    <?php
                    // Cargar lista real de criaturas y experiencia de AOMania
                    $criaturas = include __DIR__ . '/criaturas_aomania.php';
                    $criatura_sel = $_POST['criatura'] ?? 'Murciélago';
                    foreach ($criaturas as $nombre => $exp) {
                        $sel = ($criatura_sel === $nombre) ? 'selected' : '';
                        echo "<option value='$nombre' $sel>$nombre</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Selector de nivel actual -->
            <div class="mb-2 row align-items-center">
                <label for="nivel_actual" class="col-7 col-form-label label-bold"><i class="fas fa-level-up-alt"></i> Nivel actual</label>
                <select class="form-control col-5" name="nivel_actual" id="nivel_actual" required>
                    <?php
                    for ($i = 1; $i <= 56; $i++) {
                        $sel = (isset($_POST['nivel_actual']) && (int)$_POST['nivel_actual'] == $i) ? 'selected' : '';
                        echo "<option value='$i' $sel>$i</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Campo de experiencia actual -->
            <div class="mb-2 row align-items-center">
                <label for="exp_actual" class="col-7 col-form-label label-bold"><i class="fas fa-tachometer-alt icon-exp"></i> EXP actual</label>
                <input type="number" class="form-control col-5" name="exp_actual" id="exp_actual" min="0" value="<?php echo isset($_POST['exp_actual']) ? (int)$_POST['exp_actual'] : 0; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary btn-sm w-100 mt-2"><i class="fas fa-calculator"></i> Calcular</button>
        </form>
    </div>
    <div class="text-center mt-3 texto-opaco">
        <i class="fas fa-info-circle"></i> Todos los campos son obligatorios
    </div>
</main>
<!-- Script para animar la aparición del resultado y barra de progreso -->
<!-- También resetea el formulario y oculta el resultado si se pulsa el botón limpiar -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var resultado = document.getElementById('resultado-criatura');
    if(resultado) {
        // Animación fadeIn
        setTimeout(function() {
            resultado.classList.remove('resultado-oculto');
            // Barra de progreso animada (real)
            var barra = document.getElementById('barra-progreso-exp');
            if(barra) {
                var width = barra.getAttribute('data-width');
                barra.style.width = width + '%';
            }
        }, 100);
    }
    // Botón limpiar
    var limpiarBtn = document.getElementById('limpiar-criatura');
    if(limpiarBtn) {
        limpiarBtn.addEventListener('click', function() {
            var form = document.getElementById('form-criatura');
            if(form) {
                form.reset();
            }
            resultado.classList.add('resultado-oculto');
            setTimeout(function() {
                resultado.style.display = 'none';
            }, 700);
        });
    }
});
</script>
