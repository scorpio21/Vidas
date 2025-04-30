<?php include 'csrf_token.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de AOMania</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        .main-card {max-width: 600px; margin: 40px auto 0 auto; border-radius: 22px;}
        .main-header {background:rgba(0,0,0,0.7); color:#fff; border-radius:22px 22px 0 0; padding:2em 0;}
        .nav-pills .nav-link.active {background: linear-gradient(135deg,#1a2a6c,#b21f1f,#fdbb2d); color:#fff;}
        .nav-pills .nav-link {font-size:1.2em;}
        .helios-img-footer:hover {
            transform: scale(1.18) rotate(-8deg);
            box-shadow:0 4px 18px #ffb30099, 0 1px 10px #0007;
            cursor:pointer;
        }
    </style>
</head>
<body>
    <div class="container main-card shadow-lg p-0 bg-light">
        <header class="main-header text-center mb-4">
            <h1><i class="fas fa-calculator"></i> Calculadora de AOMania</h1>
            <img src="imagen/logo1.png" alt="Logo AOMania" style="max-width:170px;width:100%;height:auto;margin-top:10px;box-shadow:0 0 8px #0002;border-radius:12px;">
        </header>
        <nav class="nav nav-pills nav-justified mb-4">
            <a class="nav-item nav-link<?php echo (!isset($_GET['page']) || $_GET['page'] == 'mana') ? ' active' : ''; ?>" href="index.php?page=mana"><i class="fas fa-bolt"></i> Calculadora de Mana</a>
            <a class="nav-item nav-link<?php echo (isset($_GET['page']) && $_GET['page'] == 'vida') ? ' active' : ''; ?>" href="index.php?page=vida"><i class="fas fa-heart"></i> Calculadora de Vida</a>
            <a class="nav-item nav-link<?php echo (isset($_GET['page']) && $_GET['page'] == 'domar') ? ' active' : ''; ?>" href="index.php?page=domar"><i class="fas fa-dragon"></i> Calculadora de Domar</a>
            <a class="nav-item nav-link<?php echo (isset($_GET['page']) && $_GET['page'] == 'modificadores') ? ' active' : ''; ?>" href="index.php?page=modificadores"><i class="fas fa-sliders-h"></i> Modificadores de clase</a>
            <a class="nav-item nav-link<?php echo (isset($_GET['page']) && $_GET['page'] == 'criatura') ? ' active' : ''; ?>" href="index.php?page=criatura"><i class="fas fa-dragon"></i> Calculadora de Experiencia por Criatura</a>
        </nav>
        <div class="content">
            <?php
            $page = $_GET['page'] ?? 'home';
            switch ($page) {
                case 'mana':
                    include 'mana.php';
                    break;
                case 'vida':
                    include 'vida.php';
                    break;
                case 'domar':
                    include 'domar.php';
                    break;
                case 'modificadores':
                    include 'modificadores.php';
                    break;
                case 'criatura':
                    include 'criatura.php';
                    break;
                default:
                    echo '<div class="text-center p-5">'
                        .'<a href="https://aomania.net/" target="_blank" rel="noopener" title="Ir a AOMania">'
                        .'<img src="imagen/logo.png" alt="Logo AOMania" style="max-width:340px;width:100%;height:auto;box-shadow:0 0 18px #0003;border-radius:18px;transition:box-shadow 0.2s;">'
                        .'</a>'
                        .'</div>';
                    break;
            }
            ?>
        </div>
    </div>
    <footer class="text-center mt-4" style="opacity:0.8;">
        <small>Desarrollado por Scorpio21 &copy; <?php echo date('Y'); ?> | <i class="fas fa-heart text-danger"></i></small><br>
        <span class="footer-helios" style="font-size:0.98em;opacity:0.8;display:inline-flex;align-items:center;gap:6px;margin-top:3px;">
            <img src="imagen/helios.bmp" alt="Helios" class="helios-img-footer" style="height:28px;width:28px;object-fit:cover;vertical-align:middle;border-radius:50%;box-shadow:0 1px 6px #0004;transition:transform 0.35s, box-shadow 0.35s;">
            <span style="color:#2196f3;font-weight:600;">by Helios</span>
        </span>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>