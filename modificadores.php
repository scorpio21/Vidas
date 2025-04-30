<?php
// Página: Modificadores de clase
include 'csrf_token.php';
?>
<!-- Header fuera del contenedor principal, más pequeño y arriba -->
<header class="text-center header-modificadores">
    <h2 id="modificadores-title"><i class="fas fa-sliders-h"></i> Modificadores de clase</h2>
    <p class="lead">Selecciona una opción para consultar o modificar información de clases en AOMania.</p>
</header>
<main role="main" aria-labelledby="modificadores-title" style="max-width: 500px; margin: 40px auto 0 auto;">
    <!-- Eliminado el marco/card para un diseño más limpio -->
    <div id="modificadores-lista-dinamico"></div>
    <!-- Eliminado el botón de volver de la parte inferior -->
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    const page = params.get('page');
    const container = document.getElementById('modificadores-lista-dinamico');
    function cargarModificadoresAjax(clase) {
        let url = 'api_modificadores.php';
        if(clase) url += '?clase=' + encodeURIComponent(clase);
        container.innerHTML = `<div class='text-center my-3'><div class='spinner-border text-success'></div></div>`;
        fetch(url)
            .then(r=>r.text())
            .then(html=>{
                container.innerHTML = `<div style='position:relative;'>`+
                  html+`</div>`;
                const select = document.getElementById('clase');
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
