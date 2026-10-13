# CRUD de películas

Aplicación CRUD en PHP y MySQL para administrar películas, incluida la carga de portadas.

## Requisitos

- XAMPP con Apache, MySQL/MariaDB y PHP con PDO MySQL habilitado.
- Un navegador web.

## Instalación local con XAMPP

1. Copia o clona el proyecto en `C:\xampp\htdocs\actividad14_crudCineArielArias`.
2. Inicia Apache y MySQL desde el panel de XAMPP.
3. Abre phpMyAdmin en `http://localhost/phpmyadmin`.
4. Importa el archivo `database.sql` desde la pestaña **Importar**. Este archivo crea la base `cine` y la tabla `pelicula`, sin insertar datos personales.
5. Copia `config/database.local.example.php` como `config/database.local.php` y ajusta host, puerto, nombre de la base, usuario y contraseña para tu instalación.
   - El valor de ejemplo usa `127.0.0.1`, puerto `3307`, base `cine`, usuario `root` y contraseña vacía, tal como la configuración local original del proyecto.
   - `config/database.local.php` está excluido de Git. No publiques credenciales.
6. Abre `http://localhost/actividad14_crudCineArielArias/`.

Si tu carpeta dentro de `htdocs` tiene otro nombre, usa ese nombre en la URL.

## Base de datos

La aplicación usa la tabla `pelicula` con estos campos:

| Campo | Tipo | Uso |
| --- | --- | --- |
| `id` | entero autoincremental | Identificador |
| `nombre` | texto, hasta 100 caracteres | Nombre de la película |
| `genero` | texto, hasta 100 caracteres | Género |
| `duracion` | entero | Duración en minutos |
| `imagenportada` | texto, hasta 255 caracteres | Nombre del archivo de portada |

Para publicar una copia de la base que ya tienes, exporta **solo la estructura** desde phpMyAdmin si no quieres compartir tus registros. No subas respaldos que contengan datos personales. `database.sql` contiene únicamente el esquema básico requerido por esta aplicación.

## Imágenes

Las portadas nuevas se guardan en `public/uploads/`. Los archivos de esa carpeta se excluyen de Git; por eso no se incluyen las imágenes que existan en tu computadora. Al instalar el proyecto en otro equipo, vuelve a subir las portadas desde la aplicación o transfiérelas por separado si tienes derecho a compartirlas.

## Subir el proyecto a GitHub

Desde PowerShell, en la carpeta del proyecto:

```powershell
git init
git add .
git status
git commit -m "Preparar CRUD de películas para GitHub"
git branch -M main
git remote add origin https://github.com/USUARIO/REPOSITORIO.git
git push -u origin main
```

Crea primero un repositorio vacío en GitHub y reemplaza `USUARIO/REPOSITORIO` por sus datos. Antes de ejecutar `git commit`, revisa `git status`: no deben aparecer `config/database.local.php`, imágenes subidas ni exportaciones privadas de phpMyAdmin.
