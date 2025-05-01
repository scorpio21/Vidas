<?php
// =============================================
// API de Modificadores para AOMania
// Devuelve los modificadores de una clase en formato HTML para AJAX
// =============================================
// Incluir archivo de funciones
include_once 'src/functions.php';

// Establecer tipo de contenido de la respuesta
header('Content-Type: text/html; charset=utf-8');

// =============================================
// Función para obtener modificadores por clase
// =============================================
function getModificadoresPorClase() {
    // Definir modificadores por clase
    return [
        'GUERRERO' => [
            'Evasión' => 1,
            'Poder arma' => 1,
            'Poder proyectil' => 0.85,
            'Daño arma' => 1.1,
            'Daño proyectil' => 0.9,
            'Evasión escudo' => 1,
            'Poder wrestling' => 0.6,
            'Daño wrestling' => 0.4
        ],
        'PALADIN' => [
            'Evasión' => 0.8,
            'Poder arma' => 0.9,
            'Poder proyectil' => 0.8,
            'Daño arma' => 0.85,
            'Daño proyectil' => 0.8,
            'Evasión escudo' => 0.9,
            'Poder wrestling' => 0.4,
            'Daño wrestling' => 0.4
        ],
        'TRABAJADOR' => [
            'Evasión' => 0.8,
            'Poder arma' => 0.8,
            'Poder proyectil' => 0.5,
            'Daño arma' => 0.5,
            'Daño proyectil' => 0.5,
            'Evasión escudo' => 0.7,
            'Poder wrestling' => 0.5,
            'Daño wrestling' => 0.4
        ],
        'ASESINO' => [
            'Evasión' => 1,
            'Poder arma' => 0.8,
            'Poder proyectil' => 0.75,
            'Daño arma' => 0.85,
            'Daño proyectil' => 0.75,
            'Evasión escudo' => 0.8,
            'Poder wrestling' => 0.4,
            'Daño wrestling' => 0.4
        ],
        'LADRON' => [
            'Evasión' => 0.95,
            'Poder arma' => 0.75,
            'Poder proyectil' => 0.7,
            'Daño arma' => 0.75,
            'Daño proyectil' => 0.7,
            'Evasión escudo' => 0.7,
            'Poder wrestling' => 0.8,
            'Daño wrestling' => 1.05
        ],
        'BARDO' => [
            'Evasión' => 0.75,
            'Poder arma' => 0.7,
            'Poder proyectil' => 0.7,
            'Daño arma' => 0.75,
            'Daño proyectil' => 0.7,
            'Evasión escudo' => 0.75,
            'Poder wrestling' => 0.4,
            'Daño wrestling' => 0.4
        ],
        'PIRATA' => [
            'Evasión' => 0.8,
            'Poder arma' => 0.8,
            'Poder proyectil' => 0.75,
            'Daño arma' => 0.85,
            'Daño proyectil' => 0.75,
            'Evasión escudo' => 0.75,
            'Poder wrestling' => 0.5,
            'Daño wrestling' => 0.4
        ],
        'CLERIGO' => [
            'Evasión' => 0.8,
            'Poder arma' => 0.8,
            'Poder proyectil' => 0.7,
            'Daño arma' => 0.75,
            'Daño proyectil' => 0.7,
            'Evasión escudo' => 0.9,
            'Poder wrestling' => 0.4,
            'Daño wrestling' => 0.4
        ],
        'DRUIDA' => [
            'Evasión' => 0.5,
            'Poder arma' => 0.75,
            'Poder proyectil' => 0.7,
            'Daño arma' => 0.75,
            'Daño proyectil' => 0.7,
            'Evasión escudo' => 0.6,
            'Poder wrestling' => 0.4,
            'Daño wrestling' => 0.4
        ],
        'ARQUERO' => [
            'Evasión' => 0.8,
            'Poder arma' => 0.5,
            'Poder proyectil' => 1.2,
            'Daño arma' => 0.75,
            'Daño proyectil' => 1.6,
            'Evasión escudo' => 0.75,
            'Poder wrestling' => 0.2,
            'Daño wrestling' => 0.6
        ],
        'MAGO' => [
            'Evasión' => 0.5,
            'Poder arma' => 0.5,
            'Poder proyectil' => 0.6,
            'Daño arma' => 0.6,
            'Daño proyectil' => 0.6,
            'Evasión escudo' => 0.6,
            'Poder wrestling' => 0.3,
            'Daño wrestling' => 0.5
        ],
        'BRUJO' => [
            'Evasión' => 0.5,
            'Poder arma' => 0.5,
            'Poder proyectil' => 0.6,
            'Daño arma' => 0.6,
            'Daño proyectil' => 0.6,
            'Evasión escudo' => 0.6,
            'Poder wrestling' => 0.3,
            'Daño wrestling' => 0.5
        ],
        'BANDIDO' => [
            'Evasión' => 0.9,
            'Poder arma' => 0.5,
            'Poder proyectil' => 0.5,
            'Daño arma' => 0.5,
            'Daño proyectil' => 0.5,
            'Evasión escudo' => 0.7,
            'Poder wrestling' => 0.95,
            'Daño wrestling' => 1.05
        ]
    ];
}

// =============================================
// Obtener clase desde GET o POST
// =============================================
$clase = isset($_GET['clase']) ? strtoupper($_GET['clase']) : '';
$modificadoresClase = [];
if ($clase) {
    // Obtener modificadores de la clase seleccionada
    $mods = getModificadoresPorClase();
    if (isset($mods[$clase])) {
        $modificadoresClase = $mods[$clase];
    }
}

// =============================================
// Mostrar selector de clase
// =============================================
// Mostrar solo el selector de clase, sin form ni div extra
$clases = getClasesValidas();
echo '<div class="flex-clase mb-3">';
echo '<label for="clase" class="form-label mb-0">Clase</label>';
echo '<select name="clase" id="clase" class="form-control select-clase" required>';
echo '<option value="">--Selecciona--</option>';
foreach ($clases as $key=>$nombre) {
    $selected = ($key === $clase) ? ' selected' : '';
    echo '<option value="'.$key.'"'.$selected.'>'.$nombre.'</option>';
}
echo '</select>';
echo '<a href="index.php" class="btn btn-secondary btn-sm enlace-nowrap"><i class="fas fa-arrow-left"></i> Volver al menú principal</a>';
echo '</div>';

// =============================================
// Mostrar modificadores o mensaje
// =============================================
if ($clase && !empty($modificadoresClase)) {
    // Contenedor para alinear los modificadores debajo del selector
    echo '<div class="form-modificadores-container">';
    foreach($modificadoresClase as $nombre=>$valor) {
        echo '<div class="mb-2 row align-items-center">';
        echo '<label class="col-7 col-form-label label-bold">'.htmlspecialchars($nombre).'</label>';
        echo '<input type="text" class="form-control col-5" readonly value="'.htmlspecialchars($valor).'">';
        echo '</div>';
    }
    echo '</div>';
} else if ($clase) {
    echo '<div class="alert alert-warning mt-3">No hay modificadores definidos para esta clase.</div>';
}
