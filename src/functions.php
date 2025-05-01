<?php
// =============================================
// Funciones auxiliares para la Calculadora AOMania
// Incluye utilidades para clases, modificadores, vida, maná, domar, etc.
// =============================================

// ===================
// Clases y modificadores
// ===================
/**
 * Devuelve un array asociativo de clases válidas
 * @return array
 */
function getClasesValidas() {
    // Centralización de las clases válidas
    return [
        'MAGO' => 'Mago',
        'CLERIGO' => 'Clerigo',
        'GUERRERO' => 'Guerrero',
        'ASESINO' => 'Asesino',
        'LADRON' => 'Ladron',
        'BARDO' => 'Bardo',
        'DRUIDA' => 'Druida',
        'TRABAJADOR' => 'Trabajador',
        'PALADIN' => 'Paladin',
        'PIRATA' => 'Pirata',
        'BRUJO' => 'Brujo',
        'ARQUERO' => 'Arquero',
        'BANDIDO' => 'Bandido',
    ];
}

// ===================
// Vida y maná
// ===================
/**
 * Calcula la vida máxima y mínima según clase, constitución y nivel
 * @param string $clase
 * @param int $constitucion
 * @param int $nivel
 * @return array|null
 */
function calcularVida($clase, $constitucion, $nivel) {
    // Calcula la vida máxima y mínima según clase, constitución y nivel
    $clase = strtoupper($clase);
    $constitucion = intval($constitucion);
    $nivel = intval($nivel);

    if ($clase === "" || $constitucion === 0 || $nivel < 1 || $nivel > 299) {
        return null;
    }

    $minimoHP = 16;
    $maximoHP = 15 + intdiv($constitucion, 3);

    $AumentoMinHP = 4;
    $AumentoMaxHP = intdiv($constitucion, 2);

    // Calcula el aumento de vida según clase y constitución
    switch ($clase) {
        case "GUERRERO":
            switch ($constitucion) {
                case 21: $AumentoMinHP = 9; $AumentoMaxHP = 12; break;
                case 20: $AumentoMinHP = 9; $AumentoMaxHP = 11; break;
                case 19: $AumentoMinHP = 8; $AumentoMaxHP = 11; break;
                case 18: $AumentoMinHP = 8; $AumentoMaxHP = 10; break;
                case 17: $AumentoMinHP = 7; $AumentoMaxHP = 9; break;
                default: $AumentoMinHP = 6; $AumentoMaxHP = 9; break;
            }
            break;
        case "ARQUERO":
            switch ($constitucion) {
                case 21: $AumentoMinHP = 9; $AumentoMaxHP = 11; break;
                case 20: $AumentoMinHP = 8; $AumentoMaxHP = 11; break;
                case 19: $AumentoMinHP = 8; $AumentoMaxHP = 10; break;
                case 18: $AumentoMinHP = 7; $AumentoMaxHP = 10; break;
                case 17: $AumentoMinHP = 6; $AumentoMaxHP = 9; break;
                default: $AumentoMinHP = 5; $AumentoMaxHP = 9; break;
            }
            break;
        case "PALADIN":
            switch ($constitucion) {
                case 21: $AumentoMinHP = 9; $AumentoMaxHP = 11; break;
                case 20: $AumentoMinHP = 8; $AumentoMaxHP = 11; break;
                case 19: $AumentoMinHP = 8; $AumentoMaxHP = 10; break;
                case 18: $AumentoMinHP = 7; $AumentoMaxHP = 10; break;
                case 17: $AumentoMinHP = 6; $AumentoMaxHP = 9; break;
                default: $AumentoMinHP = 5; $AumentoMaxHP = 9; break;
            }
            break;
        case "LADRON":
            switch ($constitucion) {
                case 21: $AumentoMinHP = 9; $AumentoMaxHP = 11; break;
                case 20: $AumentoMinHP = 8; $AumentoMaxHP = 11; break;
                case 19: $AumentoMinHP = 8; $AumentoMaxHP = 10; break;
                case 18: $AumentoMinHP = 7; $AumentoMaxHP = 10; break;
                case 17: $AumentoMinHP = 6; $AumentoMaxHP = 9; break;
                default: $AumentoMinHP = 5; $AumentoMaxHP = 9; break;
            }
            break;
        case "BRUJO":
        case "MAGO":
            switch ($constitucion) {
                case 21: $AumentoMinHP = 6; $AumentoMaxHP = 9; break;
                case 20: $AumentoMinHP = 6; $AumentoMaxHP = 8; break;
                case 19: $AumentoMinHP = 5; $AumentoMaxHP = 8; break;
                case 18: $AumentoMinHP = 5; $AumentoMaxHP = 7; break;
                case 17: $AumentoMinHP = 4; $AumentoMaxHP = 7; break;
                default: $AumentoMinHP = 4; $AumentoMaxHP = 6; break;
            }
            break;
        case "CLERIGO":
            switch ($constitucion) {
                case 21: $AumentoMinHP = 7; $AumentoMaxHP = 10; break;
                case 20: $AumentoMinHP = 7; $AumentoMaxHP = 9; break;
                case 19: $AumentoMinHP = 7; $AumentoMaxHP = 8; break;
                case 18: $AumentoMinHP = 6; $AumentoMaxHP = 8; break;
                case 17: $AumentoMinHP = 5; $AumentoMaxHP = 8; break;
                default: $AumentoMinHP = 4; $AumentoMaxHP = 7; break;
            }
            break;
        case "DRUIDA":
            switch ($constitucion) {
                case 21: $AumentoMinHP = 6; $AumentoMaxHP = 9; break;
                case 20: $AumentoMinHP = 6; $AumentoMaxHP = 8; break;
                case 19: $AumentoMinHP = 5; $AumentoMaxHP = 8; break;
                case 18: $AumentoMinHP = 5; $AumentoMaxHP = 7; break;
                case 17: $AumentoMinHP = 4; $AumentoMaxHP = 7; break;
                default: $AumentoMinHP = 4; $AumentoMaxHP = 6; break;
            }
            break;
        case "ASESINO":
            switch ($constitucion) {
                case 21: $AumentoMinHP = 7; $AumentoMaxHP = 10; break;
                case 20: $AumentoMinHP = 7; $AumentoMaxHP = 9; break;
                case 19: $AumentoMinHP = 7; $AumentoMaxHP = 8; break;
                case 18: $AumentoMinHP = 6; $AumentoMaxHP = 8; break;
                case 17: $AumentoMinHP = 5; $AumentoMaxHP = 8; break;
                default: $AumentoMinHP = 4; $AumentoMaxHP = 7; break;
            }
            break;
        case "PIRATA":
            switch ($constitucion) {
                case 21: $AumentoMinHP = 9; $AumentoMaxHP = 12; break;
                case 20: $AumentoMinHP = 9; $AumentoMaxHP = 11; break;
                case 19: $AumentoMinHP = 8; $AumentoMaxHP = 10; break;
                case 18: $AumentoMinHP = 7; $AumentoMaxHP = 10; break;
                case 17: $AumentoMinHP = 6; $AumentoMaxHP = 9; break;
                default: $AumentoMinHP = 5; $AumentoMaxHP = 9; break;
            }
            break;
        case "BARDO":
            switch ($constitucion) {
                case 21: $AumentoMinHP = 7; $AumentoMaxHP = 10; break;
                case 20: $AumentoMinHP = 7; $AumentoMaxHP = 9; break;
                case 19: $AumentoMinHP = 7; $AumentoMaxHP = 8; break;
                case 18: $AumentoMinHP = 6; $AumentoMaxHP = 8; break;
                case 17: $AumentoMinHP = 5; $AumentoMaxHP = 8; break;
                default: $AumentoMinHP = 4; $AumentoMaxHP = 7; break;
            }
            break;
        case "TRABAJADOR":
            $AumentoMinHP = 4;
            $AumentoMaxHP = intdiv($constitucion, 2);
            break;
        default:
            $AumentoMinHP = 4;
            $AumentoMaxHP = intdiv($constitucion, 2);
            break;
    }

    // Calcula la vida máxima y mínima según nivel
    $minimoHP = $minimoHP + $AumentoMinHP * ($nivel - 1);
    $maximoHP = $maximoHP + $AumentoMaxHP * ($nivel - 1);

    // Calcula la vida media y el aumento medio
    $medioHP = intdiv($maximoHP + $minimoHP, 2);
    $incMedio = intdiv($AumentoMaxHP + $AumentoMinHP, 2);

    return [
        'minimoHP' => $minimoHP,
        'maximoHP' => $maximoHP,
        'medioHP'  => $medioHP,
        'aumentoMinHP' => $AumentoMinHP,
        'aumentoMaxHP' => $AumentoMaxHP,
        'aumentoMedio' => $incMedio
    ];
}

/**
 * Calcula el maná máximo y mínimo según clase, inteligencia y nivel
 * @param string $clase
 * @param int $inteligencia
 * @param int $nivel
 * @return array|null
 */
function calcularMana($clase, $inteligencia, $nivel)
{
    // Calcula el maná máximo y mínimo según clase, inteligencia y nivel
    $maxMana = 0;
    $minMana = 0;
    $incrementoMana = 0;
    $clase = strtoupper($clase);

    // Calculo base según clase (Visual Basic 6.0 logic)
    if ($clase === 'MAGO' || $clase === 'BRUJO') {
        $maxMana = 100 + intdiv($inteligencia, 3);
        $minMana = 101;
    } elseif (
        $clase === 'CLERIGO' || $clase === 'DRUIDA' || $clase === 'BARDO' ||
        $clase === 'ASESINO' || $clase === 'GLADIADOR MAGICO'
    ) {
        $minMana = 50;
        $maxMana = 50;
    } else {
        $minMana = 0;
        $maxMana = 0;
    }

    // IncrementoMana según clase
    switch ($clase) {
        case 'MAGO':
            $incrementoMana = $inteligencia * 3;
            break;
        case 'BRUJO':
            $incrementoMana = $inteligencia * 2.7;
            break;
        case 'CLERIGO':
        case 'DRUIDA':
        case 'BARDO':
            $incrementoMana = $inteligencia * 2;
            break;
        case 'PALADIN':
        case 'ASESINO':
            $incrementoMana = $inteligencia;
            break;
        default:
            $incrementoMana = 0;
    }

    // Cálculo final de mana según clase y nivel
    if ($clase === 'PALADIN' || $clase === 'ASESINO') {
        if ($nivel >= 2) {
            $minMana = $minMana + $inteligencia * ($nivel - 1);
            $maxMana = $maxMana + $inteligencia * ($nivel - 1);
        }
    }
    if (
        $clase === 'BRUJO' || $clase === 'CLERIGO' || $clase === 'DRUIDA' ||
        $clase === 'BARDO' || $clase === 'MAGO'
    ) {
        $minMana = $minMana + $incrementoMana * ($nivel - 1);
        $maxMana = $maxMana + $incrementoMana * ($nivel - 1);
    }

    return ['minMana' => $minMana, 'maxMana' => $maxMana, 'incrementoMana' => $incrementoMana];
}

// ===================
// Domar
// ===================
/**
 * Calcula el skill necesario para domar según clase y carisma
 * @param string $clase
 * @param int $carisma
 * @return int
 */
function calcularSkillDomar($clase, $carisma)
{
    // Calcula el skill necesario para domar según clase y carisma
    $skillBase = 50;
    $factorClase = 1.0;

    switch ($clase) {
        case 'MAGO':
            $factorClase = 1.2;
            break;
        case 'BRUJO':
            $factorClase = 1.1;
            break;
        case 'CLERIGO':
        case 'DRUIDA':
            $factorClase = 1.5;
            break;
        case 'BARDO':
            $factorClase = 1.3;
            break;
        case 'ASESINO':
            $factorClase = 1.4;
            break;
        case 'GUERRERO':
            $factorClase = 1.0;
            break;
        case 'PALADIN':
            $factorClase = 1.2;
            break;
        case 'PIRATA':
            $factorClase = 1.1;
            break;
        case 'ARQUERO':
            $factorClase = 1.0;
            break;
        case 'BANDIDO':
            $factorClase = 1.1;
            break;
        case 'LADRON':
            $factorClase = 1.2;
            break;
        case 'TRABAJADOR':
            $factorClase = 0.9;
            break;
        default:
            $factorClase = 1.0;
    }

    $skillNecesario = $skillBase + ($carisma * $factorClase);

    if ($skillNecesario > 100) {
        $skillNecesario = 100;
    }

    return $skillNecesario;
}

// ===================
// Utilidades varias
// ===================
/**
 * Devuelve la vida máxima absoluta para una clase
 * @param string $clase
 * @return int
 */
function vidaMaximaAbsoluta($clase) {
    // Calcula la vida máxima absoluta real para una clase
    $resultado = calcularVida($clase, 21, 299);
    return $resultado ? $resultado['maximoHP'] : 0;
}

// Aquí puedes añadir más funciones auxiliares según crezca el proyecto