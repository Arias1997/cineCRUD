<?php $esEdicion = $pelicula->getId() !== null; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cine - <?= $esEdicion ? 'Editar' : 'Agregar' ?> película</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <h1><?= $esEdicion ? 'Editar película' : 'Agregar película' ?></h1>

        <?php if (!empty($errores)): ?>
            <div class="errores">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="index.php?accion=<?= $esEdicion ? 'actualizar' : 'guardar' ?>"
              method="POST"
              enctype="multipart/form-data">

            <?php if ($esEdicion): ?>
                <input type="hidden" name="id" value="<?= (int)$pelicula->getId() ?>">
            <?php endif; ?>

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" maxlength="100" required
                   value="<?= htmlspecialchars($pelicula->getNombre()) ?>">

            <label for="genero">Género</label>
            <input type="text" id="genero" name="genero" maxlength="100" required
                   value="<?= htmlspecialchars($pelicula->getGenero()) ?>">

            <label for="duracion">Duración (minutos)</label>
            <input type="number" id="duracion" name="duracion" min="1" step="1" required
                   value="<?= $pelicula->getDuracion() ? (int)$pelicula->getDuracion() : '' ?>">

            <label for="imagenportada">Imagen de portada</label>
            <?php if ($esEdicion && $pelicula->getImagenportada()): ?>
                <div class="portada-actual">
                    <img src="public/uploads/<?= htmlspecialchars($pelicula->getImagenportada()) ?>"
                         alt="Portada actual" class="portada">
                    <small>Portada actual. Sube otra imagen solo si quieres cambiarla.</small>
                </div>
            <?php endif; ?>
            <input type="file" id="imagenportada" name="imagenportada"
                   accept=".jpg,.jpeg,.png,.gif,.webp"
                   <?= $esEdicion ? '' : 'required' ?>>

            <div class="acciones-form">
                <button type="submit" class="boton boton-agregar">
                    <?= $esEdicion ? 'Guardar cambios' : 'Guardar película' ?>
                </button>
                <a href="index.php?accion=index" class="boton boton-cancelar">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>