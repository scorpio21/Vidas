<?php
// =============================================
// Listado de Modificadores de Clase para AOMania
// Muestra los modificadores de todas las clases en formato de lista
// =============================================
// Página: Lista y gestión de Modificadores de clase
include 'csrf_token.php';
include_once 'src/functions.php';

// --- Modificadores por clase (tabla fija) ---
// Esta función devuelve un arreglo asociativo con los modificadores de clase
function getModificadoresPorClase() {
    // Ahora se carga desde modificadores_tabla.php para mejor mantenimiento
    return require __DIR__ . '/modificadores_tabla.php';
}
?>

<!-- Contenedor principal de la página -->
<div class="container mt-5">
    <!-- Encabezado principal de la página de lista de modificadores -->
    <header class="text-center mb-4">
        <h2><i class="fas fa-list"></i> Modificadores por Clase</h2>
        <p class="lead">Consulta los modificadores fijos para cada clase.</p>
    </header>
    <main>
        <!-- Tarjeta principal que contiene el contenido de la página -->
        <div class="card shadow-lg p-4 mb-4 bg-light card-480" style="margin: 0 auto; border-radius: 16px;">
            <!-- Botón volver al menú principal -->
            <div class="texto-centro-mb" style="margin-bottom:16px;">
              <a href="index.php" class="btn-volver-menu">Volver al menú principal</a>
            </div>
            <!-- Formulario para seleccionar la clase -->
            <form method="get" autocomplete="off" novalidate>
                <div class="mb-2">
                    <label for="clase" class="form-label">Clase</label>
                    <select name="clase" id="clase" class="form-control" required onchange="this.form.submit()">
                        <option value="">--Selecciona--</option>
                        <?php foreach (getClasesValidas() as $key=>$nombre): ?>
                            <option value="<?=$key?>" <?=((isset($_GET['clase']) && $_GET['clase']===$key)?'selected':'')?>><?=$nombre?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
            <?php
            // Obtener los modificadores de la clase seleccionada
            $modificadoresClase = [];
            if (!empty($_GET['clase'])) {
                $mods = getModificadoresPorClase();
                $claseSel = strtoupper($_GET['clase']);
                if (isset($mods[$claseSel])) {
                    $modificadoresClase = $mods[$claseSel];
                }
            }
            ?>
            <?php if (!empty($modificadoresClase)): ?>
            <!-- Formulario para mostrar los modificadores de la clase seleccionada -->
            <form class="mt-3 form-bg-blur" autocomplete="off">
                <?php foreach($modificadoresClase as $nombre=>$valor): ?>
                <div class="mb-2 row align-items-center">
                    <label class="col-7 col-form-label label-bold"><?=htmlspecialchars($nombre)?></label>
                    <input type="text" class="form-control col-5" readonly value="<?=htmlspecialchars($valor)?>">
                </div>
                <?php endforeach; ?>
            </form>
            <?php elseif (isset($_GET['clase'])): ?>
                <!-- Mensaje de advertencia si no hay modificadores para la clase seleccionada -->
                <div class="alert alert-warning mt-3">No hay modificadores definidos para esta clase.</div>
            <?php endif; ?>
        </div>
        <!-- Enlace para volver a la página anterior -->
        <div class="text-center mt-3">
            <a href="index.php?page=modificadores" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
        </div>
    </main>
</div>
<!-- Script para funcionalidades adicionales de la página -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
