<?php
// Página: Calculadora de Experiencia por Criatura (AOMania style, datos reales)
include 'csrf_token.php';
?>
<header class="text-center header-modificadores">
    <h2 id="criatura-title"><i class="fas fa-dragon"></i> Calculadora de Experiencia por Criatura</h2>
    <p class="lead">Calcula cuántas criaturas (NPCs) necesitas derrotar para subir al siguiente nivel en AOMania.</p>
</header>
<main role="main" aria-labelledby="criatura-title" style="max-width: 500px; margin: 40px auto 0 auto;">
    <?php
    // --- TABLA DE EXPERIENCIA INCREMENTAL POR NIVEL SEGÚN SCRIPT DE LA WEB ---
    $tabla_exp_incremental = [
        1 => 300,
        2 => 450,
        3 => 675,
        4 => 1012,
        5 => 1518,
        6 => 2277,
        7 => 3416,
        8 => 5124,
        9 => 7686,
        10 => 11529,
        11 => 17294,
        12 => 25941,
        13 => 38912,
        14 => 58368,
        15 => 75878,
        16 => 98641,
        17 => 128233,
        18 => 166703,
        19 => 216714,
        20 => 281728,
        21 => 366246,
        22 => 476120,
        23 => 618956,
        24 => 804643,
        25 => 1005804,
        26 => 1257255,
        27 => 1571569,
        28 => 1964461,
        29 => 2455576,
        30 => 3069470,
        31 => 3836837,
        32 => 4796046,
        33 => 5995057,
        34 => 7493821,
        35 => 9367276,
        36 => 11709095,
        37 => 14636369,
        38 => 18295461,
        39 => 22869326,
        40 => 27443191,
        41 => 32931829,
        42 => 39518195,
        43 => 47421834,
        44 => 56906201,
        45 => 68287441,
        46 => 81944929,
        47 => 98333915,
        48 => 118000698,
        49 => 141600837,
        50 => 155760921,
        51 => 171337013,
        52 => 188470714,
        53 => 207317786,
        54 => 228049565,
        55 => 250854521,
        56 => 376281782,
    ];
    function expIncrementalAOMania($nivel) {
        global $tabla_exp_incremental;
        return $tabla_exp_incremental[$nivel] ?? 0;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nivel_actual'], $_POST['criatura'], $_POST['exp_actual'])) {
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
        echo '<div id="resultado-criatura" class="boxresult_vida text-center mt-4" style="margin-top:40px !important; opacity:0;">';
        echo '<div class="result_vida-title"><i class="fas fa-dragon"></i> Resultado de la Calculadora</div>';
        echo '<div class="result_vida-item min"><span><i class="fas fa-skull-crossbones"></i> Debes matar:</span> <span style="font-size:1.3em;color:#ffd900">'. $cantidad .' <span style="color:#43e97b">'. htmlspecialchars($criatura) . ($cantidad == 1 ? '' : 's') .'</span></span></div>';
        echo '<div class="result_vida-item average"><span><i class="fas fa-bolt"></i> EXP obtenida:</span> <span style="font-size:1.3em">'. number_format($exp_total) .'</span></div>';
        echo '<div class="result_vida-item max"><span><i class="fas fa-level-up-alt"></i> EXP necesaria:</span> <span style="font-size:1.3em">'. number_format($exp_necesaria) .'</span></div>';
        echo '<div class="result_vida-item" style="background:#222;">';
        echo '<span><i class="fas fa-star"></i> Subirás al nivel:</span> <span style="font-size:1.2em;color:#ffd900"><b>'. $nivel_siguiente .'</b></span>';
        echo '</div>';
        echo '<div class="result_vida-item" style="background:#222;">';
        echo '<span><i class="fas fa-chart-bar"></i> Experiencia acumulada hasta el nivel '. $nivel_siguiente .':</span> <span style="font-size:1.1em">'. number_format($exp_acumulada_siguiente) .'</span>';
        echo '</div>';
        // Barra de progreso real
        echo '<div style="width:100%;margin:10px 0 0 0;">';
        echo '<div style="background:#444;border-radius:8px;width:100%;height:18px;overflow:hidden;">';
        echo '<div id="barra-progreso-exp" style="background:#43e97b;height:100%;width:0%;transition:width 1s;" data-width="'.$progreso.'"></div>';
        echo '</div>';
        echo '<span style="font-size:0.95em;opacity:0.8;">Progreso hacia el siguiente nivel: <span id="progreso-texto">'.number_format(min($exp_actual_usuario, $exp_necesaria)).'</span> / '.number_format($exp_necesaria).' EXP</span>';
        echo '</div>';
        echo '<button id="limpiar-criatura" class="btn btn-secondary btn-sm mt-2" type="button"><i class="fas fa-eraser"></i> Limpiar</button>';
        echo '</div>';
    }
    ?>
    <form method="post" class="needs-validation" id="form-criatura">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div style="max-width:340px;margin:18px auto 0 auto;">
            <div class="mb-2 row align-items-center">
                <label for="criatura" class="col-7 col-form-label" style="font-weight:500;"><i class="fas fa-paw" style="color:#43e97b;"></i> Criatura (NPC)</label>
                <select name="criatura" id="criatura" class="form-control col-5" required>
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
            <div class="mb-2 row align-items-center">
                <label for="nivel_actual" class="col-7 col-form-label" style="font-weight:500;"><i class="fas fa-level-up-alt" style="color:#ffd900;"></i> Nivel actual</label>
                <select class="form-control col-5" name="nivel_actual" id="nivel_actual" required>
<?php
for ($i = 1; $i <= 56; $i++) {
    $sel = (isset($_POST['nivel_actual']) && (int)$_POST['nivel_actual'] == $i) ? 'selected' : '';
    echo "<option value='$i' $sel>$i</option>";
}
?>
                </select>
            </div>
            <div class="mb-2 row align-items-center">
                <label for="exp_actual" class="col-7 col-form-label" style="font-weight:500;"><i class="fas fa-tachometer-alt" style="color:#ff9800;"></i> EXP actual</label>
                <input type="number" class="form-control col-5" name="exp_actual" id="exp_actual" min="0" value="<?php echo isset($_POST['exp_actual']) ? (int)$_POST['exp_actual'] : 0; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary btn-sm w-100 mt-2"><i class="fas fa-calculator"></i> Calcular</button>
        </div>
    </form>
    <div class="text-center mt-3" style="opacity:0.75;font-size:0.9em;">
        <i class="fas fa-info-circle"></i> Todos los campos son obligatorios
    </div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var resultado = document.getElementById('resultado-criatura');
    if(resultado) {
        // Animación fadeIn
        setTimeout(function() {
            resultado.style.opacity = 1;
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
            resultado.style.opacity = 0;
            setTimeout(function() {
                resultado.style.display = 'none';
            }, 700);
        });
    }
});
</script>
<style>
.boxresult_vida {
    margin-top: 40px !important;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    background-color: #2E2E2E;
    color: white;
    font-weight: 600;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}
.result_vida-title {
    font-size: 18px;
    margin-bottom: 10px;
    color: white;
}
.result_vida-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    margin-bottom: 5px;
    border-radius: 3px;
}
.result_vida-item span {
    font-weight: bold;
}
.result_vida-item.max {
    background-color: #06D606;
    color: #222;
}
.result_vida-item.min {
    background-color: #E42F2F;
}
.result_vida-item.average {
    background-color: #149EE3;
}
.result_vida-item {
    margin-bottom: 6px;
}
</style>
