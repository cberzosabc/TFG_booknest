<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'templates/head.php'; ?>
</head>
<body>
    <?php if (isset($_SESSION['mensaje_error'])) : ?>
        <p class="error"><?= $_SESSION['mensaje_error']; ?></p>
        <?php unset($_SESSION['mensaje_error']); ?>
    <?php endif; ?>
    <?php include 'templates/menu.php'; ?>
    <div class="row">
    <div class="c-links__goBack">
        <a href="#" id="enlaceVolver">Volver atrás</a>
        </div>
        <div class="col-12">
            <div class="o-table__title">
                <h4>Lista de Géneros</h4>
                <button type="button" class="btn o-button__btn-green" data-toggle="modal" data-target="#modalGenero">
                    Nuevo género
                </button>
            </div>
            <div class="table-responsive">
                <table class="o-table table table-bordered mt-3">
                    <thead class="o-table__thead">
                        <tr>
                            <th>Nombre</th>
                            <?php if (!empty($generos)) : ?>
                                <th>Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="o-table__tbody">
                        <?php if (!empty($generos)) : ?>
                            <?php foreach ($generos as $genero) : ?>
                                <tr id="fila-genero-<?= $genero['id']; ?>">
                                    <td><?= htmlspecialchars($genero['nombre']); ?></td>
                                    <td>
                                        <a class="o-input__edit" data-toggle="modal" data-target="#modalEditarGenero" data-id="<?= $genero['id']; ?>" data-nombre="<?= htmlspecialchars($genero['nombre']); ?>"><i class="uil uil-edit"></i></a>
                                        <a class="o-input__delete" data-toggle="modal" data-target="#eliminarGeneroModal<?= $genero['id']; ?>"><i class="uil uil-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="eliminarGeneroModal<?= $genero['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="eliminarGeneroModalLabel<?= $genero['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="eliminarGeneroModalLabel">Aviso importante</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Si eliminas este género, todos los libros asociados a él también se eliminarán.</p>
                                                <p>¿Estás seguro?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                <a type="button" class="btn btn-primary" href="index.php?action=deleteGenero&id=<?= $genero['id']; ?>">Confirmar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="2">No se encontraron géneros.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalGenero" tabindex="-1" role="dialog" aria-labelledby="modalGeneroLabel" aria-hidden="true">
        <div class=" modal-dialog" role="document">
            <div class="o-modal__green modal-content">
                <div class="o-modal__header modal-header">
                    <h5 class="modal-title" id="modalGeneroLabel">Nuevo género</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="o-modal__body modal-body">
                    <form method="POST" action="index.php?action=registrarGenero" class="form-horizontal form-material" accept-charset="UTF-8">
                        <div class="form-group">
                            <input type="text" name="nombre" class="o-input__form" placeholder="Nombre del género">
                            <i class="o-input__icon uil uil-user"></i>
                        </div>
                </div>
                <div class="o-modal__footer modal-footer">
                    <button type="submit" class="btn o-button__btn-login">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarGenero" tabindex="-1" role="dialog" aria-labelledby="modalEditarGeneroLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="o-modal__green modal-content">
                <div class="o-modal__header modal-header">
                    <h5 class="modal-title" id="modalEditarGeneroLabel">Editar género</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="o-modal__body modal-body">
                    <form id="formEditarGenero" class="form-horizontal form-material" accept-charset="UTF-8">
                        <div class="form-group">
                            <input type="hidden" name="id" id="editGeneroId">
                            <input type="text" name="nombre" id="editGeneroNombre" class="o-input__form" placeholder="Nombre del género">
                            <i class="o-input__icon uil uil-user"></i>
                        </div>
                    <button type="submit" class="mt-4 btn o-button__btn-login">Guardar</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'templates/scripts.php'; ?>

</body>
</html>
