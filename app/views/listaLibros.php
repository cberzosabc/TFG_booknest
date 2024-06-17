    <?php include 'templates/head.php'; ?>

    <body>
        <?php if (isset($_SESSION['mensaje_error'])) : ?>
            <p class="error"><?= $_SESSION['mensaje_error']; ?></p>
            <?php unset($_SESSION['mensaje_error']); ?>
        <?php endif; ?>
        <?php include 'templates/menu.php'; ?>
        <div class="row">
            <div class="col-12">
                <div class="c-links__goBack">
                    <a href="#" id="enlaceVolver">Volver atrás</a>
                </div>
                <div class="o-table__title">
                    <h4>Lista de Libros</h4>
                    <button type="button" class="btn o-button__btn-green" data-toggle="modal" data-target="#modalLibro">
                        nuevo libro
                    </button>
                    <button type="button" class="btn o-button__btn-green" data-toggle="modal" data-target="#modalAutor">
                        nuevo autor
                    </button>
                    <button type="button" class="btn o-button__btn-green" data-toggle="modal" data-target="#modalGenero">
                        nuevo genero
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="o-table table table-bordered mt-3">
                        <thead class="o-table__thead">
                            <tr>
                                <th>Portada</th>
                                <th>Titulo</th>
                                <th>Autor</th>
                                <th>Género</th>
                                <th>Isbn</th>
                                <th>Edición</th>
                                <th>Resumen</th>
                                <?php if (!empty($libros)) : ?>
                                    <th>Acciones</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody class="o-table__tbody">
                            <?php if (!empty($libros)) : ?>
                                <?php foreach ($libros as $libro) : ?>
                                    <tr id="fila-autor-<?= $autor['id']; ?>">
                                        <td><img src="web/images/fotosPortadas/<?= htmlspecialchars($libro['foto_portada']); ?>" alt=""></td>
                                        <td><?= htmlspecialchars($libro['titulo']); ?></td>
                                        <td><?= htmlspecialchars($libro['autor_nombre'] . ' ' . $libro['autor_apellidos']); ?></td>
                                        <td><?= htmlspecialchars($libro['genero_nombre']); ?></td>
                                        <td><?= htmlspecialchars($libro['isbn']); ?></td>
                                        <td><?= htmlspecialchars($libro['edicion']); ?></td>
                                        <td><?= htmlspecialchars($libro['resumen']); ?></td>
                                        <td>
                                            <a class="o-input__edit" data-toggle="modal" data-target="#modalEditarLibro" data-id="<?= $libro['id']; ?>" data-titulo="<?= htmlspecialchars($libro['titulo']); ?>" data-resumen="<?= htmlspecialchars($libro['resumen']); ?>" data-isbn="<?= htmlspecialchars($libro['isbn']); ?>" data-edicion="<?= htmlspecialchars($libro['edicion']); ?>" data-autor_nombre="<?= htmlspecialchars($libro['autor_nombre']); ?>" data-genero_nombre="<?= htmlspecialchars($libro['genero_nombre']); ?>" data-foto_portada="<?= htmlspecialchars($libro['foto_portada']); ?>">
                                                <i class="uil uil-edit"></i>
                                            </a>
                                            <a class="o-input__delete" href="index.php?action=deleteLibro&id=<?= $libro['id']; ?>"><i class="uil uil-trash-alt"></i></a>
                                            <?php if ($libro['portada']) : ?>
                                                <a class="o-input__portada" href="index.php?action=desmarcarPortada&id=<?= $libro['id']; ?>">Quitar de portada</a>
                                            <?php else : ?>
                                                <a class="o-input__portada" href="index.php?action=marcarPortada&id=<?= $libro['id']; ?>">Poner en portada</a>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8">No se encontraron libros.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalLibro" tabindex="-1" role="dialog" aria-labelledby="modalLibroLabel" aria-hidden="true">
            <div class=" modal-dialog" role="document">
                <div class="o-modal__green modal-content">
                    <div class="o-modal__header modal-header">
                        <h5 class="modal-title" id="modalLibroLabel">Nuevo libro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="o-modal__body modal-body">
                        <form method="POST" action="index.php?action=registrarLibros" class="form-horizontal form-material" enctype="multipart/form-data" accept-charset="UTF-8">
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" name="titulo" class="o-input__form" placeholder="Titulo">
                                    <i class="o-input__icon uil uil-book-alt"></i>
                                </div>
                                <div class="form-group mt-2">
                                    <textarea name="resumen" class="o-input__form" id=""></textarea>
                                    <i class="o-input__icon uil uil-pen"></i>
                                </div>
                                <div class="form-group mt-2">
                                    <input type="number" name="isbn" class="o-input__form" placeholder="ISBN">
                                    <i class="o-input__icon uil uil-registered"></i>
                                </div>
                                <div class="form-group mt-2">
                                    <select name="autor" class="four-boot-select" id="">
                                        <?php if (!empty($autores)) : ?>
                                            <?php foreach ($autores as $autor) : ?>
                                                <option value="<?= htmlspecialchars($autor['id']); ?>"><?= htmlspecialchars($autor['nombre']); ?> <?= htmlspecialchars($autor['apellidos']); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <i class="o-input__icon uil uil-user"></i>
                                </div>
                                <div class="form-group mt-2">
                                    <select name="genero" class="four-boot-select" id="">
                                        <?php if (!empty($generos)) : ?>
                                            <?php foreach ($generos as $genero) : ?>
                                                <option value="<?= htmlspecialchars($genero['id']); ?>"><?= htmlspecialchars($genero['nombre']); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <i class="o-input__icon uil uil-star-half-alt"></i>
                                </div>
                                <div class="form-group mt-2">
                                    <input type="text" name="edicion" class="o-input__form" placeholder="Edición">
                                    <i class="o-input__icon uil uil-10-plus"></i>
                                </div>

                                <div class="form-group mt-2">
                                    <input type="file" name="foto" class="o-input__form">
                                    <i class="o-input__icon uil uil-image"></i>

                                </div>
                                <input type="hidden" name="fromListPage" value="true">

                            </div>

                    </div>
                    <div class="o-modal__footer modal-footer">
                        <button type="submit" class="btn o-button__btn-login">Guardar libro</button>
                    </div>
                    </form>
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
                        <form method="POST" action="index.php?action=nuevoGeneroDesdeLibros" class="form-horizontal form-material" accept-charset="UTF-8">
                            <div class="form-group">
                                <div class="form-group">
                                    <input type="text" name="nombre" class="o-input__form" placeholder="Nombre del género">
                                    <i class="o-input__icon uil uil-user"></i>
                                </div>
                            </div>

                    </div>
                    <div class="o-modal__footer modal-footer">
                        <button type="submit" class="btn o-button__btn-login">Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalEditarLibro" tabindex="-1" role="dialog" aria-labelledby="modalEditarLibroLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="o-modal__green modal-content">
                    <div class="o-modal__header modal-header">
                        <h5 class="modal-title" id="modalEditarLibroLabel">Editar Libro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario de edición de libro -->
                        <form id="formEditarLibro" enctype="multipart/form-data">
                            <input type="hidden" id="editLibroId" name="id">
                            <div class="form-group">
                                <label class="pt-2" for="editLibroTitulo">Título</label>
                                <input type="text" class="form-control  o-input__form" id="editLibroTitulo" name="titulo" required>
                            </div>
                            <div class="form-group">
                                <label class="pt-2" for="editLibroResumen">Resumen</label>
                                <textarea class="form-control  o-input__form" id="editLibroResumen" name="resumen" required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="pt-2" for="editLibroIsbn">ISBN</label>
                                <input type="number" class="form-control  o-input__form" id="editLibroIsbn" name="isbn" required>
                            </div>
                            <div class="form-group">
                                <label class="pt-2" for="editLibroEdicion">Edición</label>
                                <input type="number" class="form-control  o-input__form" id="editLibroEdicion" name="edicion" required>
                            </div>
                            <div class="form-group">
                                <label class="pt-2" for="editLibroAutor">Autor</label>
                                <select name="idAutor" class="form-control  o-input__form" id="editLibroAutor" required>
                                    <!-- Opciones de autores -->
                                    <?php foreach ($autores as $autor) : ?>
                                        <option value="<?= $autor['id']; ?>"><?= htmlspecialchars($autor['nombre'] . ' ' . $autor['apellidos']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="pt-2" for="editLibroGenero">Género</label>
                                <select name="idGenero" class="form-control four-boot-select" id="editLibroGenero" required>
                                    <!-- Opciones de géneros -->
                                    <?php foreach ($generos as $genero) : ?>
                                        <option value="<?= $genero['id']; ?>"><?= htmlspecialchars($genero['nombre']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="pt-2" for="editLibroFoto">Portada</label>
                                <input type="file" class="form-control  o-input__form" id="editLibroFoto" name="foto">
                            </div>
                            <button class="mt-4 btn o-button__btn-login" type="submit" class="btn btn-primary">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'templates/scripts.php'; ?>
    </body>

    </html>