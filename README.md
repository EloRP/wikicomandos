<strong>WikiComandos</strong> es una aplicación web ligera y minimalista desarrollada en PHP nativo y SQLite, diseñada para almacenar, organizar y consultar rápidamente comandos de terminal, scripts o atajos. (Git, Docker, Linux, Python, etc.)

<strong>Características</strong>:
- Filtra comandos en tiempo real por término clave (coincidencias en comandos o descripciones).
- Organiza el contenido en tecnologías.

<strong>Lenguajes utilizados</strong>:
Backend: PHP 8+
Base de Datos: SQLite 3.
Frontend: HTML5, CSS3.

<strong>Entorno de desarrollo:</strong> Compatible con XAMPP, Laragon, Docker o servidor web embebido de PHP.

<strong>SETUP:</strong> 

1. Asegúrate de tener instalado en tu sistema:
- PHP (versión 8.0 o superior). Puedes verificarlo ejecutando php -v en tu terminal.
- La extensión de PHP para SQLite3 habilitada (suele venir activada por defecto en la mayoría de instalaciones de PHP).

2. Abre tu terminal y clona el proyecto en tu directorio de trabajo local (o descárgalo directamente de GitHub):

3. Asegúrate de que la estructura de carpetas del proyecto sea coherente con la conexión a la base de datos (definida en config/db.php), la cual busca la base de datos dentro de una carpeta llamada database.
La forma más rápida de ejecutar el proyecto sin configurar servidores complejos (como Apache o Nginx) es utilizando el servidor web integrado de PHP.

4. Abre tu terminal en la raíz del proyecto (command-wiki/).

5. Ejecuta el siguiente comando:
php -S localhost:8000

6. Entra en la siguiente URL: http://localhost:8000

7. La primera vez que cargue la página, el script detectará si la base de datos SQLite existe; si no, la creará de manera automática junto con la tabla comandos gracias a la configuración en config/db.php. Ya puedes empezar a añadir y gestionar tus comandos.

Las contribuciones, mejoras y sugerencias son bienvenidas. Si deseas proponer nuevas características, haz un Fork del proyecto, crea una rama con tus cambios y abre un Pull Request.
