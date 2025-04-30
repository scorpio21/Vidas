# AOMania Calculadoras y Modificadores

[![AOMania](https://aomania.net/images/logo.png)](https://aomania.net/)

**AOMania Calculadoras** es un conjunto de herramientas web desarrolladas para la comunidad de [AOMania](https://aomania.net/), un servidor original del clásico juego argentino **Argentum Online**. Este proyecto permite a los jugadores calcular de manera precisa y rápida valores clave de sus personajes, como vida, maná, domar y consultar modificadores de clase, todo desde una interfaz moderna, minimalista y responsiva.

---

## Enlaces Útiles
- [Sitio oficial de AOMania](https://aomania.net/)
- [Discord AOMania](https://discord.gg/argentinaonline)
- [Wiki AOMania](https://wiki.aomania.net/)

---

## Tabla de Contenidos
- [Características](#características)
- [¿Para qué sirve este proyecto?](#para-qué-sirve-este-proyecto)
- [Tecnologías Utilizadas](#tecnologías-utilizadas)
- [Instalación y Uso](#instalación-y-uso)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Créditos y Licencia](#créditos-y-licencia)
- [Sección Especial: Preguntas Frecuentes (FAQ)](#sección-especial-preguntas-frecuentes-faq)
- [Cómo preparar el proyecto para probarlo](#cómo-preparar-el-proyecto-para-probarlo)

---

## Características
- **Calculadora de Vida**: Calcula la vida máxima y los incrementos por nivel según clase, constitución y nivel del personaje.
- **Calculadora de Maná**: Calcula el maná máximo según clase, inteligencia y nivel del personaje.
- **Calculadora de Domar**: Determina la habilidad necesaria para domar criaturas según clase y carisma.
- **Consulta de Modificadores de Clase**: Muestra los modificadores fijos (evasión, poder de arma, daño, etc.) para cada clase jugable.
- **Calculadora de Experiencia por Criatura**: Calcula cuántos NPCs (criaturas) necesitas derrotar para alcanzar un nivel objetivo, seleccionando entre varias criaturas típicas de AOMania.
- **Interfaz Minimalista y Responsive**: Visual moderna, limpia y adaptable a dispositivos móviles.
- **Seguridad**: Protección CSRF en todos los formularios.
- **Accesibilidad Mejorada**: Inputs accesibles, foco visible y mensajes claros.

---

## ¿Para qué sirve este proyecto?
Esta herramienta está pensada para jugadores, administradores y desarrolladores de **AOMania** y otros servidores de **Argentum Online** que deseen:
- Optimizar la creación y evolución de personajes.
- Consultar rápidamente los modificadores y estadísticas de cada clase.
- Realizar cálculos precisos sin depender de fórmulas manuales o externas.
- Mejorar la experiencia de juego y la toma de decisiones.
- Planificar el farmeo de experiencia eligiendo criaturas y niveles a alcanzar.

---

## Tecnologías Utilizadas
- **PHP** (7.x+): Backend y lógica de negocio.
- **HTML5 / CSS3**: Estructura y estilos modernos.
- **JavaScript**: Interactividad y animaciones para una experiencia dinámica.
- **Font Awesome**: Iconografía profesional.
- **Bootstrap** (parcial): Utilizado para algunos estilos y clases responsivas.

---

## Instalación y Uso

### 1. Requisitos
- Servidor web local (XAMPP, WAMP, Laragon, etc.)
- PHP 7.x o superior

### 2. Instalación
- Clona o descarga este repositorio en la carpeta pública de tu servidor local (por ejemplo, `htdocs` en XAMPP).
- Asegúrate de copiar también la carpeta `imagen` y todos los archivos `.php`, `.css` y `.js` incluidos.

### 3. Estructura de Carpetas
```text
vidas/
├── css/
│   └── styles.min.css         # Estilos principales y modo oscuro
├── imagen/
│   ├── logo.png               # Logo principal
│   ├── logo1.png              # Logo decorativo
│   ├── helios.bmp             # Avatar Helios para footer
│   └── ...                    # Otros gráficos
├── src/
│   └── functions.php          # Funciones reutilizables (cálculos, clases, modificadores)
├── vida.php                   # Calculadora de vida
├── mana.php                   # Calculadora de maná
├── domar.php                  # Calculadora de domar
├── modificadores.php          # Consulta de modificadores por clase (AJAX)
├── modificadores-lista.php    # Consulta de modificadores en modo lista
├── api_modificadores.php      # Endpoint AJAX para modificadores
├── criatura.php               # Calculadora de experiencia por criatura (NPC)
├── index.php                  # Menú principal
└── README.md                  # Este archivo
```

### 4. Uso
- Accede vía navegador a la ruta local, por ejemplo: `http://localhost/vidas/index.php`
- Utiliza el menú para elegir la calculadora o consulta que necesites.
- Completa los campos del formulario y obtén los resultados visuales y detallados.

### 5. Personalización
- Puedes editar los estilos en `css/styles.min.css` para cambiar colores, fuentes o el diseño visual.
- Las criaturas y experiencia de AOMania se pueden modificar en `criaturas_aomania.php`.
- Para agregar más calculadoras, crea un nuevo archivo `.php` y enlázalo desde el menú en `index.php`.

---

## Cómo preparar el proyecto para probarlo

1. **Clona o descarga este repositorio** en la carpeta pública de tu servidor local (por ejemplo, `htdocs` en XAMPP).
2. **Asegúrate de copiar:**
   - Todas las carpetas y archivos PHP principales.
   - La carpeta `css/` con el archivo `styles.min.css`.
   - La carpeta `imagen/` con los logos e imágenes necesarias.
   - La carpeta `src/` con el archivo `functions.php`.
3. **No es necesario instalar dependencias externas** (no uses Composer ni npm a menos que quieras agregar nuevas librerías).
4. **No subas archivos innecesarios:**
   - El repositorio ya incluye un `.gitignore` para evitar archivos temporales, caché, backups, etc.
5. **Abre tu navegador y accede a:**
   - `http://localhost/vidas/index.php` (ajusta la ruta si usas otra carpeta).
6. **¡Listo!** Ya puedes probar todas las calculadoras y herramientas.

> Si tienes problemas de permisos o no ves imágenes, revisa que las rutas sean correctas y que tu servidor web tenga acceso a los archivos.

---

## Sección Especial: Preguntas Frecuentes (FAQ)

### ❓ ¿Por qué mis cálculos no coinciden exactamente con el AOMania oficial?
- La calculadora utiliza las mismas tablas y fórmulas que AOMania, pero si notas alguna diferencia, revisa que estés usando los mismos valores y criaturas. Si encuentras errores, ¡avísanos para corregirlo!

### 🖼️ ¿Cómo cambio los logos o imágenes?
- Simplemente reemplaza los archivos en la carpeta `imagen/` por tus propios gráficos, manteniendo el mismo nombre o ajustando las rutas en los archivos `.php`.

### 🛠️ ¿Puedo agregar nuevas criaturas o modificadores?
- Sí, edita el archivo `criaturas_aomania.php` para criaturas y experiencia, o `modificadores.php` para modificar clases y sus valores.

### 🌙 ¿Tiene modo oscuro?
- Sí, los estilos están preparados para adaptarse a modo oscuro. Puedes personalizar los colores en `css/styles.min.css`.

### 💡 ¿Cómo reporto un bug o sugiero una mejora?
- Abre un issue en el [GitHub del proyecto](https://github.com/scorpio21/Vidas) o contacta por Discord.

### 👥 ¿Quién puede usar este proyecto?
- Cualquier jugador, staff o fan de AOMania o Argentum Online. Es libre y gratuito bajo licencia MIT.

---

## Créditos y Licencia
- Proyecto original: **AOMania** (https://aomania.net/)
- Inspirado en el clásico **Argentum Online**
- Desarrollado por la comunidad para la comunidad
- Mejoras visuales y scripts: Helios, Scorpio21 y colaboradores

**Licencia:** Este proyecto es de código abierto bajo la licencia MIT. Puedes usarlo, modificarlo y compartirlo citando la autoría original.

---

[![Visita el repositorio en GitHub](https://img.shields.io/badge/GitHub-Repositorio-181717?logo=github&style=for-the-badge)](https://github.com/scorpio21/Vidas)

---

## Contacto y Soporte
¿Dudas, sugerencias o quieres contribuir? Puedes abrir un issue en GitHub o contactar a la administración de AOMania en su web oficial.

---

¡Gracias por apoyar el desarrollo de herramientas para la comunidad AOMania y Argentum Online!
