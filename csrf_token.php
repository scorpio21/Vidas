<?php
// =============================================
// Generador y verificador de tokens CSRF para AOMania
// Protege los formularios contra ataques de falsificación de solicitudes
// =============================================
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>