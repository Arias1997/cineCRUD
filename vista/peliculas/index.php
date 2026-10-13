<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cine - Listado de película1</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <h1>Listado de películas</h1>

        <a href="index.php?accion=crear" class="boton boton-agregar">+ Agregar película</a>

        <!-- Formulario de busqueda -->
        <form action="index.php" method="GET" class="buscador">
            <input type="hidden" name="accion" value="index">
            <input type="text" name="buscar" placeholder="Buscar por nombre o género..."
                   value="<?= htmlspecialchars($busqueda) ?>">
            <button type="submit" class="boton boton-editar">Buscar</button>
            <?php if ($busqueda !== ''): ?>
                <a href="index.php?accion=index" class="boton boton-cancelar">Limpiar</a>
            <?php endif; ?>
        </form>
        <?php if ($busqueda !== ''): ?>
            <p class="resultado-busqueda">
                <?= count($peliculas) ?> resultado(s) para
                "<strong><?= htmlspecialchars($busqueda) ?></strong>"
            </p>
        <?php endif; ?>


        <?php if (empty($peliculas)): ?>
            <p class="mensaje-vacio">
                <?= $busqueda !== '' ? 'No se encontraron películas con ese criterio.' : 'Aún no hay películas registradas.' ?>
            </p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Portada</th>
                        <th>Nombre</th>
                        <th>Género</th>
                        <th>Duración</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($peliculas as $p): ?>
                        <tr>
                            <td><?= $p->getId() ?></td>
                            <td>
                                <img src="public/uploads/<?= htmlspecialchars($p->getImagenportada()) ?>"
                                     alt="Portada de <?= htmlspecialchars($p->getNombre()) ?>"
                                     class="portada">
                            </td>
                            <td><?= htmlspecialchars($p->getNombre()) ?></td>
                            <td><?= htmlspecialchars($p->getGenero()) ?></td>
                            <td><?= (int)$p->getDuracion() ?> min</td>
                            <td>
                                <a href="index.php?accion=editar&id=<?= $p->getId() ?>"
                                   class="boton boton-editar">Editar</a>
                                <a href="index.php?accion=eliminar&id=<?= $p->getId() ?>"
                                   class="boton boton-eliminar"
                                   onclick="return confirm('¿Seguro que deseas eliminar esta película?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>