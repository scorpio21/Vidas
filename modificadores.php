<?php
// =============================================
// Página de Modificadores de Clase para AOMania
// Permite seleccionar y mostrar información de clases en AOMania
// =============================================
// Incluir token CSRF para proteger contra ataques de falsificación de solicitudes
include 'csrf_token.php';
?>
<!-- Encabezado principal de la página de modificadores -->
<header class="text-center header-modificadores">
    <h2 id="modificadores-title"><i class="fas fa-sliders-h"></i> Modificadores de clase</h2>
    <p class="lead">Selecciona una opción para consultar o modificar información de clases en AOMania.</p>
</header>
<!-- Contenedor principal de la página -->
<main role="main" aria-labelledby="modificadores-title" class="main-500">
    <!-- Sección dinámica para cargar contenido de modificadores -->
    <div id="modificadores-lista-dinamico"></div>
    <!-- Fin de la sección dinámica -->
</main>
<!-- Incluir biblioteca de Font Awesome para iconos -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script>
// Evento de carga de la página para inicializar la carga de modificadores
document.addEventListener('DOMContentLoaded', function() {
    // Obtener parámetros de la URL
    const params = new URLSearchParams(window.location.search);
    const page = params.get('page');
    // Obtener contenedor para cargar contenido dinámico
    const container = document.getElementById('modificadores-lista-dinamico');
    /**
     * Función para cargar modificadores mediante AJAX
     * @param {string} clase - Clase a cargar modificadores (opcional)
     */
    function cargarModificadoresAjax(clase) {
        // URL base para cargar modificadores
        let url = 'api_modificadores.php';
        // Agregar parámetro de clase si se proporciona
        if(clase) url += '?clase=' + encodeURIComponent(clase);
        // Mostrar cargador mientras se carga el contenido
        container.innerHTML = `<div class='text-center my-3'><div class='spinner-border text-success'></div></div>`;
        // Realizar solicitud AJAX para cargar modificadores
        fetch(url)
            .then(r=>r.text())
            .then(html=>{
                // Cargar contenido en el contenedor
                container.innerHTML = `<div style='position:relative;'>`+
                  html+`</div>`;
                // Obtener selector de clase
                const select = document.getElementById('clase');
                // Agregar evento de cambio para recargar modificadores
                if(select) {
                    select.addEventListener('change', function() {
                        cargarModificadoresAjax(this.value);
                    });
                }
            });
    }
    // Cargar siempre el selector y los modificadores al entrar a la página
    if(page === 'modificadores' || (page === 'modificadores' && params.get('show') === 'modificadores-lista')) {
        cargarModificadoresAjax();
    }
});
</script>
