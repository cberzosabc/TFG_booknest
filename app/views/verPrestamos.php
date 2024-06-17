<?php include 'templates/head.php'; ?>
<body>
<?php include 'templates/menu.php'; ?>

    <div class="container mt-3">
    <div class="c-links__goBack">
        <a href="#" id="enlaceVolver">Volver atrás</a>
        </div>
        <h1>Préstamos de <?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']); ?></h1>
        <div class="table-responsive">
            <table class="o-table table table-bordered mt-3">
                <thead class="o-table__thead">
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Libro</th>
                        <th>Fecha de Préstamo</th>
                        <th>Fecha de Devolución</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="o-table__tbody">
                    <?php if (!empty($prestamos)) : ?>
                        <?php foreach ($prestamos as $prestamo) : ?>
                            <tr>
                                <td><?= $prestamo['id']; ?></td>
                                <td><?= htmlspecialchars($prestamo['titulo']); ?></td>
                                <td><?= $prestamo['fecha_prestamo']; ?></td>
                                <td>
                                    <?php 
                                    if ($prestamo['estado'] === 'devuelto') {
                                        echo 'Devuelto';
                                    } else {
                                        echo htmlspecialchars($prestamo['fecha_devolucionEsperada']);
                                    }
                                    ?>
                                </td>
                                <td><?= $prestamo['estado']; ?></td>
                                <td>
                                    <?php if ($prestamo['estado'] === 'prestado') : ?>
                                        <form class="devolver-libro-form" action="index.php?action=devolverLibro" method="post">
                                            <input type="hidden" name="prestamo_id" value="<?= $prestamo['id']; ?>">
                                            <button type="submit" class="btn btn-warning">Devolver</button>
                                        </form>
                                    <?php else : ?>
                                        <span class="text-success">Devuelto</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6">No hay préstamos registrados para este usuario.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'templates/scripts.php'; ?>
</body>
