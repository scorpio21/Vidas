<?php
// =============================================
// Calculadora de Domar para AOMania
// Permite calcular probabilidades y requisitos para domar criaturas
// =============================================
?>

<?php include 'csrf_token.php'; ?>
<?php
// Incluye funciones y define clases válidas ANTES de procesar el formulario
include_once 'src/functions.php';
$clasesValidas = getClasesValidas();
$criaturasDomables = require __DIR__ . '/src/criaturas_domables.php';
$resultado = '';
$errores = [];
$valores = [
    'clase' => isset($_POST['clase']) ? $_POST['clase'] : '',
    'carisma' => isset($_POST['carisma']) ? $_POST['carisma'] : '',
    'criatura' => isset($_POST['criatura']) ? $_POST['criatura'] : '',
];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generar'])) {
    // Verificación del token CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Token CSRF inválido.');
    }
    // Recoger datos del formulario
    $clase = strtoupper(htmlspecialchars($valores['clase']));
    $carisma = intval($valores['carisma']);
    $criatura = htmlspecialchars($valores['criatura']);
    // Validación de los datos del formulario
    if ($clase == '' || !isset($clasesValidas[$clase])) {
        $errores[] = 'Selecciona una clase válida.';
    }
    if ($carisma < 1 || $carisma > 100) {
        $errores[] = 'La carisma debe estar entre 1 y 100.';
    }
    if ($criatura == '') {
        $errores[] = 'El campo criatura es obligatorio.';
    }
    // Cálculo de la probabilidad de domar
    if (empty($errores)) {
        $skillNecesario = calcularSkillDomar($clase, $carisma);
        $nombreClase = $clasesValidas[$clase];
        $resultado = "<div class='alert alert-info mt-3 animated fadeIn'><i class='fas fa-magic'></i> El skill necesario para domar un/a <b>$criatura</b> con un pj <b>$nombreClase</b> con <b>$carisma</b> de Carisma será de: <b>$skillNecesario</b> <b>Skill Calculado</b></div>";
    }
}
?>
<!--
    Encabezado principal de la página de domar
    Muestra el título y el logo de la calculadora de domar
-->
<header class="main-header text-center mb-4">
    <h1 id="domar-title"><i class="fas fa-dragon"></i> Domar</h1>
</header>
<?php if (!empty($resultado)): ?>
    <div class="domar-resultado-wrapper text-center mb-3 animated fadeIn">
        <?php echo $resultado; ?>
    </div>
<?php endif; ?>
<!--
    Sección principal de la página de domar
    Contiene el formulario y los resultados de la calculadora de domar
-->
<main role="main" aria-labelledby="domar-title">
    <!--
        Formulario para introducir los datos de cálculo de domar
        Contiene los campos para seleccionar la clase, carisma y criatura
    -->
    <form method="post" action="index.php?page=domar" class="needs-validation" id="form-domar">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <!-- Selector de clase -->
        <div class="flex-clase mb-3">
            <label for="clase" class="form-label mb-0 label-clase"><i class="fas fa-hat-wizard icon-clase"></i> Clase</label>
            <select name="clase" id="clase" class="form-control select-clase" required>
                <option value="">--Selecciona--</option>
                <?php foreach ($clasesValidas as $key => $label): ?>
                    <option value="<?php echo $key; ?>" <?php if(strtoupper($valores['clase']) === $key) echo 'selected'; ?>><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Selector de carisma -->
        <div class="form-domar-container">
            <div class="mb-2 row align-items-center">
                <label for="carisma" class="col-7 col-form-label label-carisma"><i class="fas fa-star icon-carisma"></i> Carisma</label>
                <input type="number" name="carisma" id="carisma" class="form-control col-5" min="1" max="100" value="<?php echo htmlspecialchars($valores['carisma']); ?>" required aria-required="true">
            </div>
            <!-- Selector de criatura -->
            <div class="mb-2 row align-items-center">
                <label for="criatura" class="col-7 col-form-label label-criatura" style="color:#333;"><i class="fas fa-dragon icon-criatura"></i> Criatura</label>
                <div class="col-5">
                    <select name="criatura" id="criatura" class="form-control" required aria-required="true" style="width:100%; max-width:200px; min-width:120px;">
                        <option value="">--Selecciona--</option>
                        <?php foreach ($criaturasDomables as $criatura): ?>
                            <option value="<?php echo htmlspecialchars($criatura['nombre']); ?>"
                                data-habilidad="<?php echo htmlspecialchars($criatura['habilidad']); ?>"
                                data-imagen="<?php echo htmlspecialchars($criatura['imagen']); ?>"
                                data-html="<img src='imagen/<?php echo htmlspecialchars($criatura['imagen']); ?>' class='criatura-option-img'/> <?php echo htmlspecialchars($criatura['nombre']); ?>"
                                <?php if($valores['criatura'] === $criatura['nombre']) echo 'selected'; ?>>
                                <?php echo $criatura['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row" id="info-criatura-domar" style="display:none;">
                <div class="col-12 text-center" id="img-criatura-domar" style="margin-bottom:4px;"></div>
                <div class="col-12 text-center" id="habilidad-criatura-domar" style="font-size:0.98em;"></div>
            </div>
            <!-- Botón para generar el cálculo de domar -->
            <button type="submit" name="generar" class="btn btn-primary btn-sm w-100 mt-2"><i class="fas fa-calculator"></i> Generar</button>
            <!-- Enlace para volver al menú principal -->
            <a href="index.php" class="btn btn-secondary btn-sm w-100 mt-2 enlace-nowrap"><i class="fas fa-arrow-left"></i> Volver al menú principal</a>
        </div>
        <!-- Mensaje informativo sobre la obligatoriedad de los campos -->
        <div class="text-center mt-3 texto-opaco">
            <i class="fas fa-info-circle"></i> Todos los campos son obligatorios
        </div>
    </form>
    <!--
        Sección para mostrar los errores y resultados del cálculo de domar
        Muestra los errores y resultados en forma de alertas
    -->
    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger mt-3 animated shake">
            <?php foreach ($errores as $err) echo "<div><i class='fas fa-exclamation-triangle'></i> $err</div>"; ?>
        </div>
    <?php endif; ?>
    <!-- INICIO: Bloque único y ordenado para Select2 con imágenes -->
    <style>
    .select2-results__option .criatura-option-img {
      width: 28px;
      height: 28px;
      vertical-align: middle;
      margin-right: 10px;
      border-radius: 4px;
    }
    .select2-selection__rendered .criatura-option-img {
      width: 22px;
      height: 22px;
      vertical-align: middle;
      margin-right: 7px;
      border-radius: 3px;
    }
    </style>
    <script>
    function formatCriatura (state) {
      if (!state.id) return state.text;
      var img = $(state.element).data('imagen');
      var label = state.text;
      if (img) {
        return $('<span><img src="imagen/' + img + '" class="criatura-option-img"/> ' + label + '</span>');
      }
      return state.text;
    }
    document.addEventListener('DOMContentLoaded', function() {
      if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
        $('#criatura').select2({
          templateResult: formatCriatura,
          templateSelection: formatCriatura,
          width: 'resolve', // Forzar a usar el ancho real del select
          dropdownAutoWidth: true
        });
        $('#criatura').on('change', mostrarInfoCriatura);
        mostrarInfoCriatura();
      } else {
        // Si jQuery o Select2 no están disponibles, solo muestra la info básica
        document.getElementById('criatura').addEventListener('change', mostrarInfoCriatura);
        mostrarInfoCriatura();
      }
    });
    </script>
    <!-- FIN: Bloque único y ordenado para Select2 con imágenes -->
    <script>
    function mostrarInfoCriatura() {
        var select = document.getElementById('criatura');
        var infoDiv = document.getElementById('info-criatura-domar');
        var imgDiv = document.getElementById('img-criatura-domar');
        var habilidadDiv = document.getElementById('habilidad-criatura-domar');
        var selected = select.options[select.selectedIndex];
        var habilidad = selected.getAttribute('data-habilidad');
        var imagen = selected.getAttribute('data-imagen');
        if (selected.value && habilidad && imagen) {
            imgDiv.innerHTML = '<img src="imagen/' + imagen + '" alt="' + selected.value + '" style="max-width:40px;max-height:40px;">';
            habilidadDiv.innerHTML = '<b>Habilidad:</b> ' + habilidad;
            infoDiv.style.display = '';
        } else {
            imgDiv.innerHTML = '';
            habilidadDiv.innerHTML = '';
            infoDiv.style.display = 'none';
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        mostrarInfoCriatura();
        document.getElementById('criatura').addEventListener('change', mostrarInfoCriatura);
    });
    document.addEventListener('DOMContentLoaded', function() {
        var error = document.querySelector('.alert-danger');
        if(error) {
            var input = document.querySelector('.is-invalid, .alert-danger ~ form input, .alert-danger ~ form select');
            if(input) input.focus();
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('form-domar');
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
</main>