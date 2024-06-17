<?php include 'templates/head.php'; ?>

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
                <h4>Lista de Autores</h4>
                <button type="button" class="btn o-button__btn-green" data-toggle="modal" data-target="#modalAutor">
                    nuevo autor
                </button>
            </div>
            <div class="table-responsive">
                <table class="o-table table table-bordered mt-3">
                    <thead class="o-table__thead">
                        <tr>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Biografía</th>
                            <th>Fecha de nacimiento</th>
                            <th>País</th>
                            <?php if (!empty($autores)) : ?>
                                <th>Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="o-table__tbody">
                        <?php if (!empty($autores)) : ?>
                            <?php foreach ($autores as $autor) : ?>
                                <tr id="fila-autor-<?= $autor['id']; ?>">
                                    <td><img src="web/images/fotosAutores/<?= htmlspecialchars($autor['foto']); ?>" alt=""></td>
                                    <td><?= htmlspecialchars($autor['nombre']); ?></td>
                                    <td><?= htmlspecialchars($autor['apellidos']); ?></td>
                                    <td><?= htmlspecialchars($autor['biografia']); ?></td>
                                    <td><?= htmlspecialchars($autor['fecha_nacimiento']); ?></td>
                                    <td><?= htmlspecialchars($autor['pais']); ?></td>
                                    <td>
                                        <a class="o-input__edit" data-toggle="modal" data-target="#modalEditarAutor" data-id="<?= $autor['id']; ?>" data-nombre="<?= htmlspecialchars($autor['nombre']); ?>" data-apellidos="<?= htmlspecialchars($autor['apellidos']); ?>" data-biografia="<?= htmlspecialchars($autor['biografia']); ?>" data-fecha-nacimiento="<?= htmlspecialchars($autor['fecha_nacimiento']); ?>" data-pais="<?= htmlspecialchars($autor['pais']); ?>" data-foto="<?= htmlspecialchars($autor['foto']); ?>">
                                            <i class="uil uil-edit"></i>
                                        </a>
                                        <a class="o-input__delete" data-toggle="modal" data-target="#eliminarAutorModal<?= $autor['id']; ?>"><i class="uil uil-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="eliminarAutorModal<?= $autor['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="eliminarAutorModalLabel<?= $autor['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="eliminarLibroModalLabel">Aviso importante</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Si eliminas este autor, todos los libros asociados a él también se eliminarán.</p>
                                                <p>¿Estás seguro?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <a type="a" class="btn btn-primary" href="index.php?action=deleteAutor&id=<?= $autor['id']; ?>">Confirmar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8">No se encontraron autores.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAutor" tabindex="-1" role="dialog" aria-labelledby="modalAutorLabel" aria-hidden="true">
        <div class=" modal-dialog" role="document">
            <div class="o-modal__green modal-content">
                <div class="o-modal__header modal-header">
                    <h5 class="modal-title" id="modalAutorLabel">Nuevo autor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="o-modal__body modal-body">
                    <form method="POST" action="index.php?action=registrarAutorDesdeLibros" class="form-horizontal form-material">
                        <div class="form-group">
                            <div class="form-group">
                                <input type="text" name="name" class="o-input__form" placeholder="Nombre">
                                <i class="o-input__icon uil uil-user"></i>
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" name="apellidos" class="o-input__form" placeholder="Apellidos">
                                <i class="o-input__icon uil uil-user"></i>
                            </div>
                            <div class="form-group mt-2">
                                <textarea name="biografia" id=""></textarea>
                                <i class="o-input__icon uil uil-at"></i>
                            </div>
                            <div class="form-group mt-2">
                                <input type="date" name="fecha_nacimiento" class="o-input__form" placeholder="Password">
                                <i class="o-input__icon uil uil-lock-alt"></i>
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" name="edicion" class="o-input__form" placeholder="Edición">
                                <i class="o-input__icon uil uil-user"></i>
                            </div>

                            <div class="form-group mt-2">
                                <input type="file" name="foto" class="o-input__form">
                                <i class="o-input__icon uil uil-image"></i>

                            </div>
                            <input type="hidden" name="fromListPage" value="true">

                        </div>

                </div>
                <div class="o-modal__footer modal-footer">
                    <button type="submit" class="btn o-button__btn-login">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditarAutor" tabindex="-1" role="dialog" aria-labelledby="modalEditarAutorLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="o-modal__green modal-content">
                <div class="o-modal__header modal-header">
                    <h5 class="modal-title" id="modalEditarAutorLabel">Editar autor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditarAutor" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="editAutorId" name="id">
                        <div class="form-group">
                            <label class="pt-2" for="editAutorNombre">Nombre</label>
                            <input type="text" class="form-control o-input__form" id="editAutorNombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label class="pt-2" for="editAutorApellidos">Apellidos</label>
                            <input type="text" class="form-control o-input__form" id="editAutorApellidos" name="apellidos" required>
                        </div>
                        <div class="form-group">
                            <label class="pt-2" for="editAutorBiografia">Biografía</label>
                            <textarea class="form-control o-input__form" id="editAutorBiografia" name="biografia" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="pt-2" for="editAutorFechaNacimiento">Fecha de nacimiento</label>
                            <input type="date" class="form-control o-input__form" id="editAutorFechaNacimiento" name="fecha_nacimiento" required>
                        </div>
                        <div class="form-group">
                            <label class="pt-2" for="editAutorPais">País</label>
                            <input type="text" class="form-control o-input__form" id="editAutorPais" name="pais" required>
                        </div>
                        <div class="form-group">
                            <label class="pt-2" for="editAutorFoto">Foto</label>
                            <input type="file" class="form-control o-input__form" id="editAutorFoto" name="foto">
                        </div>
                        <button type="submit" class="mt-4 btn o-button__btn-login">Guardar cambios</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php include 'templates/footer.php'; ?>
    <?php include 'templates/scripts.php'; ?>
</body>

</html>