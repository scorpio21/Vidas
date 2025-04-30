<?php
// Página: Lista y gestión de Modificadores de clase
include 'csrf_token.php';
include_once 'src/functions.php';

// --- Modificadores por clase (tabla fija) ---
function getModificadoresPorClase() {
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
?>

<div class="container mt-5">
    <header class="text-center mb-4">
        <h2><i class="fas fa-list"></i> Modificadores por Clase</h2>
        <p class="lead">Consulta los modificadores fijos para cada clase.</p>
    </header>
    <main>
        <div class="card shadow-lg p-4 mb-4 bg-light" style="max-width: 480px; margin: 0 auto; border-radius: 16px;">
            <!-- Botón volver al menú principal -->
            <div style="width:100%;text-align:center;margin-bottom:16px;">
              <a href="index.php" class="btn-volver-menu">Volver al menú principal</a>
            </div>
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
            <form class="mt-3" autocomplete="off" style="background:rgba(255,255,255,0.05);padding:14px 8px;border-radius:10px;">
                <?php foreach($modificadoresClase as $nombre=>$valor): ?>
                <div class="mb-2 row align-items-center">
                    <label class="col-7 col-form-label" style="font-weight:500;"><?=htmlspecialchars($nombre)?></label>
                    <input type="text" class="form-control col-5" readonly value="<?=htmlspecialchars($valor)?>">
                </div>
                <?php endforeach; ?>
            </form>
            <?php elseif (isset($_GET['clase'])): ?>
                <div class="alert alert-warning mt-3">No hay modificadores definidos para esta clase.</div>
            <?php endif; ?>
        </div>
        <div class="text-center mt-3">
            <a href="index.php?page=modificadores" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
        </div>
    </main>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
