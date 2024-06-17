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
                <h4>Lista de usuarios</h4>
                <button type="button" class="btn o-button__btn-green" data-toggle="modal" data-target="#exampleModal">
                    nuevo usuario
                </button>
            </div>
            <div class="table-responsive">
                <table class="o-table table table-bordered mt-3">
                    <thead class="o-table__thead">
                        <tr id="fila-usuario-<?= $usuario['id']; ?>">
                            <th>Foto</th>
                            <th>Apellidos</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Población</th>
                            <th>Rol</th>
                            <?php if (!empty($usuarios)) : ?>
                                <th>Acciones</th>
                                <th>Préstamos</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="o-table__tbody">
    <?php if (!empty($usuarios)) : ?>
        <?php foreach ($usuarios as $usuario) : ?>
            <tr id="fila-usuario-<?= $usuario['id']; ?>">
                <td><img src="web/images/fotosUsuarios/<?= htmlspecialchars($usuario['foto']); ?>" alt=""></td>
                <td><?= htmlspecialchars($usuario['apellidos']); ?></td>
                <td><?= htmlspecialchars($usuario['nombre']); ?></td>
                <td><?= htmlspecialchars($usuario['email']); ?></td>
                <td><?= htmlspecialchars($usuario['poblacion']); ?></td>
                <td><div class="o-table__mark"><?= htmlspecialchars($usuario['rol']); ?></div></td>
                <td>
                    <a class="o-input__edit" data-toggle="modal" data-target="#modalEditarUsuario" data-id="<?= $usuario['id']; ?>" data-nombre="<?= htmlspecialchars($usuario['nombre']); ?>" data-apellidos="<?= htmlspecialchars($usuario['apellidos']); ?>" data-email="<?= htmlspecialchars($usuario['email']); ?>" data-poblacion="<?= htmlspecialchars($usuario['poblacion']); ?>" data-rol="<?= htmlspecialchars($usuario['rol']); ?>" data-foto="<?= htmlspecialchars($usuario['foto']); ?>">
                        <i class="uil uil-edit"></i>
                    </a>
                    <a class="o-input__delete" href="index.php?action=deleteUser&id=<?= $usuario['id']; ?>"><i class="uil uil-trash-alt"></i></a>
                </td>
                <td><a href="index.php?action=verPrestamosUsuario&id=<?= $usuario['id']; ?>">Lista de Préstamos</a></td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="8">No se encontraron usuarios.</td>
        </tr>
    <?php endif; ?>
</tbody>

                </table>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class=" modal-dialog" role="document">
            <div class="o-modal__green modal-content">
                <div class="o-modal__header modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="o-modal__body modal-body">
                    <form method="POST" action="index.php?action=registrarDesdeAdmin" class="form-horizontal form-material">
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
                                                    <input type="email" name="email" class="o-input__form" placeholder="Email">
                                                    <i class="o-input__icon uil uil-at"></i>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="password" name="password" class="o-input__form" placeholder="Password">
                                                    <i class="o-input__icon uil uil-lock-alt"></i>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <select name="poblacion" class="four-boot-select" title="Poblacion" id="">
                                                        <option value="Alcazar">Alcázar de San Juan</option>
                                                        <option value="Argamasilla">Argamasilla de Alba</option>
                                                        <option value="Criptana">Campo de Criptana</option>
                                                        <option value="Herencia">Herencia</option>
                                                        <option value="Socuellamos">Socuellamos</option>
                                                        <option value="Tomelloso">Tomelloso</option>
                                                    </select>
                                                    <i class="o-input__icon uil uil-building"></i>
                                                </div>
                                                <div class="form-group mt-2">
                                                <select name="rol"  class="four-boot-select" title="Rol" id="">
                                    <option value="user">Usuario</option>
                                    <option value="admin">Admin</option>
                                    <option value="Super-admin">Super Admin</option>
                                </select>
                                                    <i class="o-input__icon uil uil-bag"></i>
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
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="o-modal__green  modal-content">
                <div class="o-modal__header modal-header">
                    <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditarUsuario" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="editUsuarioId" name="id">
                        <div class="form-group">
                            <label class="pt-2" for="editUsuarioNombre">Nombre</label>
                            <input type="text" class="form-control o-input__form " id="editUsuarioNombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label class="pt-2" for="editUsuarioApellidos">Apellidos</label>
                            <input type="text" class="form-control o-input__form" id="editUsuarioApellidos" name="apellidos" required>
                        </div>
                        <div class="form-group">
                            <label class="pt-2" for="editUsuarioEmail">Email</label>
                            <input type="email" class="form-control o-input__form" id="editUsuarioEmail" name="email" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="pt-2" for="editUsuarioPoblacion">Población</label>
                            <select name="poblacion" class="four-boot-select" title="Poblacion" id="editUsuarioPoblacion">
                                                        <option value="Alcazar">Alcázar de San Juan</option>
                                                        <option value="Argamasilla">Argamasilla de Alba</option>
                                                        <option value="Criptana">Campo de Criptana</option>
                                                        <option value="Herencia">Herencia</option>
                                                        <option value="Socuellamos">Socuellamos</option>
                                                        <option value="Tomelloso">Tomelloso</option>
                                                    </select>
                        </div>
                        <div class="form-group">
                            <label class="pt-2" for="editUsuarioRol">Rol</label>
                            <select name="rol"  class="four-boot-select" title="Rol" id="editUsuarioRol">
                                    <option value="user">Usuario</option>
                                    <option value="admin">Admin</option>
                                    <option value="Super-admin">Super Admin</option>
                                </select>
                        </div>
                        <div class="form-group">
                            <label class="pt-2" for="editUsuarioFoto">Foto</label>
                            <input type="file" class="form-control o-input__form" id="editUsuarioFoto" name="foto">
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